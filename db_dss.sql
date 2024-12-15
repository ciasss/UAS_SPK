-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 01:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dss`
--

-- --------------------------------------------------------

--
-- Table structure for table `saw_alternatives`
--

CREATE TABLE `saw_alternatives` (
  `id_alternative` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `saw_alternatives`
--

INSERT INTO `saw_alternatives` (`id_alternative`, `name`) VALUES
(20, 'Saka'),
(19, 'Berlian'),
(18, 'Febi'),
(17, 'Ridwan'),
(16, 'Satria'),
(15, 'Jaki'),
(14, 'Budi'),
(13, 'Adi'),
(12, 'Dede'),
(11, 'Wulan'),
(10, 'Rizki'),
(9, 'Jefri'),
(8, 'Bianto'),
(7, 'Manalu'),
(6, 'Ujang'),
(5, 'Ajo'),
(4, 'Topik'),
(3, 'Dani'),
(2, 'Aman'),
(1, 'Veren');

-- --------------------------------------------------------

--
-- Table structure for table `saw_criterias`
--

CREATE TABLE `saw_criterias` (
  `id_criteria` tinyint(3) UNSIGNED NOT NULL,
  `criteria` varchar(100) NOT NULL,
  `weight` float NOT NULL,
  `attribute` set('benefit','cost') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `saw_criterias`
--

INSERT INTO `saw_criterias` (`id_criteria`, `criteria`, `weight`, `attribute`) VALUES
(1, 'Kerja Sama', 0.416212, 'benefit'),
(2, 'Perilaku', 0.261788, 'benefit'),
(3, 'Kehadiran', 0.16105, 'benefit'),
(4, 'Bertanggung Jawab', 0.0985728, 'benefit'),
(5, 'Kemampuan Bekerja', 0.0623764, 'benefit');

-- --------------------------------------------------------

--
-- Table structure for table `saw_evaluations`
--

CREATE TABLE `saw_evaluations` (
  `id_alternative` smallint(5) UNSIGNED NOT NULL,
  `id_criteria` tinyint(3) UNSIGNED NOT NULL,
  `value` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `saw_evaluations`
--

INSERT INTO `saw_evaluations` (`id_alternative`, `id_criteria`, `value`) VALUES
(5, 1, 4),
(4, 5, 3),
(4, 4, 5),
(4, 3, 4),
(4, 2, 4),
(4, 1, 5),
(3, 5, 4),
(3, 4, 5),
(3, 3, 3),
(3, 2, 4),
(3, 1, 5),
(2, 5, 5),
(2, 4, 4),
(2, 3, 4),
(2, 2, 5),
(2, 1, 4),
(1, 5, 4),
(1, 4, 4),
(1, 3, 4),
(1, 2, 5),
(6, 2, 5),
(6, 1, 3),
(6, 3, 2),
(6, 4, 5),
(5, 2, 4),
(5, 3, 4),
(5, 4, 4),
(5, 5, 5),
(1, 1, 5),
(6, 5, 4),
(7, 1, 2),
(7, 2, 4),
(7, 3, 4),
(7, 4, 3),
(7, 5, 3),
(8, 1, 5),
(8, 2, 4),
(8, 3, 5),
(8, 4, 4),
(8, 5, 4),
(9, 1, 4),
(9, 2, 4),
(9, 3, 3),
(9, 4, 3),
(9, 5, 3),
(10, 1, 3),
(10, 2, 3),
(10, 3, 3),
(10, 4, 2),
(10, 5, 5),
(11, 1, 4),
(11, 2, 5),
(11, 3, 3),
(11, 4, 5),
(11, 5, 5),
(12, 1, 4),
(12, 2, 3),
(12, 3, 4),
(12, 4, 3),
(12, 5, 3),
(13, 1, 3),
(13, 2, 3),
(13, 3, 3),
(13, 4, 4),
(13, 5, 4),
(14, 1, 3),
(14, 2, 3),
(14, 3, 5),
(14, 4, 5),
(14, 5, 5),
(15, 1, 4),
(15, 2, 5),
(15, 3, 4),
(15, 4, 5),
(15, 5, 2),
(16, 1, 2),
(16, 2, 3),
(16, 3, 2),
(16, 4, 3),
(16, 5, 5),
(17, 1, 5),
(17, 2, 3),
(17, 3, 3),
(17, 4, 4),
(17, 5, 5),
(18, 1, 4),
(18, 2, 4),
(18, 3, 4),
(18, 4, 5),
(18, 5, 1),
(19, 1, 4),
(19, 2, 3),
(19, 3, 5),
(19, 4, 5),
(19, 5, 3),
(20, 1, 3),
(20, 2, 2),
(20, 3, 1),
(20, 4, 2),
(20, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `saw_users`
--

CREATE TABLE `saw_users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `saw_users`
--

INSERT INTO `saw_users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'admin', 'admin', 'admin'),
(3, 'manager', 'manager', 'manager'),
(4, 'saka', 'saka', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saw_alternatives`
--
ALTER TABLE `saw_alternatives`
  ADD PRIMARY KEY (`id_alternative`);

--
-- Indexes for table `saw_criterias`
--
ALTER TABLE `saw_criterias`
  ADD PRIMARY KEY (`id_criteria`);

--
-- Indexes for table `saw_evaluations`
--
ALTER TABLE `saw_evaluations`
  ADD PRIMARY KEY (`id_alternative`,`id_criteria`);

--
-- Indexes for table `saw_users`
--
ALTER TABLE `saw_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `saw_alternatives`
--
ALTER TABLE `saw_alternatives`
  MODIFY `id_alternative` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `saw_users`
--
ALTER TABLE `saw_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
