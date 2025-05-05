-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 18, 2024 at 07:29 PM
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
-- Database: `joshianadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`username`, `password`) VALUES
('admin', '654413');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `college` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone1` varchar(20) NOT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `degree` varchar(25) NOT NULL,
  `department` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `college`, `email`, `phone1`, `phone2`, `degree`, `department`, `order_id`, `payment_id`, `total_amount`, `created_at`) VALUES
(1, 'afdlakfh', 'jkdfh@gmail.com', '8618298130', '9008659494', '', 'mca', 'order_Om1ckF6T8Lqoov', 'pay_Om1cpkpqbyxWSp', 10000.00, '2024-08-17 17:05:40'),
(2, 'afdlakfh', 'jkdfh@gmail.com', '8618298130', '9008659494', '', 'mca', 'order_Om2obp9SVGJkwx', 'pay_Om2ohm8OueQuid', 20000.00, '2024-08-17 17:13:06'),
(3, 'wxsdx', 'wsx@gmail.com', '8618298130', '9008659494', 'ug', 'BSC', 'order_OmFcSAUGHQqUH6', 'pay_OmFcbR7zmod3RT', 600.00, '2024-08-18 05:45:51'),
(4, 'wxsdx', 'wsx@gmail.com', '8618298130', '9008659494', 'pg', 'MCA', 'order_OmG1yDWSD0ziql', 'pay_OmG26kaVmJTKfd', 450.00, '2024-08-18 06:08:47'),
(5, 'wxsdx', 'wsx@gmail.com', '8618298130', '9008659494', 'pg', 'MCA', 'order_OmGCtTyAlH5IQ1', 'pay_OmGD0wcVk0KJKY', 300.00, '2024-08-18 06:19:07'),
(6, '6-55-11 Gaurav nivasa 1st block Jayanagar ,Kodical', 'gauravr8402@gmail.com', '8618298130', '4534235378', 'pg', 'MCA', 'order_OmPR981fXHzRsU', 'pay_OmPRNjKbSoQhhV', 2880.00, '2024-08-18 15:20:58'),
(7, 'wdxs', 'wxd@gmail.com', '8618298130', '9008659494', 'ug', 'BCA', 'order_OmRYs2Vr7eGvHC', 'pay_OmRYyHiEh3HlRu', 300.00, '2024-08-18 17:25:32');

-- --------------------------------------------------------

--
-- Table structure for table `event_details`
--

CREATE TABLE `event_details` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `participants` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_details`
--

INSERT INTO `event_details` (`id`, `order_id`, `event_name`, `participants`, `created_at`) VALUES
(1, 'order_Om1ckF6T8Lqoov', 'astrohack', 'fbvfd', '2024-08-17 17:05:40'),
(2, 'order_Om2obp9SVGJkwx', 'galactic webcraft', 'dsxds,sxsdx', '2024-08-17 17:13:06'),
(3, 'order_Om2obp9SVGJkwx', 'quantum query', 'efcfe,sasxds', '2024-08-17 17:13:06'),
(4, 'order_OmFcSAUGHQqUH6', 'galactic webcraft', 'dvdf,fdvfg,fdvfd,fdvfdv,fdvfdhjyn,gngbg', '2024-08-18 05:45:51'),
(5, 'order_OmFcSAUGHQqUH6', 'COSMIC BEAT', 'fdvd,fdvdv', '2024-08-18 05:45:51'),
(6, 'order_OmFcSAUGHQqUH6', 'STELLER STORIES', 'nhghhgn', '2024-08-18 05:45:51'),
(7, 'order_OmFcSAUGHQqUH6', 'astrohack', 'gfbfg', '2024-08-18 05:45:51'),
(8, 'order_OmG1yDWSD0ziql', 'Select Event*', 'fhgf,fdgffg', '2024-08-18 06:08:47'),
(9, 'order_OmG1yDWSD0ziql', 'galactic webcraft', 'fbgfb,bdgffg', '2024-08-18 06:08:47'),
(10, 'order_OmG1yDWSD0ziql', 'galactic webcraft', '', '2024-08-18 06:08:47'),
(11, 'order_OmGCtTyAlH5IQ1', 'quantum query', 'dfc,dfr', '2024-08-18 06:19:07'),
(12, 'order_OmGCtTyAlH5IQ1', 'quantum query', 'rfcfr,fcdc', '2024-08-18 06:19:07'),
(13, 'order_OmPR981fXHzRsU', 'galactic webcraft', 'cfdvfd,dsfdsf,fdvfd,hggbf,fvbgf,fbgf', '2024-08-18 15:20:58'),
(14, 'order_OmPR981fXHzRsU', 'COSMIC BEAT', 'fdvfd,fdfdv', '2024-08-18 15:20:58'),
(15, 'order_OmPR981fXHzRsU', 'galactic webcraft', 'gfbgf,fgbgf', '2024-08-18 15:20:58'),
(16, 'order_OmPR981fXHzRsU', 'galactic webcraft', 'fbgf,fgbfg', '2024-08-18 15:20:58'),
(17, 'order_OmPR981fXHzRsU', 'galactic webcraft', 'fbfb,ffgbgf', '2024-08-18 15:20:58'),
(18, 'order_OmPR981fXHzRsU', 'galactic webcraft', 'bgfbgf,gfbf', '2024-08-18 15:20:58'),
(19, 'order_OmPR981fXHzRsU', 'quantum query', 'fbgf,fgbgf', '2024-08-18 15:20:58'),
(20, 'order_OmPR981fXHzRsU', 'galactic webcraft', 'bbfbgn,hnhg', '2024-08-18 15:20:58'),
(21, 'order_OmPR981fXHzRsU', 'quantum query', 'nbhgn,hnhg', '2024-08-18 15:20:58'),
(22, 'order_OmPR981fXHzRsU', 'galactic webcraft', 'hgngn,nhgn', '2024-08-18 15:20:58'),
(23, 'order_OmRYs2Vr7eGvHC', 'astrohack', 'fdvfdv', '2024-08-18 17:25:32'),
(24, 'order_OmRYs2Vr7eGvHC', 'STELLER STORIES', 'fdvfdv', '2024-08-18 17:25:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `event_details`
--
ALTER TABLE `event_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_details`
--
ALTER TABLE `event_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_details`
--
ALTER TABLE `event_details`
  ADD CONSTRAINT `event_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `events` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
