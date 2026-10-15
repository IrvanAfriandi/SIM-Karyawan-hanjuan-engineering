-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 05:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hanjuan_karyawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `tgl_absen` date NOT NULL,
  `status` enum('hadir','izin','sakit') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `karyawan_id`, `tgl_absen`, `status`) VALUES
(1, 5, '2025-03-12', 'hadir'),
(6, 5, '2025-03-05', 'hadir'),
(7, 8, '2025-03-11', 'izin'),
(8, 7, '2025-03-12', 'hadir');

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id_cuti` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_cuti` bigint(20) UNSIGNED DEFAULT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') NOT NULL DEFAULT 'menunggu',
  `alasan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id_cuti`, `karyawan_id`, `jenis_cuti`, `tgl_mulai`, `tgl_selesai`, `status`, `alasan`) VALUES
(1, 5, 1, '2025-03-04', '2025-03-25', 'disetujui', 'darurat'),
(2, 5, 1, '2025-03-21', '2025-03-17', 'ditolak', 'aaa'),
(3, 5, 2, '2025-03-04', '2025-03-25', 'ditolak', 'darurat'),
(4, 5, 2, '2025-03-06', '2025-03-27', 'ditolak', 'saksaksk'),
(5, 8, 7, '2025-03-12', '2025-03-26', 'menunggu', 'Tugas Besar'),
(6, 5, 2, '2025-03-07', '2025-03-27', 'menunggu', 'Kucing saya melahirkan'),
(7, 7, 6, '2025-02-26', '2025-04-02', 'menunggu', 'Saya nikah'),
(8, 5, 5, '2025-03-28', '2025-03-26', 'menunggu', 'Kaki saya sakit');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` bigint(20) UNSIGNED NOT NULL,
  `nama_divisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
(1, 'Engineering & Teknologi'),
(2, 'Produksi & Manufaktur'),
(4, 'Maintenance & Operasional'),
(5, 'Sumber Daya Manusia'),
(6, 'Keuangan & Akuntansi'),
(7, 'Pemasaran & Penjualan'),
(8, 'Riset & Pengembangan'),
(9, 'Pengadaan & Logistik'),
(10, 'Keselamatan & Kesehatan Kerja'),
(11, 'Teknologi Informasi'),
(12, 'Hukum & Kepatuhan'),
(13, 'Layanan Pelanggan & Administrasi');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` bigint(20) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Manajer Operasional'),
(2, 'Manajer Keuangan'),
(4, 'Manajer Teknik & Produksi'),
(5, 'Teknisi Mesin'),
(6, 'Teknisi Elektrik'),
(7, 'Staf Administrasi'),
(8, 'Staf IT Support'),
(9, 'Resepsionis');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_cuti`
--

CREATE TABLE `jenis_cuti` (
  `id_jenis_cuti` bigint(20) UNSIGNED NOT NULL,
  `nama_cuti` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_cuti`
--

INSERT INTO `jenis_cuti` (`id_jenis_cuti`, `nama_cuti`) VALUES
(1, 'Cuti Tahun Baru'),
(2, 'Cuti Melahirkan'),
(4, 'Cuti Tahunan'),
(5, 'Cuti Sakit'),
(6, 'Cuti Pernikahan'),
(7, 'Cuti Tugas Khusus');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` bigint(20) UNSIGNED NOT NULL,
  `karyawan_users` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `divisi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nik` bigint(20) DEFAULT NULL,
  `tgl_masuk` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `karyawan_users`, `jabatan_id`, `divisi_id`, `nik`, `tgl_masuk`, `foto`) VALUES
(5, 2, 1, 1, 3313451363578, '2025-03-02', '1741733871.jpg'),
(7, 7, 8, 10, 33132314135, '2025-03-06', NULL),
(8, 8, 6, 9, 24151, '2025-03-06', NULL),
(9, 9, 4, 5, 315426, '2025-03-06', NULL),
(10, 10, 7, 2, 315351, '2025-03-06', NULL),
(11, 11, 9, 8, 135135, '2025-03-06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2025_02_28_192938_create_jabatan_table', 1),
(4, '2025_02_28_192956_create_divisi_table', 1),
(5, '2025_02_28_193016_create_karyawan_table', 1),
(6, '2025_02_28_193030_create_jenis_cuti_table', 1),
(7, '2025_02_28_193031_create_cuti_table', 1),
(8, '2025_02_28_193039_create_absensi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','karyawan') NOT NULL DEFAULT 'karyawan',
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Aldoni', 'admin123@gmail.com', 'admin', '$2y$10$rtp6ELmMyberfwkNq7485ub24f5K.Vzk8TGk20ZuWiyEkQn2v7ISa', NULL, '2025-03-01 03:39:17', '2025-03-01 03:39:17'),
(2, 'Aldini', 'karyawan1@gmail.com', 'karyawan', '$2y$10$rtp6ELmMyberfwkNq7485ub24f5K.Vzk8TGk20ZuWiyEkQn2v7ISa', NULL, NULL, '2025-03-11 15:57:33'),
(3, 'Narji Cihuy', 'narjiuhuy123@gmail.com', 'karyawan', '$2y$10$po4NU9ZrlCEhF.UF4/BQKumjQ.90.fIyRy3hh3ZWSZ0UPZ7BqLfZe', NULL, '2025-03-01 20:52:04', '2025-03-02 02:15:57'),
(5, 'Sukini', 'sukinidisini123@gmail.com', 'admin', '$2y$10$eVV4XhoDJDcqbFArwchAreb3MwoH2CXjHbU2ZVeadPZLYYokof0De', NULL, '2025-03-02 02:09:26', '2025-03-02 02:15:13'),
(6, 'Susi', 'susisus234@gmail.com', 'karyawan', '$2y$10$AESQFij1823Qm4FvjUTNB.YPQJNko9BIg6CbYbSivo3zIks3ayKzK', NULL, '2025-03-02 07:32:33', '2025-03-02 07:32:33'),
(7, 'azril', 'azrilgege123@gmail.com', 'karyawan', '$2y$10$US6TKokzlaVTbLU4xKapLuwu8/uZcsIY.XBFfqaOPhqpADr9OE3Y2', NULL, '2025-03-05 20:10:22', '2025-03-05 20:10:22'),
(8, 'Windah', 'narjiauhuy123@gmail.com', 'karyawan', '$2y$10$o67tDTgeuXpCdvZeJPt2cufyp/6AFAoKbKFSKDSCxbcGkw3Ka3IcO', NULL, '2025-03-05 20:12:56', '2025-03-05 20:12:56'),
(9, 'nardia', 'ppk-003@gmail.com', 'karyawan', '$2y$10$Wse8BDLaS4QwGu22d1D7XeCqX9cM678aAsqhPyi62XNG/a1Zsvg9a', NULL, '2025-03-05 20:14:07', '2025-03-05 20:14:07'),
(10, 'suteji', 'ppk-00111@gmail.com', 'karyawan', '$2y$10$zNxF4cFSn4TuZeC1E2PUIePWDcsPhqcmvQZPXTIUs08Fy5MrpG4.q', NULL, '2025-03-05 20:18:02', '2025-03-05 20:18:02'),
(11, 'Narji', 'narjiuhAAuy123@gmail.com', 'karyawan', '$2y$10$EgIIQF4xA2G2I3aJLv4p6Om05zqf4U/KTyzdd.TnTefhPJB8wr.nS', NULL, '2025-03-05 20:19:57', '2025-03-05 20:19:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `absensi_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `cuti_karyawan_id_foreign` (`karyawan_id`),
  ADD KEY `cuti_jenis_cuti_foreign` (`jenis_cuti`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `jenis_cuti`
--
ALTER TABLE `jenis_cuti`
  ADD PRIMARY KEY (`id_jenis_cuti`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `karyawan_karyawan_users_foreign` (`karyawan_users`),
  ADD KEY `karyawan_jabatan_id_foreign` (`jabatan_id`),
  ADD KEY `karyawan_divisi_id_foreign` (`divisi_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jenis_cuti`
--
ALTER TABLE `jenis_cuti`
  MODIFY `id_jenis_cuti` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_jenis_cuti_foreign` FOREIGN KEY (`jenis_cuti`) REFERENCES `jenis_cuti` (`id_jenis_cuti`) ON DELETE SET NULL,
  ADD CONSTRAINT `cuti_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id_divisi`) ON DELETE SET NULL,
  ADD CONSTRAINT `karyawan_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE SET NULL,
  ADD CONSTRAINT `karyawan_karyawan_users_foreign` FOREIGN KEY (`karyawan_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
