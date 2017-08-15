-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2017 at 11:46 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linxbooks_lb_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `lb_project_list_items`
--

CREATE TABLE `lb_project_list_items` (
  `system_list_item_id` int(11) NOT NULL,
  `system_list_name` varchar(255) NOT NULL,
  `system_list_item_code` char(50) NOT NULL,
  `system_list_item_name` varchar(255) NOT NULL,
  `system_list_parent_item_id` int(11) DEFAULT NULL,
  `system_list_item_order` int(4) DEFAULT NULL,
  `system_list_item_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_project_list_items`
--

INSERT INTO `lb_project_list_items` (`system_list_item_id`, `system_list_name`, `system_list_item_code`, `system_list_item_name`, `system_list_parent_item_id`, `system_list_item_order`, `system_list_item_active`) VALUES
(1, 'Issue Priority', 'issue_priority_high', 'High', NULL, 1, 1),
(2, 'Issue Priority', 'issue_priority_normal', 'Normal', NULL, 2, 1),
(3, 'Issue Priority', 'issue_priority_low', 'Low', NULL, 3, 1),
(4, 'Issue Status', 'issue_status_open', 'Open', NULL, 1, 1),
(5, 'Issue Status', 'issue_status_closed', 'Closed', NULL, 2, 1),
(6, 'Implementation Status', 'implementation_status_pending', 'Pending', NULL, 1, 1),
(8, 'Implementation Status', 'implementation_status_done_with_success', 'Successful', NULL, 3, 1),
(9, 'Implementation Status', 'implementation_status_done_with_reversion', 'Failed', NULL, 4, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
