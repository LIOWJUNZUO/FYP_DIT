-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2023 at 07:13 PM
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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_totalprice` decimal(10,2) NOT NULL,
  `order_receiver_name` varchar(150) NOT NULL,
  `order_receiver_email` varchar(150) NOT NULL,
  `order_receiver_phone` varchar(20) NOT NULL,
  `order_receiver_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `user_id`, `order_totalprice`, `order_receiver_name`, `order_receiver_email`, `order_receiver_phone`, `order_receiver_address`, `order_date`, `order_status`) VALUES
(1, 'PO202305231819526', 6, '46.80', 'Test001', 'Testing001@email.com', '0123456789', '123 Jalan MMU', '2023-05-24 00:19:52', 1),
(2, 'PO202305240041057', 7, '39.00', 'Test002', 'Testing002@email.com', '0123456789', '28 Jalan D3 Taman Dahlia Bukit Beruang, 75450 Ayer Keroh, Malacca', '2023-05-24 00:41:05', 1),
(3, 'PO202305240046257', 7, '25.30', 'Test002', 'Testing002@email.com', '0123456789', '30 Jalan D3A Taman Dahlia Bukit Beruang, 75450 Ayer Keroh, Malacca', '2023-05-24 00:46:25', 1),
(4, 'PO202305240051041', 1, '21.00', 'Tan', 'tan@gmail.com', '0125896358', '123, Jalan Ayer Keroh Lama, 75450 Bukit Beruang, Melaka', '2023-05-24 00:51:04', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order-user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order-user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
