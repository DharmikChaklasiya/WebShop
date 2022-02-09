-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 10. Jun 2018 um 21:12
-- Server-Version: 10.1.31-MariaDB
-- PHP-Version: 7.2.3

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
-- Tabellenstruktur für Tabelle `order_product`
--

CREATE TABLE `order_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fk_order` bigint(20) UNSIGNED NOT NULL,
  `fk_product` varchar(32) CHARACTER SET utf8 NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `order_product`
--

INSERT INTO `order_product` (`id`, `fk_order`, `fk_product`, `count`) VALUES
(14, 1, 'derwisch.jpg', 5),
(15, 2, 'baby.jpg', 3);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order` (`fk_order`),
  ADD KEY `fk_produkt` (`fk_product`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`fk_order`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`fk_product`) REFERENCES `products` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
