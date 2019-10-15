-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2017 at 11:59 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linxbooks_2017`
--

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
