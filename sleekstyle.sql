-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 10:51 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sleekstyle`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin'),
(2, 'Taha Farooqui', 'mohdtaha9901@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `t_price` int(11) NOT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `prod_id`, `quantity`, `user_email`, `t_price`, `size`) VALUES
(84, 7, 8, 'mohdtaha9901@gmail.com', 360, 'L');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_desc` varchar(255) NOT NULL,
  `cat_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `cat_desc`, `cat_img`) VALUES
(1, 'Shoes', 'High Quality Shoes', 'img/product/product-1.jpg'),
(2, 'Jacket', 'Imported jackets', 'img/product/product-2.jpg'),
(3, 'Tshirts', 'round neck high quality tshirts', 'img/product/product-3.jpg'),
(4, 'Backpacks', 'leather backpacks', 'img/product/product-4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`) VALUES
(2, 'Taha Farooqui', 'mohdtaha9901@gmail.com', 'hola.');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `discount`, `code`) VALUES
(1, 15, 'abc123');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `product_ids` text NOT NULL,
  `quantities` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `coupon_code` varchar(20) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) NOT NULL,
  `country` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `order_notes` text DEFAULT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_email`, `product_ids`, `quantities`, `total_price`, `payment_method`, `coupon_code`, `discount`, `order_date`, `address`, `country`, `name`, `lastname`, `phone_number`, `order_notes`, `order_status`) VALUES
(1, 'mohdtaha9901@gmail.com', '7,3,2', '2', '530.00', 'COD', NULL, NULL, '2023-12-25 14:28:44', 'shah faisal colony', 'Pakistan', 'deliver fast.', 'Farooqui', '0305 2170267', NULL, ''),
(2, 'mohdtaha9901@gmail.com', '7', '1', '45.00', 'COD', NULL, NULL, '2023-12-25 14:47:17', 'G marao street', 'tanzaniz', '', 'Farooqui', '090078601', NULL, ''),
(3, 'mohdtaha9901@gmail.com', '2', '2', '170.00', 'COD', NULL, NULL, '2023-12-25 19:04:03', 'shah faisal colony', 'Pakistan', 'Taha', 'Farooqui', '0305 2170267', NULL, ''),
(4, 'mohdtaha9901@gmail.com', '3', '3', '225.00', 'COD', NULL, NULL, '2023-12-25 19:10:21', 'shah faisal colony', 'Pakistan', 'Taha', 'Farooqui', '0305 2170267', 'asdasd', ''),
(5, 'mohdtaha9901@gmail.com', '2', '1', '85.00', 'COD', NULL, NULL, '2023-12-25 19:14:59', 'shah faisal colony', 'Pakistan', 'Taha', 'Farooqui', '0305 2170267', 'asdasd', 'Delivered'),
(6, 'mohdtaha9901@gmail.com', '3,6', '6', '645.00', 'COD', 'abc123', '161.25', '2023-12-26 14:49:06', '5/2015', 'Pakistan', 'Ahmed', 'Khan', '03111842026', 'fast deliver.', ''),
(7, 'mohdtaha9901@gmail.com', '6', '6', '420.00', 'COD', 'abc123', '105.00', '2023-12-26 15:15:06', '', '', '', '', '', '', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sizes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `rating`, `price`, `category`, `image`, `label`, `description`, `sizes`) VALUES
(1, 'Piqué Biker Jacket', 4, '70', 'jacket', 'img/product/product-1.jpg', 'New', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'S,L,XL'),
(2, 'Multi-pocket Chest Bag', 5, '85', 'backpacks', 'img/product/product-3.jpg', 'New', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'S,L'),
(3, 'Diagonal Textured Cap', 4, '75', 'backpacks', 'img/product/product-4.jpg', 'Sale', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'S,L,XL,XXL'),
(4, 'Leather Backpack', 3, '100', 'backpacks', 'img/product/product-5.jpg', 'Sale', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'S'),
(5, 'Ankle Boots', 5, '70', 'shoes', 'img/product/product-2.jpg', 'New', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'S,XL'),
(6, 'T-shirt Contrast Pocket', 4, '70', 'tshirts', 'img/product/product-3.jpg', 'New', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'L,XL,XXL'),
(7, 'Basic Flowing Scarf', 5, '45', 'jacket', 'img/product/product-4.jpg', 'New', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'L'),
(8, 'T-shirt Contrast', 5, '89', 'tshirt', 'img/product/product-2.jpg', 'Sale', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'L,XXL'),
(9, 'Boots', 5, '50', 'Shoes', 'img/product/product-6.jpg', 'New', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'S,XL,XXL'),
(10, 'Backpack', 5, '65', 'backpacks', 'img/product/product-3.jpg', 'Sale', '    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur laborum laudantium asperiores totam quo, consequatur maiores, quisquam, amet mollitia minima dolorum autem?', 'S,L,XL,XXL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`) VALUES
(1, 'Taha Farooqui', 'mohdtaha9901@gmail.com', '03111842026', 'taha1134');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
