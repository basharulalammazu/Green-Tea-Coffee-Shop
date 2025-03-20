-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 05:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeeshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `quantity`) VALUES
(2, 0, 1, 100, 1),
(676548, 4, 5, 100, 1),
(676549, 0, 8, 470, 1),
(676550, 0, 9, 550, 1),
(676551, 0, 15, 720, 1),
(676552, 0, 12, 580, 1),
(676554, 0, 13, 990, 1),
(676555, 0, 14, 2590, 1),
(676572, 30, 13, 990, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `phone_number`, `subject`, `message`) VALUES
(1, 5, 'Basharul - Alam - Mazu', 'ba@gmail.com', '01813890622', '', 'Hi! Your price is so hot'),
(2, 19, 'Tanjim', 'Tanjim@hudai.com', '0123456789', '', 'vallage nai');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(500) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL,
  `payment_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `phone_number`, `address`, `address_type`, `method`, `product_id`, `price`, `quantity`, `date`, `status`, `payment_status`) VALUES
(2, 4, 'Basharul - Alam - Mazu', 'basharulalammicrosoft@gmail.com', '01813890622', '135/6/7, Janatbag road, Dhaka, Bangladesh, 1215', '', 'cash on delivery', 1, 100, 1, '2024-12-28', 'pending', 'cancel'),
(4, 4, 'Basharul - Alam - Mazu', 'bas@gmail.com', '01813890622', '135/6/7, Janatbag road, Dhaka, Bangladesh, 1215', 'home', 'cash on delivery', 1, 100, 5, '2024-12-29', 'complete', 'complete'),
(5, 5, 'Basharul - Alam - Mazu', 'basharulalammicrosoft@gmail.com', '01813890622', '135/6/7, Janatbag road, Dhaka, Bangladesh, 1215', 'home', 'mobile banking', 5, 100, 1, '2024-12-29', 'cancel', 'cancel'),
(6, 5, 'Basharul - Alam - Mazu', 'basharulalammicrosoft@gmail.com', '01813890622', '135/6/7, Janatbag road, Dhaka, Bangladesh, 1215', 'home', 'mobile banking', 8, 470, 5, '2024-12-29', 'pending', 'complete'),
(7, 4, 'Basharul - Alam - Mazu', 'ba@gmail.com', '01813890622', '135/6/7, Janatbag road, Dhaka, Bangladesh, 1215', 'home', 'cash on delivery', 5, 100, 1, '2024-12-30', 'delivered', ''),
(8, 4, 'Basharul - Alam - Mazu', 'ba@gmail.com', '01813890622', '135/6/7, Janatbag road, Dhaka, Bangladesh, 1215', 'home', 'cash on delivery', 5, 100, 1, '2025-01-07', '', ''),
(9, 19, 'Reyad', 'abu.jafor12369@gmail.com', '01231231231', '420/5 Mirpur, Mirpur, Dhaka, Bangladesh, 1214', 'home', 'cash on delivery', 13, 990, 1, '2025-01-19', 'cancel', 'pending'),
(10, 30, 'Reyad', 'abu.jafor12369@gmail.com', '01321321321', '512/B, Mirpur, Dhaka, Bangladesh, 1214', 'home', 'cash on delivery', 14, 2590, 5, '2025-01-19', 'complete', 'complete'),
(11, 30, 'Reyad', 'abu.jafor12369@gmail.com', '01321321321', '112/B, Mirpur, Dhaka, Bangladesh, 1214', 'home', 'cash on delivery', 8, 470, 2, '2025-01-20', 'in progress', 'complete'),
(14, 30, 'Reyad', 'abu.jafor12369@gmail.com', '01321321321', '111/A, Mirpur, Dhk, Bd, 1214', 'home', 'cash on delivery', 8, 470, 1, '2025-01-20', 'pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `order_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `size` varchar(50) NOT NULL,
  `price` int(10) NOT NULL,
  `product_details` varchar(1000) NOT NULL,
  `status` varchar(20) NOT NULL,
  `product_category` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `size`, `price`, `product_details`, `status`, `product_category`) VALUES
(5, 'Green Tea', '100 gm', 100, 'Mildly tannic, with pleasant lemony notes. Some of our favorite high quality green tea is grown in the Nilgiri (Blue) Mountains in India, a range known for lush forests and valleys.', 'active', 'Tea'),
(8, 'Keto Green Coffee ', '120 gm', 470, 'This keto green coffee contains 100% pure herbal ingredients, which play an ideal role in weight loss. It also contains green coffee beans, Ganoderma & ginseng extract, which relieves tiredness after eating & boosts immunity. Moreover, it is formulated with ingredients like lotus leaf extract, garcinia cambogia extract & L-carnitine, which can reduce appetite & regulate calorie intake hormones. Above all, it has many other benefits & roles such as inhibiting the fat absorption process in the body as a result of which excess fat is not created in the body.', 'deactive', 'Coffee'),
(12, 'Suayu', '100g', 580, 'arekta coffee', 'active', 'Coffee'),
(13, 'Lipton Green Tea Classic', '100gm', 990, 'Lipton Green Tea Classic Teabags have a vibrant taste that transforms the expected Green experience into a lively, more characterful brew, perfect to drink after your meals. It balances the best of what Green Tea has to offer. Drink in the positivity of an enlivening cup and be awake to what really matters.', 'active', 'Tea'),
(14, 'Robusta Green Coffee', '900gm', 2590, 'Supports Fat metabolism Supports Appetite Suppression & weight management\r\nSupports as Immunity Booster and Anti-oxidant\r\nSupports Low Lipid Levels & healthy Blood Circulation', 'active', 'Coffee'),
(15, 'Sylhet Special Tea', '500g', 720, 'Syheti chaa', 'active', 'Tea');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `password` text NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `password`, `user_type`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$iBMk7goRcadrRfH8xkvWiOq/QAfEIEzJ2nlwX61fGw/8sVGuI.ZIS', 'Admin'),
(2, 'Basharul - Alam - Mazu', 'basharulalammicrosoft@gmail.com', '01813890622', '$2y$10$bPYZ6Rwzp0AIXhenQIIaYeEW/1zilT2PPj6/4xAb9idR/AJ440Wvi', 'Customer'),
(3, 'Basharul - Alam - Mazu', 'b@gmail.com', NULL, '356a192b7913b04c54574d18c28d46e6395428ab', 'Admin'),
(4, 'Basharul - Alam - Mazu', 'ba@gmail.com', '01813890622', '$2y$10$8TECYWXmZnLsDILvP.LqdeS0pP/KBLUF66gd8/eROOCfIa02rRU/m', 'Customer'),
(5, 'Basharul - Alam - Mazu', 'bas@gmail.com', '01813890622', '$2y$10$KN9o5TVvw.IpxlaYxqGH7efT3JslNdB0XzEnFCvzhlGUMgUp4UliO', 'Admin'),
(6, 'Basharul - Alam - Mazu', 'm@gmail.com', NULL, '1', 'Customer'),
(7, 'Basharul - Alam - Mazu', 'ma@gmail.com', NULL, '$2y$10$fhuCNFC5BFB7LGQQKVFOnODwsopQtCtrIGny8iRGxuj', 'Customer'),
(8, 'Basharul - Alam - Mazu', 'a@gmail.com', NULL, '$2y$10$Fty8vtwauEx1jd.BejvP5.wa7uaueT0Cj7aNzf8spy5', 'Admin'),
(9, 'Basharul - Alam - Mazu', 'm1@gmail.com', NULL, '$2y$10$oOCHA8n96yz2LKJsz0u1merg2PWcrhXc7n6nHNDftDF', 'Admin'),
(10, 'Basharul - Alam - Mazu', 'm', NULL, '$2y$10$QcEMuA9h63zScw6LhGsUneR9E9Gu.MRUXAn1opgf8EB', 'Customer'),
(11, 'Basharul - Alam - Mazu', 'bas1@gmail.com', '01813890622', '1', 'Customer'),
(12, 'Basharul - Alam - Mazu', 'b2@gmail.com', '01813890620', '$2y$10$HfDhhp/79/pr5Iw/tBCIhuNtWPyKcliZdjG3skrfdkaBBANlktRSW', 'Customer'),
(13, 'Basharul - Alam -', 'basharulalam6@gmail.com', '01813890622', '$2y$10$/kNEWqSJRTFmIoteidZDsOaVLkAtYpCBif7Z/2D7MO3NIHssy4xLC', 'Customer'),
(14, 'Basharul - Alam -', 'b200@gmail.com', '01813890622', '$2y$10$KeBebSHelUrWCZUDLdYR8.5WjfMSrfOJ1mMIfsMKmkbHPj/StiGuG', 'Customer'),
(15, 'Basharul - Alam - Mazu', 'b8@gmail.com', '01813890622', '$2y$10$PhRqKzIJNh0Ikcw9.9eF3OQbZOy4DX98pGYxzShkLTlSlMi3p4GJa', 'Customer'),
(16, 'Basharul - Alam - Mazu', 'bas10@gmail.com', '01813890622', '$2y$10$sYMxIaHVEmMwwU/jBYyhaORPl.5kVki5JdOCUePq32/UX8kD2YkRq', 'Customer'),
(17, 'mazu', 'mazu@gmail.com', '01813890622', '$2y$10$7Awm2gecc7HG1IhC.oryeOX8AAvEAvgadVrZvjY6gOykY3i0XTbui', 'Customer'),
(29, 'mazumazu', 'mazumazu@gmail.com', '01321321321', '$2y$10$WIGzh/ov8NO8y301fv8Cs.B5WA6meX.m6DalCjC7yVDo8q0tcuah6', 'Admin'),
(30, 'Reyad', 'abu.jafor12369@gmail.com', '01321321321', '$2y$10$NalqNGN4DysXUHpEJQGWuuxgaElYrvp/OEZgl2kB7dMrLSHMsGXli', 'Customer'),
(32, 'Tanjim', 'tanjimtanjim@gmail.com', '01321321420', '$2y$10$OuFx08/Qa4otLB4lgM1BQ.5WvHkLi4zH1C7j5uJF4YHBrrKeIRnLG', 'Admin'),
(33, 'Mazu', 'mazumazumazu@gmail.com', '0132112332112', '$2y$10$zsZzpHDvp/ISDOrLJCSke.p51rqvmdHwUNboyU/eRVNhf7DTMpqiS', 'Admin'),
(44, 'abc', 'abc@gmail.com', '0212312332112', '$2y$10$1MU7e3vs8OdG.K7r6EtvjuDCSRqL4A9g9LMqyP6jqvKlIm1tn.oja', 'Admin'),
(45, 'cdf', 'cdf@gmail.com', '0132323232123', '$2y$10$x0X0hvMMCbWiDGbBlH9pUusb41UyRN4OhdlMzpdya7knn79jqYeuu', 'Admin'),
(46, 'def', 'def@gmail.com', '0123656565656', '$2y$10$vfhv4aHIcgTZD/L4ke5ztenPX7dUgO1J9yBk2JLCVr2qQ/bGf3H9W', 'Admin'),
(47, 'asd', 'asd@gmail.com', '0120202020202', '$2y$10$IH1hIoOLHsF.fXgKIYfUhOann67AkLM6loDbBgSHVjPFW5zzvR3kK', 'Admin'),
(48, 'qwe', 'qwe@gmail.com', '0101010101010', '$2y$10$71eJFuLZhcHFV9DjTW81rOMvd3eTAlcdb/Qkkr3KtI5toVCtKmYbm', 'Admin'),
(49, 'wewe', 'wewe@gmail.com', '0101010101010', '$2y$10$8qpGuYiFfLNstFfjRCkK3eDNJRfu1zRPW9JYXos74GTsxVQMWw5sC', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
(2, 5, 1, 100),
(3, 0, 1, 100),
(4, 4, 1, 100),
(5, 5, 6, 450),
(6, 5, 4, 100),
(7, 0, 6, 450),
(8, 5, 5, 100),
(9, 5, 8, 470),
(10, 4, 5, 100),
(12, 0, 5, 100),
(17, 30, 13, 990);

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
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=676573;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
