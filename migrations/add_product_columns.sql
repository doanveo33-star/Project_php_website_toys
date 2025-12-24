-- =============================================
-- THÊM CÁC CỘT MỚI VÀO BẢNG tblsanpham
-- Chạy file này trong phpMyAdmin để thêm các cột giaNhap, giaXuat, doTuoi
-- =============================================

USE websitedochoi;

-- Thêm cột giá nhập
ALTER TABLE tblsanpham ADD COLUMN giaNhap DECIMAL(15,0) DEFAULT 0 AFTER soluong;

-- Thêm cột giá xuất (giá bán)
ALTER TABLE tblsanpham ADD COLUMN giaXuat DECIMAL(15,0) DEFAULT 0 AFTER giaNhap;

-- Thêm cột độ tuổi
ALTER TABLE tblsanpham ADD COLUMN doTuoi VARCHAR(50) DEFAULT NULL AFTER giaXuat;

-- Kiểm tra cấu trúc bảng sau khi thêm
DESCRIBE tblsanpham;
