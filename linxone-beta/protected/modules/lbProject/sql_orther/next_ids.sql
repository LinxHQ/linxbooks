-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2017 at 05:14 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linxcricle`
--

-- --------------------------------------------------------

--
-- Table structure for table `next_ids`
--

CREATE TABLE `next_ids` (
  `next_id` int(11) NOT NULL,
  `subcription_id` int(11) NOT NULL,
  `task_next` varchar(20) NOT NULL,
  `issue_next` varchar(20) NOT NULL,
  `implementation_next` varchar(20) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `next_ids`
--

INSERT INTO `next_ids` (`next_id`, `subcription_id`, `task_next`, `issue_next`, `implementation_next`) VALUES
(1, 266, '10', '1', '1'),
(2, 369, '6', '1', '1'),
(3, 350, '94', '1', '1'),
(4, 253, '336', '1', '143'),
(5, 371, '2', '1', '1'),
(6, 214, '121', '1', '1'),
(7, 373, '2', '1', '1'),
(8, 374, '5', '1', '1'),
(9, 376, '2', '1', '1'),
(10, 378, '2', '1', '1'),
(11, 379, '2', '1', '1'),
(12, 307, '1', '1', '2'),
(13, 381, '3', '1', '1'),
(14, 383, '2', '1', '1'),
(15, 384, '4', '1', '1'),
(16, 388, '2', '1', '1'),
(17, 329, '172', '1', '2'),
(18, 391, '11', '1', '1'),
(19, 399, '6', '1', '1'),
(20, 405, '2', '1', '1'),
(21, 406, '2', '1', '2'),
(22, 407, '2', '1', '1'),
(23, 11, '2', '1', '1'),
(24, 409, '2', '1', '1'),
(25, 410, '2', '1', '1'),
(26, 411, '2', '1', '1'),
(27, 414, '15', '1', '1'),
(28, 416, '2', '1', '1'),
(29, 415, '20', '1', '12'),
(30, 421, '31', '1', '1'),
(31, 429, '2', '1', '2'),
(32, 437, '5', '1', '1'),
(33, 438, '4', '1', '1'),
(34, 442, '2', '1', '1'),
(35, 426, '3', '1', '1'),
(36, 463, '2', '1', '1'),
(37, 466, '7', '1', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
