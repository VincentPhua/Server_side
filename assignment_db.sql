-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 03:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `receiver_name` varchar(50) NOT NULL,
  `receiver_email` varchar(50) NOT NULL,
  `receiver_phone` varchar(20) NOT NULL,
  `delivery_addr` varchar(255) NOT NULL,
  `subtotal` decimal(7,2) NOT NULL,
  `order_time` datetime NOT NULL,
  `payment_method` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `method_id` int(3) NOT NULL,
  `method_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`method_id`, `method_name`) VALUES
(1, 'Cash'),
(2, 'Credit Card'),
(3, 'Online Banking'),
(4, 'E-Wallet');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `rrp` decimal(7,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `submittedby` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `rrp`, `quantity`, `image_name`, `date_created`, `submittedby`) VALUES
(1, 'Luxury Smart Watch', '<p>Unique watch made with stainless steel, ideal for those that prefer interactive watches.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Powered by Android with built-in apps.</li>\r\n<li>Adjustable to fit most.</li>\r\n<li>Long battery life, continuous wear for up to 2 days.</li>\r\n<li>Lightweight design, comfort on your wrist.</li>\r\n</ul>', 79.99, 109.99, 10, 'luxsmartwatch.jpg', '2024-03-27 13:01:16', 'Vincent'),
(2, 'Headphone', '<p>Immersive sound experience with our latest headphones, perfect for music enthusiasts.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Crystal clear sound quality.</li>\r\n<li>Ergonomic design for long-lasting comfort.</li>\r\n<li>Compatible with all devices.</li>\r\n<li>Adjustable headband for a personalized fit.</li>\r\n</ul>', 49.99, 0, 20, 'headphone.jpg', '2024-03-27 13:13:52', 'Vincent'),
(3, 'Digital Camera', '<p>Capture life\'s moments in stunning detail with our high-resolution digital camera.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Professional-grade image quality.</li>\r\n<li>Multiple shooting modes for versatility.</li>\r\n<li>Compact and lightweight design.</li>\r\n<li>Easy sharing with built-in Wi-Fi.</li>\r\n</ul>', 349.99, 449.99, 5, 'camera.jpg', '2024-03-27 13:21:02', 'Vincent'),
(4, 'Phone Case', '<p>Protect your phone in style with our durable and fashionable phone cases.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Shock-absorbent materials.</li>\r\n<li>Precision cutouts for easy access to ports and buttons.</li>\r\n<li>Slim and lightweight design.</li>\r\n</ul>', 36.99, 59.99, 30, 'phonecase.jpg', '2024-03-27 13:11:46', 'Vincent'),
(5, 'Adapter', '<p>Stay connected wherever you go with our versatile universal adapter.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Compatible with multiple plug types.</li>\r\n<li>Compact and portable for travel.</li>\r\n<li>Built-in surge protection.</li>\r\n<li>Sturdy construction for durability.</li>\r\n</ul>', 19.99, 29.99, 35, 'adapter.jpg', '2024-03-27 13:23:56', 'Vincent'),
(6, 'USB-C Cable', '<p>Ensure fast and reliable charging with our high-quality USB-C cable.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Supports fast data transfer.</li>\r\n<li>Durable braided design.</li>\r\n<li>Reinforced connectors for long-lasting use.</li>\r\n<li>Available in various lengths.</li>\r\n</ul>', 5.99, 0, 40, 'cable.jpg', '2024-03-27 13:28:09', 'Vincent'),
(7, 'Car Phone Holder Mount', '<p>Keep your phone secure and accessible while driving with our convenient car phone holder mount.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>360-degree rotation for flexible viewing angles.</li>\r\n<li>Strong suction cup for stable attachment.</li>\r\n<li>Adjustable arm to fit different devices.</li>\r\n<li>Easy installation and removal.</li>\r\n</ul>', 19.99, 0, 40, 'phoneholder.jpg', '2024-03-27 13:32:33', 'Vincent'),
(8, 'Wireless Charger', '<p>Experience the future of charging with our efficient wireless charger.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Fast and convenient charging without cables.</li>\r\n<li>Universal compatibility with Qi-enabled devices.</li>\r\n<li>LED indicator light for charging status.</li>\r\n<li>Sleek and compact design.</li>\r\n</ul>', 99.99, 0, 25, 'charger.jpg', '2024-03-27 13:40:46', 'Vincent');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(50) NOT NULL,
  `staff_email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `staff_email`, `password`, `reg_date`) VALUES
(1, 'Vincent', 'Vincent@email.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-03-19 15:42:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `payment_method` (`payment_method`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`method_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `method_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`payment_method`) REFERENCES `payment_method` (`method_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
