-- Cập nhật độ tuổi cho sản phẩm
-- Chạy file này trong phpMyAdmin nếu cột doTuoi đang trống

-- Cập nhật ngẫu nhiên độ tuổi cho các sản phẩm chưa có
UPDATE tblsanpham SET doTuoi = '3+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 5;
UPDATE tblsanpham SET doTuoi = '4+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 5;
UPDATE tblsanpham SET doTuoi = '5+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 5;
UPDATE tblsanpham SET doTuoi = '6+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 5;
UPDATE tblsanpham SET doTuoi = '8+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 5;
UPDATE tblsanpham SET doTuoi = '10+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 5;
UPDATE tblsanpham SET doTuoi = '12+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 5;
UPDATE tblsanpham SET doTuoi = '14+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 3;
UPDATE tblsanpham SET doTuoi = '16+' WHERE doTuoi IS NULL OR doTuoi = '' LIMIT 3;

-- Hoặc cập nhật tất cả sản phẩm còn lại thành 6+
UPDATE tblsanpham SET doTuoi = '6+' WHERE doTuoi IS NULL OR doTuoi = '';

-- Kiểm tra kết quả
SELECT doTuoi, COUNT(*) as count FROM tblsanpham GROUP BY doTuoi;
