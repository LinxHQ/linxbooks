-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2015 at 04:17 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `linxbooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_basic_permission`
--

CREATE TABLE IF NOT EXISTS `lb_account_basic_permission` (
`account_basic_permission_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `basic_permission_id` int(11) NOT NULL,
  `basic_permission_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_define_permission`
--

CREATE TABLE IF NOT EXISTS `lb_account_define_permission` (
`account_define_permission_id` int(11) NOT NULL,
  `define_permission_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_account_roles`
--

CREATE TABLE IF NOT EXISTS `lb_account_roles` (
`account_role_id` int(11) NOT NULL,
  `accout_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_bank_account`
--

CREATE TABLE IF NOT EXISTS `lb_bank_account` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_account_id` int(11) NOT NULL,
  `lb_bank_account` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_basic_permission`
--

CREATE TABLE IF NOT EXISTS `lb_basic_permission` (
`basic_permission_id` int(11) NOT NULL,
  `basic_permission_name` varchar(100) NOT NULL,
  `basic_permission_description` varchar(255) NOT NULL,
  `basic_permission_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_comment`
--

CREATE TABLE IF NOT EXISTS `lb_comment` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_module_name` varchar(100) NOT NULL,
  `lb_comment_description` longtext NOT NULL,
  `lb_item_module_id` int(11) NOT NULL,
  `lb_account_id` int(11) NOT NULL,
  `lb_comment_date` date NOT NULL,
  `lb_parent_comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_contracts`
--

CREATE TABLE IF NOT EXISTS `lb_contracts` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_contract_document`
--

CREATE TABLE IF NOT EXISTS `lb_contract_document` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_contract_id` int(11) NOT NULL,
  `lb_document_url` varchar(255) NOT NULL,
  `lb_document_name` varchar(255) NOT NULL,
  `lb_document_url_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_contract_invoice`
--

CREATE TABLE IF NOT EXISTS `lb_contract_invoice` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_contract_id` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_core_entities`
--

CREATE TABLE IF NOT EXISTS `lb_core_entities` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_entity_type` char(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'INVOICE, QUOTATION, CUSTOMER,...',
  `lb_entity_primary_key` int(11) NOT NULL,
  `lb_created_by` int(11) NOT NULL,
  `lb_created_date` datetime NOT NULL,
  `lb_last_updated_by` int(11) NOT NULL,
  `lb_last_update` datetime NOT NULL,
  `lb_subscription_id` int(11) NOT NULL,
  `lb_locked_from_deletion` tinyint(1) NOT NULL COMMENT 'e.g. already paid or written-off invoices'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='attributes that almost all important models should have' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `lb_core_entities`
--

INSERT INTO `lb_core_entities` (`lb_record_primary_key`, `lb_entity_type`, `lb_entity_primary_key`, `lb_created_by`, `lb_created_date`, `lb_last_updated_by`, `lb_last_update`, `lb_subscription_id`, `lb_locked_from_deletion`) VALUES
(1, 'lbGenera', 1, 1, '2015-06-15 04:15:38', 1, '2015-06-15 04:15:38', 1, 0),
(2, 'lbNextId', 1, 1, '2015-06-15 04:15:38', 1, '2015-06-15 04:15:38', 1, 0),
(3, 'lbDefaultNote', 1, 1, '2015-06-15 04:15:38', 1, '2015-06-15 04:15:38', 1, 0),
(4, 'modules', 1, 1, '2015-06-15 04:15:45', 1, '2015-06-15 04:16:36', 1, 0),
(5, 'modules', 2, 1, '2015-06-15 04:15:49', 1, '2015-06-15 04:16:32', 1, 0),
(6, 'modules', 3, 1, '2015-06-15 04:15:52', 1, '2015-06-15 04:16:29', 1, 0),
(7, 'modules', 4, 1, '2015-06-15 04:15:55', 1, '2015-06-15 04:16:25', 1, 0),
(8, 'modules', 5, 1, '2015-06-15 04:15:58', 1, '2015-06-15 04:16:22', 1, 0),
(9, 'modules', 6, 1, '2015-06-15 04:16:01', 1, '2015-06-15 04:16:18', 1, 0),
(10, 'modules', 7, 1, '2015-06-15 04:16:06', 1, '2015-06-15 04:16:15', 1, 0),
(11, 'modules', 8, 1, '2015-06-15 04:16:09', 1, '2015-06-15 04:16:12', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_customers`
--

CREATE TABLE IF NOT EXISTS `lb_customers` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lb_customer_registration` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_tax_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_website_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_customer_is_own_company` tinyint(1) NOT NULL COMMENT 'only allow ONE per subscription'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_customer_addresses`
--

CREATE TABLE IF NOT EXISTS `lb_customer_addresses` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_customer_address_contacts`
--

CREATE TABLE IF NOT EXISTS `lb_customer_address_contacts` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_customer_address_id` int(11) NOT NULL,
  `lb_customer_contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_customer_contacts`
--

CREATE TABLE IF NOT EXISTS `lb_customer_contacts` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_default_note`
--

CREATE TABLE IF NOT EXISTS `lb_default_note` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_default_note_quotation` longtext NOT NULL,
  `lb_default_note_invoice` longtext NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lb_default_note`
--

INSERT INTO `lb_default_note` (`lb_record_primary_key`, `lb_default_note_quotation`, `lb_default_note_invoice`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `lb_define_permission`
--

CREATE TABLE IF NOT EXISTS `lb_define_permission` (
`define_permission_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `define_permission_name` varchar(100) NOT NULL,
  `define_description` varchar(255) NOT NULL,
  `define_permission_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_documents`
--

CREATE TABLE IF NOT EXISTS `lb_documents` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_document_parent_type` varchar(255) NOT NULL,
  `lb_document_parent_id` int(11) NOT NULL,
  `lb_account_id` int(11) NOT NULL,
  `lb_document_url` varchar(255) NOT NULL,
  `lb_document_name` varchar(255) NOT NULL,
  `lb_document_uploaded_datetime` datetime NOT NULL,
  `lb_document_encoded_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses`
--

CREATE TABLE IF NOT EXISTS `lb_expenses` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_category_id` int(11) NOT NULL,
  `lb_expenses_no` varchar(50) NOT NULL,
  `lb_expenses_amount` decimal(10,2) NOT NULL,
  `lb_expenses_date` date NOT NULL,
  `lb_expenses_recurring_id` int(11) DEFAULT NULL,
  `lb_expenses_bank_account_id` int(11) DEFAULT NULL,
  `lb_expenses_note` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses_customer`
--

CREATE TABLE IF NOT EXISTS `lb_expenses_customer` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL,
  `lb_customer_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses_invoice`
--

CREATE TABLE IF NOT EXISTS `lb_expenses_invoice` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_expenses_tax`
--

CREATE TABLE IF NOT EXISTS `lb_expenses_tax` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL,
  `lb_tax_id` int(11) NOT NULL,
  `lb_expenses_tax_total` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_genera`
--

CREATE TABLE IF NOT EXISTS `lb_genera` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_genera_currency_symbol` varchar(100) NOT NULL,
  `lb_thousand_separator` varchar(50) NOT NULL,
  `lb_decimal_symbol` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lb_genera`
--

INSERT INTO `lb_genera` (`lb_record_primary_key`, `lb_genera_currency_symbol`, `lb_thousand_separator`, `lb_decimal_symbol`) VALUES
(1, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoices`
--

CREATE TABLE IF NOT EXISTS `lb_invoices` (
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
  `lb_invoice_internal_note` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoice_items`
--

CREATE TABLE IF NOT EXISTS `lb_invoice_items` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL,
  `lb_invoice_item_type` char(60) COLLATE utf8_unicode_ci NOT NULL COMMENT 'LINE_ITEM, DISCOUNT, TAX',
  `lb_invoice_item_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_invoice_item_quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_item_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_item_total` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoice_item_templates`
--

CREATE TABLE IF NOT EXISTS `lb_invoice_item_templates` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_item_title` varchar(255) DEFAULT NULL,
  `lb_item_description` longtext NOT NULL,
  `lb_item_unit_price` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_invoice_totals`
--

CREATE TABLE IF NOT EXISTS `lb_invoice_totals` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_invoice_id` int(11) NOT NULL,
  `lb_invoice_revision_id` int(11) NOT NULL COMMENT '0 for latest',
  `lb_invoice_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_total_after_discounts` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_total_after_taxes` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_total_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lb_invoice_total_outstanding` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_modules`
--

CREATE TABLE IF NOT EXISTS `lb_modules` (
`lb_record_primary_key` int(11) NOT NULL,
  `module_directory` varchar(100) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `module_text` varchar(100) NOT NULL,
  `modules_description` varchar(255) NOT NULL,
  `module_hidden` int(1) NOT NULL,
  `module_order` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

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

CREATE TABLE IF NOT EXISTS `lb_next_ids` (
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
  `lb_next_pv_number` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lb_next_ids`
--

INSERT INTO `lb_next_ids` (`lb_record_primary_key`, `lb_next_invoice_number`, `lb_next_quotation_number`, `lb_next_payment_number`, `lb_next_contract_number`, `lb_next_expenses_number`, `lb_next_po_number`, `lb_next_supplier_invoice_number`, `	lb_next_supplier_payment_number`, `lb_next_supplier_payment_number`, `lb_next_pv_number`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment`
--

CREATE TABLE IF NOT EXISTS `lb_payment` (
`lb_record_primary_key` int(11) unsigned NOT NULL,
  `lb_payment_customer_id` int(10) unsigned NOT NULL,
  `lb_payment_no` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_payment_method` int(11) NOT NULL,
  `lb_payment_date` date NOT NULL,
  `lb_payment_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_payment_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_payments`
--

CREATE TABLE IF NOT EXISTS `lb_payments` (
`id` int(11) NOT NULL,
  `txn_id` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `paypal_id` varchar(250) NOT NULL,
  `created_at` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment_item`
--

CREATE TABLE IF NOT EXISTS `lb_payment_item` (
`lb_record_primary_key` int(11) unsigned NOT NULL,
  `lb_payment_id` int(11) unsigned NOT NULL,
  `lb_invoice_id` int(11) unsigned NOT NULL,
  `lb_payment_item_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lb_payment_item_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment_vendor`
--

CREATE TABLE IF NOT EXISTS `lb_payment_vendor` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_payment_vendor_customer_id` int(11) NOT NULL,
  `lb_payment_vendor_no` varchar(100) NOT NULL,
  `lb_payment_vendor_method` int(11) NOT NULL,
  `lb_payment_vendor_date` date NOT NULL,
  `lb_payment_vendor_notes` varchar(255) NOT NULL,
  `lb_payment_vendor_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment_vendor_invoice`
--

CREATE TABLE IF NOT EXISTS `lb_payment_vendor_invoice` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_payment_id` int(11) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL,
  `lb_payment_item_note` varchar(100) NOT NULL,
  `lb_payment_item_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_payment_voucher`
--

CREATE TABLE IF NOT EXISTS `lb_payment_voucher` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_pv_company_id` int(11) NOT NULL,
  `lb_pv_company_address_id` int(11) NOT NULL,
  `lb_payment_voucher_no` varchar(100) NOT NULL,
  `lb_pv_title` varchar(255) NOT NULL,
  `lb_pv_description` varchar(255) NOT NULL,
  `lb_pv_create_by` int(11) NOT NULL,
  `lb_pv_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_pv_expenses`
--

CREATE TABLE IF NOT EXISTS `lb_pv_expenses` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_payment_voucher_id` int(11) NOT NULL,
  `lb_expenses_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation`
--

CREATE TABLE IF NOT EXISTS `lb_quotation` (
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
  `lb_quotation_encode` varchar(255) DEFAULT NULL,
  `lb_quotation_internal_note` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation_discount`
--

CREATE TABLE IF NOT EXISTS `lb_quotation_discount` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_quotation_discount_description` varchar(255) NOT NULL,
  `lb_quotation_discount_value` decimal(10,2) NOT NULL,
  `lb_quotation_discount_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation_item`
--

CREATE TABLE IF NOT EXISTS `lb_quotation_item` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_quotation_item_description` text NOT NULL,
  `lb_quotation_item_quantity` decimal(10,2) NOT NULL,
  `lb_quotation_item_price` decimal(10,2) NOT NULL,
  `lb_quotation_item_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation_tax`
--

CREATE TABLE IF NOT EXISTS `lb_quotation_tax` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_quotation_tax_id` int(11) NOT NULL,
  `lb_quotation_tax_value` decimal(10,2) NOT NULL,
  `lb_quotation_tax_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_quotation_total`
--

CREATE TABLE IF NOT EXISTS `lb_quotation_total` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_quotation_id` int(11) NOT NULL,
  `lb_quotation_subtotal` decimal(10,2) NOT NULL,
  `lb_quotation_total_after_discount` decimal(10,2) NOT NULL,
  `lb_quotation_total_after_tax` decimal(10,2) NOT NULL,
  `lb_quotation_total_after_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_roles`
--

CREATE TABLE IF NOT EXISTS `lb_roles` (
`lb_record_primary_key` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_roles_basic_permission`
--

CREATE TABLE IF NOT EXISTS `lb_roles_basic_permission` (
`role_basic_permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `basic_permission_id` int(11) NOT NULL,
  `basic_permission_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_roles_define_permission`
--

CREATE TABLE IF NOT EXISTS `lb_roles_define_permission` (
`role_define_permission_id` int(11) NOT NULL,
  `define_permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `define_permission_status` int(1) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_subscription`
--

CREATE TABLE IF NOT EXISTS `lb_subscription` (
`subscription_id` int(11) NOT NULL,
  `subscription_name` varchar(255) NOT NULL,
  `subscription_cycle` int(11) NOT NULL,
  `subscription_value` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_accounts`
--

CREATE TABLE IF NOT EXISTS `lb_sys_accounts` (
`account_id` int(11) NOT NULL,
  `account_email` char(255) NOT NULL,
  `account_password` char(255) NOT NULL,
  `account_created_date` datetime NOT NULL,
  `account_timezone` varchar(255) DEFAULT NULL,
  `account_language` varchar(255) DEFAULT NULL,
  `account_status` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_invitations`
--

CREATE TABLE IF NOT EXISTS `lb_sys_account_invitations` (
`account_invitation_id` int(11) NOT NULL,
  `account_invitation_master_id` int(11) NOT NULL,
  `account_invitation_to_email` char(255) NOT NULL,
  `account_invitation_date` datetime NOT NULL,
  `account_invitation_status` tinyint(4) NOT NULL,
  `account_invitation_rand_key` char(100) NOT NULL,
  `account_invitation_project` int(11) DEFAULT NULL,
  `account_invitation_type` tinyint(1) NOT NULL COMMENT '0: team member, 1: customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_password_reset`
--

CREATE TABLE IF NOT EXISTS `lb_sys_account_password_reset` (
`account_password_reset_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_password_reset_rand_key` char(100) CHARACTER SET utf8 NOT NULL,
  `account_password_reset_rand_key_expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_profiles`
--

CREATE TABLE IF NOT EXISTS `lb_sys_account_profiles` (
`account_profile_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_profile_surname` varchar(255) NOT NULL,
  `account_profile_given_name` varchar(255) NOT NULL,
  `account_profile_preferred_display_name` varchar(255) NOT NULL,
  `account_profile_company_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_subscriptions`
--

CREATE TABLE IF NOT EXISTS `lb_sys_account_subscriptions` (
`account_subscription_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `subscription_name` varchar(255) NOT NULL,
  `account_subscription_package_id` tinyint(3) NOT NULL,
  `account_subscription_start_date` datetime NOT NULL,
  `account_subscription_end_date` datetime DEFAULT NULL,
  `account_subscription_status_id` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_account_team_members`
--

CREATE TABLE IF NOT EXISTS `lb_sys_account_team_members` (
`account_team_member_id` int(11) NOT NULL,
  `member_account_id` int(11) NOT NULL,
  `account_subscription_id` int(11) NOT NULL,
  `master_account_id` int(11) NOT NULL,
  `is_customer` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL COMMENT '-1 deactivated; 1 active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_lists`
--

CREATE TABLE IF NOT EXISTS `lb_sys_lists` (
`system_list_item_id` int(11) NOT NULL,
  `system_list_name` varchar(255) NOT NULL,
  `system_list_code` char(100) NOT NULL,
  `system_list_item_code` char(50) NOT NULL,
  `system_list_item_name` varchar(255) NOT NULL,
  `system_list_parent_item_id` int(11) DEFAULT NULL,
  `system_list_item_order` int(4) DEFAULT NULL,
  `system_list_item_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_subscription_packages`
--

CREATE TABLE IF NOT EXISTS `lb_sys_subscription_packages` (
`subscription_package_id` int(11) NOT NULL,
  `subscription_package_name` varchar(255) NOT NULL,
  `subscription_package_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_sys_translate`
--

CREATE TABLE IF NOT EXISTS `lb_sys_translate` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_tranlate_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lb_translate_vn` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137 ;

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

CREATE TABLE IF NOT EXISTS `lb_taxes` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_tax_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `lb_tax_value` decimal(5,2) NOT NULL COMMENT 'percentage:7 for 7%',
  `lb_tax_is_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_credit_card`
--

CREATE TABLE IF NOT EXISTS `lb_user_credit_card` (
`user_credit_card_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `credit_card_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_list`
--

CREATE TABLE IF NOT EXISTS `lb_user_list` (
`system_list_item_id` int(11) NOT NULL,
  `system_list_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `system_list_code` varchar(100) CHARACTER SET utf8 NOT NULL,
  `system_list_item_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `system_list_item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `system_list_parent_item_id` int(11) NOT NULL,
  `system_list_item_order` int(4) NOT NULL,
  `system_list_item_active` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lb_user_list`
--

INSERT INTO `lb_user_list` (`system_list_item_id`, `system_list_name`, `system_list_code`, `system_list_item_code`, `system_list_item_name`, `system_list_parent_item_id`, `system_list_item_order`, `system_list_item_active`) VALUES
(1, '', 'expenses_category', '', '', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_payment`
--

CREATE TABLE IF NOT EXISTS `lb_user_payment` (
`user_payment_id` int(11) NOT NULL,
  `user_subscription_id` int(11) NOT NULL,
  `date_payment` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_user_subscription`
--

CREATE TABLE IF NOT EXISTS `lb_user_subscription` (
`user_subscription_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `date_from` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor`
--

CREATE TABLE IF NOT EXISTS `lb_vendor` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_discount`
--

CREATE TABLE IF NOT EXISTS `lb_vendor_discount` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_type` varchar(100) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL,
  `lb_vendor_description` varchar(255) NOT NULL,
  `lb_vendor_value` decimal(10,2) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_invoice`
--

CREATE TABLE IF NOT EXISTS `lb_vendor_invoice` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_item`
--

CREATE TABLE IF NOT EXISTS `lb_vendor_item` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_type` varchar(100) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL,
  `lb_vendor_item_description` longtext NOT NULL,
  `lb_vendor_item_price` decimal(10,2) NOT NULL,
  `lb_vendor_item_quantity` decimal(10,2) NOT NULL,
  `lb_vendor_item_amount` decimal(10,2) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_tax`
--

CREATE TABLE IF NOT EXISTS `lb_vendor_tax` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL,
  `lb_vendor_tax_id` int(11) NOT NULL,
  `lb_vendor_tax_value` decimal(10,2) NOT NULL,
  `lb_vendor_tax_total` decimal(10,2) NOT NULL,
  `lb_vendor_type` varchar(100) NOT NULL,
  `lb_tax_name` varchar(100) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_vendor_total`
--

CREATE TABLE IF NOT EXISTS `lb_vendor_total` (
`lb_record_primary_key` int(11) NOT NULL,
  `lb_vendor_id` int(11) NOT NULL,
  `lb_vendor_type` varchar(100) NOT NULL,
  `lb_vendor_subtotal` decimal(10,2) NOT NULL,
  `lb_vendor_total_last_discount` decimal(10,2) NOT NULL,
  `lb_vendor_last_tax` decimal(10,2) NOT NULL,
  `lb_vendor_last_paid` decimal(10,2) NOT NULL,
  `lb_vendor_last_outstanding` decimal(10,2) NOT NULL,
  `lb_vendor_invoice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `process_checklist`
--

CREATE TABLE IF NOT EXISTS `process_checklist` (
`pc_id` int(11) NOT NULL,
  `subcription_id` int(11) NOT NULL,
  `pc_name` varchar(100) NOT NULL,
  `pc_created_by` int(11) NOT NULL,
  `pc_created_date` date NOT NULL,
  `pc_last_update_by` int(11) NOT NULL,
  `pc_last_update` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `process_checklist_default`
--

CREATE TABLE IF NOT EXISTS `process_checklist_default` (
`pcdi_id` int(11) NOT NULL,
  `pc_id` int(11) NOT NULL,
  `pcdi_name` varchar(255) NOT NULL,
  `pcdi_order` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `process_checklist_item_rel`
--

CREATE TABLE IF NOT EXISTS `process_checklist_item_rel` (
`pcir_id` int(11) NOT NULL,
  `pc_id` int(11) NOT NULL,
  `pcir_name` varchar(255) NOT NULL,
  `pcir_order` int(11) NOT NULL,
  `pcir_entity_type` varchar(100) NOT NULL,
  `pcir_entity_id` int(11) NOT NULL,
  `pcir_status` int(1) NOT NULL,
  `pcir_status_update_by` int(11) NOT NULL,
  `pcir_status_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yiisession`
--

CREATE TABLE IF NOT EXISTS `yiisession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `lb_employee`
--

CREATE TABLE IF NOT EXISTS `lb_employee` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lb_employee_benefits`
--

CREATE TABLE IF NOT EXISTS `lb_employee_benefits` (
`lb_record_primary_key` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `benefit_name` varchar(255) NOT NULL,
  `benefit_tax` decimal(10,2) NOT NULL,
  `benefit_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `lb_employee_payment`
--

CREATE TABLE IF NOT EXISTS `lb_employee_payment` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `lb_employee_salary`
--

CREATE TABLE IF NOT EXISTS `lb_employee_salary` (
`lb_record_primary_key` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_name` varchar(255) NOT NULL,
  `salary_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
 ADD PRIMARY KEY (`account_profile_id`), ADD UNIQUE KEY `account_id` (`account_id`);

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
 ADD PRIMARY KEY (`system_list_item_id`), ADD UNIQUE KEY `system_list_item_code` (`system_list_item_code`);

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
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `lb_customers`
--
ALTER TABLE `lb_customers`
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
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
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
-- AUTO_INCREMENT for table `lb_modules`
--
ALTER TABLE `lb_modules`
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `lb_next_ids`
--
ALTER TABLE `lb_next_ids`
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lb_payment`
--
ALTER TABLE `lb_payment`
MODIFY `lb_record_primary_key` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_payments`
--
ALTER TABLE `lb_payments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_payment_item`
--
ALTER TABLE `lb_payment_item`
MODIFY `lb_record_primary_key` int(11) unsigned NOT NULL AUTO_INCREMENT;
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
MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
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
MODIFY `account_profile_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `lb_sys_account_subscriptions`
--
ALTER TABLE `lb_sys_account_subscriptions`
MODIFY `account_subscription_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
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
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `lb_taxes`
--
ALTER TABLE `lb_taxes`
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_user_credit_card`
--
ALTER TABLE `lb_user_credit_card`
MODIFY `user_credit_card_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lb_user_list`
--
ALTER TABLE `lb_user_list`
MODIFY `system_list_item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
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

--
-- AUTO_INCREMENT for table `lb_employee`
--
ALTER TABLE `lb_employee`
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `lb_employee_benefits`
--
ALTER TABLE `lb_employee_benefits`
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `lb_employee_payment`
--
ALTER TABLE `lb_employee_payment`
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `lb_employee_salary`
--
ALTER TABLE `lb_employee_salary`
MODIFY `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

--
-- Table structure for table `lb_language_user`
--

CREATE TABLE IF NOT EXISTS `lb_language_user` (
  `lb_record_primary_key` int(11) NOT NULL AUTO_INCREMENT,
  `lb_language_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lb_user_id` int(11) NOT NULL,
  `invite_id` int(11) NOT NULL,
  PRIMARY KEY (`lb_record_primary_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
