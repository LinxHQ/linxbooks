-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2017 at 10:35 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `linxbooks_2017`
--

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_basic_permission`
--

CREATE TABLE `lb_account_basic_permission` (
  `lb_record_primary_key` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `basic_permission_id` int(11) NOT NULL,
  `basic_permission_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_define_permission`
--

CREATE TABLE `lb_account_define_permission` (
  `lb_record_primary_key` int(11) NOT NULL,
  `define_permission_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_roles`
--

CREATE TABLE `lb_account_roles` (
  `lb_record_primary_key` int(11) NOT NULL,
  `accout_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `lb_account_roles` (`lb_record_primary_key`, `accout_id`, `role_id`) VALUES
(1, 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_basic_permission`
--

INSERT INTO `lb_basic_permission` (`basic_permission_id`, `basic_permission_name`, `basic_permission_description`, `basic_permission_hidden`) VALUES
(1, 'add', '', 0),
(2, 'view own', '', 0),
(3, 'view all', '', 0),
(4, 'update own', '', 0),
(5, 'update all', '', 0),
(6, 'delete own', '', 0),
(7, 'delete all', '', 0),
(8, 'list own', '', 0),
(9, 'list all', '', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_config_login_social`
--

CREATE TABLE `lb_config_login_social` (
  `id` int(11) NOT NULL,
  `action` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lb_config_login_social`
--

INSERT INTO `lb_config_login_social` (`id`, `action`) VALUES
(1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_contract_invoice`
--

CREATE TABLE `lb_contract_invoice` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_contract_id` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'lbGenera', 1, 1, '2017-07-27 10:28:00', 1, '2017-07-27 10:28:00', 1, 0),
(2, 'lbNextId', 1, 1, '2017-07-27 10:28:00', 1, '2017-07-27 10:28:00', 1, 0),
(3, 'lbDefaultNote', 2, 1, '2017-07-27 10:28:53', 1, '2017-07-27 10:28:53', 1, 0),
(4, 'modules', 1, 1, '2017-07-27 10:30:24', 1, '2017-07-27 10:31:57', 1, 0),
(5, 'modules', 2, 1, '2017-07-27 10:30:28', 1, '2017-07-27 10:31:57', 1, 0),
(6, 'modules', 3, 1, '2017-07-27 10:30:35', 1, '2017-07-27 10:31:58', 1, 0),
(7, 'modules', 4, 1, '2017-07-27 10:30:44', 1, '2017-07-27 10:31:58', 1, 0),
(8, 'modules', 5, 1, '2017-07-27 10:30:47', 1, '2017-07-27 10:31:58', 1, 0),
(9, 'modules', 6, 1, '2017-07-27 10:30:52', 1, '2017-07-27 10:31:58', 1, 0),
(10, 'modules', 7, 1, '2017-07-27 10:30:55', 1, '2017-07-27 10:31:57', 1, 0),
(11, 'modules', 8, 1, '2017-07-27 10:30:59', 1, '2017-07-27 10:31:58', 1, 0);

INSERT INTO `lb_core_entities` (`lb_record_primary_key`, `lb_entity_type`, `lb_entity_primary_key`, `lb_created_by`, `lb_created_date`, `lb_last_updated_by`, `lb_last_update`, `lb_subscription_id`, `lb_locked_from_deletion`) VALUES
(16, 'lbCustomer', 1, 1, '2017-08-10 10:27:16', 1, '2017-08-10 10:27:17', 1, 0),
(17, 'lbCustomer', 2, 1, '2017-08-10 10:27:16', 1, '2017-08-10 10:27:17', 1, 0),
(18, 'lbCustomerAddress', 2, 1, '2017-08-10 10:27:16', 1, '2017-08-10 10:27:17', 1, 0),
(19, 'lbCustomerAddress', 1, 1, '2017-08-10 10:27:16', 1, '2017-08-10 10:27:17', 1, 0),
(20, 'lbCustomer', 3, 1, '2017-08-10 10:27:16', 1, '2017-08-10 10:27:17', 1, 0);

INSERT INTO `lb_core_entities` (`lb_record_primary_key`, `lb_entity_type`, `lb_entity_primary_key`, `lb_created_by`, `lb_created_date`, `lb_last_updated_by`, `lb_last_update`, `lb_subscription_id`, `lb_locked_from_deletion`) VALUES
(22, 'roles', 1, 1, '2017-08-15 10:52:53', 1, '2017-08-15 10:52:53', 1, 0),
(24, 'accountRoles', 1, 1, '2017-08-15 10:53:36', 1, '2017-08-15 10:53:36', 1, 0);


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
  `lb_customer_is_own_company` tinyint(1) NOT NULL COMMENT 'only allow ONE per subscription',
  `lb_customer_type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '''vendor'' hoặc ''customer'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

INSERT INTO `lb_customers` (`lb_record_primary_key`, `lb_customer_name`, `lb_customer_registration`, `lb_customer_tax_id`, `lb_customer_website_url`, `lb_customer_is_own_company`, `lb_customer_type`) VALUES
(1, 'Newlife World Ltd', '', NULL, '', 0, NULL),
(2, 'Linx', '', NULL, '', 1, NULL),
(3, 'NexGen', NULL, NULL, '', 0, NULL);

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

INSERT INTO `lb_customer_addresses` (`lb_record_primary_key`, `lb_customer_id`, `lb_customer_address_line_1`, `lb_customer_address_line_2`, `lb_customer_address_city`, `lb_customer_address_state`, `lb_customer_address_country`, `lb_customer_address_postal_code`, `lb_customer_address_website_url`, `lb_customer_address_phone_1`, `lb_customer_address_phone_2`, `lb_customer_address_fax`, `lb_customer_address_email`, `lb_customer_address_note`, `lb_customer_address_is_active`, `lb_customer_address_is_billing`) VALUES
(1, 1, '01 Newlight avenue', '', '', '', 'SG', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(2, 2, '01 Singapore Avenue', '', 'Singapore', '', 'SG', '010001', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_customer_address_contacts`
--

CREATE TABLE `lb_customer_address_contacts` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_customer_address_id` int(11) NOT NULL,
  `lb_customer_contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `lb_default_note`
--

CREATE TABLE `lb_default_note` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_default_note_quotation` longtext NOT NULL,
  `lb_default_note_invoice` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_default_note`
--

INSERT INTO `lb_default_note` (`lb_record_primary_key`, `lb_default_note_quotation`, `lb_default_note_invoice`) VALUES
(1, '', ''),
(2, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `lb_define_permission`
--

CREATE TABLE `lb_define_permission` (
  `define_permission_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `define_permission_name` varchar(100) NOT NULL,
  `define_description` varchar(255) DEFAULT NULL,
  `define_permission_hidden` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_define_permission`
--

INSERT INTO `lb_define_permission` (`define_permission_id`, `module_id`, `define_permission_name`, `define_description`, `define_permission_hidden`) VALUES
(1, 8, 'Leave Management', NULL, 1);

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
  `employee_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `employee_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_employee_salary`
--

CREATE TABLE `lb_employee_salary` (
  `lb_record_primary_key` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_name` varchar(255) NOT NULL,
  `salary_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses`
--

CREATE TABLE `lb_expenses` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_category_id` int(11) NOT NULL,
  `lb_expenses_no` varchar(50) NOT NULL,
  `lb_expenses_amount` decimal(14,2) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_genera`
--

INSERT INTO `lb_genera` (`lb_record_primary_key`, `lb_genera_currency_symbol`, `lb_thousand_separator`, `lb_decimal_symbol`) VALUES
(1, 'SGD', ',', '.');

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
  `lb_invoice_note` longtext COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `lb_invoice_status_code` char(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_invoice_encode` varchar(300) COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `lb_quotation_id` int(11) NULL DEFAULT NULL,
  `lb_invoice_internal_note` longtext COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `lb_invoice_term_id` int(11) NULL DEFAULT NULL,
  `lb_invoice_currency` int(11) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoice_item_templates`
--

CREATE TABLE `lb_invoice_item_templates` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_item_title` varchar(255) DEFAULT NULL,
  `lb_item_description` longtext NOT NULL,
  `lb_item_unit_price` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `lb_language_user`
--

CREATE TABLE `lb_language_user` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_language_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lb_user_id` int(11) NOT NULL,
  `invite_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_language_user`
--

INSERT INTO `lb_language_user` (`lb_record_primary_key`, `lb_language_name`, `lb_user_id`, `invite_id`) VALUES
(1, 'en', 1, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_modules`
--

INSERT INTO `lb_modules` (`lb_record_primary_key`, `module_directory`, `module_name`, `module_text`, `modules_description`, `module_hidden`, `module_order`) VALUES
(1, 'lbCustomer', 'Customers', 'Customers', '', 1, 1),
(2, 'lbInvoice', 'Invoices', 'Income', '', 1, 2),
(3, 'lbEmployee', 'Employee', 'Payroll', '', 0, 6),
(4, 'lbVendor', 'Vendor', 'Bills', '', 0, 7),
(5, 'lbReport', 'Reports', 'Reports', '', 1, 100),
(6, 'lbOpportunities', 'Opportunities', 'Opportunities', '', 1, 5),
(7, 'lbExpenses', 'Expenses', 'Expenses', '', 1, 3),
(8, 'lbLeave', 'Leave', 'Leave', '', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `lb_next_ids`
--

CREATE TABLE `lb_next_ids` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_next_invoice_number` int(11) NOT NULL DEFAULT '1',
  `lb_next_quotation_number` int(11) NOT NULL DEFAULT '1',
  `lb_next_payment_number` int(11) NOT NULL DEFAULT '1',
  `lb_next_contract_number` int(11) NOT NULL DEFAULT '1',
  `lb_next_expenses_number` int(11) NOT NULL DEFAULT '1',
  `lb_next_po_number` int(11) NOT NULL DEFAULT '1',
  `lb_next_supplier_invoice_number` int(11) NOT NULL DEFAULT '1',
  `lb_next_supplier_payment_number` int(11) NOT NULL DEFAULT '1',
  `lb_next_pv_number` int(11) NOT NULL DEFAULT '1',
  `lb_payment_vendor_number` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lb_next_ids`
--

INSERT INTO `lb_next_ids` (`lb_record_primary_key`, `lb_next_invoice_number`, `lb_next_quotation_number`, `lb_next_payment_number`, `lb_next_contract_number`, `lb_next_expenses_number`, `lb_next_po_number`, `lb_next_supplier_invoice_number`, `lb_next_supplier_payment_number`, `lb_next_pv_number`, `lb_payment_vendor_number`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_opportunity`
--

CREATE TABLE `lb_opportunity` (
  `opportunity_id` int(11) NOT NULL,
  `opportunity_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NULL DEFAULT 0,
  `opportunity_status_id` int(11) NOT NULL,
  `value` int(11) NULL DEFAULT 0,
  `deadline` date NULL DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `opportunity_document_id` int(11) NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `industry` int(11) NULL DEFAULT 0,
  `star_rating` decimal(2,1) NULL
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_pv_expenses`
--

CREATE TABLE `lb_pv_expenses` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_payment_voucher_id` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_roles`
--

CREATE TABLE `lb_roles` (
  `lb_record_primary_key` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_description` varchar(255) NOT NULL,
  `role_module_home` int(11) NOT NULL,
  `role_module_home_action` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `lb_roles` (`lb_record_primary_key`, `role_name`, `role_description`, `role_module_home`, `role_module_home_action`) VALUES
(1, 'Base', '', 2, 'dashboard');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `account_status` tinyint(1) NOT NULL,
  `account_check_social_login_id_facebook` varchar(255) DEFAULT NULL,
  `account_check_social_login_id_google` varchar(255) DEFAULT NULL,
  `account_check_email_social_facebook` varchar(255) DEFAULT NULL,
  `account_check_email_social_google` varchar(255) DEFAULT NULL,
  `check_user_activated` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_sys_accounts`
--

INSERT INTO `lb_sys_accounts` (`account_id`, `account_email`, `account_password`, `account_created_date`, `account_timezone`, `account_language`, `account_status`, `account_check_social_login_id_facebook`, `account_check_social_login_id_google`, `account_check_email_social_facebook`, `account_check_email_social_google`, `check_user_activated`) VALUES
(1, 'admin', '$2a$13$QYHbE/G.3O7TBZ4QStbj6.WNCXKnI9XHVfBF3glFC1ZIYGqNztzOq', '2015-09-04 20:42:28', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL);

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
  `account_invitation_subscription_id` int(11) DEFAULT NULL,
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
  `account_profile_surname` varchar(255) NULL DEFAULT NULL,
  `account_profile_given_name` varchar(255) NOT NULL,
  `account_profile_preferred_display_name` varchar(255) NULL DEFAULT NULL,
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
(1, 1, 'My Company', 0, '2015-09-04 20:42:28', NULL, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `lb_sys_translate`
  ADD PRIMARY KEY (`lb_record_primary_key`);

ALTER TABLE `lb_sys_translate`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;

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
(136, 'Membship', 'Hội viên'),
(137, 'Leave', 'Nghỉ phép'),
(138, 'Applications', 'Việc nộp đơn'),
(139, 'Package', 'Gói'),
(140, 'In-Lieu', 'Nghỉ bù'),
(141, 'Assignment', 'Gán quyền nghỉ'),
(142, 'Report', 'Báo cáo'),
(143, 'Employee :', 'Nhân viên :'),
(144, 'Submit', 'Nộp'),
(145, 'Approver', 'Xác nhận'),
(146, 'CC-Receiver', 'CC-Người nhận'),
(147, 'Reject', 'Từ chối'),
(148, 'Assigned Package', 'Gói được gán'),
(149, 'Assigned Leave Entitlement (Other than from package)', 'Quyền nghỉ phép được gán/ Số phép được gán ( Nhiều hơn từ gói) '),
(150, 'In -Lieu Leave', 'Phép thay thế'),
(151, 'Current Date', 'Ngày hiện tại'),
(152, 'Status :', 'Trạng thái :'),
(153, 'Year :', 'Năm :'),
(154, 'Select Employee', 'Chọn nhân viên'),
(155, 'Create New Package', 'Tạo mới gói'),
(156, 'Delete Package Current', 'Xóa gói hiện tại'),
(157, 'Add new leave application', 'Thêm mới đơn nghỉ'),
(158, 'Fields with * are required.', 'Phần chứa dấu * là bắt buộc.'),
(159, '*Please choose 13:30 for half-day point, if your leave involves half-day.', 'Vui lòng chọn  13:30 cho mục điểm nửa ngày, nếu phép nghỉ của bạn là nửa ngày'),
(160, 'Type Leave *', 'Kiểu ngày nghỉ *'),
(161, 'Reason *', 'Lý do *'),
(162, 'Start *', 'Bắt đầu *'),
(163, 'End *', 'Kết thúc *'),
(164, 'Hour', 'Giờ'),
(165, 'Minute', 'Phút'),
(166, 'Approver *', 'Người xác nhận *'),
(167, 'CC-Receiver', 'CC-Người nhận'),
(168, 'Select Leave Type', 'Chọn kiểu ngày nghỉ'),
(169, 'Select', 'Chọn'),
(170, 'Create', 'Tạo mới'),
(171, 'Select Employee', 'Chọn nhân viên'),
(172, 'Select status', 'Chọn trạng thái'),
(173, 'Year', 'Năm'),
(174, 'Type Leave', 'Kiểu ngày nghỉ'),
(175, 'Reason', 'Lý do'),
(176, 'Start', 'Ngày bắt đầu'),
(177, 'End', 'Ngày kết thúc'),
(178, 'Add new package', 'Thêm mới gói'),
(179, 'Total of Days', 'Tổng số ngày'),
(180, 'Entitlement', 'Gói ngày nghỉ'),
(181, 'Leave In Lieu', 'Nghỉ bù'),
(182, 'Add', 'Thêm'),
(183, 'Select In Lieu', 'Chọn nghỉ bù'),
(184, 'Select Package', 'Chọn gói'),
(185, 'Select Type Leave', 'Chọn loại ngày nghỉ'),
(186, 'Left', 'Còn lại'),
(187, 'View Role', 'Xem vai trò'),
(188, 'Basic Permission', 'Quyền cơ bản'),
(189, 'Add permission', 'Thêm quyền'),
(190, 'Module', 'Mục'),
(191, 'Module Name', 'Tên mục'),
(192, 'View Own', 'Xem riêng'),
(193, 'View All', 'Xem tất cả'),
(194, 'Update Own', 'Cập nhật riêng'),
(195, 'Update All', 'Cập nhật tất cả'),
(196, 'Delete Own', 'Xóa riêng'),
(197, 'Delete All', 'Xóa tất cả'),
(198, 'List Own', 'Danh sách riêng'),
(199, 'List All', 'Danh sách chung'),
(200, 'Define Permission', 'Xác định quyền'),
(201, 'Role Name', 'Tên vai trò'),
(202, 'Role Description', 'Mô tả vai trò'),
(203, 'Roles', 'Các vai trò'),
(204, 'System', 'Hệ thống'),
(205, 'View modules', 'Xem các mục'),
(206, 'User roles', 'Vai trò người dùng'),
(207, 'Registration', 'Đăng ký doanh nghiệp'),
(208, 'Website', 'Trang mạng'),
(209, 'Customer Type', 'Loại khách hàng'),
(210, 'Basic Information', 'Thông tin cơ bản'),
(211, 'Select Customer Type', 'Chọn loại khách hàng'),
(212, 'All Customers', 'Tất cả khách hàng'),
(213, 'My Company', 'Công ty của tôi'),
(214, 'Contract name', 'Tên hợp đồng'),
(215, 'Date Start', 'Ngày bắt đầu'),
(216, 'Date End', 'Ngày kết thúc'),
(217, 'Choose Customer', 'Chọn khách hàng'),
(218, 'Choose Address', 'Chọn địa chỉ'),
(219, 'Choose Contact', 'Chọn liên hệ'),
(220, 'Attachments', 'Tập tin đính kèm'),
(221, 'Create new invoice, with paid amount', 'Tạo hóa đơn mới, với số tiền phải trả'),
(222, 'Income', 'Thu nhập'),
(223, 'All Invoices', 'Tất cả hóa đơn'),
(224, 'All Quotations', 'Tất cả báo giá'),
(225, 'Create Account Successfully', 'Tạo tài khoản thành công'),
(226, 'You are not assigned to any module yet. Please contact the Administrator to access the system.', 'Bạn chưa được gán cho bất kỳ mô-đun nào. Vui lòng liên hệ với Quản trị viên để truy cập vào hệ thống.'),
(227, 'Your account is successfully linked to social network', 'Tài khoản của bạn đã được liên kết thành công với mạng xã hội'),
(228, 'Choose a social network below to connect your account with', 'Chọn mạng xã hội dưới đây để kết nối tài khoản của bạn với'),
(229, 'Hide - Show Social Login', 'Ẩn - Hiện chức năng đăng nhập mạng xã hội'),
(230, 'Social Login is On', 'Đăng nhâp mạng xã hội đang được Bật'),
(231, 'Social Login is Off', 'Đăng nhập mạng xã hội đang được Tắt'),
(232, 'Turn on Social Login', 'Bật chức năng đăng nhập mạng xã hội'),
(233, 'Turn off Social Login', 'Tắt chức năng đăng nhập mạng xã hội'),
(234, 'Social Login User List', 'Danh sách tài khoản đăng nhập mạng xã hội'),
(235, 'Active', 'Kích hoạt'),
(236, 'Config ID Social', 'Chỉnh sửa ID mạng xã hội'),
(237, 'New Column', 'Tạo cột'),
(238, 'Successfully', 'Thành Công'),
(239, 'Active Users Successfully', 'Kích hoạt tài khoản thành công'),
(240, 'Submitted', 'Đã nộp'),
(241, 'Approved', 'Đã xác nhận'),
(242, 'Rejected', 'Từ chối'),
(243, 'Pending', 'Chờ xác nhận'),
(244, 'Advanced Leave', 'Phép ứng trước'),
(245, 'Annual Leave', 'Phép hàng năm'),
(246, 'Anniversary Credit', 'Ngày lễ, kỷ niệm'),
(247, 'Apprisal', 'Việc thẩm định'),
(248, 'Balace Leave', 'Phép dư'),
(249, 'Brought Fwr Leave', 'Phép cộng dồn'),
(250, 'Compasionate Leave', 'Phép hiếu hỉ'),
(251, 'Consumed Leave', 'Phép đã dùng'),
(252, 'Enhanced Childcare Leave', 'Phép con thơ'),
(253, 'In-lieu Labour Day', 'Ngày làm việc bù'),
(254, 'Infant Care', 'Con ốm'),
(255, 'Leave in Lieu', 'Phép bù'),
(256, 'Maternity Leave', 'Nghỉ thai sản'),
(257, 'Moving office', 'Chuyển văn phòng'),
(258, 'National Service Leave', 'Nghỉ nghĩa vụ quân sự'),
(259, 'On Course', 'Theo kế hoạch'),
(260, 'Paternity Leave', 'Phép vợ sinh con'),
(261, 'Sick Leave', 'Nghỉ ốm'),
(262, 'Staff Event', 'Sự kiện'),
(263, 'Staff Lunch', 'Giờ nghỉ trưa'),
(264, 'Staff Meeting', 'Họp nhân viên'),
(265, 'Unpaid Leave', 'Phép không lương'),
(266, 'Genera', 'Chi'),
(267, 'Tax', 'Thuế'),
(268, 'Invoice Number', 'Số hóa đơn'),
(269, 'System List Item', 'Danh mục hệ thống'),
(270, 'System List Item Name', 'Tên danh mục hệ thống'),
(271, 'Insert', 'Chèn'),
(272, 'New Item', 'Mục mới'),
(273, 'New List', 'Danh sách mới'),
(274, 'leave_type', 'Loại ngày nghỉ'),
(275, 'leave_year', 'Tạo năm (Module nghỉ phép)'),
(276, 'custom_type', 'Loại khách hàng'),
(277, 'status_list', 'Trạng thái (Module ngày nghỉ)'),
(278, 'leave_application_hourend', 'Giờ kết thúc nghỉ phép (Module ngày nghỉ)'),
(279, 'leave_application_hourstart', 'Giờ bắt đầu nghỉ phép (Module ngày nghỉ)'),
(280, 'leave_application_minute', 'Phút bắt đầu và kết thúc nghỉ phép'),
(281, 'Disconnect from Google', 'Ngắt kết nối tài khoản với Google'),
(282, 'Disconnect from Facebook', 'Ngắt kết nối tài khoản với Facebook'),
(283, 'Your account is connected to Google login', 'Tài khoản của bạn đang được ngắt kết nối với Google'),
(284, 'Your account is not connected to Google login', 'Tài khoản của bạn đang được kết nối với Google'),
(285, 'Your account is connected to Facebook login', 'Tài khoản của bạn đang được kết nối với Facebook'),
(286, 'Your account is not connected to Facebook login', 'Tài khoản của bạn đang được ngắt kết nối với Facebook'),
(287, 'Successfully disconnected from Google', 'Ngắt kết nối với Google thành công'),
(288, 'Successfully disconnected from Facebook', 'Ngắt kết nối với Facebook thành công'),
(289, 'Page Home', 'Trang chủ');

INSERT INTO `lb_sys_translate` (`lb_record_primary_key`, `lb_tranlate_en`, `lb_translate_vn`) VALUES
(290, 'Full day', 'Cả ngày'),
(291, 'Half day leave (morning)', 'Buổi sáng'),
(292, 'Half day leave (afternoon)', 'Buổi chiều'),
(293, 'Employee', 'Nhân viên'),
(294, 'Update Application', 'Chỉnh sửa đơn xin nghỉ'),
(295, 'View Application', 'Xem đơn xin nghỉ'),
(296, 'List Day Leave', 'Chi tiết ngày nghỉ'),
(297, 'Sum day leave', 'Tổng số ngày nghỉ'),
(298, 'Date submit', 'Ngày nộp'),
(299, 'Add CC-Receiver', 'Thêm người nhận'),
(300, 'leave_application_style_date', 'Trạng thái nghỉ'),
(301,'Project', 'Dự án'),
(302,'Task', 'Công việc'),
(303,'Documents', 'Văn bản'),
(304,'Issue', 'Vấn đề'),
(305,'Task', 'Công việc'),
(306,'Implementations', 'Hoàn thành'),
(307,'Create Project', 'Tạo dự án'),
(308,'Create Wiki Page', 'Tạo wiki'),
(309,'Create Task', 'Tạo công việc'),
(310,'Documents uploaded to your tasks, issues, implementations, etc. will be listed here', 'Tài liệu được tải lên các tác vụ, vấn đề, triển khai của bạn, v.v ... sẽ được liệt kê ở đây'),
(311,'Upload document', 'Tải lên tài liệu'),
(312,'Comment or upload document', 'Nhận xét hoặc tải lên tài liệu'),
(313,'Open', 'Mở'),
(314,'Done', 'Đã xong'),
(315,'Feature', 'Tính năng'),
(316,'Issue', 'Vấn đề'),
(317,'Forum', 'Diễn đàn'),
(318,'Other', 'Khác'),
(319,'Description', 'Mô tả'),
(320,'by', 'bởi'),
(321,'People', 'Thành viên'),
(322,'Update', 'Cập nhật'),
(323,'Schedule', 'Lịch'),
(324,'Milestone', 'Mốc'),
(325,'Posted on', 'Được đăng vào'),
(326,'Reply', 'Trả lời'),
(327,'not completed', 'chưa hoàn thành'),
(328,'completed', 'đã hoàn thành'),
(329,'To-do', 'Cần làm'),
(330,'Click to Reply', 'Ấn để phản hồi'),
(331,'Archive & Lock Project', 'Dự án lưu trữ và khóa'),
(332,'Unlock from Archive', 'Mở khóa từ lưu trữ'),
(333,'Delete Project', 'Xóa dự án'),
(334,'Check', 'Kiểm tra'),
(335,'Last updated by', 'Cập nhật lần cuối bởi'),
(336,'History', 'Lịch sử'),
(337,'Edit', 'Sửa'),
(338,'Tags', 'Thẻ'),
(339,'Attachments', 'File đính kèm'),
(340,'Add Sub Page', 'Thêm trang con'),
(341,'Table of Contents', 'Mục lục');

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
(1, 'GST', '7.00', 0),
(2, 'VAT', '10.00', 0),
(8, 'GST', '10.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_credit_card`
--

CREATE TABLE `lb_user_credit_card` (
  `user_credit_card_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `credit_card_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_list`
--

CREATE TABLE `lb_user_list` (
  `system_list_item_id` int(11) NOT NULL,
  `system_list_name` varchar(255) DEFAULT NULL,
  `system_list_code` varchar(100) NOT NULL,
  `system_list_item_code` varchar(255) NOT NULL,
  `system_list_item_name` varchar(255) NOT NULL,
  `system_list_parent_item_id` int(11) DEFAULT NULL,
  `system_list_item_order` int(4) DEFAULT NULL,
  `system_list_item_active` tinyint(1) DEFAULT NULL,
  `system_list_item_day` int(11) DEFAULT NULL,
  `system_list_item_month` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `lb_user_list`
  ADD PRIMARY KEY (`system_list_item_id`);

ALTER TABLE `lb_user_list`
  MODIFY `system_list_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Dumping data for table `lb_user_list`
--

INSERT INTO `lb_user_list` (`system_list_item_id`, `system_list_name`, `system_list_code`, `system_list_item_code`, `system_list_item_name`, `system_list_parent_item_id`, `system_list_item_order`, `system_list_item_active`, `system_list_item_day`, `system_list_item_month`) VALUES
(1, '', 'expenses_category', '', '', 0, 0, 1, 0, 0),
(2, '', 'recurring', 'recurring_recuring1', 'recuring1', 0, 0, 1, 0, 0),
(3, '', 'benefit', 'benefit_test1', 'test1', 0, 0, 1, 0, 0),
(4, '', 'salary', 'salary_Luong co ban', 'Luong co ban', 0, 0, 1, 0, 0),
(5, '', 'salary', 'salary_thuong', 'thuong', 0, 0, 1, 0, 0),
(6, '', 'salary', 'salary_hỗ trợ ăn trưa', 'hỗ trợ ăn trưa', 0, 0, 1, 0, 0),
(7, '', 'benefit', 'benefit_Bao hiem', 'Bao hiem', 0, 0, 1, 0, 0),
(8, '', 'benefit', 'benefit_bao hiem nhan tho', 'bao hiem nhan tho', 0, 0, 1, 0, 0),
(11, '', 'financial_year', 'financial_year', 'Financial Year', 0, 0, 1, 30, 4),
(12, '', 'term', 'term_Immediate', 'Immediate', 0, 0, 1, 0, 0),
(13, '', 'term', 'term_7 days', '7 days', 0, 0, 1, 0, 0),
(14, '', 'term', 'term_14 days', '14 days', 0, 0, 1, 0, 0),
(15, '', 'term', 'term_30 days', '30 days', 0, 0, 1, 0, 0),
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
(69, '', 'custom_type', 'custom_type_Vendor', 'Vendor', 0, 0, 1, 0, 0),
(70, NULL, 'status_product', 'status_product_Enabled', 'Enabled', NULL, NULL, 1, NULL, NULL),
(71, NULL, 'status_product', 'status_product_Disabled', 'Disabled', NULL, NULL, 1, NULL, NULL),
(72, NULL, 'catalog_available_colors', 'catalog_available_colors_Light grey', 'Light grey', NULL, NULL, 1, NULL, NULL),
(73, NULL, 'catalog_available_colors', 'catalog_available_colors_Dark red', 'Dark red', NULL, NULL, 1, NULL, NULL),
(74, NULL, 'catalog_available_colors', 'catalog_available_colors_Ocean blue', 'Ocean blue', NULL, NULL, 1, NULL, NULL),
(75, NULL, 'catalog_stock_availability', 'catalog_stock_availability_In stock', 'In stock', NULL, NULL, 1, NULL, NULL),
(76, NULL, 'catalog_stock_availability', 'catalog_stock_availability_Out of stock', 'Out of stock', NULL, NULL, 1, NULL, NULL),
(77, NULL, 'status', 'status_Active', 'Active', NULL, NULL, 1, NULL, NULL),
(78, NULL, 'status', 'status_Inactive', 'Inactive', NULL, NULL, 1, NULL, NULL),
(79, 'leave_application_style_date', 'leave_application_style_date_Full day', 'Full day', 0, 0, 1, 0, 0, NULL),
(80, 'leave_application_style_date', 'leave_application_style_date_Half day leave (morni', 'Half day leave (morning)', 0, 0, 1, 0, 0, NULL),
(81, 'leave_application_style_date', 'leave_application_style_date_Half day leave (after', 'Half day leave (afternoon)', 0, 0, 1, 0, 0, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `leave_id` int(11) NOT NULL,
  `leave_startdate` date NOT NULL,
  `leave_enddate` date NOT NULL,
  `leave_reason` text COLLATE utf8_unicode_ci NOT NULL,
  `leave_approver` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_ccreceiver` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `leave_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_date_submit` datetime NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `leave_name_approvers_by` int(11) NOT NULL,
  `leave_starthour` INT(2) NULL DEFAULT NULL,
  `leave_startminute` INT(2) NULL DEFAULT NULL,
  `leave_endhour` INT(2) NULL DEFAULT NULL,
  `leave_endminute` INT(2) NULL DEFAULT NULL,
  `leave_list_day` TEXT NULL DEFAULT NULL COMMENT 'tong hop cac ngay nghi theo format: 2017/08/09,Full day,2017/08/10,Full day,2017/08/11,Full day',
  `leave_sum_day` DECIMAL(10,1) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_assignment`
--

CREATE TABLE `leave_assignment` (
  `assignment_id` int(11) NOT NULL,
  `assignment_leave_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignment_leave_type_id` int(11) NOT NULL,
  `assignment_account_id` int(11) NOT NULL,
  `assignment_year` int(11) NOT NULL,
  `assignment_total_days` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_in_lieu`
--

CREATE TABLE `leave_in_lieu` (
  `leave_in_lieu_id` int(11) NOT NULL,
  `leave_in_lieu_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_in_lieu_day` date NOT NULL,
  `leave_in_lieu_totaldays` float NOT NULL,
  `account_create_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_package`
--

CREATE TABLE `leave_package` (
  `leave_package_id` int(11) NOT NULL,
  `leave_package_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_package_item`
--

CREATE TABLE `leave_package_item` (
  `item_id` int(11) NOT NULL,
  `item_leave_package_id` int(11) NOT NULL,
  `item_leave_type_id` int(11) NOT NULL,
  `item_total_days` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `process_checklist_default`
--

CREATE TABLE `process_checklist_default` (
  `pcdi_id` int(11) NOT NULL,
  `pc_id` int(11) NOT NULL,
  `pcdi_name` varchar(255) NOT NULL,
  `pcdi_order` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yiisession`
--

CREATE TABLE `yiisession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yiisession`
--

INSERT INTO `yiisession` (`id`, `expire`, `data`) VALUES
('2nvftr1fkibp0o8kvpqhqm93e5', 1520416322, ''),
('4acoe5n8rmauro1m6skj10l7v7', 1523071573, ''),
('be4aaf290eef0496c1bc1c69b65a315e', 1520756976, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lb_account_basic_permission`
--
ALTER TABLE `lb_account_basic_permission`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_account_define_permission`
--
ALTER TABLE `lb_account_define_permission`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_account_roles`
--
ALTER TABLE `lb_account_roles`
  ADD PRIMARY KEY (`lb_record_primary_key`);

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
-- Indexes for table `lb_config_login_social`
--
ALTER TABLE `lb_config_login_social`
  ADD PRIMARY KEY (`id`);

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
-- ALTER TABLE `lb_sys_translate`
--  ADD PRIMARY KEY (`lb_record_primary_key`);

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
-- ALTER TABLE `lb_user_list`
--  ADD PRIMARY KEY (`system_list_item_id`);

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
-- Indexes for table `leave_application`
--
ALTER TABLE `leave_application`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `leave_assignment`
--
ALTER TABLE `leave_assignment`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `leave_in_lieu`
--
ALTER TABLE `leave_in_lieu`
  ADD PRIMARY KEY (`leave_in_lieu_id`);

--
-- Indexes for table `leave_package`
--
ALTER TABLE `leave_package`
  ADD PRIMARY KEY (`leave_package_id`);

--
-- Indexes for table `leave_package_item`
--
ALTER TABLE `leave_package_item`
  ADD PRIMARY KEY (`item_id`);

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
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_account_define_permission`
--
ALTER TABLE `lb_account_define_permission`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_account_roles`
--
ALTER TABLE `lb_account_roles`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_bank_account`
--
ALTER TABLE `lb_bank_account`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_basic_permission`
--
ALTER TABLE `lb_basic_permission`
  MODIFY `basic_permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `lb_comment`
--
ALTER TABLE `lb_comment`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_config_login_social`
--
ALTER TABLE `lb_config_login_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `lb_customers`
--
ALTER TABLE `lb_customers`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_customer_addresses`
--
ALTER TABLE `lb_customer_addresses`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_customer_address_contacts`
--
ALTER TABLE `lb_customer_address_contacts`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_customer_contacts`
--
ALTER TABLE `lb_customer_contacts`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_default_note`
--
ALTER TABLE `lb_default_note`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lb_define_permission`
--
ALTER TABLE `lb_define_permission`
  MODIFY `define_permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_invoice_items`
--
ALTER TABLE `lb_invoice_items`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_invoice_item_templates`
--
ALTER TABLE `lb_invoice_item_templates`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_invoice_totals`
--
ALTER TABLE `lb_invoice_totals`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `lb_opportunity`
--
ALTER TABLE `lb_opportunity`
  MODIFY `opportunity_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_opportunity_comment`
--
ALTER TABLE `lb_opportunity_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_opportunity_document`
--
ALTER TABLE `lb_opportunity_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_opportunity_entry`
--
ALTER TABLE `lb_opportunity_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_opportunity_industry`
--
ALTER TABLE `lb_opportunity_industry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_opportunity_status`
--
ALTER TABLE `lb_opportunity_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `lb_payment`
--
ALTER TABLE `lb_payment`
  MODIFY `lb_record_primary_key` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_payments`
--
ALTER TABLE `lb_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_payment_item`
--
ALTER TABLE `lb_payment_item`
  MODIFY `lb_record_primary_key` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
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
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_quotation_discount`
--
ALTER TABLE `lb_quotation_discount`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_quotation_item`
--
ALTER TABLE `lb_quotation_item`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_quotation_tax`
--
ALTER TABLE `lb_quotation_tax`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_quotation_total`
--
ALTER TABLE `lb_quotation_total`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `account_subscription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
-- ALTER TABLE `lb_sys_translate`
--  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;
--
-- AUTO_INCREMENT for table `lb_taxes`
--
ALTER TABLE `lb_taxes`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `lb_user_credit_card`
--
ALTER TABLE `lb_user_credit_card`
  MODIFY `user_credit_card_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_user_list`
--
-- ALTER TABLE `lb_user_list`
--  MODIFY `system_list_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
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
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_assignment`
--
ALTER TABLE `leave_assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_in_lieu`
--
ALTER TABLE `leave_in_lieu`
  MODIFY `leave_in_lieu_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_package`
--
ALTER TABLE `leave_package`
  MODIFY `leave_package_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_package_item`
--
ALTER TABLE `leave_package_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
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
  
-- --------------------------------------------------------

--
-- Table structure for table `lb_catalog_categories`
--

CREATE TABLE `lb_catalog_categories` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_category_name` varchar(100) NOT NULL,
  `lb_category_description` varchar(255) NOT NULL,
  `lb_category_status` int(1) NOT NULL,
  `lb_category_created_date` datetime NOT NULL,
  `lb_category_created_by` int(11) NOT NULL,
  `lb_category_parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_catalog_category_product`
--

CREATE TABLE `lb_catalog_category_product` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_category_id` int(11) NOT NULL,
  `lb_product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lb_catalog_products`
--

CREATE TABLE `lb_catalog_products` (
  `lb_record_primary_key` int(11) NOT NULL,
  `lb_product_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_product_sku` varchar(30) NOT NULL,
  `lb_product_status` int(1) NOT NULL,
  `lb_product_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_product_price` decimal(14,2) NOT NULL,
  `lb_product_special_price` decimal(14,2) DEFAULT NULL,
  `lb_product_special_price_from_date` date DEFAULT NULL,
  `lb_product_special_price_to_date` date DEFAULT NULL,
  `lb_product_tax` decimal(4,2) NOT NULL,
  `lb_product_qty` int(5) NOT NULL,
  `lb_product_qty_out_of_stock` int(5) DEFAULT NULL,
  `lb_product_qty_min_order` int(5) DEFAULT NULL,
  `lb_product_qty_max_order` int(5) DEFAULT NULL,
  `lb_product_qty_notify` int(5) DEFAULT NULL,
  `lb_product_stock_availability` int(1) DEFAULT NULL,
  `lb_product_created_date` datetime NOT NULL,
  `lb_product_updated_date` datetime NOT NULL,
  `lb_product_create_by` int(11) NOT NULL,
  `lb_product_available_color` varchar(50) NOT NULL,
  `lb_product_dimension` varchar(50) NOT NULL,
  `lb_product_weight` decimal(5,2) NOT NULL,
  `lb_product_sort_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `lb_catalog_categories`
--
ALTER TABLE `lb_catalog_categories`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_catalog_category_product`
--
ALTER TABLE `lb_catalog_category_product`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- Indexes for table `lb_catalog_products`
--
ALTER TABLE `lb_catalog_products`
  ADD PRIMARY KEY (`lb_record_primary_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lb_catalog_categories`
--
ALTER TABLE `lb_catalog_categories`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `lb_catalog_category_product`
--
ALTER TABLE `lb_catalog_category_product`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `lb_catalog_products`
--
ALTER TABLE `lb_catalog_products`
  MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `lb_documents` ADD `lb_document_type` VARCHAR(50) NOT NULL AFTER `lb_document_encoded_name`;
