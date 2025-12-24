-- =====================================================
-- KIỂM TRA VÀ TẠO BẢNG REVIEWS
-- Chạy SQL này trong phpMyAdmin (database: websitedochoi)
-- =====================================================

-- 1. Tạo bảng reviews nếu chưa có
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `user_name` VARCHAR(255) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL,
  `product_id` VARCHAR(50) NOT NULL COMMENT 'masp từ tblsanpham',
  `rating` INT NOT NULL DEFAULT 5 COMMENT 'Số sao từ 1-5',
  `comment` TEXT NULL COMMENT 'Nội dung bình luận',
  `image` VARCHAR(255) NULL COMMENT 'Ảnh đánh giá',
  `status` VARCHAR(20) DEFAULT 'pending' COMMENT 'pending, approved, rejected',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL,
  INDEX `idx_product` (`product_id`),
  INDEX `idx_user` (`user_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Kiểm tra xem bảng đã có dữ liệu chưa
SELECT COUNT(*) as total_reviews FROM reviews;

-- 3. Thêm một số đánh giá mẫu để test (nếu bảng trống)
-- Lấy masp từ tblsanpham để đảm bảo product_id hợp lệ
INSERT INTO reviews (user_id, user_name, user_email, product_id, rating, comment, status, created_at)
SELECT 
    1, 
    'Nguyễn Văn A', 
    'test@example.com',
    masp,
    5,
    'Sản phẩm rất tốt, con tôi rất thích! Đóng gói cẩn thận, giao hàng nhanh.',
    'pending',
    NOW()
FROM tblsanpham 
LIMIT 1;

INSERT INTO reviews (user_id, user_name, user_email, product_id, rating, comment, status, created_at)
SELECT 
    2, 
    'Trần Thị B', 
    'test2@example.com',
    masp,
    4,
    'Đồ chơi chất lượng, giá cả hợp lý. Sẽ mua thêm lần sau.',
    'pending',
    NOW()
FROM tblsanpham 
LIMIT 1 OFFSET 1;

INSERT INTO reviews (user_id, user_name, user_email, product_id, rating, comment, status, created_at)
SELECT 
    3, 
    'Lê Văn C', 
    'test3@example.com',
    masp,
    5,
    'Tuyệt vời! Cháu tôi mê mẩn luôn. Shop uy tín, sẽ giới thiệu bạn bè.',
    'approved',
    NOW()
FROM tblsanpham 
LIMIT 1 OFFSET 2;

-- 4. Kiểm tra lại dữ liệu
SELECT * FROM reviews ORDER BY created_at DESC;
