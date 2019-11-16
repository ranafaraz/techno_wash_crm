-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2019 at 10:14 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csms`
--
CREATE DATABASE IF NOT EXISTS `csms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `csms`;

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
(8, 5, 'Mislinious Income', '05-001', 'Superadmin', '2019-11-12 07:11:43', 'Superadmin', '2019-11-12 07:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `account_heads`
--

CREATE TABLE `account_heads` (
  `account_head_id` int(11) NOT NULL,
  `acc_head_name` varchar(30) NOT NULL,
  `acc_head_description` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account_heads`
--

INSERT INTO `account_heads` (`account_head_id`, `acc_head_name`, `acc_head_description`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Police Expense', 'Police Expense', '2019-09-23 17:38:46', '2019-09-23 22:38:46', 1, 1),
(2, 'Tool Plaza Expense', 'Tool Plaza Expense', '2019-09-23 19:18:15', '2019-09-24 00:18:15', 1, 1),
(3, 'Motarway ', 'Expense', '2019-09-23 19:08:56', '0000-00-00 00:00:00', 1, 0),
(4, 'Oil Change Expense', 'Oil Change Expense', '2019-09-23 19:10:01', '0000-00-00 00:00:00', 1, 0),
(5, 'services Expense', 'services Expense', '2019-09-23 19:12:55', '0000-00-00 00:00:00', 1, 0),
(6, 'Refreshment Expenses', 'Refreshment Expenses', '2019-09-23 19:16:14', '0000-00-00 00:00:00', 1, 0),
(7, 'Other Expense', 'Receipt , tube, stitching etc', '2019-09-23 19:33:28', '2019-09-24 00:33:28', 1, 1),
(8, 'Telephone  & Cloth', 'Mobile Load, cloth wash & Press', '2019-09-23 19:39:23', '2019-09-24 00:39:23', 1, 1),
(9, 'Bill', 'Expense', '2019-09-24 09:44:25', '0000-00-00 00:00:00', 1, 0),
(10, 'Auto Repairs/Maintenance', 'Tire, Auto repair, maintenance', '2019-09-24 19:20:38', '2019-09-25 00:20:38', 1, 1),
(11, 'Labour Expense', 'Labour Expense', '2019-09-24 19:37:50', '0000-00-00 00:00:00', 1, 0),
(12, 'Eid Paid expense', 'Eidi paid to shahid', '2019-09-25 18:54:27', '0000-00-00 00:00:00', 1, 0),
(13, 'Taxi Rent Expense', 'Rent Expense', '2019-09-25 18:55:11', '0000-00-00 00:00:00', 1, 0),
(14, 'Tube Bill (1tube)', 'Tube Bill Expense', '2019-09-25 19:14:01', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_nature`
--

CREATE TABLE `account_nature` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_nature`
--

INSERT INTO `account_nature` (`id`, `branch_id`, `name`, `account_no`, `created_at`) VALUES
(1, 0, 'Income', '01-000', '2019-11-09 11:11:14'),
(2, 0, 'Expense', '02-000', '2019-11-09 11:11:21'),
(3, 0, 'Asset', '03-000', '2019-11-09 11:11:28'),
(4, 0, 'Liabilities', '04-000', '2019-11-09 11:11:38'),
(5, 0, 'Earnings', '05-000', '2019-11-12 07:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `account_payable`
--

CREATE TABLE `account_payable` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `account_payable` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_payable`
--

INSERT INTO `account_payable` (`id`, `transaction_id`, `amount`, `account_payable`, `due_date`, `created_at`, `updated_at`, `updated_by`, `status`, `branch_id`) VALUES
(50, 1, 200, 2, '2019-11-12', '2019-11-12', '2019-11-12', 0, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_recievable`
--

CREATE TABLE `account_recievable` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `payer_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `plot_no` int(11) DEFAULT NULL,
  `is_installment` int(11) DEFAULT NULL,
  `organization_id` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_by` varchar(150) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_recievable`
--

INSERT INTO `account_recievable` (`id`, `transaction_id`, `payer_id`, `amount`, `property_id`, `plot_no`, `is_installment`, `organization_id`, `due_date`, `created_at`, `updated_by`, `updated_at`) VALUES
(12, 1, 6, 400000, 20, 1, 1, 1, '0000-00-00', '0000-00-00', '0', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `account_title`
--

CREATE TABLE `account_title` (
  `id` int(11) NOT NULL,
  `title_name` varchar(200) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_title`
--

INSERT INTO `account_title` (`id`, `title_name`, `updated_by`, `updated_at`, `created_by`, `created_at`) VALUES
(5, 'abc-01', NULL, NULL, 3, '2019-10-26'),
(6, 'abc', NULL, NULL, 3, '2019-10-26'),
(7, 'shell(RYK)', NULL, NULL, 3, '2019-10-26'),
(8, 'abc(+89-789-7897897)', NULL, NULL, 3, '2019-10-26'),
(9, 'abc(+89-789-7897897)', NULL, NULL, 3, '2019-10-26'),
(11, 'Comission Route', 3, '2019-10-29', 3, '2019-10-29'),
(12, 'Ghareeb 123(+98-098-0980980)', NULL, NULL, 3, '2019-11-01'),
(13, '8979abc', NULL, NULL, 3, '2019-11-01'),
(14, 'Arshad Azad Awan(+92-300-6706635)', NULL, NULL, 0, '0000-00-00'),
(15, 'abc1(+98-098-0980980)', NULL, NULL, 3, '2019-11-01'),
(16, 'Malik Arshad(+92-300-6706635\r\n)', NULL, NULL, 0, '0000-00-00'),
(17, 'Shahid Azad Awan(+92-301-8677391)', NULL, NULL, 0, '0000-00-00'),
(18, 'abcshop', NULL, NULL, 3, '2019-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Accountant', '6', NULL),
('developer', '140', NULL),
('dexdevs', '1', NULL),
('dexdevs2', '4', NULL),
('Inquiry Head', '48', NULL),
('Principal', '7', NULL),
('Superadmin', '3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Accountant', 1, 'can login', NULL, NULL, NULL, NULL),
('add-institute', 1, 'create institute Name', NULL, NULL, NULL, NULL),
('developer', 1, 'Can view whol.', NULL, NULL, NULL, NULL),
('dexdevs', 1, 'Admin of the application', NULL, NULL, NULL, NULL),
('dexdevs2', 1, NULL, NULL, NULL, NULL, NULL),
('Inquiry Head', 1, 'Inquiry Head can manage activities of student inquiries only.', NULL, NULL, NULL, NULL),
('inquiry-nav', 1, 'can access this nav', NULL, NULL, NULL, NULL),
('login', 1, 'The user can login in the admin panel.', NULL, NULL, NULL, NULL),
('navigation ', 1, 'Navigation can be access authorized users only.', NULL, NULL, NULL, NULL),
('Principal', 1, 'Principal can manage whole activities in the application except account department', NULL, NULL, NULL, NULL),
('Superadmin', 1, 'Superadmin can manage whole activities in the application.', NULL, NULL, NULL, NULL),
('update-institute-name', 1, 'can update the institute name.', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('Accountant', 'login'),
('developer', 'login'),
('developer', 'navigation '),
('dexdevs', 'login'),
('dexdevs', 'navigation '),
('dexdevs2', 'login'),
('dexdevs2', 'navigation '),
('Inquiry Head', 'add-institute'),
('Inquiry Head', 'inquiry-nav'),
('Inquiry Head', 'login'),
('Principal', 'login'),
('Principal', 'navigation '),
('Superadmin', 'login'),
('Superadmin', 'navigation ');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `branch_contact` varchar(15) NOT NULL,
  `branch_email` varchar(50) NOT NULL,
  `branch_website` varchar(50) NOT NULL,
  `branch_owner` varchar(30) NOT NULL,
  `branch_city` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `org_id`, `branch_name`, `location`, `branch_contact`, `branch_email`, `branch_website`, `branch_owner`, `branch_city`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'Chowk Bahadupur', 'Al Muslim Chowk, Rahim Yar Khan', '+92-300-6706635', '', '', 'Arshad Awan', 1, '2019-09-24 11:01:51', '2019-09-24 16:01:51', 1, 1),
(2, 1, 'Azad Awan', 'New Truck Adda', '+92-302-8677391', '', '', 'Malik Aslam', 4, '2019-10-10 07:16:30', '0', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `broker`
--

CREATE TABLE `broker` (
  `broker_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `broker_name` varchar(20) NOT NULL,
  `broker_business` varchar(20) NOT NULL,
  `broker_address` varchar(30) NOT NULL,
  `broker_city` int(11) NOT NULL,
  `broker_contact` varchar(15) NOT NULL,
  `broker_email` varchar(30) NOT NULL,
  `broker_photo` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `broker`
--

INSERT INTO `broker` (`broker_id`, `branch_id`, `broker_name`, `broker_business`, `broker_address`, `broker_city`, `broker_contact`, `broker_email`, `broker_photo`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'M. Ahmed', 'Spray', '', 1, '', '', 'uploads/default.png', '2019-09-23 04:49:19', '0000-00-00 00:00:00', 1, 0),
(2, 1, 'Ali', 'Transport', 'karachi', 4, '+34-567-890980_', '', 'uploads/default.png', '2019-09-23 17:43:08', '0000-00-00 00:00:00', 1, 0),
(3, 1, 'Arshad Azad', 'Toori', 'Satrameel', 18, '+92-300-6706635', '', 'uploads/default.png', '2019-09-24 19:25:10', '0000-00-00 00:00:00', 1, 0),
(4, 1, 'Naveed', 'Cement ', 'Kalarkhar', 396, '+92-300-5477269', '', 'uploads/default.png', '2019-09-25 19:11:57', '0000-00-00 00:00:00', 1, 0),
(5, 1, 'Dawood Khal', 'Cement ', 'Mianwali, Dawood Khal', 7, '+92-316-4441992', '', 'uploads/default.png', '2019-09-27 16:13:20', '0000-00-00 00:00:00', 1, 0),
(6, 1, 'Shahid ', 'Transport', 'Muslim Chok', 1, '+92-301-8677391', '', 'uploads/default.png', '2019-09-27 16:15:09', '0000-00-00 00:00:00', 1, 0),
(7, 1, 'Direct', 'None', 'None', 1, '+00-000-0000000', '', 'uploads/default.png', '2019-10-10 10:55:36', '0', 1, 0),
(8, 1, 'abc', 'abc', 'sjkcdhaskl', 1, '+89-789-7897897', 'asijd@kcjs.com', 'uploads/abc_photo.jpg', '2019-10-26 09:06:04', '0', 3, 0),
(9, 1, 'abc1', 'dont know', 'abc', 1, '+98-098-0980980', 'usama@gmail.com', 'uploads/default.png', '2019-11-01 06:05:27', '0', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(20) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Rahim Yar Khan', 'Active', '2019-09-19 08:42:34', '0000-00-00 00:00:00', 1, 0),
(2, 'Lahore', 'Active', '2019-09-19 08:42:41', '0000-00-00 00:00:00', 1, 0),
(3, 'Multan', 'Active', '2019-09-19 08:42:57', '0000-00-00 00:00:00', 1, 0),
(4, 'Karachi', 'Active', '2019-09-19 08:43:04', '0000-00-00 00:00:00', 1, 0),
(5, 'Rawat', 'Active', '2019-09-23 17:44:27', '0000-00-00 00:00:00', 1, 0),
(6, 'Rawalpindi', 'Active', '2019-09-23 17:44:37', '0000-00-00 00:00:00', 1, 0),
(7, 'Mianwali', 'Active', '2019-09-23 17:44:50', '0000-00-00 00:00:00', 1, 0),
(8, 'Peshawar', 'Active', '2019-09-23 17:44:59', '0000-00-00 00:00:00', 1, 0),
(9, 'Talagang', 'Active', '2019-09-23 18:51:44', '0000-00-00 00:00:00', 1, 0),
(10, 'Tarhada', 'Active', '2019-09-23 18:51:52', '0000-00-00 00:00:00', 1, 0),
(11, 'Chok Azam', 'Active', '2019-09-23 18:52:02', '0000-00-00 00:00:00', 1, 0),
(12, 'Sukkhar', 'Active', '2019-09-23 18:52:23', '0000-00-00 00:00:00', 1, 0),
(13, 'Noshara Feroz', 'Active', '2019-09-24 19:08:51', '0000-00-00 00:00:00', 1, 0),
(14, 'Hala', 'Active', '2019-09-24 19:09:31', '0000-00-00 00:00:00', 1, 0),
(15, 'Fatehpur', 'Active', '2019-09-24 19:10:29', '0000-00-00 00:00:00', 1, 0),
(16, 'Chok Munda', 'Active', '2019-09-24 19:10:58', '0000-00-00 00:00:00', 1, 0),
(17, 'Mandi Yazman', 'Active', '2019-09-24 19:21:17', '0000-00-00 00:00:00', 1, 0),
(18, 'Satrameel', 'Active', '2019-09-24 19:22:48', '0000-00-00 00:00:00', 1, 0),
(20, 'Bagh', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(21, 'Bhimber', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(22, 'khuiratta', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(23, 'Kotli', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(24, 'Mangla', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(25, 'Mirpur', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(26, 'Muzaffarabad', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(27, 'Plandri', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(28, 'Rawalakot', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(29, 'Punch', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(30, 'Amir Chah', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(31, 'Bazdar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(32, 'Bela', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(33, 'Bellpat', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(34, 'Bagh', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(35, 'Burj', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(36, 'Chagai', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(37, 'Chah Sandan', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(38, 'Chakku', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(39, 'Chaman', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(40, 'Chhatr', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(41, 'Dalbandin', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(42, 'Dera Bugti', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(43, 'Dhana Sar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(44, 'Diwana', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(45, 'Duki', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(46, 'Dushi', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(47, 'Duzab', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(48, 'Gajar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(49, 'Gandava', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(50, 'Garhi Khairo', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(51, 'Garruck', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(52, 'Ghazluna', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(53, 'Girdan', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(54, 'Gulistan', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(55, 'Gwadar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(56, 'Gwash', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(57, 'Hab Chauki', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(58, 'Hameedabad', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(59, 'Harnai', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(60, 'Hinglaj', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(61, 'Hoshab', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(62, 'Ispikan', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(63, 'Jhal', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(64, 'Jhal Jhao', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(65, 'Jhatpat', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(66, 'Jiwani', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(67, 'Kalandi', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(68, 'Kalat', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(69, 'Kamararod', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(70, 'Kanak', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(71, 'Kandi', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(72, 'Kanpur', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(73, 'Kapip', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(74, 'Kappar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(75, 'Karodi', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(76, 'Katuri', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(77, 'Kharan', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(78, 'Khuzdar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(79, 'Kikki', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(80, 'Kohan', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(81, 'Kohlu', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(82, 'Korak', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(83, 'Lahri', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(84, 'Lasbela', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(85, 'Liari', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(86, 'Loralai', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(87, 'Mach', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(88, 'Mand', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(89, 'Manguchar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(90, 'Mashki Chah', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(91, 'Maslti', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(92, 'Mastung', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(93, 'Mekhtar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(94, 'Merui', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(95, 'Mianez', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(96, 'Murgha Kibzai', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(97, 'Musa Khel Bazar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(98, 'Nagha Kalat', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(99, 'Nal', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(100, 'Naseerabad', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(101, 'Nauroz Kalat', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(102, 'Nur Gamma', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(103, 'Nushki', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(104, 'Nuttal', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(105, 'Ormara', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(106, 'Palantuk', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(107, 'Panjgur', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(108, 'Pasni', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(109, 'Piharak', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(110, 'Pishin', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(111, 'Qamruddin Karez', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(112, 'Qila Abdullah', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(113, 'Qila Ladgasht', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(114, 'Qila Safed', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(115, 'Qila Saifullah', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(116, 'Quetta', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(117, 'Rakhni', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(118, 'Robat Thana', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(119, 'Rodkhan', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(120, 'Saindak', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(121, 'Sanjawi', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(122, 'Saruna', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(123, 'Shabaz Kalat', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(124, 'Shahpur', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(125, 'Sharam Jogizai', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(126, 'Shingar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(127, 'Shorap', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(128, 'Sibi', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(129, 'Sonmiani', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(130, 'Spezand', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(131, 'Spintangi', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(132, 'Sui', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(133, 'Suntsar', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(134, 'Surab', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(135, 'Thalo', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(136, 'Tump', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(137, 'Turbat', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(138, 'Umarao', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(139, 'pirMahal', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(140, 'Uthal', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(141, 'Vitakri', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(142, 'Wadh', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(143, 'Washap', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(144, 'Wasjuk', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(145, 'Yakmach', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(146, 'Zhob', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(147, 'Astor', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(148, 'Baramula', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(149, 'Hunza', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(150, 'Gilgit', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(151, 'Nagar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(152, 'Skardu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(153, 'Shangrila', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(154, 'Shandur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(155, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(156, 'Bajaur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(157, 'Hangu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(158, 'Malakand', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(159, 'Miram Shah', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(160, 'Mohmand', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(161, 'Khyber', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(162, 'Kurram', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(163, 'North Waziristan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(164, 'South Waziristan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(165, 'Wana', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(166, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(167, 'Abbottabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(168, 'Ayubia', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(169, 'Adezai', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(170, 'Banda Daud Shah', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(171, 'Bannu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(172, 'Batagram', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(173, 'Birote', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(174, 'Buner', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(175, 'Chakdara', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(176, 'Charsadda', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(177, 'Chitral', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(178, 'Dargai', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(179, 'Darya Khan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(180, 'Dera Ismail Khan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(181, 'Drasan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(182, 'Drosh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(183, 'Hangu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(184, 'Haripur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(185, 'Kalam', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(186, 'Karak', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(187, 'Khanaspur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(188, 'Kohat', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(189, 'Kohistan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(190, 'Lakki Marwat', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(191, 'Latamber', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(192, 'Lower Dir', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(193, 'Madyan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(194, 'Malakand', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(195, 'Mansehra', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(196, 'Mardan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(197, 'Mastuj', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(198, 'Mongora', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(199, 'Nowshera', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(200, 'Paharpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(201, 'Peshawar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(202, 'Saidu Sharif', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(203, 'Shangla', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(204, 'Sakesar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(205, 'Swabi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(206, 'Swat', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(207, 'Tangi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(208, 'Tank', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(209, 'Thall', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(210, 'Tordher', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(211, 'Upper Dir', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(212, 'Ahmedpur East', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(213, 'Ahmed Nager Chatha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(214, 'Ali Pur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(215, 'Arifwala', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(216, 'Attock', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(217, 'Basti Malook', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(218, 'Bhagalchur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(219, 'Bhalwal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(220, 'Bahawalnagar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(221, 'Bahawalpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(222, 'Bhaipheru', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(223, 'Bhakkar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(224, 'Burewala', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(225, 'Chailianwala', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(226, 'Chakwal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(227, 'Chichawatni', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(228, 'Chiniot', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(229, 'Chowk Azam', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(230, 'Chowk Sarwar Shaheed', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(231, 'Daska', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(232, 'Darya Khan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(233, 'Dera Ghazi Khan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(234, 'Derawar Fort', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(235, 'Dhaular', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(236, 'Dina City', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(237, 'Dinga', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(238, 'Dipalpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(239, 'Faisalabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(240, 'Fateh Jang', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(241, 'Gadar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(242, 'Ghakhar Mandi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(243, 'Gujranwala', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(244, 'Gujrat', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(245, 'Gujar Khan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(246, 'Hafizabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(247, 'Haroonabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(248, 'Hasilpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(249, 'Haveli Lakha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(250, 'Jampur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(251, 'Jhang', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(252, 'Jhelum', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(253, 'Kalabagh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(254, 'Karor Lal Esan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(255, 'Kasur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(256, 'Kamalia', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(257, 'Kamokey', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(258, 'Khanewal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(259, 'Khanpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(260, 'Kharian', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(261, 'Khushab', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(262, 'Kot Addu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(263, 'Jahania', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(264, 'Jalla Araain', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(265, 'Jauharabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(266, 'Laar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(267, 'Lahore', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(268, 'Lalamusa', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(269, 'Layyah', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(270, 'Lodhran', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(271, 'Mamoori', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(272, 'Mandi Bahauddin', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(273, 'Makhdoom Aali', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(274, 'Mandi Warburton', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(275, 'Mailsi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(276, 'Mian Channu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(277, 'Minawala', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(278, 'Mianwali', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(279, 'Multan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(280, 'Murree', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(281, 'Muridke', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(282, 'Muzaffargarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(283, 'Narowal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(284, 'Okara', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(285, 'Renala Khurd', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(286, 'Rajan Pur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(287, 'Pak Pattan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(288, 'Panjgur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(289, 'Pattoki', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(290, 'Pirmahal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(291, 'Qila Didar Singh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(292, 'Rabwah', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(293, 'Raiwind', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(294, 'Rajan Pur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(295, 'Rahim Yar Khan', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(296, 'Rawalpindi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(297, 'Rohri', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(298, 'Sadiqabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(299, 'Safdar Abad – (Dhaba', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(300, 'Sahiwal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(301, 'Sangla Hill', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(302, 'Samberial', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(303, 'Sarai Alamgir', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(304, 'Sargodha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(305, 'Shakargarh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(306, 'Shafqat Shaheed Chow', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(307, 'Sheikhupura', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(308, 'Sialkot', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(309, 'Sohawa', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(310, 'Sooianwala', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(311, 'Sundar (city)', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(312, 'Talagang', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(313, 'Tarbela', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(314, 'Takhtbai', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(315, 'Taxila', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(316, 'Toba Tek Singh', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(317, 'Vehari', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(318, 'Wah Cantonment', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(319, 'Wazirabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(320, 'Ali Bandar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(321, 'Baden', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(322, 'Chachro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(323, 'Dadu', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(324, 'Digri', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(325, 'Diplo', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(326, 'Dokri', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(327, 'Gadra', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(328, 'Ghanian', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(329, 'Ghauspur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(330, 'Ghotki', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(331, 'Hala', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(332, 'Hyderabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(333, 'Islamkot', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(334, 'Jacobabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(335, 'Jamesabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(336, 'Jamshoro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(337, 'Janghar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(338, 'Jati (Mughalbhin)', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(339, 'Jhudo', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(340, 'Jungshahi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(341, 'Kandiaro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(342, 'Karachi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(343, 'Kashmor', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(344, 'Keti Bandar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(345, 'Khairpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(346, 'Khora', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(347, 'Klupro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(348, 'Khokhropur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(349, 'Korangi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(350, 'Kotri', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(351, 'Kot Sarae', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(352, 'Larkana', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(353, 'Lund', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(354, 'Mathi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(355, 'Matiari', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(356, 'Mehar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(357, 'Mirpur Batoro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(358, 'Mirpur Khas', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(359, 'Mirpur Sakro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(360, 'Mithi', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(361, 'Mithani', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(362, 'Moro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(363, 'Nagar Parkar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(364, 'Naushara', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(365, 'Naudero', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(366, 'Noushero Feroz', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(367, 'Nawabshah', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(368, 'Nazimabad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(369, 'Naokot', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(370, 'Pendoo', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(371, 'Pokran', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(372, 'Qambar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(373, 'Qazi Ahmad', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(374, 'Ranipur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(375, 'Ratodero', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(376, 'Rohri', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(377, 'Saidu Sharif', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(378, 'Sakrand', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(379, 'Sanghar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(380, 'Shadadkhot', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(381, 'Shahbandar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(382, 'Shahdadpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(383, 'Shahpur Chakar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(384, 'Shikarpur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(385, 'Sujawal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(386, 'Sukkur', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(387, 'Tando Adam', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(388, 'Tando Allahyar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(389, 'Tando Bago', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(390, 'Tar Ahamd Rind', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(391, 'Thatta', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(392, 'Tujal', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(393, 'Umarkot', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(394, 'Veirwaro', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(395, 'Warah', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(396, 'Kalarkhar', 'Active', '2019-09-25 19:09:08', '0000-00-00 00:00:00', 1, 0),
(397, 'Chandni Chok', 'Active', '2019-09-25 20:24:11', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comission_route`
--

CREATE TABLE `comission_route` (
  `route_comission_id` int(11) NOT NULL,
  `vehicle_reg_no` varchar(20) NOT NULL,
  `emp_id` varchar(100) DEFAULT NULL,
  `broker_id` varchar(150) DEFAULT NULL,
  `route_date` date NOT NULL,
  `route_from` int(11) NOT NULL,
  `route_to` int(11) NOT NULL,
  `loading_material` varchar(100) NOT NULL,
  `cell_no` varchar(15) NOT NULL,
  `comission` double NOT NULL,
  `total_rent` double NOT NULL,
  `comission_agent` enum('Malik Arshad','Shahid Azad Awan') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comission_route`
--

INSERT INTO `comission_route` (`route_comission_id`, `vehicle_reg_no`, `emp_id`, `broker_id`, `route_date`, `route_from`, `route_to`, `loading_material`, `cell_no`, `comission`, `total_rent`, `comission_agent`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'fgbfg ', 'dfsdfvdf', '32rf xvdf sd', '2019-10-13', 4, 6, 'abc ', '+23-232-3232323', 213213, 23213123, 'Malik Arshad', '2019-10-12 18:30:11', '0', 3, 0),
(2, 'abc-321', 'abc', 'broker name', '2019-10-15', 2, 6, 'testing material', '+23-232-3232323', 1234, 423123, 'Malik Arshad', '2019-10-14 06:49:24', '0', 3, 0),
(3, 'abc-veh', '', 'abc broker', '2019-10-14', 3, 6, '', '', 123, 32111, 'Shahid Azad Awan', '2019-10-14 06:58:08', '2019-10-14 11:58:08', 3, 3),
(4, 'abc veh', '', 'as j', '2019-10-24', 2, 3, '', '', 123, 32111, 'Malik Arshad', '2019-10-14 06:57:02', '0', 3, 0),
(17, '78989', 'uiiouio', 'uio', '2019-10-29', 1, 2, '', '', 1200, 12000, 'Malik Arshad', '2019-10-29 09:25:58', '0', 3, 0),
(18, '87897', 'jhkkj', 'hjlkh', '2019-10-29', 1, 2, '', '', 1200, 12000, 'Malik Arshad', '2019-10-29 09:26:38', '0', 3, 0),
(19, '8979', 'ioiou', 'ouio', '2019-10-29', 1, 2, '', '', 12000, 20000, 'Malik Arshad', '2019-10-29 09:28:22', '0', 3, 0),
(20, '8979abc', 'Ghareeb Nawaz', 'Shahid Azad', '2019-11-01', 2, 1, '', '', 19000, 30000, 'Shahid Azad Awan', '2019-11-01 06:00:38', '0', 3, 0),
(21, '8979abc', 'Ghareeb Nawaz', 'abc', '2019-11-01', 1, 1, '', '', 12000, 20000, 'Shahid Azad Awan', '2019-11-01 06:04:21', '0', 3, 0),
(22, '8979abc', 'abc', 'abc', '2019-11-01', 1, 2, '', '', 1200, 120000, 'Malik Arshad', '2019-11-01 06:18:04', '0', 3, 0),
(23, '8979abc', 'abc', 'abc', '2019-11-01', 1, 2, '', '', 1300, 15000, 'Malik Arshad', '2019-11-01 06:21:03', '0', 3, 0),
(24, '8979abc', 'abc', 'abc', '2019-11-01', 1, 2, '', '', 1400, 15000, 'Shahid Azad Awan', '2019-11-01 06:23:34', '0', 3, 0),
(25, '8979abc', 'abc', 'abc', '2019-11-01', 1, 2, ' ', '', 1200, 12000, 'Malik Arshad', '2019-11-01 06:25:22', '0', 3, 0),
(26, 'abc', 'abca', 'bava', '2019-11-01', 1, 1, '', '', 1000, 90000, 'Malik Arshad', '2019-11-01 06:26:41', '0', 3, 0),
(27, '8979', 'abc', 'abc', '2019-11-01', 1, 2, '', '', 1230, 13000, '', '2019-11-01 06:28:40', '0', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `emp_type_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `emp_name` varchar(20) NOT NULL,
  `emp_cnic` varchar(15) NOT NULL,
  `emp_contact` varchar(15) NOT NULL,
  `emp_father_name` varchar(20) NOT NULL,
  `emp_gender` varchar(6) NOT NULL,
  `emp_status` enum('Active','Inactive') NOT NULL,
  `emp_photo` varchar(200) NOT NULL,
  `emp_driving_liscence` varchar(15) NOT NULL,
  `salary` double NOT NULL,
  `emp_joining_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_type_id`, `branch_id`, `city_id`, `emp_name`, `emp_cnic`, `emp_contact`, `emp_father_name`, `emp_gender`, `emp_status`, `emp_photo`, `emp_driving_liscence`, `salary`, `emp_joining_date`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 1, 'Ghareeb Nawaz', '98765-4567876-5', '+92-300-6573165', 'Haji Khan', 'Male', 'Active', '', '123456789', 17000, NULL, '2019-09-23 17:19:30', '2019-09-23 17:19:30', 1, 1),
(2, 1, 1, 1, 'Zahid Nawaz', '98765-4323456-7', '+92-304-9960987', 'Azeez Muhammad', 'Male', 'Active', 'uploads/Emp2_photo.jpg', '987654321', 17000, NULL, '2019-09-23 17:19:14', '2019-09-23 17:19:14', 1, 1),
(3, 2, 1, 1, 'Shahid Nawz', '98765-4322345-6', '+98-765-4323456', 'Azeez Muhammad', 'Male', 'Active', '', '987654321', 9000, NULL, '2019-09-23 17:20:33', '2019-09-23 17:20:33', 1, 1),
(4, 1, 1, 1, 'Rana Iftikhar', '45678-9876545-9', '+92-308-5065332', 'Ahmad', 'Male', 'Active', 'uploads/Ali_photo.jpg', '45789876568', 16000, NULL, '2019-09-24 09:41:17', '2019-09-24 09:41:17', 140, 1),
(5, 3, 1, 1, 'Asif', '23456-7890789-0', '+92-345-7627118', 'Ahmad', 'Male', 'Active', 'uploads/default.png', '678906536', 16000, NULL, '2019-09-24 09:41:48', '2019-09-24 09:41:48', 1, 1),
(6, 2, 1, 2, 'Ahmad', '12345-6789909-8', '+34-567-8978887', 'Muhammad', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-23 17:33:57', '0000-00-00 00:00:00', 1, 0),
(7, 2, 1, 1, 'Waqar', '', '+45-555-5555555', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-24 19:31:46', '0000-00-00 00:00:00', 1, 0),
(8, 1, 1, 229, 'Tariq', '11111-1111111-1', '+92-300-8087374', 'Amanat Ali', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 19:30:54', '0000-00-00 00:00:00', 1, 0),
(9, 3, 1, 11, 'Amir ', '00000-0000000-0', '+92-301-3534615', 'Riaz', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 19:32:11', '0000-00-00 00:00:00', 1, 0),
(10, 2, 1, 11, 'Rizwan', '22222-2222222-2', '+00-000-0000000', 'Amant Ali', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 19:33:12', '0000-00-00 00:00:00', 1, 0),
(11, 1, 1, 9, 'Fazal', '00000-0000000-0', '+92-300-8969825', 'Mian Muhmmad', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 19:35:51', '0000-00-00 00:00:00', 1, 0),
(12, 3, 1, 9, 'Umair', '88888-8888888-8', '+92-301-5295589', 'Mian Muhammad', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 19:37:00', '0000-00-00 00:00:00', 1, 0),
(13, 2, 1, 9, 'Irfan', '11111-1111111-1', '+00-000-0000000', 'Muhammad', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 19:38:03', '0000-00-00 00:00:00', 1, 0),
(14, 1, 1, 10, 'Arshad ', '22222-2222222-2', '+92-306-8105261', 'Akbar khan', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 19:48:35', '2019-09-25 19:48:35', 1, 1),
(15, 3, 1, 9, 'Aqeel', '11111-1111111-1', '+92-341-4429464', 'Bashir', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 19:49:02', '2019-09-25 19:49:02', 1, 1),
(16, 2, 1, 10, 'Kamran', '00000-0000000-0', '+00-000-0000000', 'Budha Khan', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 19:45:40', '0000-00-00 00:00:00', 1, 0),
(17, 2, 1, 16, 'Imran', '00000-0000011-1', '+00-000-0000000', '', 'Male', 'Active', 'uploads/default.png', '', 10000, NULL, '2019-09-25 19:50:58', '0000-00-00 00:00:00', 1, 0),
(18, 1, 1, 16, 'Abid', '00000-0000000-0', '+92-300-4146654', 'Sadiq Ali', 'Male', 'Active', 'uploads/default.png', '', 20000, NULL, '2019-09-25 19:52:05', '0000-00-00 00:00:00', 1, 0),
(19, 3, 1, 295, 'Rashid', '55555-5555555-5', '+92-301-3795056', 'Abdul Malak', 'Male', 'Active', 'uploads/default.png', '', 18000, NULL, '2019-09-25 19:53:38', '0000-00-00 00:00:00', 1, 0),
(20, 1, 1, 1, 'Makbool', '77777-7777777-7', '+92-300-3572805', 'Khan Bahadur', 'Male', 'Active', 'uploads/default.png', '', 20000, NULL, '2019-09-25 19:55:28', '0000-00-00 00:00:00', 1, 0),
(21, 3, 1, 1, 'Shahid', '88888-8888888-8', '+92-306-785484_', 'Haji Zubair', 'Male', 'Active', 'uploads/default.png', '', 18000, NULL, '2019-09-25 19:56:43', '0000-00-00 00:00:00', 1, 0),
(22, 2, 1, 1, 'Kashif', '77777-7777777-7', '+77-777-7777777', '', 'Male', 'Active', 'uploads/default.png', '', 10000, NULL, '2019-09-25 19:57:32', '0000-00-00 00:00:00', 1, 0),
(23, 1, 1, 1, 'Sadeeq', '33333-3333333-3', '+92-302-7660782', 'Muhammad Husain', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:00:02', '0000-00-00 00:00:00', 1, 0),
(24, 3, 1, 1, 'Ashoo Husain', '23232-3232323-2', '+92-030-5299891', 'Qadir Husain', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:01:17', '0000-00-00 00:00:00', 1, 0),
(25, 2, 1, 1, 'Zahid', '45454-5454545-4', '+22-222-2222222', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 20:02:18', '0000-00-00 00:00:00', 1, 0),
(26, 1, 1, 11, 'Akmal', '11111-1111111-1', '+92-300-6554289', 'Zafar Iqbal', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:03:37', '0000-00-00 00:00:00', 1, 0),
(27, 3, 1, 11, 'Rafaqat', '22222-2222222-2', '+92-300-2409961', 'Nasir Ali', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:04:54', '0000-00-00 00:00:00', 1, 0),
(28, 2, 1, 11, 'Shah Nawaz', '11111-1111111-1', '+92-333-3333333', '', 'Male', 'Active', 'uploads/default.png', '', 90000, NULL, '2019-09-25 20:05:37', '0000-00-00 00:00:00', 1, 0),
(29, 1, 1, 3, 'Shoqat', '44444-4444444-4', '+92-300-0058291', 'shabeer', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:15:35', '0000-00-00 00:00:00', 1, 0),
(30, 3, 1, 3, 'Hakim', '99999-9999999-9', '+92-301-3558145', 'Shabeer', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:16:43', '0000-00-00 00:00:00', 1, 0),
(31, 2, 1, 3, 'Allah Nawaz', '77777-7777777-7', '+77-777-7777777', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 20:17:38', '0000-00-00 00:00:00', 1, 0),
(32, 1, 1, 11, 'Adrees', '99999-9999999-9', '+92-304-2616348', 'Ismaeel', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:19:12', '0000-00-00 00:00:00', 1, 0),
(33, 3, 1, 11, 'Waqas', '22222-2222222-2', '+92-305-6580847', 'Falak Sheer', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:20:30', '0000-00-00 00:00:00', 1, 0),
(34, 2, 1, 11, 'Irfan', '44444-4444444-4', '+00-000-0000000', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 20:21:07', '0000-00-00 00:00:00', 1, 0),
(35, 1, 1, 397, 'Sanaullah', '77777-7777777-7', '+92-303-6293599', 'Gulam Shabir', 'Male', 'Active', 'uploads/default.png', '', 1600, NULL, '2019-09-25 20:25:37', '2019-09-25 20:25:37', 1, 1),
(36, 3, 1, 397, 'Saleem', '11111-1111111-1', '+92-306-2452690', 'Jahangeer', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 20:27:26', '0000-00-00 00:00:00', 1, 0),
(37, 2, 1, 397, 'Azeez', '55555-5555555-5', '+92-300-0000000', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 20:28:13', '0000-00-00 00:00:00', 1, 0),
(38, 1, 1, 10, 'Khlas Khan', '88888-8888888-8', '+92-301-7665185', 'Sher Jung', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:29:43', '0000-00-00 00:00:00', 1, 0),
(39, 3, 1, 1, 'Manzoor', '88888-8888888-8', '+92-301-2197397', 'Inam Baksh', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 20:33:43', '0000-00-00 00:00:00', 1, 0),
(40, 2, 1, 1, 'kakaaa', '77777-7777777-7', '+77-777-7777777', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 20:34:15', '0000-00-00 00:00:00', 1, 0),
(41, 1, 1, 7, 'Shabir Abbas', '21325-4564636-6', '+92-300-2121745', 'Sultan Khan', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 20:54:41', '0000-00-00 00:00:00', 1, 0),
(42, 3, 1, 7, 'Arslan', '11111-1111111-1', '+92-302-9289566', 'Muhammad Iqbal', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 20:55:47', '0000-00-00 00:00:00', 1, 0),
(43, 2, 1, 7, 'Mujahid', '88888-8888888-8', '+99-999-9999999', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 20:56:33', '0000-00-00 00:00:00', 1, 0),
(44, 1, 1, 11, 'Kaalb', '77777-7777777-7', '+92-307-8788275', 'Zaffer Iqbal', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 20:57:59', '0000-00-00 00:00:00', 1, 0),
(45, 3, 1, 11, 'Ansar', '55555-5555555-5', '+92-346-2074087', 'Rafeeq', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 20:59:06', '0000-00-00 00:00:00', 1, 0),
(46, 2, 1, 11, 'Imran', '44444-4444444-4', '+44-444-4444444', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 20:59:57', '0000-00-00 00:00:00', 1, 0),
(47, 1, 1, 1, 'Jawaed', '88888-8888888-8', '+92-308-8919491', 'Nazeer', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 21:01:53', '0000-00-00 00:00:00', 1, 0),
(48, 3, 1, 3, 'Rashid', '22222-2222222-2', '+92-305-5204743', 'Aslam', 'Male', 'Active', 'uploads/default.png', '', 17000, NULL, '2019-09-25 21:03:07', '0000-00-00 00:00:00', 1, 0),
(49, 2, 1, 1, 'Munwar', '00000-0000000-0', '+00-000-0000000', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 21:03:54', '0000-00-00 00:00:00', 1, 0),
(50, 1, 1, 9, 'Sajid', '77777-7777777-7', '+92-300-0522991', 'Abdul Wahab', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 21:06:22', '0000-00-00 00:00:00', 1, 0),
(51, 3, 1, 9, 'Najeeb', '33333-3333333-3', '+92-301-7952511', 'Samiullah Khan', 'Male', 'Active', 'uploads/default.png', '', 16000, NULL, '2019-09-25 21:07:44', '0000-00-00 00:00:00', 1, 0),
(52, 2, 1, 9, 'Naeem', '00000-0000000-0', '+88-888-8888888', '', 'Male', 'Active', 'uploads/default.png', '', 9000, NULL, '2019-09-25 21:09:33', '0000-00-00 00:00:00', 1, 0),
(53, 1, 1, 1, 'abc', '81278-9372897-8', '+89-789-7897897', 'ACB', 'Male', 'Active', 'uploads/abc_photo.jpg', '890980980980980', 30000, NULL, '2019-10-26 09:02:47', '0000-00-00 00:00:00', 3, 0),
(54, 2, 2, 1, 'Ghareeb 123', '98764-5908098-0', '+98-098-0980980', 'abc', 'Male', 'Active', 'uploads/default.png', '098098098098089', 20000, NULL, '2019-11-01 05:33:58', '0000-00-00 00:00:00', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee_types`
--

CREATE TABLE `employee_types` (
  `emp_type_id` int(11) NOT NULL,
  `emp_type_name` varchar(50) NOT NULL,
  `description` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_types`
--

INSERT INTO `employee_types` (`emp_type_id`, `emp_type_name`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Driver', 'Driver', '2019-09-19 08:43:33', '0000-00-00 00:00:00', 1, 0),
(2, 'Cleaner', 'Cleaner', '2019-09-19 08:43:46', '0000-00-00 00:00:00', 1, 0),
(3, 'Second Driver', 'Driver 2', '2019-09-23 19:00:52', '2019-09-24 00:00:52', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary`
--

CREATE TABLE `emp_salary` (
  `emp_salary_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `paid_amount` double NOT NULL,
  `salary_month` varchar(11) NOT NULL,
  `remaining` double NOT NULL,
  `status` enum('Paid','Unpaid','Partially Paid') NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp_salary`
--

INSERT INTO `emp_salary` (`emp_salary_id`, `emp_id`, `date`, `paid_amount`, `salary_month`, `remaining`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(38, 54, '2019-11-11', 20000, '2019-11', 0, 'Paid', 3, 0, '2019-11-11 16:24:37', '0');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_consumption`
--

CREATE TABLE `fuel_consumption` (
  `fuel_consmp_id` int(11) NOT NULL,
  `route_voucher_head_id` int(11) NOT NULL,
  `petroleum_service` int(11) NOT NULL,
  `fuel_consmp_date` varchar(10) DEFAULT NULL,
  `fuel_cosmp_liter` double DEFAULT NULL,
  `fuel_consmp_amount` double DEFAULT NULL,
  `receipt_status` enum('Received','Pending') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fuel_consumption`
--

INSERT INTO `fuel_consumption` (`fuel_consmp_id`, `route_voucher_head_id`, `petroleum_service`, `fuel_consmp_date`, `fuel_cosmp_liter`, `fuel_consmp_amount`, `receipt_status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, '2019-10-29', 123, 1233, 'Received', '2019-10-22 08:47:23', '0', 3, 0),
(2, 2, 1, '2019-10-29', 123, 50000, 'Pending', '2019-10-22 10:14:24', '0', 3, 0),
(3, 3, 2, '2019-10-29', 123, 2000, 'Received', '2019-10-22 10:17:10', '0', 3, 0),
(4, 4, 2, '2019-11-02', 234, 23423, 'Pending', '2019-11-02 06:48:22', '0', 3, 0),
(5, 5, 2, '2019-11-02', 234, 23423, 'Received', '2019-11-02 06:52:10', '0', 3, 0),
(6, 6, 3, '2019-11-02', 234, 1233, 'Pending', '2019-11-02 06:55:30', '0', 3, 0),
(7, 7, 3, '2019-11-02', 234, 23423, 'Received', '2019-11-02 07:02:02', '0', 3, 0),
(8, 8, 2, '2019-10-22', 234, 10000, 'Pending', '2019-11-04 09:52:26', '0', 1, 0),
(9, 9, 2, '2019-11-04', 234, 10000, '', '2019-11-04 10:00:11', '0', 1, 0),
(10, 10, 2, '2019-11-04', NULL, 10000, 'Received', '2019-11-04 10:03:28', '0', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `org_id` int(11) NOT NULL,
  `org_name` varchar(50) NOT NULL,
  `org_address` varchar(100) NOT NULL,
  `org_owner` varchar(50) NOT NULL,
  `org_contact` varchar(15) NOT NULL,
  `org_head_office` varchar(100) NOT NULL,
  `org_owner_cnic` varchar(15) NOT NULL,
  `business_ntn` varchar(15) NOT NULL,
  `org_logo` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`org_id`, `org_name`, `org_address`, `org_owner`, `org_contact`, `org_head_office`, `org_owner_cnic`, `business_ntn`, `org_logo`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'AZAAD AWAN TRAILER SERVICE', 'Chowk Bahadapur, Rahim Yar Khan', 'Arshad Awan', '+92-300-6706635', 'Chowk Bahadapur, Rahim Yar Khan', '', '', 'uploads/AZAAD AWAN TRAILER SERVICE_photo.png', '2019-09-23 03:42:19', '2019-09-23 03:42:19', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `petroleum_services`
--

CREATE TABLE `petroleum_services` (
  `petroleum_service_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `ps_name` varchar(40) NOT NULL,
  `ps_location` varchar(50) NOT NULL,
  `ps_contact` varchar(15) NOT NULL,
  `ps_owner` varchar(20) NOT NULL,
  `ps_owner_contact` varchar(15) NOT NULL,
  `ps_owner_cnic` varchar(15) NOT NULL,
  `ps_manager` varchar(20) NOT NULL,
  `ps_manager_contact` varchar(15) NOT NULL,
  `ps_manager_cnic` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `petroleum_services`
--

INSERT INTO `petroleum_services` (`petroleum_service_id`, `branch_id`, `city_id`, `ps_name`, `ps_location`, `ps_contact`, `ps_owner`, `ps_owner_contact`, `ps_owner_cnic`, `ps_manager`, `ps_manager_contact`, `ps_manager_cnic`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 'Shakeel Pump', 'Al Muslim Chowk', '', '', '', '', '', '', '', '2019-09-23 18:56:08', '2019-09-23 23:56:08', 1, 1),
(2, 1, 9, 'Azad Awan', 'Tarhada', '', '', '', '', '', '', '', '2019-09-23 18:57:31', '2019-09-23 23:57:31', 1, 1),
(3, 1, 3, 'PSO', 'KLP Road', '', '', '', '', '', '', '', '2019-09-23 04:10:13', '0000-00-00 00:00:00', 1, 0),
(4, 1, 1, 'Sohail Asgher pump', 'Noshara Fareoz', '+34-151-4635725', 'Ahmad', '+67-637-6873646', '48764-7682768-4', 'Ali', '+54-275-4753778', '46378-6478268-4', '2019-09-24 19:08:25', '0000-00-00 00:00:00', 1, 0),
(5, 1, 14, 'Satara Kamriyaal', 'Hala, Hydrabaad', '+73-573-7857423', 'Zahran ', '+76-587-3654899', '85798-3478758-9', 'Ahmad', '+46-868-5555555', '78787-8778888-8', '2019-09-24 19:15:06', '0000-00-00 00:00:00', 1, 0),
(6, 1, 1, 'shell', 'RYK', '+37-678-6978697', 'abc', '+89-789-7897897', '78989-7897897-8', 'abc', '+98-789-7897897', '78789-7897897-8', '2019-10-26 08:58:52', '0', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `tyre_shop_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `purchase_item` varchar(50) NOT NULL,
  `purchase_date` date NOT NULL,
  `total_amount` double NOT NULL,
  `discount_amount` double NOT NULL,
  `net_total` double NOT NULL,
  `paid_amount` double NOT NULL,
  `remaining_amount` double NOT NULL,
  `status` enum('Paid','Partially Paid','Credit') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `tyre_shop_id`, `vehicle_id`, `purchase_item`, `purchase_date`, `total_amount`, `discount_amount`, `net_total`, `paid_amount`, `remaining_amount`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 7, 1, 'tyre', '2019-11-01', 8000, 0, 8000, 8000, 0, 'Paid', '2019-11-01 12:02:01', '0', 3, 0),
(2, 7, 2, 'tyre', '2019-11-01', 5000, 0, 9000, 9000, 0, 'Paid', '2019-11-01 12:03:55', '2019-11-01 12:19:38', 3, 3),
(3, 7, 20, 'tyre', '2019-11-05', 65000, 0, 65000, 20000, 45000, 'Partially Paid', '2019-11-05 13:47:26', '0', 3, 0),
(4, 7, 1, 'tyre', '2019-11-05', 65000, 0, 65000, 50000, 15000, 'Partially Paid', '2019-11-05 13:50:07', '0', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_transaction`
--

CREATE TABLE `purchase_transaction` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `paid_amount` double NOT NULL,
  `remaining_amount` double NOT NULL,
  `transaction_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_transaction`
--

INSERT INTO `purchase_transaction` (`id`, `purchase_id`, `paid_amount`, `remaining_amount`, `transaction_date`, `created_at`, `created_by`) VALUES
(1, 2, 5000, 4000, '2019-11-01', '0000-00-00 00:00:00', 3),
(2, 2, 4000, 0, '2019-11-01', '2019-11-01 12:19:38', 3),
(3, 3, 20000, 45000, '2019-11-05', '0000-00-00 00:00:00', 3),
(4, 4, 50000, 15000, '2019-11-05', '0000-00-00 00:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `route_voucher_details`
--

CREATE TABLE `route_voucher_details` (
  `route_v_d_id` int(11) NOT NULL,
  `route_v_h_id` int(11) DEFAULT NULL,
  `account_head` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `route_voucher_details`
--

INSERT INTO `route_voucher_details` (`route_v_d_id`, `route_v_h_id`, `account_head`, `amount`, `date`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 2, 10000, '2019-10-02', '2019-10-22 08:47:23', '0', 3, 0),
(2, 2, 1, 10000, '2019-10-23', '2019-10-22 10:14:24', '0', 3, 0),
(3, 3, 1, 10000, '2019-10-28', '2019-10-22 10:17:10', '0', 3, 0),
(4, 4, 7, 123123, '2019-11-02', '2019-11-02 06:48:22', '0', 3, 0),
(5, 5, 1, 123123, '2019-10-14', '2019-11-02 06:52:10', '0', 3, 0),
(6, 6, 3, 123, '2019-10-21', '2019-11-02 06:55:30', '0', 3, 0),
(7, 7, 6, 123, '2019-10-14', '2019-11-02 07:02:02', '0', 3, 0),
(8, 8, 1, 1000, '2019-11-04', '2019-11-04 09:52:26', '0', 1, 0),
(9, 8, 2, 1000, '2019-11-04', '2019-11-04 09:52:26', '0', 1, 0),
(10, 8, 3, 1200, '2019-11-04', '2019-11-04 09:52:26', '0', 1, 0),
(11, 9, 1, 1000, NULL, '2019-11-04 10:00:11', '0', 1, 0),
(12, 9, 2, 1000, NULL, '2019-11-04 10:00:11', '0', 1, 0),
(13, 9, 3, 1200, NULL, '2019-11-04 10:00:11', '0', 1, 0),
(14, 10, 1, 1000, '2019-11-04', '2019-11-04 10:03:28', '0', 1, 0),
(15, 10, 2, 1000, '2019-11-04', '2019-11-04 10:03:28', '0', 1, 0),
(16, 10, 3, 1200, '2019-11-04', '2019-11-04 10:03:28', '0', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `route_voucher_employee`
--

CREATE TABLE `route_voucher_employee` (
  `route_v_emp_id` int(11) NOT NULL,
  `route_v_h_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `emp_wage` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `route_voucher_employee`
--

INSERT INTO `route_voucher_employee` (`route_v_emp_id`, `route_v_h_id`, `emp_id`, `comments`, `emp_wage`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 40, 1, '', 17000, '2019-10-22 07:33:22', '0', 3, 0),
(2, 40, 2, '', 17000, '2019-10-22 07:33:22', '0', 3, 0),
(3, 41, 1, '', 20000, '2019-10-22 07:38:40', '0', 3, 0),
(4, 41, 2, '', 25000, '2019-10-22 07:38:40', '0', 3, 0),
(5, 42, 16, '', 10000, '2019-10-22 07:40:05', '0', 3, 0),
(6, 1, 7, 'dsf ', 10000, '2019-10-22 08:47:23', '0', 3, 0),
(7, 2, 5, 'dsf ', 50000, '2019-10-22 10:14:23', '0', 3, 0),
(8, 3, 7, '234', 10000, '2019-10-22 10:17:10', '0', 3, 0),
(9, 4, 1, 'sdklfj', 35000, '2019-11-02 06:48:22', '0', 3, 0),
(10, 5, 9, 'sdklfj', 40000, '2019-11-02 06:52:10', '0', 3, 0),
(11, 6, 54, 'sdklfj', 1233, '2019-11-02 06:55:30', '0', 3, 0),
(12, 7, 1, 'sdklfj', 15000, '2019-11-02 07:02:02', '0', 3, 0),
(13, 8, 1, '', 15000, '2019-11-04 09:52:26', '0', 1, 0),
(14, 8, 2, '', 10000, '2019-11-04 09:52:26', '0', 1, 0),
(15, 9, 1, '', 15000, '2019-11-04 10:00:11', '0', 1, 0),
(16, 9, 2, '', 10000, '2019-11-04 10:00:11', '0', 1, 0),
(17, 10, 1, '', 15000, '2019-11-04 10:03:28', '0', 1, 0),
(18, 10, 2, '', 10000, '2019-11-04 10:03:28', '0', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `route_voucher_head`
--

CREATE TABLE `route_voucher_head` (
  `route_v_h_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `broker_id` int(11) NOT NULL,
  `route_from` int(20) NOT NULL,
  `route_to` int(20) NOT NULL,
  `meter_read_before` double DEFAULT NULL,
  `meter_read_after` double DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `rent_per_ton` double DEFAULT NULL,
  `total_rent` double DEFAULT NULL,
  `oil_place` varchar(30) DEFAULT NULL,
  `net_earning` double DEFAULT NULL,
  `banam_paid_to` double DEFAULT NULL,
  `banam_paid_from` double DEFAULT NULL,
  `banam_paid_from_description` text DEFAULT NULL,
  `banam_paid_to_date` date DEFAULT NULL,
  `banam_paid_from_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `route_voucher_head`
--

INSERT INTO `route_voucher_head` (`route_v_h_id`, `vehicle_id`, `broker_id`, `route_from`, `route_to`, `meter_read_before`, `meter_read_after`, `start_date`, `end_date`, `weight`, `rent_per_ton`, `total_rent`, `oil_place`, `net_earning`, `banam_paid_to`, `banam_paid_from`, `banam_paid_from_description`, `banam_paid_to_date`, `banam_paid_from_date`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 1, 2, 23, 12312, '2019-10-17', '2019-10-31', 123, 123, 100000, '123', 78767, NULL, NULL, '', NULL, NULL, '2019-10-22 08:47:22', '0', 3, 0),
(2, 1, 1, 2, 1, 23, 324, '2019-10-17', '2019-10-31', 123, 123, 100000, 'ryk', 0, 10000, 0, 'testing banam', '2019-10-17', NULL, '2019-10-22 10:17:10', '0', 3, 0),
(3, 1, 2, 2, 3, 32, 324, '2019-10-17', '2019-10-17', 123, 123, 50000, 'ryk', 28000, 0, 10000, 'testing banam', NULL, '2019-10-17', '2019-10-22 10:17:10', '0', 3, 0),
(4, 20, 9, 1, 1, NULL, NULL, '2019-11-02', '2019-10-17', NULL, NULL, 8098, '', 0, 100000, 0, 'sdfsdj l', '2019-11-11', NULL, '2019-11-02 06:55:30', '0', 3, 0),
(5, 20, 9, 1, 2, NULL, NULL, '2019-11-02', '2019-11-02', NULL, NULL, 90000, '', 96546, 0, 73448, 'banam paid to ', NULL, '2019-11-02', '2019-11-02 06:52:09', '0', 3, 0),
(6, 20, 1, 2, 4, 123, 321, '2019-11-11', '2019-11-18', 123, 321, 123321, '123', 120732, 0, 100000, 'sdfsdj l', NULL, '2019-11-02', '2019-11-02 06:55:30', '0', 3, 0),
(7, 20, 1, 1, 2, NULL, NULL, '2019-10-17', '2019-10-18', NULL, NULL, 120000, '', 81454, 0, NULL, '', NULL, NULL, '2019-11-02 07:02:02', '0', 3, 0),
(8, 19, 8, 1, 2, NULL, NULL, '2019-11-11', '2019-10-17', NULL, NULL, 100000, '', 61800, 0, NULL, '', NULL, NULL, '2019-11-04 09:52:26', '0', 1, 0),
(9, 19, 8, 1, 2, NULL, NULL, '2019-11-04', '2019-11-04', NULL, NULL, 100000, '', 61800, 0, NULL, '', NULL, NULL, '2019-11-04 10:00:11', '0', 1, 0),
(10, 19, 8, 1, 2, NULL, NULL, '2019-11-04', '2019-11-04', NULL, NULL, 100000, '', 61800, 0, NULL, '', NULL, NULL, '2019-11-04 10:03:27', '0', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `type` enum('Cash Payment','Bank Payment') NOT NULL,
  `narration` text DEFAULT NULL,
  `account_title_id` int(11) DEFAULT NULL,
  `debit_account` int(11) NOT NULL,
  `debit_amount` double NOT NULL,
  `credit_account` int(11) NOT NULL,
  `credit_amount` double NOT NULL,
  `date` date NOT NULL,
  `ref_no` varchar(50) DEFAULT NULL,
  `created_by` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `type`, `narration`, `account_title_id`, `debit_account`, `debit_amount`, `credit_account`, `credit_amount`, `date`, `ref_no`, `created_by`) VALUES
(18, 1, 'Cash Payment', 'Salary paid to ghareeb123', 12, 7, 20000, 3, 20000, '2019-11-11', NULL, '3'),
(21, 2, 'Cash Payment', 'internet Bill payment', NULL, 2, 1000, 3, 1000, '2019-11-12', '', 'Superadmin'),
(23, 3, 'Cash Payment', 'partially paid internet bill', NULL, 2, 1000, 3, 800, '2019-11-12', '', 'Superadmin'),
(24, 4, 'Cash Payment', 'partially paid internet bill', NULL, 2, 200, 5, 200, '2019-11-12', NULL, '3'),
(25, 5, 'Cash Payment', 'Mislinious income ', NULL, 3, 1200, 8, 1200, '2019-11-12', '', 'Superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `tyre_shop`
--

CREATE TABLE `tyre_shop` (
  `tyre_shop_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `shop_name` varchar(50) NOT NULL,
  `shop_owner_name` varchar(40) NOT NULL,
  `shop_contact` varchar(15) NOT NULL,
  `shop_address` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tyre_shop`
--

INSERT INTO `tyre_shop` (`tyre_shop_id`, `branch_id`, `city_id`, `shop_name`, `shop_owner_name`, `shop_contact`, `shop_address`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 'Sohail Traders', 'M. Sohail', '+92-345-6789879', 'Chowk Bahadurpur, Rahim Yar Khan', '2019-09-22 14:24:03', '2019-09-23 16:37:34', 140, 1),
(2, 1, 1, 'Azad Awan Autos', 'Arshad Azad', '+92-300-6706635', 'Chowk Bhadurpur', '2019-09-24 15:48:27', '0000-00-00 00:00:00', 1, 0),
(3, 1, 9, 'Shani Tire Shop', 'Zeeshan ', '+92-300-5472715', 'Baipass Talagang', '2019-09-27 12:26:45', '0000-00-00 00:00:00', 1, 0),
(4, 2, 4, 'Ali Karachi', 'Ali', '+92-302-8677391', 'New Transport Adda, Karachi ', '2019-10-10 12:18:13', '0', 1, 0),
(6, 1, 1, 'abc', 'abc', '+45-609-7986789', 'jkashd', '2019-10-26 13:54:49', '0', 3, 0),
(7, 2, 1, 'abcshop', 'abc', '+98-098-0980980', 'j;klj;kl', '2019-11-01 11:36:54', '0', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'example@gmail.com',
  `user_type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_photo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `is_block` tinyint(4) NOT NULL DEFAULT 1,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `branch_id`, `first_name`, `last_name`, `username`, `email`, `user_type`, `auth_key`, `password_hash`, `password_reset_token`, `user_photo`, `is_block`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'M', 'Mansoor', 'mansoor_admin', 'mmansoor@gmail.com', 'Admin', 'pQEdYTAVV_wLtqIALoSZ-vELIA0mdsOx', '$2y$13$ClHehtUhZZQqsocCsPnEwer2wfQd4gTcpwSOJTkWnvoMD/oFzfCpG', NULL, 'userphotos/mansoor_admin_photo.png', 1, 10, 1552727256, 1552727256),
(3, 5, 'Super', 'Admin', 'Superadmin', 'superadmin@gmail.com', 'Superadmin', 'xqZuT3vxOiZ-rsN56V6wjZhi7VXMpKnD', '$2y$13$9TnNqeWAHECax0kmKSBzK.tGW/ePQm6IkutslR9ITYIXocjs4nnX.', NULL, 'userphotos/Superadmin_photo.png', 1, 10, 1552883449, 1552883449),
(4, 6, 'Dexterous', 'Developers', 'dexdevsdeveloper', 'admin@dexdevs.com', 'dexdevs2', 'm4vI7EWTZ61_eTBrJf_tliCWdgRfCKzM', '$2y$13$k6pJmBNM4hrkgZh0SYhcC.dZLxMLOjsJtVo55TV4QiVIJ4F6t7lIW', NULL, 'userphotos/dexdevs2_photo.png', 1, 10, 1552894313, 1552894313),
(140, 5, 'Nauman', 'Shahid', 'developer', 'nauman@gmail.com', 'Admin', '-xHBOB89uX2S4JlqtBwNlvZ-wh3BNXbV', '$2y$13$loctbLkt3eLax6aljyQ7Ju2RqaDLAkKDnNqVLIFUtmpuh3oq.dnM6', NULL, '0', 1, 10, 1567762598, 1567762598);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`) VALUES
(1, 'Executive'),
(2, 'Admin'),
(3, 'Superadmin'),
(4, 'Accountant'),
(5, 'Data Entry Operator'),
(6, 'Registrar'),
(7, 'Accountant'),
(8, 'Exams Controller'),
(9, 'Student'),
(10, 'Teacher'),
(11, 'Parent'),
(12, 'Executive');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `name`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Super Admin', 'Super Admin', '2019-09-19 08:53:00', '0000-00-00 00:00:00', 1, 0),
(2, 'Admin', 'Admin', '2019-09-19 08:53:08', '2019-09-21 06:54:01', 1, 140);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `vehicle_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `vehicle_type_id` int(11) NOT NULL,
  `vehicle_reg_no` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`vehicle_id`, `branch_id`, `vehicle_type_id`, `vehicle_reg_no`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 'TMC-091', '2019-09-23 17:21:41', '2019-09-23 22:21:41', 1, 1),
(2, 1, 2, 'TLY-491', '2019-09-23 17:34:28', '2019-09-23 22:34:28', 1, 1),
(3, 1, 1, 'TLM-291', '2019-09-25 21:11:36', '2019-09-26 02:11:36', 1, 1),
(4, 1, 1, 'TMC-191', '2019-09-25 19:38:55', '0000-00-00 00:00:00', 1, 0),
(5, 1, 2, 'TLW-191', '2019-09-25 19:39:44', '0000-00-00 00:00:00', 1, 0),
(6, 1, 1, 'TMA-391', '2019-09-25 21:12:21', '0000-00-00 00:00:00', 1, 0),
(7, 1, 1, 'TLM-591', '2019-09-25 21:12:51', '0000-00-00 00:00:00', 1, 0),
(8, 1, 1, 'TLH-691', '2019-09-25 21:13:34', '0000-00-00 00:00:00', 1, 0),
(9, 1, 1, 'TLB-691', '2019-09-25 21:14:00', '0000-00-00 00:00:00', 1, 0),
(10, 1, 2, 'TLX-791', '2019-09-25 21:14:30', '0000-00-00 00:00:00', 1, 0),
(11, 1, 1, 'TLW-891', '2019-09-25 21:15:04', '0000-00-00 00:00:00', 1, 0),
(12, 1, 2, 'TLX-991', '2019-09-25 21:15:49', '0000-00-00 00:00:00', 1, 0),
(13, 1, 1, 'JW-9291', '2019-09-25 21:16:39', '0000-00-00 00:00:00', 1, 0),
(14, 1, 2, 'JV-9391', '2019-09-25 21:17:34', '0000-00-00 00:00:00', 1, 0),
(15, 1, 1, 'JV-9491', '2019-09-25 21:17:56', '0000-00-00 00:00:00', 1, 0),
(16, 1, 2, 'JV-9591', '2019-09-25 21:18:19', '0000-00-00 00:00:00', 1, 0),
(17, 1, 2, 'JV-9791', '2019-09-25 21:18:47', '0000-00-00 00:00:00', 1, 0),
(19, 1, 1, 'abc-01', '2019-10-26 08:53:31', '0', 3, 0),
(20, 2, 2, '8979abc', '2019-11-01 05:59:24', '0', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_type`
--

CREATE TABLE `vehicle_type` (
  `vehical_type_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_type`
--

INSERT INTO `vehicle_type` (`vehical_type_id`, `name`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '22-Wheeler', '22-Wheeler', 1, 1, '2019-09-23 17:21:03', '2019-09-23 22:21:03'),
(2, '18-Wheeler', '18-Wheeler', 1, 0, '2019-09-19 08:44:36', '0000-00-00 00:00:00');

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
-- Indexes for table `account_heads`
--
ALTER TABLE `account_heads`
  ADD PRIMARY KEY (`account_head_id`);

--
-- Indexes for table `account_nature`
--
ALTER TABLE `account_nature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_id` (`branch_id`);

--
-- Indexes for table `account_payable`
--
ALTER TABLE `account_payable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `account_payable` (`account_payable`),
  ADD KEY `organization_id` (`branch_id`),
  ADD KEY `account_payable_2` (`account_payable`);

--
-- Indexes for table `account_recievable`
--
ALTER TABLE `account_recievable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payer_id` (`payer_id`),
  ADD KEY `transaction__id` (`transaction_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `account_title`
--
ALTER TABLE `account_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `org_id` (`org_id`),
  ADD KEY `branch_city` (`branch_city`);

--
-- Indexes for table `broker`
--
ALTER TABLE `broker`
  ADD PRIMARY KEY (`broker_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `broker_city` (`broker_city`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `comission_route`
--
ALTER TABLE `comission_route`
  ADD PRIMARY KEY (`route_comission_id`),
  ADD KEY `route_from` (`route_from`,`route_to`),
  ADD KEY `route_to` (`route_to`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `broker_id` (`broker_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `emp_type_id` (`emp_type_id`,`branch_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `employee_types`
--
ALTER TABLE `employee_types`
  ADD PRIMARY KEY (`emp_type_id`);

--
-- Indexes for table `emp_salary`
--
ALTER TABLE `emp_salary`
  ADD PRIMARY KEY (`emp_salary_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `fuel_consumption`
--
ALTER TABLE `fuel_consumption`
  ADD PRIMARY KEY (`fuel_consmp_id`),
  ADD KEY `route_voucher_head_id` (`route_voucher_head_id`,`petroleum_service`),
  ADD KEY `petroleum_service_id` (`petroleum_service`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`org_id`);

--
-- Indexes for table `petroleum_services`
--
ALTER TABLE `petroleum_services`
  ADD PRIMARY KEY (`petroleum_service_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `tyre_shop_id` (`tyre_shop_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `tyre_shop_id_2` (`tyre_shop_id`);

--
-- Indexes for table `purchase_transaction`
--
ALTER TABLE `purchase_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `route_voucher_details`
--
ALTER TABLE `route_voucher_details`
  ADD PRIMARY KEY (`route_v_d_id`),
  ADD KEY `route_v_h_id` (`route_v_h_id`,`account_head`),
  ADD KEY `acc_head_id` (`account_head`);

--
-- Indexes for table `route_voucher_employee`
--
ALTER TABLE `route_voucher_employee`
  ADD PRIMARY KEY (`route_v_emp_id`),
  ADD KEY `route_v_h_id` (`route_v_h_id`,`emp_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `route_voucher_head`
--
ALTER TABLE `route_voucher_head`
  ADD PRIMARY KEY (`route_v_h_id`),
  ADD KEY `vehicle_id` (`vehicle_id`,`broker_id`),
  ADD KEY `broker_id` (`broker_id`),
  ADD KEY `route_from` (`route_from`),
  ADD KEY `route_to` (`route_to`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `debit_account` (`debit_account`),
  ADD KEY `credit_account` (`credit_account`),
  ADD KEY `account_title_id` (`account_title_id`),
  ADD KEY `debit_account_2` (`debit_account`),
  ADD KEY `credit_account_2` (`credit_account`);

--
-- Indexes for table `tyre_shop`
--
ALTER TABLE `tyre_shop`
  ADD PRIMARY KEY (`tyre_shop_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `vehicle_type_id` (`vehicle_type_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
  ADD PRIMARY KEY (`vehical_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_head`
--
ALTER TABLE `account_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `account_heads`
--
ALTER TABLE `account_heads`
  MODIFY `account_head_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `account_nature`
--
ALTER TABLE `account_nature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `account_payable`
--
ALTER TABLE `account_payable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `account_recievable`
--
ALTER TABLE `account_recievable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `account_title`
--
ALTER TABLE `account_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `broker`
--
ALTER TABLE `broker`
  MODIFY `broker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=398;

--
-- AUTO_INCREMENT for table `comission_route`
--
ALTER TABLE `comission_route`
  MODIFY `route_comission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `employee_types`
--
ALTER TABLE `employee_types`
  MODIFY `emp_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `emp_salary`
--
ALTER TABLE `emp_salary`
  MODIFY `emp_salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `fuel_consumption`
--
ALTER TABLE `fuel_consumption`
  MODIFY `fuel_consmp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `petroleum_services`
--
ALTER TABLE `petroleum_services`
  MODIFY `petroleum_service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_transaction`
--
ALTER TABLE `purchase_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `route_voucher_details`
--
ALTER TABLE `route_voucher_details`
  MODIFY `route_v_d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `route_voucher_employee`
--
ALTER TABLE `route_voucher_employee`
  MODIFY `route_v_emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `route_voucher_head`
--
ALTER TABLE `route_voucher_head`
  MODIFY `route_v_h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tyre_shop`
--
ALTER TABLE `tyre_shop`
  MODIFY `tyre_shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vehicle_type`
--
ALTER TABLE `vehicle_type`
  MODIFY `vehical_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_head`
--
ALTER TABLE `account_head`
  ADD CONSTRAINT `account_head_ibfk_1` FOREIGN KEY (`nature_id`) REFERENCES `account_nature` (`id`);

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`org_id`) REFERENCES `organization` (`org_id`);

--
-- Constraints for table `broker`
--
ALTER TABLE `broker`
  ADD CONSTRAINT `broker_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `broker_ibfk_2` FOREIGN KEY (`broker_city`) REFERENCES `cities` (`city_id`);

--
-- Constraints for table `emp_salary`
--
ALTER TABLE `emp_salary`
  ADD CONSTRAINT `emp_salary_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);

--
-- Constraints for table `fuel_consumption`
--
ALTER TABLE `fuel_consumption`
  ADD CONSTRAINT `fuel_consumption_ibfk_1` FOREIGN KEY (`route_voucher_head_id`) REFERENCES `route_voucher_head` (`route_v_h_id`),
  ADD CONSTRAINT `fuel_consumption_ibfk_2` FOREIGN KEY (`petroleum_service`) REFERENCES `petroleum_services` (`petroleum_service_id`);

--
-- Constraints for table `petroleum_services`
--
ALTER TABLE `petroleum_services`
  ADD CONSTRAINT `petroleum_services_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `petroleum_services_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`),
  ADD CONSTRAINT `purchase_ibfk_3` FOREIGN KEY (`tyre_shop_id`) REFERENCES `tyre_shop` (`tyre_shop_id`);

--
-- Constraints for table `purchase_transaction`
--
ALTER TABLE `purchase_transaction`
  ADD CONSTRAINT `purchase_transaction_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`);

--
-- Constraints for table `route_voucher_details`
--
ALTER TABLE `route_voucher_details`
  ADD CONSTRAINT `route_voucher_details_ibfk_1` FOREIGN KEY (`route_v_h_id`) REFERENCES `route_voucher_head` (`route_v_h_id`),
  ADD CONSTRAINT `route_voucher_details_ibfk_2` FOREIGN KEY (`account_head`) REFERENCES `account_heads` (`account_head_id`);

--
-- Constraints for table `route_voucher_employee`
--
ALTER TABLE `route_voucher_employee`
  ADD CONSTRAINT `route_voucher_employee_ibfk_1` FOREIGN KEY (`route_v_h_id`) REFERENCES `route_voucher_head` (`route_v_h_id`),
  ADD CONSTRAINT `route_voucher_employee_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);

--
-- Constraints for table `route_voucher_head`
--
ALTER TABLE `route_voucher_head`
  ADD CONSTRAINT `route_voucher_head_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`),
  ADD CONSTRAINT `route_voucher_head_ibfk_3` FOREIGN KEY (`route_from`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `route_voucher_head_ibfk_4` FOREIGN KEY (`route_to`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `route_voucher_head_ibfk_5` FOREIGN KEY (`broker_id`) REFERENCES `broker` (`broker_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`account_title_id`) REFERENCES `account_title` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`debit_account`) REFERENCES `account_head` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`credit_account`) REFERENCES `account_head` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
