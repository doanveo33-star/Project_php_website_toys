-- Thêm sản phẩm mẫu cho Độc Quyền Online và Hàng Mới
-- Chạy file này trong phpMyAdmin để có dữ liệu test

USE websitedochoi;

-- Kiểm tra và thêm loại sản phẩm nếu chưa có
INSERT IGNORE INTO tblloaisp (maLoaiSP, tenLoaiSP, moTaLoaiSP) VALUES
('DocQuyenOnline', 'Độc Quyền Online', 'Sản phẩm độc quyền khi mua Online'),
('SanPhamMoi', 'Hàng Mới', 'Sản phẩm mới nhất');

-- Thêm sản phẩm Độc Quyền Online mẫu
INSERT INTO tblsanpham (masp, maLoaiSP, tensp, hinhanh, soluong, giaNhap, giaXuat, thuongHieu, doTuoi, mota, createDate) VALUES
('DQO001', 'DocQuyenOnline', 'Robot Transformer Optimus Prime Limited', 'robot1.jpg', 50, 800000, 1299000, 'Hasbro', '6+', 'Phiên bản giới hạn chỉ có online', CURDATE()),
('DQO002', 'DocQuyenOnline', 'LEGO Star Wars Millennium Falcon Exclusive', 'lego_falcon.jpg', 30, 2000000, 3499000, 'LEGO', '10+', 'Bộ LEGO độc quyền online', CURDATE()),
('DQO003', 'DocQuyenOnline', 'Búp Bê Barbie Collector Edition', 'barbie_collector.jpg', 40, 500000, 899000, 'Mattel', '6+', 'Phiên bản sưu tầm độc quyền', CURDATE()),
('DQO004', 'DocQuyenOnline', 'Hot Wheels Ultimate Garage Exclusive', 'hw_garage.jpg', 25, 1500000, 2599000, 'Hot Wheels', '5+', 'Garage siêu xe độc quyền online', CURDATE());

-- Thêm sản phẩm Hàng Mới mẫu
INSERT INTO tblsanpham (masp, maLoaiSP, tensp, hinhanh, soluong, giaNhap, giaXuat, thuongHieu, doTuoi, mota, createDate) VALUES
('NEW001', 'SanPhamMoi', 'Robot Điều Khiển Từ Xa 2025', 'robot_new.jpg', 100, 400000, 699000, 'VECTO', '5+', 'Sản phẩm mới 2025', CURDATE()),
('NEW002', 'SanPhamMoi', 'Bộ Xếp Hình Thành Phố Tương Lai', 'city_new.jpg', 80, 300000, 549000, 'LEGO', '6+', 'Bộ xếp hình mới nhất', CURDATE()),
('NEW003', 'SanPhamMoi', 'Xe Đua Điều Khiển Drift Pro', 'car_drift.jpg', 60, 600000, 999000, 'RC Pro', '8+', 'Xe drift mới về', CURDATE()),
('NEW004', 'SanPhamMoi', 'Board Game Chiến Thuật 2025', 'boardgame_new.jpg', 70, 350000, 599000, 'Ravensburger', '10+', 'Board game mới nhất', CURDATE());

SELECT 'Đã thêm sản phẩm mẫu thành công!' as Message;
