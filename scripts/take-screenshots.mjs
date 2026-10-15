import { chromium } from 'playwright';
import sharp from 'sharp';
import fs from 'node:fs';
import os from 'node:os';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const projectRoot = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const screenshotsDir = path.join(projectRoot, 'screenshots');
const baseURL = process.env.SCREENSHOT_BASE_URL || 'http://127.0.0.1:8127';
const baseOrigin = new URL(baseURL).origin;
const viewport = { width: 1920, height: 870 };
const maxScreenshots = 12;
const credentials = {
  admin: {
    email: process.env.SCREENSHOT_ADMIN_EMAIL || 'admin@example.test',
    password: process.env.SCREENSHOT_PASSWORD || 'uji-lokal-123',
  },
  karyawan: {
    email: process.env.SCREENSHOT_KARYAWAN_EMAIL || 'karyawan@example.test',
    password: process.env.SCREENSHOT_PASSWORD || 'uji-lokal-123',
  },
};

const captures = [];
const temporaryPngs = [];
const uploadedFiles = [];
const temporaryDir = fs.mkdtempSync(path.join(os.tmpdir(), 'aldoni-screenshot-'));
const stateDir = path.join(temporaryDir, 'storage-state');
const dummyImagePath = path.join(temporaryDir, 'foto-karyawan-dummy.png');
const dummyAvatar = await sharp({
  create: {
    width: 160,
    height: 160,
    channels: 4,
    background: '#dbeafe',
  },
})
  .composite([{
    input: Buffer.from(
      '<svg width="160" height="160" xmlns="http://www.w3.org/2000/svg">' +
      '<circle cx="80" cy="58" r="30" fill="#2563eb"/>' +
      '<path d="M26 151c4-34 24-51 54-51s50 17 54 51" fill="#2563eb"/>' +
      '</svg>',
    ),
  }])
  .png()
  .toBuffer();

function clearOldScreenshotImages() {
  fs.mkdirSync(screenshotsDir, { recursive: true });
  for (const entry of fs.readdirSync(screenshotsDir, { withFileTypes: true })) {
    if (entry.isFile() && /^\d{2}-[a-z0-9-]+\.(?:png|webp)$/i.test(entry.name)) {
      fs.unlinkSync(path.join(screenshotsDir, entry.name));
    }
  }
}

async function configurePage(page) {
  await page.route('**/images/**', async route => {
    await route.fulfill({
      status: 200,
      contentType: 'image/png',
      headers: { 'cache-control': 'no-store' },
      body: dummyAvatar,
    });
  });
  await page.route('**/*', async route => {
    if (new URL(route.request().url()).origin !== baseOrigin) {
      await route.abort();
      return;
    }
    await route.continue();
  });
  page.on('pageerror', error => {
    console.error(`Browser script error: ${error.message}`);
  });
}

async function waitUntilReady(page) {
  await page.waitForLoadState('networkidle', { timeout: 30000 });
  await page.evaluate(async () => {
    if (document.fonts?.ready) await document.fonts.ready;
    await Promise.all(Array.from(document.images, image => {
      if (image.complete) return Promise.resolve();
      return new Promise(resolve => {
        image.addEventListener('load', resolve, { once: true });
        image.addEventListener('error', resolve, { once: true });
      });
    }));
  });
  await page.addStyleTag({
    content: `
      #debugbar, #phpdebugbar, .phpdebugbar, [data-debugbar] { display: none !important; }
      [class*="cookie-banner"], [id*="cookie-banner"], [class*="intercom"], [class*="drift"] { display: none !important; }
    `,
  });
  await page.waitForTimeout(1200);

  const status = await page.evaluate(() => {
    const text = document.body?.innerText?.trim() || '';
    return {
      title: document.title,
      text,
      height: Math.max(
        document.documentElement.scrollHeight,
        document.body?.scrollHeight || 0,
      ),
    };
  });
  if (!status.text || /Whoops!|Server Error|Page Expired|Not Found/i.test(status.text)) {
    throw new Error(`Halaman tidak siap atau menampilkan error: ${page.url()}`);
  }
  return status.height;
}

async function captureFeature(page, name, caption) {
  const pageHeight = await waitUntilReady(page);
  const segmentCount = Math.max(1, Math.ceil(pageHeight / viewport.height));
  if (captures.length + segmentCount > maxScreenshots) {
    throw new Error(
      `Batas ${maxScreenshots} screenshot terlampaui saat menangkap ${name}; ` +
      `halaman ini memerlukan ${segmentCount} viewport.`,
    );
  }

  const maxScroll = Math.max(0, pageHeight - viewport.height);
  for (let segment = 0; segment < segmentCount; segment += 1) {
    const scrollY = segment === segmentCount - 1
      ? maxScroll
      : Math.min(segment * viewport.height, maxScroll);
    await page.evaluate(y => window.scrollTo(0, y), scrollY);
    await page.waitForTimeout(250);

    const sequence = String(captures.length + 1).padStart(2, '0');
    const suffix = segmentCount > 1 ? `-bagian-${segment + 1}` : '';
    const file = `${sequence}-${name}${suffix}.webp`;
    const webpPath = path.join(screenshotsDir, file);
    const pngPath = webpPath.replace(/\.webp$/i, '.png');
    temporaryPngs.push(pngPath);

    await page.screenshot({ path: pngPath, fullPage: false, animations: 'disabled' });
    await sharp(pngPath).webp({ quality: 85 }).toFile(webpPath);
    const metadata = await sharp(webpPath).metadata();
    if (metadata.width !== viewport.width || metadata.height !== viewport.height) {
      throw new Error(`Ukuran screenshot tidak sesuai: ${file} (${metadata.width}x${metadata.height})`);
    }
    fs.unlinkSync(pngPath);
    temporaryPngs.pop();
    captures.push({
      file,
      caption: segmentCount > 1
        ? `${caption} (bagian ${segment + 1} dari ${segmentCount}).`
        : `${caption}.`,
    });
    console.log(`Saved ${file}`);
  }
}

async function openPage(page, route) {
  const response = await page.goto(new URL(route, baseURL).href, {
    waitUntil: 'networkidle',
    timeout: 30000,
  });
  if (!response || response.status() >= 400) {
    throw new Error(`Route ${route} merespons ${response?.status() ?? 'tanpa response'}`);
  }
  await waitUntilReady(page);
}

async function loginAndSaveState(browser, role) {
  const context = await browser.newContext({ viewport, deviceScaleFactor: 1 });
  const page = await context.newPage();
  await configurePage(page);
  await openPage(page, '/login');
  await page.locator('input[name="email"]').fill(credentials[role].email);
  await page.locator('input[name="password"]').fill(credentials[role].password);
  await Promise.all([
    page.waitForURL(url => url.pathname.startsWith('/dashboard'), { timeout: 15000 }),
    page.locator('form button[type="submit"]').click(),
  ]);
  await waitUntilReady(page);
  const statePath = path.join(stateDir, `${role}.json`);
  await context.storageState({ path: statePath });
  await context.close();

  const savedContext = await browser.newContext({
    viewport,
    deviceScaleFactor: 1,
    storageState: statePath,
  });
  const savedPage = await savedContext.newPage();
  await configurePage(savedPage);
  return { context: savedContext, page: savedPage };
}

async function saveSummary() {
  const summary = {
    slug: 'aldoni',
    title: 'Aplikasi Data Karyawan',
    category: 'Kepegawaian',
    shortDescription: 'Aplikasi pengelolaan karyawan, absensi, dan pengajuan cuti dengan akses admin dan karyawan.',
    tags: ['Laravel', 'PHP', 'MySQL'],
    about: 'Aplikasi Data Karyawan membantu admin dan karyawan mengelola administrasi SDM, absensi, serta pengajuan cuti. Aplikasi dibangun dengan Laravel 10 dan antarmuka Argon Dashboard; akses fitur dibedakan menjadi role admin dan karyawan.',
    features: [
      'Dashboard ringkas untuk admin dan karyawan.',
      'Pengelolaan akun dengan role admin dan karyawan.',
      'Pengelolaan data karyawan, divisi, jabatan, dan jenis cuti.',
      'Pencatatan absensi harian karyawan.',
      'Pengajuan cuti serta alur persetujuan admin.',
      'Unggah foto pada data karyawan.',
    ],
    technologies: [
      'Laravel 10',
      'PHP 8.1+',
      'MySQL (default konfigurasi)',
      'SQLite (basis data demo screenshot)',
      'Argon Dashboard 2.0.4',
      'Bootstrap 5',
      'Chart.js',
      'SweetAlert2',
      'Laravel Sanctum',
      'Vite',
    ],
    liveUrl: null,
    repoUrl: null,
    screenshots: captures,
  };
  fs.writeFileSync(
    path.join(screenshotsDir, 'project-summary.json'),
    `${JSON.stringify(summary, null, 2)}\n`,
    'utf8',
  );
}

async function main() {
  fs.mkdirSync(stateDir, { recursive: true });
  fs.writeFileSync(dummyImagePath, await sharp(dummyAvatar).png().toBuffer());
  clearOldScreenshotImages();

  const browser = await chromium.launch({ headless: true });
  let admin;
  let karyawan;
  try {
    admin = await loginAndSaveState(browser, 'admin');
    const adminPage = admin.page;

    await openPage(adminPage, '/dashboard');
    await captureFeature(adminPage, 'dashboard-admin', 'Dashboard admin dengan ringkasan dan aktivitas karyawan');

    await openPage(adminPage, '/users');
    await captureFeature(adminPage, 'manajemen-pengguna', 'Daftar akun pengguna beserta role akses');

    await openPage(adminPage, '/karyawan');
    await captureFeature(adminPage, 'data-karyawan', 'Data karyawan dengan identitas dan penempatan kerja');
    await adminPage.locator('tbody tr').first().locator('a[href*="/edit"]').first().click();
    await adminPage.waitForURL(/\/karyawan\/\d+\/edit$/);
    await waitUntilReady(adminPage);
    await adminPage.locator('input[name="name"]').fill('Raka Pratama');
    await adminPage.locator('input[name="nik"]').fill('3273009000000001');
    await adminPage.locator('input[name="tgl_masuk"]').fill('2023-04-17');
    await adminPage.locator('input[name="foto"]').setInputFiles(dummyImagePath);
    await adminPage.waitForFunction(() => {
      const preview = document.querySelector('#imagePreview');
      return preview && preview.complete && preview.naturalWidth > 0;
    });
    await captureFeature(adminPage, 'form-edit-foto-karyawan', 'Form edit karyawan terisi dengan foto dummy terpilih');

    const publicImages = path.join(projectRoot, 'public', 'images');
    const filesBeforeUpload = new Set(fs.readdirSync(publicImages));
    while (fs.existsSync(path.join(publicImages, `${Math.floor(Date.now() / 1000)}.png`))) {
      await new Promise(resolve => setTimeout(resolve, 250));
    }
    await Promise.all([
      adminPage.waitForURL(url => url.pathname === '/karyawan', { timeout: 20000 }),
      adminPage.locator('form button[type="submit"]').click(),
    ]);
    await waitUntilReady(adminPage);
    const uploadedImageSource = await adminPage.locator('tbody tr').first().locator('img').first().getAttribute('src');
    const uploadedImageName = path.basename(new URL(uploadedImageSource, baseURL).pathname);
    const uploadedImagePath = path.join(publicImages, uploadedImageName);
    if (filesBeforeUpload.has(uploadedImageName) || !fs.existsSync(uploadedImagePath)) {
      throw new Error('Foto hasil unggah tidak ditemukan sebagai file baru di public/images.');
    }
    uploadedFiles.push(uploadedImagePath);
    await captureFeature(adminPage, 'foto-karyawan-berhasil-diunggah', 'Foto dummy berhasil disimpan pada data karyawan');

    await openPage(adminPage, '/absensi');
    await captureFeature(adminPage, 'rekap-absensi', 'Daftar absensi karyawan dengan status kehadiran');

    await openPage(adminPage, '/cuti');
    await adminPage.locator('tbody tr button').first().click();
    await adminPage.locator('.swal2-popup').waitFor({ state: 'visible', timeout: 10000 });
    await captureFeature(adminPage, 'konfirmasi-persetujuan-cuti', 'Konfirmasi admin sebelum menyetujui pengajuan cuti');

    karyawan = await loginAndSaveState(browser, 'karyawan');
    const employeePage = karyawan.page;
    await openPage(employeePage, '/dashboard');
    await captureFeature(employeePage, 'dashboard-karyawan', 'Dashboard karyawan dengan ringkasan data pribadi');

    await openPage(employeePage, '/absen_karyawan');
    await employeePage.getByRole('button', { name: 'Absen Sekarang' }).click();
    await employeePage.waitForLoadState('networkidle');
    await waitUntilReady(employeePage);
    if (!(await employeePage.getByText('Anda telah absen hari ini').count())) {
      throw new Error('Pencatatan absensi dummy tidak menampilkan status berhasil.');
    }
    await captureFeature(employeePage, 'absensi-harian-berhasil', 'Status absensi harian setelah karyawan mencatat kehadiran');

    await openPage(employeePage, '/pengajuan_cuti');
    await employeePage.getByRole('button', { name: /Buat Pengajuan Cuti Baru/ }).click();
    await employeePage.evaluate(() => {
      const modal = document.getElementById('cutiModal');
      if (window.bootstrap?.Modal) {
        window.bootstrap.Modal.getOrCreateInstance(modal).show();
      } else {
        modal.classList.add('show');
        modal.style.display = 'block';
        document.body.classList.add('modal-open');
      }
    });
    await employeePage.locator('#cutiModal').waitFor({ state: 'visible' });
    const startDate = new Date();
    startDate.setDate(startDate.getDate() + 14);
    const endDate = new Date(startDate);
    endDate.setDate(endDate.getDate() + 2);
    const toInputDate = date => [
      date.getFullYear(),
      String(date.getMonth() + 1).padStart(2, '0'),
      String(date.getDate()).padStart(2, '0'),
    ].join('-');
    await employeePage.locator('#cutiModal input[name="tgl_mulai"]').fill(toInputDate(startDate));
    await employeePage.locator('#cutiModal input[name="tgl_selesai"]').fill(toInputDate(endDate));
    await employeePage.locator('#cutiModal select[name="jenis_cuti"]').selectOption({ index: 1 });
    await employeePage.locator('#cutiModal textarea[name="alasan"]').fill('Keperluan keluarga (data contoh)');
    await captureFeature(employeePage, 'form-pengajuan-cuti', 'Form pengajuan cuti karyawan terisi dengan data contoh');
    await Promise.all([
      employeePage.waitForLoadState('networkidle'),
      employeePage.locator('#cutiModal button[type="submit"]').click(),
    ]);
    await waitUntilReady(employeePage);
    if (!(await employeePage.getByText('Pengajuan cuti berhasil diajukan').count())) {
      throw new Error('Pengajuan cuti dummy tidak menampilkan status berhasil.');
    }
    await captureFeature(employeePage, 'pengajuan-cuti-berhasil', 'Riwayat pengajuan cuti setelah formulir berhasil dikirim');

    const guestContext = await browser.newContext({ viewport, deviceScaleFactor: 1 });
    const guestPage = await guestContext.newPage();
    await configurePage(guestPage);
    await openPage(guestPage, '/login');
    await guestPage.addStyleTag({
      content: '.col-6.d-lg-flex.position-absolute { display: none !important; }',
    });
    await captureFeature(guestPage, 'login', 'Form login aplikasi untuk autentikasi pengguna');
    await guestContext.close();

    await saveSummary();
    console.log(`Selesai: ${captures.length} screenshot WebP dan project-summary.json.`);
  } finally {
    if (admin) await admin.context.close();
    if (karyawan) await karyawan.context.close();
    await browser.close();
    for (const file of [...uploadedFiles, ...temporaryPngs]) {
      if (fs.existsSync(file)) fs.unlinkSync(file);
    }
    fs.rmSync(temporaryDir, { recursive: true, force: true });
  }
}

main().catch(error => {
  console.error(error);
  process.exitCode = 1;
});
