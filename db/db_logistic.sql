-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2020 at 08:02 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_logistic`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `name`, `email`, `created_at`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', 'admin@admin.com', '2019-12-24 04:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `custom_id` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `creator_type` int(11) DEFAULT NULL COMMENT '1=admin,2=station',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `password`, `name`, `email`, `contact_number`, `custom_id`, `company_name`, `country`, `state`, `city`, `post_code`, `address`, `creator_type`, `created_by`, `created_at`) VALUES
(1, 'customer12', 'e10adc3949ba59abbe56e057f20f883e', 'Omor  Farukq', 'customer@gmail.comq', '019876543212', 'LMS336325022', 'IOTA ITw', 'Bangladeshw', 'Dhakaw', 'Dhakaw', '1229w', 'Nikunja, Nikunja-2 Dhakaw', NULL, NULL, '2019-12-26 04:14:08'),
(3, 'adminew', 'e10adc3949ba59abbe56e057f20f883e', 'Omor  Faruk', 'customer@gmail.com', '01987654321', 'LMS35389028', 'IOTA IT', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', NULL, NULL, '2019-12-26 04:43:16'),
(5, 'Customer Station1', 'd41d8cd98f00b204e9800998ecf8427e', 'Station Customer', 'customerS@a.com', '01987654321', 'LMS29471422', 'IOTA IT', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', 2, 2, '2019-12-28 10:38:00'),
(6, 'stcustomer', 'c33367701511b4f6020ec61ded352059', 'Station Customer 2', 'stcustomer2@gmail.com', '01987654322', 'LMS77866193', 'IOTA IT', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', 2, 2, '2019-12-30 03:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL COMMENT '1=Lorry/truck, 2=motorcycle',
  `zone` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `username`, `password`, `name`, `email`, `contact_number`, `vehicle_number`, `vehicle_type`, `zone`, `image_path`, `country`, `state`, `city`, `post_code`, `address`, `created_at`) VALUES
(1, 'driver1', 'e10adc3949ba59abbe56e057f20f883e', 'Driver Name', 'driver@gmail.com', '01987654321', 'Reg1234556', 'Motocycle', 'Dhaka', '', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-26 04:51:59'),
(3, 'driver123', '98c807929d21ec94ac60befdb7f00d92', 'Driver Name', 'driver@gmail.com', '01987654321', 'Reg1234556', 'Motocycle', 'Dhaka', '', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-26 04:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `driver_requests`
--

CREATE TABLE `driver_requests` (
  `id` int(11) NOT NULL,
  `tracking_number_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `unique_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `primary_email` varchar(255) DEFAULT NULL,
  `secondary_email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `username`, `password`, `unique_id`, `name`, `primary_email`, `secondary_email`, `contact_number`, `country`, `state`, `city`, `post_code`, `address`, `created_at`) VALUES
(2, 'station', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Demo Station', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:33'),
(4, 'station1fr', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(5, 'station1frd', 'd41d8cd98f00b204e9800998ecf8427e', 'Sta12', 'Station Name2', 'p.email@email.comw', 's.email@email.comw', '019876543211', 'Bangladesh2', 'Dhakaw', 'Dhakaw', '1229s', 'Nikunja, Nikunja-2 Dhakas', '2019-12-24 05:29:56'),
(6, 'station1frdsfdc', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(7, 'station1frdsfdcdfv', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(8, 'station1frvc', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(9, 'station1frvcdghn', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(10, 'station1frvcdghnsg', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(11, 'station1frdfsvcdghnsg', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(12, 'station1frddfsfsvcdghnsg', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(13, 'station1frddf', 'e10adc3949ba59abbe56e057f20f883e', 'Sta1', 'Station Name', 'p.email@email.com', 's.email@email.com', '01987654321', 'Bangladesh', 'Dhaka', 'Dhaka', '1229', 'Nikunja, Nikunja-2 Dhaka', '2019-12-24 05:29:56'),
(14, NULL, NULL, NULL, 'Awaiting Pick-Up', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-26 07:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `station_prefix`
--

CREATE TABLE `station_prefix` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `station_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `station_prefix`
--

INSERT INTO `station_prefix` (`id`, `name`, `station_id`, `created_at`) VALUES
(1, 'SA', 2, '2019-12-26 06:45:30'),
(2, 'SA2', 5, '2019-12-26 06:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `others` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `others`, `created_at`) VALUES
(1, 'Awaiting Pick-Up', NULL, '2019-12-26 07:24:12'),
(2, 'In Transit', NULL, '2019-12-26 07:24:36'),
(3, 'In Warehouse', NULL, '2019-12-26 07:24:52'),
(4, 'On Route', NULL, '2019-12-26 07:25:11'),
(5, 'Delivered', NULL, '2019-12-26 07:25:25'),
(6, 'Out To Delivery', NULL, '2019-12-26 07:25:45'),
(7, 'Fail To Delivery', NULL, '2019-12-26 07:26:01'),
(8, 'Receiver Refused To Accept', NULL, '2019-12-26 07:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `tracking_numbers`
--

CREATE TABLE `tracking_numbers` (
  `id` int(11) NOT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `station_prefix_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `date_stamp` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `remark` mediumtext DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `parcel_type` int(11) DEFAULT NULL COMMENT '1=Parcel,2=Document,3=Heavy Shipment',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracking_numbers`
--

INSERT INTO `tracking_numbers` (`id`, `tracking_number`, `station_prefix_id`, `status_id`, `date_stamp`, `image_path`, `remark`, `sender_id`, `receiver_id`, `parcel_type`, `created_at`) VALUES
(2, 'A000012324', 1, 1, '1578006000', 'upload/fd459e2c87.jpg', ' after', 1, 3, NULL, '2019-12-28 04:59:12'),
(3, 'A001', 1, 2, '1575932400', 'upload/3719263cb0.jpg', 'sfgvwe', 6, 5, NULL, '2019-12-28 04:59:12'),
(4, 'A00g', 2, 1, '1575414000', 'upload/fd459e2c87.jpg', 'sfgv', 1, 3, NULL, '2019-12-28 04:59:12'),
(7, 'A00gsdfs', 1, 1, '1575414000', 'upload/fd459e2c87.jpg', 'sfgv', 1, 3, NULL, '2019-12-28 04:59:12'),
(8, 'A0ert', 1, 1, '1575414000', 'upload/fd459e2c87.jpg', 'sfgv', 1, 3, NULL, '2019-12-28 04:59:12'),
(9, 'Awer', 1, 1, '1575414000', 'upload/fd459e2c87.jpg', 'sfgv', 1, 3, NULL, '2019-12-28 04:59:12'),
(12, 'A000012324', 1, 3, '1576537200', 'upload/70c9735631.jpg', 'tgfhvnh', 5, 3, NULL, '2019-12-30 03:53:18'),
(13, 'A00g', 2, 2, '1575414000', 'upload/fd459e2c87.jpg', 'sfgv', 1, 3, NULL, '2019-12-28 04:59:12'),
(14, 'A000012324', 1, 2, '1579647600', 'upload/9fd64af136.jpg', 'gyijft', 1, 5, NULL, '2020-01-01 05:46:04'),
(15, 'A00001', 1, NULL, NULL, NULL, NULL, 1, 3, NULL, '2020-01-01 06:58:10'),
(16, 'sfv', 1, NULL, NULL, NULL, NULL, 1, 1, NULL, '2020-01-01 06:59:40'),
(17, 'A00002', 1, NULL, NULL, NULL, NULL, 3, 5, NULL, '2020-01-01 07:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `tracking_status`
--

CREATE TABLE `tracking_status` (
  `id` int(11) NOT NULL,
  `tracking_number_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `date_stamp` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `remark` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracking_status`
--

INSERT INTO `tracking_status` (`id`, `tracking_number_id`, `status_id`, `date_stamp`, `image_path`, `remark`, `created_at`) VALUES
(1, 17, 1, '1578092400', 'upload/6c01d33385.jpg', 'zxdc', '2020-01-01 07:01:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_requests`
--
ALTER TABLE `driver_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `station_prefix`
--
ALTER TABLE `station_prefix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking_numbers`
--
ALTER TABLE `tracking_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking_status`
--
ALTER TABLE `tracking_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `driver_requests`
--
ALTER TABLE `driver_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `station_prefix`
--
ALTER TABLE `station_prefix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tracking_numbers`
--
ALTER TABLE `tracking_numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tracking_status`
--
ALTER TABLE `tracking_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
