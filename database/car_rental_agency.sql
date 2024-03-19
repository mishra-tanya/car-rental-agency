-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2024 at 08:56 AM
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
-- Database: `car_rental_agency`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_cars`
--

CREATE TABLE `booked_cars` (
  `rental_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `daysforrent` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registerd_agency`
--

CREATE TABLE `registerd_agency` (
  `id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `user_type` varchar(500) NOT NULL,
  `a_name` varchar(255) NOT NULL,
  `a_add` varchar(500) NOT NULL,
  `a_phone` varchar(500) DEFAULT NULL,
  `a_email` varchar(500) DEFAULT NULL,
  `a_pass` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_customer`
--

CREATE TABLE `registered_customer` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_type` varchar(500) DEFAULT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `c_phone` varchar(500) NOT NULL,
  `c_email` varchar(500) DEFAULT NULL,
  `c_pass` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehical_table`
--

CREATE TABLE `vehical_table` (
  `vehicle_id` int(11) NOT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `v_model` varchar(600) DEFAULT NULL,
  `v_number` varchar(600) DEFAULT NULL,
  `v_seat` int(11) DEFAULT NULL,
  `v_rent` int(11) DEFAULT NULL,
  `image_path` varchar(1000) NOT NULL,
  `rental_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_cars`
--
ALTER TABLE `booked_cars`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `registerd_agency`
--
ALTER TABLE `registerd_agency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_customer`
--
ALTER TABLE `registered_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehical_table`
--
ALTER TABLE `vehical_table`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_cars`
--
ALTER TABLE `booked_cars`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registerd_agency`
--
ALTER TABLE `registerd_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_customer`
--
ALTER TABLE `registered_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehical_table`
--
ALTER TABLE `vehical_table`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_cars`
--
ALTER TABLE `booked_cars`
  ADD CONSTRAINT `booked_cars_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehical_table` (`vehicle_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
