-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2015 at 05:58 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `linxcircle`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_start_date` date DEFAULT NULL,
  `task_end_date` date DEFAULT NULL,
  `task_owner_id` int(11) NOT NULL,
  `task_created_date` date NOT NULL,
  `task_public_viewable` tinyint(1) DEFAULT NULL,
  `task_status` tinyint(1) DEFAULT NULL,
  `task_last_commented_date` datetime DEFAULT NULL,
  `task_description` longtext,
  `task_is_sticky` int(1) DEFAULT '0' COMMENT '1: sticky. 0: no',
  `task_type` int(2) DEFAULT '1',
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `task_assignees`
--

CREATE TABLE IF NOT EXISTS `task_assignees` (
  `task_assignee_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `task_assignee_start_date` datetime NOT NULL,
  PRIMARY KEY (`task_assignee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `task_progress`
--

CREATE TABLE IF NOT EXISTS `task_progress` (
  `tp_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `tp_percent_completed` decimal(3,0) NOT NULL,
  `tp_days_completed` decimal(2,1) NOT NULL,
  `tp_last_update` datetime NOT NULL,
  `tp_last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`tp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `task_resource_plan`
--

CREATE TABLE IF NOT EXISTS `task_resource_plan` (
  `trp_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `trp_start` date NOT NULL,
  `trp_end` date NOT NULL,
  `trp_work_load` int(3) NOT NULL,
  `trp_effort` decimal(2,1) NOT NULL,
  PRIMARY KEY (`trp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
