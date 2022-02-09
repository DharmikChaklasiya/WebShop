-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 10. Jun 2018 um 23:03
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
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user` varchar(32) CHARACTER SET utf8 NOT NULL,
  `fk_voucher` varchar(5) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`order_id`, `date`, `user`, `fk_voucher`) VALUES
(1, '2018-06-10', 'user5', NULL),
(2, '2018-06-10', 'user5', NULL);

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
('affenkopf.jpg', 'red', 2.5, 'Available', 4.5),
('baby.jpg', 'white', 2, 'Available', 1),
('cypripedium.jpg', 'red', 2, 'Available', 4),
('derwisch.jpg', 'white', 3, 'Available', 1),
('dracula_orchidee.jpg', 'red', 3.5, 'Not available', 5),
('figure.jpg', 'red', 2, 'Available', 4.5),
('gebirgeorchidee.jpg', 'orange', 4, 'Not available', 5),
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
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) DEFAULT '0',
  `is_ldap` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`username`, `pwd`, `anrede`, `vorname`, `nachname`, `adresse`, `plz`, `ort`, `email`, `zahlung`, `is_active`, `is_admin`, `is_ldap`) VALUES
('Qwerty12#', 'dc2e1a3ea84bb1ef8262fc7ea1ee6b0f', '', 'Qwerty2#', 'Qwerty2#', '', '', '', 'Qwerty12@at.at', NULL, 0, 0, 0),
('if17b051', '6c7e4a8193375f6af7b53a759cea552d', '', 'Michael', 'Leithner', '', '', '', 'if17b051@technikum-wien.at', NULL, 0, 0, 1),
('if17b075', 'f31e7db753c0ca7eda79a4a4652665c7', '', 'Barbara', 'LatosiÅ„ska', '', '', '', 'if17b075@technikum-wien.at', NULL, 0, 1, 1),
('test', '1a1dc91c907325c69271ddf0c944bc72', 'test', 'te', 'te', 'te', 'test', 'test', 'test@gmail.com', 1, 1, 0, 0),
('test5', 'e3d704f3542b44a621ebed70dc0efe13', '', 'test5', 'test5', 'test5', 'test5', 'test5', 'test5@gmail.com', 3, 1, 1, 0),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', '', 'user', 'user', '', '', '', 'user@mail.at', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vouchers`
--

CREATE TABLE `vouchers` (
  `code` varchar(5) COLLATE utf8_bin NOT NULL,
  `status` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `vouchers`
--

INSERT INTO `vouchers` (`code`, `status`, `value`, `date`) VALUES
('E0O2O', 0, 0, '1970-01-01'),
('MzsfA', 0, 0, '2018-06-09'),
('bFcs2', 0, 0, '0000-00-00'),
('dIHNV', 0, 0, '2018-06-28'),
('gHR5m', 0, 0, '2018-06-10');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `user` (`user`),
  ADD KEY `fk_vourcher` (`fk_voucher`);

--
-- Indizes für die Tabelle `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order` (`fk_order`),
  ADD KEY `fk_produkt` (`fk_product`);

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

--
-- Indizes für die Tabelle `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`code`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT für Tabelle `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`fk_voucher`) REFERENCES `vouchers` (`code`);

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
