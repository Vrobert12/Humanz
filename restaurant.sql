-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Jún 19. 22:39
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `restaurant`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `coupon`
--

CREATE TABLE `coupon` (
  `couponId` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `discountCode` int(11) NOT NULL,
  `discountValidate` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `errorlog`
--

CREATE TABLE `errorlog` (
  `errorLogId` int(11) NOT NULL,
  `errorType` varchar(30) NOT NULL,
  `errorMail` varchar(100) NOT NULL,
  `errorText` text NOT NULL,
  `errorTime` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `errorlog`
--

INSERT INTO `errorlog` (`errorLogId`, `errorType`, `errorMail`, `errorText`, `errorTime`) VALUES
(1, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-24 10:54:34.000000'),
(2, 'Log in', 'robertvarro1fd2@gmail.com', 'Not registered E-mail!', '2024-04-24 10:54:49.000000'),
(3, 'Password change', 'robertvarro123@gmail.com', 'Not registered E-mail!', '2024-04-24 10:59:50.000000'),
(4, 'E-mail validation', 'varrorobert03@gmail.com', 'The validation code is not correct!', '2024-04-24 11:18:29.000000'),
(5, 'E-mail validation', 'varrorobert03@gmail.com', 'The validation code is not correct!', '2024-04-24 11:19:42.000000'),
(6, 'E-mail validation', 'varrorobert03@gmail.com', 'Time for validation has expired', '2024-04-24 11:21:34.000000'),
(7, 'E-mail validation', 'varrorobert03@gmail.com', 'Time for validation has expired', '2024-04-24 11:23:54.000000'),
(8, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-25 07:51:58.000000'),
(9, 'Log in', 'hupkodominik1ee4rertg43@gmail.com', 'Not registered E-mail!', '2024-04-25 07:52:19.000000'),
(10, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-27 14:25:52.000000'),
(11, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-27 14:26:03.000000'),
(12, 'Password change', 'robertvarro12@gmail.com', 'Not registered E-mail!', '2024-04-27 14:40:17.000000'),
(13, 'Password change', 'robertvarro12@gmail.com', 'Not registered E-mail!', '2024-04-27 14:40:30.000000'),
(14, 'Log in', '', 'Not registered E-mail!', '2024-04-27 15:55:55.000000'),
(15, 'Log in', '', 'Not registered E-mail!', '2024-04-27 15:55:57.000000'),
(16, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-27 17:06:15.000000'),
(17, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-27 20:34:24.000000'),
(18, 'Adding a Worker', 'robertvarro12@gmail.com', 'The worker is already registered', '2024-04-27 21:18:09.000000'),
(19, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-27 21:49:53.000000'),
(20, 'Adding a Worker', 'robertvarro12@gmail.com', 'The worker is already registered', '2024-04-27 21:51:25.000000'),
(21, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-27 22:13:44.000000'),
(22, 'Adding a Worker', 'robertvarro12@gmail.com', 'The worker is already registered', '2024-04-28 22:24:59.000000'),
(23, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-28 22:37:27.000000'),
(24, 'Adding a Worker', 'robertvarro12@gmail.com', 'The worker is already registered', '2024-04-28 22:45:12.000000'),
(25, 'Adding a Worker', 'robertvarro12@gmail.com', 'The worker is already registered', '2024-04-28 22:46:38.000000'),
(26, 'Adding a Worker', 'robertvarro12@gmail.com', 'The worker is already registered', '2024-04-28 22:46:52.000000'),
(27, 'Adding a Worker', 'robertvarro12@gmail.com', 'The worker is already registered', '2024-04-28 22:47:16.000000'),
(28, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:05:25.000000'),
(29, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:06:52.000000'),
(30, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:08:17.000000'),
(31, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:10:24.000000'),
(32, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:10:34.000000'),
(33, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:11:10.000000'),
(34, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:11:34.000000'),
(35, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:11:50.000000'),
(36, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:13:55.000000'),
(37, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:14:21.000000'),
(38, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:14:48.000000'),
(39, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:16:30.000000'),
(40, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:17:05.000000'),
(41, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:18:18.000000'),
(42, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-28 23:19:05.000000'),
(43, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:19:33.000000'),
(44, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:21:12.000000'),
(45, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:22:16.000000'),
(46, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:23:09.000000'),
(47, 'Log in', 'varrorobert03@gmail.com', 'The worker did not set up a password!', '2024-04-28 23:25:00.000000'),
(48, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-30 19:53:34.000000'),
(49, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-30 19:53:45.000000'),
(50, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-30 21:21:13.000000'),
(51, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-30 21:21:25.000000'),
(52, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-30 21:22:05.000000'),
(53, 'Log in', 'varrorobert03@gmail.com', 'Wrong password!', '2024-04-30 21:22:07.000000'),
(54, 'Banned', 'varrorobert03@gmail.com', 'User tried to log in while he is banned!', '2024-04-30 21:25:42.000000'),
(55, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-04-30 21:42:30.000000'),
(56, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-05-04 21:26:15.000000'),
(57, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-05-04 23:54:17.000000'),
(58, 'Log in', 'robertvarro12@gmail.com', 'Wrong password!', '2024-05-05 18:17:50.000000'),
(59, 'Log in', '', 'Not registered E-mail!', '2024-05-23 17:11:26.000000'),
(60, 'Log in', 'robertvrro12@gmail.com', 'Not registered E-mail!', '2024-05-24 08:34:28.000000'),
(61, 'E-mail validation', 'varrorobert03@gmail.com', 'Time for validation has expired', '2024-06-11 13:24:20.000000'),
(62, 'Log in', 'robertvarro12@gmail.com', 'The password was not valid!', '2024-06-15 20:47:21.000000'),
(63, 'UserModify', 'robertvarro12@gmail.com', 'The file is bigger than 200KB', '2024-06-15 21:05:30.000000'),
(64, 'UserModify', 'robertvarro12@gmail.com', 'The file is bigger than 200KB', '2024-06-15 21:05:32.000000'),
(65, 'UserModify', 'robertvarro12@gmail.com', 'The file is bigger than 200KB', '2024-06-15 21:05:34.000000'),
(66, 'UserModify', 'robertvarro12@gmail.com', 'The file is bigger than 200KB', '2024-06-15 21:05:42.000000'),
(67, 'Log in', 'robertarro12@gmail.com', 'The E-mal is not in our database', '2024-06-16 10:31:47.000000'),
(68, 'Log in', 'robertarro12@gmail.com', 'The E-mal is not in our database', '2024-06-16 11:06:12.000000'),
(69, 'Picture', 'robertvarro12@gmail.com', 'The file is bigger than 200KB', '2024-06-19 10:07:14.000000'),
(70, 'Picture', 'robertvarro12@gmail.com', 'The file is bigger than 200KB', '2024-06-19 13:27:56.000000'),
(71, 'Log in', 'robertvarro12@gmail.com', 'The password was not valid!', '2024-06-19 14:08:35.000000'),
(72, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:13:52.000000'),
(73, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:15:09.000000'),
(74, 'Picture', 'robertvarro12@gmail.com', 'The file is bigger than 200KB', '2024-06-19 20:23:44.000000'),
(75, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:34:10.000000'),
(76, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:34:51.000000'),
(77, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:36:27.000000'),
(78, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:38:45.000000'),
(79, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:39:53.000000'),
(80, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:40:54.000000'),
(81, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:41:46.000000'),
(82, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:42:41.000000'),
(83, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:43:13.000000'),
(84, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:44:06.000000'),
(85, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:45:58.000000'),
(86, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:48:52.000000'),
(87, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:50:13.000000'),
(88, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 20:50:30.000000'),
(89, 'file Upload', 'Unknown', 'Someone tried to upload a picture from a not valid page', '2024-06-19 21:45:06.000000');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menu`
--

CREATE TABLE `menu` (
  `dishId` int(11) NOT NULL,
  `dishName` varchar(50) NOT NULL,
  `dishPicture` varchar(100) NOT NULL,
  `dishType` varchar(30) NOT NULL,
  `dishPrice` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `menu`
--

INSERT INTO `menu` (`dishId`, `dishName`, `dishPicture`, `dishType`, `dishPrice`) VALUES
(1, 'God of war', '20240611133528.jpg', 'Vegetarian', 4.99),
(2, 'Bread', 'spaghetti.jpg', 'Ordinary', 2.00),
(3, 'Spaghetti', 'spaghetti.jpg', 'Gluten free', 3.00),
(4, 'Spaghetti', 'spaghetti.jpg', 'Vegetarian', 4.00);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reports`
--

CREATE TABLE `reports` (
  `reportId` int(11) NOT NULL,
  `reservationCount` int(11) NOT NULL,
  `couponCount` int(11) NOT NULL,
  `sumCount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservation`
--

CREATE TABLE `reservation` (
  `reservationId` int(11) NOT NULL,
  `tableId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `reservationDay` date DEFAULT NULL,
  `reservationTime` time DEFAULT NULL,
  `period` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `reservation`
--

INSERT INTO `reservation` (`reservationId`, `tableId`, `userId`, `reservationDay`, `reservationTime`, `period`) VALUES
(1, 1, 19, '2024-06-02', '17:00:00', '17:45:00'),
(2, 1, 19, '2024-06-02', '15:15:00', '17:00:00'),
(3, 1, 19, '2024-06-03', '15:15:00', '16:00:00'),
(4, 1, 19, '2024-06-05', '15:15:00', '16:00:00'),
(5, 1, 19, '2024-06-05', '15:15:00', '16:00:00'),
(6, 1, 19, '2024-06-05', '15:15:00', '16:00:00'),
(10, 2, 19, '2024-06-06', '15:30:00', '17:30:00'),
(11, 3, 19, '2024-06-06', '15:00:00', '16:00:00'),
(12, 3, 19, '2024-06-06', '15:00:00', '16:00:00'),
(13, 3, 19, '2024-06-06', '15:00:00', '16:00:00'),
(16, 3, 19, '2024-06-12', '17:45:00', '21:15:00'),
(25, 2, 19, '2024-05-29', '15:45:00', '19:00:00'),
(40, 1, 19, '2024-06-15', '16:00:00', '17:00:00'),
(42, 1, 19, '2024-06-13', '18:30:00', '23:00:00'),
(44, 2, 19, '2024-06-19', '18:00:00', '23:00:00'),
(73, 2, 26, '2024-06-21', '16:15:00', '19:30:00'),
(74, 2, 26, '2024-06-13', '15:00:00', '16:00:00'),
(75, 5, 19, '2024-06-20', '15:00:00', '21:00:00'),
(76, 3, 27, '2024-06-15', '15:00:00', '16:00:00'),
(78, 7, 19, '2024-06-28', '15:00:00', '21:00:00'),
(79, 2, 27, '2024-06-28', '15:15:00', '19:15:00'),
(81, 5, 19, '2024-06-21', '15:00:00', '21:00:00'),
(82, 1, 29, '2024-06-28', '18:30:00', '22:30:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `table`
--

CREATE TABLE `table` (
  `tableId` int(6) NOT NULL,
  `reservationPicture` varchar(100) DEFAULT NULL,
  `capacity` int(2) NOT NULL,
  `area` varchar(50) NOT NULL,
  `smokingArea` varchar(5) NOT NULL,
  `workerId` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `table`
--

INSERT INTO `table` (`tableId`, `reservationPicture`, `capacity`, `area`, `smokingArea`, `workerId`) VALUES
(1, '2.jpg', 4, 'Gold', 'Yes', 0),
(2, '20240615201221.webp', 6, 'Bronze', 'Yes', 0),
(3, '20240615190533.webp', 4, 'Bronze', 'No', 0),
(4, '2.jpg', 6, 'Gold', 'Yes', 0),
(5, '2.jpg', 7, 'Gold', 'Yes', 0),
(6, '20240615175822.webp', 4, 'Silver', 'No', 0),
(7, '20240615202205.avif', 4, 'asd', 'No', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `userId` int(6) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `phoneNumber` int(10) NOT NULL,
  `userMail` varchar(100) NOT NULL,
  `userPassword` varchar(60) NOT NULL,
  `profilePic` varchar(100) DEFAULT NULL,
  `privilage` varchar(25) NOT NULL,
  `registrationTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_code` int(50) DEFAULT NULL,
  `verify` int(11) NOT NULL,
  `verification_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `banned` tinyint(1) NOT NULL,
  `banned_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `passwordValidation` int(10) DEFAULT NULL,
  `passwordValidationTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`userId`, `firstName`, `lastName`, `phoneNumber`, `userMail`, `userPassword`, `profilePic`, `privilage`, `registrationTime`, `verification_code`, `verify`, `verification_time`, `banned`, `banned_time`, `passwordValidation`, `passwordValidationTime`) VALUES
(6, 'Nikoletta', 'Varro', 0, 'nikolettavarro12@gmail.com', '$2y$10$ZJtAXGLi1y8Y7VlLzE4Ru.nH.SbV5pbDRtoQTlOv88WgemWiSIrB2', 'logInPic.png', 'Guest', '0000-00-00 00:00:00', 401081, 0, '2024-04-29 22:00:00', 0, '0000-00-00 00:00:00', 0, '2024-04-23 09:54:10'),
(7, 'Nikoletta', 'Varro', 0, 'nikolettavarro@gmail.com', '$2y$10$GZ9eslD9.lWIwuBi0by.sunJYqe1s8Jn8K2eX4CefmMN/LOnyRNua', 'logInPic.png', 'Guest', '0000-00-00 00:00:00', 102107, 0, '2024-04-29 22:00:00', 0, '0000-00-00 00:00:00', 0, '2024-04-23 09:54:10'),
(19, 'Róbert', 'Varró', 649420637, 'robertvarro12@gmail.com', '$2y$10$cPLcJMsanfIKcT/RSF3rgO1zc/9JEbFgnD9YuEMZoFbNstohYDBha', '20240619205458.png', 'Admin', '0000-00-00 00:00:00', 229527, 1, '2024-04-29 22:00:00', 0, '0000-00-00 00:00:00', 136415, '2024-06-15 11:28:52'),
(25, 'Dominik', 'Hupko', 628277140, 'hupkodominik143@gmail.com', '$2y$10$2GtJU92kqTP4FioPdkS0WuXGDZMTqQwpEuDToq9suKr3T7XP37EEm', 'logInPic.png', 'Guest', '2024-06-03 12:23:54', 2047970, 1, '2024-06-03 12:33:54', 0, '0000-00-00 00:00:00', NULL, '2024-06-03 12:23:54'),
(26, 'Robert', 'Hupko', 649420637, 'varorobert03@gmail.com', '$2y$10$vVRKD1BHdxuVyK2Q1yAFiutrZafKmdOPO5HD1GhEctq8BgxUuQoa.', 'logInPic.png', 'Guest', '2024-06-12 16:21:21', 3652391, 1, '2024-06-12 16:31:21', 0, '2024-06-12 16:21:22', NULL, '2024-06-12 16:21:22'),
(27, 'Robert', 'Varro', 649420637, 'vaorobert03@gmail.com', '$2y$10$WLNUBEgiMnWyRdJYBqrQXOUu3kKCaJlkirZYbg.u4.UNkFMavtedi', '20240615204340.avif', 'Worker', '2024-06-15 11:30:27', 9844306, 1, '2024-06-15 11:40:27', 0, '0000-00-00 00:00:00', NULL, '2024-06-15 11:30:27'),
(28, 'Robert', 'Varro', 649420637, 'vadrrorobert03@gmail.com', '$2y$10$6TqYvJ6B6htGzaHUzOA/SuZwEnoXELGaDRKtU2HCkiqPvDWRN5h4u', 'logInPic.png', 'Worker', '2024-06-15 19:59:50', 1302342, 1, '2024-06-15 20:09:50', 0, '2024-06-15 19:59:50', NULL, '2024-06-15 19:59:50'),
(29, 'Robert', 'Varro', 649420637, 'varrorobert03@gmail.com', '$2y$10$/g5cMYoHnlvFQzuzCPLE/e2Dp1QG3d3cEDooOOu66Cy64Uaw/2uue', 'logInPic.png', 'Guest', '2024-06-19 10:25:41', 2120816, 1, '2024-06-19 10:35:41', 0, '2024-06-19 10:25:41', NULL, '2024-06-19 10:25:41');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `visitor`
--

CREATE TABLE `visitor` (
  `visitId` int(6) NOT NULL,
  `visitDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `visitor`
--

INSERT INTO `visitor` (`visitId`, `visitDate`) VALUES
(0, '2024-06-15 22:03:33'),
(0, '2024-06-16 10:22:25'),
(0, '2024-06-16 10:24:36'),
(0, '2024-06-19 10:03:53');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`couponId`);

--
-- A tábla indexei `errorlog`
--
ALTER TABLE `errorlog`
  ADD PRIMARY KEY (`errorLogId`);

--
-- A tábla indexei `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`dishId`);

--
-- A tábla indexei `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportId`);

--
-- A tábla indexei `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservationId`),
  ADD KEY `fk_user_reservation` (`userId`),
  ADD KEY `fk_table_reservation` (`tableId`);

--
-- A tábla indexei `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`tableId`,`workerId`),
  ADD KEY `dolgozoId` (`workerId`);

--
-- A tábla indexei `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `coupon`
--
ALTER TABLE `coupon`
  MODIFY `couponId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `errorlog`
--
ALTER TABLE `errorlog`
  MODIFY `errorLogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT a táblához `menu`
--
ALTER TABLE `menu`
  MODIFY `dishId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT a táblához `table`
--
ALTER TABLE `table`
  MODIFY `tableId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_table_reservation` FOREIGN KEY (`tableId`) REFERENCES `table` (`tableId`),
  ADD CONSTRAINT `fk_user_reservation` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
