-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2020 at 08:27 AM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_techno`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_head`
--

CREATE TABLE `account_head` (
  `id` int(11) NOT NULL,
  `nature_id` int(11) NOT NULL,
  `account_name` varchar(150) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `created_by` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(150) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_head`
--

INSERT INTO `account_head` (`id`, `nature_id`, `account_name`, `account_no`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'Mislinious Income', '01-001', 'Superadmin', '2019-11-09 11:11:13', 'Superadmin', '2019-11-09 11:11:13'),
(2, 2, 'Internet Bill', '02-001', 'Superadmin', '2019-11-09 11:11:27', 'Superadmin', '2019-11-09 11:11:27'),
(3, 3, 'Cash', '03-001', 'Superadmin', '2019-11-09 11:11:51', 'Superadmin', '2019-11-09 11:11:51'),
(4, 3, 'Bank', '03-002', 'Superadmin', '2019-11-09 11:11:58', 'Superadmin', '2019-11-09 11:11:58'),
(5, 4, 'Account Payable', '04-001', 'Superadmin', '2019-11-09 11:11:39', 'Superadmin', '2019-11-09 11:11:39'),
(6, 3, 'Account Recievable', '03-003', 'Superadmin', '2019-11-09 11:11:20', 'Superadmin', '2019-11-09 11:11:20'),
(7, 2, 'Salaries', '02-002', 'Superadmin', '2019-11-11 05:11:51', 'Superadmin', '2019-11-11 05:11:51'),
(8, 3, 'Sales', '03-004', 'admin_techno', '2019-12-15 00:00:00', 'admin_techno', '2019-12-15 00:00:00'),
(9, 2, 'Refreshment', '02-003', 'Superadmin', '2020-01-14 00:00:00', 'Superadmin', '2020-01-14 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_head`
--
ALTER TABLE `account_head`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nature_id` (`nature_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_head`
--
ALTER TABLE `account_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_head`
--
ALTER TABLE `account_head`
  ADD CONSTRAINT `account_head_ibfk_1` FOREIGN KEY (`nature_id`) REFERENCES `account_nature` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
