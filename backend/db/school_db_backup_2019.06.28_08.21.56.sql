-- -------------------------------------------
SET AUTOCOMMIT=0;
START TRANSACTION;
SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------
-- -------------------------------------------
-- START BACKUP
-- -------------------------------------------
-- -------------------------------------------
-- TABLE `account_nature`
-- -------------------------------------------
DROP TABLE IF EXISTS `account_nature`;
CREATE TABLE IF NOT EXISTS `account_nature` (
  `account_nature_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_nature_name` varchar(64) NOT NULL,
  `account_nature_status` enum('+ve','-ve') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`account_nature_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `account_register`
-- -------------------------------------------
DROP TABLE IF EXISTS `account_register`;
CREATE TABLE IF NOT EXISTS `account_register` (
  `account_register_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_nature_id` int(11) NOT NULL,
  `account_name` varchar(64) NOT NULL,
  `account_description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`account_register_id`),
  KEY `account_register_account_nature_id` (`account_nature_id`),
  CONSTRAINT `account_register_ibfk_1` FOREIGN KEY (`account_nature_id`) REFERENCES `account_nature` (`account_nature_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `account_transactions`
-- -------------------------------------------
DROP TABLE IF EXISTS `account_transactions`;
CREATE TABLE IF NOT EXISTS `account_transactions` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `account_nature` varchar(11) NOT NULL,
  `account_register_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `description` varchar(200) NOT NULL,
  `total_amount` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `trans_head_account_id` (`account_nature`),
  KEY `trans_head_voucher_type_id` (`account_register_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `account_transactions_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`branch_id`),
  CONSTRAINT `account_transactions_ibfk_4` FOREIGN KEY (`account_register_id`) REFERENCES `account_register` (`account_register_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `auth_assignment`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `auth_item`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `auth_item_child`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `auth_rule`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `branches`
-- -------------------------------------------
DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `branch_code` varchar(32) NOT NULL,
  `branch_name` varchar(32) NOT NULL,
  `branch_type` enum('Franchise','Group') NOT NULL,
  `branch_location` varchar(50) NOT NULL,
  `branch_contact_no` varchar(32) NOT NULL,
  `branch_email` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `branch_head_name` varchar(50) NOT NULL,
  `branch_head_contact_no` varchar(15) NOT NULL,
  `branch_head_email` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`branch_id`),
  KEY `institute_id` (`institute_id`),
  CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`institute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `concession`
-- -------------------------------------------
DROP TABLE IF EXISTS `concession`;
CREATE TABLE IF NOT EXISTS `concession` (
  `concession_id` int(11) NOT NULL AUTO_INCREMENT,
  `concession_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`concession_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `custom_sms`
-- -------------------------------------------
DROP TABLE IF EXISTS `custom_sms`;
CREATE TABLE IF NOT EXISTS `custom_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_to` text NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `departments`
-- -------------------------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) NOT NULL,
  `department_description` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `designation`
-- -------------------------------------------
DROP TABLE IF EXISTS `designation`;
CREATE TABLE IF NOT EXISTS `designation` (
  `designation_id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`designation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emails`
-- -------------------------------------------
DROP TABLE IF EXISTS `emails`;
CREATE TABLE IF NOT EXISTS `emails` (
  `emial_id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_name` varchar(60) NOT NULL,
  `receiver_email` varchar(120) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `email_content` text NOT NULL,
  `email_attachment` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`emial_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emp_attendance`
-- -------------------------------------------
DROP TABLE IF EXISTS `emp_attendance`;
CREATE TABLE IF NOT EXISTS `emp_attendance` (
  `att_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `att_date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `attendance` varchar(2) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`att_id`),
  KEY `emp_id` (`emp_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `emp_attendance_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `emp_info` (`emp_id`),
  CONSTRAINT `emp_attendance_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emp_departments`
-- -------------------------------------------
DROP TABLE IF EXISTS `emp_departments`;
CREATE TABLE IF NOT EXISTS `emp_departments` (
  `emp_department_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  PRIMARY KEY (`emp_department_id`),
  KEY `emp_id` (`emp_id`),
  KEY `department_id` (`dept_id`),
  CONSTRAINT `emp_departments_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `emp_info` (`emp_id`),
  CONSTRAINT `emp_departments_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emp_designation`
-- -------------------------------------------
DROP TABLE IF EXISTS `emp_designation`;
CREATE TABLE IF NOT EXISTS `emp_designation` (
  `emp_designation_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `emp_type_id` int(11) NOT NULL,
  `group_by` enum('Faculty','Non-Faculty') NOT NULL,
  `emp_salary` double NOT NULL,
  `designation_status` enum('Registered','Promotion','Demotion') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`emp_designation_id`),
  KEY `emp_id` (`emp_id`),
  KEY `designation_id` (`designation_id`),
  KEY `emp_type_id` (`emp_type_id`),
  CONSTRAINT `emp_designation_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `emp_info` (`emp_id`),
  CONSTRAINT `emp_designation_ibfk_2` FOREIGN KEY (`designation_id`) REFERENCES `designation` (`designation_id`),
  CONSTRAINT `emp_designation_ibfk_3` FOREIGN KEY (`emp_type_id`) REFERENCES `emp_type` (`emp_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emp_documents`
-- -------------------------------------------
DROP TABLE IF EXISTS `emp_documents`;
CREATE TABLE IF NOT EXISTS `emp_documents` (
  `emp_document_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_info_id` int(11) NOT NULL,
  `emp_document_name` varchar(30) NOT NULL,
  `emp_document` varchar(120) NOT NULL,
  `delete_status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`emp_document_id`),
  KEY `emp_info_id` (`emp_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emp_info`
-- -------------------------------------------
DROP TABLE IF EXISTS `emp_info`;
CREATE TABLE IF NOT EXISTS `emp_info` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_branch_id` int(11) NOT NULL,
  `emp_reg_no` varchar(50) NOT NULL,
  `emp_name` varchar(50) NOT NULL,
  `emp_father_name` varchar(50) NOT NULL,
  `emp_cnic` varchar(15) NOT NULL,
  `emp_contact_no` varchar(15) NOT NULL,
  `emp_perm_address` varchar(200) NOT NULL,
  `emp_temp_address` varchar(200) NOT NULL,
  `emp_marital_status` enum('Single','Married') NOT NULL,
  `emp_fb_ID` varchar(30) NOT NULL,
  `emp_gender` enum('M','F') NOT NULL,
  `emp_date_of_birth` date NOT NULL,
  `emp_religion` varchar(32) NOT NULL,
  `emp_domicile` varchar(32) NOT NULL,
  `emp_photo` varchar(200) NOT NULL,
  `emp_dept_id` int(11) NOT NULL,
  `emp_salary_type` enum('Salaried','Per Lecture') NOT NULL,
  `emp_email` varchar(84) NOT NULL,
  `emp_qualification` varchar(50) NOT NULL,
  `emp_passing_year` int(11) NOT NULL,
  `emp_institute_name` varchar(50) NOT NULL,
  `degree_scan_copy` varchar(200) NOT NULL,
  `emp_cv` varchar(200) NOT NULL,
  `barcode` longblob NOT NULL,
  `emp_status` enum('Active','Inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`emp_id`),
  KEY `emp_branch_id` (`emp_branch_id`),
  KEY `emp_dept_id` (`emp_dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emp_leave`
-- -------------------------------------------
DROP TABLE IF EXISTS `emp_leave`;
CREATE TABLE IF NOT EXISTS `emp_leave` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `leave_type` enum('Casual Leave','Medical Leave','','') NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `applying_date` date NOT NULL,
  `no_of_days` int(5) NOT NULL,
  `leave_purpose` varchar(100) NOT NULL,
  `status` enum('Accepted','Rejected','Pending') NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`app_id`),
  KEY `emp_id` (`emp_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emp_reference`
-- -------------------------------------------
DROP TABLE IF EXISTS `emp_reference`;
CREATE TABLE IF NOT EXISTS `emp_reference` (
  `emp_ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `ref_name` varchar(50) NOT NULL,
  `ref_contact_no` varchar(15) NOT NULL,
  `ref_cnic` varchar(15) NOT NULL,
  `ref_designation` varchar(100) NOT NULL,
  PRIMARY KEY (`emp_ref_id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `emp_type`
-- -------------------------------------------
DROP TABLE IF EXISTS `emp_type`;
CREATE TABLE IF NOT EXISTS `emp_type` (
  `emp_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`emp_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `event`
-- -------------------------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `events`
-- -------------------------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(80) NOT NULL,
  `event_detail` text NOT NULL,
  `event_venue` varchar(100) NOT NULL,
  `event_start_datetime` datetime NOT NULL,
  `event_end_datetime` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_status` enum('Active','Inactive') NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `exams_category`
-- -------------------------------------------
DROP TABLE IF EXISTS `exams_category`;
CREATE TABLE IF NOT EXISTS `exams_category` (
  `exam_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) NOT NULL,
  `description` varchar(300) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`exam_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `exams_criteria`
-- -------------------------------------------
DROP TABLE IF EXISTS `exams_criteria`;
CREATE TABLE IF NOT EXISTS `exams_criteria` (
  `exam_criteria_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_category_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `exam_start_date` date NOT NULL,
  `exam_end_date` date NOT NULL,
  `exam_status` varchar(50) NOT NULL,
  `exam_type` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`exam_criteria_id`),
  KEY `exam_category_id` (`exam_category_id`,`class_id`),
  KEY `std_enroll_head_id` (`class_id`),
  CONSTRAINT `exams_criteria_ibfk_1` FOREIGN KEY (`exam_category_id`) REFERENCES `exams_category` (`exam_category_id`),
  CONSTRAINT `exams_criteria_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `std_class_name` (`class_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `exams_room`
-- -------------------------------------------
DROP TABLE IF EXISTS `exams_room`;
CREATE TABLE IF NOT EXISTS `exams_room` (
  `exam_room_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_schedule_id` int(11) NOT NULL,
  `class_head_id` int(11) NOT NULL,
  `exam_room` int(15) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `invigilator_attend` varchar(2) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`exam_room_id`),
  KEY `exams_room_ibfk_2` (`class_head_id`),
  KEY `exams_room_ibfk_1` (`exam_schedule_id`),
  KEY `emp_id` (`emp_id`),
  KEY `exam_room` (`exam_room`),
  CONSTRAINT `exams_room_ibfk_1` FOREIGN KEY (`exam_schedule_id`) REFERENCES `exams_schedule` (`exam_schedule_id`),
  CONSTRAINT `exams_room_ibfk_2` FOREIGN KEY (`exam_room`) REFERENCES `rooms` (`room_id`),
  CONSTRAINT `exams_room_ibfk_3` FOREIGN KEY (`emp_id`) REFERENCES `emp_info` (`emp_id`),
  CONSTRAINT `exams_room_ibfk_4` FOREIGN KEY (`class_head_id`) REFERENCES `std_enrollment_head` (`std_enroll_head_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `exams_schedule`
-- -------------------------------------------
DROP TABLE IF EXISTS `exams_schedule`;
CREATE TABLE IF NOT EXISTS `exams_schedule` (
  `exam_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_criteria_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `exam_start_time` time NOT NULL,
  `exam_end_time` time NOT NULL,
  `full_marks` int(5) NOT NULL,
  `passing_marks` int(5) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`exam_schedule_id`),
  KEY `exam_criteria_id` (`exam_criteria_id`,`subject_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `exams_schedule_ibfk_1` FOREIGN KEY (`exam_criteria_id`) REFERENCES `exams_criteria` (`exam_criteria_id`),
  CONSTRAINT `exams_schedule_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `fee_month_detail`
-- -------------------------------------------
DROP TABLE IF EXISTS `fee_month_detail`;
CREATE TABLE IF NOT EXISTS `fee_month_detail` (
  `month_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(11) NOT NULL,
  `month` varchar(10) NOT NULL,
  `monthly_amount` double NOT NULL,
  PRIMARY KEY (`month_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `fee_transaction_detail`
-- -------------------------------------------
DROP TABLE IF EXISTS `fee_transaction_detail`;
CREATE TABLE IF NOT EXISTS `fee_transaction_detail` (
  `fee_trans_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_trans_detail_head_id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `fee_amount` double DEFAULT NULL,
  `collected_fee_amount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fee_trans_detail_id`),
  KEY `fee_trans_detail_head_id` (`fee_trans_detail_head_id`),
  KEY `fee_type_id` (`fee_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `fee_transaction_head`
-- -------------------------------------------
DROP TABLE IF EXISTS `fee_transaction_head`;
CREATE TABLE IF NOT EXISTS `fee_transaction_head` (
  `fee_trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `class_name_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL,
  `std_name` varchar(75) NOT NULL,
  `month` varchar(20) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `total_amount` double NOT NULL,
  `paid_amount` double NOT NULL,
  `remaining` double NOT NULL,
  `collection_date` datetime NOT NULL,
  `status` enum('Paid','Unpaid','Partially Paid','Added to next month') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fee_trans_id`),
  KEY `std_id` (`std_id`),
  KEY `month_id` (`month`),
  KEY `class_name_id` (`class_name_id`),
  KEY `session_id` (`session_id`),
  KEY `section_id` (`section_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `fee_type`
-- -------------------------------------------
DROP TABLE IF EXISTS `fee_type`;
CREATE TABLE IF NOT EXISTS `fee_type` (
  `fee_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_type_name` varchar(64) NOT NULL,
  `fee_type_description` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fee_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `grades`
-- -------------------------------------------
DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(5) NOT NULL,
  `grade_from` int(5) NOT NULL,
  `grade_to` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `installment`
-- -------------------------------------------
DROP TABLE IF EXISTS `installment`;
CREATE TABLE IF NOT EXISTS `installment` (
  `installment_id` int(11) NOT NULL AUTO_INCREMENT,
  `installment_name` varchar(20) NOT NULL,
  PRIMARY KEY (`installment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `institute`
-- -------------------------------------------
DROP TABLE IF EXISTS `institute`;
CREATE TABLE IF NOT EXISTS `institute` (
  `institute_id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_name` varchar(65) NOT NULL,
  `institute_logo` varchar(200) NOT NULL,
  `institute_account_no` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`institute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `institute_name`
-- -------------------------------------------
DROP TABLE IF EXISTS `institute_name`;
CREATE TABLE IF NOT EXISTS `institute_name` (
  `Institute_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `Institute_name` varchar(100) NOT NULL,
  `Institutte_address` varchar(120) NOT NULL,
  `Institute_contact_no` varchar(12) NOT NULL,
  `head_name` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Institute_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `marks_details`
-- -------------------------------------------
DROP TABLE IF EXISTS `marks_details`;
CREATE TABLE IF NOT EXISTS `marks_details` (
  `marks_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `marks_head_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`marks_detail_id`),
  KEY `marks_head_id` (`marks_head_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `marks_details_ibfk_1` FOREIGN KEY (`marks_head_id`) REFERENCES `marks_head` (`marks_head_id`),
  CONSTRAINT `marks_details_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `marks_details_weightage`
-- -------------------------------------------
DROP TABLE IF EXISTS `marks_details_weightage`;
CREATE TABLE IF NOT EXISTS `marks_details_weightage` (
  `marks_details_weightage_id` int(11) NOT NULL AUTO_INCREMENT,
  `marks_details_id` int(11) NOT NULL,
  `weightage_type_id` int(11) NOT NULL,
  `obtained_marks` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`marks_details_weightage_id`),
  KEY `marks_details_id` (`marks_details_id`),
  KEY `weightage_type_id` (`weightage_type_id`),
  CONSTRAINT `marks_details_weightage_ibfk_1` FOREIGN KEY (`marks_details_id`) REFERENCES `marks_details` (`marks_detail_id`),
  CONSTRAINT `marks_details_weightage_ibfk_2` FOREIGN KEY (`weightage_type_id`) REFERENCES `marks_weightage_type` (`weightage_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `marks_head`
-- -------------------------------------------
DROP TABLE IF EXISTS `marks_head`;
CREATE TABLE IF NOT EXISTS `marks_head` (
  `marks_head_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_criteria_id` int(11) NOT NULL,
  `class_head_id` int(10) NOT NULL,
  `std_id` int(11) NOT NULL,
  `grand_total` double NOT NULL,
  `percentage` varchar(10) NOT NULL,
  `grade` varchar(3) NOT NULL,
  `exam_status` varchar(6) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`marks_head_id`),
  KEY `std_id` (`std_id`),
  KEY `exam_criteria_id` (`exam_criteria_id`),
  KEY `class_head_id` (`class_head_id`),
  CONSTRAINT `marks_head_ibfk_1` FOREIGN KEY (`exam_criteria_id`) REFERENCES `exams_criteria` (`exam_criteria_id`),
  CONSTRAINT `marks_head_ibfk_2` FOREIGN KEY (`class_head_id`) REFERENCES `std_enrollment_head` (`std_enroll_head_id`),
  CONSTRAINT `marks_head_ibfk_3` FOREIGN KEY (`std_id`) REFERENCES `std_personal_info` (`std_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `marks_weightage_details`
-- -------------------------------------------
DROP TABLE IF EXISTS `marks_weightage_details`;
CREATE TABLE IF NOT EXISTS `marks_weightage_details` (
  `weightage_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `weightage_head_id` int(11) NOT NULL,
  `weightage_type_id` int(11) NOT NULL,
  `marks` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`weightage_detail_id`),
  KEY `weightage_head_id` (`weightage_head_id`),
  KEY `weightage_type_id` (`weightage_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `marks_weightage_head`
-- -------------------------------------------
DROP TABLE IF EXISTS `marks_weightage_head`;
CREATE TABLE IF NOT EXISTS `marks_weightage_head` (
  `marks_weightage_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_category_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subjects_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`marks_weightage_id`),
  KEY `exam_category_id` (`exam_category_id`),
  KEY `subjects_id` (`subjects_id`),
  KEY `marks_weightage_head_ibfk_2` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `marks_weightage_type`
-- -------------------------------------------
DROP TABLE IF EXISTS `marks_weightage_type`;
CREATE TABLE IF NOT EXISTS `marks_weightage_type` (
  `weightage_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `weightage_type_name` varchar(30) NOT NULL,
  `weightage_type_description` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`weightage_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `migration`
-- -------------------------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `msg_of_day`
-- -------------------------------------------
DROP TABLE IF EXISTS `msg_of_day`;
CREATE TABLE IF NOT EXISTS `msg_of_day` (
  `msg_of_day_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_details` varchar(100) NOT NULL,
  `msg_user_type` enum('Students','Parents','Employees','Others') NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_status` enum('Active','Inactive') NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`msg_of_day_id`),
  UNIQUE KEY `msg_details` (`msg_details`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `notice`
-- -------------------------------------------
DROP TABLE IF EXISTS `notice`;
CREATE TABLE IF NOT EXISTS `notice` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_title` varchar(25) NOT NULL,
  `notice_description` text,
  `notice_start` datetime NOT NULL,
  `notice_end` datetime NOT NULL,
  `notice_user_type` enum('Students','Parents','Employees','Others') NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_status` enum('Active','Inactive') NOT NULL,
  PRIMARY KEY (`notice_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `remarks_head`
-- -------------------------------------------
DROP TABLE IF EXISTS `remarks_head`;
CREATE TABLE IF NOT EXISTS `remarks_head` (
  `remarks_head_id` int(11) NOT NULL AUTO_INCREMENT,
  `remarks_head_name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`remarks_head_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `rooms`
-- -------------------------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `sms`
-- -------------------------------------------
DROP TABLE IF EXISTS `sms`;
CREATE TABLE IF NOT EXISTS `sms` (
  `sms_id` int(11) NOT NULL AUTO_INCREMENT,
  `sms_name` varchar(120) NOT NULL,
  `sms_template` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_academic_info`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_academic_info`;
CREATE TABLE IF NOT EXISTS `std_academic_info` (
  `academic_id` int(11) NOT NULL AUTO_INCREMENT,
  `std_id` int(11) NOT NULL,
  `class_name_id` int(11) NOT NULL,
  `subject_combination` int(11) NOT NULL,
  `previous_class` varchar(50) NOT NULL,
  `passing_year` int(32) DEFAULT NULL,
  `previous_class_rollno` int(11) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `obtained_marks` int(11) DEFAULT NULL,
  `grades` varchar(10) NOT NULL,
  `percentage` varchar(5) DEFAULT NULL,
  `Institute` varchar(50) NOT NULL,
  `std_enroll_status` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`academic_id`),
  KEY `std_id` (`std_id`),
  KEY `class_name_id` (`class_name_id`),
  KEY `subject_combination` (`subject_combination`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_attendance`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_attendance`;
CREATE TABLE IF NOT EXISTS `std_attendance` (
  `std_attend_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_name_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`std_attend_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `class_id` (`class_name_id`),
  KEY `student_id` (`student_id`),
  KEY `session_id` (`session_id`),
  KEY `section_id` (`section_id`),
  KEY `subject_id` (`subject_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_class_name`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_class_name`;
CREATE TABLE IF NOT EXISTS `std_class_name` (
  `class_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `class_name` varchar(120) NOT NULL,
  `class_name_description` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`class_name_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_enrollment_detail`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_enrollment_detail`;
CREATE TABLE IF NOT EXISTS `std_enrollment_detail` (
  `std_enroll_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `std_enroll_detail_head_id` int(11) NOT NULL,
  `std_reg_no` varchar(15) NOT NULL,
  `std_roll_no` varchar(32) NOT NULL,
  `std_enroll_detail_std_id` int(11) NOT NULL,
  `std_enroll_detail_std_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`std_enroll_detail_id`),
  KEY `std_enroll_detail_head_id` (`std_enroll_detail_head_id`),
  KEY `std_enroll_detail_std_id` (`std_enroll_detail_std_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_enrollment_head`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_enrollment_head`;
CREATE TABLE IF NOT EXISTS `std_enrollment_head` (
  `std_enroll_head_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `class_name_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `std_enroll_head_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`std_enroll_head_id`),
  KEY `class_name_id` (`class_name_id`),
  KEY `session_id` (`session_id`),
  KEY `section_id` (`section_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_fee_details`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_fee_details`;
CREATE TABLE IF NOT EXISTS `std_fee_details` (
  `fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `std_id` int(11) NOT NULL,
  `admission_fee` double NOT NULL,
  `addmission_fee_discount` int(11) NOT NULL,
  `net_addmission_fee` double NOT NULL,
  `concession_id` int(11) NOT NULL,
  `tuition_fee` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fee_id`),
  KEY `std_id` (`std_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_fee_installments`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_fee_installments`;
CREATE TABLE IF NOT EXISTS `std_fee_installments` (
  `fee_installment_id` int(11) NOT NULL AUTO_INCREMENT,
  `std_fee_id` int(11) NOT NULL,
  `installment_no` int(11) NOT NULL,
  `installment_amount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`fee_installment_id`),
  KEY `std_fee_id` (`std_fee_id`),
  KEY `installment_no` (`installment_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_fee_pkg`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_fee_pkg`;
CREATE TABLE IF NOT EXISTS `std_fee_pkg` (
  `std_fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `admission_fee` double NOT NULL,
  `tutuion_fee` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`std_fee_id`),
  KEY `session_id` (`session_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_guardian_info`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_guardian_info`;
CREATE TABLE IF NOT EXISTS `std_guardian_info` (
  `std_guardian_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `std_id` int(11) NOT NULL,
  `guardian_name` varchar(50) NOT NULL,
  `guardian_relation` varchar(50) NOT NULL,
  `guardian_cnic` varchar(15) NOT NULL,
  `guardian_email` varchar(84) NOT NULL,
  `guardian_contact_no_1` varchar(15) NOT NULL,
  `guardian_contact_no_2` varchar(15) NOT NULL,
  `guardian_monthly_income` int(11) DEFAULT NULL,
  `guardian_occupation` varchar(50) NOT NULL,
  `guardian_designation` varchar(100) NOT NULL,
  `guardian_password` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`std_guardian_info_id`),
  KEY `std_id` (`std_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_ice_info`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_ice_info`;
CREATE TABLE IF NOT EXISTS `std_ice_info` (
  `std_ice_id` int(11) NOT NULL AUTO_INCREMENT,
  `std_id` int(11) NOT NULL,
  `std_ice_name` varchar(64) NOT NULL,
  `std_ice_relation` varchar(64) NOT NULL,
  `std_ice_contact_no` varchar(15) NOT NULL,
  `std_ice_address` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`std_ice_id`),
  KEY `std_id` (`std_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_inquiry`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_inquiry`;
CREATE TABLE IF NOT EXISTS `std_inquiry` (
  `std_inquiry_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `std_inquiry_no` varchar(15) NOT NULL,
  `inquiry_session` varchar(20) NOT NULL,
  `std_name` varchar(32) NOT NULL,
  `std_father_name` varchar(32) NOT NULL,
  `gender` enum('Female','Male') NOT NULL,
  `std_contact_no` varchar(15) NOT NULL,
  `std_father_contact_no` varchar(15) NOT NULL,
  `std_inquiry_date` date NOT NULL,
  `std_intrested_class` varchar(50) NOT NULL,
  `std_previous_class` varchar(32) NOT NULL,
  `previous_institute` varchar(120) NOT NULL,
  `std_roll_no` varchar(10) NOT NULL,
  `std_obtained_marks` int(4) NOT NULL,
  `std_total_marks` int(4) NOT NULL,
  `std_percentage` varchar(6) NOT NULL,
  `refrence_name` varchar(32) NOT NULL,
  `refrence_contact_no` varchar(15) NOT NULL,
  `refrence_designation` varchar(30) NOT NULL,
  `std_address` varchar(200) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `inquiry_status` enum('Inquiry','Registered') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`std_inquiry_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_personal_info`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_personal_info`;
CREATE TABLE IF NOT EXISTS `std_personal_info` (
  `std_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `std_reg_no` varchar(50) NOT NULL,
  `std_name` varchar(50) NOT NULL,
  `std_father_name` varchar(50) NOT NULL,
  `std_contact_no` varchar(15) NOT NULL,
  `std_DOB` date NOT NULL,
  `std_gender` enum('Male','Female') NOT NULL,
  `std_permanent_address` varchar(255) NOT NULL,
  `std_temporary_address` varchar(255) NOT NULL,
  `std_email` varchar(84) NOT NULL,
  `std_photo` varchar(200) NOT NULL,
  `std_b_form` varchar(255) NOT NULL,
  `admission_date` date NOT NULL,
  `std_cast` varchar(50) NOT NULL,
  `std_district` varchar(50) NOT NULL,
  `std_religion` varchar(50) NOT NULL,
  `std_nationality` varchar(50) NOT NULL,
  `std_tehseel` varchar(50) NOT NULL,
  `std_password` varchar(20) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `academic_status` enum('Active','Promote','Left','Struck off') NOT NULL,
  `barcode` longblob NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`std_id`),
  UNIQUE KEY `std_reg_no` (`std_reg_no`),
  KEY `std_name` (`std_name`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_remarks`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_remarks`;
CREATE TABLE IF NOT EXISTS `std_remarks` (
  `std_remarks_id` int(11) NOT NULL AUTO_INCREMENT,
  `remarks_head_id` int(11) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`std_remarks_id`),
  KEY `remarks_head_id` (`remarks_head_id`),
  CONSTRAINT `std_remarks_ibfk_1` FOREIGN KEY (`remarks_head_id`) REFERENCES `remarks_head` (`remarks_head_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_sections`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_sections`;
CREATE TABLE IF NOT EXISTS `std_sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `section_description` varchar(100) NOT NULL,
  `section_intake` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`section_id`),
  KEY `session_id` (`session_id`),
  KEY `branch_id` (`branch_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `std_sections_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `std_class_name` (`class_name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_sessions`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_sessions`;
CREATE TABLE IF NOT EXISTS `std_sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_branch_id` int(11) NOT NULL,
  `session_name` varchar(32) NOT NULL,
  `session_start_date` date NOT NULL,
  `session_end_date` date NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `installment_cycle` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`session_id`),
  KEY `session_branch_id` (`session_branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `std_subjects`
-- -------------------------------------------
DROP TABLE IF EXISTS `std_subjects`;
CREATE TABLE IF NOT EXISTS `std_subjects` (
  `std_subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `std_subject_name` varchar(200) NOT NULL,
  PRIMARY KEY (`std_subject_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `subjects`
-- -------------------------------------------
DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(32) NOT NULL,
  `subject_alias` varchar(10) NOT NULL,
  `subject_description` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `teacher_subject_assign_detail`
-- -------------------------------------------
DROP TABLE IF EXISTS `teacher_subject_assign_detail`;
CREATE TABLE IF NOT EXISTS `teacher_subject_assign_detail` (
  `teacher_subject_assign_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_subject_assign_detail_head_id` int(11) NOT NULL,
  `incharge` tinyint(4) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `no_of_lecture` enum('1 Lecture','2 Lectures','3 Lectures','4 Lectures','5 Lectures','6 Lectures','Full Week') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`teacher_subject_assign_detail_id`),
  KEY `teacher_subject_assign_detail_head_id` (`teacher_subject_assign_detail_head_id`),
  KEY `subject_id` (`subject_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `teacher_subject_assign_head`
-- -------------------------------------------
DROP TABLE IF EXISTS `teacher_subject_assign_head`;
CREATE TABLE IF NOT EXISTS `teacher_subject_assign_head` (
  `teacher_subject_assign_head_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `teacher_subject_assign_head_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`teacher_subject_assign_head_id`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `time_table_detail`
-- -------------------------------------------
DROP TABLE IF EXISTS `time_table_detail`;
CREATE TABLE IF NOT EXISTS `time_table_detail` (
  `time_table_d_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_table_h_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(10) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`time_table_d_id`),
  KEY `time_table_h_id` (`time_table_h_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `time_table_detail_ibfk_1` FOREIGN KEY (`time_table_h_id`) REFERENCES `time_table_head` (`time_table_h_id`),
  CONSTRAINT `time_table_detail_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `time_table_head`
-- -------------------------------------------
DROP TABLE IF EXISTS `time_table_head`;
CREATE TABLE IF NOT EXISTS `time_table_head` (
  `time_table_h_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `days` varchar(200) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`time_table_h_id`),
  KEY `time_table_head_ibfk_1` (`class_id`),
  CONSTRAINT `time_table_head_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `std_enrollment_head` (`std_enroll_head_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `user`
-- -------------------------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'example@gmail.com',
  `user_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_photo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `is_block` tinyint(4) NOT NULL DEFAULT '1',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------
-- TABLE `users`
-- -------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE `visitors`
-- -------------------------------------------
DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `visitor_id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_name` varchar(30) NOT NULL,
  `visitor_contact_no` varchar(15) NOT NULL,
  `visitor_photo` varchar(200) NOT NULL,
  `visitor_cnic` varchar(30) NOT NULL,
  `date_time` datetime NOT NULL,
  `visit_purpose` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`visitor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- -------------------------------------------
-- TABLE DATA account_nature
-- -------------------------------------------
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','CURRENT ASSETS','+ve','2019-06-11 13:06:59','2019-06-14 10:15:05','1','1');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','ACCOUNT RECEIVABLE','+ve','2019-06-11 13:08:12','2019-06-14 10:15:43','1','1');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','STOCK','+ve','2019-06-11 13:09:55','2019-06-14 10:16:01','1','1');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','NON-CURRENT ASSETS','+ve','2019-06-11 13:10:20','2019-06-14 10:16:27','1','1');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','FIXED ASSETS','+ve','2019-06-11 13:11:27','2019-06-14 10:16:38','1','1');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','OTHER ASSETS','+ve','2019-06-13 12:42:14','2019-06-14 10:14:44','1','1');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','SALARIES & OTHER BEFITS','-ve','2019-06-14 10:42:44','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('8','TRANSPORTATION','-ve','2019-06-14 10:43:21','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('9','RENT, RATE & TAXES','-ve','2019-06-14 10:43:44','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('10','UTILITY EXPENSES','-ve','2019-06-14 10:44:04','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('11','AFFILIATION / REGISTRATION EXPENSE','-ve','2019-06-14 10:44:26','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('12','ADVERTISEMENT & MARKETING EXPENSE','-ve','2019-06-14 10:45:22','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('13','PRINTING & STATIONARY','-ve','2019-06-14 10:45:41','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('14','STUDENT EXTRA CURRICULAR ACTICITIES','-ve','2019-06-14 10:46:10','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('15','REPAIR & MAINTENANCE','-ve','2019-06-14 10:46:36','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('16','TRAVELLING & CONVEYANCE','-ve','2019-06-14 10:46:55','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('17','ENTERTAINMENT EXPENSE ','-ve','2019-06-14 10:47:23','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('18','LEGAL & PROFESSIONAL EXPENSE','-ve','2019-06-14 10:47:47','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('19','LAB CONSUMABLES','-ve','2019-06-14 10:48:05','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('20','RESEARCH & DEVELOPMENT','-ve','2019-06-14 10:48:22','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('21','GENERAL ADMINISTRATIVE EXPENSE','-ve','2019-06-15 09:33:31','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('22','GENERAL EXPENSES','-ve','2019-06-15 09:33:53','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('23','WELFARE EXPENSES','-ve','2019-06-15 09:34:23','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('24','FINANCIAL CHARGES','-ve','2019-06-15 09:35:21','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('25','REWARDS & SCHOLARSHIP','-ve','2019-06-15 09:35:50','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('26','REVENUE','+ve','2019-06-15 09:36:11','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('27','ADVANCES & PAYMENTS','-ve','2019-06-15 09:36:47','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_nature` (`account_nature_id`,`account_nature_name`,`account_nature_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('28','CAPITAL','+ve','2019-06-15 09:37:08','0000-00-00 00:00:00','1','0');;;
-- -------------------------------------------
-- TABLE DATA account_register
-- -------------------------------------------
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','1','BANK ACCOUNT','Bank account description','2019-06-15 09:38:22','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','1','PETTY CASH','Petty cash description','2019-06-15 09:38:51','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','1','CASH COUNTER','Cash Counter Description','2019-06-15 09:39:20','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','1','PRINICIPAL A/C','Principal Account Description','2019-06-15 09:39:59','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','4','SECURITY DEPOSIT','Security Deposit Description','2019-06-15 09:40:35','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','4','INVESTEMENT','Investment Description','2019-06-15 09:41:14','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','4','PREPAID EXPENSE','Prepaid Expense','2019-06-15 09:41:43','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('8','5','LAND ','Land Description','2019-06-15 09:42:24','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('9','5','BUILDING ','Building Description','2019-06-15 09:43:02','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('10','5','FURNITURE & FIXTURE ','Furniture & Fixture Description ','2019-06-15 10:30:54','2019-06-15 10:31:12','1','1');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('11','5','OFFFICE EQUIPMENTS','Office Equipments Description
','2019-06-15 10:34:16','2019-06-15 10:35:20','1','1');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('12','5','EDUCATIONAL EQUIPMENTS','Educational Equipments Description','2019-06-15 10:35:07','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('13','5','PHYSICS LABORATORIES EQUIPMENTS','Physics Laboratories Equipments Description','2019-06-15 11:36:12','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('14','5','CHEMISTRY LABORATORIES EQUIPMENTS','Chemistry Laboatories Equipments Description','2019-06-15 11:38:09','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('15','5','BIO LABORATORIES EQUIPMENTS','Bio Laboratories Equipments Description','2019-06-15 11:39:32','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('16','5','COMPUTER LAB EQUIPMENTS','Computer Lab Equipments Description','2019-06-15 11:40:27','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('17','5','STAFF VECHILES','Staff Vechiles Description','2019-06-15 11:41:21','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('18','5','ELECTRIC GENERATOR','Electric Generator Description','2019-06-15 11:41:57','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('19','5','ELECTRIC INSTALLATION ','Electric Installation Description ','2019-06-15 11:42:42','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('20','5','LIBRARY BOOKS','Library Books Description
','2019-06-15 11:43:45','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('21','5','SPORTS EQUIPMENTS','Sports Equipments Description','2019-06-15 11:44:21','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('22','5','MUSICAL EQUIPMENTS','Musical Equipments Description
','2019-06-15 11:45:07','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('23','5','GROUND EQUIPMENTS','Ground Equipments Description','2019-06-15 11:45:39','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('24','5','COMPUTER','Computer Description
','2019-06-15 11:46:03','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('25','5','AIR CONDITIONRS','Air Conditionrs Description','2019-06-15 11:46:48','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('26','5','KITCHEN ACCESSORIES','Kitchen Accessories Description','2019-06-15 11:47:36','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('27','5','WORK IN PROGRESS','Work In Progress Description','2019-06-15 11:48:14','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('28','7','SALARIES - PERMANENT STAFF','Salaries - Permanent Staff Description','2019-06-15 11:49:43','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('29','7','EXTRA LECTURE ANNUAL','Extra Lectures Annual Description','2019-06-15 11:50:25','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('30','7','SALARIES AND WAGES  - CLEANIN STAFF','Salaries And Wages - Cleanin Staff Description','2019-06-15 11:51:47','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('31','7','PROVIDENT FUND','Provident Fund Description','2019-06-15 11:52:28','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('32','7','OVERTIMES','Overtimes Description','2019-06-15 11:52:56','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('33','7','BONUS','Bonus Description','2019-06-15 11:53:22','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('34','7','EOBI CONTRIBUTION ','Eobi Contribution Description','2019-06-15 11:54:02','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('35','8','VECHILE RENT & SUBSI','Vechile Rent & Subsi Description','2019-06-15 11:54:55','0000-00-00 00:00:00','1','0');;;
INSERT INTO `account_register` (`account_register_id`,`account_nature_id`,`account_name`,`account_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('36','8','TRANSPORTATION VECHILE FUEL EXPENSES','Transportation Vechile Fuel Expenses Description','0000-00-00 00:00:00','0000-00-00 00:00:00','0','0');;;
-- -------------------------------------------
-- TABLE DATA account_transactions
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA auth_assignment
-- -------------------------------------------
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('Accountant','6','');;;
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('dexdevs','1','');;;
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('dexdevs2','4','');;;
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('Inquiry Head','48','');;;
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('Principal','7','');;;
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('Superadmin','3','');;;
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('Vice Principal','5','');;;
-- -------------------------------------------
-- TABLE DATA auth_item
-- -------------------------------------------
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('Accountant','1','can login','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('add-institute','1','create institute Name','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('dexdevs','1','Admin of the application','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('dexdevs2','1','','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('Inquiry Head','1','Inquiry Head can manage activities of student inquiries only.','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('inquiry-nav','1','can access this nav','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('login','1','The user can login in the admin panel.','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('navigation ','1','Navigation can be access authorized users only.','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('Principal','1','Principal can manage whole activities in the application except account department','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('Superadmin','1','Superadmin can manage whole activities in the application.','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('update-institute-name','1','can update the institute name.','','','','');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('Vice Principal','1','Can view whole reports.','','','','');;;
-- -------------------------------------------
-- TABLE DATA auth_item_child
-- -------------------------------------------
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Accountant','login');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('dexdevs','login');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('dexdevs','navigation ');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('dexdevs2','login');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('dexdevs2','navigation ');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Inquiry Head','add-institute');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Inquiry Head','inquiry-nav');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Inquiry Head','login');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Principal','login');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Principal','navigation ');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Superadmin','login');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Superadmin','navigation ');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Vice Principal','login');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('Vice Principal','navigation ');;;
-- -------------------------------------------
-- TABLE DATA auth_rule
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA branches
-- -------------------------------------------
INSERT INTO `branches` (`branch_id`,`institute_id`,`branch_code`,`branch_name`,`branch_type`,`branch_location`,`branch_contact_no`,`branch_email`,`status`,`branch_head_name`,`branch_head_contact_no`,`branch_head_email`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','2','RYK01','Main Branch','Group','Dawood Pull, Habib Colony ','068-58-75860','abclearning@gmail.com','Active','Ma\'am Nasreen Akram','+92-333-7668866','nasreenakram@gmail.com','2019-03-16 12:01:14','2019-03-16 12:01:14','1','1','1');;;
INSERT INTO `branches` (`branch_id`,`institute_id`,`branch_code`,`branch_name`,`branch_type`,`branch_location`,`branch_contact_no`,`branch_email`,`status`,`branch_head_name`,`branch_head_contact_no`,`branch_head_email`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','2','RYK02','Sub Campus','Group','Business Man Colony','068-58-87526','subcampus@gmail.com','Active','Ma\'am Nadia Gull','+92-345-3456787','nadiagull@gmail.com','2019-03-16 12:03:19','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA concession
-- -------------------------------------------
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','100% Concession ','0000-00-00 00:00:00','0000-00-00 00:00:00','1','1','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','90% Concession ','2019-01-10 13:16:15','0000-00-00 00:00:00','1','1','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','80% Concession','2019-01-10 13:16:39','2019-01-10 13:16:39','1','1','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','70% Concession','2019-01-10 13:16:54','2019-01-10 13:16:54','1','1','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','60% Concession','2019-01-10 13:17:28','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','50% Concession','2019-01-10 13:17:47','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','40% Concession ','2019-01-10 13:18:40','2019-01-10 13:18:40','1','1','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','30% Concession','2019-01-10 13:18:08','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','25% Concession','2019-01-10 13:18:19','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `concession` (`concession_id`,`concession_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('10','Kinship','2019-01-10 13:18:27','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA custom_sms
-- -------------------------------------------
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','923063772105','<p>Hello,</p><p>This is testing <b><i>SMS.</i></b></p>','2019-03-08 20:24:28','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','923063772106','<p>

Testing <b><i>SMS.</i></b>

<br></p>','2019-03-08 21:02:54','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','923317375027','<p>Testing SMS from web application.</p>','2019-03-08 21:08:41','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','923063772106','This is testing SMS from Brookfield.','2019-03-08 21:14:43','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','923063772105','Testing SMS.','2019-03-08 21:23:59','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','923063772106','Testing SMS.','2019-03-08 21:26:31','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('8','923063772106','Testing SMS.','2019-03-08 21:36:02','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('9','923041422508','This is testing SMS by DEXDEVS from Brookfield web application.','2019-03-08 21:37:40','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('10','923063772105','This is testing SMS by DEXDEVS from Brookfield web application.','2019-03-08 21:39:10','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('11','923356383287','This is testing SMS by DEXDEVS from Brookfield web application.','2019-03-08 21:40:13','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('12','923006773327','This is testing SMS by DEXDEVS from Brookfield web application.','2019-03-08 21:41:07','0000-00-00 00:00:00','8','0');;;
INSERT INTO `custom_sms` (`id`,`send_to`,`message`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('13','923006999824','This is testing SMS by DEXDEVS from Brookfield web application.

Task completed by Nauman & Anas.','2019-03-08 21:42:14','0000-00-00 00:00:00','8','0');;;
-- -------------------------------------------
-- TABLE DATA departments
-- -------------------------------------------
INSERT INTO `departments` (`department_id`,`department_name`,`department_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','Computer Science Department','Computer Science Department','2019-02-19 10:42:48','0000-00-00 00:00:00','3','0');;;
INSERT INTO `departments` (`department_id`,`department_name`,`department_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','Biology Department','Biology Department','2019-02-19 10:43:07','0000-00-00 00:00:00','3','0');;;
INSERT INTO `departments` (`department_id`,`department_name`,`department_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','Chemistry Department','Chemistry Department','2019-02-19 10:43:25','0000-00-00 00:00:00','3','0');;;
INSERT INTO `departments` (`department_id`,`department_name`,`department_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','Physics Department','Physics Department','2019-02-19 10:43:44','0000-00-00 00:00:00','3','0');;;
INSERT INTO `departments` (`department_id`,`department_name`,`department_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','Mathematics Department','Mathematics Department','2019-02-19 10:44:16','0000-00-00 00:00:00','3','0');;;
INSERT INTO `departments` (`department_id`,`department_name`,`department_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','Urdu Department','Urdu Department','2019-02-19 10:44:42','0000-00-00 00:00:00','3','0');;;
INSERT INTO `departments` (`department_id`,`department_name`,`department_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','English Department','English Department','2019-02-19 10:45:05','0000-00-00 00:00:00','3','0');;;
-- -------------------------------------------
-- TABLE DATA designation
-- -------------------------------------------
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','Vice Principal','2019-04-27 13:49:01','2018-10-31 13:17:30','1','1','1');;;
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','Coordinator','2018-10-31 13:23:02','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','Teacher','2018-10-31 13:23:21','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','Security Gaurd','2018-10-31 14:55:43','2018-10-31 14:55:43','1','1','1');;;
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','Accountant','2018-12-07 11:29:32','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','Librarian','2019-01-14 22:59:26','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','Office Boy','2019-02-20 18:33:12','0000-00-00 00:00:00','9','0','1');;;
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','HOD','2019-02-22 12:33:33','2019-02-22 12:33:33','9','8','1');;;
INSERT INTO `designation` (`designation_id`,`designation`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('10','Clerical Staff','2019-05-02 14:30:04','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA emails
-- -------------------------------------------
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('1','Anas','anasshafqat01@gmail.com','Welcome','This is testing email from yii2...!','attachments/1545482896.png','2018-12-22 17:48:24','0','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('3','Anas Shafqat','anasshafqat01@gmail.com','Wellcome to DEXDEVS','This is testing email from Yii2...!','attachments/1545483278.png','2018-12-22 17:54:44','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('4','Saif ur Rehman','saifarshad.6987@gmail.com','Wellcome To DEXDEVS','This is testing email from Yii2...!','attachments/1545483348.png','2018-12-22 17:55:52','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('5','Nauman Shahid','hwhasmhi1625@gmail.com','Wellcome To DEXDEVS','This is testing email from Yii2...!','attachments/1545483409.png','2018-12-22 17:56:55','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('6','Nauman Shahid','hwhashmi1625@gmail.com','Wellcome To DEXDEVS','This is testing email with file attachment from Yii2...!','attachments/1545483610.png','2018-12-22 18:00:16','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('7','Nadia Gull','nadiagull285@gmail.com','Wellcome To DEXDEVS','This is testing email with file attachment from Yii2...!','attachments/1545483685.png','2018-12-22 18:01:39','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('8','Kinza Fatima','kinza.fatima522@gmail.com','Wellcome To DEXDEVS','This is testing email with file attachment from Yii2...!','attachments/1545483773.png','2018-12-22 18:02:59','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('9','Rana Faraz','ranafarazahmed@gmail.com','Wellcome To DEXDEVS','This is testing email with file attachment from Yii2...!	','attachments/1545484174.png','2018-12-22 18:09:38','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('10','Anas Shafqat','anasshafqat01@gmail.com','Wellcome To DEXDEVS','This is testing email with file attachment from Yii2...!','attachments/1545484846.jpg','2018-12-31 15:46:04','1','2018-12-31 15:46:04','1','0');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('11','anas','anasshafqat01@gmail.com','helli','mlklkk','attachments/1545761723.jpg','2018-12-31 15:44:52','1','2018-12-31 15:44:52','1','0');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('12','Anas','anasshafqat01@gmail.com','Hello','heloo heloo heloo heloo','attachments/1545764108.jpg','2018-12-31 16:11:53','1','2018-12-31 16:11:53','1','0');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('13','Anas','anasshafqat01@gmail.com','Hello','Testing Email....','attachments/1545804180.jpg','2018-12-26 11:03:14','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('14','khh','anasshafqat01@gmail.com','hello','jkhjkh','attachments/1545816221.sql','2018-12-26 14:23:48','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('15','Mehtab','chmehtab4@gmail.com','Hello','This is testing Email with file attachment from Yii2....','attachments/1546064434.png','2018-12-29 11:21:12','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('16','Anas Shafqat','anasshafqat01@gmail.com','Wellcome','Testing Email...','attachments/1546066690.png','2018-12-29 11:58:16','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('17','Anas Shafqat','anasshafqat01@gmail.com','Hello','<h2>Hello Sir,</h2><p><b><i>This is testing email from yii2...</i></b><br></p><p><b><i><br></i></b></p><p><b></b>Regards<b></b></p><p><b><i>Anas Shafqat</i></b></p>','attachments/1546068232.mp4','2018-12-29 12:26:27','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('18','Rana Faraz','ranafarazahmed@gmail.com','Testing Email','<h2><b>Hello Sir,</b></h2><p><b><i></i><i>This is testing Email from Yii2 with text formatting.</i><i></i></b><b></b></p><p><b><i><br></i></b></p><p><b>Note:</b></p><p><ol><li><i>jkhjhj</i></li><li><i>erwrwe</i></li><li><i>werwe</i></li><li><i>were</i></li><li><i>werwerwr</i></li></ol><p>Regards,<br></p><p><b><i>Anas Shafqat</i></b></p></p>','attachments/1546069705.jpg','2018-12-29 12:48:30','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('19','ans','anasshafqat01@gmail.com','hello','<p><b><i>anasshafqat01@gmail.com</i></b><br></p>','attachments/1548138607.jpg','2019-01-22 11:30:23','9','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('20','Kinza Mustafah','kinza@gmail.com','Wellcome','Hello....','','2019-03-04 14:49:21','0','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('21','Kinza Mustafah','kinza@gmail.com','Wellcome','Hello....','','2019-03-04 14:49:40','0','0000-00-00 00:00:00','0','1');;;
INSERT INTO `emails` (`emial_id`,`receiver_name`,`receiver_email`,`email_subject`,`email_content`,`email_attachment`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('22','Rana Faraz','ranafarazahmed@gmail.com','Testing','<p>lkjhgfdsdfghjk</p>','attachments/1551947170.jpg','2019-03-07 13:26:26','3','0000-00-00 00:00:00','0','1');;;
-- -------------------------------------------
-- TABLE DATA emp_attendance
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA emp_departments
-- -------------------------------------------
INSERT INTO `emp_departments` (`emp_department_id`,`emp_id`,`dept_id`) VALUES
('1','4','1');;;
INSERT INTO `emp_departments` (`emp_department_id`,`emp_id`,`dept_id`) VALUES
('2','1','5');;;
INSERT INTO `emp_departments` (`emp_department_id`,`emp_id`,`dept_id`) VALUES
('3','5','1');;;
INSERT INTO `emp_departments` (`emp_department_id`,`emp_id`,`dept_id`) VALUES
('4','3','5');;;
INSERT INTO `emp_departments` (`emp_department_id`,`emp_id`,`dept_id`) VALUES
('5','2','4');;;
-- -------------------------------------------
-- TABLE DATA emp_designation
-- -------------------------------------------
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','1','4','4','Faculty','20000','Registered','Active','2019-05-04 15:21:32','0000-00-00 00:00:00','4','0');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','2','3','5','Faculty','40000','Registered','Active','2019-05-04 15:59:04','2019-05-04 15:59:04','4','1');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','3','9','4','Faculty','30000','Registered','Inactive','2019-05-04 16:04:55','2019-05-04 16:04:55','1','1');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','4','4','5','Faculty','20000','Registered','Inactive','2019-05-04 15:47:30','2019-05-04 15:47:30','1','1');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','3','3','5','Faculty','25000','Demotion','Active','2019-05-04 15:55:38','0000-00-00 00:00:00','1','0');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','3','4','4','Faculty','2000','Demotion','Active','2019-05-04 16:04:55','0000-00-00 00:00:00','1','0');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('8','5','9','4','Faculty','25555','Registered','Inactive','2019-06-15 11:36:10','2019-06-15 11:36:10','1','1');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('9','5','4','4','Faculty','15555','Demotion','Active','2019-06-15 11:36:10','0000-00-00 00:00:00','1','0');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('10','6','3','4','Faculty','30000','Registered','Active','2019-06-25 11:44:31','0000-00-00 00:00:00','1','0');;;
INSERT INTO `emp_designation` (`emp_designation_id`,`emp_id`,`designation_id`,`emp_type_id`,`group_by`,`emp_salary`,`designation_status`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('12','8','4','4','Faculty','30000','Registered','Active','2019-06-25 14:43:41','0000-00-00 00:00:00','1','0');;;
-- -------------------------------------------
-- TABLE DATA emp_documents
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA emp_info
-- -------------------------------------------
INSERT INTO `emp_info` (`emp_id`,`emp_branch_id`,`emp_reg_no`,`emp_name`,`emp_father_name`,`emp_cnic`,`emp_contact_no`,`emp_perm_address`,`emp_temp_address`,`emp_marital_status`,`emp_fb_ID`,`emp_gender`,`emp_date_of_birth`,`emp_religion`,`emp_domicile`,`emp_photo`,`emp_dept_id`,`emp_salary_type`,`emp_email`,`emp_qualification`,`emp_passing_year`,`emp_institute_name`,`degree_scan_copy`,`emp_cv`,`barcode`,`emp_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','6','EMP-Y19-1','Nadia Gull','Iftkhar Ali','31303-1234567-8','+92-315-8410500','RYK','RYK','Single','','','0000-00-00','','','uploads/Nadia Gull_emp_photo.jpg','1','Salaried','nadiagull285@gmail.com','BSCS','2019','Superior College','uploads/Nadia Gull_degree_scan_copy.jpg','uploads/Nadia Gull_emp_cv.jpg','','Active','2019-05-04 10:29:47','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `emp_info` (`emp_id`,`emp_branch_id`,`emp_reg_no`,`emp_name`,`emp_father_name`,`emp_cnic`,`emp_contact_no`,`emp_perm_address`,`emp_temp_address`,`emp_marital_status`,`emp_fb_ID`,`emp_gender`,`emp_date_of_birth`,`emp_religion`,`emp_domicile`,`emp_photo`,`emp_dept_id`,`emp_salary_type`,`emp_email`,`emp_qualification`,`emp_passing_year`,`emp_institute_name`,`degree_scan_copy`,`emp_cv`,`barcode`,`emp_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','6','EMP-Y19-2','Anas Shafqat','M Shafqat','31303-7654345-6','+92-300-7976242','RYK','RYK','Single','','','0000-00-00','','','uploads/Anas Shafqat_emp_photo.jpg','2','Per Lecture','anas@gmail.com','BSCS','2019','SperiorCollege','uploads/Anas Shafqat_degree_scan_copy.jpg','uploads/Anas Shafqat_emp_cv.jpg','','Active','2019-05-04 14:12:09','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `emp_info` (`emp_id`,`emp_branch_id`,`emp_reg_no`,`emp_name`,`emp_father_name`,`emp_cnic`,`emp_contact_no`,`emp_perm_address`,`emp_temp_address`,`emp_marital_status`,`emp_fb_ID`,`emp_gender`,`emp_date_of_birth`,`emp_religion`,`emp_domicile`,`emp_photo`,`emp_dept_id`,`emp_salary_type`,`emp_email`,`emp_qualification`,`emp_passing_year`,`emp_institute_name`,`degree_scan_copy`,`emp_cv`,`barcode`,`emp_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','5','EMP-Y19-3','Kinza Mustafa','Ghulam Mustafa','45102-0511722-2','+92-300-7976242','RYK','RYK','Single','','F','0000-00-00','','','uploads/Kinza Mustafa_emp_photo.jpg','1','Per Lecture','kinza.fatima.522@gmail.com','BSCS','2017','IUB','uploads/Kinza Mustafa_degree_scan_copy.jpg','uploads/Kinza Mustafa_emp_cv.jpg','','Active','2019-06-25 14:36:18','2019-06-25 14:36:18','1','1','1');;;
INSERT INTO `emp_info` (`emp_id`,`emp_branch_id`,`emp_reg_no`,`emp_name`,`emp_father_name`,`emp_cnic`,`emp_contact_no`,`emp_perm_address`,`emp_temp_address`,`emp_marital_status`,`emp_fb_ID`,`emp_gender`,`emp_date_of_birth`,`emp_religion`,`emp_domicile`,`emp_photo`,`emp_dept_id`,`emp_salary_type`,`emp_email`,`emp_qualification`,`emp_passing_year`,`emp_institute_name`,`degree_scan_copy`,`emp_cv`,`barcode`,`emp_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','5','EMP-Y19-4','Numan Hashmi','M.Shahid','31303-0511722-2','+92-315-8410500','RYK','RYK','Married','','M','0000-00-00','','','uploads/Numan Hashmi_emp_photo.jpg','1','Salaried','nauman@gmail.com','BSCS','2018','Superior College','uploads/Numan Hashmi_degree_scan_copy.jpg','uploads/Numan Hashmi_emp_cv.jpg','','Active','2019-06-25 14:36:12','2019-06-25 14:36:12','1','1','1');;;
INSERT INTO `emp_info` (`emp_id`,`emp_branch_id`,`emp_reg_no`,`emp_name`,`emp_father_name`,`emp_cnic`,`emp_contact_no`,`emp_perm_address`,`emp_temp_address`,`emp_marital_status`,`emp_fb_ID`,`emp_gender`,`emp_date_of_birth`,`emp_religion`,`emp_domicile`,`emp_photo`,`emp_dept_id`,`emp_salary_type`,`emp_email`,`emp_qualification`,`emp_passing_year`,`emp_institute_name`,`degree_scan_copy`,`emp_cv`,`barcode`,`emp_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','5','EMP-Y19-5','Aisha','Gull Ahmed','11111-1111111-1','+92-331-7375027','klni','jpooj','Single','','F','0000-00-00','','','uploads/Aisha_emp_photo.jpg','6','Salaried','anas@gmail.com','nbho','2018','nklij','0','0','data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANIAAABaCAYAAADNegj3AAAEW0lEQVR4Xu3dMW7UUBSF4TMlNRtgHyBBxxIooEeiQ6KHBSDRIdHDIqhIAQugpGMD1JRBTmaQY+yMZ3KdOLwvUoQ0sd+zz9x/zr3v3TGbJCfb3/ihAAWOUuDhJsmb7e9RIziJAhTIayCJAgpcXQEgXV1DI1CAI4kBClQowJEqVDRG8woAqfkQIECFAkCqUNEYzSsApOZDgAAVCgCpQkVjNK8AkJoPAQJUKACkChWN0bwCQGo+BAhQoQCQKlQ0RvMKAKn5ECBAhQJAqlDRGM0rAKTmQ4AAFQoAqUJFYzSvAJCaDwECVCgApAoVjdG8AvNBOj09PZ0j12azSXdo92/3sztt93r3Wv+Y3bGXnTN2/NjYazlud4+7a/zf73fqvT72/ajUb18Mzozp82Ce/gHSEgBXBsIS11cd+NXjVeoHpFvsXJWBAKTz7GaYuczVBUhAuhBAa05lOdIBz2xQI03XfcNPTI50vIP0a+qKGpMjcSSOtF2sktpZtZvM7efm+C0eV+noHIkjcSSOZB+pX4BfJTXhSFbtbMgWfKICCUhAAtI/NeKcZXw10qCu2VfoHdtCUr1vUT1eZSBwJI7EkTgSRxr259mQtSF7XYsmlY6+LyvStDqyR7WWVLEyEKR2UjupndROaie1G/8kvO5VJ47EkTgSR+JIHIkjVW8LzB2vssa02KDXTq9dgaMDCUhAApKmVU2r60iNORJH4kgciSNxJI402jWhRUiLkBahyYYiz7VbYsOzcvl2ieubuwx9U8dV6qdGUiOpkdRIaiQ1khpJjXSFJ3tWP5dNaqfXTq9dQWoCJCABCUiaVjWtriPH50gciSNxJI7EkTiSfaRzCjY7IaYf8GBDdonUqXJDcYnruylA5s5bqZ8NWRuyNmQLUmMgAQlIQNLZoLNhHTUmR+JIHIkjcSSOxJH02um1+7v/M+c5fnNX4+YeZ9XO/0ZxFoCVgWD5W2eDzoaCHB9IQAISkLQIaRFaR7HMkTgSR+JIHIkjcaS5q2zVx1Uu1tiQtSFrQ7bA0YEEJCABSWeDzoZ1pMarc6Tp7zT5CwWaV2D+F/ual4oAFKj4hiwVKUCBSQU4kuCgQIECQCoQ0RAUAJIYoECBAkAqENEQFACSGKBAgQJAGhHxfpJ7ST71/nYnyask75P86r3+NMnPJN96r91N8iLJ2yS/t69PnT+cfmzusfG688bmPuTaD5lreJ1jcxfE460dAkgDWN4leZ7kWQ+kLuC+Jvm8Dd4OpC64O9AeJ3nQA6kLsI9JPiR5uQVp7PxhxHSgjc09Nt7Y3FPnj819yFzD65y671tLQNGFA4kjXXDeKffjSJcTByQgAanAlYB0QyDtUq5u+n5qeEjdch010i61/J7kSZIfW73USBcDB0g3BNLUh+DaQJq6TiABaa+RH7LyZdVur5xNHMCRmnib3eTSCgBpaYWN34QCQGribXaTSysApKUVNn4TCpyB9CXJSRO36yYpsIwCj/4AmHnS6GAIM0AAAAAASUVORK5CYII=','Active','2019-06-25 14:35:56','2019-06-25 14:35:56','1','1','1');;;
INSERT INTO `emp_info` (`emp_id`,`emp_branch_id`,`emp_reg_no`,`emp_name`,`emp_father_name`,`emp_cnic`,`emp_contact_no`,`emp_perm_address`,`emp_temp_address`,`emp_marital_status`,`emp_fb_ID`,`emp_gender`,`emp_date_of_birth`,`emp_religion`,`emp_domicile`,`emp_photo`,`emp_dept_id`,`emp_salary_type`,`emp_email`,`emp_qualification`,`emp_passing_year`,`emp_institute_name`,`degree_scan_copy`,`emp_cv`,`barcode`,`emp_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','5','EMP-Y19-6','Anas Shafqat','Shafqat Ali','31303-0437738-3','+92-306-3772105','House # 4/C-1, Scheme # 3, Y-Block, Gulshan Iqbal','','Single','','M','2001-03-01','Islam','Rahim Yar Khan','uploads/Anas Shafqat_emp_photo.jpg','1','Salaried','anasshafqat01@gmail.com','BSCS','2018','Superior College','0','0','data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANIAAABaCAYAAADNegj3AAAGrElEQVR4Xu2dP4gsRRDGvw0FMw0MzTQzMRB9oJgoJoKJgRqKICaCmeh7KmaCiQgiRmpgIpgImvhABQMRnpEmIsaaanhSbtddbV/3TPdsL9w4v4Xl7nZmq7u/qa/rT1f37STdTG/xAgEQWITAwztJN9J7kQS+BAIgoOsQCS0AgeMRgEjHY4gEEMAioQMgMAIBLNIIFJGxeQQg0uZVAABGIACRRqCIjM0jAJE2rwIAMAIBiDQCRWRsHgGItHkVAIARCECkESgiY/MIQKTNqwAAjEAAIo1AERmbRwAibV4FAGAEAhBpBIrI2DwCEGnzKgAAIxCASCNQRMbmEYBIm1cBABiBAEQagSIyNo9AO5HOzs7OWuDa7XayW+2nvfxr/rl9NndPvO6y8p8l2bU2W+TFfrrspfJ8jFFObRy1dnMMR+BXwz7Hp+W+Gv6lcZ4Cj7yPPXoSv9uo03tlrr8gUnwApQfeozC5skOk/aQKkQIDsUiHlnSphemdsXMyHmPRWyxN7kFEq7zUk4BIEKnons65iqdQHFy7ergw9Tzmwgtcu0L8tTSmmXLJcO0uYl0sUpV2xEjESPuZvoRDLeHRO2GdwkKTbCBrV1XcUnKCGOmQ6L0eAq5dSqH3pDV7Z8raTByVt/fBnSpLRYxEjHSe/pzKCLWa6qk1Koh06KItcdnI2l2Og3auWKwjTSsYyQZipKnsHUTKguglaWtcO7J2EAkidWfjcO1w7ar1fXOWCNcO1w7XblA6naLVizRzSylRj8vLOhIlQpQIhSp+KhuobDiIFWquXmnm7Jl5qf4uZ0exSFgkLBIWyWJv9iNNbXegsmG/8XLJwm2PpcYiYZGwSFgkLFJr2pv0N+lv0t+kvy+dizGXTJnaHsGCLAuyLMjOVHK0rA9BJIgEkSDSpeQJ+5HYj3QwMbAfif1I7EdqtBRxQyHn2h1fdV7bnxZd3Kkkg19jHYnqb6q/Zw4phUicItQdE5JsODywsvHwYNaRWEfqXx8ia0fWrnuGpkSIEiFcO1y77okD1w7Xrml9gFOEOEWo5b+WkLWb+ZcxEAkiQaSsZm5u+0OtjL+nvJ8YiRiJGIkYiRipYZ2QEiFKhCgRSpPl0rMiqGxYONMQIxEjESMRI53vxi3NwBStUrRK0SpFq0U3dW4D4lQRb74m1vNfS0h/k/4+mJR6XVkWZFmQZUE2TSI1MrTM0BAJIkEkiNSd7idrR9bufOLI4wQs0n4RucUCQySIBJEGnKcHkSASRIJIF4uCc+UZvVmnlhVuau0uH0E8twbFkcXTFXec2dBg2eL6g/vdMS5ZQsySnKki3Kn7iZEOJ4be5zE3mVO0StFqdxaL9Dfpb9LfpL+7Jw6SDQ0uGfuR+mvPsEhYJCwSFun/YZFagjLuAYGNInDdzoW9kd4bxYBhg8DRCECkoyFEAAhIEAktAIEBCECkASAiAgQgEjoAAgMQgEgDQEQECEAkdAAEBiAAkQKI90j6TNJ9kj6Q9LKkf9L12yS9Iul9SX9JekjSd+na65LeSr/Hz5+V9Kmk1yS9ma5fk/R95cH5fbckPS3p13CfXfstySu1/YykT8L9X0l6SdJ7kh4Ln1uffqyMM8qt9bM27gG6uGoREKny+Ewxf09K78pjymmfG5Hiywj3paQ/Atns+tuSXg333yHpRUnvBIK6HCPxE5LeTSR9NJDTrlkb3yYildqOpLP+3p3dm08ELsPH+dNM30sw+bhj26tmwxGdh0gV8HIlqSli/PzOQAYTG8lof0ey5M3Ge6PMv5OC/yzp9gZy2Hefk/RxRlYjl71ya1ibBGqE937X8DhCF1f9VYiUPT53r3LXJlcc+9usxwPBDcuJ4uT4M7lSP2TuYmy6RqTHk2W0e93KlNp2Wa3WqDROs5jmit5VcC0jgfJxr5oBgzoPkSpAxpjEbpmySKZYZgGMMO6e1SySlWNZ7HJviLGMtEYSdyW9ra8lPRjcvZK75m27pXle0ueZ+2kEt/a+KIzVx2lxk/fNrOAbkj6SdH+KvfK4zcls467FfIN0dBViIFLlMeUz+5Qr49bklxAXuUvmyYkpMto1a8/jIrds5sp5ksK76QmMPMYxZTaL8pSkD7MxPSnJ+laKZXycRqQ4CbTEP7nrugqNP1EnIVIANmak5rJ2MUtWy9qZpbEg3qzGC6mdlqxdKakRiT3VdkuSoTbOmtzcBfXsYBz3ifRzNWIh0moeFR29yghApKv8dOjbahCASKt5VHT0KiMAka7y06Fvq0HgPyJ9I+nmarpMR0Hg6iHwyL9Jguzo/lzK8wAAAABJRU5ErkJggg==','Active','2019-06-25 14:35:44','2019-06-25 14:35:44','1','1','1');;;
INSERT INTO `emp_info` (`emp_id`,`emp_branch_id`,`emp_reg_no`,`emp_name`,`emp_father_name`,`emp_cnic`,`emp_contact_no`,`emp_perm_address`,`emp_temp_address`,`emp_marital_status`,`emp_fb_ID`,`emp_gender`,`emp_date_of_birth`,`emp_religion`,`emp_domicile`,`emp_photo`,`emp_dept_id`,`emp_salary_type`,`emp_email`,`emp_qualification`,`emp_passing_year`,`emp_institute_name`,`degree_scan_copy`,`emp_cv`,`barcode`,`emp_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','5','EMP-Y19-7','Nadia Gull','Iftikhar Ahmed','12345-6789000-0','+92-331-7375027','Foji Chock','','Single','','F','2000-02-01','Islam','Rahim Yar Khan','uploads/Nadia Gull_emp_photo.jpg','1','Salaried','nadia@gmail.com','BSCS','2018','Superior College','0','0','data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANIAAABaCAYAAADNegj3AAAHBUlEQVR4Xu2dPaxsUxTH/1NKdNQiGqVEJUiIRqJRKtAQkegkOuE9RCfRSRQUPgqNUtB4CTqRUNGIqGkpr6x398pds2d/nTPbeJnzO8nNnTmzzt77/Gf99/rY+6zZSbqR/sQBAiCwCoFHdpKup79VLXARCICArkEktAAEjkcAIh2PIS2AABYJHQCBGQhgkWagSBubRwAibV4FAGAGAhBpBoq0sXkEINLmVQAAZiAAkWagSBubRwAibV4FAGAGAhBpBoq0sXkEINLmVQAAZiAAkWagSBubRwAibV4FAGAGAhBpBoq0sXkEINLmVQAAZiAAkWagSBubRwAibV4FAGAGAhBpBoq0sXkExol0cXFxMQLXbreTidp/O/wyP2/noozLtq7J5fM2vJ9anyP91cYX245jbd2Hf7b02ly+dZ+lsdT6i7iMfg9L24/fc2scI3I9/Gr6UOq3p4ODOn2pzPUDIh2rvPlEsERRapPIWlJDpMuJe8lkDpEKlg+LdKhIuaXHIl06VhGHHpl2rlhYpCt3c7YVwCJdWYBRl6wn1/sc1y6FWSMxy0gMUpptSz7xSH9r3SmIBJGkBcVPSDbsW7URopNsKHsCPYvT+xyLhEU6yGKWAuO11pFkA8mGZsqc9Pf+csKSGZlkQ3sJppdoSNaR9HcphplpBYiRiJGIkcKi8Vp3CiJBJIgEkQ4WMNdMDPkkxM6GhsNI1o6s3bEEGSUcWbtsH11vn1NpfWdkHShPPccveOR6YqT91f3WOtvIlqdRgozKQSSItJfeZh2JdaQDJw/XDtcO164a+7D7O1eOltvIYxT1TbEzXUBcO1w7XLtCJnTpAjJEgkgQCSK1N0sQIxEjESMRI1UXHomR9p8oZUH2kCw82Beeoq3tuYNIEKm3cRUiQaSDXfU8as6j5nvP2dd2J7CzoWxhepa3tUt+NIs2S260nZGdEr3dNT1rlMbCYxQ8RlF+lilfL4NIdUrh2uHa4dp1aitikSjHdeDqttLTuHb7Jbgox1Wo+8Du70slgUjUbKBmw4SHDCESRIJIEGmRqzpam5ysXaPYfmuHNulv0t/U/q78ggXluCjHtTY9j0XCIt1MHrQeix9ZkKSuHXXtqr+jhGtX3olOsoFkA8kGkg0kG+Lq8JJAjypC5R/FWlusEouERcIiYZGwSFikZTFLbcNobxtPzeKM7Jbutb02Kza6nrNEbuR+Rtsja0fWjqxd2nB6TAFLiASRIBJE2l9AjK5M7zmYkZ0JpL+XuZKlDa2972HUdfov5HDtKMdFOS7KccWUweFrynFRjquVXqfSqnRdl3/NAyJBJIhUpQi1v3tp4V7KeU0dONLf7QcRiZGIkYiRiJFw7aKfX9s1PVIXrjejYpGwSL1Qqrjtn/T3WHx1rJvZimF6bbOzoa7alOOiHBfluCjHtf9QW+tHvuJsO7Kgy2/I8huylOOiHNfBA4+9mIydDYf1vv83InWDIwRAYLsIjK8jbRcj7hwEughApC5ECIBAHwGI1McICRDoIgCRuhAhAAJ9BCBSHyMkQKCLAETqQoQACPQRgEh9jJAAgS4CEKkA0UOS7pb0afrM3n+XXj+Tzsdzr0t6K2vnNUm/FWS/kvS0pL8K/d4r6TNJ90myfn4I7138YUk/SnpX0ouS3pf0sqR/JFmfb0qKfcQ24zhd9idJT0n6VVLpPvNh3hb6bt1LV/POTAAihS80KokTxj5+UtLXSe4VSe9lRDBF/iIpo4mZ8tq5bwOR7Pz3DeW5Q9Lbkl6tkMw+f0nSO5LuD0Q3UtrxezhnhHgskdvH9oekNyR9kOSfSIRwWWvX781EamOJk4z37RPOmXFj0e1ApAGL5CJGtJxI+Tl//7Ok2xORTOFM0VtEcoU2i2KHWZ4ob2T+JVgOt5jetr33Ppx0H0p6LpHPLJaTwIln7ft4baJ4MJHLPq+NOU4akdzW/pYPiLSASFG53Ho9EFyjqID2Oir7J6mfkhvo192TrIhZtOclXUsuW0lhbSzWprcXrYMR5tnUFkQ6Db0h0gCRnDTuqsVL/LOPJf0pKbpMMc7ya3xGvzPEXWZ9IvFyK2fEsMMtVB5/mRtnrpnHTWZdvpT0UXAH11okuwcjrMdSdn/uxmKRrjQBIg0QKY+B8kvcUplCu2vmMjHWMoJ4nGLBfTyiFbors0gvSPo8xE5xPHadk9fb8/FYUiL2F0nsMZRfb6TzuOjvggsb27bXFhflSZnTzP23Zi8QqUMkm3VNaR4PcmZBfKa20yV3LSqZZ8hMNhKrRMg4+xvZSrN+HJNbCmvLM35xPHkm0BMDpQxfzNrlMZqPNSZkYsbw1lTv040KIp0Oa3o6YwQg0hl/udza6RCASKfDmp7OGAGIdMZfLrd2OgRuEukbSTdO1yc9gcDZIfDovxVt9ei6QwpmAAAAAElFTkSuQmCC','Active','2019-06-25 14:43:41','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA emp_leave
-- -------------------------------------------
INSERT INTO `emp_leave` (`app_id`,`branch_id`,`emp_id`,`leave_type`,`starting_date`,`ending_date`,`applying_date`,`no_of_days`,`leave_purpose`,`status`,`remarks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','5','3','Casual Leave','2019-05-07','2019-05-10','2019-05-04','4','Some reason','Pending','','2019-05-04 13:05:15','0000-00-00 00:00:00','94','0');;;
-- -------------------------------------------
-- TABLE DATA emp_reference
-- -------------------------------------------
INSERT INTO `emp_reference` (`emp_ref_id`,`emp_id`,`ref_name`,`ref_contact_no`,`ref_cnic`,`ref_designation`) VALUES
('1','3','Nadia','+92-315-8410500','31303-4567898-7','Developer');;;
INSERT INTO `emp_reference` (`emp_ref_id`,`emp_id`,`ref_name`,`ref_contact_no`,`ref_cnic`,`ref_designation`) VALUES
('3','','','','','');;;
INSERT INTO `emp_reference` (`emp_ref_id`,`emp_id`,`ref_name`,`ref_contact_no`,`ref_cnic`,`ref_designation`) VALUES
('4','','Anas Shafqat','+92-222-2222222','33333-3333333-3','Teacher');;;
INSERT INTO `emp_reference` (`emp_ref_id`,`emp_id`,`ref_name`,`ref_contact_no`,`ref_cnic`,`ref_designation`) VALUES
('5','','Anas Shafqat','+92-333-3333333','33333-3333333-3','Teacher');;;
INSERT INTO `emp_reference` (`emp_ref_id`,`emp_id`,`ref_name`,`ref_contact_no`,`ref_cnic`,`ref_designation`) VALUES
('6','','','','','');;;
INSERT INTO `emp_reference` (`emp_ref_id`,`emp_id`,`ref_name`,`ref_contact_no`,`ref_cnic`,`ref_designation`) VALUES
('7','5','','','','');;;
INSERT INTO `emp_reference` (`emp_ref_id`,`emp_id`,`ref_name`,`ref_contact_no`,`ref_cnic`,`ref_designation`) VALUES
('8','6','','','','');;;
INSERT INTO `emp_reference` (`emp_ref_id`,`emp_id`,`ref_name`,`ref_contact_no`,`ref_cnic`,`ref_designation`) VALUES
('10','8','','','','');;;
-- -------------------------------------------
-- TABLE DATA emp_type
-- -------------------------------------------
INSERT INTO `emp_type` (`emp_type_id`,`emp_type`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','Daily Wages','2019-03-16 11:47:32','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `emp_type` (`emp_type_id`,`emp_type`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','Weekly Wages','2019-03-16 11:47:44','2019-03-16 11:47:44','1','1','1');;;
INSERT INTO `emp_type` (`emp_type_id`,`emp_type`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','Contract Basis','2019-01-14 23:24:23','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `emp_type` (`emp_type_id`,`emp_type`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','Permanent ','2018-12-14 12:52:24','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `emp_type` (`emp_type_id`,`emp_type`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','Visiting','2019-02-26 10:02:48','2019-02-26 10:02:48','0','3','1');;;
-- -------------------------------------------
-- TABLE DATA event
-- -------------------------------------------
INSERT INTO `event` (`id`,`title`,`description`,`created_at`) VALUES
('1','Hello','Something in the description','2019-01-27 22:14:06');;;
INSERT INTO `event` (`id`,`title`,`description`,`created_at`) VALUES
('2','Another Event','Another Event Description','2019-01-28 00:10:28');;;
INSERT INTO `event` (`id`,`title`,`description`,`created_at`) VALUES
('3','Another Event 2','Another Event 2 Description','2019-01-28 00:12:23');;;
-- -------------------------------------------
-- TABLE DATA events
-- -------------------------------------------
INSERT INTO `events` (`event_id`,`event_title`,`event_detail`,`event_venue`,`event_start_datetime`,`event_end_datetime`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('1','Last Day','Last Day of Janvi','','2015-05-30 00:00:00','2015-05-30 00:00:00','2015-05-27 15:34:53','1','2015-05-27 15:40:30','1','Inactive');;;
INSERT INTO `events` (`event_id`,`event_title`,`event_detail`,`event_venue`,`event_start_datetime`,`event_end_datetime`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('2','Janvi BDay','Happy Birthday Janvi ','','2015-07-05 00:00:00','2015-07-05 00:00:00','2015-05-27 15:35:38','1','2015-05-27 15:40:48','1','Inactive');;;
INSERT INTO `events` (`event_id`,`event_title`,`event_detail`,`event_venue`,`event_start_datetime`,`event_end_datetime`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('3','Happy Bday','Happy Birthday KarmrajSir','','2015-07-25 00:00:00','2015-07-25 00:00:00','2019-04-20 13:14:50','3','0000-00-00 00:00:00','0','Inactive');;;
INSERT INTO `events` (`event_id`,`event_title`,`event_detail`,`event_venue`,`event_start_datetime`,`event_end_datetime`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('4','Launching New Application','Launch of Edusec Yii2','','2015-06-02 09:30:00','2015-06-02 10:00:00','2015-05-27 15:37:00','1','2015-05-27 15:39:37','1','');;;
INSERT INTO `events` (`event_id`,`event_title`,`event_detail`,`event_venue`,`event_start_datetime`,`event_end_datetime`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('5','Meeting for staff ','All Staff Members-Meeting','','2015-06-09 00:00:00','2015-06-09 00:00:00','2015-05-27 15:37:42','1','','','');;;
INSERT INTO `events` (`event_id`,`event_title`,`event_detail`,`event_venue`,`event_start_datetime`,`event_end_datetime`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('7','Celebration Time','Celebration Time','','2015-06-25 00:00:00','2015-06-25 00:00:00','2015-05-27 15:39:12','1','','','');;;
INSERT INTO `events` (`event_id`,`event_title`,`event_detail`,`event_venue`,`event_start_datetime`,`event_end_datetime`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('8','Sports Week','Annual sports week of Brookfield Group of Colleges.','Shiekh Zaid Sports Complex','2019-01-31 08:00:05','2019-02-04 05:00:05','2019-01-30 16:57:53','9','2019-01-30 17:00:43','9','Active');;;
-- -------------------------------------------
-- TABLE DATA exams_category
-- -------------------------------------------
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','Daily Test','Daily Class Tests','2019-03-11 14:34:22','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','Weekly Tests','Weekly Class Tests','2019-03-11 14:34:40','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','First Term','First Term Exams','2019-03-11 14:35:27','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','Mid Term','Mid Term Exams','2019-03-11 14:35:49','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','Final Term','Final Term Exams','2019-03-11 14:36:04','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','December Test','December Test / Exams','2019-03-11 14:36:44','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','Quiz','Subject Quiz','2019-03-11 14:37:15','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('8','Assignment','Class Assignment','2019-03-11 14:37:35','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('9','Presentation','Class Presentation','2019-03-11 14:37:56','0000-00-00 00:00:00','0','0');;;
INSERT INTO `exams_category` (`exam_category_id`,`category_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('10','Sendups','Class Sendups','2019-03-11 14:38:11','0000-00-00 00:00:00','0','0');;;
-- -------------------------------------------
-- TABLE DATA exams_criteria
-- -------------------------------------------
INSERT INTO `exams_criteria` (`exam_criteria_id`,`exam_category_id`,`class_id`,`exam_start_date`,`exam_end_date`,`exam_status`,`exam_type`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','5','1','2019-05-30','2019-06-08','Conducted','Regular','2019-06-13 11:15:46','2019-06-10 12:57:48','1','1');;;
-- -------------------------------------------
-- TABLE DATA exams_room
-- -------------------------------------------
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('1','1','2','1','1','no','1','0','2019-06-03 10:36:08','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('2','1','3','21','3','no','1','1','2019-06-03 10:36:00','2019-06-01 06:59:05');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('3','1','4','7','1','no','1','0','2019-06-03 10:36:18','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('4','2','2','4','3','','1','0','2019-06-13 16:17:41','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('5','2','3','7','4','','1','1','2019-06-01 06:59:05','2019-06-01 06:59:05');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('6','2','4','4','2','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('7','3','2','4','3','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('8','3','3','4','4','','1','1','2019-06-01 06:59:05','2019-06-01 06:59:05');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('9','3','4','6','1','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('10','4','2','5','4','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('11','4','3','11','1','','1','1','2019-06-01 06:59:05','2019-06-01 06:59:05');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('12','4','4','6','1','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('13','5','2','3','3','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('14','5','3','11','1','','1','1','2019-06-01 06:59:05','2019-06-01 06:59:05');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('15','5','4','2','3','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('16','6','2','4','1','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('17','6','3','22','3','','1','1','2019-06-01 06:59:05','2019-06-01 06:59:05');;;
INSERT INTO `exams_room` (`exam_room_id`,`exam_schedule_id`,`class_head_id`,`exam_room`,`emp_id`,`invigilator_attend`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('18','6','4','4','3','','1','0','2019-05-30 07:45:31','0000-00-00 00:00:00');;;
-- -------------------------------------------
-- TABLE DATA exams_schedule
-- -------------------------------------------
INSERT INTO `exams_schedule` (`exam_schedule_id`,`exam_criteria_id`,`subject_id`,`date`,`exam_start_time`,`exam_end_time`,`full_marks`,`passing_marks`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','1','1','2019-05-30','08:00:00','11:00:00','100','33','not','2019-06-13 21:09:57','2019-06-10 12:57:48','1','1');;;
INSERT INTO `exams_schedule` (`exam_schedule_id`,`exam_criteria_id`,`subject_id`,`date`,`exam_start_time`,`exam_end_time`,`full_marks`,`passing_marks`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','1','2','2019-05-31','08:00:00','11:00:00','100','33','not','2019-06-10 12:57:48','2019-06-10 12:57:48','1','1');;;
INSERT INTO `exams_schedule` (`exam_schedule_id`,`exam_criteria_id`,`subject_id`,`date`,`exam_start_time`,`exam_end_time`,`full_marks`,`passing_marks`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','1','4','2019-06-01','08:00:00','11:00:00','100','33','not','2019-06-10 12:57:48','2019-06-10 12:57:48','1','1');;;
INSERT INTO `exams_schedule` (`exam_schedule_id`,`exam_criteria_id`,`subject_id`,`date`,`exam_start_time`,`exam_end_time`,`full_marks`,`passing_marks`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','1','8','2019-06-03','08:00:00','11:00:00','100','33','not','2019-06-14 09:24:36','2019-06-10 12:57:48','1','1');;;
INSERT INTO `exams_schedule` (`exam_schedule_id`,`exam_criteria_id`,`subject_id`,`date`,`exam_start_time`,`exam_end_time`,`full_marks`,`passing_marks`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','1','7','2019-06-04','08:00:00','11:00:00','50','18','not','2019-06-14 09:25:05','2019-06-10 12:57:48','1','1');;;
INSERT INTO `exams_schedule` (`exam_schedule_id`,`exam_criteria_id`,`subject_id`,`date`,`exam_start_time`,`exam_end_time`,`full_marks`,`passing_marks`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','1','10','2019-06-08','08:00:00','11:00:00','50','18','result prepared','2019-06-14 09:33:50','2019-06-10 12:57:48','1','1');;;
-- -------------------------------------------
-- TABLE DATA fee_month_detail
-- -------------------------------------------
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('1','1001','2019-03','5000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('2','1002','2019-03','5000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('3','1003','2019-03','5000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('4','1004','2019-03','5000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('5','1005','2019-04','7000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('6','1006','2019-04','7000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('7','1007','2019-04','7000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('8','1008','2019-04','7000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('9','1009','2019-05','9000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('10','1010','2019-05','6000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('11','1011','2019-05','5000');;;
INSERT INTO `fee_month_detail` (`month_detail_id`,`voucher_no`,`month`,`monthly_amount`) VALUES
('12','1012','2019-05','2000');;;
-- -------------------------------------------
-- TABLE DATA fee_transaction_detail
-- -------------------------------------------
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','1','1','3000','0','2019-05-04 10:55:22','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','1','2','2000','0','2019-05-04 10:55:22','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','2','1','3000','0','2019-05-04 10:55:22','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','2','2','2000','0','2019-05-04 10:55:22','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','3','1','3000','0','2019-05-04 10:55:22','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','3','2','2000','0','2019-05-04 10:55:22','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','4','1','3000','0','2019-05-04 10:55:22','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','4','2','2000','0','2019-05-04 10:55:22','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','5','2','2000','0','2019-05-04 10:56:34','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('10','5','8','5000','0','2019-05-04 10:56:34','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('11','6','2','2000','0','2019-05-04 10:56:34','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('12','6','8','5000','0','2019-05-04 10:56:35','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('13','7','2','2000','0','2019-05-04 10:56:35','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('14','7','8','5000','0','2019-05-04 10:56:35','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('15','8','2','2000','0','2019-05-04 10:56:35','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('16','8','8','5000','0','2019-05-04 10:56:35','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('17','9','2','2000','0','2019-05-04 10:59:17','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('18','9','8','7000','0','2019-05-04 10:59:17','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('19','10','2','2000','0','2019-05-04 10:59:17','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('20','10','8','4000','0','2019-05-04 10:59:17','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('21','11','2','2000','0','2019-05-04 10:59:17','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('22','11','8','3000','0','2019-05-04 10:59:17','0000-00-00 00:00:00','0','0','1');;;
INSERT INTO `fee_transaction_detail` (`fee_trans_detail_id`,`fee_trans_detail_head_id`,`fee_type_id`,`fee_amount`,`collected_fee_amount`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('23','12','2','2000','0','2019-05-04 10:59:17','0000-00-00 00:00:00','0','0','1');;;
-- -------------------------------------------
-- TABLE DATA fee_transaction_head
-- -------------------------------------------
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','1001','5','1','4','3','1','Anas','','2019-05-04 10:55:22','5000','0','0','0000-00-00 00:00:00','Added to next month','2019-05-04 10:56:34','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','1002','5','1','4','3','2','Noman Shahid','','2019-05-04 10:55:22','5000','0','0','0000-00-00 00:00:00','Added to next month','2019-05-04 10:56:34','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','1003','5','1','4','3','3','Nadia Gull','','2019-05-04 10:55:22','5000','0','0','0000-00-00 00:00:00','Added to next month','2019-05-04 10:56:35','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','1004','5','1','4','3','4','Saif-ur-Rehman','','2019-05-04 10:55:22','5000','0','0','0000-00-00 00:00:00','Added to next month','2019-05-04 10:56:35','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','1005','5','1','4','3','1','Anas','','2019-05-04 10:56:34','7000','0','0','0000-00-00 00:00:00','Added to next month','2019-05-04 10:59:16','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','1006','5','1','4','3','2','Noman Shahid','','2019-05-04 10:56:34','7000','3000','4000','2019-05-04 10:59:01','Added to next month','2019-05-04 10:59:16','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','1007','5','1','4','3','3','Nadia Gull','','2019-05-04 10:56:35','7000','4000','3000','2019-05-04 10:57:36','Added to next month','2019-05-04 10:59:16','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','1008','5','1','4','3','4','Saif-ur-Rehman','','2019-05-04 10:56:35','7000','7000','0','2019-05-04 10:58:24','Paid','2019-05-04 10:58:24','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','1009','5','1','4','3','1','Anas','','2019-05-04 10:59:16','9000','0','0','0000-00-00 00:00:00','Unpaid','2019-05-04 10:59:16','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('10','1010','5','1','4','3','2','Noman Shahid','','2019-05-04 10:59:17','6000','0','0','0000-00-00 00:00:00','Unpaid','2019-05-04 10:59:17','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('11','1011','5','1','4','3','3','Nadia Gull','','2019-05-04 10:59:17','5000','0','0','0000-00-00 00:00:00','Unpaid','2019-05-04 10:59:17','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_transaction_head` (`fee_trans_id`,`voucher_no`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_id`,`std_name`,`month`,`transaction_date`,`total_amount`,`paid_amount`,`remaining`,`collection_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('12','1012','5','1','4','3','4','Saif-ur-Rehman','','2019-05-04 10:59:17','2000','0','0','0000-00-00 00:00:00','Unpaid','2019-05-04 10:59:17','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA fee_type
-- -------------------------------------------
INSERT INTO `fee_type` (`fee_type_id`,`fee_type_name`,`fee_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','Admission Fee','Student have to pay admission fee only one time','2018-11-03 11:36:22','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_type` (`fee_type_id`,`fee_type_name`,`fee_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','Tuition Fee','Paid on monthly bases','2018-11-03 11:48:34','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `fee_type` (`fee_type_id`,`fee_type_name`,`fee_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','Absent Fine','Absent Fine','2019-04-09 12:33:52','2019-04-09 12:33:52','1','1','1');;;
INSERT INTO `fee_type` (`fee_type_id`,`fee_type_name`,`fee_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','Activity Dues','Activity Dues','2019-04-09 12:33:09','2019-04-09 12:33:09','1','1','1');;;
INSERT INTO `fee_type` (`fee_type_id`,`fee_type_name`,`fee_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','Stationary Dues','Stationary Dues','2019-04-09 12:32:21','2019-04-09 12:32:21','1','1','1');;;
INSERT INTO `fee_type` (`fee_type_id`,`fee_type_name`,`fee_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','Board/University Fee','Board/University Fee','2019-04-09 12:31:49','2019-04-09 12:31:49','1','1','1');;;
INSERT INTO `fee_type` (`fee_type_id`,`fee_type_name`,`fee_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','Exams Fee','Examination Fee','2019-02-28 10:03:40','0000-00-00 00:00:00','3','0','1');;;
INSERT INTO `fee_type` (`fee_type_id`,`fee_type_name`,`fee_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','Arrears','Previous Pending Dues','2019-04-09 12:29:28','2019-04-09 12:29:28','1','1','1');;;
-- -------------------------------------------
-- TABLE DATA grades
-- -------------------------------------------
INSERT INTO `grades` (`grade_id`,`grade_name`,`grade_from`,`grade_to`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','A+','80','100','2019-04-20 12:28:36','0000-00-00 00:00:00','1','3');;;
INSERT INTO `grades` (`grade_id`,`grade_name`,`grade_from`,`grade_to`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','A','70','79','2019-04-20 12:28:36','2019-04-20 12:20:57','1','3');;;
INSERT INTO `grades` (`grade_id`,`grade_name`,`grade_from`,`grade_to`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','B','60','69','2019-04-20 12:28:36','0000-00-00 00:00:00','1','3');;;
INSERT INTO `grades` (`grade_id`,`grade_name`,`grade_from`,`grade_to`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','C','50','59','2019-04-20 12:28:36','0000-00-00 00:00:00','1','3');;;
INSERT INTO `grades` (`grade_id`,`grade_name`,`grade_from`,`grade_to`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','D','40','49','2019-04-20 12:28:36','0000-00-00 00:00:00','1','3');;;
INSERT INTO `grades` (`grade_id`,`grade_name`,`grade_from`,`grade_to`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','F','33','39','2019-04-20 12:28:36','0000-00-00 00:00:00','1','3');;;
INSERT INTO `grades` (`grade_id`,`grade_name`,`grade_from`,`grade_to`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','Fail','1','32','2019-04-20 12:28:37','2019-04-20 12:20:34','1','3');;;
-- -------------------------------------------
-- TABLE DATA installment
-- -------------------------------------------
INSERT INTO `installment` (`installment_id`,`installment_name`) VALUES
('1','1st Installment');;;
INSERT INTO `installment` (`installment_id`,`installment_name`) VALUES
('2','2nd Installment');;;
INSERT INTO `installment` (`installment_id`,`installment_name`) VALUES
('3','3rd Installment');;;
INSERT INTO `installment` (`installment_id`,`installment_name`) VALUES
('4','4th Installment');;;
INSERT INTO `installment` (`installment_id`,`installment_name`) VALUES
('5','5th Installment');;;
INSERT INTO `installment` (`installment_id`,`installment_name`) VALUES
('6','6th Installment');;;
-- -------------------------------------------
-- TABLE DATA institute
-- -------------------------------------------
INSERT INTO `institute` (`institute_id`,`institute_name`,`institute_logo`,`institute_account_no`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','ABC Learning School','uploads/ABC Learning School_photo.jpg','xyz, RYK','2019-05-02 23:09:01','2019-05-02 23:09:01','1','1','1');;;
-- -------------------------------------------
-- TABLE DATA institute_name
-- -------------------------------------------
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('1','NIMS School System','RYK','923345678988','Sir Nadeem','0','0','2019-03-12 11:07:06','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('2','National Garission School System','RYK','923456789023','fghjklkj','0','0','2019-03-12 11:10:12','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('3','Lahore School System','RYK','923456348256','fghjklghj','0','0','2019-03-12 11:11:07','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('4','The New Horizons School','RYK','923569872345','fghjhgfghj','0','0','2019-03-12 11:11:59','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('5','Rehnuma Public School','RYK','923564337866','fghjkjnhgfvg','0','0','2019-03-12 11:12:30','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('6','ABC Learning School','RYK','923786547856','dfghjkhg','0','0','2019-03-12 11:13:19','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('7','ESNA Public School','RYK','923456789876','dfghjkljmhn','0','0','2019-03-12 11:13:57','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('8','Govt. Girls Model Girls High School','RYK','923456789765','fdghjgfghj','0','0','2019-03-12 11:15:20','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('9','Allied School','RYK','923345678987','fghjkgbhj','0','0','2019-03-12 11:15:48','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('10','The Spirit School','RYK','923456789876','ghjkfghjk','0','0','2019-03-12 11:16:12','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('11','TCI School System','RYK','923567898765','fghjkljhg','0','0','2019-03-12 11:16:35','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('12','Colony High School','RYK','923456789098','fghjkj','0','0','2019-03-12 11:17:11','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('13','Pilot High School','RYK','923456789098','frghjkjnhb','0','0','2019-03-12 11:17:29','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('14','Comprehensive School','RYK','923678998765','dcfghjklkjh','0','0','2019-03-12 11:18:02','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('15','Govt Girls High School','RYK','234567887656','abc','0','0','2019-03-12 23:21:40','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('16','National Garrison School','Satelite Town','922345676767','Sir Zahid','0','0','2019-03-12 23:37:52','0000-00-00 00:00:00');;;
INSERT INTO `institute_name` (`Institute_name_id`,`Institute_name`,`Institutte_address`,`Institute_contact_no`,`head_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('17','Docters Public School','Ryk','123456789098','Sir','0','0','2019-03-13 00:38:43','0000-00-00 00:00:00');;;
-- -------------------------------------------
-- TABLE DATA marks_details
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA marks_details_weightage
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA marks_head
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA marks_weightage_details
-- -------------------------------------------
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','1','1','5','2019-04-23 14:11:35','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','1','2','5','2019-04-23 14:11:35','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','1','3','5','2019-04-23 14:11:35','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','1','4','5','2019-04-23 14:11:35','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','1','6','80','2019-04-23 14:11:35','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','2','1','5','2019-04-23 17:26:23','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','2','2','5','2019-04-23 17:26:23','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('8','2','3','5','2019-04-23 17:26:23','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('9','2','4','5','2019-04-23 17:26:23','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_details` (`weightage_detail_id`,`weightage_head_id`,`weightage_type_id`,`marks`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('10','2','6','80','2019-04-23 17:26:23','0000-00-00 00:00:00','1','0');;;
-- -------------------------------------------
-- TABLE DATA marks_weightage_head
-- -------------------------------------------
INSERT INTO `marks_weightage_head` (`marks_weightage_id`,`exam_category_id`,`class_id`,`subjects_id`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','5','4','1','2019-04-23 16:30:11','0000-00-00 00:00:00','1','0');;;
INSERT INTO `marks_weightage_head` (`marks_weightage_id`,`exam_category_id`,`class_id`,`subjects_id`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','5','4','2','2019-04-23 17:26:23','0000-00-00 00:00:00','1','0');;;
-- -------------------------------------------
-- TABLE DATA marks_weightage_type
-- -------------------------------------------
INSERT INTO `marks_weightage_type` (`weightage_type_id`,`weightage_type_name`,`weightage_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','Attendance','','2019-04-22 11:55:40','0000-00-00 00:00:00','3','0');;;
INSERT INTO `marks_weightage_type` (`weightage_type_id`,`weightage_type_name`,`weightage_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','Assignment','','2019-04-22 11:55:55','0000-00-00 00:00:00','3','0');;;
INSERT INTO `marks_weightage_type` (`weightage_type_id`,`weightage_type_name`,`weightage_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','Presentation','','2019-04-22 11:56:08','0000-00-00 00:00:00','3','0');;;
INSERT INTO `marks_weightage_type` (`weightage_type_id`,`weightage_type_name`,`weightage_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','Dressing','','2019-04-22 11:56:16','0000-00-00 00:00:00','3','0');;;
INSERT INTO `marks_weightage_type` (`weightage_type_id`,`weightage_type_name`,`weightage_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','Behaviour','','2019-04-22 11:56:27','0000-00-00 00:00:00','3','0');;;
INSERT INTO `marks_weightage_type` (`weightage_type_id`,`weightage_type_name`,`weightage_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','Theory','','2019-04-22 11:56:37','0000-00-00 00:00:00','3','0');;;
INSERT INTO `marks_weightage_type` (`weightage_type_id`,`weightage_type_name`,`weightage_type_description`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','Practical','','2019-04-22 11:57:06','0000-00-00 00:00:00','3','0');;;
-- -------------------------------------------
-- TABLE DATA migration
-- -------------------------------------------
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m000000_000000_base','1538846625');;;
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m130524_201442_init','1538846629');;;
-- -------------------------------------------
-- TABLE DATA msg_of_day
-- -------------------------------------------
INSERT INTO `msg_of_day` (`msg_of_day_id`,`msg_details`,`msg_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`,`delete_status`) VALUES
('1','Each Day is a GIFT don\'t send it BACK unopened.  Have a nice Day !','Students','2015-05-27 15:21:01','1','','','Active','1');;;
INSERT INTO `msg_of_day` (`msg_of_day_id`,`msg_details`,`msg_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`,`delete_status`) VALUES
('2','Every day may not be GOOD but there is something GOOD in every day.','Parents','2015-05-27 15:21:22','1','','','Active','1');;;
INSERT INTO `msg_of_day` (`msg_of_day_id`,`msg_details`,`msg_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`,`delete_status`) VALUES
('3','Every ONE wants happiness, No ONE needs pain, But its not possible to get a rainbow.','Employees','2015-05-27 15:21:41','1','','','Active','1');;;
INSERT INTO `msg_of_day` (`msg_of_day_id`,`msg_details`,`msg_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`,`delete_status`) VALUES
('4','Smile is the Electricity and Life is a Battery whenever you Smile the Battery gets Charges.','Students','2015-05-27 15:21:59','1','2018-12-26 18:11:26','1','Active','1');;;
INSERT INTO `msg_of_day` (`msg_of_day_id`,`msg_details`,`msg_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`,`delete_status`) VALUES
('5','The Best for the Group comes when everyone in the group does what’s best for himself AND the group.','Students','2015-05-27 15:22:20','1','','','Active','1');;;
INSERT INTO `msg_of_day` (`msg_of_day_id`,`msg_details`,`msg_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`,`delete_status`) VALUES
('6','In life, as in football, you won\'t go far unless you know where the goalposts are.-- Arnold Glasow','Students','2015-05-27 15:24:54','1','2018-12-26 18:11:18','1','Active','1');;;
-- -------------------------------------------
-- TABLE DATA notice
-- -------------------------------------------
INSERT INTO `notice` (`notice_id`,`notice_title`,`notice_description`,`notice_start`,`notice_end`,`notice_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('1','Final Term Exams ','Final Term Exams will be conducted on coming monday. All The Best !','0000-00-00 00:00:00','0000-00-00 00:00:00','Students','2015-05-27 15:26:29','1','2019-01-26 11:59:21','9','Active');;;
INSERT INTO `notice` (`notice_id`,`notice_title`,`notice_description`,`notice_start`,`notice_end`,`notice_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('2','Monthly Report','All Employee have to submit their report on month end.','0000-00-00 00:00:00','0000-00-00 00:00:00','Employees','2015-05-27 15:27:23','1','2018-12-26 18:43:37','1','Inactive');;;
INSERT INTO `notice` (`notice_id`,`notice_title`,`notice_description`,`notice_start`,`notice_end`,`notice_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('3','Summer Vacation','Summer Vacation starts from June to  2nd week of July.','0000-00-00 00:00:00','0000-00-00 00:00:00','Students','2015-05-27 15:28:37','1','2018-12-26 18:44:16','1','Inactive');;;
INSERT INTO `notice` (`notice_id`,`notice_title`,`notice_description`,`notice_start`,`notice_end`,`notice_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('4','Attendance Report','All Employees collect their class wise  attendance report','0000-00-00 00:00:00','0000-00-00 00:00:00','Employees','2015-05-27 15:30:35','1','2018-12-26 18:44:19','1','Inactive');;;
INSERT INTO `notice` (`notice_id`,`notice_title`,`notice_description`,`notice_start`,`notice_end`,`notice_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('5','Exam From Fill','All Students come and fill their exam forms','0000-00-00 00:00:00','0000-00-00 00:00:00','Students','2015-05-27 15:33:07','1','2018-12-26 18:44:03','1','Active');;;
INSERT INTO `notice` (`notice_id`,`notice_title`,`notice_description`,`notice_start`,`notice_end`,`notice_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('6','Roll No Slip','Collect your roll no slips from the exams department.','2019-01-30 04:10:44','1900-12-02 03:00:00','Students','2019-01-30 15:04:08','9','2019-01-30 16:12:50','9','Active');;;
INSERT INTO `notice` (`notice_id`,`notice_title`,`notice_description`,`notice_start`,`notice_end`,`notice_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('7','Meeting','Meeting at 5:00 Pm for final exams conduction.','0000-00-00 00:00:00','0000-00-00 00:00:00','Employees','2019-01-30 15:11:30','9','0000-00-00 00:00:00','0','Inactive');;;
INSERT INTO `notice` (`notice_id`,`notice_title`,`notice_description`,`notice_start`,`notice_end`,`notice_user_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_status`) VALUES
('9','PTM','Parent teacher meeting on 01-Feb-2019 at 5:00 Pm.<br><b>Venue: Brookfield Group of Colleges</b>.','2019-01-30 04:01:59','2019-02-01 05:00:53','Parents','2019-01-30 16:02:23','9','2019-01-30 16:36:13','9','Active');;;
-- -------------------------------------------
-- TABLE DATA remarks_head
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA rooms
-- -------------------------------------------
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','Room-1','2019-05-26 00:47:51','0000-00-00 00:00:00','0','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','Room-2','2019-05-26 00:49:27','0000-00-00 00:00:00','0','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','Room-3','2019-05-26 00:49:56','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','Room-4','2019-05-26 00:50:04','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','Room-5','2019-05-26 00:50:20','0000-00-00 00:00:00','0','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','Room-6','2019-05-26 00:50:34','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','Room-7','2019-05-26 00:50:41','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('8','Room-8','2019-05-26 00:50:48','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('9','Room-9','2019-05-26 00:50:56','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('10','Room-10','2019-05-26 00:51:00','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('11','Room-11','2019-05-26 00:51:05','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('12','Room-12','2019-05-26 00:51:10','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('13','Room-13','2019-05-26 00:51:13','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('14','Room-14','2019-05-26 00:51:19','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('15','Room-15','2019-05-26 00:51:22','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('16','Room-16','2019-05-26 00:51:26','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('17','Room-17','2019-05-26 00:51:32','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('18','Room-18','2019-05-26 00:51:38','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('19','Room-19','2019-05-26 00:51:55','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('20','Room-20','2019-05-26 00:51:59','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('21','Computer Lab-1','2019-05-26 00:52:17','0000-00-00 00:00:00','1','0');;;
INSERT INTO `rooms` (`room_id`,`room_name`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('22','Computer Lab-2','2019-05-26 00:52:25','0000-00-00 00:00:00','1','0');;;
-- -------------------------------------------
-- TABLE DATA sms
-- -------------------------------------------
INSERT INTO `sms` (`sms_id`,`sms_name`,`sms_template`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','Absent Message','Absent Message','2019-03-07 13:20:16','0000-00-00 00:00:00','3','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_academic_info
-- -------------------------------------------
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','1','1','5','10th','2018','12345','505','408','A','81%','Colony High School','signed','2019-05-04 10:53:56','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','2','1','5','','','','','','','','Colony High School','signed','2019-05-04 10:53:56','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','3','1','5','','','','','','','','National Garrison ','signed','2019-05-04 10:53:56','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','4','1','5','','','','','','','','National Garrison ','signed','2019-05-04 10:53:56','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','5','11','14','6th','2018','12345','505','408','A','81%','National Garrison ','unsign','2019-05-04 10:19:34','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','6','11','14','6th','2019','265641','1100','880','A','80%','Colony High School','unsign','2019-05-04 10:21:35','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','7','11','14','6th','2019','265641','505','408','A','81%','Colony High School','unsign','2019-05-04 10:23:35','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','8','11','14','6th','2018','12345','505','408','A','81%','Colony High School','unsign','2019-05-04 10:25:31','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_academic_info` (`academic_id`,`std_id`,`class_name_id`,`subject_combination`,`previous_class`,`passing_year`,`previous_class_rollno`,`total_marks`,`obtained_marks`,`grades`,`percentage`,`Institute`,`std_enroll_status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','9','5','9','','','','','','','','','unsign','2019-06-25 11:18:04','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_attendance
-- -------------------------------------------
INSERT INTO `std_attendance` (`std_attend_id`,`branch_id`,`teacher_id`,`class_name_id`,`session_id`,`section_id`,`subject_id`,`date`,`student_id`,`status`) VALUES
('1','5','3','1','4','3','1','2019-05-04 00:00:00','1','P');;;
INSERT INTO `std_attendance` (`std_attend_id`,`branch_id`,`teacher_id`,`class_name_id`,`session_id`,`section_id`,`subject_id`,`date`,`student_id`,`status`) VALUES
('2','5','3','1','4','3','1','2019-05-04 00:00:00','2','P');;;
INSERT INTO `std_attendance` (`std_attend_id`,`branch_id`,`teacher_id`,`class_name_id`,`session_id`,`section_id`,`subject_id`,`date`,`student_id`,`status`) VALUES
('3','5','3','1','4','3','1','2019-05-04 00:00:00','3','P');;;
INSERT INTO `std_attendance` (`std_attend_id`,`branch_id`,`teacher_id`,`class_name_id`,`session_id`,`section_id`,`subject_id`,`date`,`student_id`,`status`) VALUES
('4','5','3','1','4','3','1','2019-05-04 00:00:00','4','P');;;
INSERT INTO `std_attendance` (`std_attend_id`,`branch_id`,`teacher_id`,`class_name_id`,`session_id`,`section_id`,`subject_id`,`date`,`student_id`,`status`) VALUES
('5','5','3','1','4','3','2','2019-05-04 00:00:00','1','P');;;
INSERT INTO `std_attendance` (`std_attend_id`,`branch_id`,`teacher_id`,`class_name_id`,`session_id`,`section_id`,`subject_id`,`date`,`student_id`,`status`) VALUES
('6','5','3','1','4','3','2','2019-05-04 00:00:00','2','P');;;
INSERT INTO `std_attendance` (`std_attend_id`,`branch_id`,`teacher_id`,`class_name_id`,`session_id`,`section_id`,`subject_id`,`date`,`student_id`,`status`) VALUES
('7','5','3','1','4','3','2','2019-05-04 00:00:00','3','P');;;
INSERT INTO `std_attendance` (`std_attend_id`,`branch_id`,`teacher_id`,`class_name_id`,`session_id`,`section_id`,`subject_id`,`date`,`student_id`,`status`) VALUES
('8','5','3','1','4','3','2','2019-05-04 00:00:00','4','P');;;
-- -------------------------------------------
-- TABLE DATA std_class_name
-- -------------------------------------------
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','5','KG-1','KG-1','Active','2019-03-16 06:27:49','2019-03-16 06:27:49','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','5','Nursery','Nursery','Active','2019-03-16 06:28:12','2019-03-16 06:28:12','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','5','Prep','Prep','Active','2019-03-16 06:28:25','2019-03-16 06:28:25','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','5','One','One','Active','2019-03-16 06:28:33','2019-03-16 06:28:33','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','5','Two','Two','Active','2019-03-16 06:28:45','2019-03-16 06:28:45','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','5','Three','Three','Active','2019-03-16 06:28:56','2019-03-16 06:28:56','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','5','Four','Four','Active','2019-03-16 06:29:09','2019-03-16 06:29:09','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','5','5th','5th','Active','2019-03-18 10:31:59','2019-03-16 06:29:26','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','6','6th','6th','Active','2019-03-18 10:30:32','2019-03-16 06:29:36','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('11','6','7th','7th','Active','2019-03-18 10:45:19','2019-03-18 10:45:19','1','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('12','6','8th ','8th ','Active','2019-03-18 10:45:28','2019-03-18 10:45:28','3','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('13','6','9th','9th','Active','2019-03-18 10:45:36','2019-03-18 10:45:36','3','1','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('14','6','10th','10th','Inactive','2019-04-20 13:12:28','2019-04-20 13:12:28','1','3','1');;;
INSERT INTO `std_class_name` (`class_name_id`,`branch_id`,`class_name`,`class_name_description`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('16','5','Play Group','Play Group','Active','2019-03-20 10:02:23','0000-00-00 00:00:00','4','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_enrollment_detail
-- -------------------------------------------
INSERT INTO `std_enrollment_detail` (`std_enroll_detail_id`,`std_enroll_detail_head_id`,`std_reg_no`,`std_roll_no`,`std_enroll_detail_std_id`,`std_enroll_detail_std_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','1','STD-Y19-1','KG--Gr19-1','1','Anas','2019-05-04 10:53:56','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_enrollment_detail` (`std_enroll_detail_id`,`std_enroll_detail_head_id`,`std_reg_no`,`std_roll_no`,`std_enroll_detail_std_id`,`std_enroll_detail_std_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','1','STD-Y19-2','KG--Gr19-2','2','Noman Shahid','2019-05-04 10:53:56','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_enrollment_detail` (`std_enroll_detail_id`,`std_enroll_detail_head_id`,`std_reg_no`,`std_roll_no`,`std_enroll_detail_std_id`,`std_enroll_detail_std_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','1','STD-Y19-3','KG--Gr19-3','3','Nadia Gull','2019-05-04 10:53:56','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_enrollment_detail` (`std_enroll_detail_id`,`std_enroll_detail_head_id`,`std_reg_no`,`std_roll_no`,`std_enroll_detail_std_id`,`std_enroll_detail_std_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','1','STD-Y19-4','KG--Gr19-4','4','Saif-ur-Rehman','2019-05-04 10:53:56','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_enrollment_head
-- -------------------------------------------
INSERT INTO `std_enrollment_head` (`std_enroll_head_id`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_enroll_head_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','5','3','4','3','Prep-2019 - 2020 -Green','2019-05-08 00:19:21','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_enrollment_head` (`std_enroll_head_id`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_enroll_head_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','5','1','4','1','KG-1-2019 - 2020 -Red','2019-05-22 23:08:33','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_enrollment_head` (`std_enroll_head_id`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_enroll_head_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','5','1','4','2','KG-1-2019 - 2020 -Blue','2019-05-22 23:09:41','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_enrollment_head` (`std_enroll_head_id`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_enroll_head_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','5','1','4','3','KG-1-2019 - 2020 -Green','2019-05-22 23:11:15','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_enrollment_head` (`std_enroll_head_id`,`branch_id`,`class_name_id`,`session_id`,`section_id`,`std_enroll_head_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','5','8','4','1','5th-2019 - 2020 -Red','2019-06-21 06:48:46','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_fee_details
-- -------------------------------------------
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','1','3000','0','3000','0','2000','2019-05-04 09:46:17','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','2','3000','0','3000','0','2000','2019-05-04 09:56:42','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','3','3000','0','3000','0','2000','2019-05-04 10:04:29','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','4','3000','0','3000','0','2000','2019-05-04 10:07:38','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','5','5000','0','5000','0','3000','2019-05-04 10:19:34','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','6','5000','0','5000','0','3000','2019-05-04 10:21:35','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','7','5000','0','5000','0','3000','2019-05-04 10:23:35','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','8','5000','0','5000','0','3000','2019-05-04 10:25:31','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_fee_details` (`fee_id`,`std_id`,`admission_fee`,`addmission_fee_discount`,`net_addmission_fee`,`concession_id`,`tuition_fee`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','9','4000','3000','1000','500','2500','2019-06-25 11:18:05','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_fee_installments
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA std_fee_pkg
-- -------------------------------------------
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('1','4','1','3000','2000','2019-03-20 10:36:41','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('2','4','16','3000','2000','2019-04-20 13:05:04','1','2019-04-20 13:05:04','3','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('3','4','2','3000','2000','2019-03-20 10:37:44','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('4','4','3','3000','2000','2019-03-20 10:38:02','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('5','4','4','4000','3000','2019-03-20 10:38:18','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('6','4','5','4000','3000','2019-03-20 10:38:52','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('7','4','6','4000','3000','2019-03-20 10:39:19','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('8','4','7','4000','3000','2019-03-20 10:40:57','1','2019-03-20 10:40:57','1','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('9','4','8','4000','3000','2019-03-20 10:40:37','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('10','6','9','5000','3000','2019-03-20 10:42:20','4','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('11','6','11','5000','3000','2019-03-20 10:42:37','4','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('12','6','12','5000','3000','2019-03-20 10:42:54','4','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('13','6','13','5000','4000','2019-03-20 10:43:14','4','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_fee_pkg` (`std_fee_id`,`session_id`,`class_id`,`admission_fee`,`tutuion_fee`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('14','6','14','5000','4000','2019-03-20 10:43:32','4','0000-00-00 00:00:00','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_guardian_info
-- -------------------------------------------
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','1','M Shafqat','Father','31303-4598637-0','shafqat@gmail.com','+92-300-7976242','+92-333-5498658','45000','Govt. Employe','employee','4439','2019-05-04 09:46:16','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','2','M Shahid','Father','31303-9876543-2','shahid@gmail.com','+92-315-8410500','+92-333-4567890','20000','Govt. Employe','Engineer','5464','2019-05-04 09:56:41','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','3','Iftikhar Ali','Father','31303-2345678-9','','+92-300-7976242','+92-333-2345678','','','','1336','2019-05-04 10:04:28','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','4','M. Ahmed','Father','45102-9876543-2','ahmed@gmail.com','+92-300-7976242','+92-333-8765432','45000','Govt. Employe','Engineer','7038','2019-05-04 10:07:37','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','5','G Mustafa','Father','31303-9473976-5','','+92-315-8410500','+92-334-4456788','','','','7653','2019-05-04 10:19:33','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','6','Iftikhar Ali','Father','31303-9876543-4','','+92-300-7976242','','','','','9056','2019-05-04 10:21:34','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','7','G Mustafa','Father','45102-8765432-3','','+92-300-7976242','','','','','7719','2019-05-04 10:23:34','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','8','Iftikhar Ali','Father','31323-9876543-8','','+92-315-8410500','','','','','1395','2019-05-04 10:25:30','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_guardian_info` (`std_guardian_info_id`,`std_id`,`guardian_name`,`guardian_relation`,`guardian_cnic`,`guardian_email`,`guardian_contact_no_1`,`guardian_contact_no_2`,`guardian_monthly_income`,`guardian_occupation`,`guardian_designation`,`guardian_password`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','9','Shahid Khalil','Father','12345-6789098-7','','+92-304-1422508','','','','','4971','2019-06-25 11:18:04','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_ice_info
-- -------------------------------------------
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('1','1','Asad Shafqat','Brother','+92-334-8765432','Gulshan Iqbal','2019-05-04 09:46:17','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('2','2','Anas','Friend','+92-334-5678998','Gulshan Iqbal','2019-05-04 09:56:42','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('3','3','Aniqa Gull','Sister','','','2019-05-04 10:04:29','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('4','4','Anas','Dost ','+92-335-4567898','Jaddah Town RYK','2019-05-04 10:07:38','1','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('5','5','Kinza','Sister','','','2019-05-04 10:19:34','4','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('6','6','Nadia Gull','Sister','','','2019-05-04 10:21:35','4','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('7','7','Aniqa Gull','Sister','','','2019-05-04 10:23:35','4','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('8','8','Nadia Gull','Sister','+92-345-6789009','','2019-05-04 10:25:31','4','0000-00-00 00:00:00','0','1');;;
INSERT INTO `std_ice_info` (`std_ice_id`,`std_id`,`std_ice_name`,`std_ice_relation`,`std_ice_contact_no`,`std_ice_address`,`created_at`,`created_by`,`updated_at`,`updated_by`,`delete_status`) VALUES
('9','9','','','','','2019-06-25 11:18:04','1','0000-00-00 00:00:00','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_inquiry
-- -------------------------------------------
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('1','5','STD-Y19-01','2019 - 2021','nauman','shahid','Male','+92-333-7486345','+92-300-6738133','2019-02-13','Nursery','Nursery','ESNA Public School','025','900','1100','82%','Anas','+90-331-7375765','MD DEXDEVS','RYK','','Inquiry','2019-04-20 10:04:32','2019-04-20 10:04:32','9','3');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('2','5','STD-Y19-02','2019 - 2021','Farhan','Shahid','Male','+92-331-5993454','+92-331-5848948','2019-03-06','ICS (Part - I)','Matric','ESNA Public School','12345','850','1100','77%','Nauman','+92-333-7486765','MD','Satelite Town, Rahim Yar Khan','','Inquiry','2019-03-12 17:45:51','2019-03-12 17:44:27','3','3');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('3','5','STD-Y19-03','2019 - 2021','Kinza','Mustafa','Female','+92-345-6789234','+92-456-7890987','2019-03-07','FSC Pre-Medical (Part - I)','metric','The New Horizons School','12365','800','1100','73%','Nadia','+92-987-6543765','hgh','lkjhgfdfghj','','Inquiry','2019-03-12 17:45:57','2019-03-12 17:37:11','3','3');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('4','5','STD-Y19-04','2019 - 2021','Saif-ur-Rehman','M. Khalil','Male','+92-308-3152045','+92-302-3836145','2019-03-12','ICS (Part - I)','Matric','Lahore School System','265641','743','1050','71%','Anas Shafqat','+92-331-7375027','MD DEXDEVS','Chak # 145/p, Adaam Sahaba','','Inquiry','2019-03-12 17:46:05','2019-03-12 17:38:57','3','3');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('5','6','STD-Y19-05','2019 - 2021','Nadia gull','Iftikhar ali','Female','+92-315-8410500','+92-303-8635458','2019-03-12','FSC Pre-Engineering (Part - II)','Matric','Lahore School System','1278','780','1050','74%','Asmat Ara ','+92-987-6545678','Ammi','kjhgfd','','Inquiry','2019-03-12 17:46:50','2019-03-12 17:46:50','3','3');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('6','6','STD-Y19-06','2019 - 2021','Shahzad ','Saeed','Male','+92-300-1234567','+92-310-1234567','2019-03-12','ICS (Part - I)','Metric','The New Horizons School','263214','743','1050','71%','Saif Ur Rehman','+92-308-3152045','student','Chack No 51 p ','','Inquiry','2019-03-12 17:46:22','2019-03-12 17:37:38','3','3');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('7','6','STD-Y19-07','2019 - 2021','Sadia ','Iftikhar ali','Female','+92-987-6545678','+92-234-5678987','2019-03-13','FSC Pre-Medical (Part - I)','10th','Lahore School System','8765498765','897','1050','85%','Aniqa','+87-654-3456787',',jnhbgvfd','lkjhgfd','lkjhgfdsdfghjklkjhbgv','Inquiry','2019-03-13 10:32:47','0000-00-00 00:00:00','21','0');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('8','6','STD-Y19-08','2019 - 2020','tfgyhuj','ihuhuihiu','Female','+92-654-9848949','+92-216-5189181','2019-03-18','8th ','7th','Lahore School System','123','450','500','90%','iuytrfd','+92-315-6894986','jnjn','bubj','omoimoim','Inquiry','2019-03-18 14:17:53','2019-03-18 14:11:18','4','4');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('9','6','STD-Y19-09','2019 - 2020','tygbbuhbHU','UHIUJIU','Male','+92-316-5165197','+92-333-3333333','2019-03-18','Four','Three','Lahore School System','123','450','500','90%','HUK','+92-361-6198619','DRTYFUGH IU','NJNOL','EDTRFYGUYH','Inquiry','2019-03-18 14:20:32','0000-00-00 00:00:00','4','0');;;
INSERT INTO `std_inquiry` (`std_inquiry_id`,`branch_id`,`std_inquiry_no`,`inquiry_session`,`std_name`,`std_father_name`,`gender`,`std_contact_no`,`std_father_contact_no`,`std_inquiry_date`,`std_intrested_class`,`std_previous_class`,`previous_institute`,`std_roll_no`,`std_obtained_marks`,`std_total_marks`,`std_percentage`,`refrence_name`,`refrence_contact_no`,`refrence_designation`,`std_address`,`comment`,`inquiry_status`,`created_at`,`updated_at`,`created_by`,`updated_by`) VALUES
('10','6','STD-Y19-010','2019 - 2020','Aniqa','Gull','Female','+92-654-3456789','+92-876-5434567','2019-03-18','Four','Three','Rehnuma Public School','678','450','500','90%','Ali','+92-345-6789876','kjhgfds','nhbgfdsa','jhgfdsdvbnytrrftgyujikl
jhgfdsxcvbhjkoiuytrer6','Inquiry','2019-03-18 17:44:25','0000-00-00 00:00:00','4','0');;;
-- -------------------------------------------
-- TABLE DATA std_personal_info
-- -------------------------------------------
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','5','STD-Y19-1','Anas','Shafqat','+92-333-2345433','2007-05-14','','RYK','Jinnah  Park RYK','anas@gmail.com','uploads/Anas_photo.jpg','31303-0437738-3','0000-00-00','','Rahim Yar Khan ','Islam','Pakistani','Rahim Yar Khan','1643','Active','Active','','2019-06-25 11:07:39','2019-06-25 11:07:39','1','1','1');;;
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','5','STD-Y19-2','Noman Shahid','M Shahid','+92-333-5678987','2000-09-18','Male','RYK','RYK','nauman@gmail.com','uploads/Noman Shahid_photo.jpg','31303-8765445-6','0000-00-00','','Rahim Yar Khan ','Islam','Pakistani','Rahim Yar Khan','5517','Active','Active','','2019-05-04 09:59:46','2019-05-04 09:59:46','1','1','1');;;
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','5','STD-Y19-3','Nadia Gull','Iftikhar Ali','+92-333-3456788','2000-02-01','Female','RYK','RYK','nadia@gmail.com','uploads/Nadia Gull_photo.jpg','31303-8765434-5','0000-00-00','','Rahim Yar Khan ','Islam','Pakistani','Rahim Yar Khan','7239','Active','Active','','2019-05-04 10:04:27','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','5','STD-Y19-4','Saif-ur-Rehman','M. Ahmed','+92-333-3456789','2000-01-14','Male','RYK','RYK','saif@gmail.com','uploads/Saif-ur-Rehman_photo.jpg','31303-9876545-6','0000-00-00','','Rahim Yar Khan ','Islam','Pakistani','Rahim Yar Khan','7689','Active','Active','','2019-05-04 10:07:36','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','6','STD-Y19-5','Asra','Mustafa','+92-398-7654456','2019-05-04','Female','RYK','RYK','asra@gmail.com','uploads/Asra_photo.jpg','31303-5793467-9','0000-00-00','','Rahim Yar Khan ','Islam','Pakistani','Rahim Yar Khan','6762','Active','Active','','2019-05-04 10:19:32','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','6','STD-Y19-6','Sadia Gull','Iftikhar Ali','+31-304-2632478','2019-05-04','Female','RYK','RYK','','uploads/Sadia Gull_photo.jpg','31303-3456789-8','0000-00-00','','Rahim Yar Khan ','Islam','Pakistani','Rahim Yar Khan','3776','Active','Active','','2019-05-04 10:21:33','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','6','STD-Y19-7','Zarwa Mustafa','G Mustafa','+92-334-5678909','2019-05-04','Female','RYK','RYK','zarwa@gmail.com','uploads/Zarwa Mustafa_photo.jpg','31303-8765456-7','0000-00-00','','Rahim Yar Khan ','Islam','Pakistani','RYK','3518','Active','Active','','2019-05-04 10:23:33','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','6','STD-Y19-8','Aniqa Gull','Iftikhar Ali','+92-334-5678998','2019-05-04','Female','RYK','RYK','asra@gmail.com','uploads/Aniqa Gull_photo.jpg','45102-8765435-6','0000-00-00','','RYK','Islam','Pakistani','Rahim Yar Khan','6848','Active','Active','','2019-05-04 10:25:29','0000-00-00 00:00:00','4','0','1');;;
INSERT INTO `std_personal_info` (`std_id`,`branch_id`,`std_reg_no`,`std_name`,`std_father_name`,`std_contact_no`,`std_DOB`,`std_gender`,`std_permanent_address`,`std_temporary_address`,`std_email`,`std_photo`,`std_b_form`,`admission_date`,`std_cast`,`std_district`,`std_religion`,`std_nationality`,`std_tehseel`,`std_password`,`status`,`academic_status`,`barcode`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','5','STD-REG-Y19-09','Farhan Shahid','Shahid Khalil','+92-304-1422507','2010-02-02','','Satellite Town ','Satellite Town ','','uploads/Farhan Shahid_photo.jpg','12345-6789123-4','2019-06-25','Hasmhi','RYK','Islam','Pakistani','RYK','7816','Active','Active','','2019-06-25 11:18:03','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_remarks
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA std_sections
-- -------------------------------------------
INSERT INTO `std_sections` (`section_id`,`branch_id`,`session_id`,`class_id`,`section_name`,`section_description`,`section_intake`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','5','4','1','Red','Red','25','2019-04-26 17:22:05','2019-03-16 07:10:30','3','1','1');;;
INSERT INTO `std_sections` (`section_id`,`branch_id`,`session_id`,`class_id`,`section_name`,`section_description`,`section_intake`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','5','4','1','Blue','Blue','25','2019-04-26 17:22:11','2019-03-16 07:10:47','3','1','1');;;
INSERT INTO `std_sections` (`section_id`,`branch_id`,`session_id`,`class_id`,`section_name`,`section_description`,`section_intake`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','5','4','1','Green','Green','20','2019-04-26 19:10:10','2019-04-26 19:10:10','3','1','1');;;
INSERT INTO `std_sections` (`section_id`,`branch_id`,`session_id`,`class_id`,`section_name`,`section_description`,`section_intake`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','5','4','4','Pink','Pink','30','2019-04-26 19:09:34','2019-04-26 19:09:34','3','1','1');;;
INSERT INTO `std_sections` (`section_id`,`branch_id`,`session_id`,`class_id`,`section_name`,`section_description`,`section_intake`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','6','6','3','Green','Green ','30','2019-04-26 18:57:35','2019-04-26 18:57:35','3','4','1');;;
INSERT INTO `std_sections` (`section_id`,`branch_id`,`session_id`,`class_id`,`section_name`,`section_description`,`section_intake`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('11','6','6','2','Red','Red','25','2019-04-26 19:04:22','0000-00-00 00:00:00','4','0','1');;;
-- -------------------------------------------
-- TABLE DATA std_sessions
-- -------------------------------------------
INSERT INTO `std_sessions` (`session_id`,`session_branch_id`,`session_name`,`session_start_date`,`session_end_date`,`status`,`installment_cycle`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','5','2019 - 2020 ','2019-03-01','2020-03-31','Active','4','2019-03-16 12:04:49','2019-03-16 12:04:49','1','1','1');;;
INSERT INTO `std_sessions` (`session_id`,`session_branch_id`,`session_name`,`session_start_date`,`session_end_date`,`status`,`installment_cycle`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','6','2019 - 2020','2019-03-01','2020-03-31','Active','0','2019-03-16 12:05:16','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `std_sessions` (`session_id`,`session_branch_id`,`session_name`,`session_start_date`,`session_end_date`,`status`,`installment_cycle`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','5','2020 - 2021','2019-03-19','2019-03-19','Inactive','0','2019-04-26 22:15:40','2019-04-26 22:15:40','4','4','1');;;
-- -------------------------------------------
-- TABLE DATA std_subjects
-- -------------------------------------------
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('1','13','Biology,Chemistry,Physics,English A,English B,Urdu A,Urdu B,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('2','14','Biology,Chemistry,Physics,English A,English B,Urdu A,Urdu B,Pak-Studies');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('3','13','Computer,Chemistry,Physics,English A,English B,Urdu A,Urdu B,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('4','14','Computer,Chemistry,Physics,English A,English B,Urdu A,Urdu B,Pak-Studies');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('5','1','Math,English A,Urdu A,Computer,Pak-Studies,Drawing');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('6','2','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('7','3','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('8','4','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('9','5','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('10','6','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('11','7','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('12','8','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('13','9','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('14','11','Math,English A,Urdu A,Islamiat');;;
INSERT INTO `std_subjects` (`std_subject_id`,`class_id`,`std_subject_name`) VALUES
('15','12','Math,English A,Urdu A,Islamiat');;;
-- -------------------------------------------
-- TABLE DATA subjects
-- -------------------------------------------
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','Math','M','Math','2019-04-20 12:54:14','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','English A','Ea','English A','2019-04-20 12:54:14','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','English B','Eb','English B','2019-04-20 12:54:14','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('4','Urdu A','Ua','Urdu A','2019-04-20 12:54:14','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('5','Urdu B','Ub','Urdu B','2019-04-20 12:54:14','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('6','Science','S','Science','2019-04-20 12:54:14','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('7','Pak-Studies','Ps','History / Pak-Studies','2019-04-20 12:54:14','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('8','Computer','Cm','Computer','2019-04-20 12:54:14','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('9','Islamiat','I','Islamiat','2019-04-20 12:54:14','2018-12-31 16:57:46','1','1','0');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('10','Drawing','D','Drawing','2019-04-18 11:57:07','0000-00-00 00:00:00','9','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('11','Biology','B','Biology','2019-04-20 12:54:15','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('12','Physics','P','Physics','2019-04-20 12:54:15','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('13','Chemistry','Ch','Chemistry','2019-04-20 12:54:15','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `subjects` (`subject_id`,`subject_name`,`subject_alias`,`subject_description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('14','Islamiat (Elective)','I(ele)','Islamiat (Elective)','2019-04-20 12:54:15','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA teacher_subject_assign_detail
-- -------------------------------------------
INSERT INTO `teacher_subject_assign_detail` (`teacher_subject_assign_detail_id`,`teacher_subject_assign_detail_head_id`,`incharge`,`class_id`,`subject_id`,`no_of_lecture`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','1','1','1','1','1 Lecture','2019-05-04 11:05:44','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `teacher_subject_assign_detail` (`teacher_subject_assign_detail_id`,`teacher_subject_assign_detail_head_id`,`incharge`,`class_id`,`subject_id`,`no_of_lecture`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('2','1','0','1','2','1 Lecture','2019-05-04 11:06:55','0000-00-00 00:00:00','1','0','1');;;
INSERT INTO `teacher_subject_assign_detail` (`teacher_subject_assign_detail_id`,`teacher_subject_assign_detail_head_id`,`incharge`,`class_id`,`subject_id`,`no_of_lecture`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('3','1','0','1','4','1 Lecture','2019-05-04 11:06:55','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA teacher_subject_assign_head
-- -------------------------------------------
INSERT INTO `teacher_subject_assign_head` (`teacher_subject_assign_head_id`,`teacher_id`,`teacher_subject_assign_head_name`,`created_at`,`updated_at`,`created_by`,`updated_by`,`delete_status`) VALUES
('1','3','Kinza Mustafa','2019-05-04 11:05:44','0000-00-00 00:00:00','1','0','1');;;
-- -------------------------------------------
-- TABLE DATA time_table_detail
-- -------------------------------------------
INSERT INTO `time_table_detail` (`time_table_d_id`,`time_table_h_id`,`subject_id`,`start_time`,`end_time`,`room`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('2','5','8','08:00:00','08:40:00','Room-1','1','0','2019-05-10 11:31:30','0000-00-00 00:00:00');;;
INSERT INTO `time_table_detail` (`time_table_d_id`,`time_table_h_id`,`subject_id`,`start_time`,`end_time`,`room`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('3','5','9','08:40:00','09:20:00','Room-1','1','0','2019-05-10 11:31:30','0000-00-00 00:00:00');;;
INSERT INTO `time_table_detail` (`time_table_d_id`,`time_table_h_id`,`subject_id`,`start_time`,`end_time`,`room`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('4','5','2','09:20:00','10:00:00','Room-1','1','0','2019-05-10 11:31:30','0000-00-00 00:00:00');;;
INSERT INTO `time_table_detail` (`time_table_d_id`,`time_table_h_id`,`subject_id`,`start_time`,`end_time`,`room`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('5','5','4','10:20:00','11:00:00','Room-1','1','0','2019-05-10 11:31:30','0000-00-00 00:00:00');;;
INSERT INTO `time_table_detail` (`time_table_d_id`,`time_table_h_id`,`subject_id`,`start_time`,`end_time`,`room`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('6','5','1','11:00:00','11:40:00','Room-1','1','0','2019-05-10 11:31:30','0000-00-00 00:00:00');;;
-- -------------------------------------------
-- TABLE DATA time_table_head
-- -------------------------------------------
INSERT INTO `time_table_head` (`time_table_h_id`,`class_id`,`days`,`status`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('5','1','Monday,Tuesday,Wednesday,Thursday,Friday,Saturday','Active','1','0','2019-05-10 11:31:30','0000-00-00 00:00:00');;;
-- -------------------------------------------
-- TABLE DATA user
-- -------------------------------------------
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('1','5','Dexterous','Developers','dexdevs','anas@dexdevs.com','dexdevs','pQEdYTAVV_wLtqIALoSZ-vELIA0mdsOx','$2y$13$ClHehtUhZZQqsocCsPnEwer2wfQd4gTcpwSOJTkWnvoMD/oFzfCpG','','userphotos/dexdevs_photo.png','1','10','1552727256','1552727256');;;
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('3','5','Super','Admin','Superadmin','superadmin@gmail.com','Superadmin','xqZuT3vxOiZ-rsN56V6wjZhi7VXMpKnD','$2y$13$9TnNqeWAHECax0kmKSBzK.tGW/ePQm6IkutslR9ITYIXocjs4nnX.','','userphotos/Superadmin_photo.png','1','10','1552883449','1552883449');;;
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('4','6','Dexterous','Developers','dexdevsdeveloper','admin@dexdevs.com','dexdevs2','m4vI7EWTZ61_eTBrJf_tliCWdgRfCKzM','$2y$13$k6pJmBNM4hrkgZh0SYhcC.dZLxMLOjsJtVo55TV4QiVIJ4F6t7lIW','','userphotos/dexdevs2_photo.png','1','10','1552894313','1552894313');;;
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('94','5','','','45102-0511722-2','kinza.fatima.522@gmail.com','Teacher','780IQdeAG-7zbU1hPr78QYYLu0a-3hob','$2y$13$TxvaK0Nggikoobfw3rXSbeKCPProPS.bnJ3Avs0P1jxQUcAXgwHDO','','uploads/Kinza Mustafa_emp_photo.jpg','1','10','1556948502','1556948502');;;
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('96','5','','','Executive','executive@abc.com','Executive','0nZjH6QF5WhUz_Df-8X21kKCVCIgi8AI','$2y$13$emHj93Oxj0nIaLIIF1N0/uK3461diDYunNDYQCH95TdNDW/s9evAW','','userphotos/Executive_photo.jpg','1','10','1556957679','1556957679');;;
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('102','5','','','12345-6789123-4','','Student','_iui2wuJ6tZOFmOXJEQUCqtIMBAdCgV8','$2y$13$6z3duEseVTj4HMSEumZeueIAm1I1WdkeJAvw8n0OLj4/yiVNGtq7u','','uploads/Farhan Shahid_photo.jpg','1','10','1561443484','1561443484');;;
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('103','5','','','12345-6789098-7','','Parent','-141QAZe7KsIFC0qOiIR5rMTz3yBpa8q','$2y$13$8y9ervakTCd.N8AKSY57JunyuYXZ1ayWjHRolk5YrRxqQDVcij6Ee','','uploads/Farhan Shahid_photo.jpg','1','10','1561443484','1561443484');;;
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('104','5','','','31303-0437738-3','anasshafqat01@gmail.com','Teacher','x81FaJ-7fOraeMpC-CpQr6oPmx_9o_dQ','$2y$13$jFRj307sG1ptFraOUgN1BupdErvUE/VZnh3mPWF3JjoUPCjeOGydi','','uploads/Anas Shafqat_emp_photo.jpg','1','10','1561445072','1561445072');;;
INSERT INTO `user` (`id`,`branch_id`,`first_name`,`last_name`,`username`,`email`,`user_type`,`auth_key`,`password_hash`,`password_reset_token`,`user_photo`,`is_block`,`status`,`created_at`,`updated_at`) VALUES
('106','5','','','12345-6789000-0','nadia@gmail.com','Teacher','jjazLozV02xWGyn0GqRQYw-iVhzFQA4d','$2y$13$vuthKOeV8OZT/6J8AdoIJu2RIbu5Nf0JFDsNtvK0jo9u0sqGj15a.','','uploads/Nadia Gull_emp_photo.jpg','1','10','1561455821','1561455821');;;
-- -------------------------------------------
-- TABLE DATA users
-- -------------------------------------------
INSERT INTO `users` (`id`,`user_name`) VALUES
('1','Principal');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('2','Admin');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('3','Vice Principal');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('4','Superadmin');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('5','Inquiry Head');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('6','Registrar');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('7','Accountant');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('8','Exams Controller');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('9','Student');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('10','Teacher');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('11','Parent');;;
INSERT INTO `users` (`id`,`user_name`) VALUES
('12','Executive');;;
-- -------------------------------------------
-- TABLE DATA visitors
-- -------------------------------------------
INSERT INTO `visitors` (`visitor_id`,`visitor_name`,`visitor_contact_no`,`visitor_photo`,`visitor_cnic`,`date_time`,`visit_purpose`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('1','Kinza Mustafa','+92-300-7976242','','4510205117222','2019-06-18 01:23:40','meeting with principle','1','1','2019-06-18 13:40:17','2019-06-18 13:23:42');;;
INSERT INTO `visitors` (`visitor_id`,`visitor_name`,`visitor_contact_no`,`visitor_photo`,`visitor_cnic`,`date_time`,`visit_purpose`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('2','Nauman Hashmi','+92-333-7486807','','31303-4519566-9','0000-00-00 00:00:00','want to visit admission office
','1','1','2019-06-17 00:58:51','2019-06-17 00:58:51');;;
INSERT INTO `visitors` (`visitor_id`,`visitor_name`,`visitor_contact_no`,`visitor_photo`,`visitor_cnic`,`date_time`,`visit_purpose`,`created_by`,`updated_by`,`created_at`,`updated_at`) VALUES
('3','Anas Shafqat','+92-345-6767767','uploads/Anas Shafqat_photo.jpg','31303-1234567-8','2019-06-18 12:46:45','some purpose
','1','0','2019-06-18 12:46:58','0000-00-00 00:00:00');;;
-- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
COMMIT;
-- -------------------------------------------
-- -------------------------------------------
-- END BACKUP
-- -------------------------------------------
