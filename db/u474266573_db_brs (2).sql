-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2025 at 08:42 PM
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
-- Table structure for table `buses_tb`
--

CREATE TABLE `buses_tb` (
  `buses_tb_id` int(11) NOT NULL,
  `bus_name` varchar(60) NOT NULL,
  `bus_no` varchar(10) NOT NULL,
  `bus_type` enum('Ordinary','Air-Con','','') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses_tb`
--

INSERT INTO `buses_tb` (`buses_tb_id`, `bus_name`, `bus_no`, `bus_type`, `created_at`, `updated_at`) VALUES
(1, 'Goldtrans Tours', '2333', 'Ordinary', '2025-08-07 14:07:02', '2025-08-07 14:39:41'),
(3, 'Goldtrans Tours', '834', 'Air-Con', '2025-08-07 14:41:32', '2025-08-07 14:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `bus_trav_sched_tb`
--

CREATE TABLE `bus_trav_sched_tb` (
  `bus_trav_sched_tb_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `dep_time` time NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `buses_tb_id` int(11) NOT NULL,
  `routes_tb_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes_tb`
--

CREATE TABLE `routes_tb` (
  `routes_tb_id` int(11) NOT NULL,
  `origin` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `name`, `email`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES
(1, '7b79ed8b-0f05-4176-95e7-964e5c2ab065', 'Administrator', 'admin@example.com', '$2y$10$wHnAHwPX1/VTbJAWr4VOmeaYw3LCjHIdozjs5uSXJMqE26celZ2P.', 'default-user-image.webp', 'admin', '2025-05-26 01:36:07', '2025-05-26 01:36:07'),
(2, 'ca0e60bb-954d-4def-837d-ff3d9c6a7a99', 'Mark Chito Anteja', '00anteja23@gmail.com', '$2y$10$tVegFXG8lWiUJpaNoJ7FKO0CtJytKv6ZcwpELUyq3cWydHFIBTMXi', 'default-user-image.webp', 'user', '2025-05-26 01:36:42', '2025-05-27 16:14:29'),
(3, 'a5b011f0-78af-4e4e-b3e5-6eaf51bc8a1e', 'Ken', 'kenneth@gmail.com', '$2y$10$eb.e2eXr2U.ZG9YafQVareM.yNSDVUXVhHANRC56xdYBsmMlR4gT6', 'default-user-image.webp', 'user', '2025-05-27 20:47:50', '2025-05-27 20:47:50'),
(4, '9db8badf-b9a5-4e83-80d7-f5f9b7304560', 'Kristine Oblino', 'oblinokristine6@gmail.com', '$2y$10$EbyB988PlOiRHO/jp4fNs.wmfGlsdtM9Rqb36Yc/0F4X03WNeRguC', 'default-user-image.webp', 'user', '2025-05-27 21:50:06', '2025-05-27 21:50:06'),
(5, '16923517-14ff-45fc-a34d-8e30da2a5b7d', 'kristine', 'kristine@gmail.com', '$2y$10$vCUl7V0L8b.dXTW10DGqGOVrLgAbE7.eoLTgRtNlwFA7nf573AoaS', 'default-user-image.webp', 'user', '2025-06-01 21:26:53', '2025-06-01 21:26:53'),
(6, 'a606114e-7512-4c38-8b5e-a9d0119432da', 'Ken Docabo', 'kendo@gmail.com', '$2y$10$79R5tfH4QPXvnktSM2Xgo.nj.qUSOVqug3Zr9Kx88XIkiwiTxLZ.i', 'default-user-image.webp', 'user', '2025-06-05 05:07:53', '2025-06-05 05:07:53'),
(7, '45fecc3e-0760-442a-bc2a-7efff51eee8b', 'Kristine Oblino', 'tintin@gmail.com', '$2y$10$bX5hNY7h6J/kd6lTBLkT5egt4Qald1fpes/nOzWuW2ACC9g/aoaWG', 'default-user-image.webp', 'user', '2025-06-05 14:52:26', '2025-06-05 14:52:26'),
(10, '30dd9ad4-b8d2-40a1-9707-065b02f63cef', 'Clarck Cruz', 'clarck@gmail.com', '$2y$10$iYwYvjPLmSwtgiIGJdmzZu7u/dfj5yeC2WdNiw15pPTHKX3mjrv4G', 'default-user-image.webp', 'user', '2025-07-22 16:24:29', '2025-07-22 16:24:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buses_tb`
--
ALTER TABLE `buses_tb`
  ADD PRIMARY KEY (`buses_tb_id`);

--
-- Indexes for table `bus_trav_sched_tb`
--
ALTER TABLE `bus_trav_sched_tb`
  ADD PRIMARY KEY (`bus_trav_sched_tb_id`),
  ADD KEY `bus_trav_sched_tb_ibfk_1` (`buses_tb_id`),
  ADD KEY `bus_trav_sched_tb_ibfk_2` (`routes_tb_id`);

--
-- Indexes for table `routes_tb`
--
ALTER TABLE `routes_tb`
  ADD PRIMARY KEY (`routes_tb_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buses_tb`
--
ALTER TABLE `buses_tb`
  MODIFY `buses_tb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bus_trav_sched_tb`
--
ALTER TABLE `bus_trav_sched_tb`
  MODIFY `bus_trav_sched_tb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `routes_tb`
--
ALTER TABLE `routes_tb`
  MODIFY `routes_tb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bus_trav_sched_tb`
--
ALTER TABLE `bus_trav_sched_tb`
  ADD CONSTRAINT `bus_trav_sched_tb_ibfk_1` FOREIGN KEY (`buses_tb_id`) REFERENCES `buses_tb` (`buses_tb_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bus_trav_sched_tb_ibfk_2` FOREIGN KEY (`routes_tb_id`) REFERENCES `routes_tb` (`routes_tb_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
