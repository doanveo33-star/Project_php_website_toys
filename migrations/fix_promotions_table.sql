-- =====================================================
-- SỬA BẢNG PROMOTIONS - THÊM CÁC CỘT CẦN THIẾT
-- Chạy SQL này trong phpMyAdmin (database: websitedochoi)
-- =====================================================

-- CÁCH 1: TẠO LẠI BẢNG PROMOTIONS (KHUYẾN NGHỊ)
-- Backup dữ liệu cũ trước khi chạy

DROP TABLE IF EXISTS promotions_backup;
CREATE TABLE promotions_backup AS SELECT * FROM promotions;

DROP TABLE IF EXISTS promotions;

CREATE TABLE promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE COMMENT 'Mã khuyến mãi',
    name VARCHAR(255) NULL COMMENT 'Tên chương trình',
    type VARCHAR(20) DEFAULT 'percent' COMMENT 'percent hoặc fixed',
    value DECIMAL(10,2) DEFAULT 0 COMMENT 'Giá trị giảm',
    min_order_amount DECIMAL(15,2) DEFAULT 0 COMMENT 'Đơn tối thiểu',
    usage_count INT DEFAULT 0,
    usage_limit INT NULL,
    start_date DATETIME NULL,
    end_date DATETIME NULL,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu
INSERT INTO promotions (code, name, type, value, start_date, end_date, status) VALUES
('TOYSHOP10', 'Giảm 10%', 'percent', 10, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'active'),
('TOYSHOP20', 'Giảm 20%', 'percent', 20, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'active'),
('SIEUTIET30', 'Siêu Tiết Kiệm 30%', 'percent', 30, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'active'),
('FREESHIP', 'Miễn phí vận chuyển', 'fixed', 30000, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'active');

-- Thêm cột vào tblsanpham (nếu chưa có) - chạy từng lệnh, bỏ qua nếu lỗi Duplicate
ALTER TABLE tblsanpham ADD COLUMN promotion_id INT NULL DEFAULT NULL;
ALTER TABLE tblsanpham ADD COLUMN discount_percent INT NULL DEFAULT NULL;

-- Kiểm tra kết quả
SELECT * FROM promotions;
DESCRIBE tblsanpham;
