-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2019 at 08:52 PM
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
-- Table structure for table `car_manufacture`
--

CREATE TABLE `car_manufacture` (
  `car_manufacture_id` int(11) NOT NULL,
  `vehical_type_id` int(11) NOT NULL,
  `manufacturer` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `car_manufacture`
--

INSERT INTO `car_manufacture` (`car_manufacture_id`, `vehical_type_id`, `manufacturer`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'SUZUKI', '', '2019-10-04 10:42:58', 140, '0000-00-00 00:00:00', 0),
(2, 2, 'ABC', '', '2019-10-05 05:57:23', 140, '0000-00-00 00:00:00', 0),
(3, 2, 'COROLA', '', '2019-10-10 05:40:17', 1, '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_manufacture`
--
ALTER TABLE `car_manufacture`
  ADD PRIMARY KEY (`car_manufacture_id`),
  ADD KEY `vehical_type_id` (`vehical_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_manufacture`
--
ALTER TABLE `car_manufacture`
  MODIFY `car_manufacture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `car_manufacture`
--
ALTER TABLE `car_manufacture`
  ADD CONSTRAINT `car_manufacture_ibfk_1` FOREIGN KEY (`vehical_type_id`) REFERENCES `vehicle_type` (`vehical_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
