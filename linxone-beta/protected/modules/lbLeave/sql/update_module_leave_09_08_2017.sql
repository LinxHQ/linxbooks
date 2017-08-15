-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2017 at 11:08 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--


ALTER TABLE `leave_application` CHANGE `leave_name` `leave_name` INT(2) NULL DEFAULT NULL;
ALTER TABLE `leave_application` CHANGE `leave_date_submit` `leave_date_submit` INT(2) NULL DEFAULT NULL;
ALTER TABLE `leave_application` CHANGE `leave_starthour` `leave_starthour` INT(2) NULL DEFAULT NULL;
ALTER TABLE `leave_application` CHANGE `leave_startminute` `leave_startminute` INT(2) NULL DEFAULT NULL;
ALTER TABLE `leave_application` CHANGE `leave_endhour` `leave_endhour` INT(2) NULL DEFAULT NULL;
ALTER TABLE `leave_application` CHANGE `leave_endminute` `leave_endminute` INT(2) NULL DEFAULT NULL;


ALTER TABLE `leave_application` ADD `leave_list_day` TEXT NULL DEFAULT NULL AFTER `leave_endminute`;
ALTER TABLE `leave_application` ADD `leave_sum_day` DECIMAL(10,1) NULL DEFAULT NULL AFTER `leave_list_day`;
--
-- Indexes for dumped tables
--

--
-- AUTO_INCREMENT for dumped tables
--



--
-- Table structure for table `lb_sys_translate`
--


--
-- Dumping data for data table `lb_sys_translate`
--

INSERT INTO `lb_sys_translate` (`lb_tranlate_en`, `lb_translate_vn`) VALUES
('Full day', 'Cả ngày'),
('Half day leave (morning)', 'Buổi sáng'),
('Half day leave (afternoon)', 'Buổi chiều'),
('Employee', 'Nhân viên'),
('Update Application', 'Chỉnh sửa đơn xin nghỉ'),
('View Application', 'Xem đơn xin nghỉ'),
('List Day Leave', 'Chi tiết ngày nghỉ'),
('Sum day leave', 'Tổng số ngày nghỉ'),
('Date submit', 'Ngày nộp'),
('Add CC-Receiver', 'Thêm người nhận'),
('leave_application_style_date', 'Trạng thái nghỉ');