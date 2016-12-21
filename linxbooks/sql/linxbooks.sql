-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2016 at 10:27 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linxbookgithub`
--

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_basic_permission`
--

CREATE TABLE `lb_account_basic_permission` (
  `account_basic_permission_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `basic_permission_id` int(11) NOT NULL,
  `basic_permission_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_define_permission`
--

CREATE TABLE `lb_account_define_permission` (
  `account_define_permission_id` int(11) NOT NULL,
  `define_permission_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_roles`
--

CREATE TABLE `lb_account_roles` (
  `account_role_id` int(11) NOT NULL,
  `accout_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_bank_account`
--

CREATE TABLE `lb_bank_account` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_account_id` int(11) NOT NULL,
  `lb_bank_account` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_basic_permission`
--

CREATE TABLE `lb_basic_permission` (
  `basic_permission_id` int(11) NOT NULL,
  `basic_permission_name` varchar(100) NOT NULL,
  `basic_permission_description` varchar(255) NOT NULL,
  `basic_permission_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_comment`
--

CREATE TABLE `lb_comment` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_module_name` varchar(100) NOT NULL,
  `lb_comment_description` longtext NOT NULL,
  `lb_item_module_id` int(11) NOT NULL,
  `lb_account_id` int(11) NOT NULL,
  `lb_comment_date` date NOT NULL,
  `lb_parent_comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_contracts`
--

CREATE TABLE `lb_contracts` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_customer_id` int(11) NOT NULL,
  `lb_address_id` int(11) NOT NULL,
  `lb_contact_id` int(11) NOT NULL,
  `lb_contract_no` varchar(50) NOT NULL,
  `lb_contract_notes` varchar(255) NOT NULL,
  `lb_contract_date_start` date NOT NULL,
  `lb_contract_date_end` date NOT NULL,
  `lb_contract_type` varchar(100) NOT NULL,
  `lb_contract_amount` decimal(10,2) NOT NULL,
  `lb_contract_parent` int(11) NOT NULL,
  `lb_contract_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_contract_document`
--

CREATE TABLE `lb_contract_document` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_contract_id` int(11) NOT NULL,
  `lb_document_url` varchar(255) NOT NULL,
  `lb_document_name` varchar(255) NOT NULL,
  `lb_document_url_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_contract_invoice`
--

CREATE TABLE `lb_contract_invoice` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_contract_id` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_core_entities`
--

CREATE TABLE `lb_core_entities` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_entity_type` char(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'INVOICE, QUOTATION, CUSTOMER,...',
  `lb_entity_primary_key` int(11) NOT NULL,
  `lb_created_by` int(11) NOT NULL,
  `lb_created_date` datetime NOT NULL,
  `lb_last_updated_by` int(11) NOT NULL,
  `lb_last_update` datetime NOT NULL,
  `lb_subscription_id` int(11) NOT NULL,
  `lb_locked_from_deletion` tinyint(1) NOT NULL COMMENT 'e.g. already paid or written-off invoices'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='attributes that almost all important models should have';

--
-- Dumping data for table `lb_core_entities`
--

INSERT INTO `lb_core_entities` (`lb_record_primary_key`, `lb_entity_type`, `lb_entity_primary_key`, `lb_created_by`, `lb_created_date`, `lb_last_updated_by`, `lb_last_update`, `lb_subscription_id`, `lb_locked_from_deletion`) VALUES
(1, 'lbGenera', 1, 1, '2015-06-15 04:15:38', 1, '2016-12-20 03:24:12', 1, 0),
(2, 'lbNextId', 1, 1, '2015-06-15 04:15:38', 1, '2016-12-20 11:34:00', 1, 0),
(3, 'lbDefaultNote', 1, 1, '2015-06-15 04:15:38', 1, '2015-06-15 04:15:38', 1, 0),
(4, 'modules', 1, 1, '2015-06-15 04:15:45', 1, '2015-06-15 04:16:36', 1, 0),
(5, 'modules', 2, 1, '2015-06-15 04:15:49', 1, '2015-06-15 04:16:32', 1, 0),
(6, 'modules', 3, 1, '2015-06-15 04:15:52', 1, '2015-06-15 04:16:29', 1, 0),
(7, 'modules', 4, 1, '2015-06-15 04:15:55', 1, '2015-06-15 04:16:25', 1, 0),
(8, 'modules', 5, 1, '2015-06-15 04:15:58', 1, '2015-06-15 04:16:22', 1, 0),
(9, 'modules', 6, 1, '2015-06-15 04:16:01', 1, '2015-06-15 04:16:18', 1, 0),
(10, 'modules', 7, 1, '2015-06-15 04:16:06', 1, '2015-06-15 04:16:15', 1, 0),
(11, 'modules', 8, 1, '2015-06-15 04:16:09', 1, '2015-06-15 04:16:12', 1, 0),
(12, 'lbInvoice', 1, 1, '2016-12-19 08:56:37', 1, '2016-12-19 08:56:37', 1, 0),
(13, 'lbInvoiceItem', 1, 1, '2016-12-19 08:56:38', 1, '2016-12-19 08:56:38', 1, 0),
(14, 'lbInvoiceItem', 2, 1, '2016-12-19 08:56:38', 1, '2016-12-19 08:56:38', 1, 0),
(15, 'lbInvoiceTotal', 1, 1, '2016-12-19 08:56:38', 1, '2016-12-19 08:56:41', 1, 0),
(16, 'lbInvoice', 2, 1, '2016-12-19 08:57:00', 1, '2016-12-19 08:57:00', 1, 0),
(17, 'lbInvoiceItem', 3, 1, '2016-12-19 08:57:01', 1, '2016-12-19 08:57:01', 1, 0),
(18, 'lbInvoiceItem', 4, 1, '2016-12-19 08:57:01', 1, '2016-12-19 08:57:01', 1, 0),
(19, 'lbInvoiceTotal', 2, 1, '2016-12-19 08:57:01', 1, '2016-12-19 08:57:02', 1, 0),
(20, 'lbInvoice', 3, 1, '2016-12-19 08:58:04', 1, '2016-12-19 08:59:39', 1, 0),
(21, 'lbInvoiceItem', 5, 1, '2016-12-19 08:58:05', 1, '2016-12-19 08:59:21', 1, 0),
(22, 'lbInvoiceItem', 6, 1, '2016-12-19 08:58:05', 1, '2016-12-19 08:59:22', 1, 0),
(23, 'lbInvoiceTotal', 3, 1, '2016-12-19 08:58:05', 1, '2016-12-19 08:59:34', 1, 0),
(24, 'lbCustomer', 6, 1, '2016-12-19 08:58:24', 1, '2016-12-20 07:49:27', 1, 0),
(25, 'lbCustomerAddress', 1, 1, '2016-12-19 08:58:40', 1, '2016-12-19 08:58:40', 1, 0),
(26, 'lbCustomerContact', 1, 1, '2016-12-19 08:59:04', 1, '2016-12-19 08:59:04', 1, 0),
(27, 'lbTax', 1, 1, '2016-12-19 08:59:33', 1, '2016-12-19 08:59:33', 1, 0),
(28, 'lbInvoiceItem', 7, 1, '2016-12-19 08:59:33', 1, '2016-12-19 08:59:33', 1, 0),
(33, 'lbInvoice', 5, 1, '2016-12-19 11:37:56', 1, '2016-12-19 11:37:56', 1, 0),
(34, 'lbInvoiceItem', 10, 1, '2016-12-19 11:37:57', 1, '2016-12-19 11:37:57', 1, 0),
(35, 'lbInvoiceItem', 11, 1, '2016-12-19 11:37:57', 1, '2016-12-19 11:37:57', 1, 0),
(36, 'lbInvoiceTotal', 5, 1, '2016-12-19 11:37:57', 1, '2016-12-20 07:52:34', 1, 0),
(37, 'lbCustomer', 7, 1, '2016-12-19 11:39:21', 1, '2016-12-20 04:40:57', 1, 0),
(38, 'lbCustomerAddress', 2, 1, '2016-12-19 11:39:21', 1, '2016-12-19 11:39:21', 1, 0),
(43, 'lbCustomer', 8, 1, '2016-12-19 11:42:51', 1, '2016-12-20 04:40:57', 1, 0),
(44, 'lbCustomerAddress', 3, 1, '2016-12-19 11:42:52', 1, '2016-12-19 11:42:52', 1, 0),
(45, 'lbCustomerContact', 2, 1, '2016-12-19 11:42:52', 1, '2016-12-19 11:42:52', 1, 0),
(46, 'lbCustomerAddressContact', 1, 1, '2016-12-19 11:42:52', 1, '2016-12-19 11:42:52', 1, 0),
(51, 'lbInvoice', 8, 1, '2016-12-20 02:34:39', 1, '2016-12-20 02:34:58', 1, 0),
(52, 'lbInvoiceItem', 16, 1, '2016-12-20 02:34:39', 1, '2016-12-20 02:34:39', 1, 0),
(53, 'lbInvoiceItem', 17, 1, '2016-12-20 02:34:39', 1, '2016-12-20 02:34:39', 1, 0),
(54, 'lbInvoiceTotal', 8, 1, '2016-12-20 02:34:39', 1, '2016-12-20 02:34:40', 1, 0),
(59, 'lbTax', 2, 1, '2016-12-20 03:25:27', 1, '2016-12-20 03:25:58', 1, 0),
(60, 'lbInvoice', 10, 1, '2016-12-20 03:41:13', 1, '2016-12-20 03:41:21', 1, 0),
(61, 'lbInvoiceItem', 20, 1, '2016-12-20 03:41:13', 1, '2016-12-20 03:41:13', 1, 0),
(62, 'lbInvoiceItem', 21, 1, '2016-12-20 03:41:13', 1, '2016-12-20 03:41:13', 1, 0),
(63, 'lbInvoiceTotal', 10, 1, '2016-12-20 03:41:14', 1, '2016-12-20 03:51:14', 1, 0),
(64, 'lbInvoice', 11, 1, '2016-12-20 03:54:35', 1, '2016-12-20 03:54:35', 1, 0),
(65, 'lbInvoiceItem', 22, 1, '2016-12-20 03:54:36', 1, '2016-12-20 03:54:36', 1, 0),
(66, 'lbInvoiceItem', 23, 1, '2016-12-20 03:54:36', 1, '2016-12-20 03:54:36', 1, 0),
(67, 'lbInvoiceTotal', 11, 1, '2016-12-20 03:54:36', 1, '2016-12-20 03:55:29', 1, 0),
(68, 'lbInvoice', 12, 1, '2016-12-20 03:55:53', 1, '2016-12-20 03:57:41', 1, 0),
(69, 'lbInvoiceItem', 24, 1, '2016-12-20 03:55:53', 1, '2016-12-20 03:56:30', 1, 0),
(70, 'lbInvoiceItem', 25, 1, '2016-12-20 03:55:53', 1, '2016-12-20 03:56:56', 1, 0),
(71, 'lbInvoiceTotal', 12, 1, '2016-12-20 03:55:53', 1, '2016-12-20 05:11:00', 1, 0),
(72, 'lbInvoiceItem', 26, 1, '2016-12-20 03:56:36', 1, '2016-12-20 03:56:55', 1, 0),
(73, 'lbPayment', 1, 1, '2016-12-20 03:57:40', 1, '2016-12-20 03:57:40', 1, 0),
(74, 'lbPaymentItem', 1, 1, '2016-12-20 03:57:40', 1, '2016-12-20 03:57:40', 1, 0),
(75, 'lbInvoice', 13, 1, '2016-12-20 03:58:03', 1, '2016-12-20 03:58:03', 1, 0),
(76, 'lbInvoiceItem', 27, 1, '2016-12-20 03:58:04', 1, '2016-12-20 03:58:04', 1, 0),
(77, 'lbInvoiceItem', 28, 1, '2016-12-20 03:58:04', 1, '2016-12-20 03:58:04', 1, 0),
(78, 'lbInvoiceTotal', 13, 1, '2016-12-20 03:58:04', 1, '2016-12-20 03:58:05', 1, 0),
(79, 'lbInvoice', 14, 1, '2016-12-20 04:11:35', 1, '2016-12-20 08:44:36', 1, 0),
(80, 'lbInvoiceItem', 29, 1, '2016-12-20 04:11:35', 1, '2016-12-20 04:12:37', 1, 0),
(81, 'lbInvoiceItem', 30, 1, '2016-12-20 04:11:36', 1, '2016-12-20 04:12:38', 1, 0),
(82, 'lbInvoiceTotal', 14, 1, '2016-12-20 04:11:36', 1, '2016-12-20 08:44:36', 1, 0),
(83, 'lbCustomerContact', 3, 1, '2016-12-20 04:12:00', 1, '2016-12-20 04:12:00', 1, 0),
(84, 'lbTax', 3, 1, '2016-12-20 04:16:11', 1, '2016-12-20 04:16:11', 1, 0),
(85, 'lbTax', 4, 1, '2016-12-20 04:16:34', 1, '2016-12-20 04:16:34', 1, 0),
(86, 'lbInvoice', 15, 1, '2016-12-20 04:16:57', 1, '2016-12-20 04:16:57', 1, 0),
(87, 'lbInvoiceItem', 31, 1, '2016-12-20 04:16:58', 1, '2016-12-20 04:16:58', 1, 0),
(88, 'lbInvoiceItem', 32, 1, '2016-12-20 04:16:58', 1, '2016-12-20 04:16:58', 1, 0),
(89, 'lbInvoiceTotal', 15, 1, '2016-12-20 04:16:58', 1, '2016-12-20 04:16:59', 1, 0),
(90, 'lbQuotation', 1, 1, '2016-12-20 04:17:11', 1, '2016-12-20 04:17:11', 1, 0),
(91, 'lbQuotationItem', 1, 1, '2016-12-20 04:17:11', 1, '2016-12-20 04:17:11', 1, 0),
(92, 'lbQuotationTax', 1, 1, '2016-12-20 04:17:11', 1, '2016-12-20 04:17:11', 1, 0),
(93, 'lbQuotationTotal', 1, 1, '2016-12-20 04:17:11', 1, '2016-12-20 04:17:11', 1, 0),
(94, 'lbQuotation', 2, 1, '2016-12-20 04:24:55', 1, '2016-12-20 04:24:55', 1, 0),
(95, 'lbQuotationItem', 2, 1, '2016-12-20 04:24:55', 1, '2016-12-20 04:24:55', 1, 0),
(96, 'lbQuotationTax', 2, 1, '2016-12-20 04:24:55', 1, '2016-12-20 04:24:55', 1, 0),
(97, 'lbQuotationTotal', 2, 1, '2016-12-20 04:24:55', 1, '2016-12-20 04:24:55', 1, 0),
(102, 'lbCustomer', 9, 1, '2016-12-20 04:40:57', 1, '2016-12-20 04:40:57', 1, 0),
(103, 'lbCustomerAddress', 4, 1, '2016-12-20 04:40:58', 1, '2016-12-20 04:40:58', 1, 0),
(104, 'lbCustomerContact', 4, 1, '2016-12-20 04:40:58', 1, '2016-12-20 04:40:58', 1, 0),
(105, 'lbCustomerAddressContact', 2, 1, '2016-12-20 04:40:58', 1, '2016-12-20 04:40:58', 1, 0),
(106, 'lbInvoice', 17, 1, '2016-12-20 04:41:06', 1, '2016-12-20 08:45:14', 1, 0),
(107, 'lbInvoiceItem', 35, 1, '2016-12-20 04:41:06', 1, '2016-12-20 04:41:58', 1, 0),
(108, 'lbInvoiceItem', 36, 1, '2016-12-20 04:41:06', 1, '2016-12-20 04:42:00', 1, 0),
(109, 'lbInvoiceTotal', 17, 1, '2016-12-20 04:41:06', 1, '2016-12-20 08:45:14', 1, 0),
(110, 'lbInvoice', 18, 1, '2016-12-20 04:42:27', 1, '2016-12-20 11:34:00', 1, 0),
(111, 'lbInvoiceItem', 37, 1, '2016-12-20 04:42:27', 1, '2016-12-20 11:33:57', 1, 0),
(112, 'lbInvoiceItem', 38, 1, '2016-12-20 04:42:28', 1, '2016-12-20 11:33:58', 1, 0),
(113, 'lbInvoiceTotal', 18, 1, '2016-12-20 04:42:28', 1, '2016-12-20 11:33:58', 1, 0),
(114, 'lbQuotation', 3, 1, '2016-12-20 05:48:06', 1, '2016-12-20 05:48:07', 1, 0),
(115, 'lbQuotationItem', 3, 1, '2016-12-20 05:48:07', 1, '2016-12-20 05:48:07', 1, 0),
(116, 'lbQuotationTax', 3, 1, '2016-12-20 05:48:07', 1, '2016-12-20 05:48:07', 1, 0),
(117, 'lbQuotationTotal', 3, 1, '2016-12-20 05:48:07', 1, '2016-12-20 05:48:07', 1, 0),
(118, 'lbInvoice', 19, 1, '2016-12-20 08:40:32', 1, '2016-12-20 08:44:37', 1, 0),
(119, 'lbInvoiceItem', 39, 1, '2016-12-20 08:40:32', 1, '2016-12-20 08:42:19', 1, 0),
(120, 'lbInvoiceItem', 40, 1, '2016-12-20 08:40:32', 1, '2016-12-20 08:42:20', 1, 0),
(121, 'lbInvoiceTotal', 19, 1, '2016-12-20 08:40:33', 1, '2016-12-20 08:44:37', 1, 0),
(122, 'lbPayment', 2, 1, '2016-12-20 08:44:35', 1, '2016-12-20 08:44:35', 1, 0),
(123, 'lbPaymentItem', 2, 1, '2016-12-20 08:44:35', 1, '2016-12-20 08:44:35', 1, 0),
(124, 'lbPaymentItem', 3, 1, '2016-12-20 08:44:36', 1, '2016-12-20 08:44:36', 1, 0),
(125, 'lbPayment', 3, 1, '2016-12-20 08:45:13', 1, '2016-12-20 08:45:13', 1, 0),
(126, 'lbPaymentItem', 4, 1, '2016-12-20 08:45:13', 1, '2016-12-20 08:45:13', 1, 0),
(127, 'lbInvoice', 20, 1, '2016-12-20 08:45:25', 1, '2016-12-20 08:46:53', 1, 0),
(128, 'lbInvoiceItem', 41, 1, '2016-12-20 08:45:25', 1, '2016-12-20 08:46:07', 1, 0),
(129, 'lbInvoiceItem', 42, 1, '2016-12-20 08:45:25', 1, '2016-12-20 08:46:14', 1, 0),
(130, 'lbInvoiceTotal', 20, 1, '2016-12-20 08:45:26', 1, '2016-12-20 08:46:53', 1, 0),
(131, 'lbInvoiceItem', 43, 1, '2016-12-20 08:46:13', 1, '2016-12-20 08:46:14', 1, 0),
(132, 'lbPayment', 4, 1, '2016-12-20 08:46:53', 1, '2016-12-20 08:46:53', 1, 0),
(133, 'lbPaymentItem', 5, 1, '2016-12-20 08:46:53', 1, '2016-12-20 08:46:53', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_customers`
--

CREATE TABLE `lb_customers` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lb_customer_registration` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_tax_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_website_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_is_own_company` tinyint(1) NOT NULL COMMENT 'only allow ONE per subscription'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_customers`
--

INSERT INTO `lb_customers` (`lb_record_primary_key`, `lb_customer_name`, `lb_customer_registration`, `lb_customer_tax_id`, `lb_customer_website_url`, `lb_customer_is_own_company`) VALUES
(6, 'Alibaba', 'Hóa đơn', NULL, 'alibaba.com.vn', 0),
(7, 'Honda', 'Hóa đơn', NULL, 'honda.com', 0),
(8, 'Susuki', 'Hóa đơn', NULL, 'susuki.com', 0),
(9, 'LinxHQ', 'Cung cấp', NULL, 'linxhq.com.vn', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_customer_addresses`
--

CREATE TABLE `lb_customer_addresses` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_customer_id` int(11) NOT NULL,
  `lb_customer_address_line_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lb_customer_address_line_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_postal_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_website_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_phone_1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_phone_2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_fax` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_address_is_active` tinyint(1) NOT NULL,
  `lb_customer_address_is_billing` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_customer_addresses`
--

INSERT INTO `lb_customer_addresses` (`lb_record_primary_key`, `lb_customer_id`, `lb_customer_address_line_1`, `lb_customer_address_line_2`, `lb_customer_address_city`, `lb_customer_address_state`, `lb_customer_address_country`, `lb_customer_address_postal_code`, `lb_customer_address_website_url`, `lb_customer_address_phone_1`, `lb_customer_address_phone_2`, `lb_customer_address_fax`, `lb_customer_address_email`, `lb_customer_address_note`, `lb_customer_address_is_active`, `lb_customer_address_is_billing`) VALUES
(1, 6, '58 Trần Trân', '', 'Hà nội', 'Cầu giấy', 'VN', '12413253', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(2, 7, '58 Trường Chinh', '58 Hàng bồ', 'Hà nội', 'Thanh xuân', 'VN', '312311', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(3, 8, '12 hàng khoai', '', 'hà nội', 'hoàn kiếm', 'VN', '2134324654', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(4, 9, 'Tầng 6 - 58 Trần Thái Tông - Cầu Giấy - Hà Nội', '', 'Hà nội', 'Cầu giấy', 'VN', '12413253', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_customer_address_contacts`
--

CREATE TABLE `lb_customer_address_contacts` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_customer_address_id` int(11) NOT NULL,
  `lb_customer_contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_customer_address_contacts`
--

INSERT INTO `lb_customer_address_contacts` (`lb_record_primary_key`, `lb_customer_address_id`, `lb_customer_contact_id`) VALUES
(1, 3, 2),
(2, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `lb_customer_contacts`
--

CREATE TABLE `lb_customer_contacts` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_customer_id` int(11) DEFAULT NULL,
  `lb_customer_contact_first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lb_customer_contact_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lb_customer_contact_office_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_contact_office_fax` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_contact_mobile` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_contact_email_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_contact_email_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_contact_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_contact_is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_customer_contacts`
--

INSERT INTO `lb_customer_contacts` (`lb_record_primary_key`, `lb_customer_id`, `lb_customer_contact_first_name`, `lb_customer_contact_last_name`, `lb_customer_contact_office_phone`, `lb_customer_contact_office_fax`, `lb_customer_contact_mobile`, `lb_customer_contact_email_1`, `lb_customer_contact_email_2`, `lb_customer_contact_note`, `lb_customer_contact_is_active`) VALUES
(1, 6, 'Tuyen', 'Trna', '', NULL, '034654', 'tuyen@gmail.com', NULL, NULL, 1),
(2, 8, 'thong', 'nguyen', '', NULL, '04654654', 'thong@gmail.com', NULL, NULL, 1),
(3, 7, 'Hai', 'Cao', '', NULL, '097948812', 'hai@gmail.com', NULL, NULL, 1),
(4, 9, 'Messi', 'Leo', '04-333-3333', NULL, '0989999999', 'messi@gmail.com', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_default_note`
--

CREATE TABLE `lb_default_note` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_default_note_quotation` longtext NOT NULL,
  `lb_default_note_invoice` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_default_note`
--

INSERT INTO `lb_default_note` (`lb_record_primary_key`, `lb_default_note_quotation`, `lb_default_note_invoice`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `lb_define_permission`
--

CREATE TABLE `lb_define_permission` (
  `define_permission_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `define_permission_name` varchar(100) NOT NULL,
  `define_description` varchar(255) NOT NULL,
  `define_permission_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_documents`
--

CREATE TABLE `lb_documents` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_document_parent_type` varchar(255) NOT NULL,
  `lb_document_parent_id` int(11) NOT NULL,
  `lb_account_id` int(11) NOT NULL,
  `lb_document_url` varchar(255) NOT NULL,
  `lb_document_name` varchar(255) NOT NULL,
  `lb_document_uploaded_datetime` datetime NOT NULL,
  `lb_document_encoded_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_employee`
--

CREATE TABLE `lb_employee` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lowest_salary` decimal(10,2) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_address` text NOT NULL,
  `employee_birthday` date NOT NULL,
  `employee_phone_1` int(11) NOT NULL,
  `employee_phone_2` int(11) NOT NULL,
  `employee_email_1` varchar(255) NOT NULL,
  `employee_email_2` varchar(255) NOT NULL,
  `employee_code` varchar(255) NOT NULL,
  `employee_tax` varchar(255) NOT NULL,
  `employee_bank` text NOT NULL,
  `employee_note` text NOT NULL,
  `employee_salary` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_employee_benefits`
--

CREATE TABLE `lb_employee_benefits` (
  `lb_record_primary_key` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `benefit_name` varchar(255) NOT NULL,
  `benefit_tax` decimal(10,2) NOT NULL,
  `benefit_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_employee_payment`
--

CREATE TABLE `lb_employee_payment` (
  `lb_record_primary_key` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_paid` decimal(10,2) NOT NULL,
  `payment_oustanding` decimal(10,2) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_note` varchar(255) NOT NULL,
  `payment_created_by` int(11) NOT NULL,
  `payment_for_month` date NOT NULL,
  `payment_month` int(11) NOT NULL,
  `payment_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_employee_salary`
--

CREATE TABLE `lb_employee_salary` (
  `lb_record_primary_key` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_name` varchar(255) NOT NULL,
  `salary_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses`
--

CREATE TABLE `lb_expenses` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_category_id` int(11) NOT NULL,
  `lb_expenses_no` varchar(50) NOT NULL,
  `lb_expenses_amount` decimal(10,2) NOT NULL,
  `lb_expenses_date` date NOT NULL,
  `lb_expenses_recurring_id` int(11) DEFAULT NULL,
  `lb_expenses_bank_account_id` int(11) DEFAULT NULL,
  `lb_expenses_note` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses_customer`
--

CREATE TABLE `lb_expenses_customer` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL,
  `lb_customer_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses_invoice`
--

CREATE TABLE `lb_expenses_invoice` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses_tax`
--

CREATE TABLE `lb_expenses_tax` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL,
  `lb_tax_id` int(11) NOT NULL,
  `lb_expenses_tax_total` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_genera`
--

CREATE TABLE `lb_genera` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_genera_currency_symbol` varchar(100) NOT NULL,
  `lb_thousand_separator` varchar(50) NOT NULL,
  `lb_decimal_symbol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_genera`
--

INSERT INTO `lb_genera` (`lb_record_primary_key`, `lb_genera_currency_symbol`, `lb_thousand_separator`, `lb_decimal_symbol`) VALUES
(1, '$', ',', '.');

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoices`
--

CREATE TABLE `lb_invoices` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_invoice_group` char(60) COLLATE utf8_unicode_ci NOT NULL COMMENT 'INVOICE, QUOTATION',
  `lb_generated_from_quotation_id` int(11) DEFAULT NULL,
  `lb_invoice_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lb_invoice_date` date NOT NULL,
  `lb_invoice_due_date` date DEFAULT NULL,
  `lb_invoice_company_id` int(11) DEFAULT NULL COMMENT 'owner company',
  `lb_invoice_company_address_id` int(11) DEFAULT NULL,
  `lb_invoice_customer_id` int(11) DEFAULT NULL,
  `lb_invoice_customer_address_id` int(11) DEFAULT NULL,
  `lb_invoice_attention_contact_id` int(11) DEFAULT NULL,
  `lb_invoice_subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_invoice_note` longtext COLLATE utf8_unicode_ci,
  `lb_invoice_status_code` char(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_invoice_encode` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_invoice_internal_note` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lb_invoice_term_id` int(11) NOT NULL,
  `lb_invoice_currency` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_invoices`
--

INSERT INTO `lb_invoices` (`lb_record_primary_key`, `lb_invoice_group`, `lb_generated_from_quotation_id`, `lb_invoice_no`, `lb_invoice_date`, `lb_invoice_due_date`, `lb_invoice_company_id`, `lb_invoice_company_address_id`, `lb_invoice_customer_id`, `lb_invoice_customer_address_id`, `lb_invoice_attention_contact_id`, `lb_invoice_subject`, `lb_invoice_note`, `lb_invoice_status_code`, `lb_invoice_encode`, `lb_quotation_id`, `lb_invoice_internal_note`, `lb_invoice_term_id`, `lb_invoice_currency`) VALUES
(5, 'INVOICE', NULL, 'Draft', '2016-12-19', '2016-12-19', NULL, NULL, NULL, NULL, NULL, NULL, '', 'I_DRAFT', 'OVNDNWlZZ1dGejE=', 0, '', 0, 0),
(8, 'INVOICE', NULL, 'Draft', '2016-12-20', '2016-12-20', NULL, NULL, 8, 3, 2, NULL, '', 'I_DRAFT', 'blZNMXlySXhzVzE=', 0, '', 0, 0),
(10, 'INVOICE', NULL, 'Draft', '2016-12-20', '2016-12-29', NULL, NULL, NULL, NULL, NULL, NULL, '', 'I_DRAFT', 'MWlWOGNUb2xiODE=', 0, '', 8, 0),
(11, 'INVOICE', NULL, 'Draft', '2016-12-20', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, '', 'I_DRAFT', 'OU9TM2lpcU51RjE=', 0, '', 0, 0),
(12, 'INVOICE', NULL, 'I-20160000002', '2016-12-20', '2016-12-20', NULL, NULL, 6, 1, 1, 'cafe', '', 'I_PAID', 'QzQ1TXdITTVHTDE=', 0, '', 7, 1),
(13, 'INVOICE', NULL, 'Draft', '2016-12-20', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, '', 'I_DRAFT', 'YmZ1OWQ1TWRLdjE=', 0, '', 0, 0),
(14, 'INVOICE', NULL, 'I-20160000003', '2016-12-20', '2016-12-20', NULL, NULL, 7, 2, 3, 'Coca', '', 'I_PAID', 'ZFhJNDc1bE5yOTE=', 0, '', 7, 1),
(15, 'INVOICE', NULL, 'Draft', '2016-12-20', '2016-12-20', NULL, NULL, NULL, NULL, NULL, NULL, '', 'I_DRAFT', 'Rm1OMWVTYVdRcjE=', 0, '', 0, 0),
(17, 'INVOICE', NULL, 'I-20160000004', '2016-12-20', '2016-12-20', 9, 4, 9, 4, 4, 'ABC Bank', '', 'I_PAID', 'WFhaQ05SRWpaUjE=', 0, '', 7, 1),
(18, 'INVOICE', NULL, 'I-20160000007', '2016-12-20', '2016-12-20', 9, 4, 7, 2, 3, NULL, '', 'I_OPEN', 'YjJZZjhuYmRSbTE=', 0, '', 7, 0),
(19, 'INVOICE', NULL, 'I-20160000005', '2016-12-20', '2016-12-20', 9, 4, 7, 2, 3, 'Excited', '', 'I_PAID', 'NlN5bGhZQTV3bjE=', 0, '', 7, 1),
(20, 'INVOICE', NULL, 'I-20160000006', '2016-12-20', '2016-12-20', 9, 4, 6, 1, 1, 'Baba', '', 'I_PAID', 'Z2E1dnV6SjlFTjE=', 0, '', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoice_items`
--

CREATE TABLE `lb_invoice_items` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL,
  `lb_invoice_item_type` char(60) COLLATE utf8_unicode_ci NOT NULL COMMENT 'LINE_ITEM, DISCOUNT, TAX',
  `lb_invoice_item_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_invoice_item_quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_item_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_item_total` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_invoice_items`
--

INSERT INTO `lb_invoice_items` (`lb_record_primary_key`, `lb_invoice_id`, `lb_invoice_item_type`, `lb_invoice_item_description`, `lb_invoice_item_quantity`, `lb_invoice_item_value`, `lb_invoice_item_total`) VALUES
(10, 5, 'LINE', NULL, '1.00', '0.00', '0.00'),
(11, 5, 'TAX', '1', '1.00', '10.00', '0.00'),
(16, 8, 'LINE', NULL, '1.00', '0.00', '0.00'),
(17, 8, 'TAX', '1', '1.00', '10.00', '0.00'),
(20, 10, 'LINE', NULL, '1.00', '0.00', '0.00'),
(21, 10, 'TAX', '1', '1.00', '10.00', '0.00'),
(22, 11, 'LINE', NULL, '1.00', '0.00', '0.00'),
(23, 11, 'TAX', '1', '1.00', '10.00', '0.00'),
(24, 12, 'LINE', 'admin', '1.00', '10000.00', '10000.00'),
(25, 12, 'TAX', '1', '1.00', '10.00', '990.00'),
(26, 12, 'DISCOUNT', 'Discount', '1.00', '100.00', '100.00'),
(27, 13, 'LINE', NULL, '1.00', '0.00', '0.00'),
(28, 13, 'TAX', '1', '1.00', '10.00', '0.00'),
(29, 14, 'LINE', 'pepsi', '100.00', '10000.00', '1000000.00'),
(30, 14, 'TAX', '1', '1.00', '10.00', '100000.00'),
(31, 15, 'LINE', NULL, '1.00', '0.00', '0.00'),
(32, 15, 'TAX', '1', '1.00', '10.00', '0.00'),
(35, 17, 'LINE', 'Hóa đơn', '100.00', '10000.00', '1000000.00'),
(36, 17, 'TAX', '2', '1.00', '20.00', '200000.00'),
(37, 18, 'LINE', 'fasfa', '1.00', '111110.00', '111110.00'),
(38, 18, 'TAX', '1', '1.00', '10.00', '11111.00'),
(39, 19, 'LINE', 'Excited 2015', '1.00', '2500000.00', '2500000.00'),
(40, 19, 'TAX', '1', '1.00', '10.00', '250000.00'),
(41, 20, 'LINE', 'Baba lớn', '1.00', '10000.00', '10000.00'),
(42, 20, 'TAX', '3', '1.00', '2.00', '200.00'),
(43, 20, 'TAX', '1', '1.00', '10.00', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoice_item_templates`
--

CREATE TABLE `lb_invoice_item_templates` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_item_title` varchar(255) DEFAULT NULL,
  `lb_item_description` longtext NOT NULL,
  `lb_item_unit_price` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoice_totals`
--

CREATE TABLE `lb_invoice_totals` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL,
  `lb_invoice_revision_id` int(11) NOT NULL COMMENT '0 for latest',
  `lb_invoice_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_total_after_discounts` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_total_after_taxes` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_total_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_total_outstanding` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_invoice_totals`
--

INSERT INTO `lb_invoice_totals` (`lb_record_primary_key`, `lb_invoice_id`, `lb_invoice_revision_id`, `lb_invoice_subtotal`, `lb_invoice_total_after_discounts`, `lb_invoice_total_after_taxes`, `lb_invoice_total_paid`, `lb_invoice_total_outstanding`) VALUES
(5, 5, 0, '0.00', '0.00', '0.00', '0.00', '0.00'),
(8, 8, 0, '0.00', '0.00', '0.00', '0.00', '0.00'),
(10, 10, 0, '0.00', '0.00', '0.00', '0.00', '0.00'),
(11, 11, 0, '0.00', '0.00', '0.00', '0.00', '0.00'),
(12, 12, 0, '10000.00', '9900.00', '10890.00', '10890.00', '0.00'),
(13, 13, 0, '0.00', '0.00', '0.00', '0.00', '0.00'),
(14, 14, 0, '1000000.00', '1000000.00', '1100000.00', '1100000.00', '0.00'),
(15, 15, 0, '0.00', '0.00', '0.00', '0.00', '0.00'),
(17, 17, 0, '1000000.00', '1000000.00', '1200000.00', '1200000.00', '0.00'),
(18, 18, 0, '111110.00', '111110.00', '122221.00', '0.00', '122221.00'),
(19, 19, 0, '2500000.00', '2500000.00', '2750000.00', '2750000.00', '0.00'),
(20, 20, 0, '10000.00', '10000.00', '11200.00', '11200.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `lb_language_user`
--

CREATE TABLE `lb_language_user` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_language_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lb_user_id` int(11) NOT NULL,
  `invite_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_language_user`
--

INSERT INTO `lb_language_user` (`lb_record_primary_key`, `lb_language_name`, `lb_user_id`, `invite_id`) VALUES
(1, 'en', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_modules`
--

CREATE TABLE `lb_modules` (
  `lb_record_primary_key` int(11) NOT NULL,
  `module_directory` varchar(100) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `module_text` varchar(100) NOT NULL,
  `modules_description` varchar(255) NOT NULL,
  `module_hidden` int(1) NOT NULL,
  `module_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_modules`
--

INSERT INTO `lb_modules` (`lb_record_primary_key`, `module_directory`, `module_name`, `module_text`, `modules_description`, `module_hidden`, `module_order`) VALUES
(1, 'lbContract', 'Contracts', 'CONTRACTS', '', 1, 1),
(2, 'lbCustomer', 'Customers', 'CUSTOMERS', '', 1, 2),
(3, 'lbExpenses', 'Expenses', 'EXPENSES', '', 1, 3),
(4, 'lbInvoice', 'Invoices', 'INVOCIES', '', 1, 4),
(5, 'lbPayment', 'Payments', 'PAYMENTS', '', 1, 5),
(6, 'lbQuotation', 'Quotations', 'QUOTATIONS', '', 1, 6),
(7, 'lbReport', 'Reports', 'REPORTS', '', 1, 7),
(8, 'lbVendor', 'Vendor', 'VENDOR', '', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `lb_next_ids`
--

CREATE TABLE `lb_next_ids` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_next_invoice_number` int(11) NOT NULL,
  `lb_next_quotation_number` int(11) NOT NULL,
  `lb_next_payment_number` int(11) NOT NULL,
  `lb_next_contract_number` int(11) NOT NULL,
  `lb_next_expenses_number` int(11) NOT NULL,
  `lb_next_po_number` int(11) NOT NULL,
  `lb_next_supplier_invoice_number` int(11) NOT NULL,
  `	lb_next_supplier_payment_number` int(11) NOT NULL,
  `lb_next_supplier_payment_number` int(11) NOT NULL,
  `lb_next_pv_number` int(11) NOT NULL,
  `lb_payment_vendor_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_next_ids`
--

INSERT INTO `lb_next_ids` (`lb_record_primary_key`, `lb_next_invoice_number`, `lb_next_quotation_number`, `lb_next_payment_number`, `lb_next_contract_number`, `lb_next_expenses_number`, `lb_next_po_number`, `lb_next_supplier_invoice_number`, `	lb_next_supplier_payment_number`, `lb_next_supplier_payment_number`, `lb_next_pv_number`, `lb_payment_vendor_number`) VALUES
(1, 8, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment`
--

CREATE TABLE `lb_payment` (
  `lb_record_primary_key` int(11) UNSIGNED NOT NULL,
  `lb_payment_customer_id` int(10) UNSIGNED NOT NULL,
  `lb_payment_no` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_payment_method` int(11) NOT NULL,
  `lb_payment_date` date NOT NULL,
  `lb_payment_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_payment_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_payment`
--

INSERT INTO `lb_payment` (`lb_record_primary_key`, `lb_payment_customer_id`, `lb_payment_no`, `lb_payment_method`, `lb_payment_date`, `lb_payment_notes`, `lb_payment_total`) VALUES
(1, 6, 'R-20160000001', 0, '2016-12-20', NULL, '10890.00'),
(2, 7, 'R-20160000001', 0, '2016-12-20', NULL, '3850000.00'),
(3, 9, 'R-20160000001', 0, '2016-12-20', NULL, '1200000.00'),
(4, 6, 'R-20160000001', 2, '2016-12-20', NULL, '11200.00');

-- --------------------------------------------------------

--
-- Table structure for table `lb_payments`
--

CREATE TABLE `lb_payments` (
  `id` int(11) NOT NULL,
  `txn_id` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `paypal_id` varchar(250) NOT NULL,
  `created_at` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment_item`
--

CREATE TABLE `lb_payment_item` (
  `lb_record_primary_key` int(11) UNSIGNED NOT NULL,
  `lb_payment_id` int(11) UNSIGNED NOT NULL,
  `lb_invoice_id` int(11) UNSIGNED NOT NULL,
  `lb_payment_item_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_payment_item_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_payment_item`
--

INSERT INTO `lb_payment_item` (`lb_record_primary_key`, `lb_payment_id`, `lb_invoice_id`, `lb_payment_item_note`, `lb_payment_item_amount`) VALUES
(1, 1, 12, '', '10890.00'),
(2, 2, 14, '', '1100000.00'),
(3, 2, 19, '', '2750000.00'),
(4, 3, 17, '', '1200000.00'),
(5, 4, 20, '', '11200.00');

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment_vendor`
--

CREATE TABLE `lb_payment_vendor` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_payment_vendor_customer_id` int(11) NOT NULL,
  `lb_payment_vendor_no` varchar(100) NOT NULL,
  `lb_payment_vendor_method` int(11) NOT NULL,
  `lb_payment_vendor_date` date NOT NULL,
  `lb_payment_vendor_notes` varchar(255) NOT NULL,
  `lb_payment_vendor_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment_vendor_invoice`
--

CREATE TABLE `lb_payment_vendor_invoice` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_payment_id` int(11) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL,
  `lb_payment_item_note` varchar(100) NOT NULL,
  `lb_payment_item_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment_voucher`
--

CREATE TABLE `lb_payment_voucher` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_pv_company_id` int(11) NOT NULL,
  `lb_pv_company_address_id` int(11) NOT NULL,
  `lb_payment_voucher_no` varchar(100) NOT NULL,
  `lb_pv_title` varchar(255) NOT NULL,
  `lb_pv_description` varchar(255) NOT NULL,
  `lb_pv_create_by` int(11) NOT NULL,
  `lb_pv_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_pv_expenses`
--

CREATE TABLE `lb_pv_expenses` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_payment_voucher_id` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation`
--

CREATE TABLE `lb_quotation` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_company_id` int(11) DEFAULT NULL,
  `lb_company_address_id` int(11) DEFAULT NULL,
  `lb_quotation_customer_id` int(11) DEFAULT NULL,
  `lb_quotation_customer_address_id` int(11) DEFAULT NULL,
  `lb_quotation_attention_id` int(11) DEFAULT NULL,
  `lb_quotation_no` varchar(50) DEFAULT NULL,
  `lb_quotation_date` date DEFAULT NULL,
  `lb_quotation_due_date` date DEFAULT NULL,
  `lb_quotation_subject` varchar(255) DEFAULT NULL,
  `lb_quotation_note` longtext,
  `lb_quotation_status` char(20) DEFAULT NULL,
  `lb_quotation_term` int(11) NOT NULL,
  `lb_quotation_currency` int(11) NOT NULL,
  `lb_quotation_encode` varchar(255) DEFAULT NULL,
  `lb_quotation_internal_note` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_quotation`
--

INSERT INTO `lb_quotation` (`lb_record_primary_key`, `lb_company_id`, `lb_company_address_id`, `lb_quotation_customer_id`, `lb_quotation_customer_address_id`, `lb_quotation_attention_id`, `lb_quotation_no`, `lb_quotation_date`, `lb_quotation_due_date`, `lb_quotation_subject`, `lb_quotation_note`, `lb_quotation_status`, `lb_quotation_term`, `lb_quotation_currency`, `lb_quotation_encode`, `lb_quotation_internal_note`) VALUES
(1, 5, NULL, NULL, NULL, NULL, 'Draft', '2016-12-20', '2016-12-20', NULL, '', 'Q-DRAFT', 0, 0, 'aXVKdlA5bmEwZzE=', ''),
(2, 5, NULL, NULL, NULL, NULL, 'Draft', '2016-12-20', '2016-12-20', NULL, '', 'Q-DRAFT', 0, 0, 'OHh6TlNGTjdudTE=', ''),
(3, 9, 4, NULL, NULL, NULL, 'Draft', '2016-12-20', '2016-12-20', NULL, '', 'Q-DRAFT', 0, 0, 'YkdONk1jeFVnejE=', '');

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation_discount`
--

CREATE TABLE `lb_quotation_discount` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_quotation_discount_description` varchar(255) NOT NULL,
  `lb_quotation_discount_value` decimal(10,2) NOT NULL,
  `lb_quotation_discount_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation_item`
--

CREATE TABLE `lb_quotation_item` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_quotation_item_description` text NOT NULL,
  `lb_quotation_item_quantity` decimal(10,2) NOT NULL,
  `lb_quotation_item_price` decimal(10,2) NOT NULL,
  `lb_quotation_item_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_quotation_item`
--

INSERT INTO `lb_quotation_item` (`lb_record_primary_key`, `lb_quotation_id`, `lb_quotation_item_description`, `lb_quotation_item_quantity`, `lb_quotation_item_price`, `lb_quotation_item_total`) VALUES
(1, 1, '', '1.00', '0.00', '0.00'),
(2, 2, '', '1.00', '0.00', '0.00'),
(3, 3, '', '1.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation_tax`
--

CREATE TABLE `lb_quotation_tax` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_quotation_tax_id` int(11) NOT NULL,
  `lb_quotation_tax_value` decimal(10,2) NOT NULL,
  `lb_quotation_tax_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_quotation_tax`
--

INSERT INTO `lb_quotation_tax` (`lb_record_primary_key`, `lb_quotation_id`, `lb_quotation_tax_id`, `lb_quotation_tax_value`, `lb_quotation_tax_total`) VALUES
(1, 1, 1, '10.00', '0.00'),
(2, 2, 1, '10.00', '0.00'),
(3, 3, 1, '10.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation_total`
--

CREATE TABLE `lb_quotation_total` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_quotation_subtotal` decimal(10,2) NOT NULL,
  `lb_quotation_total_after_discount` decimal(10,2) NOT NULL,
  `lb_quotation_total_after_tax` decimal(10,2) NOT NULL,
  `lb_quotation_total_after_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_quotation_total`
--

INSERT INTO `lb_quotation_total` (`lb_record_primary_key`, `lb_quotation_id`, `lb_quotation_subtotal`, `lb_quotation_total_after_discount`, `lb_quotation_total_after_tax`, `lb_quotation_total_after_total`) VALUES
(1, 1, '0.00', '0.00', '0.00', '0.00'),
(2, 2, '0.00', '0.00', '0.00', '0.00'),
(3, 3, '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `lb_roles`
--

CREATE TABLE `lb_roles` (
  `lb_record_primary_key` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_roles_basic_permission`
--

CREATE TABLE `lb_roles_basic_permission` (
  `role_basic_permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `basic_permission_id` int(11) NOT NULL,
  `basic_permission_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_roles_define_permission`
--

CREATE TABLE `lb_roles_define_permission` (
  `role_define_permission_id` int(11) NOT NULL,
  `define_permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `define_permission_status` int(1) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_subscription`
--

CREATE TABLE `lb_subscription` (
  `subscription_id` int(11) NOT NULL,
  `subscription_name` varchar(255) NOT NULL,
  `subscription_cycle` int(11) NOT NULL,
  `subscription_value` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_accounts`
--

CREATE TABLE `lb_sys_accounts` (
  `account_id` int(11) NOT NULL,
  `account_email` char(255) NOT NULL,
  `account_password` char(255) NOT NULL,
  `account_created_date` datetime NOT NULL,
  `account_timezone` varchar(255) DEFAULT NULL,
  `account_language` varchar(255) DEFAULT NULL,
  `account_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_sys_accounts`
--

INSERT INTO `lb_sys_accounts` (`account_id`, `account_email`, `account_password`, `account_created_date`, `account_timezone`, `account_language`, `account_status`) VALUES
(1, 'mr.tran1511@gmail.com', '$2a$13$k/0RpqOH0UJGJm1sHgw6xuVcmgzU.02QRPsO.OgSarPOaFynekjry', '2016-12-19 08:50:33', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_invitations`
--

CREATE TABLE `lb_sys_account_invitations` (
  `account_invitation_id` int(11) NOT NULL,
  `account_invitation_master_id` int(11) NOT NULL,
  `account_invitation_to_email` char(255) NOT NULL,
  `account_invitation_date` datetime NOT NULL,
  `account_invitation_status` tinyint(4) NOT NULL,
  `account_invitation_rand_key` char(100) NOT NULL,
  `account_invitation_project` int(11) DEFAULT NULL,
  `account_invitation_type` tinyint(1) NOT NULL COMMENT '0: team member, 1: customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_password_reset`
--

CREATE TABLE `lb_sys_account_password_reset` (
  `account_password_reset_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_password_reset_rand_key` char(100) CHARACTER SET utf8 NOT NULL,
  `account_password_reset_rand_key_expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_profiles`
--

CREATE TABLE `lb_sys_account_profiles` (
  `account_profile_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_profile_surname` varchar(255) NOT NULL,
  `account_profile_given_name` varchar(255) NOT NULL,
  `account_profile_preferred_display_name` varchar(255) NOT NULL,
  `account_profile_company_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_sys_account_profiles`
--

INSERT INTO `lb_sys_account_profiles` (`account_profile_id`, `account_id`, `account_profile_surname`, `account_profile_given_name`, `account_profile_preferred_display_name`, `account_profile_company_name`) VALUES
(1, 1, '', 'Admin', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_subscriptions`
--

CREATE TABLE `lb_sys_account_subscriptions` (
  `account_subscription_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `subscription_name` varchar(255) NOT NULL,
  `account_subscription_package_id` tinyint(3) NOT NULL,
  `account_subscription_start_date` datetime NOT NULL,
  `account_subscription_end_date` datetime DEFAULT NULL,
  `account_subscription_status_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_sys_account_subscriptions`
--

INSERT INTO `lb_sys_account_subscriptions` (`account_subscription_id`, `account_id`, `subscription_name`, `account_subscription_package_id`, `account_subscription_start_date`, `account_subscription_end_date`, `account_subscription_status_id`) VALUES
(1, 1, 'My Company', 0, '2016-12-19 08:50:33', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_team_members`
--

CREATE TABLE `lb_sys_account_team_members` (
  `account_team_member_id` int(11) NOT NULL,
  `member_account_id` int(11) NOT NULL,
  `account_subscription_id` int(11) NOT NULL,
  `master_account_id` int(11) NOT NULL,
  `is_customer` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL COMMENT '-1 deactivated; 1 active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_lists`
--

CREATE TABLE `lb_sys_lists` (
  `system_list_item_id` int(11) NOT NULL,
  `system_list_name` varchar(255) NOT NULL,
  `system_list_code` char(100) NOT NULL,
  `system_list_item_code` char(50) NOT NULL,
  `system_list_item_name` varchar(255) NOT NULL,
  `system_list_parent_item_id` int(11) DEFAULT NULL,
  `system_list_item_order` int(4) DEFAULT NULL,
  `system_list_item_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_subscription_packages`
--

CREATE TABLE `lb_sys_subscription_packages` (
  `subscription_package_id` int(11) NOT NULL,
  `subscription_package_name` varchar(255) NOT NULL,
  `subscription_package_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_translate`
--

CREATE TABLE `lb_sys_translate` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_tranlate_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_translate_vn` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_sys_translate`
--

INSERT INTO `lb_sys_translate` (`lb_record_primary_key`, `lb_tranlate_en`, `lb_translate_vn`) VALUES
(4, 'Home', 'Trang chủ'),
(5, 'About', 'Giới thiệu'),
(6, 'Contact', 'Liên hệ'),
(7, 'Login', 'Đăng nhập'),
(8, 'Logout', 'Đăng xuất'),
(9, 'Customers', 'Khách hàng'),
(10, 'Invoices', 'Hóa đơn'),
(11, 'Contracts', 'Hợp đồng'),
(12, 'Payments', 'Thanh toán'),
(13, 'Expenses', 'Chi phí'),
(14, 'Configuration', 'Cấu hình'),
(16, 'My Account', 'Thông tin cá nhân'),
(17, 'My Team', 'Thôn tin nhóm'),
(18, 'Name', 'Tên'),
(19, 'Tax Code', 'Mã số thuế'),
(20, 'Own Company', 'Địa chỉ công ty'),
(21, 'New Customer', 'Thêm khách hàng'),
(22, 'Fields with * are required', 'Các trường có dấu * là bắc buộc'),
(23, 'Address', 'Địa chỉ'),
(24, 'Optional', 'Không bắc buộc'),
(25, 'Contact Person', 'Người liên hệ'),
(26, 'Customer', 'Khách hàng'),
(27, 'Address Line', 'Địa chỉ'),
(29, 'City', 'Thành phố'),
(30, 'Country', 'Nước'),
(31, 'Postal Code', 'Mã bưu chính'),
(32, 'State/Province', 'Bang/khu vực'),
(33, 'Phone', 'Số điện thoại'),
(34, 'Note', 'Ghi chú'),
(35, 'Is Active', 'Đang hoặt động'),
(36, 'Billing Address', 'Địa chỉ thanh toán'),
(37, 'Translate', 'Ngôn ngữ'),
(38, 'List', 'Danh sách'),
(39, 'Invoice Number', 'Số hóa đơn'),
(40, 'Default Note', 'Ghi chú mặt định'),
(41, 'Tax', 'Thuế'),
(42, 'New Address', 'Thêm địa chỉ'),
(43, 'New Contact', 'Thêm liên hệ'),
(44, 'New Invoice', 'Thêm hóa đơn'),
(45, 'Addresses', 'Địa chỉ'),
(46, 'Contacts', 'Liên hệ'),
(47, 'Paid', 'Đã thanh toán'),
(48, 'Due', 'Còn nợ'),
(49, 'Amount', 'Tổng tiền'),
(50, 'Invoice No', 'Mã hóa đơn'),
(51, 'Date', 'Thời gian'),
(52, 'New', 'Thêm'),
(53, 'Back', 'Quay lại'),
(54, 'Detail information', 'Thông tin chi tiết'),
(55, 'Delete', 'Xóa'),
(56, 'First Name', 'Tên'),
(57, 'Last Name', 'Họ'),
(58, 'Office Phone', 'Điện thoại văn phòng'),
(61, 'Mobile', 'Điện thoại di động'),
(62, 'All Time Revenue', 'Tổng doanh thu'),
(63, 'Year To Date Revenue', 'Doanh thu trong năm'),
(64, 'Cash Collected', 'Tổng tiền đã thu'),
(65, 'Outstanding', 'Tổng tiền chưa thu'),
(66, 'Status', 'Trạng thái'),
(67, 'Created By', 'Người tạo'),
(68, 'Due Date', 'Ngày hết hạn'),
(69, 'New Payment', 'Thêm thanh toán'),
(70, 'see more invoices', 'Xem thêm các hóa đơn'),
(71, 'see more quotations', 'Xem thêm các báo giá'),
(72, 'New Quotation', 'Thêm báo giá'),
(73, 'Outstanding Quotation', 'Báo giá chưa thu'),
(75, 'Password', 'Mật khẩu'),
(76, 'Outstanding Invoice', 'Hóa đơn chưa thu'),
(77, 'Quotation No', 'Mã báo giá'),
(78, 'Payment Amount', 'Số thiền thanh toán'),
(79, 'Payment Date', 'Ngày thanh toán'),
(80, 'Payment Method', 'Phương thức thanh toán'),
(81, 'Receipt No', 'Mã biên lai'),
(82, 'Payment', 'Thanh toán'),
(83, 'Amount Due', 'Số tiền nợ'),
(84, 'Notes', 'Nghi chú'),
(85, 'View Payment', 'Xem thanh toán'),
(86, 'Customer name', 'Tên khách hàng'),
(87, 'From', ' Từ ngày'),
(88, 'To', 'Đến'),
(89, 'No results found', 'Không có kết quả nào được tìm thấy'),
(90, 'Amount Paid', 'Số tiền đã trả'),
(91, 'Method', 'Hình thức'),
(92, 'Total Paid', 'Tổng tiền đã trả'),
(93, 'Total Balance', 'Tổng tiền còn nợ'),
(94, 'Total Due', 'Tổng tiền còn nợ'),
(95, 'Total', 'Tổng tiền'),
(96, 'Category', 'Loại'),
(97, 'Expenses No', 'Mã Chi phí'),
(98, 'Recurring', 'Định kỳ'),
(99, 'Bank Account', 'Tài khoản ngân hàng'),
(100, 'New Expenses', 'Thêm chi phí'),
(101, 'Search', 'Tìm kiếm'),
(102, 'Document', 'Tài liệu'),
(104, 'Taxes', 'Thuế'),
(105, 'Contract No', 'Mã hợp đồng'),
(106, 'Renew', 'Gia hạn'),
(107, 'End Date', 'Ngày kết thúc'),
(108, 'Start Date', 'Ngày bắt đầu'),
(109, 'Contract Type', 'Loại hợp đồng'),
(110, 'see more contracts', 'Xem thêm hợp đồng'),
(111, 'New Contract', 'Thêm hợp đồng'),
(112, 'Outstanding Payments', 'Chưa thanh toán hết'),
(113, 'Expiring Contracts', 'Hợp đồng hết hạn'),
(114, 'Active Contracts', 'Hợp đồng hợp lệ'),
(115, 'Renew Contract', 'Gia hạn hợp đồng'),
(116, 'Cancel Contract', 'Hủy hợp đồng'),
(117, 'End Contract', 'Kết thúc hợp đồng'),
(118, 'Contract Notes', 'Ghi chú'),
(119, 'Contract Amount', 'Số tiền hợp đồng'),
(120, 'Detail', 'Chi tiết'),
(121, 'Related Invoice', 'Hóa đơn liên quan'),
(122, 'Due Date', 'Ngày hết hạn'),
(123, 'Internal Note', 'Ghi chú nội bộ'),
(124, 'Note', 'Ghi chú'),
(125, 'Invoice Date', 'Ngày tạo'),
(126, 'Item', 'Sản phẩm'),
(127, 'Add item', 'Thêm sản phẩm'),
(128, 'Quantity', 'Số lượng'),
(129, 'Unit Price', 'Đơn giá'),
(130, 'Add discount', 'Thêm giảm giá'),
(131, 'Save', 'Lưu'),
(132, 'Add tax', 'Thêm thuế'),
(133, 'Quotation Date', 'Ngày tạo'),
(134, 'Quotation', 'Báo giá'),
(135, 'Enter', 'Nhập'),
(136, 'Membship', 'Hội viên');

-- --------------------------------------------------------

--
-- Table structure for table `lb_taxes`
--

CREATE TABLE `lb_taxes` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_tax_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `lb_tax_value` decimal(5,2) NOT NULL COMMENT 'percentage:7 for 7%',
  `lb_tax_is_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_taxes`
--

INSERT INTO `lb_taxes` (`lb_record_primary_key`, `lb_tax_name`, `lb_tax_value`, `lb_tax_is_default`) VALUES
(1, 'Gtgt', '10.00', 1),
(2, 'Thuế nhập khẩu', '20.00', 0),
(3, 'Thuế bải vệ môi trường', '2.00', 0),
(4, 'Thuế tiêu thụ đặc biệt', '7.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_credit_card`
--

CREATE TABLE `lb_user_credit_card` (
  `user_credit_card_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `credit_card_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_list`
--

CREATE TABLE `lb_user_list` (
  `system_list_item_id` int(11) NOT NULL,
  `system_list_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `system_list_code` varchar(100) CHARACTER SET utf8 NOT NULL,
  `system_list_item_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `system_list_item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `system_list_parent_item_id` int(11) NOT NULL,
  `system_list_item_order` int(4) NOT NULL,
  `system_list_item_active` tinyint(1) NOT NULL,
  `system_list_item_day` int(11) NOT NULL,
  `system_list_item_month` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_user_list`
--

INSERT INTO `lb_user_list` (`system_list_item_id`, `system_list_name`, `system_list_code`, `system_list_item_code`, `system_list_item_name`, `system_list_parent_item_id`, `system_list_item_order`, `system_list_item_active`, `system_list_item_day`, `system_list_item_month`) VALUES
(1, '', 'expenses_category', '', '', 0, 0, 1, 0, 0),
(2, '', 'recurring', '', '', 0, 0, 1, 0, 0),
(6, '', 'financial_year', 'financial_year_Financial Year', 'Financial Year', 0, 0, 1, 21, 12),
(7, '', 'term', 'term_Immediate', 'Immediate', 0, 0, 1, 0, 0),
(8, '', 'term', 'term_7 days', '7 days', 0, 0, 1, 0, 0),
(9, '', 'term', 'term_14 days', '14 days', 0, 0, 1, 0, 0),
(10, '', 'term', 'term_30 days', '30 days', 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_payment`
--

CREATE TABLE `lb_user_payment` (
  `user_payment_id` int(11) NOT NULL,
  `user_subscription_id` int(11) NOT NULL,
  `date_payment` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_subscription`
--

CREATE TABLE `lb_user_subscription` (
  `user_subscription_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `date_from` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor`
--

CREATE TABLE `lb_vendor` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_company_id` int(11) NOT NULL,
  `lb_vendor_company_address_id` int(11) NOT NULL,
  `lb_vendor_supplier_id` int(11) NOT NULL,
  `lb_vendor_supplier_address` int(11) NOT NULL,
  `lb_vendor_supplier_attention_id` int(11) NOT NULL,
  `lb_vendor_no` varchar(100) NOT NULL,
  `lb_vendor_category` varchar(255) NOT NULL,
  `lb_vendor_date` date NOT NULL,
  `lb_vendor_due_date` date NOT NULL,
  `lb_vendor_notes` longtext NOT NULL,
  `lb_vendor_subject` longtext,
  `lb_vendor_status` varchar(50) NOT NULL,
  `lb_vendor_encode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_discount`
--

CREATE TABLE `lb_vendor_discount` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_type` varchar(100) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL,
  `lb_vendor_description` varchar(255) NOT NULL,
  `lb_vendor_value` decimal(10,2) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_invoice`
--

CREATE TABLE `lb_vendor_invoice` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_vd_invoice_company_id` int(11) NOT NULL,
  `lb_vd_invoice_company_address_id` int(11) NOT NULL,
  `lb_vd_invoice_supplier_id` int(11) NOT NULL,
  `lb_vd_invoice_supplier_address_id` int(11) NOT NULL,
  `lb_vd_invoice_supplier_attention_id` int(11) NOT NULL,
  `lb_vd_invoice_no` varchar(100) DEFAULT NULL,
  `lb_vd_invoice_category` int(11) NOT NULL,
  `lb_vd_invoice_date` date DEFAULT NULL,
  `lb_vd_invoice_due_date` date NOT NULL,
  `lb_vd_invoice_notes` longtext,
  `lb_vd_invoice_subject` longtext,
  `lb_vd_invoice_status` varchar(50) NOT NULL,
  `lb_vd_invoice_encode` varchar(255) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_item`
--

CREATE TABLE `lb_vendor_item` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_type` varchar(100) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL,
  `lb_vendor_item_description` longtext NOT NULL,
  `lb_vendor_item_price` decimal(10,2) NOT NULL,
  `lb_vendor_item_quantity` decimal(10,2) NOT NULL,
  `lb_vendor_item_amount` decimal(10,2) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_tax`
--

CREATE TABLE `lb_vendor_tax` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL,
  `lb_vendor_tax_id` int(11) NOT NULL,
  `lb_vendor_tax_value` decimal(10,2) NOT NULL,
  `lb_vendor_tax_total` decimal(10,2) NOT NULL,
  `lb_vendor_type` varchar(100) NOT NULL,
  `lb_tax_name` varchar(100) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_total`
--

CREATE TABLE `lb_vendor_total` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL,
  `lb_vendor_type` varchar(100) NOT NULL,
  `lb_vendor_subtotal` decimal(10,2) NOT NULL,
  `lb_vendor_total_last_discount` decimal(10,2) NOT NULL,
  `lb_vendor_last_tax` decimal(10,2) NOT NULL,
  `lb_vendor_last_paid` decimal(10,2) NOT NULL,
  `lb_vendor_last_outstanding` decimal(10,2) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `process_checklist`
--

CREATE TABLE `process_checklist` (
  `pc_id` int(11) NOT NULL,
  `subcription_id` int(11) NOT NULL,
  `pc_name` varchar(100) NOT NULL,
  `pc_created_by` int(11) NOT NULL,
  `pc_created_date` date NOT NULL,
  `pc_last_update_by` int(11) NOT NULL,
  `pc_last_update` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `process_checklist_default`
--

CREATE TABLE `process_checklist_default` (
  `pcdi_id` int(11) NOT NULL,
  `pc_id` int(11) NOT NULL,
  `pcdi_name` varchar(255) NOT NULL,
  `pcdi_order` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `process_checklist_item_rel`
--

CREATE TABLE `process_checklist_item_rel` (
  `pcir_id` int(11) NOT NULL,
  `pc_id` int(11) NOT NULL,
  `pcir_name` varchar(255) NOT NULL,
  `pcir_order` int(11) NOT NULL,
  `pcir_entity_type` varchar(100) NOT NULL,
  `pcir_entity_id` int(11) NOT NULL,
  `pcir_status` int(1) NOT NULL,
  `pcir_status_update_by` int(11) NOT NULL,
  `pcir_status_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yiisession`
--

CREATE TABLE `yiisession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `yiisession`
--

INSERT INTO `yiisession` (`id`, `expire`, `data`) VALUES
('7iav1issg8egetjaug56lgeud4', 1504079760, ''),
('8s3f2g105nn084v23rdlg26g50', 1504149586, ''),
('as3kq8tmjiu78ro8d71a9chdb7', 1504143233, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lb_account_basic_permission`
--
ALTER TABLE `lb_account_basic_permission`
  ADD PRIMARY KEY (`account_basic_permission_id`);

--
-- Indexes for table `lb_account_define_permission`
--
ALTER TABLE `lb_account_define_permission`
  ADD PRIMARY KEY (`account_define_permission_id`);

--
-- Indexes for table `lb_account_roles`
--
ALTER TABLE `lb_account_roles`
  ADD PRIMARY KEY (`account_role_id`);

--
-- Indexes for table `lb_bank_account`
--
ALTER TABLE `lb_bank_account`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_basic_permission`
--
ALTER TABLE `lb_basic_permission`
  ADD PRIMARY KEY (`basic_permission_id`);

--
-- Indexes for table `lb_comment`
--
ALTER TABLE `lb_comment`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_contracts`
--
ALTER TABLE `lb_contracts`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_contract_document`
--
ALTER TABLE `lb_contract_document`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_contract_invoice`
--
ALTER TABLE `lb_contract_invoice`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_core_entities`
--
ALTER TABLE `lb_core_entities`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_customers`
--
ALTER TABLE `lb_customers`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_customer_addresses`
--
ALTER TABLE `lb_customer_addresses`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_customer_address_contacts`
--
ALTER TABLE `lb_customer_address_contacts`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_customer_contacts`
--
ALTER TABLE `lb_customer_contacts`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_default_note`
--
ALTER TABLE `lb_default_note`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_define_permission`
--
ALTER TABLE `lb_define_permission`
  ADD PRIMARY KEY (`define_permission_id`);

--
-- Indexes for table `lb_documents`
--
ALTER TABLE `lb_documents`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_employee`
--
ALTER TABLE `lb_employee`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_employee_benefits`
--
ALTER TABLE `lb_employee_benefits`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_employee_payment`
--
ALTER TABLE `lb_employee_payment`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_employee_salary`
--
ALTER TABLE `lb_employee_salary`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_expenses`
--
ALTER TABLE `lb_expenses`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_expenses_customer`
--
ALTER TABLE `lb_expenses_customer`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_expenses_invoice`
--
ALTER TABLE `lb_expenses_invoice`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_expenses_tax`
--
ALTER TABLE `lb_expenses_tax`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_genera`
--
ALTER TABLE `lb_genera`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_invoices`
--
ALTER TABLE `lb_invoices`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_invoice_items`
--
ALTER TABLE `lb_invoice_items`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_invoice_item_templates`
--
ALTER TABLE `lb_invoice_item_templates`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_invoice_totals`
--
ALTER TABLE `lb_invoice_totals`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_language_user`
--
ALTER TABLE `lb_language_user`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_modules`
--
ALTER TABLE `lb_modules`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_next_ids`
--
ALTER TABLE `lb_next_ids`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_payment`
--
ALTER TABLE `lb_payment`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_payments`
--
ALTER TABLE `lb_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lb_payment_item`
--
ALTER TABLE `lb_payment_item`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_payment_vendor`
--
ALTER TABLE `lb_payment_vendor`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_payment_vendor_invoice`
--
ALTER TABLE `lb_payment_vendor_invoice`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_payment_voucher`
--
ALTER TABLE `lb_payment_voucher`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_pv_expenses`
--
ALTER TABLE `lb_pv_expenses`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_quotation`
--
ALTER TABLE `lb_quotation`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_quotation_discount`
--
ALTER TABLE `lb_quotation_discount`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_quotation_item`
--
ALTER TABLE `lb_quotation_item`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_quotation_tax`
--
ALTER TABLE `lb_quotation_tax`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_quotation_total`
--
ALTER TABLE `lb_quotation_total`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_roles`
--
ALTER TABLE `lb_roles`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_roles_basic_permission`
--
ALTER TABLE `lb_roles_basic_permission`
  ADD PRIMARY KEY (`role_basic_permission_id`);

--
-- Indexes for table `lb_roles_define_permission`
--
ALTER TABLE `lb_roles_define_permission`
  ADD PRIMARY KEY (`role_define_permission_id`);

--
-- Indexes for table `lb_subscription`
--
ALTER TABLE `lb_subscription`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `lb_sys_accounts`
--
ALTER TABLE `lb_sys_accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `lb_sys_account_invitations`
--
ALTER TABLE `lb_sys_account_invitations`
  ADD PRIMARY KEY (`account_invitation_id`);

--
-- Indexes for table `lb_sys_account_password_reset`
--
ALTER TABLE `lb_sys_account_password_reset`
  ADD PRIMARY KEY (`account_password_reset_id`);

--
-- Indexes for table `lb_sys_account_profiles`
--
ALTER TABLE `lb_sys_account_profiles`
  ADD PRIMARY KEY (`account_profile_id`),
  ADD UNIQUE KEY `account_id` (`account_id`);

--
-- Indexes for table `lb_sys_account_subscriptions`
--
ALTER TABLE `lb_sys_account_subscriptions`
  ADD PRIMARY KEY (`account_subscription_id`);

--
-- Indexes for table `lb_sys_account_team_members`
--
ALTER TABLE `lb_sys_account_team_members`
  ADD PRIMARY KEY (`account_team_member_id`);

--
-- Indexes for table `lb_sys_lists`
--
ALTER TABLE `lb_sys_lists`
  ADD PRIMARY KEY (`system_list_item_id`),
  ADD UNIQUE KEY `system_list_item_code` (`system_list_item_code`);

--
-- Indexes for table `lb_sys_subscription_packages`
--
ALTER TABLE `lb_sys_subscription_packages`
  ADD PRIMARY KEY (`subscription_package_id`);

--
-- Indexes for table `lb_sys_translate`
--
ALTER TABLE `lb_sys_translate`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_taxes`
--
ALTER TABLE `lb_taxes`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_user_credit_card`
--
ALTER TABLE `lb_user_credit_card`
  ADD PRIMARY KEY (`user_credit_card_id`);

--
-- Indexes for table `lb_user_list`
--
ALTER TABLE `lb_user_list`
  ADD PRIMARY KEY (`system_list_item_id`);

--
-- Indexes for table `lb_user_payment`
--
ALTER TABLE `lb_user_payment`
  ADD PRIMARY KEY (`user_payment_id`);

--
-- Indexes for table `lb_user_subscription`
--
ALTER TABLE `lb_user_subscription`
  ADD PRIMARY KEY (`user_subscription_id`);

--
-- Indexes for table `lb_vendor`
--
ALTER TABLE `lb_vendor`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_vendor_discount`
--
ALTER TABLE `lb_vendor_discount`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_vendor_invoice`
--
ALTER TABLE `lb_vendor_invoice`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_vendor_item`
--
ALTER TABLE `lb_vendor_item`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_vendor_tax`
--
ALTER TABLE `lb_vendor_tax`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_vendor_total`
--
ALTER TABLE `lb_vendor_total`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `process_checklist`
--
ALTER TABLE `process_checklist`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `process_checklist_default`
--
ALTER TABLE `process_checklist_default`
  ADD PRIMARY KEY (`pcdi_id`);

--
-- Indexes for table `process_checklist_item_rel`
--
ALTER TABLE `process_checklist_item_rel`
  ADD PRIMARY KEY (`pcir_id`);

--
-- Indexes for table `yiisession`
--
ALTER TABLE `yiisession`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lb_account_basic_permission`
--
ALTER TABLE `lb_account_basic_permission`
  MODIFY `account_basic_permission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_account_define_permission`
--
ALTER TABLE `lb_account_define_permission`
  MODIFY `account_define_permission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_account_roles`
--
ALTER TABLE `lb_account_roles`
  MODIFY `account_role_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_bank_account`
--
ALTER TABLE `lb_bank_account`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_basic_permission`
--
ALTER TABLE `lb_basic_permission`
  MODIFY `basic_permission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_comment`
--
ALTER TABLE `lb_comment`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_contracts`
--
ALTER TABLE `lb_contracts`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_contract_document`
--
ALTER TABLE `lb_contract_document`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_contract_invoice`
--
ALTER TABLE `lb_contract_invoice`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_core_entities`
--
ALTER TABLE `lb_core_entities`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT for table `lb_customers`
--
ALTER TABLE `lb_customers`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `lb_customer_addresses`
--
ALTER TABLE `lb_customer_addresses`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lb_customer_address_contacts`
--
ALTER TABLE `lb_customer_address_contacts`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lb_customer_contacts`
--
ALTER TABLE `lb_customer_contacts`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lb_default_note`
--
ALTER TABLE `lb_default_note`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lb_define_permission`
--
ALTER TABLE `lb_define_permission`
  MODIFY `define_permission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_documents`
--
ALTER TABLE `lb_documents`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_employee`
--
ALTER TABLE `lb_employee`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_employee_benefits`
--
ALTER TABLE `lb_employee_benefits`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_employee_payment`
--
ALTER TABLE `lb_employee_payment`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_employee_salary`
--
ALTER TABLE `lb_employee_salary`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_expenses`
--
ALTER TABLE `lb_expenses`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_expenses_customer`
--
ALTER TABLE `lb_expenses_customer`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_expenses_invoice`
--
ALTER TABLE `lb_expenses_invoice`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_expenses_tax`
--
ALTER TABLE `lb_expenses_tax`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_genera`
--
ALTER TABLE `lb_genera`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lb_invoices`
--
ALTER TABLE `lb_invoices`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `lb_invoice_items`
--
ALTER TABLE `lb_invoice_items`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `lb_invoice_item_templates`
--
ALTER TABLE `lb_invoice_item_templates`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_invoice_totals`
--
ALTER TABLE `lb_invoice_totals`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `lb_language_user`
--
ALTER TABLE `lb_language_user`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lb_modules`
--
ALTER TABLE `lb_modules`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `lb_next_ids`
--
ALTER TABLE `lb_next_ids`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lb_payment`
--
ALTER TABLE `lb_payment`
  MODIFY `lb_record_primary_key` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lb_payments`
--
ALTER TABLE `lb_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_payment_item`
--
ALTER TABLE `lb_payment_item`
  MODIFY `lb_record_primary_key` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `lb_payment_vendor`
--
ALTER TABLE `lb_payment_vendor`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_payment_vendor_invoice`
--
ALTER TABLE `lb_payment_vendor_invoice`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_payment_voucher`
--
ALTER TABLE `lb_payment_voucher`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_pv_expenses`
--
ALTER TABLE `lb_pv_expenses`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_quotation`
--
ALTER TABLE `lb_quotation`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lb_quotation_discount`
--
ALTER TABLE `lb_quotation_discount`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_quotation_item`
--
ALTER TABLE `lb_quotation_item`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lb_quotation_tax`
--
ALTER TABLE `lb_quotation_tax`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lb_quotation_total`
--
ALTER TABLE `lb_quotation_total`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lb_roles`
--
ALTER TABLE `lb_roles`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_roles_basic_permission`
--
ALTER TABLE `lb_roles_basic_permission`
  MODIFY `role_basic_permission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_roles_define_permission`
--
ALTER TABLE `lb_roles_define_permission`
  MODIFY `role_define_permission_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_subscription`
--
ALTER TABLE `lb_subscription`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_sys_accounts`
--
ALTER TABLE `lb_sys_accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lb_sys_account_invitations`
--
ALTER TABLE `lb_sys_account_invitations`
  MODIFY `account_invitation_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_sys_account_password_reset`
--
ALTER TABLE `lb_sys_account_password_reset`
  MODIFY `account_password_reset_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_sys_account_profiles`
--
ALTER TABLE `lb_sys_account_profiles`
  MODIFY `account_profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lb_sys_account_subscriptions`
--
ALTER TABLE `lb_sys_account_subscriptions`
  MODIFY `account_subscription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lb_sys_account_team_members`
--
ALTER TABLE `lb_sys_account_team_members`
  MODIFY `account_team_member_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_sys_lists`
--
ALTER TABLE `lb_sys_lists`
  MODIFY `system_list_item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_sys_subscription_packages`
--
ALTER TABLE `lb_sys_subscription_packages`
  MODIFY `subscription_package_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_sys_translate`
--
ALTER TABLE `lb_sys_translate`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `lb_taxes`
--
ALTER TABLE `lb_taxes`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lb_user_credit_card`
--
ALTER TABLE `lb_user_credit_card`
  MODIFY `user_credit_card_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_user_list`
--
ALTER TABLE `lb_user_list`
  MODIFY `system_list_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `lb_user_payment`
--
ALTER TABLE `lb_user_payment`
  MODIFY `user_payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_user_subscription`
--
ALTER TABLE `lb_user_subscription`
  MODIFY `user_subscription_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_vendor`
--
ALTER TABLE `lb_vendor`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_vendor_discount`
--
ALTER TABLE `lb_vendor_discount`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_vendor_invoice`
--
ALTER TABLE `lb_vendor_invoice`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_vendor_item`
--
ALTER TABLE `lb_vendor_item`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_vendor_tax`
--
ALTER TABLE `lb_vendor_tax`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_vendor_total`
--
ALTER TABLE `lb_vendor_total`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `process_checklist`
--
ALTER TABLE `process_checklist`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `process_checklist_default`
--
ALTER TABLE `process_checklist_default`
  MODIFY `pcdi_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `process_checklist_item_rel`
--
ALTER TABLE `process_checklist_item_rel`
  MODIFY `pcir_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
