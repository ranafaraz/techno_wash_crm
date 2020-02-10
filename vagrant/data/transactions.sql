-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2020 at 05:53 AM
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
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `narration` text,
  `account_head` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `amount` double NOT NULL,
  `remaining` double NOT NULL,
  `transactions_date` date NOT NULL,
  `head_id` int(11) NOT NULL,
  `ref_no` varchar(50) DEFAULT NULL,
  `ref_name` varchar(50) NOT NULL,
  `created_by` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `branch_id`, `narration`, `account_head`, `total_amount`, `amount`, `remaining`, `transactions_date`, `head_id`, `ref_no`, `ref_name`, `created_by`) VALUES
(1, 1, '', 13, 0, 500, 0, '2020-02-08', 0, NULL, 'Payments', '1'),
(2, 1, NULL, 12, 350, 350, 0, '2020-02-08', 2, '2', 'Sale', '1'),
(3, 1, NULL, 14, 200, 100, 100, '2020-02-08', 6, '7', 'Purchase', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `debit_account` (`account_head`),
  ADD KEY `debit_account_2` (`account_head`),
  ADD KEY `branch_id` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`account_head`) REFERENCES `account_head` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`branch_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
