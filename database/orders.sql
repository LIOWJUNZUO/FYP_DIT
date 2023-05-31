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
(1, 'PO202305242211076', 6, '18.20', 'Test001', 'Testing001@email.com', '012-345-6789', 'No 20, Jalan D7, 75450 Bukit Beruang, Melaka', '2023-05-24 22:11:07', 1),
(2, 'PO202305242217435', 5, '29.90', 'Josh Lim', 'lim@gmail.com', '01128252182', '20, Jalan SS1, Taman Seri Selendang, Melaka City, 75350, Melaka', '2023-05-24 22:17:43', 1),
(3, 'PO202305250016293', 3, '6.90', 'Yuu', 'yuu@gmail.com', '0125896586', '4, Jalan TU 2, 75450 Ayer Keroh, Melaka', '2023-05-25 00:16:29', 1),
(4, 'PO202305250019303', 3, '25.00', 'Yuu', 'yuu@gmail.com', '0125896586', '4, Jalan TU 2, 75450 Ayer Keroh, Melaka', '2023-05-25 00:19:30', 1),
(5, 'PO202305250026213', 3, '9.70', 'Yuu', 'yuu@gmail.com', '0125896586', '4, Jalan TU 2, 75450 Ayer Keroh, Melaka', '2023-05-25 00:26:21', 1),
(6, 'PO202305250040333', 3, '9.70', 'Xiao Yuu', 'yuu@gmail.com', '0125896586', '4, Jalan TU 2, 75450 Ayer Keroh, Melaka', '2023-05-25 00:40:33', 1),
(7, 'PO202305250049205', 5, '21.40', 'Lim Lerk', 'lim@gmail.com', '0124589635', '20, Jalan SS1, Taman Seri Selendang, Melaka City, 75350, Melaka', '2023-05-25 00:49:20', 1),
(8, 'PO202305250054495', 5, '21.00', 'Lim Lerk', 'lim@gmail.com', '0124589635', '20, Jalan SS1, Taman Seri Selendang, Melaka City, 75350, Melaka', '2023-05-25 00:54:49', 1),
(9, 'PO202305251627416', 6, '12.80', 'Test001', 'Testing001@email.com', '012-345-6789', '123 Jalan MMU', '2023-05-25 16:27:41', 1),
(10, 'PO202305260912556', 6, '20.70', 'Test001', 'Testing001@email.com', '01128582188', '123 Jalan MMU', '2023-05-26 09:12:56', 1),
(11, 'PO202305301756446', 6, '35.00', 'Test001', 'Testing001@email.com', '01128582188', '4, Jalan TU 2, 75450 Ayer Keroh, Melaka', '2023-05-30 17:56:44', 1),
(12, 'PO202305310152096', 6, '6.90', 'Test001', 'Testing001@email.com', '01128582188', '4, Jalan TU 2, 75450 Ayer Keroh, Melaka', '2023-05-31 01:52:09', 1);

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
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
