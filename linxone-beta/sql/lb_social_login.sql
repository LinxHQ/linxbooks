-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2017 at 05:36 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30


-- Add new 5 column in table lb_sys_accounts
ALTER TABLE `lb_sys_accounts` ADD 
`account_check_social_login_id_facebook` VARCHAR(255) NULL AFTER `account_status`;

ALTER TABLE `lb_sys_accounts` ADD 
`account_check_social_login_id_google` VARCHAR(255) NULL AFTER `account_check_social_login_id_facebook`;

ALTER TABLE `lb_sys_accounts` ADD 
`account_check_email_social_facebook` VARCHAR(255) NULL AFTER `account_check_social_login_id_google`;

ALTER TABLE `lb_sys_accounts` ADD 
`account_check_email_social_google` VARCHAR(255) NULL AFTER `account_check_email_social_facebook`;

ALTER TABLE `lb_sys_accounts` ADD 
`check_user_activated` INT(11) NULL AFTER `account_check_email_social_google`;

-- Create table config login social, use hidden - show modules social
CREATE TABLE `lb_config_login_social` (
    `id` int(1) NULL AUTO_INCREMENT,
	`action` int(1) NULL,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM;

INSERT INTO `lb_config_login_social` (`id`, `action`) VALUES
(1, 1);