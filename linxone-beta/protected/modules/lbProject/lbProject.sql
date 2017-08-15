-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: May 16, 2017 at 10:38 AM
-- Server version: 5.5.38
-- PHP Version: 5.5.14

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `lb_project_documents`;
CREATE TABLE `lb_project_documents` (
`document_id` int(11) NOT NULL,
  `document_real_name` varchar(255) NOT NULL,
  `document_encoded_name` varchar(255) NOT NULL,
  `document_description` varchar(255) DEFAULT NULL,
  `document_date` datetime NOT NULL,
  `document_revision` int(3) NOT NULL,
  `document_root_revision_id` int(11) NOT NULL,
  `document_owner_id` int(11) NOT NULL,
  `document_parent_id` int(11) DEFAULT NULL,
  `document_parent_type` char(100) DEFAULT NULL,
  `document_is_temp` tinyint(1) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=953 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_notifications`
--

DROP TABLE IF EXISTS `lb_project_email_notifications`;
CREATE TABLE `lb_project_email_notifications` (
`notification_id` int(11) NOT NULL,
  `notification_parent_id` int(11) NOT NULL,
  `notification_parent_type` char(60) NOT NULL,
  `notification_created_date` datetime NOT NULL,
  `notification_sent` tinyint(1) NOT NULL,
  `notification_sender_account_id` int(11) NOT NULL,
  `notification_receivers_account_ids` char(225) NOT NULL,
  `notification_hash` char(64) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6295 ;

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

DROP TABLE IF EXISTS `lb_project_milestones`;
CREATE TABLE `lb_project_milestones` (
`milestone_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `milestone_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `milestone_date` date DEFAULT NULL COMMENT 'deadline for this milestone',
  `milestone_status` int(1) NOT NULL COMMENT '-1: canceled; 1: not completed. 2: completed',
  `milestone_description` text COLLATE utf8_unicode_ci,
  `milestone_created_date` datetime NOT NULL,
  `milestone_created_by` int(11) NOT NULL,
  `milestone_last_update` datetime NOT NULL,
  `milestone_last_updated_by` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `milestone_entities`
--

DROP TABLE IF EXISTS `lb_project_milestone_entities`;
CREATE TABLE `lb_project_milestone_entities` (
`me_id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `me_entity_type` char(60) COLLATE utf8_unicode_ci NOT NULL,
  `me_entity_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `lb_project_projects`;
CREATE TABLE `lb_project_projects` (
`project_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_owner_id` int(11) NOT NULL,
  `project_start_date` datetime NOT NULL,
  `project_description` varchar(1000) DEFAULT NULL,
  `project_status` tinyint(1) NOT NULL,
  `account_subscription_id` int(11) NOT NULL,
  `project_latest_activity_date` datetime DEFAULT '0000-00-00 00:00:00',
  `project_simple_view` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'default 0: No. 1: yes',
  `project_priority` int(1) NOT NULL DEFAULT '3' COMMENT '3: low, 2: normal, 1: high',
  `project_ms_method` int(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=422 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

DROP TABLE IF EXISTS `lb_project_project_members`;
CREATE TABLE `lb_project_project_members` (
`project_member_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `project_member_start_date` datetime NOT NULL,
  `project_member_is_manager` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=263 ;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `lb_project_resources`;
CREATE TABLE `lb_project_resources` (
`resource_id` int(11) NOT NULL,
  `account_subscription_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT '0',
  `resource_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resource_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resource_created_by` int(11) NOT NULL,
  `resource_created_date` datetime NOT NULL,
  `resource_space` char(60) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'PUBLIC, PRIVATE'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `resource_assigned_lists`
--

DROP TABLE IF EXISTS `lb_project_resource_assigned_lists`;
CREATE TABLE `lb_project_resource_assigned_lists` (
`resource_assigned_list_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `resource_user_list_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Table structure for table `resource_user_lists`
--

DROP TABLE IF EXISTS `lb_project_resource_user_lists`;
CREATE TABLE `lb_project_resource_user_lists` (
`resource_user_list_id` int(11) NOT NULL,
  `account_subscription_id` int(11) NOT NULL,
  `resource_user_list_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_user_list_created_by` int(11) NOT NULL,
  `resource_user_list_created_date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `lb_project_tasks`;
CREATE TABLE `lb_project_tasks` (
`task_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_start_date` date DEFAULT NULL,
  `task_end_date` date DEFAULT NULL,
  `task_owner_id` int(11) NOT NULL,
  `task_created_date` date NOT NULL,
  `task_public_viewable` tinyint(1) DEFAULT NULL,
  `task_status` tinyint(1) DEFAULT NULL,
  `task_last_commented_date` datetime DEFAULT NULL,
  `task_description` longtext,
  `task_is_sticky` int(1) DEFAULT '0' COMMENT '1: sticky. 0: no',
  `task_type` int(2) DEFAULT '1',
  `task_no` varchar(20) DEFAULT NULL,
  `task_priority` int(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2078 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_assignees`
--

DROP TABLE IF EXISTS `lb_project_task_assignees`;
CREATE TABLE `lb_project_task_assignees` (
`task_assignee_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `task_assignee_start_date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2242 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

DROP TABLE IF EXISTS `lb_project_task_comments`;
CREATE TABLE `lb_project_task_comments` (
`task_comment_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `task_comment_owner_id` int(11) NOT NULL,
  `task_comment_last_update` datetime NOT NULL,
  `task_comment_created_date` datetime NOT NULL,
  `task_comment_content` longtext NOT NULL,
  `task_comment_internal` tinyint(1) DEFAULT NULL,
  `task_comment_parent_id` int(11) NOT NULL,
  `task_comment_to_do` tinyint(1) DEFAULT NULL,
  `task_comment_to_do_completed` tinyint(1) DEFAULT '0',
  `task_comment_api` char(60) DEFAULT NULL COMMENT 'EMAIL or not'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5926 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_progress`
--

DROP TABLE IF EXISTS `lb_project_task_progress`;
CREATE TABLE `lb_project_task_progress` (
`tp_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL COMMENT 'account id of assignee',
  `tp_percent_completed` int(3) NOT NULL DEFAULT '0',
  `tp_last_update` datetime NOT NULL,
  `tp_last_update_by` int(11) NOT NULL,
  `tp_days_completed` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='store the percentage of work completed by each assignee of a task' AUTO_INCREMENT=106 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_resource_plan`
--

DROP TABLE IF EXISTS `lb_project_task_resource_plan`;
CREATE TABLE `lb_project_task_resource_plan` (
`trp_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL COMMENT 'account id of the assignee',
  `trp_start` datetime NOT NULL,
  `trp_end` datetime NOT NULL,
  `trp_work_load` int(3) NOT NULL DEFAULT '0' COMMENT 'percentage of workload',
  `trp_effort` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `wiki_pages`
--

DROP TABLE IF EXISTS `lb_project_wiki_pages`;
CREATE TABLE `lb_project_wiki_pages` (
`wiki_page_id` int(11) NOT NULL,
  `account_subscription_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `wiki_page_title` varchar(255) NOT NULL,
  `wiki_page_parent_id` int(11) DEFAULT NULL,
  `wiki_page_content` longtext NOT NULL,
  `wiki_page_tags` varchar(255) DEFAULT NULL,
  `wiki_page_date` datetime NOT NULL,
  `wiki_page_updated_by` int(11) NOT NULL,
  `wiki_page_summary` varchar(255) DEFAULT NULL,
  `wiki_page_creator_id` int(11) NOT NULL,
  `wiki_page_is_category` tinyint(1) DEFAULT NULL,
  `wiki_page_order` int(3) DEFAULT NULL COMMENT 'order within its group (category order; or page order in a category) - NO LONGER IN USE',
  `sort` int(11) NOT NULL COMMENT 'order of page within its parent group',
  `wiki_page_is_template` tinyint(1) NOT NULL COMMENT '0: not a template, 1: a template',
  `wiki_page_is_home` tinyint(1) DEFAULT NULL COMMENT '0/null: non home page, 1: home page'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=536 ;

-- --------------------------------------------------------

--
-- Table structure for table `wiki_page_revisions`
--

DROP TABLE IF EXISTS `lb_project_wiki_page_revisions`;
CREATE TABLE `lb_project_wiki_page_revisions` (
`wiki_page_revision_id` int(11) NOT NULL,
  `wiki_page_id` int(11) NOT NULL,
  `wiki_page_revision_content` longtext NOT NULL,
  `wiki_page_revision_date` datetime NOT NULL,
  `wiki_page_revision_updated_by` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=506 ;

--
-- Indexes for dumped tables
--

--
-- Table structure for table `lb_project_list_items`
--
DROP TABLE IF EXISTS `lb_project_list_items`;
CREATE TABLE `lb_project_list_items` (
  `system_list_item_id` int(11) NOT NULL,
  `system_list_name` varchar(255) NOT NULL,
  `system_list_item_code` char(50) NOT NULL,
  `system_list_item_name` varchar(255) NOT NULL,
  `system_list_parent_item_id` int(11) DEFAULT NULL,
  `system_list_item_order` int(4) DEFAULT NULL,
  `system_list_item_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lb_project_list_items`
--

INSERT INTO `lb_project_list_items` (`system_list_item_id`, `system_list_name`, `system_list_item_code`, `system_list_item_name`, `system_list_parent_item_id`, `system_list_item_order`, `system_list_item_active`) VALUES
(1, 'Issue Priority', 'issue_priority_high', 'High', NULL, 1, 1),
(2, 'Issue Priority', 'issue_priority_normal', 'Normal', NULL, 2, 1),
(3, 'Issue Priority', 'issue_priority_low', 'Low', NULL, 3, 1),
(4, 'Issue Status', 'issue_status_open', 'Open', NULL, 1, 1),
(5, 'Issue Status', 'issue_status_closed', 'Closed', NULL, 2, 1),
(6, 'Implementation Status', 'implementation_status_pending', 'Pending', NULL, 1, 1),
(8, 'Implementation Status', 'implementation_status_done_with_success', 'Successful', NULL, 3, 1),
(9, 'Implementation Status', 'implementation_status_done_with_reversion', 'Failed', NULL, 4, 1);

--
-- Table structure for table `next_ids`
--
DROP TABLE IF EXISTS `next_ids`;
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


--
-- Indexes for table `documents`
--
ALTER TABLE `lb_project_documents`
 ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `email_notifications`
--
ALTER TABLE `lb_project_email_notifications`
 ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `lb_project_milestones`
 ADD PRIMARY KEY (`milestone_id`);

--
-- Indexes for table `milestone_entities`
--
ALTER TABLE `lb_project_milestone_entities`
 ADD PRIMARY KEY (`me_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `lb_project_projects`
 ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_members`
--
ALTER TABLE `lb_project_project_members`
 ADD PRIMARY KEY (`project_member_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `lb_project_resources`
 ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `resource_assigned_lists`
--
ALTER TABLE `lb_project_resource_assigned_lists`
 ADD PRIMARY KEY (`resource_assigned_list_id`);

--
-- Indexes for table `resource_user_lists`
--
ALTER TABLE `lb_project_resource_user_lists`
 ADD PRIMARY KEY (`resource_user_list_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `lb_project_tasks`
 ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `task_assignees`
--
ALTER TABLE `lb_project_task_assignees`
 ADD PRIMARY KEY (`task_assignee_id`);

--
-- Indexes for table `task_comments`
--
ALTER TABLE `lb_project_task_comments`
 ADD PRIMARY KEY (`task_comment_id`);

--
-- Indexes for table `task_progress`
--
ALTER TABLE `lb_project_task_progress`
 ADD PRIMARY KEY (`tp_id`);

--
-- Indexes for table `task_resource_plan`
--
ALTER TABLE `lb_project_task_resource_plan`
 ADD PRIMARY KEY (`trp_id`);

--
-- Indexes for table `wiki_pages`
--
ALTER TABLE `lb_project_wiki_pages`
 ADD PRIMARY KEY (`wiki_page_id`);

--
-- Indexes for table `wiki_page_revisions`
--
ALTER TABLE `lb_project_wiki_page_revisions`
 ADD PRIMARY KEY (`wiki_page_revision_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `lb_project_documents`
MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=953;
--
-- AUTO_INCREMENT for table `email_notifications`
--
ALTER TABLE `lb_project_email_notifications`
MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6295;
--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `lb_project_milestones`
MODIFY `milestone_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `milestone_entities`
--
ALTER TABLE `lb_project_milestone_entities`
MODIFY `me_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `lb_project_projects`
MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=422;
--
-- AUTO_INCREMENT for table `project_members`
--
ALTER TABLE `lb_project_project_members`
MODIFY `project_member_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=263;
--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `lb_project_resources`
MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `resource_assigned_lists`
--
ALTER TABLE `lb_project_resource_assigned_lists`
MODIFY `resource_assigned_list_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `resource_user_lists`
--
ALTER TABLE `lb_project_resource_user_lists`
MODIFY `resource_user_list_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `lb_project_tasks`
MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2078;
--
-- AUTO_INCREMENT for table `task_assignees`
--
ALTER TABLE `lb_project_task_assignees`
MODIFY `task_assignee_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2242;
--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `lb_project_task_comments`
MODIFY `task_comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5926;
--
-- AUTO_INCREMENT for table `task_progress`
--
ALTER TABLE `lb_project_task_progress`
MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `task_resource_plan`
--
ALTER TABLE `lb_project_task_resource_plan`
MODIFY `trp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `wiki_pages`
--
ALTER TABLE `lb_project_wiki_pages`
MODIFY `wiki_page_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=536;
--
-- AUTO_INCREMENT for table `wiki_page_revisions`
--
ALTER TABLE `lb_project_wiki_page_revisions`
MODIFY `wiki_page_revision_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=506;

