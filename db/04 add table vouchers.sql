-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 09. Jun 2018 um 16:18
-- Server-Version: 10.1.30-MariaDB
-- PHP-Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ss2018_wt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vouchers`
--

CREATE TABLE `vouchers` (
  `value` int(11) NOT NULL,
  `code` varchar(5) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `vouchers`
--

INSERT INTO `vouchers` (`value`, `code`, `date`, `used`) VALUES
(5, '12345', '0000-00-00', 0),
(10, '54321', '0000-00-00', 0),
(1, 'ABCDE', '0000-00-00', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
