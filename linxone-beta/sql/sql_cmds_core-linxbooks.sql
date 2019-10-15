-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2017 at 09:57 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lb_trunk1`
--

-- --------------------------------------------------------

--
-- Table structure for table `lb_pastoral_care`
--
DROP TABLE `lb_pastoral_care`;
CREATE TABLE `lb_pastoral_care` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_people_id` int(11) NOT NULL,
  `lb_pastoral_care_type` int(11) NOT NULL,
  `lb_pastoral_care_pastor_id` int(11) NOT NULL,
  `lb_pastoral_care_date` datetime NOT NULL,
  `lb_pastoral_care_remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_pastoral_care`
--

INSERT INTO `lb_pastoral_care` (`lb_record_primary_key`, `lb_people_id`, `lb_pastoral_care_type`, `lb_pastoral_care_pastor_id`, `lb_pastoral_care_date`, `lb_pastoral_care_remark`) VALUES
(9, 21, 113, 25, '2017-11-22 10:00:00', 'tét');

-- --------------------------------------------------------

--
-- Table structure for table `lb_people`
--
DROP TABLE `lb_people`;
CREATE TABLE `lb_people` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_given_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_family_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_title` int(11) DEFAULT NULL,
  `lb_people_believer` int(1) DEFAULT NULL,
  `lb_gender` int(3) DEFAULT NULL,
  `lb_birthday` date DEFAULT NULL,
  `lb_nationality` int(11) DEFAULT NULL,
  `lb_marital_status` int(1) DEFAULT NULL,
  `lb_ethnic` int(11) DEFAULT NULL,
  `lb_nric` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_religion` int(11) DEFAULT NULL,
  `lb_company_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_company_position` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_company_occupation` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_baptism_church` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_baptism_no` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_baptism_date` date DEFAULT NULL,
  `lb_local_address_street` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_local_address_street2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_local_address_mobile` int(11) DEFAULT NULL,
  `lb_local_address_phone` int(11) DEFAULT NULL,
  `lb_local_address_phone_2` int(11) DEFAULT NULL,
  `lb_local_address_level` int(11) DEFAULT NULL,
  `lb_local_address_unit` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_local_address_postal_code` int(6) DEFAULT NULL,
  `lb_local_address_email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_local_address_country` int(11) DEFAULT NULL,
  `lb_overseas_address_street` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_overseas_address_street2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_overseas_address_mobile` int(11) DEFAULT NULL,
  `lb_overseas_address_phone` int(11) DEFAULT NULL,
  `lb_overseas_address_phone2` int(11) DEFAULT NULL,
  `lb_overseas_address_level` int(11) DEFAULT NULL,
  `lb_overseas_address_unit` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_overseas_address_postal_code` int(6) DEFAULT NULL,
  `lb_overseas_address_email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_overseas_address_country` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_people`
--

INSERT INTO `lb_people` (`lb_record_primary_key`, `lb_given_name`, `lb_family_name`, `lb_title`, `lb_people_believer`, `lb_gender`, `lb_birthday`, `lb_nationality`, `lb_marital_status`, `lb_ethnic`, `lb_nric`, `lb_religion`, `lb_company_name`, `lb_company_position`, `lb_company_occupation`, `lb_baptism_church`, `lb_baptism_no`, `lb_baptism_date`, `lb_local_address_street`, `lb_local_address_street2`, `lb_local_address_mobile`, `lb_local_address_phone`, `lb_local_address_phone_2`, `lb_local_address_level`, `lb_local_address_unit`, `lb_local_address_postal_code`, `lb_local_address_email`, `lb_local_address_country`, `lb_overseas_address_street`, `lb_overseas_address_street2`, `lb_overseas_address_mobile`, `lb_overseas_address_phone`, `lb_overseas_address_phone2`, `lb_overseas_address_level`, `lb_overseas_address_unit`, `lb_overseas_address_postal_code`, `lb_overseas_address_email`, `lb_overseas_address_country`) VALUES
(21, 'tuchido', 'ghostmastert', 95, 98, 24, '1993-12-06', 100, 103, 104, '017253900', 107, 'LinxHQ', '58, trần thái tông, cầu giấy, hà nội', 'devlopper', 'nhà thờ rửa tội', 'số no rửa tội', '2017-11-20', 'Ba Vì, Hà Nội', 'Cầu Giấy, Hà Nội', 1674033581, 1674033581, 1674033581, 6, '123123', 123123, 'tula@linxhq.com', 110, 'Quận 10, Sigapore', 'Quận 20, Sigapore', 123654, 123456, 654321, 10, '123123', 123123, 'caybutdasau.1102@gmail.com', 111),
(25, 'sadasd', 'ádasd', NULL, NULL, NULL, '1970-01-01', NULL, NULL, NULL, '', NULL, '', '', '', '', '', '1970-01-01', '', '', NULL, NULL, NULL, NULL, '', NULL, '', NULL, '', '', NULL, NULL, NULL, NULL, '', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lb_people_memberships`
--
DROP TABLE `lb_people_memberships`;
CREATE TABLE `lb_people_memberships` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_people_id` int(11) NOT NULL,
  `lb_membership_type` int(11) NOT NULL,
  `lb_membership_start_date` date NOT NULL,
  `lb_membership_end_date` date NOT NULL,
  `lb_membership_confirm` int(11) NOT NULL,
  `lb_membership_remark` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_people_relationships`
--
DROP TABLE `lb_people_relationships`;
CREATE TABLE `lb_people_relationships` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_people_id` int(11) NOT NULL,
  `lb_people_relationship_id` int(11) NOT NULL,
  `lb_people_relationship_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_people_volunteers`
--
DROP TABLE `lb_people_volunteers`;
CREATE TABLE `lb_people_volunteers` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_volunteers_active` int(1) NOT NULL,
  `lb_entity_id` int(11) DEFAULT NULL,
  `lb_entity_type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_people_volunteers`
--

INSERT INTO `lb_people_volunteers` (`lb_record_primary_key`, `lb_volunteers_active`, `lb_entity_id`, `lb_entity_type`) VALUES
(15, 131, 3, 'smallgroup'),
(16, 131, 4, 'smallgroup');

-- --------------------------------------------------------

--
-- Table structure for table `lb_people_volunteers_stage`
--
DROP TABLE `lb_people_volunteers_stage`;
CREATE TABLE `lb_people_volunteers_stage` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_people_id` int(11) NOT NULL,
  `lb_volunteers_id` int(11) NOT NULL,
  `lb_volunteers_type` int(11) NOT NULL,
  `lb_volunteers_position` int(11) NOT NULL,
  `lb_volunteers_start_date` date NOT NULL,
  `lb_volunteers_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_people_volunteers_stage`
--

INSERT INTO `lb_people_volunteers_stage` (`lb_record_primary_key`, `lb_people_id`, `lb_volunteers_id`, `lb_volunteers_type`, `lb_volunteers_position`, `lb_volunteers_start_date`, `lb_volunteers_end_date`) VALUES
(5, 25, 15, 129, 130, '2017-11-23', '2017-11-30'),
(6, 21, 16, 128, 130, '2017-11-23', '2017-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `lb_small_groups`
--
DROP TABLE `lb_small_groups`;
CREATE TABLE `lb_small_groups` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_group_name` varchar(255) NOT NULL,
  `lb_group_type` varchar(50) DEFAULT NULL,
  `lb_group_district` varchar(50) DEFAULT NULL,
  `lb_group_frequency` int(11) DEFAULT NULL,
  `lb_group_meeting_time` datetime DEFAULT NULL,
  `lb_group_since` date DEFAULT NULL,
  `lb_group_location` varchar(255) DEFAULT NULL,
  `lb_group_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_small_groups`
--

INSERT INTO `lb_small_groups` (`lb_record_primary_key`, `lb_group_name`, `lb_group_type`, `lb_group_district`, `lb_group_frequency`, `lb_group_meeting_time`, `lb_group_since`, `lb_group_location`, `lb_group_active`) VALUES
(3, 'Alpha ONE', '115', 'BPJ', 118, '2017-11-22 15:00:00', '2017-11-22', 'West', 122),
(4, 'tesst', '116', 'tesst', 120, '2017-11-22 17:00:00', '2017-11-22', 'tesst', 121);

-- --------------------------------------------------------

--
-- Table structure for table `lb_small_group_people`
--
DROP TABLE `lb_small_group_people`;
CREATE TABLE `lb_small_group_people` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_small_group_id` int(11) NOT NULL,
  `lb_people_id` int(11) NOT NULL,
  `lb_position_id` int(11) NOT NULL,
  `lb_mem_small_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_small_group_people`
--

INSERT INTO `lb_small_group_people` (`lb_record_primary_key`, `lb_small_group_id`, `lb_people_id`, `lb_position_id`, `lb_mem_small_active`) VALUES
(11, 3, 21, 1, 126),
(14, 3, 25, 2, 126),
(18, 4, 25, 1, 126),
(19, 4, 21, 2, 126);

-- --------------------------------------------------------

--

INSERT INTO `lb_user_list` (`system_list_name`, `system_list_code`, `system_list_item_code`, `system_list_item_name`, `system_list_parent_item_id`, `system_list_item_order`, `system_list_item_active`, `system_list_item_day`, `system_list_item_month`) VALUES
(NULL, 'people_title', 'people_title_Mr', 'Mr', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_title', 'people_title_Ms', 'Ms', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_believer', 'people_believer_Yes', 'Yes', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_believer', 'people_believer_No', 'No', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_nationality', 'people_nationality_Viet Nam', 'Viet Nam', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_nationality', 'people_nationality_Singapore', 'Singapore', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_marital', 'people_marital_Not Married', 'Not Married', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_marital', 'people_marital_Married', 'Married', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_ethnic', 'people_ethnic_Kinh', 'Kinh', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_ethnic', 'people_ethnic_Thái', 'Thái', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_religion', 'people_religion_Phật giáo', 'Phật giáo', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_religion', 'people_religion_Hồi giáo', 'Hồi giáo', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_religion', 'people_religion_Tin Lành', 'Tin Lành', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_country', 'people_country_Việt Nam', 'Việt Nam', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_country', 'people_country_Singapore', 'Singapore', NULL, NULL, 1, NULL, NULL),
(NULL, 'pastoralcare_type', 'pastoralcare_type_Hospital Visit', 'Hospital Visit', NULL, NULL, 1, NULL, NULL),
(NULL, 'pastoralcare_type', 'pastoralcare_type_Wedding', 'Wedding', NULL, NULL, 1, NULL, NULL),
(NULL, 'pastoralcare_type', 'pastoralcare_type_Party', 'Party', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_type', 'small_group_type_Young Adults', 'Young Adults', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_type', 'small_group_type_35-45', '35-45', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_frequency', 'small_group_frequency_Weekly', 'Weekly', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_frequency', 'small_group_frequency_Biweekly', 'Biweekly', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_frequency', 'small_group_frequency_Monthly', 'Monthly', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_frequency', 'small_group_frequency_Bimonthly', 'Bimonthly', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_active', 'small_group_active_Active', 'Active', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_active', 'small_group_active_In-Progress', 'In-Progress', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_member_active', 'small_group_member_active_Active', 'Active', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_member_active', 'small_group_member_active_In-Progress', 'In-Progress', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_ministry', 'volunteers_ministry_Sunbeams', 'Sunbeams', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_ministry', 'volunteers_ministry_Worship', 'Worship', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_position', 'volunteers_position_Leader', 'Leader', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_active', 'volunteers_active_Active', 'Active', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_active', 'volunteers_active_In-Progress', 'In-Progress', NULL, NULL, 1, NULL, NULL),
(NULL, 'small_group_member_position', 'small_group_member_position_Member', 'Member', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_relationships', 'people_relationships_Wife', 'Wife', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_relationships', 'people_relationships_Son', 'Son', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_relationships', 'people_relationships_Daughter', 'Daughter', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_relationships', 'people_relationships_Mother', 'Mother', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_membership_type', 'people_membership_type_Transferred in', 'Transferred in', NULL, NULL, 1, NULL, NULL),
(NULL, 'people_membership_type', 'people_membership_type_Renewed', 'Renewed', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_ministry', 'volunteers_ministry_Sunbeams1', 'Sunbeams1', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_ministry', 'volunteers_ministry_Worship2', 'Worship2', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_position', 'volunteers_position_Member', 'Member', NULL, NULL, 1, NULL, NULL),
(NULL, 'volunteers_position', 'volunteers_position_Assistant', 'Assistant', NULL, NULL, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lb_pastoral_care`
--
ALTER TABLE `lb_pastoral_care`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_people`
--
ALTER TABLE `lb_people`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_people_memberships`
--
ALTER TABLE `lb_people_memberships`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_people_relationships`
--
ALTER TABLE `lb_people_relationships`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_people_volunteers`
--
ALTER TABLE `lb_people_volunteers`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_people_volunteers_stage`
--
ALTER TABLE `lb_people_volunteers_stage`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_small_groups`
--
ALTER TABLE `lb_small_groups`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_small_group_people`
--
ALTER TABLE `lb_small_group_people`
  ADD PRIMARY KEY (`lb_record_primary_key`);


--
-- AUTO_INCREMENT for table `lb_pastoral_care`
--
ALTER TABLE `lb_pastoral_care`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `lb_people`
--
ALTER TABLE `lb_people`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `lb_people_memberships`
--
ALTER TABLE `lb_people_memberships`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_people_relationships`
--
ALTER TABLE `lb_people_relationships`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_people_volunteers`
--
ALTER TABLE `lb_people_volunteers`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `lb_people_volunteers_stage`
--
ALTER TABLE `lb_people_volunteers_stage`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `lb_small_groups`
--
ALTER TABLE `lb_small_groups`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lb_small_group_people`
--
ALTER TABLE `lb_small_group_people`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

