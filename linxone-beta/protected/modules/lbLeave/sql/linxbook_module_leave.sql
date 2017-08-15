-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2017 at 03:57 AM
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
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `leave_id` int(11) NOT NULL,
  `leave_startdate` date NOT NULL,
  `leave_enddate` date NOT NULL,
  `leave_reason` text COLLATE utf8_unicode_ci NOT NULL,
  `leave_approver` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_ccreceiver` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leave_date_submit` datetime NOT NULL,
  `account_id` int(11) NOT NULL,
  `leave_name_approvers_by` int(11) NOT NULL,
  `leave_starthour` int(2) NOT NULL,
  `leave_startminute` int(2) NOT NULL,
  `leave_endhour` int(2) NOT NULL,
  `leave_endminute` int(2) NOT NULL
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

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `leave_assignment`
--
ALTER TABLE `leave_assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `leave_in_lieu`
--
ALTER TABLE `leave_in_lieu`
  MODIFY `leave_in_lieu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `leave_package`
--
ALTER TABLE `leave_package`
  MODIFY `leave_package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `leave_package_item`
--
ALTER TABLE `leave_package_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Table structure for table `lb_sys_translate`
--


--
-- Dumping data for data table `lb_sys_translate`
--

INSERT INTO `lb_sys_translate` (`lb_tranlate_en`, `lb_translate_vn`) VALUES
('Leave', 'Nghỉ phép'),
('Applications', 'Việc nộp đơn'),
('Package', 'Gói'),
('In-Lieu', 'Nghỉ bù'),
('Assignment', 'Gán quyền nghỉ'),
('Report', 'Báo cáo'),
('Employee :', 'Nhân viên :'),
('Submit', 'Nộp'),
('Approver', 'Xác nhận'),
('CC-Receiver', 'CC-Người nhận'),
('Reject', 'Từ chối'),
('Assigned Package', 'Gói được gán'),
('Assigned Leave Entitlement (Other than from package)', 'Quyền nghỉ phép được gán/ Số phép được gán ( Nhiều hơn từ gói) '),
('In -Lieu Leave', 'Phép thay thế'),
('Current Date', 'Ngày hiện tại'),
('Status :', 'Trạng thái :'),
('Year :', 'Năm :'),
('Select Employee', 'Chọn nhân viên'),
('Create New Package', 'Tạo mới gói'),
('Delete Package Current', 'Xóa gói hiện tại'),
('Add new leave application', 'Thêm mới đơn nghỉ'),
('Fields with * are required.', 'Phần chứa dấu * là bắt buộc.'),
('*Please choose 13:30 for half-day point, if your leave involves half-day.', 'Vui lòng chọn  13:30 cho mục điểm nửa ngày, nếu phép nghỉ của bạn là nửa ngày'),
('Type Leave *', 'Kiểu ngày nghỉ *'),
('Reason *', 'Lý do *'),
('Start *', 'Bắt đầu *'),
('End *', 'Kết thúc *'),
('Hour', 'Giờ'),
('Minute', 'Phút'),
('Approver *', 'Người xác nhận *'),
('CC-Receiver', 'CC-Người nhận'),
('Select Leave Type', 'Chọn kiểu ngày nghỉ'),
('Select', 'Chọn'),
('Create', 'Tạo mới'),
('Select Employee', 'Chọn nhân viên'),
('Select status', 'Chọn trạng thái'),
('Year', 'Năm'),
('Type Leave', 'Kiểu ngày nghỉ'),
('Reason', 'Lý do'),
('Start', 'Ngày bắt đầu'),
('End', 'Ngày kết thúc'),
('Add new package', 'Thêm mới gói'),
('Total of Days', 'Tổng số ngày'),
('Entitlement', 'Gói ngày nghỉ'),
('Leave In Lieu', 'Nghỉ bù'),
('Add', 'Thêm'),
('Select In Lieu', 'Chọn nghỉ bù'),
('Select Package', 'Chọn gói'),
('Select Type Leave', 'Chọn loại ngày nghỉ'),
('Left', 'Còn lại'),
('View Role', 'Xem vai trò'),
('Basic Permission', 'Quyền cơ bản'),
('Add permission', 'Thêm quyền'),
('Module', 'Mục'),
('Module Name', 'Tên mục'),
('View Own', 'Xem riêng'),
('View All', 'Xem tất cả'),
('Update Own', 'Cập nhật riêng'),
('Update All', 'Cập nhật tất cả'),
('Delete Own', 'Xóa riêng'),
('Delete All', 'Xóa tất cả'),
('List Own', 'Danh sách riêng'),
('List All', 'Danh sách chung'),
('Define Permission', 'Xác định quyền'),
('Role Name', 'Tên vai trò'),
('Role Description', 'Mô tả vai trò'),
('Roles', 'Các vai trò'),
('System', 'Hệ thống'),
('View modules', 'Xem các mục'),
('User roles', 'Vai trò người dùng'),
('Registration', 'Đăng ký doanh nghiệp'),
('Website', 'Trang mạng'),
('Customer Type', 'Loại khách hàng'),
('Basic Information', 'Thông tin cơ bản'),
('Select Customer Type', 'Chọn loại khách hàng'),
('All Customers', 'Tất cả khách hàng'),
('My Company', 'Công ty của tôi'),
('Contract name', 'Tên hợp đồng'),
('Date Start', 'Ngày bắt đầu'),
('Date End', 'Ngày kết thúc'),
('Choose Customer', 'Chọn khách hàng'),
('Choose Address', 'Chọn địa chỉ'),
('Choose Contact', 'Chọn liên hệ'),
('Attachments', 'Tập tin đính kèm'),
('Create new invoice, with paid amount', 'Tạo hóa đơn mới, với số tiền phải trả'),
('Income', 'Thu nhập'),
('All Invoices', 'Tất cả hóa đơn'),
('All Quotations', 'Tất cả báo giá');
