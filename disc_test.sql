-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2026 at 12:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `disc_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$p3/5CUccmm09tYOS/IDEdO0H3DxrfjEeH/LK.DW4OCXlF8k0hDCZS', '2026-07-26 16:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int NOT NULL,
  `participant_id` int NOT NULL,
  `question_no` int NOT NULL,
  `most_position` tinyint NOT NULL,
  `least_position` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `participant_id`, `question_no`, `most_position`, `least_position`) VALUES
(1, 1, 1, 4, 2),
(2, 1, 2, 1, 3),
(3, 1, 3, 1, 2),
(4, 1, 4, 2, 3),
(5, 1, 5, 3, 1),
(6, 1, 6, 4, 3),
(7, 1, 7, 1, 2),
(8, 1, 8, 3, 1),
(9, 1, 9, 1, 3),
(10, 1, 10, 4, 2),
(11, 1, 11, 4, 3),
(12, 1, 12, 2, 4),
(13, 1, 13, 4, 3),
(14, 1, 14, 1, 4),
(15, 1, 15, 2, 3),
(16, 1, 16, 4, 3),
(17, 1, 17, 1, 4),
(18, 1, 18, 4, 1),
(19, 1, 19, 4, 1),
(20, 1, 20, 2, 1),
(21, 1, 21, 4, 2),
(22, 1, 22, 4, 1),
(23, 1, 23, 3, 1),
(24, 1, 24, 1, 4),
(25, 2, 1, 4, 2),
(26, 2, 2, 1, 3),
(27, 2, 3, 4, 2),
(28, 2, 4, 2, 4),
(29, 2, 5, 3, 2),
(30, 2, 6, 4, 2),
(31, 2, 7, 3, 2),
(32, 2, 8, 2, 3),
(33, 2, 9, 4, 1),
(34, 2, 10, 4, 3),
(35, 2, 11, 4, 2),
(36, 2, 12, 4, 2),
(37, 2, 13, 4, 2),
(38, 2, 14, 1, 4),
(39, 2, 15, 2, 1),
(40, 2, 16, 2, 1),
(41, 2, 17, 2, 4),
(42, 2, 18, 4, 3),
(43, 2, 19, 2, 1),
(44, 2, 20, 1, 2),
(45, 2, 21, 4, 2),
(46, 2, 22, 1, 4),
(47, 2, 23, 3, 4),
(48, 2, 24, 3, 1),
(49, 4, 1, 3, 1),
(50, 4, 2, 2, 3),
(51, 4, 3, 4, 3),
(52, 4, 4, 4, 1),
(53, 4, 5, 4, 1),
(54, 4, 6, 1, 2),
(55, 4, 7, 4, 2),
(56, 4, 8, 3, 2),
(57, 4, 9, 2, 3),
(58, 4, 10, 4, 1),
(59, 4, 11, 4, 1),
(60, 4, 12, 2, 4),
(61, 4, 13, 1, 2),
(62, 4, 14, 1, 2),
(63, 4, 15, 3, 4),
(64, 4, 16, 2, 3),
(65, 4, 17, 3, 2),
(66, 4, 18, 2, 4),
(67, 4, 19, 4, 3),
(68, 4, 20, 4, 1),
(69, 4, 21, 2, 1),
(70, 4, 22, 2, 1),
(71, 4, 23, 2, 3),
(72, 4, 24, 4, 3),
(73, 5, 1, 3, 1),
(74, 5, 2, 2, 3),
(75, 5, 3, 1, 3),
(76, 5, 4, 4, 1),
(77, 5, 5, 4, 2),
(78, 5, 6, 4, 3),
(79, 5, 7, 4, 3),
(80, 5, 8, 3, 2),
(81, 5, 9, 2, 4),
(82, 5, 10, 4, 1),
(83, 5, 11, 1, 4),
(84, 5, 12, 2, 1),
(85, 5, 13, 1, 2),
(86, 5, 14, 3, 1),
(87, 5, 15, 2, 4),
(88, 5, 16, 4, 3),
(89, 5, 17, 1, 4),
(90, 5, 18, 2, 4),
(91, 5, 19, 3, 1),
(92, 5, 20, 4, 3),
(93, 5, 21, 3, 1),
(94, 5, 22, 3, 1),
(95, 5, 23, 2, 3),
(96, 5, 24, 4, 2),
(97, 6, 1, 4, 3),
(98, 6, 2, 4, 3),
(99, 6, 3, 4, 2),
(100, 6, 4, 2, 3),
(101, 6, 5, 3, 1),
(102, 6, 6, 4, 2),
(103, 6, 7, 1, 2),
(104, 6, 8, 3, 4),
(105, 6, 9, 1, 4),
(106, 6, 10, 3, 2),
(107, 6, 11, 4, 2),
(108, 6, 12, 3, 4),
(109, 6, 13, 4, 2),
(110, 6, 14, 2, 3),
(111, 6, 15, 2, 3),
(112, 6, 16, 1, 3),
(113, 6, 17, 3, 4),
(114, 6, 18, 4, 1),
(115, 6, 19, 4, 2),
(116, 6, 20, 2, 1),
(117, 6, 21, 4, 1),
(118, 6, 22, 4, 2),
(119, 6, 23, 3, 1),
(120, 6, 24, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int NOT NULL,
  `nama` varchar(150) NOT NULL,
  `usia` int NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tanggal_tes` datetime DEFAULT CURRENT_TIMESTAMP,
  `most_d` int DEFAULT '0',
  `most_i` int DEFAULT '0',
  `most_s` int DEFAULT '0',
  `most_c` int DEFAULT '0',
  `least_d` int DEFAULT '0',
  `least_i` int DEFAULT '0',
  `least_s` int DEFAULT '0',
  `least_c` int DEFAULT '0',
  `change_d` int DEFAULT '0',
  `change_i` int DEFAULT '0',
  `change_s` int DEFAULT '0',
  `change_c` int DEFAULT '0',
  `most_profil_idx` int DEFAULT NULL,
  `most_profil_kode` varchar(30) DEFAULT NULL,
  `most_profil_nama` varchar(100) DEFAULT NULL,
  `least_profil_idx` int DEFAULT NULL,
  `least_profil_kode` varchar(30) DEFAULT NULL,
  `least_profil_nama` varchar(100) DEFAULT NULL,
  `change_profil_idx` int DEFAULT NULL,
  `change_profil_kode` varchar(30) DEFAULT NULL,
  `change_profil_nama` varchar(100) DEFAULT NULL,
  `profil_kode` varchar(20) DEFAULT NULL,
  `profil_nama` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `nama`, `usia`, `jenis_kelamin`, `tanggal_tes`, `most_d`, `most_i`, `most_s`, `most_c`, `least_d`, `least_i`, `least_s`, `least_c`, `change_d`, `change_i`, `change_s`, `change_c`, `most_profil_idx`, `most_profil_kode`, `most_profil_nama`, `least_profil_idx`, `least_profil_kode`, `least_profil_nama`, `change_profil_idx`, `change_profil_kode`, `change_profil_nama`, `profil_kode`, `profil_nama`, `created_at`) VALUES
(1, 'Hafid', 25, 'Laki-laki', '2026-07-26 16:46:08', 2, 1, 8, 13, 9, 12, 1, 2, -7, -11, 7, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', 'LOGICAL THINKER', '2026-07-26 16:46:08'),
(2, 'Hafid', 25, 'Laki-laki', '2026-07-26 16:56:39', 6, 0, 8, 10, 8, 5, 5, 6, -2, -5, 3, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C-S', 'PERFECTIONIST', '2026-07-26 16:56:39'),
(4, 'Audiyah Dini Maharani', 20, 'Perempuan', '2026-07-27 09:51:11', 5, 3, 1, 9, 4, 6, 6, 2, 1, -3, -5, 7, 1, 'C', 'LOGICAL THINKER', 38, 'C-D-S', 'CONTEMPLATOR', 3, 'D / C-D', 'DESIGNER', NULL, NULL, '2026-07-27 09:51:11'),
(5, 'Latifah Kurnia Devani', 28, 'Perempuan', '2026-07-27 09:59:46', 4, 5, 4, 6, 3, 5, 8, 5, 1, 0, -4, 1, 26, 'I-C', 'ASSESSOR', 18, 'D-C', 'CHALLENGER', 37, 'C-D-I', 'CHALLENGER', NULL, NULL, '2026-07-27 09:59:46'),
(6, 'MUHAMMAD HAFID HIDAYAT', 25, 'Laki-laki', '2026-07-27 10:39:26', 2, 3, 9, 6, 7, 7, 2, 1, -5, -4, 7, 5, 17, 'S-C', 'PEACEMAKER, RESPECTFULL & ACCURATE', 16, 'S / C-S', 'PERFECTIONIST', 16, 'S / C-S', 'PERFECTIONIST', NULL, NULL, '2026-07-27 10:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `scoring_key`
--

CREATE TABLE `scoring_key` (
  `id` int NOT NULL,
  `question_no` int NOT NULL,
  `position` tinyint NOT NULL,
  `letter` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `scoring_key`
--

INSERT INTO `scoring_key` (`id`, `question_no`, `position`, `letter`) VALUES
(1, 1, 1, 'S'),
(2, 1, 2, 'I'),
(3, 1, 3, 'D'),
(4, 1, 4, 'C'),
(5, 2, 1, 'C'),
(6, 2, 2, 'D'),
(7, 2, 3, 'I'),
(8, 2, 4, 'S'),
(9, 3, 1, 'I'),
(10, 3, 2, 'C'),
(11, 3, 3, 'S'),
(12, 3, 4, 'D'),
(13, 4, 1, 'S'),
(14, 4, 2, 'C'),
(15, 4, 3, 'I'),
(16, 4, 4, 'D'),
(17, 5, 1, 'I'),
(18, 5, 2, 'D'),
(19, 5, 3, 'S'),
(20, 5, 4, 'C'),
(21, 6, 1, 'C'),
(22, 6, 2, 'D'),
(23, 6, 3, 'I'),
(24, 6, 4, 'S'),
(25, 7, 1, 'S'),
(26, 7, 2, 'I'),
(27, 7, 3, 'C'),
(28, 7, 4, 'D'),
(29, 8, 1, 'I'),
(30, 8, 2, 'S'),
(31, 8, 3, 'C'),
(32, 8, 4, 'D'),
(33, 9, 1, 'D'),
(34, 9, 2, 'C'),
(35, 9, 3, 'I'),
(36, 9, 4, 'S'),
(37, 10, 1, 'C'),
(38, 10, 2, 'I'),
(39, 10, 3, 'S'),
(40, 10, 4, 'D'),
(41, 11, 1, 'I'),
(42, 11, 2, 'C'),
(43, 11, 3, 'D'),
(44, 11, 4, 'S'),
(45, 12, 1, 'S'),
(46, 12, 2, 'C'),
(47, 12, 3, 'I'),
(48, 12, 4, 'D'),
(49, 13, 1, 'D'),
(50, 13, 2, 'S'),
(51, 13, 3, 'I'),
(52, 13, 4, 'C'),
(53, 14, 1, 'C'),
(54, 14, 2, 'I'),
(55, 14, 3, 'S'),
(56, 14, 4, 'D'),
(57, 15, 1, 'I'),
(58, 15, 2, 'C'),
(59, 15, 3, 'D'),
(60, 15, 4, 'S'),
(61, 16, 1, 'D'),
(62, 16, 2, 'C'),
(63, 16, 3, 'I'),
(64, 16, 4, 'S'),
(65, 17, 1, 'C'),
(66, 17, 2, 'D'),
(67, 17, 3, 'S'),
(68, 17, 4, 'I'),
(69, 18, 1, 'D'),
(70, 18, 2, 'I'),
(71, 18, 3, 'S'),
(72, 18, 4, 'C'),
(73, 19, 1, 'D'),
(74, 19, 2, 'S'),
(75, 19, 3, 'I'),
(76, 19, 4, 'C'),
(77, 20, 1, 'D'),
(78, 20, 2, 'S'),
(79, 20, 3, 'I'),
(80, 20, 4, 'C'),
(81, 21, 1, 'S'),
(82, 21, 2, 'D'),
(83, 21, 3, 'I'),
(84, 21, 4, 'C'),
(85, 22, 1, 'S'),
(86, 22, 2, 'I'),
(87, 22, 3, 'D'),
(88, 22, 4, 'C'),
(89, 23, 1, 'D'),
(90, 23, 2, 'I'),
(91, 23, 3, 'S'),
(92, 23, 4, 'C'),
(93, 24, 1, 'S'),
(94, 24, 2, 'I'),
(95, 24, 3, 'D'),
(96, 24, 4, 'C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participant_id` (`participant_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoring_key`
--
ALTER TABLE `scoring_key`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_q_pos` (`question_no`,`position`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `scoring_key`
--
ALTER TABLE `scoring_key`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
