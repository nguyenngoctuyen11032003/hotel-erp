-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th5 16, 2025 lúc 12:15 AM
-- Phiên bản máy phục vụ: 9.1.0
-- Phiên bản PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `khachsan_erp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `admin_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `created_at`) VALUES
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd6ab8', 'Sys Admin', 'admin@gmail.com', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 18:23:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assets`
--

DROP TABLE IF EXISTS `assets`;
CREATE TABLE IF NOT EXISTS `assets` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `assets_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `assets`
--

INSERT INTO `assets` (`id`, `name`, `code`, `details`, `status`, `created_at`) VALUES
('0b8f18a47ea85bada12945ed8fc5d545dbf0788d61', 'Tivi Samsung 43\\\" Smart 4K', 'XSBNW-42750', 'Tivi màn hình phẳng, độ phân giải 4K UHD, kết nối Wi-Fi, tích hợp YouTube/Netflix', 'Hoạt động', '2025-05-15 19:46:42'),
('33f4a8d2a0b345354a670c33e3a810901fe9f12a81e89a800c', 'Két sắt điện tử Welko KS35', 'UF1CX-91054', 'Két chống cháy, mã điện tử, có chìa khóa dự phòng', 'Hoạt động', '2025-05-15 19:48:21'),
('3e1c9190a105276e6a3c2bcd309030d4787c9964d1572f457e', 'Điều hòa Daikin 2 chiều Inverter 12000 BTU', 'FBU0T-57069', 'Máy lạnh tiết kiệm điện, có điều khiển từ xa, hoạt động êm ái', 'Hoạt động', '2025-05-15 19:47:52'),
('412e9976af93887bdc31489a68e8ed7c3d9fd9945e39536ee4', 'Tủ lạnh mini Aqua 90L', 'VUJ9R-34689', 'Tủ lạnh nhỏ gọn, có ngăn đá, thiết kế cho phòng khách sạn', 'Hoạt động', '2025-05-15 19:48:02'),
('7da85a935083ef2905e32ef1664f23deccf3bad5eb1fa91b65', 'Máy sấy tóc Panasonic EH-ND21', 'O4Y2H-35418', 'Máy sấy công suất 1200W, gấp gọn, 3 chế độ nhiệt', 'Hoạt động', '2025-05-15 19:48:30'),
('8967dcda387a2596e6024bb7f8d47ebb80f16adfdba21a69e0', 'Bàn làm việc gỗ công nghiệp kèm ghế đệm da', 'AXLEW-16748', 'Mặt bàn phủ veneer chống xước, ghế bọc da êm ái', 'Hoạt động', '2025-05-15 19:47:41'),
('9c81aa5068a68c718bfdf0ef10353f5462559dbc96a6036121', 'Bình đun siêu tốc Sunhouse 1.8L', 'JW1QF-58962', 'Vỏ inox không gỉ, tự ngắt khi sôi, chân xoay 360 độ', 'Hoạt động', '2025-05-15 19:48:11'),
('9c86f16163a0576078fb1f0454683d5242e10378ab85e28e75', 'Tủ quần áo 3 cánh MDF phủ Melamine', 'U395E-20753', 'Tủ đứng, thiết kế hiện đại, có ngăn treo và ngăn xếp đồ, cửa kéo êm ái', 'Hoạt động', '2025-05-15 19:47:27'),
('bc27318efcd1bd21267dcb821d8058199057ec865a88458e24', 'Giường ngủ đôi 1m8 gỗ sồi', 'UJ576-84071', 'Giường khung gỗ sồi, đệm cao su, đầu giường bọc nỉ cao cấp', 'Hoạt động', '2025-05-15 19:47:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `check_in` time NOT NULL,
  `check_out` time DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `attendance`
--

INSERT INTO `attendance` (`id`, `staff_id`, `date`, `check_in`, `check_out`, `status`, `created_at`) VALUES
('', 'e4f2c219f414223be9f1825ceb1dd81ea4abc0000', '2025-04-08', '17:10:06', '17:10:11', 'Present', '2025-04-08 17:10:06'),
('67f6982031fc8', 'e4f2c219f414223be9f1825ceb1dd81ea4abc0000', '2025-04-09', '15:54:08', '15:54:16', 'Present', '2025-04-09 15:54:08'),
('67f759fe28748', 'e4f2c219f414223be9f1825ceb1dd81ea4abc0000', '2025-04-10', '05:41:18', '08:48:00', 'Muộn', '2025-04-10 05:41:18'),
('68266c5b23ca5', 'e4f2c219f414223be9f1825ceb1dd81ea4abc0000', '2025-05-15', '22:36:11', '22:36:14', 'Present', '2025-05-15 22:36:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2020_09_10_090517_create_sessions_table', 1),
(7, '2020_09_23_093603_create_admin_table', 1),
(8, '2020_09_23_093712_create_staffs_table', 1),
(9, '2020_09_23_093726_create_rooms_table', 1),
(10, '2020_09_23_093756_create_reservations_table', 1),
(11, '2020_09_23_093826_create_resturants_table', 1),
(12, '2020_09_23_093854_create_assets_table', 1),
(13, '2020_09_23_093909_create_payrolls_table', 1),
(14, '2020_09_23_093931_create_vendors_table', 1),
(15, '2020_09_23_094001_create_house-keeping_table', 1),
(16, '2020_09_23_094025_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('sysadmin@kea-hotel-erp.org', '2a63ae7c3ee35cb720c0872cb8408a5bccd24dee4fde5a5100494b64d79351f05828f977b04642b59b7781f1f9bf1f2f49009970efb1f74767cde8707a604794dbfafe3c3af390e17531794493cd92a5953e14ebf6414212cc088048eb36034', '2020-09-23 12:47:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_paid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_means` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `code`, `amt`, `cust_name`, `service_paid`, `payment_means`, `status`, `month`, `created_at`) VALUES
('0129c69b882fd9e31725d2d6e9585d0027983819b597077daa', 'IWYSM1XDL4', '500000', 'Trương Khánh Linh', 'Resturant Sales', 'Tiền mặt', '', 'May', '2025-05-15 19:22:24'),
('14f3f26948a7133cc4a91b3e2e0ed180ab2435702b6754c18e', 'CPOMFUXDV9', '110000000', 'Nguyễn Ngọc Tuyền', 'Đặt phòng', 'Tiền mặt', '', 'May', '2025-05-15 19:21:04'),
('5396c04bcb337e96a20e798594934a3ea53acd45d90b099a7a', 'GJ5OY6UWNM', '250000', 'Nguyễn Việt Tùng', 'Resturant Sales', 'Thẻ tín dụng', '', 'May', '2025-05-15 21:29:30'),
('5a363f1c04f6d6b446de466fc5d70e5192cae4d2d9e2fc7e5d', 'PY4OH3JUG8', '50000', 'Nguyễn Văn Hiến', 'Resturant Sales', 'Thẻ tín dụng', '', 'May', '2025-05-15 22:59:18'),
('76c61c163f5c5091fcf1e5c7c71fe15ee78adf6f0a119b59cc', '8IPC9LQSND', '50000', 'Vũ Hoàng Long', 'Resturant Sales', 'Thẻ tín dụng', '', 'May', '2025-05-15 20:26:53'),
('81b34e4dbbfa2c289bc7e84b551013d3dd459b5c63c26db712', 'T19LYDM6U7', '1200000', 'Nguyễn Văn Hiến', 'Đặt phòng', 'Thẻ tín dụng', '', 'May', '2025-05-15 20:32:52'),
('83c46ec35a99dd7496f725fa28bbf44d40d2bf6d3863b5f319', '80YNLTIUSX', '200000', 'Nguyễn Ngọc Tuyền', 'Resturant Sales', 'Tiền mặt', '', 'May', '2025-05-15 19:21:56'),
('c5c411958f2e69ab5c1617ec321a31b461390142bc757fe2d8', 'GFWUAVICY7', '16000000', 'Vũ Hoàng Long', 'Đặt phòng', 'Thẻ tín dụng', '', 'May', '2025-05-15 20:06:17'),
('ca764911dc305e887722550f07588b2d6047adf3e7d1172315', 'ILOGFNV50R', '125000000', 'Nguyễn Việt Tùng', 'Đặt phòng', 'Tiền mặt', '', 'May', '2025-05-15 20:33:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payrolls`
--

DROP TABLE IF EXISTS `payrolls`;
CREATE TABLE IF NOT EXISTS `payrolls` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `payrolls_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payrolls`
--

INSERT INTO `payrolls` (`id`, `code`, `month`, `staff_id`, `staff_name`, `salary`, `created_at`) VALUES
('11c6ebacb0607f4bfcf32d7931b057c180e193a04f28db98eb', 'LA8QK-43571', 'Tháng 4', '<br />\\r\\n<font size=\\\'1\\\'><table class=\\\'xdebug-error xe-warning\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\' cellpadding=\\\'1\\\'>\\r\\n<tr><th align=\\\'left\\\' bgcolor=\\\'#f57900\\\' colspan=\\\"5\\\"><', '<br /><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-warning\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\' cellpadding=\\\'1\\\'><tr><th align=\\\'left\\\' bgcolor=\\\'#f57900\\\' colspan=\\\"5\\\"><span style=\\\'back', '12000000', '2025-05-15 19:42:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_cost` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_in` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_out` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_adr` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `reservations_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reservations`
--

INSERT INTO `reservations` (`id`, `room_id`, `room_number`, `room_cost`, `room_type`, `check_in`, `check_out`, `cust_name`, `cust_id`, `cust_phone`, `cust_email`, `cust_adr`, `status`, `created_at`) VALUES
('24f08bc7fd466976b7a267324fb4803c5b1bbb1532a4201f34', '4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0018', 'PTT002', '125000000', 'Phòng tổng thống', '2025-05-20', '2025-05-21', 'Nguyễn Việt Tùng', '024203014141', '0399045919', 'nguyenviettung@gmail.com', 'Hà Nội', 'Đã thanh toán', '2025-05-15 20:33:13'),
('2b542f5fe32921d047f0026e1b225b5ac400f852ac2037418d', '4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0015', 'DL003', '35000000', 'Phòng deluxe', '2025-05-26', '2025-05-28', 'Dương Văn Minh', '024203014246', '0399045923', 'duongvanminh@gmail.com', 'Hà Nội', 'Pending', '2025-05-15 20:02:30'),
('341300d205e1f917b5f74e21fa64e835aaf303d23d8a6a45e8', '4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0034', 'PH004', '55000000', 'Phòng penthouse', '2025-05-17', '2025-05-19', 'Nguyễn Ngọc Tuyền', '024203013133', '0399045920', 'tt98tuyen@gmail.com', 'Bắc Giang', 'Đã thanh toán', '2025-05-15 19:21:04'),
('3759935e032ea77ffb544e8957b93fda0369b0cf5b7381025a', '4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0022', 'PTT005', '125000000', 'Phòng tổng thống', '2025-05-29', '2025-05-30', 'Nguyễn Văn Dũng', '024203014248', '0399045928', 'nguyenvandung@gmail.com', 'Bắc Giang', 'Pending', '2025-05-15 19:59:18'),
('939e3763594c4d9fee95ca0dd89cca8101bdf78d85e22f0833', 'aab8e6b55f219c44eb0c599fae9b9eb707bb54aec6241a2b9b743db9b0ee0cec924f9ad830f93afde5b3895388314e400d6574e9006f253c9968849d22afaec157732bd9b7af9a547a34b501a2de1b3e69376510339a9976aae63fe74ef78e6', 'PD003', '1200000', 'Phòng đơn', '2025-05-23', '2025-05-25', 'Nguyễn Lý Bằng', '039223014243', '0332045920', 'nguyenlybang@gmail.com', 'Hà Nội', 'Pending', '2025-05-15 20:30:50'),
('a0e15e6ef48f0e7a2ff1f7544fb6c3dc8eeb53ef836b60e79b', '8b06b2f2e0e3a49dab2390265b89ddca05db0c6fac5dacb86be1d75bf1a9b39907fefd9c28a109380acf899628ea19c71667273d02c15fed3dff12477a246f5378da7ebff7a9e62462fb0e2823f1fe010347ac033219046f5b2a7b824afc7b1', 'PĐ004', '8000000', 'Phòng đôi', '2025-05-20', '2025-05-22', 'Vũ Hoàng Long', '024203014249', '0399045929', 'vuhoanglong@gmail.com', 'Thái Bình', 'Đã thanh toán', '2025-05-15 20:06:17'),
('b96507b7303d81f7a6a75c320c6e65f1e380c91e19ea4d7c8a', '1cb9c0741c113696b3f2ac8933e8142e105477591da5bdc2bfe361890ed8075ac164d3a3ad807b60917349951d7029488d98766fa55f348f0f281582b62c87fb830534ad141a23c3c465d2855dbf69a97f4b6b6fd1dbe4bb14f43dc0c92de24', 'PD005', '1200000', 'Phòng đơn', '2025-05-30', '2025-05-31', 'Phạm Duy Yên', '024293914243', '0399002220', 'phamduyyen@gmail.com', 'Bắc Giang', 'Pending', '2025-05-15 20:31:35'),
('c84a39a15613b7c7158a2932e5b3b763406bf619d26a69a1d5', '4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0031', 'PH002', '55000000', 'Phòng penthouse', '2025-05-24', '2025-05-26', 'Hà Văn Quý', '024203014022', '0399049381', 'havanquy@gmail.com', 'Hải Phòng', 'Pending', '2025-05-15 20:05:18'),
('f13da76a7a6266c6e334b96ca669e118fb1747e118a153875b', '4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0023', 'PD008', '1200000', 'Phòng đơn', '2025-05-26', '2025-05-28', 'Hà Thượng Thủy', '024203023413', '0399045999', 'hathuongthuy@gmail.com', 'Thanh Hóa', 'Pending', '2025-05-15 20:30:04'),
('ff08260fc4e60646a8bbcd4c49b5228193de51f03e5510ff52', 'de354046e932fa2569d3877751138de8cb69e973025ac491dc3f4756c91c70fbfdb53739ad6811007111977c2673b9607a39f1936e87b7382a4ee8fe5803d79e89cbcc24a97d7f2d992ce949734a9a5005485a7aeba354c695df70aaf091d01', 'PD006', '1200000', 'Phòng đơn', '2025-05-20', '2025-05-21', 'Nguyễn Văn Hiến', '024203014240', '0399045927', 'nguyenvanhien@gmail.com', 'Hải Dương', 'Đã thanh toán', '2025-05-15 20:32:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `resturants`
--

DROP TABLE IF EXISTS `resturants`;
CREATE TABLE IF NOT EXISTS `resturants` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tables_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_categories` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `resturants_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `rooms_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `number`, `type`, `image`, `price`, `status`, `details`, `created_at`) VALUES
('1cb9c0741c113696b3f2ac8933e8142e105477591da5bdc2bfe361890ed8075ac164d3a3ad807b60917349951d7029488d98766fa55f348f0f281582b62c87fb830534ad141a23c3c465d2855dbf69a97f4b6b6fd1dbe4bb14f43dc0c92de24', 'PD005', 'Phòng đơn', 'Single Hotel Room 1.jpg', '1200000', 'Occupied', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 20:31:35'),
('42bf39a56bbe0d5f94ab34ce72235675e04de38d808a2e4b39e77b0803979d5582693eae91a41ecb52889ee82911681d89c13556ba10a649a48d97aed866fcedae8a5b387e9aa6260f85f7eeacf96e7b090153e30844e59c18b9e65deb9cc19', 'PĐ002', 'Phòng đôi', 'rooms_1.jpg', '8000000', 'Vacant', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:06:10'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0000', 'PĐ003', 'Phòng đôi', 'sidebar.jpg', '8000000', 'Vacant', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:06:30'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0001', 'PĐ009', 'Phòng đôi', 'standard-double-room.jpg', '8000000', 'Vacant', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:12:46'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0002', 'PĐ006', 'Phòng đôi', 'sidebar.jpg', '8000000', 'Trống', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:11:05'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0003', 'PD001', 'Phòng đơn', 'Single Hotel Room 1.jpg', '1200000', 'Trống', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 18:47:47'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0008', 'PD007', 'Phòng đơn', 'Single-room1.jpg', '1200000', 'Vacant', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 18:51:03'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0012', 'PĐ008', 'Phòng đôi', 'standard-double-room.jpg', '8000000', 'Vacant', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:16:31'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0013', 'DL001', 'Phòng deluxe', 'deluxe-king-2.jpg', '35000000', 'Vacant', 'Phòng cao cấp hơn phòng thường, không gian rộng rãi, nội thất hiện đại, có thể kèm ban công hoặc tầm nhìn đẹp, phù hợp cho khách yêu cầu sự thoải mái và tiện nghi.', '2025-05-15 18:56:12'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0014', 'DL002', 'Phòng deluxe', 'room_1.jpg', '35000000', 'Vacant', 'Phòng cao cấp hơn phòng thường, không gian rộng rãi, nội thất hiện đại, có thể kèm ban công hoặc tầm nhìn đẹp, phù hợp cho khách yêu cầu sự thoải mái và tiện nghi.', '2025-05-15 18:56:36'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0015', 'DL003', 'Phòng deluxe', 'room_2.jpg', '35000000', 'Occupied', 'Phòng cao cấp hơn phòng thường, không gian rộng rãi, nội thất hiện đại, có thể kèm ban công hoặc tầm nhìn đẹp, phù hợp cho khách yêu cầu sự thoải mái và tiện nghi.', '2025-05-15 20:02:30'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0016', 'PTT001', 'Phòng tổng thống', 'home.jpg', '125000000', 'Vacant', 'Hạng phòng cao cấp nhất, diện tích lớn, nội thất xa hoa, dịch vụ riêng biệt (như quản gia riêng), thường được lựa chọn bởi nguyên thủ quốc gia, lãnh đạo cấp cao hoặc khách VIP.', '2025-05-15 18:52:44'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0018', 'PTT002', 'Phòng tổng thống', 'offer_5.jpg', '125000000', 'Occupied', 'Hạng phòng cao cấp nhất, diện tích lớn, nội thất xa hoa, dịch vụ riêng biệt (như quản gia riêng), thường được lựa chọn bởi nguyên thủ quốc gia, lãnh đạo cấp cao hoặc khách VIP.', '2025-05-15 20:04:08'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0020', 'PTT003', 'Phòng tổng thống', 'Presidential-suite.jpg', '125000000', 'Vacant', 'Hạng phòng cao cấp nhất, diện tích lớn, nội thất xa hoa, dịch vụ riêng biệt (như quản gia riêng), thường được lựa chọn bởi nguyên thủ quốc gia, lãnh đạo cấp cao hoặc khách VIP.', '2025-05-15 18:53:51'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0021', 'PTT004', 'Phòng tổng thống', 'regular_suites.jpg', '125000000', 'Vacant', 'Hạng phòng cao cấp nhất, diện tích lớn, nội thất xa hoa, dịch vụ riêng biệt (như quản gia riêng), thường được lựa chọn bởi nguyên thủ quốc gia, lãnh đạo cấp cao hoặc khách VIP.', '2025-05-15 18:54:34'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0022', 'PTT005', 'Phòng tổng thống', 'Presidential-suite.jpg', '125000000', 'Occupied', 'Hạng phòng cao cấp nhất, diện tích lớn, nội thất xa hoa, dịch vụ riêng biệt (như quản gia riêng), thường được lựa chọn bởi nguyên thủ quốc gia, lãnh đạo cấp cao hoặc khách VIP.', '2025-05-15 19:59:18'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0023', 'PD008', 'Phòng đơn', 'Single Hotel Room 1.jpg', '1200000', 'Occupied', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 20:30:04'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0024', 'DL004', 'Phòng deluxe', 'room_3.jpg', '35000000', 'Vacant', 'Phòng cao cấp hơn phòng thường, không gian rộng rãi, nội thất hiện đại, có thể kèm ban công hoặc tầm nhìn đẹp, phù hợp cho khách yêu cầu sự thoải mái và tiện nghi.', '2025-05-15 18:57:29'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0026', 'DL005', 'Phòng deluxe', 'deluxe-king-2.jpg', '35000000', 'Vacant', 'Phòng cao cấp hơn phòng thường, không gian rộng rãi, nội thất hiện đại, có thể kèm ban công hoặc tầm nhìn đẹp, phù hợp cho khách yêu cầu sự thoải mái và tiện nghi.', '2025-05-15 18:58:13'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0027', 'DL006', 'Phòng deluxe', 'room_1.jpg', '35000000', 'Vacant', 'Phòng cao cấp hơn phòng thường, không gian rộng rãi, nội thất hiện đại, có thể kèm ban công hoặc tầm nhìn đẹp, phù hợp cho khách yêu cầu sự thoải mái và tiện nghi.', '2025-05-15 18:58:46'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0028', 'DL007', 'Phòng deluxe', 'room_3.jpg', '35000000', 'Vacant', 'Phòng cao cấp hơn phòng thường, không gian rộng rãi, nội thất hiện đại, có thể kèm ban công hoặc tầm nhìn đẹp, phù hợp cho khách yêu cầu sự thoải mái và tiện nghi.', '2025-05-15 18:59:11'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0029', 'PĐ007', 'Phòng đôi', 'room_4.jpg', '8000000', 'Vacant', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:11:52'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0030', 'PH001', 'Phòng penthouse', 'offer_2.jpg', '55000000', 'Vacant', 'Căn hộ cao cấp trên tầng cao nhất, thiết kế sang trọng, thường có nhiều phòng ngủ, phòng khách riêng, và tầm nhìn toàn cảnh, dành cho khách hàng cao cấp hoặc gia đình.', '2025-05-15 19:00:21'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0031', 'PH002', 'Phòng penthouse', 'offer_4.jpg', '55000000', 'Occupied', 'Căn hộ cao cấp trên tầng cao nhất, thiết kế sang trọng, thường có nhiều phòng ngủ, phòng khách riêng, và tầm nhìn toàn cảnh, dành cho khách hàng cao cấp hoặc gia đình.', '2025-05-15 20:05:18'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0032', 'PH003', 'Phòng penthouse', 'penthouse-suite.jpg', '55000000', 'Vacant', 'Căn hộ cao cấp trên tầng cao nhất, thiết kế sang trọng, thường có nhiều phòng ngủ, phòng khách riêng, và tầm nhìn toàn cảnh, dành cho khách hàng cao cấp hoặc gia đình.', '2025-05-15 19:01:11'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0033', 'PT001', 'Phòng thường lớn', 'rooms_2.jpg', '5000000', 'Vacant', 'Phòng tiêu chuẩn với đầy đủ tiện nghi cơ bản như giường ngủ, bàn làm việc, tivi và phòng tắm riêng. Phù hợp với khách lưu trú ngắn hạn, ưu tiên chi phí hợp lý và sự tiện lợi.', '2025-05-15 19:02:47'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0034', 'PH004', 'Phòng penthouse', 'offer_4.jpg', '55000000', 'Occupied', 'Căn hộ cao cấp trên tầng cao nhất, thiết kế sang trọng, thường có nhiều phòng ngủ, phòng khách riêng, và tầm nhìn toàn cảnh, dành cho khách hàng cao cấp hoặc gia đình.', '2025-05-15 19:18:20'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0035', 'PT002', 'Phòng thường lớn', 'offer_3.jpg', '5000000', 'Vacant', 'Phòng tiêu chuẩn với đầy đủ tiện nghi cơ bản như giường ngủ, bàn làm việc, tivi và phòng tắm riêng. Phù hợp với khách lưu trú ngắn hạn, ưu tiên chi phí hợp lý và sự tiện lợi.', '2025-05-15 19:03:10'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0036', 'PT003', 'Phòng thường lớn', 'rooms_2.jpg', '5000000', 'Vacant', 'Phòng tiêu chuẩn với đầy đủ tiện nghi cơ bản như giường ngủ, bàn làm việc, tivi và phòng tắm riêng. Phù hợp với khách lưu trú ngắn hạn, ưu tiên chi phí hợp lý và sự tiện lợi.', '2025-05-15 19:03:28'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0037', 'PT004', 'Phòng thường lớn', 'offer_3.jpg', '5000000', 'Vacant', 'Phòng tiêu chuẩn với đầy đủ tiện nghi cơ bản như giường ngủ, bàn làm việc, tivi và phòng tắm riêng. Phù hợp với khách lưu trú ngắn hạn, ưu tiên chi phí hợp lý và sự tiện lợi.', '2025-05-15 19:03:45'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0038', 'PD009', 'Phòng đơn', 'Single-room1.jpg', '1200000', 'Vacant', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 19:13:36'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0039', 'PT005', 'Phòng thường lớn', 'offer_3.jpg', '5000000', 'Vacant', 'Phòng tiêu chuẩn với đầy đủ tiện nghi cơ bản như giường ngủ, bàn làm việc, tivi và phòng tắm riêng. Phù hợp với khách lưu trú ngắn hạn, ưu tiên chi phí hợp lý và sự tiện lợi.', '2025-05-15 19:04:06'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd0040', 'PĐ001', 'Phòng đôi', 'room_4.jpg', '8000000', 'Vacant', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:05:41'),
('8b06b2f2e0e3a49dab2390265b89ddca05db0c6fac5dacb86be1d75bf1a9b39907fefd9c28a109380acf899628ea19c71667273d02c15fed3dff12477a246f5378da7ebff7a9e62462fb0e2823f1fe010347ac033219046f5b2a7b824afc7b1', 'PĐ004', 'Phòng đôi', 'standard-double-room.jpg', '8000000', 'Occupied', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:58:21'),
('aab8e6b55f219c44eb0c599fae9b9eb707bb54aec6241a2b9b743db9b0ee0cec924f9ad830f93afde5b3895388314e400d6574e9006f253c9968849d22afaec157732bd9b7af9a547a34b501a2de1b3e69376510339a9976aae63fe74ef78e6', 'PD003', 'Phòng đơn', 'Single Hotel Room 1.jpg', '1200000', 'Occupied', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 20:30:50'),
('b6ff834267fd3928e443b85eb3ce049ede61de7f491e06591fb99b0c225a279cd509f2cba6838237a7d580f32e1236689164dd3bdae4974969c7806a49eb9cba13abcc97e521a25004bb517f8501da8244e34f1cb777ed4274a21f07adaab88', 'PD002', 'Phòng đơn', 'Single-room1.jpg', '1200000', 'Vacant', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 18:49:04'),
('cbdaea0daf511218d65548cc8c52b4d99a23d5fe60705c41f1b9b8e47e142beaacb9653ba954dead702a0ac0f2b172922f661709a43287ccafcbfd4315c53f97293a1f2084f2cd718dd2b55a172558935545c03112ed2ef14f4bb7816551329', 'PĐ005', 'Phòng đôi', 'rooms_1.jpg', '8000000', 'Vacant', 'Phòng có 1 giường đôi hoặc 2 giường đơn, phù hợp cho 2 người lớn, thiết kế tiện nghi cơ bản, đáp ứng nhu cầu nghỉ dưỡng tiêu chuẩn.', '2025-05-15 19:07:50'),
('d51dad3cb24f70582ba7416147ede28dee145b3b38', 'PD004', 'Phòng đơn', 'Single Hotel Room 1.jpg', '1200000', 'Vacant', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 18:49:50'),
('de354046e932fa2569d3877751138de8cb69e973025ac491dc3f4756c91c70fbfdb53739ad6811007111977c2673b9607a39f1936e87b7382a4ee8fe5803d79e89cbcc24a97d7f2d992ce949734a9a5005485a7aeba354c695df70aaf091d01', 'PD006', 'Phòng đơn', 'Single Hotel Room 1.jpg', '1200000', 'Occupied', 'Phòng dành cho 1 người, trang bị giường đơn, không gian nhỏ gọn, phù hợp cho khách đi công tác hoặc nghỉ ngắn ngày.', '2025-05-15 20:01:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_service`
--

DROP TABLE IF EXISTS `room_service`;
CREATE TABLE IF NOT EXISTS `room_service` (
  `id` varchar(200) NOT NULL,
  `room_id` varchar(200) NOT NULL,
  `staff_id` varchar(200) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `room_number` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `room_service`
--

INSERT INTO `room_service` (`id`, `room_id`, `staff_id`, `staff_name`, `staff_number`, `room_number`, `created_at`) VALUES
('1522e490fa403c708cdb9ef2663ee5ca02fca5dcff85a41997e2e69fccb20e31601d5df923fbb695671c7e07c4b0979ac9061abcd52b2874383382e5f8d2942981362001ceb520e240ca3754e1d7d43852dd40a0b029a54e53fbf7f4738fc33dec1156ce', '42bf39a56bbe0d5f94ab34ce72235675e04de38d808a2e4b39e77b0803979d5582693eae91a41ecb52889ee82911681d89c13556ba10a649a48d97aed866fcedae8a5b387e9aa6260f85f7eeacf96e7b090153e30844e59c18b9e65deb9cc19', '630877b16604abb4068e93aa67b8b80f9774b72fdb4cecac2930bf9ca1b3d13db3e8516fee8e167904b1c003d4fbfd7f519021497f916e0e74555121f3c4e99a5f95fa9b62e79e9e570e253f3f3a146a91ac85fafc3ce7ff27b6882360b7c9e', 'Irene M. Florence', 'UDIJG-47023', 'MCDQI-45210', '2020-09-25 09:20:51'),
('8a7f228ab50813ca97a7281cfcd40de35f9b6dfed1', '1cb9c0741c113696b3f2ac8933e8142e105477591da5bdc2bfe361890ed8075ac164d3a3ad807b60917349951d7029488d98766fa55f348f0f281582b62c87fb830534ad141a23c3c465d2855dbf69a97f4b6b6fd1dbe4bb14f43dc0c92de24', 'e4f2c219f414223be9f1825ceb1dd81ea4abc0000', 'Staff 000', '7AOQL_0000', 'OTICN-26084', '2021-02-03 08:37:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staffs`
--

DROP TABLE IF EXISTS `staffs`;
CREATE TABLE IF NOT EXISTS `staffs` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adr` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `staffs_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `staffs`
--

INSERT INTO `staffs` (`id`, `name`, `number`, `phone`, `email`, `adr`, `password`, `created_at`) VALUES
('e4f2c219f414223be9f1825ceb1dd81ea4abc0000', 'Nguyễn Ngọc Tuyền', 'NV0001', '0399045920', 'nhanvien001@erp.vn', '34 Dương Lâm, Văn Quán, Hà Đông, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:29:36'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0017', 'Nguyễn Đại Dương', 'NV0002', '0399045921', 'nhanvien002@erp.vn', 'Số 12 Đội Cấn, Phường Ngọc Hà, Ba Đình, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:31:54'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0020', 'Nguyễn Văn Minh', 'NV0003', '0399045922', 'nhanvien003@erp.vn', 'Số 10 Cổ Loa, Xã Cổ Loa, Đông Anh, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:34:24'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0025', 'Trần Thị Hồng Nhung', 'NV0004', '0399045923', 'nhanvien004@erp.vn', 'Số 22 Cao Lỗ, Xã Uy Nỗ, Đông Anh, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:35:01'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0026', 'Lê Hoàng Anh', 'NV0005', '0399045924', 'nhanvien005@erp.vn', 'Số 145 Ngọc Hồi, Thị trấn Văn Điển, Thanh Trì, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:35:40'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0027', 'Đỗ Đức Thịnh', 'NV0006', '0399045925', 'nhanvien006@erp.vn', 'Số 18 Xuân Diệu, Phường Quảng An, Tây Hồ, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:36:21'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0028', 'Bùi Thị Ngọc Lan', 'NV0007', '0399045926', 'nhanvien007@erp.vn', 'Số 5 Nhật Chiêu, Phường Nhật Tân, Tây Hồ, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:36:59'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0029', 'Phạm Minh Tuấn', 'NV0008', '0399045927', 'nhanvien008@erp.vn', 'Số 21 Nguyễn Văn Cừ, Phường Bồ Đề, Long Biên, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:38:01'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0030', 'Lê Thị Mỹ Linh', 'NV0009', '0399045928', 'nhanvien009@erp.vn', 'Số 10 Linh Đường, Phường Hoàng Liệt, Hoàng Mai, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:41:43'),
('e4f2c219f414223be9f1825ceb1dd81ea4abc0031', 'Trương Khánh Linh', 'NV0010', '0373745230', 'nhanvien010@erp.vn', 'Số 19 Trung Kính, Phường Yên Hòa, Cầu Giấy, Hà Nội', '472caccac2eee36913c7b596e5fbb00efd9b9ae9', '2025-05-15 19:41:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE IF NOT EXISTS `system_settings` (
  `sys_id` int NOT NULL AUTO_INCREMENT,
  `sys_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_license` longblob NOT NULL,
  `sys_logo` varchar(200) NOT NULL,
  `sys_tagline` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `welcome_heading` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `welcome_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacts_phone` longtext NOT NULL,
  `contacts_email` longtext NOT NULL,
  `contacts_addres` longtext NOT NULL,
  `social_fb` longtext NOT NULL,
  `social_ig` longtext NOT NULL,
  `social_twitter` longtext NOT NULL,
  `contact_about` longblob NOT NULL,
  PRIMARY KEY (`sys_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `system_settings`
--

INSERT INTO `system_settings` (`sys_id`, `sys_name`, `sys_license`, `sys_logo`, `sys_tagline`, `welcome_heading`, `welcome_content`, `contacts_phone`, `contacts_email`, `contacts_addres`, `social_fb`, `social_ig`, `social_twitter`, `contact_about`) VALUES
(1, 'ERP Hotel NNT', 0x436f70797269676874203230323020204d617274446576656c6f7065727320496e632e20205065726d697373696f6e20697320686572656279206772616e7465642c2066726565206f66206368617267652c20746f20616e7920706572736f6e206f627461696e696e67206120636f7079206f66207468697320736f66747761726520616e64206173736f63696174656420646f63756d656e746174696f6e2066696c657320287468652022536f66747761726522292c20746f206465616c20696e2074686520536f66747761726520776974686f7574207265737472696374696f6e2c20696e636c7564696e6720776974686f7574206c696d69746174696f6e207468652072696768747320746f207573652c20636f70792c206d6f646966792c206d657267652c207075626c6973682c20646973747269627574652c207375626c6963656e73652c20616e642f6f722073656c6c20636f70696573206f662074686520536f6674776172652c20616e6420746f207065726d697420706572736f6e7320746f2077686f6d2074686520536f667477617265206973206675726e697368656420746f20646f20736f2c207375626a65637420746f2074686520666f6c6c6f77696e6720636f6e646974696f6e733a20205468652061626f766520636f70797269676874206e6f7469636520616e642074686973207065726d697373696f6e206e6f74696365207368616c6c20626520696e636c7564656420696e20616c6c20636f70696573206f72207375627374616e7469616c20706f7274696f6e73206f662074686520536f6674776172652e202054484520534f4654574152452049532050524f564944454420224153204953222c20574954484f55542057415252414e5459204f4620414e59204b494e442c2045585052455353204f5220494d504c4945442c20494e434c5544494e4720425554204e4f54204c494d4954454420544f205448452057415252414e54494553204f46204d45524348414e544142494c4954592c204649544e45535320464f52204120504152544943554c415220505552504f534520414e44204e4f4e494e4652494e47454d454e542e20494e204e4f204556454e54205348414c4c2054484520415554484f5253204f5220434f5059524947485420484f4c44455253204245204c4941424c4520464f5220414e5920434c41494d2c2044414d41474553204f52204f54484552204c494142494c4954592c205748455448455220494e20414e20414354494f4e204f4620434f4e54524143542c20544f5254204f52204f54484552574953452c2041524953494e472046524f4d2c204f5554204f46204f5220494e20434f4e4e454354494f4e20574954482054484520534f465457415245204f522054484520555345204f52204f54484552204445414c494e475320494e2054484520534f4654574152452e, '68264b190771d.png', 'Trải nghiệm cuộc sống từng khoảnh khắc', 'Khách sạn tuyệt vời với view biển', 'Chào mừng quý khách đến với ERP HOTEL NNT – nền tảng quản lý khách sạn toàn diện, hiện đại và tối ưu hóa hiệu suất vận hành. Tích hợp thông minh từ lễ tân, buồng phòng đến tài chính và chăm sóc khách hàng, tất cả chỉ trong một hệ thống duy nhất. Vận hành tinh gọn – Bứt phá doanh thu – Dẫn đầu chuyển đổi số cùng ERP HOTEL NNT!', '0399045920', 'tt98tuyen@gmail.com', 'Bao Son, Luc Nam, Bac Giang', 'NNTHotels', '@nnthotels', '@nnt_hotels', 0x45525020484f54454c204e4e54206cc3a0206769e1baa369207068c3a170207068e1baa76e206de1bb816d207175e1baa36e206cc3bd206b68c3a163682073e1baa16e20746fc3a06e206469e1bb876e2c20c491c6b0e1bba363207068c3a17420747269e1bb836e206e68e1bab16d2073e1bb912068c3b36120717579207472c3ac6e682076e1baad6e2068c3a06e682076c3a02074e1bb916920c6b075206869e1bb8775207375e1baa574206b696e6820646f616e682063686f2063c3a163206b68c3a163682073e1baa16e2c207265736f72742c2076c3a020636875e1bb9769206cc6b075207472c3ba2e2056e1bb9b69206769616f206469e1bb876e207468c3a26e20746869e1bb876e2c2063c3b46e67206e6768e1bb87206869e1bb876e20c491e1baa1692076c3a0206b68e1baa3206ec4836e672074c3ad63682068e1bba370206c696e6820686fe1baa1742c2068e1bb87207468e1bb916e67206769c3ba70207175e1baa36e206cc3bd206869e1bb8775207175e1baa32063c3a1632062e1bb99207068e1baad6e206e68c6b0206ce1bb852074c3a26e2c206275e1bb936e67207068c3b26e672c206e68c3a02068c3a06e672c206be1babf20746fc3a16e20e280932074c3a069206368c3ad6e682c206e68c3a26e2073e1bbb12076c3a0206368c4836d2073c3b363206b68c3a163682068c3a06e672e2045525020484f54454c204e4e54206b68c3b46e67206368e1bb89206769c3ba70207469e1babf74206b69e1bb876d207468e1bb9d69206769616e2c20636869207068c3ad206dc3a02063c3b26e206ec3a26e672063616f207472e1baa369206e676869e1bb876d2064e1bb8b63682076e1bba52c2074e1baa16f206ce1bba369207468e1babf2063e1baa16e68207472616e682062e1bb816e2076e1bbaf6e672063686f20646f616e68206e676869e1bb87702074726f6e67206be1bbb7206e677579c3aa6e2073e1bb912e);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vendors`
--

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adr` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `vendors_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
