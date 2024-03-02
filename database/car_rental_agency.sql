-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2024 at 01:07 PM
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
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `daysforrent` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booked_cars`
--

INSERT INTO `booked_cars` (`id`, `vehicle_id`, `customer_id`, `agency_id`, `daysforrent`, `booking_date`) VALUES
(1, 4, 2, 2, 3, '2024-03-02 12:04:07'),
(2, 2, 2, 1, 4, '2024-03-02 12:04:50'),
(3, 1, 1, 1, 2, '2024-03-02 12:06:10');

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
  `a_phone` int(11) DEFAULT NULL,
  `a_email` varchar(500) DEFAULT NULL,
  `a_pass` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registerd_agency`
--

INSERT INTO `registerd_agency` (`id`, `agency_id`, `user_type`, `a_name`, `a_add`, `a_phone`, `a_email`, `a_pass`) VALUES
(1, 1, 'Agency', 'Speedy Drive Car Rentals', '23 MG Road, Mumbai, Maharashtra, India', 2147483647, 'speedy_agency@gmail.com', '123'),
(2, 2, 'Agency', 'Swift Wheels Rent-A-Car', '456 Brigade Road, Bangalore, Karnataka, India', 2147483647, 'swift_rental@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `registered_customer`
--

CREATE TABLE `registered_customer` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_type` varchar(500) DEFAULT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `c_phone` int(11) NOT NULL,
  `c_email` varchar(500) DEFAULT NULL,
  `c_pass` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_customer`
--

INSERT INTO `registered_customer` (`id`, `customer_id`, `user_type`, `c_name`, `c_phone`, `c_email`, `c_pass`) VALUES
(1, 1, 'Customer', 'Rossie', 2147483647, 'rossie@gmail.com', '123'),
(2, 2, 'Customer', 'Tanya', 2147483647, 'tanya@gmail.com', '123');

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
  `v_rent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehical_table`
--

INSERT INTO `vehical_table` (`vehicle_id`, `agency_id`, `v_model`, `v_number`, `v_seat`, `v_rent`) VALUES
(1, 1, 'Toyota Innova', ' MH 01 AB 1234', 7, 2500),
(2, 1, 'Maruti Swift Dzire', 'KA 02 CD 5678', 5, 1800),
(3, 1, 'Honda City', 'DL 03 EF 9012', 5, 2200),
(4, 2, 'Hyundai Creta 1', ' TN 04 GH 3456', 5, 2600),
(5, 2, 'Ford EcoSport', 'WB 05 IJ 7890', 5, 2000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_cars`
--
ALTER TABLE `booked_cars`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registerd_agency`
--
ALTER TABLE `registerd_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registered_customer`
--
ALTER TABLE `registered_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehical_table`
--
ALTER TABLE `vehical_table`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
