-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2023 at 01:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`, `stock`) VALUES
(257, 16, 21, 'Product1', 100, 4, 'Screenshot_1.png', 4),
(258, 16, 23, 'Product3', 50, 4, 'GACHA OCS.png', 26);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `gcash` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `gcash`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(33, 16, 'Ren', '09194828418', 'rengalorio24@gmail.com', 'cash on delivery', '12345', '2D 2nd St. A. Marcelo Dalandanan, Dalandanan, Valenzuela', ', Product323 (10) , Product424 (5) ', 600, '29-Sep-2023', 'completed'),
(34, 16, 'Ren', '09194828418', 'rengalorio24@gmail.com', 'cash on delivery', '123456', '2D 2nd St. A. Marcelo Dalandanan, Dalandanan, Valenzuela', ', Product222 (1) , Product121 (1) , Product424 (1) , Product323 (1) ', 370, '29-Sep-2023', 'pending'),
(35, 16, 'Ren', '09194828418', 'rengalorio24@gmail.com', 'cash on delivery', '12356468789', '2D 2nd St. A. Marcelo Dalandanan, Dalandanan, Valenzuela', ', Product222 (1) , Product121 (1) , Product424 (3) ', 360, '29-Sep-2023', 'pending'),
(36, 16, 'Ren', '123', 'rengalorio24@gmail.com', 'cash on delivery', '123', '2D 2nd St. A. Marcelo Dalandanan, 123, Iloilo', ', Product323 (1) , Product222 (1) ', 250, '29-Sep-2023', 'pending'),
(37, 16, 'Renante H Galorio', '123', 'rengalorio24@gmail.com', 'cash on delivery', '1231', '2D 2nd St. A. Marcelo Dalandanan, 123, Iloilo', ', Product323 (1) ', 50, '29-Sep-2023', 'pending'),
(38, 16, 'Renante H Galorio', '123123', 'rengalorio24@gmail.com', 'cash on delivery', '213', '2D 2nd St. A. Marcelo Dalandanan, 12321, Iloilo', ', Product323 (1) , Product424 (1) ', 120, '29-Sep-2023', 'pending'),
(39, 16, 'Renante H Galorio', '12312312', 'rengalorio24@gmail.com', 'cash on delivery', '123123', '2D 2nd St. A. Marcelo Dalandanan, 12321312, IloIlo', ', Product424 (1) , Product121 (1) ', 170, '29-Sep-2023', 'pending'),
(40, 16, 'Renante H Galorio', '123123', 'rengalorio24@gmail.com', 'cash on delivery', '123', '2D 2nd St. A. Marcelo Dalandanan, 123, Cabanatuan', ', Product121 (1) , Product424 (1) ', 170, '29-Sep-2023', 'pending'),
(41, 16, 'Renante H Galorio', '123', 'rengalorio24@gmail.com', 'cash on delivery', '123', '2D 2nd St. A. Marcelo Dalandanan, 213, cavite', ', Product121 (1) , Product424 (1) ', 170, '29-Sep-2023', 'completed'),
(42, 16, 'Renante H Galorio', '12312', 'rengalorio24@gmail.com', 'cash on delivery', '123', '2D 2nd St. A. Marcelo Dalandanan, 123, cavite', ', Product121 (1) , Product424 (1) ', 170, '29-Sep-2023', 'completed'),
(43, 16, 'Renante H Galorio', '213', 'rengalorio24@gmail.com', 'cash on delivery', '123', '2D 2nd St. A. Marcelo Dalandanan, asd, valenzuela', ', Product424 (1) , Product222 (1) ', 220, '29-Sep-2023', 'completed'),
(44, 16, 'REN', '123123', 'rengalorio24@gmail.com', 'cash on delivery', '213', '2D 2nd St. A. Marcelo Dalandanan, 123123, mandaluyong', ', Product222 (1) , Product121 (1) ', 800, '29-Sep-2023', 'completed'),
(45, 16, 'Ren', '09194828418', 'rengalorio24@gmail.com', 'cash on delivery', '458458412584', '2nd St, Dalandanan, valenzuela', ', Product222 (1) , Product121 (12) , Product323 (3) ', 1550, '29-Sep-2023', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `stock` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `stock`, `image`) VALUES
(21, 'Product1', 'Product1', 100, 4, 'Screenshot_1.png'),
(22, 'Product2', 'Product2', 200, 20, '384280945_1210381553685707_6029088701548123124_n.jpg'),
(23, 'Product3', 'Product3\r\n', 50, 26, 'GACHA OCS.png'),
(24, 'Product4', 'Product4', 20, 31, 'mUrJDA.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `code` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `code`, `image`, `user_type`) VALUES
(16, 'renggg24', 'rengalorio24@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '443265', '', 'user'),
(17, 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '439618', '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
