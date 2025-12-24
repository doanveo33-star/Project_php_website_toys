-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2025 at 11:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websitedochoi`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_code` varchar(50) DEFAULT NULL,
  `receiver` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `delivery_method` varchar(20) DEFAULT 'home',
  `payment_method` varchar(20) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT 0.00,
  `discount_amount` decimal(15,2) DEFAULT 0.00,
  `coupon_code` varchar(100) DEFAULT NULL,
  `transaction_info` varchar(30) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `received_amount` decimal(15,2) DEFAULT 0.00,
  `lack_amount` decimal(15,2) DEFAULT 0.00,
  `user_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `receiver`, `phone`, `address`, `delivery_method`, `payment_method`, `total_amount`, `discount_amount`, `coupon_code`, `transaction_info`, `note`, `created_at`, `received_amount`, `lack_amount`, `user_email`) VALUES
(7, 5, 'HD1765536795', 'nguyễn Công Đoàn', '0398558249', 'fdggf, dfgfggf, dfdjkd', 'home', 'bank_before', 400000.00, 0.00, NULL, 'thanhtoanthieu', 'hfhgh', '2025-12-12 17:53:15', 200000.00, 200000.00, 'dinhanhn6@gmail.com'),
(8, 5, 'HD1765584969', 'nguyễn Công Đoàn', '0398558249', 'fgggd, dfgfggf, sdjs', 'home', 'bank_after', 1200000.00, 0.00, NULL, 'dathanhtoan', 'fgggddfsjyyyuu', '2025-12-13 07:16:10', 1200000.00, 0.00, 'dinhanhn6@gmail.com'),
(9, 5, 'HD1765588365', 'nguyễn Công Đoàn', '0398558249', 'fgggf, dfgfggf, dfdjkd', 'home', 'cod', 1600000.00, 0.00, NULL, 'chothanhtoan', 'ggfgf', '2025-12-13 08:12:45', 0.00, 0.00, 'dinhanhn6@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` varchar(20) DEFAULT NULL,
  `product_id` varchar(50) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `product_type` varchar(100) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `size`, `quantity`, `price`, `sale_price`, `total`, `image`, `product_type`, `product_name`) VALUES
(1, '1', '55', 'masp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(2, '1', '55', 'tensp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(3, '1', '55', 'hinhanh', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(4, '1', '55', 'giaXuat', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(5, '1', '55', 'qty', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(6, '1', '54', 'masp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(7, '1', '54', 'tensp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(8, '1', '54', 'hinhanh', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(9, '1', '54', 'giaXuat', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(10, '1', '54', 'qty', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(11, '2', '55', 'masp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(12, '2', '55', 'tensp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(13, '2', '55', 'hinhanh', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(14, '2', '55', 'giaXuat', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(15, '2', '55', 'qty', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(16, '3', '55', 'masp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(17, '3', '55', 'tensp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(18, '3', '55', 'hinhanh', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(19, '3', '55', 'giaXuat', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(20, '3', '55', 'qty', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(21, '4', '13', 'masp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(22, '4', '13', 'tensp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(23, '4', '13', 'hinhanh', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(24, '4', '13', 'giaXuat', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(25, '4', '13', 'qty', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(26, '5', '60', 'masp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(27, '5', '60', 'tensp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(28, '5', '60', 'hinhanh', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(29, '5', '60', 'giaXuat', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(30, '5', '60', 'giaGoc', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(31, '5', '60', 'discount_p', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(32, '5', '60', 'qty', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(33, '6', '54', 'masp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(34, '6', '54', 'tensp', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(35, '6', '54', 'hinhanh', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(36, '6', '54', 'giaXuat', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(37, '6', '54', 'giaGoc', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(38, '6', '54', 'discount_p', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(39, '6', '54', 'qty', 0, 0.00, NULL, NULL, NULL, NULL, NULL),
(40, '7', '55', NULL, 1, 400000.00, NULL, 400000.00, 'product_1765467658_693ae60adfd0c.webp', NULL, 'đồ chơi máy nuôi thú ảo ngôi nhà chó con bitzee 60'),
(41, '8', '54', NULL, 2, 600000.00, NULL, 1200000.00, 'product_1765467607_693ae5d7cc6ad.webp', NULL, 'đồ chơi slime bánh cupcake slime life 569312-000'),
(42, '9', '17', NULL, 1, 800000.00, NULL, 800000.00, 'product_1765443657_693a88490d3bc.webp', NULL, 'Đồ chơi robot đặc vụ agent 04'),
(43, '9', '58', NULL, 1, 400000.00, NULL, 400000.00, 'product_1765467820_693ae6acdc3bb.webp', NULL, 'đồ chơi thức ăn đổi màu - bánh donut sweet heart b'),
(44, '9', '59', NULL, 1, 400000.00, NULL, 400000.00, 'product_1765467906_693ae702f2647.webp', NULL, 'đồ chơi slime bánh cupcake slime life 569312-000');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(20) DEFAULT 'percent',
  `value` decimal(10,2) DEFAULT 0.00,
  `min_order_amount` decimal(15,2) DEFAULT 0.00,
  `usage_count` int(11) DEFAULT 0,
  `usage_limit` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `name`, `type`, `value`, `min_order_amount`, `usage_count`, `usage_limit`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(4, '01', 'SIÊU SALE GIÁNG SINH', 'percent', 40.00, 200000.00, 0, NULL, '2025-12-11 16:06:00', '2025-12-31 16:06:00', 'active', '2025-12-12 09:06:53'),
(5, '02', 'LEGO XMAS', 'percent', 30.00, 200000.00, 0, NULL, '2025-12-11 16:07:00', '2025-12-31 16:07:00', 'active', '2025-12-12 09:07:34'),
(6, '03', 'CƠ HỘI CUỐI CÙNG THÁNG 12', 'percent', 40.00, 200000.00, 0, NULL, '2025-12-11 16:08:00', '2025-12-31 16:08:00', 'active', '2025-12-12 09:08:24'),
(7, '04', 'CÁC ƯU ĐÃI KHÁC', 'percent', 30.00, 100000.00, 0, NULL, '2025-12-11 16:09:00', '2025-12-22 16:09:00', 'active', '2025-12-12 09:09:08'),
(8, '11', 'Giảm giá 50%', 'percent', 50.00, 100.00, 0, NULL, '2025-12-11 23:23:00', '2025-12-26 23:24:00', 'active', '2025-12-12 16:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `user_name`, `user_email`, `product_id`, `rating`, `comment`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '01', 5, 'Sản phẩm rất tốt, con tôi rất thích! Đóng gói cẩn thận, giao hàng nhanh.', NULL, 'approved', '2025-12-12 15:04:20', '2025-12-12 15:24:06'),
(2, 2, 'Trần Thị B', 'tranthib@gmail.com', '02', 4, 'Đồ chơi chất lượng cao, giá cả hợp lý. Sẽ mua thêm lần sau.', NULL, 'approved', '2025-12-12 15:04:20', '2025-12-12 15:24:07'),
(3, 3, 'Lê Văn C', 'levanc@gmail.com', '03', 5, 'Tuyệt vời! Shop uy tín, sản phẩm đúng mô tả. Highly recommend!', NULL, 'approved', '2025-12-12 15:04:20', '2025-12-12 15:24:09'),
(4, 3, 'Tạ Văn Hội', 'chitogelovehoi@gmail.com', '46', 5, 'ok', 'review_1765527248_693bced094676.png', 'approved', '2025-12-12 15:14:08', '2025-12-12 15:15:59'),
(5, 5, 'Đoàn', 'dinhanhn6@gmail.com', '09', 5, 'quán xịn', NULL, 'approved', '2025-12-12 22:42:25', '2025-12-12 22:42:35'),
(6, 5, 'Đoàn', 'dinhanhn6@gmail.com', '46', 5, 'sdjksdkj', NULL, 'approved', '2025-12-13 08:14:08', '2025-12-13 08:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `tblloaisp`
--

CREATE TABLE `tblloaisp` (
  `maLoaiSP` varchar(50) NOT NULL,
  `tenLoaiSP` varchar(100) NOT NULL,
  `moTaLoaiSP` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblloaisp`
--

INSERT INTO `tblloaisp` (`maLoaiSP`, `tenLoaiSP`, `moTaLoaiSP`) VALUES
('BoardGame', 'Board Game', 'Trò chơi bàn cờ, thẻ bài'),
('BupBe', 'Búp bê & Phụ kiện', 'Búp bê, nhà búp bê, phụ kiện'),
('DoChoiLapGhep', 'Đồ chơi lắp ghép', 'Đồ chơi để lắp ghép'),
('ĐocQuyenOnline', 'Độc Quyền Online', 'Độc quyền khi mua Online'),
('GiaoDuc', 'Đồ chơi giáo dục', 'Đồ chơi phát triển trí tuệ'),
('LEGO1', 'LEGO Bé Trai ', 'Cho bé trai nhỏ tuổi '),
('LEGO2', 'LEGO Bé Gái ', 'Cho bé gái nhỏ tuổi '),
('LEGO3', 'LEGO Bé Mầm Non', 'Cho trẻ mầm non'),
('LEGO4', 'LEGO Người Lớn', 'Cho người lớn'),
('NgoaiTroi', 'Đồ chơi ngoài trời', 'Đồ chơi vận động, thể thao'),
('NhoiBong', 'Đồ chơi nhồi bông', 'Gấu bông, thú nhồi bông'),
('Robot', 'Robot & Điều khiển', 'Robot, xe điều khiển từ xa'),
('SanPhamMoi', 'Hàng Mới', 'Sản Phẩm Mới Nhất');

-- --------------------------------------------------------

--
-- Table structure for table `tblsanpham`
--

CREATE TABLE `tblsanpham` (
  `maLoaiSP` varchar(50) NOT NULL,
  `masp` varchar(20) NOT NULL,
  `tensp` varchar(50) NOT NULL,
  `hinhanh` varchar(50) DEFAULT NULL,
  `soluong` int(11) NOT NULL DEFAULT 0,
  `giaNhap` decimal(15,0) DEFAULT 0,
  `giaXuat` decimal(15,0) DEFAULT 0,
  `doTuoi` varchar(50) DEFAULT NULL,
  `mota` varchar(200) DEFAULT NULL,
  `createDate` date DEFAULT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsanpham`
--

INSERT INTO `tblsanpham` (`maLoaiSP`, `masp`, `tensp`, `hinhanh`, `soluong`, `giaNhap`, `giaXuat`, `doTuoi`, `mota`, `createDate`, `promotion_id`, `discount_percent`) VALUES
('DoChoiLapGhep', '01', 'đồ chơi lắp ráp siêu xe ferrairi v29', 'product_1765442042_693a81fa9eb57.webp', 50, 400000, 1000000, '6+', 'đồ chơi lắp ráp siêu xe ferrairi v29', '2025-12-11', NULL, NULL),
('DoChoiLapGhep', '02', 'đồ chơi lắp ráp xe thể thao koenigsegg-jesko', 'product_1765442302_693a82fee820a.webp', 40, 400000, 900000, '6+', 'đồ chơi lắp ráp xe thể thao koenigsegg-jesko', '2025-12-11', NULL, NULL),
('DoChoiLapGhep', '03', 'đồ chơi lắp ráp thùng gạch sáng tạo', 'product_1765442357_693a8335539d2.webp', 30, 300000, 800000, '6+', 'đồ chơi lắp ráp thùng gạch sáng tạo', '2025-12-11', NULL, NULL),
('DoChoiLapGhep', '04', 'Đồ chơi lắp ráp chậu cây vui vẻ', 'product_1765442425_693a83790f7e5.webp', 50, 300000, 700000, '6+', 'Đồ chơi lắp ráp chậu cây vui vẻ', '2025-12-11', NULL, NULL),
('DoChoiLapGhep', '05', 'đồ chơi lắp ráp rồng bạc', 'product_1765442469_693a83a54b9fa.webp', 35, 400000, 800000, '8+', 'đồ chơi lắp ráp rồng bạc', '2025-12-11', NULL, NULL),
('DoChoiLapGhep', '06', 'đồ chơi lắp ráp hoa dâm bụt', 'product_1765442542_693a83eecd9de.webp', 40, 250000, 500000, '4+', 'đồ chơi lắp ráp hoa dâm bụt', '2025-12-11', NULL, NULL),
('BoardGame', '07', 'Trò chơi caro 4 in a row', 'product_1765442806_693a84f681a6f.webp', 25, 50000, 125000, '8+', 'Trò chơi caro 4 in a row', '2025-12-11', NULL, NULL),
('BoardGame', '08', 'Cá ngựa', 'product_1765442839_693a85171d76a.webp', 15, 40000, 100000, '8+', 'Cá ngựa', '2025-12-11', NULL, NULL),
('BoardGame', '09', 'Bài uno', 'product_1765442877_693a853d747ee.webp', 35, 45000, 120000, '8+', 'Bài uno', '2025-12-11', NULL, NULL),
('BoardGame', '10', 'Cờ vua', 'product_1765442917_693a8565da5d6.webp', 30, 35000, 120000, '10+', 'Cờ vua', '2025-12-11', NULL, NULL),
('BoardGame', '11', 'Cờ tỉ phú', 'product_1765442967_693a85979e0d7.webp', 20, 200000, 500000, '8+', 'Cờ tỉ phú', '2025-12-11', NULL, NULL),
('Robot', '17', 'Đồ chơi robot đặc vụ agent 04', 'product_1765443657_693a88490d3bc.webp', 19, 400000, 800000, '10+', 'Đồ chơi robot đặc vụ agent 04', '2025-12-11', NULL, NULL),
('Robot', '18', 'Đồ chơi robot mèo puffy mũm mĩm', 'product_1765443732_693a8894d8dd1.webp', 20, 150000, 300000, '8+', 'Đồ chơi robot mèo puffy mũm mĩm', '2025-12-11', NULL, NULL),
('BupBe', '19', 'Bộ vòng tay nút thắt tình bạn sắc màu MAKE IT REAL', 'product_1765445133_693a8e0d3183c.webp', 20, 15000, 30000, '5+', 'Mới', '2025-12-11', NULL, NULL),
('Robot', '20', 'đồ chơi robot tự động cleverbot thông thái vecto v', 'product_1765445300_693a8eb458e50.webp', 17, 200000, 300000, '14+', 'đẹp', '2025-12-11', NULL, NULL),
('Robot', '21', 'đồ chơi robot tự động bọ hung giận dữ vecto vt9903', 'product_1765445360_693a8ef063567.webp', 18, 100000, 300000, '16+', 'hay', '2025-12-11', NULL, NULL),
('Robot', '22', 'robot-chi-huy-captain-commander-bien-hinh-xe-conta', 'product_1765445465_693a8f59f2ea9.webp', 10, 1000000, 1500000, '14+', 'đắt', '2025-12-11', NULL, NULL),
('BupBe', '23', 'búp bê decora 11 inch - decora d1005', 'product_1765445683_693a9033561c4.webp', 18, 300000, 500000, '10+', 'điệu', '2025-12-11', NULL, NULL),
('BupBe', '24', 'búp bê decora 11 inch - luna d1006', 'product_1765445726_693a905ed0038.webp', 15, 300000, 500000, '10+', 'hay', '2025-12-11', NULL, NULL),
('BupBe', '25', 'búp bê 29cm nàng tiên dreameez 81038dre', 'product_1765445802_693a90aa7a2e9.webp', 12, 130000, 230000, '10+', 'cũ', '2025-12-11', NULL, NULL),
('BupBe', '26', 'búp bê baby bập bẹ dollsworld dw60280', 'product_1765445864_693a90e8a3bf0.webp', 16, 300000, 600000, '8+', 'dễ thương', '2025-12-11', NULL, NULL),
('GiaoDuc', '27', 'Đồ chơi đàn piano mèo con b.brand bx1025z', 'product_1765446289_693a92910c9a1.webp', 12, 40000, 100000, '4+', 'tốt', '2025-12-11', NULL, NULL),
('GiaoDuc', '28', 'Đồ chơi điện thoại quay số FISHER PRICE MATTEL FGW', 'product_1765446355_693a92d3abd1a.webp', 12, 30000, 100000, '8+', 'tốt', '2025-12-11', NULL, NULL),
('GiaoDuc', '29', 'đồ chơi chú voi âm nhạc vui nhộn winfun 230202', 'product_1765446409_693a93099d704.webp', 15, 60000, 120000, '14+', 'hay', '2025-12-11', NULL, NULL),
('GiaoDuc', '30', 'Đồ chơi thả khối và chong chóng sắc màu peek a boo', 'product_1765446474_693a934a8de0a.webp', 19, 70000, 140000, '16+', 'đẹp', '2025-12-11', NULL, NULL),
('GiaoDuc', '31', 'đồ chơi nút bật rèn luyện tay-mắt cho bé peek a bo', 'product_1765446536_693a938802a09.webp', 15, 30000, 60000, '14+', 'tốt cho mắt', '2025-12-11', NULL, NULL),
('NhoiBong', '32', 'thú nhồi bông catnap poppy playtime cp7751', 'product_1765446687_693a941fc9fe4.webp', 10, 50000, 100000, '10+', 'xịn', '2025-12-11', NULL, NULL),
('NhoiBong', '33', 'thú nhồi bông craftycorn poppy playtime cp7753', 'product_1765446728_693a944836aee.webp', 10, 50000, 100000, '14+', 'cịn', '2025-12-11', NULL, NULL),
('NhoiBong', '34', 'thú nhồi bông dogday poppy playtime cp7752', 'product_1765446780_693a947c49676.webp', 10, 40000, 80000, '14+', 'hay', '2025-12-11', NULL, NULL),
('NhoiBong', '35', 'móc khoá nhồi bông kimmon mimon plush toy 556005km', 'product_1765446828_693a94accba0d.webp', 12, 30000, 60000, '10+', 'hay ho', '2025-12-11', NULL, NULL),
('NhoiBong', '36', 'đồ chơi nhồi bông 7.5 inch silvina squishmallows s', 'product_1765446871_693a94d765e29.webp', 10, 20000, 50000, '6+', 'có lương tâm', '2025-12-11', NULL, NULL),
('NgoaiTroi', '37', 'đồ chơi bóng nảy siêu đàn hồi marvel - captain ame', 'product_1765447018_693a956a672e1.webp', 4, 50000, 500000, '8+', 'căng', '2025-12-11', NULL, NULL),
('NgoaiTroi', '38', 'đồ chơi bóng nảy siêu đàn hồi marvel – iron man eo', 'product_1765447059_693a95930c62e.webp', 6, 50000, 500000, '6+', 'tròn', '2025-12-11', NULL, NULL),
('NgoaiTroi', '39', 'đồ chơi phun nước vô địch 1000ml xshot x56221', 'product_1765447109_693a95c5070ad.webp', 26, 50000, 300000, '14+', 'dài', '2025-12-11', NULL, NULL),
('NgoaiTroi', '40', 'đồ chơi ném bong bóng nước siêu cấp vui nhộn xshot', 'product_1765447163_693a95fbd737c.webp', 17, 40000, 160000, '14+', 'to', '2025-12-11', NULL, NULL),
('NgoaiTroi', '41', 'đồ chơi phun nước vui nhộn xshot 170ml (2022 ver.)', 'product_1765447218_693a96329524c.webp', 39, 200000, 500000, '16+', 'tốn', '2025-12-11', NULL, NULL),
('LEGO1', '42', 'Đồ chơi lắp ráp rồng con', 'product_1765480183_693b16f7f0eac.webp', 20, 250000, 500000, '8+', 'Đồ chơi lắp ráp rồng con', '2025-12-11', NULL, NULL),
('LEGO1', '43', 'Đồ chơi lắp ráp máy bay', 'product_1765480197_693b1705c669a.webp', 24, 150000, 450000, '8+', 'Đồ chơi lắp ráp máy bay', '2025-12-11', NULL, NULL),
('LEGO1', '44', 'Xe cảnh sát', 'product_1765480207_693b170f314b8.webp', 50, 150000, 300000, '8+', 'Xe cảnh sát', '2025-12-11', NULL, NULL),
('LEGO1', '45', 'Chiến giáp zane', 'product_1765480217_693b1719e811e.webp', 25, 300000, 600000, '8+', 'Chiến giáp zane', '2025-12-11', NULL, NULL),
('LEGO1', '46', 'Bộ sưu tập xe đua f1', 'product_1765467497_693ae569a48ab.jpg', 25, 250000, 500000, '8+', 'Bộ sưu tập xe đua f1', '2025-12-11', NULL, NULL),
('LEGO1', '47', 'Robot chiến đấu', 'product_1765467474_693ae5527d4f3.jpg', 20, 400000, 900000, '8+', 'Robot chiến đấu', '2025-12-11', NULL, NULL),
('SanPhamMoi', '48', 'đồ chơi mô hình saga khủng long có âm thanh abelis', 'product_1765467000_693ae3783ec9a.webp', 10, 290000, 500000, '10+', 'Mô hình', '2025-12-11', NULL, NULL),
('SanPhamMoi', '49', 'đồ chơi máy nuôi thú ảo ngôi nhà chó con', 'product_1765467059_693ae3b3cb2eb.webp', 10, 40000, 400000, '10+', 'Giáo dục', '2025-12-11', NULL, NULL),
('SanPhamMoi', '50', 'đồ chơi bộ làm bánh kẹp kẹo dẻo slime life', 'product_1765467201_693ae4416bdcd.webp', 10, 100000, 150000, '10+', 'mới', '2025-12-11', NULL, NULL),
('SanPhamMoi', '51', 'đồ chơi lắp ráp interactive mario & xe tiêu chuẩn ', 'product_1765467252_693ae474ab665.webp', 10, 230000, 400000, '10+', 'mới', '2025-12-11', NULL, NULL),
('SanPhamMoi', '52', 'đồ chơi thức ăn đổi màu - bánh donut sweet heart b', 'product_1765467304_693ae4a8a8728.webp', 19, 200000, 300000, '10+', 'mới', '2025-12-11', NULL, NULL),
('SanPhamMoi', '53', 'đồ chơi slime bánh cupcake slime life 569312-000', 'product_1765467372_693ae4ec13f67.webp', 10, 100000, 200000, '10+', 'mới', '2025-12-11', NULL, NULL),
('ĐocQuyenOnline', '54', 'đồ chơi slime bánh cupcake slime life 569312-000', 'product_1765467607_693ae5d7cc6ad.webp', 6, 120000, 600000, '10+', 'độc quyền', '2025-12-11', NULL, NULL),
('ĐocQuyenOnline', '55', 'đồ chơi máy nuôi thú ảo ngôi nhà chó con bitzee 60', 'product_1765467658_693ae60adfd0c.webp', 8, 300000, 400000, '6+', 'Độc quyền', '2025-12-11', NULL, NULL),
('ĐocQuyenOnline', '56', 'đồ chơi lắp ráp interactive mario & xe tiêu chuẩn ', 'product_1765467713_693ae6417e46a.webp', 10, 190000, 290000, '4+', 'Đqq', '2025-12-11', NULL, NULL),
('ĐocQuyenOnline', '57', 'đồ chơi mô hình saga khủng long có âm thanh abelis', 'product_1765467753_693ae66995c1f.webp', 100, 100000, 200000, '6+', 'đq', '2025-12-11', NULL, NULL),
('ĐocQuyenOnline', '58', 'đồ chơi thức ăn đổi màu - bánh donut sweet heart b', 'product_1765467820_693ae6acdc3bb.webp', 9, 300000, 400000, '6+', 'đqq', '2025-12-11', NULL, NULL),
('ĐocQuyenOnline', '59', 'đồ chơi slime bánh cupcake slime life 569312-000', 'product_1765467906_693ae702f2647.webp', 9, 200000, 400000, '12+', 'Đq', '2025-12-11', NULL, NULL),
('ĐocQuyenOnline', '60', 'Khung Long Bạo Chúa', 'product_1765467980_693ae74c38236.jpg', 10, 80000, 300000, '5+', 'hay', '2025-12-11', NULL, NULL),
('LEGO2', '61', 'đồ chơi lắp ráp tiệm cà phê thành phố heartlake le', 'product_1765468193_693ae82130417.webp', 10, 200000, 400000, '5+', 'gái', '2025-12-11', NULL, NULL),
('LEGO2', '62', 'đồ chơi lắp ráp hoa hồng lego® lego botanicals 404', 'product_1765468253_693ae85db6b00.webp', 10, 340000, 540000, '10+', 'gái', '2025-12-11', NULL, NULL),
('LEGO2', '63', 'đồ chơi lắp ráp kỳ lân sắc màu lego creator 31140', 'product_1765468300_693ae88c253d0.webp', 10, 37000, 70000, '5+', 'tfhfh', '2025-12-11', NULL, NULL),
('LEGO2', '64', 'đồ chơi lắp ráp ngôi nhà bóng bay up lego disney p', 'product_1765468620_693ae9cc4481e.webp', 10, 300000, 500000, '14+', 'dfdgf', '2025-12-11', NULL, NULL),
('LEGO2', '65', 'đồ chơi lắp ráp quầy kẹo bông gòn di động và xe sc', 'product_1765468697_693aea19b0ca1.webp', 10, 100000, 300000, '10+', 'fddgdgf', '2025-12-11', NULL, NULL),
('LEGO2', '66', 'đồ chơi lắp ráp căn phòng của paisley lego friends', 'product_1765468760_693aea582223c.webp', 10, 100000, 299999300000, '8+', 'đồ chơi lắp ráp căn phòng của paisley lego friends 42647', '2025-12-11', NULL, NULL),
('LEGO3', '67', 'đồ chơi lắp ráp bộ gạch chi tiết', 'product_1765468924_693aeafcdfe97.jpg', 10, 100000, 200000, '6+', 'đồ chơi lắp ráp bộ gạch chi tiết', '2025-12-11', NULL, NULL),
('LEGO3', '68', 'đồ chơi lắp ráp bộ gạch chi tiết', 'product_1765468964_693aeb243a274.jpg', 30, 300000, 400000, '1+', 'dssgf', '2025-12-11', NULL, NULL),
('LEGO3', '69', 'đồ chơi lắp ráp bộ gạch chi tiết', 'product_1765469014_693aeb5602757.jpg', 40, 100000, 300000, '4+', 'đồ chơi lắp ráp bộ gạch chi tiết', '2025-12-11', NULL, NULL),
('LEGO3', '70', 'đồ chơi lắp ráp bộ gạch chi tiết', 'product_1765469048_693aeb78a818d.jpg', 10, 200000, 500000, '4+', 'đồ chơi lắp ráp bộ gạch chi tiết', '2025-12-11', NULL, NULL),
('LEGO3', '71', 'đồ chơi lắp ráp bộ gạch chi tiết', 'product_1765469082_693aeb9a5d9f1.jpg', 80, 200000, 400000, '6+', 'đồ chơi lắp ráp bộ gạch chi tiết', '2025-12-11', NULL, NULL),
('LEGO3', '72', 'đồ chơi lắp ráp bộ gạch chi tiết', 'product_1765469148_693aebdc772f8.jpg', 10, 130000, 330000, '4+', 'sdsggfd', '2025-12-11', NULL, NULL),
('LEGO4', '73', 'đồ chơi lắp ráp siêu xe mclaren f1 lego speed cham', 'product_1765469658_693aedda7cb73.webp', 10, 100000, 100000, '16+', 'đồ chơi lắp ráp siêu xe mclaren f1 lego speed champions 76919 (245 chi tiết)', '2025-12-11', NULL, NULL),
('LEGO4', '74', 'đồ chơi lắp ráp xe đua mercedes f1 lego technic 42', 'product_1765469700_693aee0451441.webp', 10, 300000, 400000, '16+', 'đồ chơi lắp ráp xe đua mercedes f1 lego technic 42165', '2025-12-11', NULL, NULL),
('LEGO4', '75', 'đồ chơi lắp ráp xe đua oracle red bull rb20 f1 leg', 'product_1765469749_693aee3590e15.webp', 10, 200000, 600000, '16+', 'đồ chơi lắp ráp xe đua oracle red bull rb20 f1 lego speed champions 77243', '2025-12-11', NULL, NULL),
('LEGO4', '76', 'đồ chơi lắp ráp siêu xe mclaren f1 lego speed cham', 'product_1765469796_693aee64cd69b.webp', 10, 340000, 500000, '16+', 'đồ chơi lắp ráp siêu xe mclaren f1 lego speed champions 76919 (245 chi tiết)', '2025-12-11', NULL, NULL),
('LEGO4', '77', 'đồ chơi lắp ráp xe thể thao koenigsegg jesko absol', 'product_1765469853_693aee9d169d2.webp', 10, 112000, 400000, '16+', 'đồ chơi lắp ráp xe thể thao koenigsegg jesko absolut màu xám lego technic 42173 (801 chi', '2025-12-11', NULL, NULL),
('LEGO4', '78', 'đồ chơi lắp ráp siêu xe lamborghini huracán tecnic', 'product_1765469901_693aeecd56bf0.webp', 10, 1000000, 3000000, '16+', 'đồ chơi lắp ráp siêu xe lamborghini huracán tecnica lego technic 42161', '2025-12-11', NULL, NULL),
('Robot', '80', 'Robot cảnh sát tuần tra', 'product_1765531373_693bdeed4575c.webp', 50, 400000, 850000, '6+', 'Robot cảnh sát tuần tra', '2025-12-12', 6, 40),
('LEGO1', '81', 'Đồ chơi lắp ráp rồng trung cổ', 'product_1765531482_693bdf5aa00a3.webp', 20, 1000000, 1500000, '8+', 'Đồ chơi lắp ráp rồng trung cổ', '2025-12-12', 5, 30),
('BupBe', '82', 'Đồ chơi trang điểm khổng lồ frozen', 'product_1765531575_693bdfb7aeaab.webp', 15, 400000, 800000, '6+', 'Đồ chơi trang điểm khổng lồ', '2025-12-12', 7, 30);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_token` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`user_id`, `fullname`, `email`, `password`, `is_verified`, `verification_token`, `created_at`, `role`) VALUES
(1, 'Admin ToyShop', 'admin@toyshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, '2025-12-11 13:33:39', 'admin'),
(2, 'Tạ Văn Hội', 'hoilovedtl2307@gmail.com', '$2y$10$ANelAPAZnGZFwA6QxR/Wiugb7Yo7kNTf37kij4kd.BlwirghuClyG', 0, NULL, '2025-12-11 14:21:56', 'user'),
(3, 'Tạ Văn Hội', 'chitogelovehoi@gmail.com', '$2y$10$yI4QyC5Qm.nnV/SfU/6cMOKfdMmuwPRnbYriV/31o9I3DZHvIWCXS', 1, NULL, '2025-12-11 14:37:07', 'user'),
(4, 'nguyendoan', 'doanveo33@gmail.com', '$2y$10$daBbWMGGPxsyv83nkIgdUOq4Y7qweveoMfHmzcccqULkY6xp8RHDi', 1, NULL, '2025-12-11 16:10:49', 'admin'),
(5, 'Đoàn', 'dinhanhn6@gmail.com', '$2y$10$w9JmGbhYgPcQ0nDrms7txOcOGl7mzCDRa6X16KJzpfrXsFRKhrBW.', 1, NULL, '2025-12-12 17:45:05', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblloaisp`
--
ALTER TABLE `tblloaisp`
  ADD PRIMARY KEY (`maLoaiSP`);

--
-- Indexes for table `tblsanpham`
--
ALTER TABLE `tblsanpham`
  ADD PRIMARY KEY (`masp`),
  ADD KEY `maLoaiSP` (`maLoaiSP`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `tblsanpham`
--
ALTER TABLE `tblsanpham`
  ADD CONSTRAINT `tblsanpham_ibfk_1` FOREIGN KEY (`maLoaiSP`) REFERENCES `tblloaisp` (`maLoaiSP`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
