-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 11, 2025 lúc 12:11 PM
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
('LEGO1', 'LEGO Bé Trai ', 'Cho bé trai nhỏ tuổi '),
('LEGO2', 'LEGO Bé Gái ', 'Cho bé gái nhỏ tuổi '),
('LEGO3', 'LEGO Bé Mầm Non', 'Cho trẻ mầm non'),
('LEGO4', 'LEGO Người Lớn', 'Cho người lớn'),
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
('Robot', '18', 'Đồ chơi robot mèo puffy mũm mĩm', 'product_1765443732_693a8894d8dd1.webp', 20, 150000, 300000, '8+', 'Đồ chơi robot mèo puffy mũm mĩm', '2025-12-11'),
('BupBe', '19', 'Bộ vòng tay nút thắt tình bạn sắc màu MAKE IT REAL', 'product_1765445133_693a8e0d3183c.webp', 20, 15000, 30000, '5+', 'Mới', '2025-12-11'),
('Robot', '20', 'đồ chơi robot tự động cleverbot thông thái vecto v', 'product_1765445300_693a8eb458e50.webp', 17, 200000, 300000, '14+', 'đẹp', '2025-12-11'),
('Robot', '21', 'đồ chơi robot tự động bọ hung giận dữ vecto vt9903', 'product_1765445360_693a8ef063567.webp', 18, 100000, 300000, '16+', 'hay', '2025-12-11'),
('Robot', '22', 'robot-chi-huy-captain-commander-bien-hinh-xe-conta', 'product_1765445465_693a8f59f2ea9.webp', 10, 1000000, 1500000, '14+', 'đắt', '2025-12-11'),
('BupBe', '23', 'búp bê decora 11 inch - decora d1005', 'product_1765445683_693a9033561c4.webp', 18, 300000, 500000, '10+', 'điệu', '2025-12-11'),
('BupBe', '24', 'búp bê decora 11 inch - luna d1006', 'product_1765445726_693a905ed0038.webp', 15, 300000, 500000, '10+', 'hay', '2025-12-11'),
('BupBe', '25', 'búp bê 29cm nàng tiên dreameez 81038dre', 'product_1765445802_693a90aa7a2e9.webp', 12, 130000, 230000, '10+', 'cũ', '2025-12-11'),
('BupBe', '26', 'búp bê baby bập bẹ dollsworld dw60280', 'product_1765445864_693a90e8a3bf0.webp', 16, 300000, 600000, '8+', 'dễ thương', '2025-12-11'),
('GiaoDuc', '27', 'Đồ chơi đàn piano mèo con b.brand bx1025z', 'product_1765446289_693a92910c9a1.webp', 12, 40000, 100000, '4+', 'tốt', '2025-12-11'),
('GiaoDuc', '28', 'Đồ chơi điện thoại quay số FISHER PRICE MATTEL FGW', 'product_1765446355_693a92d3abd1a.webp', 12, 30000, 100000, '8+', 'tốt', '2025-12-11'),
('GiaoDuc', '29', 'đồ chơi chú voi âm nhạc vui nhộn winfun 230202', 'product_1765446409_693a93099d704.webp', 15, 60000, 120000, '14+', 'hay', '2025-12-11'),
('GiaoDuc', '30', 'Đồ chơi thả khối và chong chóng sắc màu peek a boo', 'product_1765446474_693a934a8de0a.webp', 19, 70000, 140000, '16+', 'đẹp', '2025-12-11'),
('GiaoDuc', '31', 'đồ chơi nút bật rèn luyện tay-mắt cho bé peek a bo', 'product_1765446536_693a938802a09.webp', 15, 30000, 60000, '14+', 'tốt cho mắt', '2025-12-11'),
('NhoiBong', '32', 'thú nhồi bông catnap poppy playtime cp7751', 'product_1765446687_693a941fc9fe4.webp', 10, 50000, 100000, '10+', 'xịn', '2025-12-11'),
('NhoiBong', '33', 'thú nhồi bông craftycorn poppy playtime cp7753', 'product_1765446728_693a944836aee.webp', 10, 50000, 100000, '14+', 'cịn', '2025-12-11'),
('NhoiBong', '34', 'thú nhồi bông dogday poppy playtime cp7752', 'product_1765446780_693a947c49676.webp', 10, 40000, 80000, '14+', 'hay', '2025-12-11'),
('NhoiBong', '35', 'móc khoá nhồi bông kimmon mimon plush toy 556005km', 'product_1765446828_693a94accba0d.webp', 12, 30000, 60000, '10+', 'hay ho', '2025-12-11'),
('NhoiBong', '36', 'đồ chơi nhồi bông 7.5 inch silvina squishmallows s', 'product_1765446871_693a94d765e29.webp', 10, 20000, 50000, '6+', 'có lương tâm', '2025-12-11'),
('NgoaiTroi', '37', 'đồ chơi bóng nảy siêu đàn hồi marvel - captain ame', 'product_1765447018_693a956a672e1.webp', 4, 50000, 500000, '8+', 'căng', '2025-12-11'),
('NgoaiTroi', '38', 'đồ chơi bóng nảy siêu đàn hồi marvel – iron man eo', 'product_1765447059_693a95930c62e.webp', 6, 50000, 500000, '6+', 'tròn', '2025-12-11'),
('NgoaiTroi', '39', 'đồ chơi phun nước vô địch 1000ml xshot x56221', 'product_1765447109_693a95c5070ad.webp', 26, 50000, 300000, '14+', 'dài', '2025-12-11'),
('NgoaiTroi', '40', 'đồ chơi ném bong bóng nước siêu cấp vui nhộn xshot', 'product_1765447163_693a95fbd737c.webp', 17, 40000, 160000, '14+', 'to', '2025-12-11'),
('NgoaiTroi', '41', 'đồ chơi phun nước vui nhộn xshot 170ml (2022 ver.)', 'product_1765447218_693a96329524c.webp', 39, 200000, 500000, '16+', 'tốn', '2025-12-11'),
('LEGO1', '42', 'Đồ chơi lắp ráp rồng con', 'product_1765451175_693aa5a73434e.webp', 20, 250000, 500000, '8+', 'Đồ chơi lắp ráp rồng con', '2025-12-11'),
('LEGO1', '43', 'Đồ chơi lắp ráp máy bay', 'product_1765451223_693aa5d7054d6.webp', 24, 150000, 450000, '8+', 'Đồ chơi lắp ráp máy bay', '2025-12-11'),
('LEGO1', '44', 'Xe cảnh sát', 'product_1765451262_693aa5fe68fcf.webp', 50, 150000, 300000, '8+', 'Xe cảnh sát', '2025-12-11'),
('LEGO1', '45', 'Chiến giáp zane', 'product_1765451306_693aa62aa7afc.webp', 25, 300000, 600000, '8+', 'Chiến giáp zane', '2025-12-11'),
('LEGO1', '46', 'Bộ sưu tập xe đua f1', 'product_1765451353_693aa6594a897.webp', 25, 250000, 500000, '8+', 'Bộ sưu tập xe đua f1', '2025-12-11'),
('LEGO1', '47', 'Robot chiến đấu', 'product_1765451385_693aa679cb0c0.webp', 20, 400000, 900000, '8+', 'Robot chiến đấu', '2025-12-11');

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
(3, 'Tạ Văn Hội', 'chitogelovehoi@gmail.com', '$2y$10$yI4QyC5Qm.nnV/SfU/6cMOKfdMmuwPRnbYriV/31o9I3DZHvIWCXS', 1, NULL, '2025-12-11 14:37:07', 'admin'),
(4, 'nguyendoan', 'doanveo33@gmail.com', '$2y$10$daBbWMGGPxsyv83nkIgdUOq4Y7qweveoMfHmzcccqULkY6xp8RHDi', 1, NULL, '2025-12-11 16:10:49', 'admin');

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
