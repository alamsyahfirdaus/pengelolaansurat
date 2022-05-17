-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2022 at 03:40 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apk_pengelolaan_surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id_jenis_surat` int(11) NOT NULL,
  `jenis_surat` varchar(64) NOT NULL,
  `nomor_ke` int(11) NOT NULL DEFAULT 0,
  `format_nomor` varchar(64) DEFAULT NULL,
  `paragraf1` longtext DEFAULT NULL,
  `paragraf2` longtext DEFAULT NULL,
  `paragraf3` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_surat`
--

INSERT INTO `jenis_surat` (`id_jenis_surat`, `jenis_surat`, `nomor_ke`, `format_nomor`, `paragraf1`, `paragraf2`, `paragraf3`) VALUES
(1, 'Surat Keterangan Mahasiswa Aktif', 4, 'a/UMTAS-FKIP/A.2', 'Dekan Fakultas Keguruan dan Ilmu Pendidikan Universitas Muhammadiyah Tasikmalaya menerangkan bahwa:', 'adalah benar terdaftar sebagai mahasiswa aktif Program Sarjana Program Studi Pendidikan Teknologi Informasi Universitas Muhammadiyah Tasikmalaya.', 'Demikian surat pernyataan ini dibuat dengan sesungguhnya untuk dipergunakan sebagaimana mestinya.'),
(2, 'Surat Izin Penelitian', 2, 'b/UMTAS-FKIP/A.3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'),
(3, 'Surat Dipensasi', 2, 'c/UMTAS-FKIP/A.D', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'),
(4, 'Surat Izin Melakukan Kegiatan', 1, 'e/UMTAS-FKIP/F.3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

-- --------------------------------------------------------

--
-- Table structure for table `program_studi`
--

CREATE TABLE `program_studi` (
  `id_program_studi` int(11) NOT NULL,
  `program_studi` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program_studi`
--

INSERT INTO `program_studi` (`id_program_studi`, `program_studi`) VALUES
(1, 'Pendidikan Teknologi Informasi'),
(2, 'Bimbingan dan Konseling'),
(3, 'Pendidikan Guru Sekolah Dasar'),
(4, 'Pendidikan Guru Anak Usia Dini'),
(5, 'Pendidikan Seni Drama, Tari dan Musik');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `nim` varchar(128) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `program_studi_id` int(11) DEFAULT NULL,
  `tahun_masuk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `nim`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`, `program_studi_id`, `tahun_masuk`) VALUES
(1, 'Dzaki Muhammad', 'C1783207003', 'waffidzaki@gmail.com', 'Pas_Foto_3x4_dzaki-min.jpg', '$2y$10$pE2BCrUnAJFrpXWIAlOz/ui6LRZhXqUhThiKQwG6hB76y7X9uRx/S', 1, 1, 1631330283, NULL, NULL),
(2, 'Cynthia Fitri Madania', 'P20637017009', 'cynthia.f.madania@gmail.com', 'default.jpg', '$2y$10$EjKN/L6Yi/n5Gk0k9ClSQ.R/Lk.K8H.k06vQQx1BBTwTkC8figfV6', 2, 1, 1631330460, NULL, NULL),
(5, 'admin', '123', 'admin@admin.com', 'default.jpg', '$2y$10$/cUq5XyL/TQBTo.xY1BCZeU22NbUMd7LGnd24QoDfY/a9FfIOC5PG', 2, 1, 1636269059, NULL, NULL),
(6, 'Alamsyah Firdaus', 'C1783207002', 'alamsyah.firdaus.af31@gmail.com', 'Alamsyah_Latar_Merah.jpg', '$2y$10$2gcskIDCIDleDkbmHsiIIeB1.uoiGQfcftuEZ/SZ5cUhQ1NC2lVFy', 2, 1, 1636804490, 1, 2017),
(7, 'Admin', '31071998', 'alamsyahfirdaus@gmail.com', 'default-150x150.png', '$2y$10$wxN6WCExHFHBuc26Gx9u1evpV3x80Ede6.fxTQ5fkRvP2Xes/1rJW', 1, 1, 1636804490, NULL, NULL),
(8, 'Tes', '2121212121', 'tes@gmail.com', 'default.jpg', '$2y$10$MQ2nNvP8bgaYegN5hGnWvueZlB8Da8MOtYJk105mMlMCJCRmdnpSS', 2, 1, 1638679360, NULL, NULL),
(9, 'Tes', '121212121', 'tes1@gmail.com', 'default.jpg', '$2y$10$EqexYk1DVyxfSBzGYfx4pugqd8DbCFOZzNRjkg312XWhmEE8U4kqW', 2, 1, 1638679577, NULL, NULL),
(10, 'Tes', '1212121211', 'tes2@gmail.com', 'default.jpg', '$2y$10$7HF5C9U7xsSFwOpaokpk.Of0hBp/c7fWlB5W0ZgSTDVGS1L9me7.C', 2, 1, 1638679970, NULL, NULL),
(11, 'Tes', '1212121213', 'alamsyah.firdaus2.af31@gmail.com', 'default.jpg', '$2y$10$.SOxMM3RydUyHh2v/l3d1ejdsaJP2zayTtwQaZxNY7EIDubsZ7d9G', 2, 0, 1638680126, NULL, NULL),
(12, 'Alamsyah', '1212121212121', 'alamsyah.firdaus3.af31@gmail.com', 'default.jpg', '$2y$10$VxAoJvG7ouTfqbYKDf9QoOoL0uWt476iWZkAoVN9wX9HOebkB4hK2', 2, 1, 1638680433, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(6, 1, 11),
(3, 2, 2),
(4, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(11, 'Setting');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Mahasiswa');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin/index', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'Profil Saya', 'user/index', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit_profile', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Pengajuan Surat', 'user/pengajuan_surat', 'fas fa-fw fa-envelope-open-text', 1),
(5, 2, 'Ubah Password', 'user/ubah_password', 'fas fa-fw fa-unlock-alt', 1),
(13, 11, 'Jenis Surat', 'admin/jenissurat', 'fas fa-fw fa-envelope', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_surat`
--

CREATE TABLE `user_surat` (
  `id_surat` int(11) NOT NULL,
  `nomor_surat` varchar(64) NOT NULL,
  `tanggal` date DEFAULT current_timestamp(),
  `tahun` year(4) DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL COMMENT 'Id Mahasiswa',
  `smt_mhs` int(11) DEFAULT NULL COMMENT 'Semester Mahasiswa',
  `jenis_surat_id` int(11) NOT NULL,
  `status_surat` int(11) DEFAULT NULL COMMENT '1=disetujui, NULL=menunggu persetujuan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_surat`
--

INSERT INTO `user_surat` (`id_surat`, `nomor_surat`, `tanggal`, `tahun`, `user_id`, `smt_mhs`, `jenis_surat_id`, `status_surat`) VALUES
(10, '510.a/UMTAS-FKIP/A.2/XI/2021', NULL, NULL, 6, 3, 1, 1),
(17, '514.a/UMTAS-FKIP/A.2/XI/2021', NULL, NULL, 6, 2, 1, NULL),
(25, '1.a/UMTAS-FKIP/A.2/I/2022', '2022-01-06', 2022, 6, 4, 1, NULL),
(26, '2.a/UMTAS-FKIP/A.2/I/2022', '2022-01-06', 2022, 6, 1, 1, 1),
(29, '3.a/UMTAS-FKIP/A.2/I/2022', '2022-01-06', 2022, 6, 5, 1, NULL),
(30, '1.b/UMTAS-FKIP/A.3/I/2022', '2022-01-07', 2022, 6, 13, 2, 1),
(31, '2.b/UMTAS-FKIP/A.3/I/2022', '2022-01-07', 2022, 6, 13, 2, NULL),
(32, '1.c/UMTAS-FKIP/A.D/I/2022', '2022-01-07', 2022, 6, 14, 3, NULL),
(33, '2.c/UMTAS-FKIP/A.D/I/2022', '2022-01-07', 2022, 6, 5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(1, 'tes1@gmail.com', 'Pqs1tIcM/UdCIglPIQoLUq1iUQvK4CzSTs3iBkYRTYw=', 1638679577),
(2, 'tes2@gmail.com', 'Gs6d5tSBtZkEEKFFmyYuiG4OOFJtLLmgPg0GeQrckw8=', 1638679970);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id_jenis_surat`);

--
-- Indexes for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id_program_studi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `program_studi_id` (`program_studi_id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`,`menu_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `user_surat`
--
ALTER TABLE `user_surat`
  ADD PRIMARY KEY (`id_surat`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `jenis_surat_id` (`jenis_surat_id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id_jenis_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id_program_studi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_surat`
--
ALTER TABLE `user_surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`program_studi_id`) REFERENCES `program_studi` (`id_program_studi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_access_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `user_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD CONSTRAINT `user_sub_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `user_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_surat`
--
ALTER TABLE `user_surat`
  ADD CONSTRAINT `user_surat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_surat_ibfk_2` FOREIGN KEY (`jenis_surat_id`) REFERENCES `jenis_surat` (`id_jenis_surat`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
