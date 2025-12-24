-- =====================================================
-- THÊM CỘT KHUYẾN MÃI VÀO BẢNG SẢN PHẨM
-- Chạy SQL này trong phpMyAdmin (database: websitedochoi)
-- =====================================================

-- 1. Thêm cột promotion_id vào tblsanpham (nếu chưa có)
-- Chạy từng lệnh một nếu gặp lỗi "Duplicate column"

ALTER TABLE tblsanpham 
ADD COLUMN promotion_id INT NULL DEFAULT NULL COMMENT 'ID khuyến mãi từ bảng promotions';

ALTER TABLE tblsanpham 
ADD COLUMN discount_percent INT NULL DEFAULT NULL COMMENT 'Phần trăm giảm giá (cache từ promotion)';

-- 2. Thêm cột name và icon vào bảng promotions (nếu chưa có)
-- MySQL không hỗ trợ IF NOT EXISTS cho ADD COLUMN, chạy từng lệnh

ALTER TABLE promotions ADD COLUMN name VARCHAR(255) NULL COMMENT 'Tên chương trình khuyến mãi';

ALTER TABLE promotions ADD COLUMN icon VARCHAR(50) NULL DEFAULT '🎁' COMMENT 'Icon hiển thị';

-- 3. Cập nhật tên cho các promotions chưa có tên
UPDATE promotions SET name = CONCAT('Khuyến mãi ', code) WHERE name IS NULL OR name = '';

-- 4. Thêm một số khuyến mãi mẫu (nếu bảng trống)
INSERT INTO promotions (code, name, type, value, start_date, end_date, icon) VALUES
('SALE10', 'Giảm 10%', 'percent', 10, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), '🎁'),
('SALE20', 'Giảm 20%', 'percent', 20, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), '🔥'),
('SALE30', 'Siêu Sale 30%', 'percent', 30, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), '💥')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- 5. Kiểm tra kết quả
SELECT * FROM promotions;
DESCRIBE tblsanpham;
