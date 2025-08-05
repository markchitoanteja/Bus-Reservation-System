-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 05:13 PM
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
-- Database: `u474266573_db_brs`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus_trav_sched_tb`
--

CREATE TABLE `bus_trav_sched_tb` (
  `bus_trav_sched_tb_id` int(11) NOT NULL,
  `datetime_trav` datetime NOT NULL,
  `route` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `buses_tb_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus_trav_sched_tb`
--
ALTER TABLE `bus_trav_sched_tb`
  ADD PRIMARY KEY (`bus_trav_sched_tb_id`),
  ADD KEY `buses_tb_id` (`buses_tb_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bus_trav_sched_tb`
--
ALTER TABLE `bus_trav_sched_tb`
  MODIFY `bus_trav_sched_tb_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bus_trav_sched_tb`
--
ALTER TABLE `bus_trav_sched_tb`
  ADD CONSTRAINT `bus_trav_sched_tb_ibfk_1` FOREIGN KEY (`buses_tb_id`) REFERENCES `buses_tb` (`buses_tb_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
