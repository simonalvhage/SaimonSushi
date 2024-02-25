-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1:3306
-- Tid vid skapande: 25 feb 2024 kl 21:30
-- Serverversion: 10.6.16-MariaDB-cll-lve
-- PHP-version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `u191649926_saimonsushi`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `text` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumpning av Data i tabell `menu`
--

INSERT INTO `menu` (`id`, `heading`, `text`, `image_url`, `price`) VALUES
(1, 'Udon nudlar', 'Stekt udon (vetenudlar), ägg, grönsaker, salladslök och sesammix', 'https://www.fbgcdn.com/pictures/22bcd7ba-ff4a-4fd7-9a59-3941c5394900_d2.jpg', 105.00),
(2, 'Teriyaki Kyckling', 'Stekt teriyakimarinerad kyckling. Serveras med ris och salladsmix.', 'https://www.fbgcdn.com/pictures/e624d77e-2078-49fe-83a9-645d57307bc0_d2.jpg', 155.00),
(3, 'Teryaki Lax', 'Stekt teriyakimarinerad lax. Serveras med ris och salladsmix.', 'https://www.fbgcdn.com/pictures/b3835035-c518-406a-86c1-b1c28cfdade7_d2.jpg', 155.00),
(4, 'Yakiniku', 'Strimlad entrecote chilimayo, söt sojasås, sesammix. Serveras med ris och salladsmix.', 'https://www.fbgcdn.com/pictures/06d06101-69c2-47a2-9285-1b981ac99ad5_d2.jpg', 155.00);

-- --------------------------------------------------------

--
-- Tabellstruktur `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`order_id`, `table_id`, `order_time`, `total_price`) VALUES
(30, 5, '2024-02-25 21:23:06', 0.00),
(31, 1, '2024-02-25 21:23:18', 0.00),
(32, 2, '2024-02-25 21:23:37', 0.00);

-- --------------------------------------------------------

--
-- Tabellstruktur `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `dish_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumpning av Data i tabell `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `dish_name`, `quantity`, `price`) VALUES
(25, 30, 'Udon nudlar', 1, 105.00),
(26, 30, 'Teriyaki Kyckling', 3, 155.00),
(27, 30, 'Teryaki Lax', 2, 155.00),
(28, 30, 'Yakiniku', 1, 155.00),
(29, 31, 'Udon nudlar', 2, 105.00),
(30, 31, 'Teryaki Lax', 2, 155.00),
(31, 32, 'Udon nudlar', 1, 105.00),
(32, 32, 'Teriyaki Kyckling', 1, 155.00);

-- --------------------------------------------------------

--
-- Tabellstruktur `tables`
--

CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumpning av Data i tabell `tables`
--

INSERT INTO `tables` (`table_id`, `table_number`, `status`) VALUES
(1, 1, 'available'),
(2, 2, 'available'),
(3, 3, 'available'),
(4, 4, 'available'),
(5, 5, 'available');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `table_id` (`table_id`);

--
-- Index för tabell `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Index för tabell `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT för tabell `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT för tabell `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`);

--
-- Restriktioner för tabell `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
