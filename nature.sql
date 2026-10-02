-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 02, 2026 at 04:19 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nature`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` varchar(100) DEFAULT NULL,
  `cart_product` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `total_price`, `cart_product`) VALUES
(1, 7, NULL, NULL),
(2, 7, '2295', NULL),
(3, 7, '6502.5', NULL),
(4, 11, NULL, NULL),
(5, 11, '675', NULL),
(6, 11, '675', NULL),
(7, 11, '675', NULL),
(8, 11, '2970', NULL),
(9, 11, '2160', NULL),
(10, 11, '1530', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int NOT NULL,
  `cart_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `product_quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `order_date`, `status`) VALUES
(1, 11, 750.00, '2026-10-02 03:10:25', 'Pending'),
(2, 11, 750.00, '2026-10-02 03:10:28', 'Pending'),
(3, 11, 750.00, '2026-10-02 03:12:57', 'Pending'),
(4, 11, 750.00, '2026-10-02 03:13:24', 'Pending'),
(5, 11, 3300.00, '2026-10-02 03:21:29', 'Completed'),
(6, 11, 2400.00, '2026-10-02 04:04:41', 'Pending'),
(7, 11, 1700.00, '2026-10-02 04:10:11', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `product_quantity`, `price`) VALUES
(1, 3, 9, 1, 750.00),
(2, 4, 9, 1, 750.00),
(3, 5, 2, 1, 900.00),
(4, 5, 10, 1, 2400.00),
(5, 6, 10, 1, 2400.00),
(6, 7, 11, 1, 1700.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(900) NOT NULL,
  `seller_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `image`, `description`, `seller_id`) VALUES
(1, 'Rachio Smart Hose Timer', 700, '../images/image1.jpg', 'Kit comes with one valve and one WiFi Hub. Timer valves require a WiFi Hub and two AA batteries (not included). This device only works with 2.4 GHz WiFi network.', NULL),
(2, 'Orbit B-hyve', 900, '../images/image2.jpg', 'offers weather-based irrigation scheduling and can be managed through a mobile app. It supports voice control with Amazon Alexa and allows for remote control and monitoring of your irrigation system.', NULL),
(3, 'RainMachine Touch HD-12', 850, '../images/image3.jpg', 'This smart sprinkler controller features a touchscreen interface and uses weather data to adjust watering schedules. It offers app control, weather-based scheduling, and integration with smart home systems like Google Home and Amazon Alexa.', NULL),
(4, 'Netro Smart Sprinkler Controller', 1200, '../images/image4.jpg', 'The Netro controller is designed for easy installation and operation. It uses weather forecasts and historical data to create efficient watering schedules. The device can be controlled through a mobile app and supports voice commands via Google Assistant and Amazon Alexa.', NULL),
(5, 'Hunter Hydrawise Wi-Fi Irrigation Controller', 1115, '../images/image5.jpg', 'Hunter\'s Hydrawise controller offers advanced water-saving features, including predictive watering based on weather forecasts. It can be managed through a mobile app and integrates with smart home systems for convenient control and monitoring.', NULL),
(6, 'Eve Aqua Smart Water Controller', 980, '../images/image6.jpg', 'The Eve Aqua is a smart water controller that can be attached to any outdoor faucet. It allows you to control your watering schedule via an app and supports automation with Apple HomeKit, enabling voice control with Siri.\r\n', NULL),
(7, 'Blossom 7 Smart Watering Controller', 750, '../images/image7.jpg', 'Blossom\'s smart watering controller uses weather data and plant types to create efficient watering schedules. It can be controlled via a mobile app and helps reduce water usage while keeping your garden healthy.', NULL),
(8, 'GreenIQ Smart Garden Hub', 780, '../images/image8.jpg', 'The GreenIQ Hub connects to various sensors and smart devices to optimize your irrigation system. It uses weather forecasts to adjust watering schedules and supports integration with smart home systems and IoT devices.', NULL),
(9, 'Aeon Matrix Yardian Pro', 750, '../images/image9.jpg', 'The Yardian Pro is a smart sprinkler controller that offers real-time weather adjustments, remote control via a mobile app, and integration with security cameras for additional home monitoring features.', NULL),
(10, 'wheel barrow', 2400, '../images/wheelbarrow.png', 'wheel ', 10),
(11, 'Jigsaw', 1700, '../images/jigsaw.png', 'cutting wood', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'Customer',
  `firstname` varchar(60) NOT NULL,
  `middlename` varchar(60) DEFAULT NULL,
  `lastname` varchar(60) NOT NULL,
  `contact` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `role`, `firstname`, `middlename`, `lastname`, `contact`, `email`, `username`, `password`, `token`) VALUES
(1, 'Admin', 'Rojan', '', 'Maharjan', '9803549098', 'rojanmaharjan@gmail.com', 'rojan', 'rojanmhzn', '640301'),
(10, 'seller', 'Avash', '', 'Khadka', '9800000000', 'seller@gmail.com', 'avash', 'avash123', '100001'),
(11, 'Customer', 'Vision', '', 'Maharjan', '9803549098', 'vision777maharjan@gmail.com', 'vision', 'vision123', '403745');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_seller` (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_seller` FOREIGN KEY (`seller_id`) REFERENCES `users` (`userid`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
