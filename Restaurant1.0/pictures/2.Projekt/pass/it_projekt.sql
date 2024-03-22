-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 03:53 PM
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
-- Database: `it projekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `it`
--

CREATE TABLE `it` (
  `termek_id` int(3) NOT NULL,
  `termek_nev` varchar(50) NOT NULL,
  `termek_tipus` varchar(20) NOT NULL,
  `termek_ar` decimal(6,2) NOT NULL,
  `termek_gyarto` varchar(30) NOT NULL,
  `kep` varchar(255) NOT NULL,
  `kep_dir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `it`
--

INSERT INTO `it` (`termek_id`, `termek_nev`, `termek_tipus`, `termek_ar`, `termek_gyarto`, `kep`, `kep_dir`) VALUES
(1, 'Ryzen 5 3600 ', 'Processzor', 99.99, 'AMD', 'ryzen3600', 'jpeg'),
(2, 'Intel Core i5-12400F', 'Processzor', 169.99, 'Intel', 'intel-core-i5-12400f', 'jpg'),
(3, '24G2 ', 'Monitor', 170.00, 'AOC', '24G2 Gaming Monitor', 'png'),
(4, 'GTX 1080 Ti', 'Grafikus kártya', 300.00, 'Gigabyte', 'MSI GTX 1080', 'png'),
(5, 'YHP 3020', 'Fejhalgató', 30.00, 'Yenkee', 'Yenkee', 'jpg'),
(6, 'ROG Strix Scar 16', 'Laptop', 4000.00, 'Asus', 'asusLaptop', 'jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `it`
--
ALTER TABLE `it`
  ADD PRIMARY KEY (`termek_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `it`
--
ALTER TABLE `it`
  MODIFY `termek_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


GRANT ALL PRIVILEGES ON *.* TO `VRobert12`@`localhost` IDENTIFIED BY PASSWORD '*08E56F893DF2B11C03948BF647D171E4108F5E32' WITH GRANT OPTION;