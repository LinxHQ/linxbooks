-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2017 at 11:38 AM
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
-- Table structure for table `lb_opportunity`
--

CREATE TABLE `lb_opportunity` (
  `opportunity_id` int(11) NOT NULL,
  `opportunity_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `opportunity_status_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `opportunity_document_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `industry` int(11) NOT NULL,
  `star_rating` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lb_opportunity_comment`
--

CREATE TABLE `lb_opportunity_comment` (
  `id` int(11) NOT NULL,
  `opportunity_id` int(11) NOT NULL,
  `comment_content` text COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lb_opportunity_document`
--

CREATE TABLE `lb_opportunity_document` (
  `id` int(11) NOT NULL,
  `opportunity_id` int(11) NOT NULL,
  `opportunity_document_name` text COLLATE utf8_unicode_ci NOT NULL,
  `opportunity_document_type` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `opportunity_document_size` char(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lb_opportunity_entry`
--

CREATE TABLE `lb_opportunity_entry` (
  `id` int(11) NOT NULL,
  `opportunity_id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `entry_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lb_opportunity_industry`
--

CREATE TABLE `lb_opportunity_industry` (
  `id` int(11) NOT NULL,
  `industry_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lb_opportunity_status`
--

CREATE TABLE `lb_opportunity_status` (
  `id` int(11) NOT NULL,
  `column_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `listorder` int(11) NOT NULL,
  `column_color` char(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_opportunity_status`
--

INSERT INTO `lb_opportunity_status` (`id`, `column_name`, `listorder`, `column_color`) VALUES
(2, 'Proposal', 1, 'rgb(159, 266, 228)'),
(3, 'Verbal Won', 3, 'rgb(255, 254, 0)'),
(4, 'Signed Won', 0, 'rgb(20, 194, 5)'),
(5, 'Lost', 2, 'rgb(156, 152, 152)'),
(6, 'Qualification', 0, 'rgb(249, 0, 0)'),
(7, 'Negotiation', 0, 'rgb(167, 58, 231)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lb_opportunity`
--
ALTER TABLE `lb_opportunity`
  ADD PRIMARY KEY (`opportunity_id`);

--
-- Indexes for table `lb_opportunity_comment`
--
ALTER TABLE `lb_opportunity_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_opportunity_document`
--
ALTER TABLE `lb_opportunity_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_opportunity_entry`
--
ALTER TABLE `lb_opportunity_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_opportunity_industry`
--
ALTER TABLE `lb_opportunity_industry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_opportunity_status`
--
ALTER TABLE `lb_opportunity_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lb_opportunity`
--
ALTER TABLE `lb_opportunity`
  MODIFY `opportunity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;
--
-- AUTO_INCREMENT for table `lb_opportunity_comment`
--
ALTER TABLE `lb_opportunity_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `lb_opportunity_document`
--
ALTER TABLE `lb_opportunity_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `lb_opportunity_entry`
--
ALTER TABLE `lb_opportunity_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=549;
--
-- AUTO_INCREMENT for table `lb_opportunity_industry`
--
ALTER TABLE `lb_opportunity_industry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lb_opportunity_status`
--
ALTER TABLE `lb_opportunity_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
