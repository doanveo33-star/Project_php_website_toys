-- =============================================
-- DATABASE WEBSITE ĐỒ CHƠI (ĐƠN GIẢN - KHÔNG CÓ SIZE)
-- =============================================

USE websitedochoi;

-- Xóa bảng cũ nếu có
DROP TABLE IF EXISTS order_details;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS promotions;
DROP TABLE IF EXISTS tblsanpham;
DROP TABLE IF EXISTS tblloaisp;
DROP TABLE IF EXISTS tbluser;

-- =============================================
-- BẢNG LOẠI SẢN PHẨM (tblloaisp)
-- =============================================
CREATE TABLE tblloaisp (
    maLoaiSP VARCHAR(50) NOT NULL PRIMARY KEY,
    tenLoaiSP VARCHAR(100) NOT NULL,
    moTaLoaiSP TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- BẢNG SẢN PHẨM (tblsanpham) - CÓ GIÁ NHẬP/XUẤT TRỰC TIẾP
-- =============================================
CREATE TABLE tblsanpham (
    masp VARCHAR(20) NOT NULL PRIMARY KEY,
    maLoaiSP VARCHAR(50) NOT NULL,
    tensp VARCHAR(100) NOT NULL,
    hinhanh VARCHAR(100),
    soluong INT(11) DEFAULT 0,
    giaNhap DECIMAL(15,0) DEFAULT 0,
    giaXuat DECIMAL(15,0) DEFAULT 0,
    thuongHieu VARCHAR(100),
    doTuoi VARCHAR(50),
    mota TEXT,
    createDate DATE,
    FOREIGN KEY (maLoaiSP) REFERENCES tblloaisp(maLoaiSP) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- BẢNG NGƯỜI DÙNG (tbluser)
-- =============================================
CREATE TABLE tbluser (
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    is_verified TINYINT(1) DEFAULT 0,
    verification_token INT(11),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM('user', 'admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- BẢNG ĐƠN HÀNG (orders)
-- =============================================
CREATE TABLE orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    user_email VARCHAR(100),
    order_code VARCHAR(50),
    receiver VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    delivery_method VARCHAR(20) DEFAULT 'home',
    payment_method VARCHAR(20),
    total_amount DECIMAL(15,2) DEFAULT 0,
    discount_amount DECIMAL(15,2) DEFAULT 0,
    coupon_code VARCHAR(100) NULL,
    transaction_info VARCHAR(30),
    note TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    received_amount DECIMAL(15,2) DEFAULT 0.00,
    lack_amount DECIMAL(15,2) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES tbluser(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- BẢNG CHI TIẾT ĐƠN HÀNG (order_details)
-- =============================================
CREATE TABLE order_details (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(20),
    product_id VARCHAR(50),
    quantity INT(11),
    price DECIMAL(15,2),
    total DECIMAL(15,2),
    image VARCHAR(255) NULL,
    product_name VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- BẢNG KHUYẾN MÃI (promotions)
-- =============================================
CREATE TABLE promotions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_type ENUM('percent', 'fixed') DEFAULT 'percent',
    discount_value DECIMAL(15,2) NOT NULL,
    min_order_amount DECIMAL(15,2) DEFAULT 0,
    max_discount DECIMAL(15,2) NULL,
    usage_limit INT(11) NULL,
    used_count INT(11) DEFAULT 0,
    start_date DATE,
    end_date DATE,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- BẢNG ĐÁNH GIÁ (reviews)
-- =============================================
CREATE TABLE reviews (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    product_id VARCHAR(50),
    rating INT(11) DEFAULT 5,
    comment TEXT,
    image VARCHAR(255) NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tbluser(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- DỮ LIỆU MẪU - LOẠI ĐỒ CHƠI (không bao gồm LEGO - LEGO có bảng riêng)
-- =============================================
INSERT INTO tblloaisp (maLoaiSP, tenLoaiSP, moTaLoaiSP) VALUES
('Robot', 'Robot & Điều khiển', 'Robot, xe điều khiển từ xa'),
('BupBe', 'Búp bê & Phụ kiện', 'Búp bê, nhà búp bê, phụ kiện'),
('GiaoDuc', 'Đồ chơi giáo dục', 'Đồ chơi phát triển trí tuệ'),
('XeMoHinh', 'Xe mô hình', 'Xe ô tô, máy bay, tàu mô hình'),
('NgoaiTroi', 'Đồ chơi ngoài trời', 'Đồ chơi vận động, thể thao'),
('BoardGame', 'Board Game', 'Trò chơi bàn cờ, thẻ bài'),
('NhoiBong', 'Đồ chơi nhồi bông', 'Gấu bông, thú nhồi bông');

-- =============================================
-- BẢNG LEGO - PHÂN LOẠI RIÊNG
-- =============================================

-- Loại LEGO theo đối tượng
CREATE TABLE tbl_lego_doituong (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_doituong VARCHAR(50) NOT NULL,
    ten_doituong VARCHAR(100) NOT NULL,
    icon VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tbl_lego_doituong (ma_doituong, ten_doituong, icon) VALUES
('LEGO_BOY', 'LEGO Bé Trai', '👦'),
('LEGO_GIRL', 'LEGO Bé Gái', '👧'),
('LEGO_BABY', 'LEGO Bé Mầm Non', '👶'),
('LEGO_ADULT', 'LEGO Người Lớn', '👨');

-- Loại LEGO theo dòng sản phẩm (theme)
CREATE TABLE tbl_lego_theme (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_theme VARCHAR(50) NOT NULL,
    ten_theme VARCHAR(100) NOT NULL,
    ma_doituong VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tbl_lego_theme (ma_theme, ten_theme, ma_doituong) VALUES
('LEGO_CITY', 'LEGO CITY', 'LEGO_BOY'),
('LEGO_NINJAGO', 'LEGO NINJAGO', 'LEGO_BOY'),
('LEGO_MINECRAFT', 'LEGO MINECRAFT', 'LEGO_BOY'),
('LEGO_MARIO', 'LEGO SUPER MARIO', 'LEGO_BOY'),
('LEGO_MINIFIG', 'LEGO MINIFIGURES', 'LEGO_BOY'),
('LEGO_MINIONS', 'LEGO MINIONS', 'LEGO_BOY'),
('LEGO_SPIDEY', 'LEGO SPIDEY', 'LEGO_BOY'),
('LEGO_FRIENDS', 'LEGO FRIENDS', 'LEGO_GIRL'),
('LEGO_DISNEY', 'LEGO DISNEY', 'LEGO_GIRL'),
('LEGO_GABBY', 'LEGO GABBY', 'LEGO_GIRL'),
('LEGO_DUPLO', 'LEGO DUPLO', 'LEGO_BABY'),
('LEGO_TECHNIC', 'LEGO TECHNIC', 'LEGO_ADULT'),
('LEGO_ICONS', 'LEGO ICONS', 'LEGO_ADULT'),
('LEGO_IDEAS', 'LEGO IDEAS', 'LEGO_ADULT');

-- Bảng sản phẩm LEGO riêng
CREATE TABLE tbl_lego_sanpham (
    masp VARCHAR(20) NOT NULL PRIMARY KEY,
    ma_theme VARCHAR(50) NOT NULL,
    tensp VARCHAR(100) NOT NULL,
    hinhanh VARCHAR(100),
    soluong INT(11) DEFAULT 0,
    giaNhap DECIMAL(15,0) DEFAULT 0,
    giaXuat DECIMAL(15,0) DEFAULT 0,
    giaKhuyenMai DECIMAL(15,0) DEFAULT NULL,
    soManhGhep INT DEFAULT 0,
    doTuoi VARCHAR(20),
    mota TEXT,
    createDate DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu sản phẩm LEGO
INSERT INTO tbl_lego_sanpham (masp, ma_theme, tensp, hinhanh, soluong, giaNhap, giaXuat, giaKhuyenMai, soManhGhep, doTuoi, mota, createDate) VALUES
('LEGO60414', 'LEGO_CITY', 'Đồ Chơi Lắp Ráp Trạm Cứu Hỏa', 'lego60414.jpg', 50, 1000000, 1279000, 959250, 843, '6+', 'LEGO City Fire Station', CURDATE()),
('LEGO60374', 'LEGO_CITY', 'Đồ Chơi Lắp Ráp Trạm Bảo Dưỡng Xe F1', 'lego60374.jpg', 30, 900000, 1149000, 804000, 674, '7+', 'LEGO City F1 Service Station', CURDATE()),
('LEGO71819', 'LEGO_NINJAGO', 'Đồ Chơi Lắp Ráp Ngôi Làng Của Rồng', 'lego71819.jpg', 40, 800000, 999000, 749000, 632, '8+', 'LEGO Ninjago Dragon Village', CURDATE()),
('LEGO21189', 'LEGO_MINECRAFT', 'Đồ Chơi Lắp Ráp Ngục Tối Skeleton', 'lego21189.jpg', 35, 600000, 799000, 599000, 364, '8+', 'LEGO Minecraft Skeleton Dungeon', CURDATE()),
('LEGO71408', 'LEGO_MARIO', 'Đồ Chơi Lắp Ráp Lâu Đài Peach', 'lego71408.jpg', 25, 1200000, 1599000, 1199000, 1216, '8+', 'LEGO Super Mario Peach Castle', CURDATE()),
('LEGO41754', 'LEGO_FRIENDS', 'Đồ Chơi Lắp Ráp Phòng Leo', 'lego41754.jpg', 45, 400000, 549000, 439000, 203, '6+', 'LEGO Friends Leo Room', CURDATE()),
('LEGO43246', 'LEGO_DISNEY', 'Đồ Chơi Lắp Ráp Công Chúa Disney', 'lego43246.jpg', 55, 500000, 699000, 559000, 349, '6+', 'LEGO Disney Princess', CURDATE()),
('LEGO10980', 'LEGO_DUPLO', 'Đồ Chơi Lắp Ráp Tấm Nền Xanh Lá', 'lego10980.jpg', 100, 200000, 299000, 239000, 1, '1.5+', 'LEGO Duplo Green Building Plate', CURDATE()),
('LEGO42151', 'LEGO_TECHNIC', 'Đồ Chơi Lắp Ráp Bugatti Bolide', 'lego42151.jpg', 20, 500000, 699000, 559000, 905, '9+', 'LEGO Technic Bugatti Bolide', CURDATE()),
('LEGO10497', 'LEGO_ICONS', 'Đồ Chơi Lắp Ráp Galaxy Explorer', 'lego10497.jpg', 15, 1500000, 1999000, 1599000, 1254, '18+', 'LEGO Icons Galaxy Explorer', CURDATE());

-- =============================================
-- DỮ LIỆU MẪU - SẢN PHẨM ĐỒ CHƠI
-- =============================================
INSERT INTO tblsanpham (masp, maLoaiSP, tensp, hinhanh, soluong, giaNhap, giaXuat, thuongHieu, doTuoi, mota, createDate) VALUES
('LEGO001', 'LEGO', 'LEGO City Trạm Cứu Hỏa', 'lego001.jpg', 50, 800000, 1299000, 'LEGO', '6+', 'Bộ LEGO City trạm cứu hỏa với 509 mảnh ghép', CURDATE()),
('LEGO002', 'LEGO', 'LEGO Technic Xe Đua F1', 'lego002.jpg', 30, 1500000, 2499000, 'LEGO', '10+', 'Mô hình xe đua F1 tỷ lệ 1:8', CURDATE()),
('VTK4', 'Robot', 'Robot Biến Hình STRIKE VECTO', 'vtk4.jpg', 100, 500000, 999000, 'VECTO', '5+', 'Robot biến hình điều khiển từ xa', CURDATE()),
('VT052', 'Robot', 'Robot Chó Điều Khiển Từ Xa', 'vt052.jpg', 80, 400000, 759000, 'VECTO', '4+', 'Đồ chơi Robot Chó Tương Lai', CURDATE()),
('BRU02483', 'XeMoHinh', 'Xe Xúc CAT BRUDER 1:16', 'bru02483.jpg', 40, 1200000, 2199000, 'BRUDER', '4+', 'Mô hình xe xúc CAT tỷ lệ 1:16', CURDATE()),
('EU461542', 'GiaoDuc', 'Xe Tập Đi 3 Trong 1', 'eu461542.jpg', 60, 700000, 1309000, 'PEEK A BOO', '1+', 'Xe tập đi đa năng 3 trong 1', CURDATE()),
('BAR001', 'BupBe', 'Búp Bê Barbie Fashionistas', 'barbie001.jpg', 100, 250000, 450000, 'Barbie', '3+', 'Búp bê Barbie thời trang', CURDATE()),
('HW001', 'XeMoHinh', 'Hot Wheels Đường Đua Siêu Tốc', 'hw001.jpg', 45, 500000, 899000, 'Hot Wheels', '5+', 'Bộ đường đua Hot Wheels với 2 xe', CURDATE());

-- =============================================
-- TÀI KHOẢN ADMIN MẪU (password: 123456)
-- =============================================
INSERT INTO tbluser (fullname, email, password, is_verified, role) VALUES
('Admin ToyShop', 'admin@toyshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'admin');

-- =============================================
-- KHUYẾN MÃI MẪU
-- =============================================
INSERT INTO promotions (code, discount_type, discount_value, min_order_amount, max_discount, usage_limit, start_date, end_date, is_active) VALUES
('TOYSHOP10', 'percent', 10, 500000, 100000, 100, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 1),
('FREESHIP', 'fixed', 30000, 300000, NULL, 50, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 1);
