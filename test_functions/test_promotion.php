<?php
/**
 * TEST KHUYẾN MÃI VÀ SẢN PHẨM
 * Truy cập: http://localhost/websiteDoChoi/test_promotion.php
 */

require_once 'app/config.php';
require_once 'app/DB.php';

echo "<h1>🏷️ Test Khuyến Mãi & Sản Phẩm</h1>";
echo "<style>body{font-family:Arial;padding:20px;} .ok{color:green;font-weight:bold;} .error{color:red;font-weight:bold;} .warning{color:orange;} pre{background:#f5f5f5;padding:15px;border-radius:8px;overflow-x:auto;} table{border-collapse:collapse;width:100%;margin:10px 0;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#003399;color:#fff;}</style>";

try {
    $db = DB::getInstance();
    echo "<p class='ok'>✅ Kết nối DB OK</p>";
    
    // ========== KIỂM TRA BẢNG TBLSANPHAM ==========
    echo "<h2>🎮 Kiểm tra bảng tblsanpham</h2>";
    $stmt = $db->query("SHOW COLUMNS FROM tblsanpham");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $hasPromoId = in_array('promotion_id', $columns);
    $hasDiscountPercent = in_array('discount_percent', $columns);
    
    if ($hasPromoId) {
        echo "<p class='ok'>✅ Có cột promotion_id</p>";
    } else {
        echo "<p class='error'>❌ Thiếu cột promotion_id</p>";
        echo "<pre>ALTER TABLE tblsanpham ADD COLUMN promotion_id INT NULL DEFAULT NULL;</pre>";
    }
    
    if ($hasDiscountPercent) {
        echo "<p class='ok'>✅ Có cột discount_percent</p>";
    } else {
        echo "<p class='error'>❌ Thiếu cột discount_percent</p>";
        echo "<pre>ALTER TABLE tblsanpham ADD COLUMN discount_percent INT NULL DEFAULT NULL;</pre>";
    }
    
    // Kiểm tra sản phẩm có khuyến mãi
    if ($hasPromoId && $hasDiscountPercent) {
        $stmt = $db->query("SELECT masp, tensp, giaXuat, promotion_id, discount_percent FROM tblsanpham WHERE promotion_id IS NOT NULL OR discount_percent IS NOT NULL LIMIT 10");
        $promoProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Sản phẩm có khuyến mãi: " . count($promoProducts) . "</h3>";
        if (count($promoProducts) > 0) {
            echo "<table><tr><th>Mã SP</th><th>Tên SP</th><th>Giá</th><th>Promo ID</th><th>Giảm %</th></tr>";
            foreach ($promoProducts as $p) {
                echo "<tr><td>{$p['masp']}</td><td>{$p['tensp']}</td><td>" . number_format($p['giaXuat']) . "đ</td><td>{$p['promotion_id']}</td><td>{$p['discount_percent']}%</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='warning'>⚠️ Chưa có sản phẩm nào được gán khuyến mãi. Hãy vào Admin > Sản phẩm > Chỉnh sửa để gán.</p>";
        }
    }
    
    echo "<hr>";
    
    // 1. Kiểm tra cấu trúc bảng promotions
    echo "<h2>1. Cấu trúc bảng promotions</h2>";
    $stmt = $db->query("DESCRIBE promotions");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>";
    foreach ($columns as $col) {
        echo "<tr>";
        echo "<td><strong>{$col['Field']}</strong></td>";
        echo "<td>{$col['Type']}</td>";
        echo "<td>{$col['Null']}</td>";
        echo "<td>{$col['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Kiểm tra các cột cần thiết
    $requiredCols = ['id', 'code', 'name', 'type', 'value', 'status', 'start_date', 'end_date'];
    $existingCols = array_column($columns, 'Field');
    $missingCols = array_diff($requiredCols, $existingCols);
    
    if (!empty($missingCols)) {
        echo "<p class='error'>❌ Thiếu các cột: " . implode(', ', $missingCols) . "</p>";
        echo "<h3>Chạy SQL sau để thêm cột:</h3>";
        echo "<pre>";
        foreach ($missingCols as $col) {
            switch ($col) {
                case 'name': echo "ALTER TABLE promotions ADD COLUMN name VARCHAR(255) NULL;\n"; break;
                case 'type': echo "ALTER TABLE promotions ADD COLUMN type VARCHAR(20) DEFAULT 'percent';\n"; break;
                case 'value': echo "ALTER TABLE promotions ADD COLUMN value DECIMAL(10,2) DEFAULT 0;\n"; break;
                case 'status': echo "ALTER TABLE promotions ADD COLUMN status VARCHAR(20) DEFAULT 'active';\n"; break;
                case 'start_date': echo "ALTER TABLE promotions ADD COLUMN start_date DATETIME NULL;\n"; break;
                case 'end_date': echo "ALTER TABLE promotions ADD COLUMN end_date DATETIME NULL;\n"; break;
                case 'min_order_amount': echo "ALTER TABLE promotions ADD COLUMN min_order_amount DECIMAL(15,2) DEFAULT 0;\n"; break;
                case 'usage_limit': echo "ALTER TABLE promotions ADD COLUMN usage_limit INT NULL;\n"; break;
                case 'usage_count': echo "ALTER TABLE promotions ADD COLUMN usage_count INT DEFAULT 0;\n"; break;
                case 'created_at': echo "ALTER TABLE promotions ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;\n"; break;
            }
        }
        echo "</pre>";
    } else {
        echo "<p class='ok'>✅ Có đủ các cột cần thiết</p>";
    }
    
    // 2. Hiển thị dữ liệu hiện có
    echo "<h2>2. Dữ liệu trong bảng promotions</h2>";
    $stmt = $db->query("SELECT * FROM promotions");
    $promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($promotions) > 0) {
        echo "<p>Có " . count($promotions) . " khuyến mãi:</p>";
        echo "<pre>" . print_r($promotions, true) . "</pre>";
    } else {
        echo "<p class='error'>❌ Bảng promotions trống!</p>";
    }
    
    // 3. Thử thêm khuyến mãi test
    echo "<h2>3. Thử thêm khuyến mãi test</h2>";
    
    // Kiểm tra xem có đủ cột không
    if (in_array('type', $existingCols) && in_array('value', $existingCols)) {
        try {
            $testCode = 'TEST' . time();
            $sql = "INSERT INTO promotions (code, name, type, value, status, start_date, end_date, created_at) 
                    VALUES (?, ?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), NOW())";
            $stmt = $db->prepare($sql);
            $stmt->execute([$testCode, 'Test Khuyến Mãi', 'percent', 15, 'active']);
            
            echo "<p class='ok'>✅ Thêm khuyến mãi test thành công! Code: $testCode</p>";
            
            // Kiểm tra lại
            $stmt = $db->query("SELECT * FROM promotions ORDER BY id DESC LIMIT 1");
            $lastPromo = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<pre>" . print_r($lastPromo, true) . "</pre>";
            
        } catch (PDOException $e) {
            echo "<p class='error'>❌ Lỗi khi thêm: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p class='error'>❌ Không thể test vì thiếu cột type hoặc value</p>";
    }
    
    // 4. SQL để tạo lại bảng
    echo "<h2>4. SQL tạo lại bảng promotions (nếu cần)</h2>";
    echo "<pre>";
    echo "-- Backup và tạo lại bảng promotions
DROP TABLE IF EXISTS promotions;

CREATE TABLE promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NULL,
    type VARCHAR(20) DEFAULT 'percent',
    value DECIMAL(10,2) DEFAULT 0,
    min_order_amount DECIMAL(15,2) DEFAULT 0,
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
('SIEUTIET30', 'Siêu Tiết Kiệm 30%', 'percent', 30, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'active');
";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
?>
