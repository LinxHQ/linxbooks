-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2017 at 12:35 PM
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
-- Table structure for table `lb_departments`
--

CREATE TABLE `lb_departments` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_department_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_department_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_department_phone` int(11) NOT NULL,
  `lb_department_fax` int(11) NOT NULL,
  `lb_department_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_department_city` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_department_state` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_department_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_department_parent_id` int(11) NOT NULL,
  `lb_department_create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_departments`
--

INSERT INTO `lb_departments` (`lb_record_primary_key`, `lb_department_name`, `lb_department_no`, `lb_department_phone`, `lb_department_fax`, `lb_department_address`, `lb_department_city`, `lb_department_state`, `lb_department_description`, `lb_department_parent_id`, `lb_department_create_date`) VALUES
(1, 'Administrative Office', 'KD-0123456', 123456789, 445566, 'Số 58, Trần Thái Tông, Cầu giấy, Hà Nội', 'H? N?i', 'abcabc', 'C?ng ty ph?t tri?n ph?n m?m ho?nh tr?ng', 0, '2017-09-26'),
(2, 'Research & Development', 'KD-0123456', 123456789, 445566, 'Số 58, Trần Thái Tông, Cầu giấy, Hà Nội', 'H? N?i', 'abcabc', 'C?ng ty ph?t tri?n ph?n m?m ho?nh tr?ng', 0, '2017-09-26');

-- --------------------------------------------------------

--
-- Table structure for table `lb_department_employees`
--

CREATE TABLE `lb_department_employees` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_department_id` int(11) NOT NULL,
  `lb_employee_id` int(11) NOT NULL,
  `lb_assigning_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_talent_courses`
--

CREATE TABLE `lb_talent_courses` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_course_name` varchar(255) NOT NULL,
  `lb_level_id` int(2) NOT NULL,
  `lb_create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_talent_course_skills`
--

CREATE TABLE `lb_talent_course_skills` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_talent_course_id` int(11) NOT NULL,
  `lb_skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_talent_employee_courses`
--

CREATE TABLE `lb_talent_employee_courses` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_course_id` int(11) NOT NULL,
  `lb_course_status_id` int(11) NOT NULL,
  `lb_result_course` varchar(50) NOT NULL,
  `lb_create_date` date NOT NULL,
  `lb_end_date` date NOT NULL,
  `lb_talent_need_id` int(11) NOT NULL,
  `lb_employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_talent_need`
--

CREATE TABLE `lb_talent_need` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_talent_name` varchar(255) NOT NULL,
  `lb_department_id` int(11) NOT NULL,
  `lb_talent_status_id` int(11) NOT NULL,
  `lb_talent_description` text NOT NULL,
  `lb_talent_start_date` date NOT NULL,
  `lb_talent_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_talent_need`
--

INSERT INTO `lb_talent_need` (`lb_record_primary_key`, `lb_talent_name`, `lb_department_id`, `lb_talent_status_id`, `lb_talent_description`, `lb_talent_start_date`, `lb_talent_end_date`) VALUES
(3, 'Agile project management', 1, 1, 'This is Agile project management', '2017-09-01', '2017-09-30'),
(4, 'Marketing preparation for Vietnam market', 2, 0, 'This is Marketing preparation for Vietnam market', '2017-09-01', '2017-09-30'),
(5, 'Blockchain', 1, 1, 'This is Blockchain', '2017-09-01', '2017-09-30'),
(6, 'Global cloud infrastructure', 2, 0, 'This is Global cloud infrastructure', '2017-09-01', '2017-09-30'),
(7, 'test', 2, 0, 'test', '2017-09-27', '2017-09-27'),
(8, 'tessttt', 2, 0, 'asdasdasd', '2016-12-01', '2017-09-27'),
(9, 'test', 2, 0, 'asdsasdasd', '2017-09-27', '2017-09-27'),
(10, 'asdasfsdfsdf', 1, 0, 'asdasdasdasd', '2017-09-27', '2017-09-27'),
(11, '123123weqweqwe', 1, 0, 'asdasdasd', '2017-09-27', '2017-09-27'),
(12, '23123', 1, 0, 'asdasdasdasdasd', '2017-09-27', '2017-09-27'),
(13, 'dsfsdfsdfsdf', 1, 0, 'sdfsdfsdf', '2017-09-27', '2017-09-28'),
(14, 'tessttt', 2, 0, 'asdasd', '2017-09-28', '2017-09-28');

-- --------------------------------------------------------

--
-- Table structure for table `lb_talent_need_skills`
--

CREATE TABLE `lb_talent_need_skills` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_talent_need_id` int(11) NOT NULL,
  `lb_skill_id` int(11) NOT NULL,
  `lb_create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_talent_skills`
--

CREATE TABLE `lb_talent_skills` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_skill_name` varchar(255) NOT NULL,
  `lb_parent_id` int(11) NOT NULL,
  `lb_level_id` int(2) NOT NULL,
  `lb_create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_talent_skills`
--

INSERT INTO `lb_talent_skills` (`lb_record_primary_key`, `lb_skill_name`, `lb_parent_id`, `lb_level_id`, `lb_create_date`) VALUES
(2, 'TeamWork1234', 0, 78, '2017-09-28'),
(3, 'Code', 2, 75, '2017-09-27'),
(4, 'Github', 2, 0, '2017-09-27'),
(6, 'Code', 4, 74, '2017-09-27'),
(7, 'Website', 0, 0, '2017-09-28'),
(8, 'PHP', 7, 0, '2017-09-28'),
(9, 'HTML/CSS', 7, 0, '2017-09-28'),
(10, 'MYSQL', 8, 0, '2017-09-28'),
(11, 'fac', 10, 0, '2017-09-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lb_departments`
--
ALTER TABLE `lb_departments`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_department_employees`
--
ALTER TABLE `lb_department_employees`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_talent_courses`
--
ALTER TABLE `lb_talent_courses`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_talent_course_skills`
--
ALTER TABLE `lb_talent_course_skills`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_talent_employee_courses`
--
ALTER TABLE `lb_talent_employee_courses`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_talent_need`
--
ALTER TABLE `lb_talent_need`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_talent_need_skills`
--
ALTER TABLE `lb_talent_need_skills`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_talent_skills`
--
ALTER TABLE `lb_talent_skills`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lb_departments`
--
ALTER TABLE `lb_departments`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lb_department_employees`
--
ALTER TABLE `lb_department_employees`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_talent_courses`
--
ALTER TABLE `lb_talent_courses`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `lb_talent_course_skills`
--
ALTER TABLE `lb_talent_course_skills`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `lb_talent_employee_courses`
--
ALTER TABLE `lb_talent_employee_courses`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `lb_talent_need`
--
ALTER TABLE `lb_talent_need`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `lb_talent_need_skills`
--
ALTER TABLE `lb_talent_need_skills`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `lb_talent_skills`
--
ALTER TABLE `lb_talent_skills`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO `lb_user_list` (`system_list_name`, `system_list_code`, `system_list_item_code`, `system_list_item_name`, `system_list_parent_item_id`, `system_list_item_order`, `system_list_item_active`, `system_list_item_day`, `system_list_item_month`) VALUES
(NULL, 'level_talent', 'level_talent_Level 1', 'Level 1', NULL, NULL, 1, NULL, NULL),
(NULL, 'level_talent', 'level_talent_Level 2', 'Level 2', NULL, NULL, 1, NULL, NULL),
(NULL, 'level_talent', 'level_talent_Level 3', 'Level 3', NULL, NULL, 1, NULL, NULL),
(NULL, 'level_talent', 'level_talent_Level 4', 'Level 4', NULL, NULL, 1, NULL, NULL),
(NULL, 'level_talent', 'level_talent_Level 5', 'Level 5', NULL, NULL, 1, NULL, NULL),
(NULL, 'date', 'date_2015', '2015', NULL, NULL, 1, NULL, NULL),
(NULL, 'date', 'date_2016', '2016', NULL, NULL, 1, NULL, NULL),
(NULL, 'date', 'date_2017', '2017', NULL, NULL, 1, NULL, NULL),
(NULL, 'date', 'date_2018', '2018', NULL, NULL, 1, NULL, NULL),
(NULL, 'date', 'date_2019', '2019', NULL, NULL, 1, NULL, NULL),
(NULL, 'year', 'year_2015', '2015', NULL, NULL, 1, NULL, NULL),
(NULL, 'year', 'year_2016', '2016', NULL, NULL, 1, NULL, NULL),
(NULL, 'year', 'year_2017', '2017', NULL, NULL, 1, NULL, NULL),
(NULL, 'year', 'year_2018', '2018', NULL, NULL, 1, NULL, NULL),
(NULL, 'result', 'result_Bad', 'Bad', NULL, NULL, 1, NULL, NULL),
(NULL, 'result', 'result_Good', 'Good', NULL, NULL, 1, NULL, NULL),
(NULL, 'result', 'result_Very Good', 'Very Good', NULL, NULL, 1, NULL, NULL),
(NULL, 'status_need', 'status_need_Completed', 'Completed', NULL, NULL, 1, NULL, NULL),
(NULL, 'status_need', 'status_need_In-Progress', 'In-Progress', NULL, NULL, 1, NULL, NULL);