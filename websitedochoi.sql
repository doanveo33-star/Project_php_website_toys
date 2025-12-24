-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 11, 2025 lúc 10:05 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `websitedochoi`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percent','fixed') DEFAULT 'percent',
  `discount_value` decimal(15,2) NOT NULL,
  `min_order_amount` decimal(15,2) DEFAULT 0.00,
  `max_discount` decimal(15,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `discount_type`, `discount_value`, `min_order_amount`, `max_discount`, `usage_limit`, `used_count`, `start_date`, `end_date`, `is_active`, `created_at`) VALUES
(1, 'TOYSHOP10', 'percent', 10.00, 500000.00, 100000.00, 100, 0, '2025-12-11', '2026-01-10', 1, '2025-12-11 13:33:39'),
(2, 'FREESHIP', 'fixed', 30000.00, 300000.00, NULL, 50, 0, '2025-12-11', '2026-01-10', 1, '2025-12-11 13:33:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` varchar(50) DEFAULT NULL,
  `rating` int(11) DEFAULT 5,
  `comment` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblloaisp`
--

CREATE TABLE `tblloaisp` (
  `maLoaiSP` varchar(50) NOT NULL,
  `tenLoaiSP` varchar(100) NOT NULL,
  `moTaLoaiSP` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tblloaisp`
--

INSERT INTO `tblloaisp` (`maLoaiSP`, `tenLoaiSP`, `moTaLoaiSP`) VALUES
('BoardGame', 'Board Game', 'Trò chơi bàn cờ, thẻ bài'),
('BupBe', 'Búp bê & Phụ kiện', 'Búp bê, nhà búp bê, phụ kiện'),
('DoChoiLapGhep', 'Đồ chơi lắp ghép', 'Đồ chơi để lắp ghép'),
('GiaoDuc', 'Đồ chơi giáo dục', 'Đồ chơi phát triển trí tuệ'),
('LEGO', 'Đồ chơi LEGO', 'Các bộ xếp hình LEGO chính hãng'),
('NgoaiTroi', 'Đồ chơi ngoài trời', 'Đồ chơi vận động, thể thao'),
('NhoiBong', 'Đồ chơi nhồi bông', 'Gấu bông, thú nhồi bông'),
('Robot', 'Robot & Điều khiển', 'Robot, xe điều khiển từ xa'),
('XeMoHinh', 'Xe mô hình', 'Xe ô tô, máy bay, tàu mô hình');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tblsanpham`
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
  `createDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tblsanpham`
--

INSERT INTO `tblsanpham` (`maLoaiSP`, `masp`, `tensp`, `hinhanh`, `soluong`, `giaNhap`, `giaXuat`, `doTuoi`, `mota`, `createDate`) VALUES
('DoChoiLapGhep', '01', 'đồ chơi lắp ráp siêu xe ferrairi v29', 'product_1765442042_693a81fa9eb57.webp', 50, 400000, 1000000, '6+', 'đồ chơi lắp ráp siêu xe ferrairi v29', '2025-12-11'),
('DoChoiLapGhep', '02', 'đồ chơi lắp ráp xe thể thao koenigsegg-jesko', 'product_1765442302_693a82fee820a.webp', 40, 400000, 900000, '6+', 'đồ chơi lắp ráp xe thể thao koenigsegg-jesko', '2025-12-11'),
('DoChoiLapGhep', '03', 'đồ chơi lắp ráp thùng gạch sáng tạo', 'product_1765442357_693a8335539d2.webp', 30, 300000, 800000, '6+', 'đồ chơi lắp ráp thùng gạch sáng tạo', '2025-12-11'),
('DoChoiLapGhep', '04', 'Đồ chơi lắp ráp chậu cây vui vẻ', 'product_1765442425_693a83790f7e5.webp', 50, 300000, 700000, '6+', 'Đồ chơi lắp ráp chậu cây vui vẻ', '2025-12-11'),
('DoChoiLapGhep', '05', 'đồ chơi lắp ráp rồng bạc', 'product_1765442469_693a83a54b9fa.webp', 35, 400000, 800000, '8+', 'đồ chơi lắp ráp rồng bạc', '2025-12-11'),
('DoChoiLapGhep', '06', 'đồ chơi lắp ráp hoa dâm bụt', 'product_1765442542_693a83eecd9de.webp', 40, 250000, 500000, '4+', 'đồ chơi lắp ráp hoa dâm bụt', '2025-12-11'),
('BoardGame', '07', 'Trò chơi caro 4 in a row', 'product_1765442806_693a84f681a6f.webp', 25, 50000, 125000, '8+', 'Trò chơi caro 4 in a row', '2025-12-11'),
('BoardGame', '08', 'Cá ngựa', 'product_1765442839_693a85171d76a.webp', 15, 40000, 100000, '8+', 'Cá ngựa', '2025-12-11'),
('BoardGame', '09', 'Bài uno', 'product_1765442877_693a853d747ee.webp', 35, 45000, 120000, '8+', 'Bài uno', '2025-12-11'),
('BoardGame', '10', 'Cờ vua', 'product_1765442917_693a8565da5d6.webp', 30, 35000, 120000, '10+', 'Cờ vua', '2025-12-11'),
('BoardGame', '11', 'Cờ tỉ phú', 'product_1765442967_693a85979e0d7.webp', 20, 200000, 500000, '8+', 'Cờ tỉ phú', '2025-12-11'),
('XeMoHinh', '12', 'Mô hình xe cần cẩu', 'product_1765443233_693a86a138f36.webp', 25, 100000, 220000, '4+', 'mô hình xe cần cẩu', '2025-12-11'),
('XeMoHinh', '13', 'Xe đua f1 red bull racing', 'product_1765443290_693a86da112b3.webp', 100, 200000, 450000, '5+', 'Xe đua f1 red bull racing', '2025-12-11'),
('XeMoHinh', '14', 'Xe đua đổi màu', 'product_1765443352_693a87183b7e0.webp', 10, 75000, 150000, '4+', 'Xe đua đổi màu', '2025-12-11'),
('XeMoHinh', '15', 'Mô hình tàu', 'product_1765443388_693a873cb02d0.webp', 25, 300000, 700000, '5+', 'Mô hình tàu', '2025-12-11'),
('XeMoHinh', '16', 'Mô hình cần cẩu', 'product_1765443429_693a87658a2cc.webp', 24, 100000, 250000, '5+', 'Mô hình cần cẩu', '2025-12-11'),
('Robot', '17', 'Đồ chơi robot đặc vụ agent 04', 'product_1765443657_693a88490d3bc.webp', 20, 400000, 800000, '10+', 'Đồ chơi robot đặc vụ agent 04', '2025-12-11'),
('Robot', '18', 'Đồ chơi robot mèo puffy mũm mĩm', 'product_1765443732_693a8894d8dd1.webp', 20, 150000, 300000, '8+', 'Đồ chơi robot mèo puffy mũm mĩm', '2025-12-11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbluser`
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
-- Đang đổ dữ liệu cho bảng `tbluser`
--

INSERT INTO `tbluser` (`user_id`, `fullname`, `email`, `password`, `is_verified`, `verification_token`, `created_at`, `role`) VALUES
(1, 'Admin ToyShop', 'admin@toyshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, '2025-12-11 13:33:39', 'admin'),
(2, 'Tạ Văn Hội', 'hoilovedtl2307@gmail.com', '$2y$10$ANelAPAZnGZFwA6QxR/Wiugb7Yo7kNTf37kij4kd.BlwirghuClyG', 0, NULL, '2025-12-11 14:21:56', 'user'),
(3, 'Tạ Văn Hội', 'chitogelovehoi@gmail.com', '$2y$10$yI4QyC5Qm.nnV/SfU/6cMOKfdMmuwPRnbYriV/31o9I3DZHvIWCXS', 1, NULL, '2025-12-11 14:37:07', 'admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `tblloaisp`
--
ALTER TABLE `tblloaisp`
  ADD PRIMARY KEY (`maLoaiSP`);

--
-- Chỉ mục cho bảng `tblsanpham`
--
ALTER TABLE `tblsanpham`
  ADD PRIMARY KEY (`masp`),
  ADD KEY `maLoaiSP` (`maLoaiSP`);

--
-- Chỉ mục cho bảng `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`user_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`user_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `tblsanpham`
--
ALTER TABLE `tblsanpham`
  ADD CONSTRAINT `tblsanpham_ibfk_1` FOREIGN KEY (`maLoaiSP`) REFERENCES `tblloaisp` (`maLoaiSP`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
