-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 09. Jun 2018 um 00:42
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
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `name` varchar(32) NOT NULL,
  `category` varchar(32) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `description` varchar(64) DEFAULT NULL,
  `rating` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`name`, `category`, `price`, `description`, `rating`) VALUES
('', 'red', 2, 'Available', 2),
('affenkopf.jpg', 'red', 2.5, 'Available', 4.5),
('baby.jpg', 'white', 2, 'Available', 4.5),
('cypripedium.jpg', 'red', 2, 'Available', 4),
('derwisch.jpg', 'white', 3, 'Available', 5),
('dracula_orchidee.jpg', 'red', 3.5, 'Not available', 5),
('elf.jpg', 'white', 2.5, 'Available', 4.7),
('figure.jpg', 'red', 2, 'Available', 4.5),
('gebirgeorchidee.jpg', 'orange', 4, 'Available', 5),
('gepardkopf.jpg', 'white', 3, 'Available', 5),
('herz_der_blume.jpg', 'pink', 4, 'Available', 4.9),
('insekt.jpg', 'white', 2, 'Available', 4),
('lippen.jpg', 'red', 4.5, 'Available', 5),
('menschlein_lila.jpg', 'colour-mix', 3.5, 'Available', 4.7),
('menschlein_violet.jpg', 'colour-mix', 4, 'Available', 5),
('pareidolia_rosa.jpg', 'purple', 3, 'Available', 4.5),
('pareidolia_violet.jpg', 'purple', 3, 'Available', 4.5),
('pokemon.jpg', 'colour-mix', 4, 'Available', 5),
('raubblume.jpg', 'white', 4, 'Not available', 4.5),
('spinnen_orchidee.jpg', 'colour-mix', 3, 'Available', 4),
('tanzende_orchidee.jpg', 'colour-mix', 3.5, 'Available', 4.5),
('tÃ¤nzerin.jpg', 'colour-mix', 4, 'Available', 5),
('vader.jpg', 'colour-mix', 4.5, 'Available', 5),
('vogel_im_herz.jpg', 'white', 4, 'Not available', 4.5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `username` varchar(32) COLLATE utf8_bin NOT NULL,
  `pwd` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `anrede` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `vorname` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `nachname` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `adresse` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `plz` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `ort` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `zahlung` tinyint(1) DEFAULT '0',
  `is_admin` tinyint(1) DEFAULT '0',
  `is_ldap` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`username`, `pwd`, `anrede`, `vorname`, `nachname`, `adresse`, `plz`, `ort`, `email`, `zahlung`, `is_admin`, `is_ldap`) VALUES
('Qwerty12#', 'dc2e1a3ea84bb1ef8262fc7ea1ee6b0f', '', 'Qwerty2#', 'Qwerty2#', '', '', '', 'Qwerty12@at.at', NULL, 0, 0),
('if17b051', '6c7e4a8193375f6af7b53a759cea552d', '', 'Michael', 'Leithner', '', '', '', 'if17b051@technikum-wien.at', NULL, 0, 1),
('if17b075', 'f31e7db753c0ca7eda79a4a4652665c7', '', 'Barbara', 'LatosiÅ„ska', '', '', '', 'if17b075@technikum-wien.at', NULL, 1, 1),
('test', '1a1dc91c907325c69271ddf0c944bc72', 'test', 'te', 'te', 'te', 'test', 'test', 'test@gmail.com', 1, 0, 0),
('test5', 'e3d704f3542b44a621ebed70dc0efe13', '', 'test5', 'test5', 'test5', 'test5', 'test5', 'test5@gmail.com', 3, 0, 0),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', '', 'user', 'user', '', '', '', 'user@mail.at', NULL, 0, 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`name`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
