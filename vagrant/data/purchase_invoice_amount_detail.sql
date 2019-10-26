-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2019 at 01:43 PM
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
-- Database: `techno_wash`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_amount_detail`
--

CREATE TABLE `purchase_invoice_amount_detail` (
  `p_inv_amount_detail` int(11) NOT NULL,
  `purchase_invoice_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase_invoice_amount_detail`
--
ALTER TABLE `purchase_invoice_amount_detail`
  ADD PRIMARY KEY (`p_inv_amount_detail`),
  ADD KEY `purchase_invoice_id` (`purchase_invoice_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_invoice_amount_detail`
--
ALTER TABLE `purchase_invoice_amount_detail`
  MODIFY `p_inv_amount_detail` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase_invoice_amount_detail`
--
ALTER TABLE `purchase_invoice_amount_detail`
  ADD CONSTRAINT `purchase_invoice_amount_detail_ibfk_1` FOREIGN KEY (`purchase_invoice_id`) REFERENCES `purchase_invoice` (`purchase_invoice_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
