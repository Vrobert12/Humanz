-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Jún 11. 17:03
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.3.6

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
(61, 'E-mail validation', 'varrorobert03@gmail.com', 'Time for validation has expired', '2024-06-11 13:24:20.000000');

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
(7, 2, 19, '2024-06-12', '15:15:00', '17:15:00'),
(8, 2, 19, '2024-06-12', '15:15:00', '17:15:00'),
(9, 2, 19, '2024-06-12', '15:15:00', '17:15:00'),
(10, 2, 19, '2024-06-06', '15:30:00', '17:30:00'),
(11, 3, 19, '2024-06-06', '15:00:00', '16:00:00'),
(12, 3, 19, '2024-06-06', '15:00:00', '16:00:00'),
(13, 3, 19, '2024-06-06', '15:00:00', '16:00:00'),
(14, 3, 19, '2024-06-14', '18:45:00', '22:30:00'),
(15, 3, 19, '2024-06-20', '15:45:00', '20:00:00'),
(16, 3, 19, '2024-06-12', '17:45:00', '21:15:00'),
(17, 3, 19, '2024-06-13', '15:45:00', '00:00:00'),
(18, 3, 19, '2024-06-21', '16:00:00', '00:00:00'),
(19, 3, 19, '2024-06-20', '20:30:00', '23:00:00'),
(20, 3, 19, '2024-06-12', '21:15:00', '00:00:00'),
(21, 3, 19, '2024-06-20', '15:15:00', '00:00:00'),
(22, 4, 19, '2024-06-19', '18:45:00', '22:45:00'),
(23, 4, 19, '2024-06-14', '19:00:00', '20:30:00'),
(24, 1, 25, '2024-06-14', '15:00:00', '16:00:00'),
(25, 2, 19, '2024-05-29', '15:45:00', '19:00:00'),
(26, 1, 19, '2024-06-14', '16:00:00', '22:00:00'),
(27, 2, 27, '2024-06-21', '15:00:00', '17:00:00'),
(28, 2, 27, '2024-06-21', '18:00:00', '22:00:00'),
(29, 2, 27, '2024-06-22', '15:00:00', '18:45:00');

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
(2, '2.jpg', 4, 'Silver', 'No', 0),
(3, '2.jpg', 6, 'Gold', 'Yes', 0),
(4, '2.jpg', 6, 'Gold', 'Yes', 0),
(5, '2.jpg', 7, 'Gold', 'Yes', 0);

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
(19, 'Pál', 'Varró', 649420637, 'robertvarro12@gmail.com', '$2y$10$N2.WWC3OvEIK9xAdqDI0e.1jdtMYJQkMpiyovSGiDwK2df8ollXda', '20240603142900.png', 'Admin', '0000-00-00 00:00:00', 229527, 1, '2024-04-29 22:00:00', 0, '0000-00-00 00:00:00', 231192, '2024-06-11 11:27:05'),
(25, 'Dominik', 'Hupko', 628277140, 'hupkodominik143@gmail.com', '$2y$10$2GtJU92kqTP4FioPdkS0WuXGDZMTqQwpEuDToq9suKr3T7XP37EEm', 'logInPic.png', 'Guest', '2024-06-03 12:23:54', 2047970, 1, '2024-06-03 12:33:54', 0, '0000-00-00 00:00:00', NULL, '2024-06-03 12:23:54'),
(27, 'Robert', 'Hupko', 289420637, 'varrorobert03@gmail.com', '$2y$10$G1FvHNnYvhb/dMYg4EkVMu2MuJXMvrEufqkVqLjsQxgNb6Cgm3.Oy', 'logInPic.png', 'Guest', '2024-06-11 11:40:42', 9301603, 0, '2024-06-11 11:50:42', 0, '2024-06-11 11:40:42', 250493, '2024-06-11 11:51:48');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `visitor`
--

CREATE TABLE `visitor` (
  `visitorId` int(6) NOT NULL,
  `visitDate` datetime NOT NULL,
  `visitId` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `visitorcount`
--

CREATE TABLE `visitorcount` (
  `visitId` int(6) NOT NULL,
  `visitDate` datetime NOT NULL,
  `visitorcount` int(6) NOT NULL,
  `adminId` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `errorlog`
--
ALTER TABLE `errorlog`
  ADD PRIMARY KEY (`errorLogId`);

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
-- A tábla indexei `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`visitorId`,`visitId`),
  ADD KEY `latogatasId` (`visitId`);

--
-- A tábla indexei `visitorcount`
--
ALTER TABLE `visitorcount`
  ADD PRIMARY KEY (`visitId`,`adminId`),
  ADD KEY `adminId` (`adminId`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `errorlog`
--
ALTER TABLE `errorlog`
  MODIFY `errorLogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT a táblához `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT a táblához `table`
--
ALTER TABLE `table`
  MODIFY `tableId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT a táblához `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitorId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `visitorcount`
--
ALTER TABLE `visitorcount`
  MODIFY `visitId` int(6) NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_table_reservation` FOREIGN KEY (`tableId`) REFERENCES `table` (`tableId`),
  ADD CONSTRAINT `fk_user_reservation` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Megkötések a táblához `visitor`
--
ALTER TABLE `visitor`
  ADD CONSTRAINT `visitor_ibfk_1` FOREIGN KEY (`visitId`) REFERENCES `visitorcount` (`visitId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
