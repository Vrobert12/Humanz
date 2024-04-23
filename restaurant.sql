-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Ápr 23. 15:41
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.0.30

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
-- Tábla szerkezet ehhez a táblához `admin`
--

CREATE TABLE `admin` (
  `adminId` int(2) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `profilePic` varchar(100) NOT NULL,
  `adminMail` varchar(100) NOT NULL,
  `adminPassword` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `admin`
--

INSERT INTO `admin` (`adminId`, `firstName`, `lastName`, `profilePic`, `adminMail`, `adminPassword`) VALUES
(3, 'Róbert', 'Varró', '20240421201538.jpg', 'robertvarro12@gmail.com', '$2a$12$/YkfY2GW29N/J7wb0E.mVupaSBsibaP3aA5EW9INUNSOA8EZcLBNq');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservation`
--

CREATE TABLE `reservation` (
  `tableId` int(11) NOT NULL,
  `registrationId` int(11) NOT NULL,
  `reservationTime` date NOT NULL,
  `period` date NOT NULL,
  `reservationCode` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `table`
--

CREATE TABLE `table` (
  `tableId` int(6) NOT NULL,
  `tableCode` int(3) NOT NULL,
  `capacity` int(2) NOT NULL,
  `reservationTime` datetime NOT NULL,
  `period` time NOT NULL,
  `area` varchar(50) NOT NULL,
  `smokingArea` tinyint(1) NOT NULL,
  `workerId` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `registrationId` int(6) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `phoneNumber` int(10) NOT NULL,
  `userMail` varchar(100) NOT NULL,
  `userPassword` varchar(60) NOT NULL,
  `profilePic` varchar(100) DEFAULT NULL,
  `verification_code` int(50) DEFAULT NULL,
  `verify` int(11) NOT NULL,
  `verification_time` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `banned` tinyint(1) NOT NULL,
  `banned_time` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `passwordValidation` int(10) NOT NULL,
  `passwordValidationTime` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`registrationId`, `firstName`, `lastName`, `phoneNumber`, `userMail`, `userPassword`, `profilePic`, `verification_code`, `verify`, `verification_time`, `banned`, `banned_time`, `passwordValidation`, `passwordValidationTime`) VALUES
(6, 'Nikoletta', 'Varro', 101231232, 'nikolettavarro12@gmail.com', '$2y$10$ZJtAXGLi1y8Y7VlLzE4Ru.nH.SbV5pbDRtoQTlOv88WgemWiSIrB2', 'logInPic.png', 401081, 0, '2024-04-20 14:30:12.800889', 0, '2024-04-20 22:59:22.000000', 0, '2024-04-23 11:54:10.723073'),
(7, 'Nikoletta', 'Varro', 101231232, 'nikolettavarro@gmail.com', '$2y$10$GZ9eslD9.lWIwuBi0by.sunJYqe1s8Jn8K2eX4CefmMN/LOnyRNua', 'logInPic.png', 102107, 0, '2024-04-20 14:30:12.800889', 0, '2024-04-20 22:59:22.000000', 0, '2024-04-23 11:54:10.723073'),
(8, 'Robert', 'Varro', 644300022, 'vrobert1976@gmail.com', '$2y$10$6/uAicjSHhrmJc7sTO492uX4gZKJGNMNo8/6dSwKD7cPHsf0kpdim', 'logInPic.png', 358901, 1, '2024-04-20 14:30:12.800889', 0, '2024-04-20 22:59:22.000000', 0, '2024-04-23 11:54:10.723073'),
(17, 'Dominik', 'Varro', 101231232, 'varrorobert03@gmail.com', '$2y$10$Pcgka6CW.hKnBdt6N3jezuKO5W0urSVDfbtPSIsftsn7rDLpjYoEO', 'logInPic.png', 168122, 1, '2024-04-23 15:37:50.000000', 0, '0000-00-00 00:00:00.000000', 357330, '2024-04-23 15:38:03.000000'),
(18, 'Dominik', 'Hupko', 109420637, 'hupkodominik143@gmail.com', '$2y$10$TW8FomtNzJoUl0s37W9FYe22K.4m7srELL41rkyfnFqxeVRRyygcO', 'logInPic.png', 2442334, 1, '2024-04-23 15:31:22.000000', 0, '0000-00-00 00:00:00.000000', 233122, '2024-04-23 15:28:06.000000');

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

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `worker`
--

CREATE TABLE `worker` (
  `workerId` int(3) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `profilePic` varchar(50) NOT NULL,
  `phoneNumber` int(10) NOT NULL,
  `workerMail` varchar(100) NOT NULL,
  `workerPassword` varchar(100) NOT NULL,
  `adminId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `worker`
--

INSERT INTO `worker` (`workerId`, `firstName`, `lastName`, `profilePic`, `phoneNumber`, `workerMail`, `workerPassword`, `adminId`) VALUES
(1, 'Adam', 'Laszlo', 'logInPic.png', 123456, 'laci@gmail.com', '$2a$12$vLsIP..QTClqkbVF8ZI4g.54aDE28I56Yn6qEua6KgFhcsXkHIdC2', 3);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`);

--
-- A tábla indexei `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`tableId`,`registrationId`),
  ADD KEY `regisztraloid` (`registrationId`);

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
  ADD PRIMARY KEY (`registrationId`);

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
-- A tábla indexei `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`workerId`,`adminId`),
  ADD KEY `rendszergazdaId` (`adminId`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `admin`
--
ALTER TABLE `admin`
  MODIFY `adminId` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `table`
--
ALTER TABLE `table`
  MODIFY `tableId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `registrationId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- AUTO_INCREMENT a táblához `worker`
--
ALTER TABLE `worker`
  MODIFY `workerId` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`registrationId`) REFERENCES `user` (`registrationId`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`tableId`) REFERENCES `table` (`tableId`);

--
-- Megkötések a táblához `table`
--
ALTER TABLE `table`
  ADD CONSTRAINT `table_ibfk_1` FOREIGN KEY (`workerId`) REFERENCES `worker` (`workerId`);

--
-- Megkötések a táblához `visitor`
--
ALTER TABLE `visitor`
  ADD CONSTRAINT `visitor_ibfk_1` FOREIGN KEY (`visitId`) REFERENCES `visitorcount` (`visitId`);

--
-- Megkötések a táblához `visitorcount`
--
ALTER TABLE `visitorcount`
  ADD CONSTRAINT `visitorcount_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admin` (`adminId`);

--
-- Megkötések a táblához `worker`
--
ALTER TABLE `worker`
  ADD CONSTRAINT `worker_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admin` (`adminId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
