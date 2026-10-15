<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

$projectRoot = dirname(__DIR__, 2);
require $projectRoot . '/vendor/autoload.php';
$app = require $projectRoot . '/bootstrap/app.php';
$app->make(ConsoleKernel::class)->bootstrap();

if (DB::connection()->getDriverName() !== 'sqlite') {
    throw new RuntimeException('Seeder screenshot hanya boleh berjalan pada SQLite dummy.');
}

if (DB::table('users')->exists()) {
    throw new RuntimeException('Basis data SQLite dummy tidak kosong; seeder tidak mengubah data yang sudah ada.');
}

$now = now();
$password = Hash::make('uji-lokal-123');
$adminId = DB::table('users')->insertGetId([
    'name' => 'Admin Contoh',
    'email' => 'admin@example.test',
    'password' => $password,
    'role' => 'admin',
    'email_verified_at' => $now,
    'created_at' => $now,
    'updated_at' => $now,
]);

$divisi = [];
foreach (['Operasional', 'Teknologi Informasi', 'Keuangan', 'Sumber Daya Manusia'] as $name) {
    $divisi[] = DB::table('divisi')->insertGetId(['nama_divisi' => $name]);
}

$jabatan = [];
foreach (['Koordinator', 'Analis', 'Staf Administrasi', 'Teknisi'] as $name) {
    $jabatan[] = DB::table('jabatan')->insertGetId(['nama_jabatan' => $name]);
}

$jenisCuti = [];
foreach (['Cuti Tahunan', 'Cuti Sakit', 'Cuti Keluarga', 'Cuti Khusus'] as $name) {
    $jenisCuti[] = DB::table('jenis_cuti')->insertGetId(['nama_cuti' => $name]);
}

$employees = [
    ['Raka Pratama', 'karyawan@example.test'],
    ['Nadia Puspita', 'nadia@example.test'],
    ['Bima Saputra', 'bima@example.test'],
    ['Sari Wulandari', 'sari@example.test'],
    ['Dimas Haryanto', 'dimas@example.test'],
    ['Larasati Putri', 'larasati@example.test'],
    ['Fajar Nugroho', 'fajar@example.test'],
    ['Intan Permata', 'intan@example.test'],
];
$employeeIds = [];

foreach ($employees as $index => [$name, $email]) {
    $userId = DB::table('users')->insertGetId([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'role' => 'karyawan',
        'email_verified_at' => $now,
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    $employeeIds[] = DB::table('karyawan')->insertGetId([
        'karyawan_users' => $userId,
        'jabatan_id' => $jabatan[$index % count($jabatan)],
        'divisi_id' => $divisi[$index % count($divisi)],
        'nik' => 3273009000000001 + $index,
        'tgl_masuk' => date('Y-m-d', strtotime('-' . (12 + $index) . ' months')),
        'foto' => '',
    ]);
}

foreach ($employeeIds as $index => $employeeId) {
    $dayOffset = match ($index) {
        1, 2, 3 => 0,
        default => $index + 1,
    };
    DB::table('absensi')->insert([
        'karyawan_id' => $employeeId,
        'tgl_absen' => date('Y-m-d', strtotime("-{$dayOffset} days")),
        'status' => ['hadir', 'hadir', 'izin', 'sakit'][$index % 4],
    ]);
}

$statuses = ['menunggu', 'disetujui', 'ditolak', 'menunggu', 'disetujui', 'menunggu', 'ditolak', 'disetujui'];
$reasons = [
    'Keperluan keluarga (contoh)',
    'Pemulihan kesehatan (contoh)',
    'Agenda pribadi (contoh)',
    'Urusan keluarga (contoh)',
    'Kegiatan pendidikan (contoh)',
    'Keperluan administrasi (contoh)',
    'Istirahat kesehatan (contoh)',
    'Agenda keluarga (contoh)',
];

foreach ($employeeIds as $index => $employeeId) {
    $startOffset = 5 + ($index * 2);
    DB::table('cuti')->insert([
        'karyawan_id' => $employeeId,
        'jenis_cuti' => $jenisCuti[$index % count($jenisCuti)],
        'tgl_mulai' => date('Y-m-d', strtotime("+{$startOffset} days")),
        'tgl_selesai' => date('Y-m-d', strtotime('+' . ($startOffset + 2) . ' days')),
        'status' => $statuses[$index],
        'alasan' => $reasons[$index],
    ]);
}

printf(
    "Dummy SQLite siap: %d akun (admin ID %d), %d karyawan, %d absensi, %d pengajuan cuti.\n",
    DB::table('users')->count(),
    $adminId,
    DB::table('karyawan')->count(),
    DB::table('absensi')->count(),
    DB::table('cuti')->count(),
);
