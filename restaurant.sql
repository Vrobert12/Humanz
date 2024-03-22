-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Már 22. 23:15
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
-- Tábla szerkezet ehhez a táblához `asztalok`
--

CREATE TABLE `asztalok` (
  `asztalId` int(6) NOT NULL,
  `asztalKod` int(3) NOT NULL,
  `ferohely` int(2) NOT NULL,
  `idopont` datetime DEFAULT NULL,
  `idotartam` time NOT NULL,
  `helyseg` varchar(50) NOT NULL,
  `dohanyzo_hely` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `dolgozo`
--

CREATE TABLE `dolgozo` (
  `dolgozoId` int(3) NOT NULL,
  `keresztnev` varchar(50) NOT NULL,
  `vezeteknev` varchar(50) NOT NULL,
  `profilkep` varchar(100) DEFAULT NULL,
  `dolgozoEmail` varchar(100) NOT NULL,
  `dolgozoJelszo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `dolgozo`
--

INSERT INTO `dolgozo` (`dolgozoId`, `keresztnev`, `vezeteknev`, `profilkep`, `dolgozoEmail`, `dolgozoJelszo`) VALUES
(1, 'Robert', 'Varro', 'logInPic.jpg', 'varrorobert03@gmail.com', '$2a$12$/YkfY2GW29N/J7wb0E.mVupaSBsibaP3aA5EW9INUNSOA8EZcLBNq');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `foglalas`
--

CREATE TABLE `foglalas` (
  `asztalid` int(11) NOT NULL,
  `regisztraloid` int(11) NOT NULL,
  `foglalasidopont` date NOT NULL,
  `idotartam` date NOT NULL,
  `foglalaskod` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `latogatasokszama`
--

CREATE TABLE `latogatasokszama` (
  `latogatasId` int(6) NOT NULL,
  `latogatasDatum` datetime NOT NULL,
  `latogatokSzama` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `latogato`
--

CREATE TABLE `latogato` (
  `latogatoId` int(6) NOT NULL,
  `latogatasIdo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `regisztralo`
--

CREATE TABLE `regisztralo` (
  `regisztraloId` int(6) NOT NULL,
  `keresztnev` varchar(50) NOT NULL,
  `vezeteknev` varchar(50) NOT NULL,
  `telefonszam` int(10) NOT NULL,
  `regisztraloEmail` varchar(100) NOT NULL,
  `regisztraloJelszo` varchar(60) NOT NULL,
  `profilkep` varchar(100) DEFAULT NULL,
  `verification_code` int(50) DEFAULT NULL,
  `verify` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `regisztralo`
--

INSERT INTO `regisztralo` (`regisztraloId`, `keresztnev`, `vezeteknev`, `telefonszam`, `regisztraloEmail`, `regisztraloJelszo`, `profilkep`, `verification_code`, `verify`) VALUES
(6, 'Nikoletta', 'Varro', 101231232, 'nikolettavarro12@gmail.com', '$2y$10$ZJtAXGLi1y8Y7VlLzE4Ru.nH.SbV5pbDRtoQTlOv88WgemWiSIrB2', NULL, 401081, 0),
(7, 'Nikoletta', 'Varro', 101231232, 'nikolettavarro@gmail.com', '$2y$10$GZ9eslD9.lWIwuBi0by.sunJYqe1s8Jn8K2eX4CefmMN/LOnyRNua', NULL, 102107, 0),
(8, 'Robert', 'Varro', 644300022, 'vrobert1976@gmail.com', '$2y$10$6/uAicjSHhrmJc7sTO492uX4gZKJGNMNo8/6dSwKD7cPHsf0kpdim', 'Bob.jpg', 358901, 1),
(11, 'Dominik', 'Hupko', 179420637, 'hupkodominik143@gmail.com', '$2y$10$pDSkDGh3QMNmw2k1xHR3IucBdYN7lyjrVaCg1xth0JV71hl8EsFJG', 'logInPic.jpg', 790057, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rendszergazda`
--

CREATE TABLE `rendszergazda` (
  `rendszerGazdaId` int(2) NOT NULL,
  `keresztnev` varchar(50) NOT NULL,
  `vezeteknev` varchar(50) NOT NULL,
  `profilkep` varchar(100) NOT NULL,
  `rendszerGazdaEmail` varchar(100) NOT NULL,
  `rendszerGazdaJelszo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `rendszergazda`
--

INSERT INTO `rendszergazda` (`rendszerGazdaId`, `keresztnev`, `vezeteknev`, `profilkep`, `rendszerGazdaEmail`, `rendszerGazdaJelszo`) VALUES
(3, 'Róbert', 'Varró', 'logInPic.jpg', 'robertvarro12@gmail.com', '$2a$12$/YkfY2GW29N/J7wb0E.mVupaSBsibaP3aA5EW9INUNSOA8EZcLBNq');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `asztalok`
--
ALTER TABLE `asztalok`
  ADD PRIMARY KEY (`asztalId`);

--
-- A tábla indexei `dolgozo`
--
ALTER TABLE `dolgozo`
  ADD PRIMARY KEY (`dolgozoId`);

--
-- A tábla indexei `foglalas`
--
ALTER TABLE `foglalas`
  ADD PRIMARY KEY (`asztalid`,`regisztraloid`),
  ADD KEY `regisztraloid` (`regisztraloid`);

--
-- A tábla indexei `latogatasokszama`
--
ALTER TABLE `latogatasokszama`
  ADD PRIMARY KEY (`latogatasId`);

--
-- A tábla indexei `latogato`
--
ALTER TABLE `latogato`
  ADD PRIMARY KEY (`latogatoId`);

--
-- A tábla indexei `regisztralo`
--
ALTER TABLE `regisztralo`
  ADD PRIMARY KEY (`regisztraloId`);

--
-- A tábla indexei `rendszergazda`
--
ALTER TABLE `rendszergazda`
  ADD PRIMARY KEY (`rendszerGazdaId`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `asztalok`
--
ALTER TABLE `asztalok`
  MODIFY `asztalId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `dolgozo`
--
ALTER TABLE `dolgozo`
  MODIFY `dolgozoId` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `latogatasokszama`
--
ALTER TABLE `latogatasokszama`
  MODIFY `latogatasId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `latogato`
--
ALTER TABLE `latogato`
  MODIFY `latogatoId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `regisztralo`
--
ALTER TABLE `regisztralo`
  MODIFY `regisztraloId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `rendszergazda`
--
ALTER TABLE `rendszergazda`
  MODIFY `rendszerGazdaId` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `asztalok`
--
ALTER TABLE `asztalok`
  ADD CONSTRAINT `asztalok_ibfk_1` FOREIGN KEY (`asztalId`) REFERENCES `foglalas` (`asztalid`);

--
-- Megkötések a táblához `foglalas`
--
ALTER TABLE `foglalas`
  ADD CONSTRAINT `foglalas_ibfk_1` FOREIGN KEY (`regisztraloid`) REFERENCES `regisztralo` (`regisztraloId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
