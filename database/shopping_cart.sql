-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 02:59 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp2220`
--

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `Item_ID` int(10) UNSIGNED NOT NULL,
  `Item_qty` int(10) NOT NULL,
  `cart_status` int(10) NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_id`, `user_id`, `Item_ID`, `Item_qty`, `cart_status`, `order_id`) VALUES
(1, 6, 1, 1, 2, 1),
(2, 6, 7, 1, 2, 1),
(3, 5, 3, 1, 2, 2),
(4, 5, 6, 1, 2, 2),
(6, 5, 8, 1, 2, 2),
(7, 7, 2, 2, 1, NULL),
(8, 7, 12, 1, 1, NULL),
(9, 3, 6, 1, 2, 3),
(10, 3, 12, 2, 2, 4),
(11, 3, 2, 1, 2, 5),
(12, 3, 5, 1, 2, 6),
(13, 5, 9, 1, 2, 7),
(14, 5, 6, 1, 2, 7),
(15, 5, 7, 1, 2, 8),
(16, 5, 5, 1, 2, 8),
(17, 6, 3, 1, 2, 9),
(18, 6, 1, 1, 2, 10),
(19, 6, 6, 2, 2, 10),
(20, 6, 3, 1, 2, 11),
(21, 6, 5, 1, 2, 11),
(22, 6, 12, 1, 2, 11),
(23, 6, 1, 1, 2, 12),
(24, 6, 6, 1, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user-cart` (`user_id`),
  ADD KEY `menu-cart` (`Item_ID`),
  ADD KEY `cart-orders` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `cart-orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `menu-cart` FOREIGN KEY (`Item_ID`) REFERENCES `menu` (`Item_ID`),
  ADD CONSTRAINT `user-cart` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
