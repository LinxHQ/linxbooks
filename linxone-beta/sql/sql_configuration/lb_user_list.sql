-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2017 at 11:41 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linxbook`
--

--
-- Dumping data for table `lb_user_list`
--

INSERT INTO `lb_user_list` (`system_list_item_id`, `system_list_name`, `system_list_code`, `system_list_item_code`, `system_list_item_name`, `system_list_parent_item_id`, `system_list_item_order`, `system_list_item_active`, `system_list_item_day`, `system_list_item_month`) VALUES
(21, '', 'leave_type', 'leave_type_Advanced Leave', 'Advanced Leave', 0, 0, 1, 0, 0),
(23, '', 'leave_type', 'leave_type_Anniversary Credit', 'Anniversary Credit', 0, 0, 1, 0, 0),
(24, '', 'leave_type', 'leave_type_Annual Leave', 'Annual Leave', 0, 0, 1, 0, 0),
(25, '', 'leave_type', 'leave_type_Apprisal', 'Apprisal', 0, 0, 1, 0, 0),
(26, '', 'leave_type', 'leave_type_Balace Leave', 'Balace Leave', 0, 0, 1, 0, 0),
(27, '', 'leave_type', 'leave_type_Brought Fwr Leave', 'Brought Fwr Leave', 0, 0, 1, 0, 0),
(28, '', 'leave_type', 'leave_type_Compasionate Leave', 'Compasionate Leave', 0, 0, 1, 0, 0),
(29, '', 'leave_type', 'leave_type_Consumed Leave', 'Consumed Leave', 0, 0, 1, 0, 0),
(30, '', 'leave_type', 'leave_type_Enhanced Childcare Leave', 'Enhanced Childcare Leave', 0, 0, 1, 0, 0),
(31, '', 'leave_type', 'leave_type_In-lieu Labour Day', 'In-lieu Labour Day', 0, 0, 1, 0, 0),
(32, '', 'leave_type', 'leave_type_Infant Care', 'Infant Care', 0, 0, 1, 0, 0),
(33, '', 'leave_type', 'leave_type_Leave in Lieu', 'Leave in Lieu', 0, 0, 1, 0, 0),
(34, '', 'leave_type', 'leave_type_Maternity Leave', 'Maternity Leave', 0, 0, 1, 0, 0),
(35, '', 'leave_type', 'leave_type_Moving office', 'Moving office', 0, 0, 1, 0, 0),
(36, '', 'leave_type', 'leave_type_National Service Leave', 'National Service Leave', 0, 0, 1, 0, 0),
(37, '', 'leave_type', 'leave_type_On Course', 'On Course', 0, 0, 1, 0, 0),
(38, '', 'leave_type', 'leave_type_Paternity Leave', 'Paternity Leave', 0, 0, 1, 0, 0),
(39, '', 'leave_type', 'leave_type_Sick Leave', 'Sick Leave', 0, 0, 1, 0, 0),
(40, '', 'leave_type', 'leave_type_Staff Event', 'Staff Event', 0, 0, 1, 0, 0),
(41, '', 'leave_type', 'leave_type_Staff Lunch', 'Staff Lunch', 0, 0, 1, 0, 0),
(42, '', 'leave_type', 'leave_type_Staff Meeting', 'Staff Meeting', 0, 0, 1, 0, 0),
(43, '', 'leave_type', 'leave_type_Unpaid Leave', 'Unpaid Leave', 0, 0, 1, 0, 0),
(44, '', 'status_list', 'status_list_Submitted', 'Submitted', 0, 0, 1, 0, 0),
(45, '', 'status_list', 'status_list_Approved', 'Approved', 0, 0, 1, 0, 0),
(46, '', 'status_list', 'status_list_Rejected', 'Rejected', 0, 0, 1, 0, 0),
(47, '', 'status_list', 'status_list_Pending', 'Pending', 0, 0, 1, 0, 0),
(48, '', 'leave_year', 'leave_year_2010', '2010', 0, 0, 1, 0, 0),
(49, '', 'leave_year', 'leave_year_2011', '2011', 0, 0, 1, 0, 0),
(50, '', 'leave_year', 'leave_year_2012', '2012', 0, 0, 1, 0, 0),
(51, '', 'leave_year', 'leave_year_2013', '2013', 0, 0, 1, 0, 0),
(52, '', 'leave_year', 'leave_year_2014', '2014', 0, 0, 1, 0, 0),
(53, '', 'leave_year', 'leave_year_2015', '2015', 0, 0, 1, 0, 0),
(54, '', 'leave_year', 'leave_year_2016', '2016', 0, 0, 1, 0, 0),
(55, '', 'leave_year', 'leave_year_2017', '2017', 0, 0, 1, 0, 0),
(56, '', 'leave_year', 'leave_year_2018', '2018', 0, 0, 1, 0, 0),
(57, '', 'leave_year', 'leave_year_2019', '2019', 0, 0, 1, 0, 0),
(58, '', 'leave_year', 'leave_year_2020', '2020', 0, 0, 1, 0, 0),
(59, '', 'leave_application_hourstart', 'leave_application_hourstart_09', '09', 0, 0, 1, 0, 0),
(60, '', 'leave_application_hourstart', 'leave_application_hourstart_13', '13', 0, 0, 1, 0, 0),
(61, '', 'leave_application_hourend', 'leave_application_hourend_09', '09', 0, 0, 1, 0, 0),
(62, '', 'leave_application_hourend', 'leave_application_hourend_13', '13', 0, 0, 1, 0, 0),
(63, '', 'leave_application_hourend', 'leave_application_hourend_18', '18', 0, 0, 1, 0, 0),
(64, '', 'leave_application_minute', 'leave_application_minute_00', '00', 0, 0, 1, 0, 0),
(65, '', 'leave_application_minute', 'leave_application_minute_30', '30', 0, 0, 1, 0, 0),
(66, '', 'leave_application_minutestart', 'leave_application_minutestart_00', '00', 0, 0, 1, 0, 0),
(67, '', 'leave_application_minutestart', 'leave_application_minutestart_30', '30', 0, 0, 1, 0, 0),
(68, '', 'custom_type', 'custom_type_Customer', 'Customer', 0, 0, 1, 0, 0),
(69, '', 'custom_type', 'custom_type_Vendor', 'Vendor', 0, 0, 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
