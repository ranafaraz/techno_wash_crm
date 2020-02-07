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
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `type` enum('Cash Payment','Bank Payment') NOT NULL,
  `narration` text,
  `debit_account` int(11) NOT NULL,
  `credit_account` int(11) NOT NULL,
  `amount` double NOT NULL,
  `transactions_date` date NOT NULL,
  `head_id` int(11) NOT NULL,
  `ref_no` varchar(50) DEFAULT NULL,
  `ref_name` varchar(50) NOT NULL,
  `created_by` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `branch_id`, `type`, `narration`, `debit_account`, `credit_account`, `amount`, `transactions_date`, `head_id`, `ref_no`, `ref_name`, `created_by`) VALUES
(1, 1, 'Cash Payment', '', 12, 3, 400, '2020-02-01', 0, '1', 'Purchase', '1'),
(2, 1, 'Cash Payment', '', 12, 3, 500, '2020-02-01', 0, '1', 'Sale', '1'),
(7, 1, 'Cash Payment', '', 2, 3, 2000, '2020-02-01', 0, NULL, 'Payments', '1'),
(8, 1, 'Cash Payment', '', 13, 5, 500, '2020-02-01', 0, NULL, 'Payments', '1'),
(9, 1, 'Cash Payment', '', 2, 5, 1000, '2020-02-01', 0, NULL, 'Payments', '1'),
(10, 1, 'Cash Payment', '', 13, 3, 0, '2020-02-03', 0, NULL, 'Payments', '1'),
(11, 1, 'Cash Payment', '', 13, 3, 0, '2020-02-03', 0, NULL, 'Payments', '1'),
(12, 1, 'Cash Payment', 'After Updation paid 400 out of total 450', 12, 3, 400, '2020-02-03', 0, '2', 'Sale', '1'),
(13, 1, 'Cash Payment', '', 13, 3, 0, '2020-02-03', 0, NULL, 'Payments', '1'),
(14, 1, 'Cash Payment', '', 13, 3, 0, '2020-02-03', 0, NULL, 'Payments', '1'),
(15, 1, 'Cash Payment', '', 13, 5, 0, '2020-02-03', 0, NULL, 'Payments', '1'),
(16, 1, 'Cash Payment', '', 13, 3, 500, '2020-02-03', 0, NULL, 'Payments', '1'),
(17, 1, 'Cash Payment', '', 12, 5, 0, '2020-02-03', 0, '3', 'Sale', '1'),
(18, 1, 'Cash Payment', '', 12, 3, 5000, '2020-02-03', 0, '4', 'Sale', '1'),
(19, 1, 'Cash Payment', '', 12, 5, 0, '2020-02-03', 0, '2', 'Purchase', '1'),
(20, 1, 'Cash Payment', '', 12, 3, 500, '2020-02-03', 0, '3', 'Purchase', '1'),
(21, 1, 'Cash Payment', '', 5, 3, 500, '2020-02-04', 0, '4', 'Purchase', '1'),
(22, 1, 'Cash Payment', '', 3, 12, 850, '2020-02-07', 0, '5', 'Sale', '1'),
(23, 1, 'Cash Payment', '', 3, 12, 450, '2020-02-07', 6, '6', 'Sale', '1'),
(24, 1, 'Cash Payment', '', 3, 12, 1000, '2020-02-07', 4, '5', 'Purchase', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `debit_account` (`debit_account`),
  ADD KEY `credit_account` (`credit_account`),
  ADD KEY `debit_account_2` (`debit_account`),
  ADD KEY `credit_account_2` (`credit_account`),
  ADD KEY `branch_id` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`credit_account`) REFERENCES `account_head` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`debit_account`) REFERENCES `account_head` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`branch_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
