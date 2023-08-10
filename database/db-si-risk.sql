-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 10 Agu 2023 pada 18.47
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db-si-risk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_dampak`
--

CREATE TABLE `daftar_dampak` (
  `peringkat` int(10) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_dampak`
--

INSERT INTO `daftar_dampak` (`peringkat`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Dapat Diabaikan', '2023-08-07 18:59:41', NULL),
(2, 'Sedikit', '2023-08-07 19:00:30', NULL),
(3, 'Sedang', '2023-08-07 19:00:36', NULL),
(4, 'Tinggi', '2023-08-07 19:00:48', NULL),
(5, 'Sangat Tinggi', '2023-08-07 19:00:55', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_isu`
--

CREATE TABLE `daftar_isu` (
  `id` int(11) NOT NULL,
  `no_isu` varchar(100) NOT NULL,
  `uraian_isu` text NOT NULL,
  `dept_penerbit` int(100) NOT NULL,
  `sumber` varchar(50) NOT NULL,
  `tgl_target` timestamp NULL DEFAULT NULL,
  `kemungkinan` int(10) NOT NULL,
  `dampak` int(10) NOT NULL,
  `ket_dampak` varchar(100) NOT NULL DEFAULT 'Positif',
  `bobot` int(10) NOT NULL,
  `terhadap` varchar(10) NOT NULL DEFAULT 'Lain-lain',
  `url_lampiran_isu` text NOT NULL DEFAULT '-',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_isu`
--

INSERT INTO `daftar_isu` (`id`, `no_isu`, `uraian_isu`, `dept_penerbit`, `sumber`, `tgl_target`, `kemungkinan`, `dampak`, `ket_dampak`, `bobot`, `terhadap`, `url_lampiran_isu`, `created_at`, `updated_at`) VALUES
(4, '3/RM/MCP/09/08/23', 'Pada riset sebelumnya ditemukan bug pada pipeline. lakukan perbaikan secepatnya', 16, 'Internal', '2023-08-12 17:00:00', 4, 4, 'Positif', 16, 'Q', '3RMMCP090823.pdf', '2023-08-09 08:23:02', NULL),
(5, '4/RM/MCP/09/08/23', 'Efisiensi anggaran', 2, 'Internal', '2023-08-11 17:00:00', 3, 4, 'Positif', 12, 'C', '4RMMCP090823.pdf', '2023-08-09 09:53:11', '2023-08-10 08:57:24'),
(6, '1/RM/MCP/10/08/23', 'Sortir tidak terlalu ketat, terdapat barang cacat dan komplain', 17, 'Internal', '2023-08-11 17:00:00', 3, 4, 'Positif', 12, 'Q', '1RMMCP100823.pdf', '2023-08-10 04:57:23', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_kemungkinan`
--

CREATE TABLE `daftar_kemungkinan` (
  `peringkat` int(10) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `frekuensi` text NOT NULL,
  `kemungkinan_terjadi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_kemungkinan`
--

INSERT INTO `daftar_kemungkinan` (`peringkat`, `deskripsi`, `keterangan`, `frekuensi`, `kemungkinan_terjadi`, `created_at`, `updated_at`) VALUES
(1, 'Jarang', 'Belum pernah terjadi sebelumnya dan tidak ada alasan untuk berpikir lebih mungkin terjadi sekarang.', 'Hampir tidak pernah', '< 5 %', '2023-08-07 18:15:18', NULL),
(2, 'Kemungkinan Kecil', 'Ada kemungkinan bahwa hal itu bisa terjadi, tapi mungkin tidak akan segera.', '1 - 2 kali per bulan', '5% - 10%', '2023-08-07 18:28:17', '2023-08-08 09:27:18'),
(3, 'Menengah', 'Pada keseimbangan, risiko/peluangnya lebih mungkin terjadi daripada tidak.', '3 - 4 kali per bulan', '10% - 25%', '2023-08-08 09:25:30', '2023-08-08 09:27:14'),
(4, 'Kemungkinan Besar', 'Ini akan menjadi kejutan jika risiko/peluang tidak terjadi, baik berdasarkan frekuensi masa lalu atau keadaan saat ini.', '6 - 10 kali per bulan', '25% - 50%', '2023-08-08 09:26:14', '2023-08-08 09:27:06'),
(5, 'Hampir Pasti', 'Sudah terjadi secara teratur, atau ada beberapa alasan untuk percaya itu pasti terjadi.', '> 10 kali per bulan', '50% - 100%', '2023-08-08 09:27:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_tindakan`
--

CREATE TABLE `daftar_tindakan` (
  `id` int(11) NOT NULL,
  `no_tindakan` varchar(100) NOT NULL,
  `no_isu` varchar(100) NOT NULL,
  `dept_penerima` int(10) NOT NULL,
  `uraian_tindakan` text NOT NULL,
  `tgl_target` timestamp NULL DEFAULT NULL,
  `tgl_aktual` timestamp NULL DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT 201,
  `url_lampiran_tindakan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_tindakan`
--

INSERT INTO `daftar_tindakan` (`id`, `no_tindakan`, `no_isu`, `dept_penerima`, `uraian_tindakan`, `tgl_target`, `tgl_aktual`, `status`, `url_lampiran_tindakan`, `created_at`, `updated_at`) VALUES
(7, '3/RM/MCP/09/08/23-1', '3/RM/MCP/09/08/23', 17, '', '2023-08-12 17:00:00', NULL, 202, NULL, '2023-08-09 08:23:02', NULL),
(8, '3/RM/MCP/09/08/23-2', '3/RM/MCP/09/08/23', 21, '', '2023-08-12 17:00:00', NULL, 202, NULL, '2023-08-09 08:23:02', NULL),
(9, '3/RM/MCP/09/08/23-3', '3/RM/MCP/09/08/23', 25, '', '2023-08-12 17:00:00', NULL, 202, NULL, '2023-08-09 08:23:02', NULL),
(10, '4/RM/MCP/09/08/23-1', '4/RM/MCP/09/08/23', 28, 'Mengurangi riset', '2023-08-11 17:00:00', '2023-08-09 09:54:47', 200, '4RMMCP090823-1.pdf', '2023-08-09 09:55:49', '2023-08-10 08:57:24'),
(11, '4/RM/MCP/09/08/23-2', '4/RM/MCP/09/08/23', 30, 'PPC telah mengurangi anggaran', '2023-08-11 17:00:00', '2023-08-10 04:22:29', 200, '4RMMCP090823-2.pdf', '2023-08-10 04:34:57', '2023-08-10 08:57:24'),
(12, '4/RM/MCP/09/08/23-3', '4/RM/MCP/09/08/23', 29, '', '2023-08-11 17:00:00', NULL, 202, NULL, '2023-08-09 09:53:11', '2023-08-10 08:57:24'),
(13, '1/RM/MCP/10/08/23-1', '1/RM/MCP/10/08/23', 16, '', '2023-08-11 17:00:00', NULL, 202, NULL, '2023-08-10 04:57:23', NULL),
(14, '1/RM/MCP/10/08/23-2', '1/RM/MCP/10/08/23', 20, '', '2023-08-11 17:00:00', NULL, 202, NULL, '2023-08-10 04:57:23', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `meeting`
--

CREATE TABLE `meeting` (
  `id` int(11) NOT NULL,
  `agenda` text NOT NULL,
  `initiate_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `meeting_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 202,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meeting`
--

INSERT INTO `meeting` (`id`, `agenda`, `initiate_id`, `room_id`, `meeting_date`, `status`, `created_at`, `updated_at`) VALUES
(192673322, 'Uji coba ke 2', 1, 1, '2023-08-11 09:00:00', 200, '2023-08-10 14:45:28', '2023-08-10 15:14:02'),
(1362741428, 'Rapat CHM', 1, 1, '2023-08-14 10:20:00', 202, '2023-08-10 15:22:11', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `meeting_participant`
--

CREATE TABLE `meeting_participant` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meeting_participant`
--

INSERT INTO `meeting_participant` (`id`, `meeting_id`, `participant_id`, `created_at`, `updated_at`) VALUES
(4, 192673322, 27, '2023-08-10 14:45:28', '2023-08-10 15:14:02'),
(5, 192673322, 16, '2023-08-10 14:45:28', '2023-08-10 15:14:02'),
(6, 192673322, 17, '2023-08-10 14:45:28', '2023-08-10 15:14:02'),
(7, 1362741428, 27, '2023-08-10 15:22:11', NULL),
(8, 1362741428, 28, '2023-08-10 15:22:11', NULL),
(9, 1362741428, 29, '2023-08-10 15:22:11', NULL),
(10, 1362741428, 30, '2023-08-10 15:22:11', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `meeting_room`
--

CREATE TABLE `meeting_room` (
  `id` int(11) NOT NULL,
  `room` varchar(100) NOT NULL,
  `operational_hours` varchar(100) NOT NULL DEFAULT '08:00 WIB - 17:00 WIB',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meeting_room`
--

INSERT INTO `meeting_room` (`id`, `room`, `operational_hours`, `created_at`, `updated_at`) VALUES
(1, 'Ruang 1-1', '09:00 WIB - 12:00 WIB', '2023-08-10 10:59:13', '2023-08-10 11:02:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_tindakan`
--

CREATE TABLE `temp_tindakan` (
  `id` int(100) NOT NULL,
  `no_isu` varchar(100) NOT NULL,
  `dept_penerima_id` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(14) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `image` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `no_hp`, `alamat`, `image`, `password`, `role_id`) VALUES
(1, 'Admin 123', 'admin@gmail.com', '083811641671', 'GG.Kelor No.31', 'default.jpg', '$2y$10$3hJJNMOax31EfG6N6yrFX.URir4fZ3/jgTZJRa6FGp4MfPqU74VcO', 1),
(3, 'Akun MKT', 'mkt@gmail.com', '083811641671', 'Bogor, indonesia.', 'default.jpg', '$2y$10$Fu7715n0v8.lOS1xVehkfeZrHCRRlZ71eNCTA0GQZfgFLGLixNlNa', 2),
(9, 'Akun R&D', 'r&d@gmail.com', '083811641671', 'GG. NASEDIN, RT/RW 004/002, Kel/Desa CILENDEK BARAT, Kecamatan KOTA BOGOR BARAT', 'default.jpg', '$2y$10$uGHBGvfTnTrTkevKqDiFlufMjDb86ANqXbi3xJnemcdH1nGAUUOgq', 16),
(11, 'Akun PPC', 'ppc@gmail.com', '083811641671', NULL, 'default.jpg', '$2y$10$.kQSv8rmw5XqrbL4CVZ2oeP655PhnFVjpGvOpWs.xY6muQ9.C8KHO', 17),
(12, 'Akun PE', 'pe@gmail.com', '083811641671', NULL, 'default.jpg', '$2y$10$s.I2KG/Cklez4wGGwzHJ8.ygYb8LBTpGXm0lmjja1sjbwcz9DgULu', 18),
(13, 'Akun GA', 'ga@gmail.com', '083811641671', NULL, 'default.jpg', '$2y$10$kxSgLAzGbpWembLSWa8pJeOs882f4mFVg7pqUFqwttlxVjjZDk9ny', 33),
(14, 'Akun CHM-MKT', 'chm-mkt@gmail.com', '083811641671', NULL, 'default.jpg', '$2y$10$75u2JdBQV.VrKONT9JpOBekLep3X6GsAlBMaIsPK0ICKAK.o3K2Zq', 27);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(8, 1, 22),
(9, 6, 2),
(11, 6, 22),
(12, 6, 23),
(14, 1, 24),
(16, 1, 23),
(17, 1, 25),
(18, 2, 2),
(20, 1, 26),
(23, 3, 25),
(24, 3, 26),
(26, 2, 26),
(27, 1, 27),
(39, 1, 30),
(43, 3, 2),
(44, 3, 31),
(45, 4, 2),
(49, 3, 28),
(50, 4, 27),
(55, 1, 31),
(57, 2, 31),
(61, 1, 33),
(63, 1, 28),
(64, 1, 29),
(65, 2, 29),
(67, 2, 33),
(69, 16, 29),
(70, 16, 33),
(71, 16, 2),
(72, 17, 33),
(73, 17, 29),
(75, 17, 2),
(76, 19, 33),
(77, 19, 29),
(79, 19, 2),
(80, 20, 33),
(81, 20, 29),
(83, 20, 2),
(84, 21, 33),
(85, 21, 29),
(87, 21, 2),
(88, 22, 33),
(89, 22, 29),
(91, 22, 2),
(92, 23, 33),
(93, 23, 29),
(95, 23, 2),
(96, 24, 2),
(98, 24, 29),
(99, 24, 33),
(100, 25, 2),
(102, 25, 29),
(103, 25, 33),
(104, 26, 33),
(105, 26, 29),
(107, 26, 2),
(108, 27, 2),
(110, 27, 29),
(111, 27, 33),
(112, 28, 33),
(113, 28, 29),
(115, 28, 2),
(116, 29, 33),
(117, 29, 29),
(119, 29, 2),
(120, 30, 2),
(122, 30, 29),
(123, 30, 33),
(124, 31, 33),
(125, 31, 29),
(127, 31, 2),
(128, 32, 33),
(129, 32, 29),
(131, 32, 2),
(133, 1, 3),
(134, 18, 2),
(135, 18, 29),
(136, 18, 33),
(137, 33, 33),
(138, 33, 29),
(139, 33, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'menu'),
(28, 'klasifikasi'),
(29, 'isu'),
(33, 'opsi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'MKT'),
(16, 'R&D'),
(17, 'PPC'),
(18, 'PE'),
(19, 'GDG'),
(20, 'TS'),
(21, 'PCH'),
(22, 'HRD'),
(23, 'MTN'),
(24, 'ACC'),
(25, 'MIS'),
(26, 'MGT'),
(27, 'CHM-MKT'),
(28, 'CHM-R&D'),
(29, 'CHM-PE'),
(30, 'CHM-PPIC'),
(31, 'CHM-PRD'),
(32, 'CHM-QC'),
(33, 'GA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(5, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(6, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(11, 1, 'Department', 'admin', 'fas fa-fw fa-user-tie', 1),
(19, 24, 'Category Management', 'category', 'fas fa-fw fa-globe', 1),
(22, 25, 'My Vacancies', 'company', 'fas fa-fw fa-user-md', 1),
(23, 26, 'All Vacancies', 'Job', 'fas fa-fw fa-globe', 1),
(27, 27, 'Daftar Transaksi', 'transaksi', 'fas fa-fw fa-shopping-cart', 1),
(29, 29, 'Risk Management', 'isu', 'fas fa-fw fa-virus', 1),
(31, 33, 'Jadwalkan Meeting', 'opsi/meeting', 'fas fa-fw fa-camera', 1),
(32, 1, 'User List', 'admin/usermanagement', 'fas fa-fw fa-user-cog', 1),
(33, 28, 'Data Kemungkinan', 'klasifikasi/likelihood', 'fas fa-fw fa-crosshairs', 1),
(34, 28, 'Data Dampak', 'klasifikasi/impact', 'fas fa-fw fa-wave-square', 1),
(35, 29, 'Daftar Tindakan', 'isu/tindakan', 'fas fa-fw fa-tasks', 1),
(36, 1, 'Daftar Ruangan', 'opsi/meetingroom', 'fas fa-fw fa-door-open', 1),
(37, 33, 'Undangan Meeting', 'opsi/invitation', 'fas fa-fw fa-receipt', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_dampak`
--
ALTER TABLE `daftar_dampak`
  ADD PRIMARY KEY (`peringkat`);

--
-- Indeks untuk tabel `daftar_isu`
--
ALTER TABLE `daftar_isu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_isu` (`no_isu`) USING BTREE;

--
-- Indeks untuk tabel `daftar_kemungkinan`
--
ALTER TABLE `daftar_kemungkinan`
  ADD PRIMARY KEY (`peringkat`);

--
-- Indeks untuk tabel `daftar_tindakan`
--
ALTER TABLE `daftar_tindakan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_tindakan` (`no_tindakan`) USING BTREE,
  ADD KEY `no_isu` (`no_isu`);

--
-- Indeks untuk tabel `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `meeting_participant`
--
ALTER TABLE `meeting_participant`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `meeting_room`
--
ALTER TABLE `meeting_room`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temp_tindakan`
--
ALTER TABLE `temp_tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_isu`
--
ALTER TABLE `daftar_isu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `daftar_tindakan`
--
ALTER TABLE `daftar_tindakan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT untuk tabel `meeting_participant`
--
ALTER TABLE `meeting_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `meeting_room`
--
ALTER TABLE `meeting_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `temp_tindakan`
--
ALTER TABLE `temp_tindakan`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
