-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 10, 2015 at 09:27 AM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `process_checklist`
--

--
-- Table structure for table `process_checklist`
--

CREATE TABLE IF NOT EXISTS `process_checklist` (
  `pc_id` int(11) NOT NULL AUTO_INCREMENT,
  `subcription_id` int(11) NOT NULL,
  `pc_name` varchar(100) NOT NULL,
  `pc_created_by` int(11) NOT NULL,
  `pc_created_date` date NOT NULL,
  `pc_last_update_by` int(11) NOT NULL,
  `pc_last_update` date NOT NULL,
  PRIMARY KEY (`pc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `process_checklist_default`
--

CREATE TABLE IF NOT EXISTS `process_checklist_default` (
  `pcdi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_id` int(11) NOT NULL,
  `pcdi_name` varchar(255) NOT NULL,
  `pcdi_order` int(2) NOT NULL,
  PRIMARY KEY (`pcdi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `process_checklist_item_rel`
--

CREATE TABLE IF NOT EXISTS `process_checklist_item_rel` (
  `pcir_id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_id` int(11) NOT NULL,
  `pcir_name` varchar(255) NOT NULL,
  `pcir_order` int(11) NOT NULL,
  `pcir_entity_type` varchar(100) NOT NULL,
  `pcir_entity_id` int(11) NOT NULL,
  `pcir_status` int(1) NOT NULL,
  `pcir_status_update_by` int(11) NOT NULL,
  `pcir_status_date` date NOT NULL,
  PRIMARY KEY (`pcir_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
