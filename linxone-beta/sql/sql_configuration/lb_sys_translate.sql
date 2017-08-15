-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2017 at 01:38 PM
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

--
-- Dumping data for table `lb_sys_translate`
--

INSERT INTO `lb_sys_translate` (`lb_record_primary_key`, `lb_tranlate_en`, `lb_translate_vn`) VALUES
('Submitted', 'Đã nộp'),
('Approved', 'Đã xác nhận'),
('Rejected', 'Từ chối'),
('Pending', 'Chờ xác nhận'),
('Advanced Leave', 'Phép ứng trước'),
('Annual Leave', 'Phép hàng năm'),
('Anniversary Credit', 'Ngày lễ, kỷ niệm'),
('Apprisal', 'Việc thẩm định'),
('Balace Leave', 'Phép dư'),
('Brought Fwr Leave', 'Phép cộng dồn'),
('Compasionate Leave', 'Phép hiếu hỉ'),
('Consumed Leave', 'Phép đã dùng'),
('Enhanced Childcare Leave', 'Phép con thơ'),
('In-lieu Labour Day', 'Ngày làm việc bù'),
('Infant Care', 'Con nhỏ'),
('Leave in Lieu', 'Phép bù'),
('Maternity Leave', 'Nghỉ thai sản'),
('Moving office', 'Chuyển văn phòng'),
('National Service Leave', 'Nghỉ nghĩa vụ quân sự'),
('On Course', 'Theo kế hoạch'),
('Paternity Leave', 'Phép vợ sinh con'),
('Sick Leave', 'Nghỉ ốm'),
('Staff Event', 'Sự kiện'),
('Staff Lunch', 'Giờ nghỉ trưa'),
('Staff Meeting', 'Họp nhân viên'),
('Unpaid Leave', 'Phép không lương'),
('Genera', 'Chi'),
('Tax', 'Thuế'),
('Invoice Number', 'Số hóa đơn'),
('System List Item', 'Danh mục hệ thống'),
('System List Item Name', 'Tên danh mục hệ thống'),
('Insert', 'Chèn'),
('New Item', 'Mục mới'),
('New List', 'Danh sách mới'),
('leave_type', 'Loại ngày nghỉ'),
('leave_year', 'Tạo năm (Module nghỉ phép)'),
('custom_type', 'Loại khách hàng'),
('status_list', 'Trạng thái (Module ngày nghỉ)'),
('leave_application_hourend', 'Giờ kết thúc nghỉ phép (Module ngày nghỉ)'),
('leave_application_hourstart', 'Giờ bắt đầu nghỉ phép (Module ngày nghỉ)'),
('leave_application_minute', 'Phút bắt đầu và kết thúc nghỉ phép');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
