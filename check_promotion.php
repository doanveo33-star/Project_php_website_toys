<?php
/**
 * KIỂM TRA HỆ THỐNG KHUYẾN MÃI
 * Truy cập: http://localhost/websiteDoChoi/check_promotion.php
 */

require_once 'app/config.php';
require_once 'app/DB.php';

echo "<h1>🏷️ Kiểm tra hệ thống khuyến mãi</h1>";
echo "<style>body{font-family:Arial;padding:20px;} table{border-collapse:collapse;width:100%;margin:20px 0;} th,td{border:1px solid #ddd;padding:10px;text-align:left;} th{background:#003399;color:#fff;} .ok{color:green;font-weight:bold;} .error{color:red;font-weight:bold;} .warning{color:orange;font-weight:bold;}</style>";

try {
    $db = DB::getInstance();
    echo "<p class='ok'>✅ Kết nối database OK</p>";
    
    // 1. Kiểm tra bảng promotions
    echo "<h2>1. Bảng promotions</h2>";
    $stmt = $db->query("SHOW COLUMNS FROM promotions");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Các cột: " . implode(', ', $columns) . "</p>";
    
    $hasName = in_array('name', $columns);
    $hasIcon = in_array('icon', $columns);
    
    if (!$hasName) {
        echo "<p class='warning'>⚠️ Thiếu cột 'name' - Chạy: ALTER TABLE promotions ADD COLUMN name VARCHAR(255) NULL;</p>";
    }
    if (!$hasIcon) {
        echo "<p class='warning'>⚠️ Thiếu cột 'icon' - Chạy: ALTER TABLE promotions ADD COLUMN icon VARCHAR(50) NULL DEFAULT '🎁';</p>";
    }
    
    // Lấy danh sách promotions
    $stmt = $db->query("SELECT * FROM promotions");
    $promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Danh sách khuyến mãi (" . count($promotions) . " mục)</h3>";
    if (count($promotions) > 0) {
        echo "<table><tr><th>ID</th><th>Code</th><th>Name</th><th>Type</th><th>Value</th><th>Start</th><th>End</th></tr>";
        foreach ($promotions as $p) {
            echo "<tr>";
            echo "<td>{$p['id']}</td>";
            echo "<td>{$p['code']}</td>";
            echo "<td>" . ($p['name'] ?? '<em>NULL</em>') . "</td>";
            echo "<td>{$p['type']}</td>";
            echo "<td>{$p['value']}" . ($p['type'] == 'percent' ? '%' : 'đ') . "</td>";
            echo "<td>" . ($p['start_date'] ?? 'N/A') . "</td>";
            echo "<td>" . ($p['end_date'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠️ Chưa có khuyến mãi nào. Hãy thêm trong Admin hoặc chạy migration.</p>";
    }
    
    // 2. Kiểm tra bảng tblsanpham
    echo "<h2>2. Bảng tblsanpham</h2>";
    $stmt = $db->query("SHOW COLUMNS FROM tblsanpham");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $hasPromoId = in_array('promotion_id', $columns);
    $hasDiscountPercent = in_array('discount_percent', $columns);
    
    if ($hasPromoId) {
        echo "<p class='ok'>✅ Có cột promotion_id</p>";
    } else {
        echo "<p class='error'>❌ Thiếu cột promotion_id - Chạy: ALTER TABLE tblsanpham ADD COLUMN promotion_id INT NULL DEFAULT NULL;</p>";
    }
    
    if ($hasDiscountPercent) {
        echo "<p class='ok'>✅ Có cột discount_percent</p>";
    } else {
        echo "<p class='error'>❌ Thiếu cột discount_percent - Chạy: ALTER TABLE tblsanpham ADD COLUMN discount_percent INT NULL DEFAULT NULL;</p>";
    }
    
    // 3. Kiểm tra sản phẩm có khuyến mãi
    if ($hasPromoId && $hasDiscountPercent) {
        echo "<h2>3. Sản phẩm có khuyến mãi</h2>";
        $stmt = $db->query("SELECT masp, tensp, giaXuat, promotion_id, discount_percent FROM tblsanpham WHERE promotion_id IS NOT NULL OR discount_percent IS NOT NULL");
        $promoProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($promoProducts) > 0) {
            echo "<table><tr><th>Mã SP</th><th>Tên SP</th><th>Giá gốc</th><th>Promo ID</th><th>Giảm %</th><th>Giá sau giảm</th></tr>";
            foreach ($promoProducts as $p) {
                $giaGoc = $p['giaXuat'];
                $giamGia = $p['discount_percent'] ? round($giaGoc * $p['discount_percent'] / 100) : 0;
                $giaSauGiam = $giaGoc - $giamGia;
                echo "<tr>";
                echo "<td>{$p['masp']}</td>";
                echo "<td>{$p['tensp']}</td>";
                echo "<td>" . number_format($giaGoc) . "đ</td>";
                echo "<td>{$p['promotion_id']}</td>";
                echo "<td>{$p['discount_percent']}%</td>";
                echo "<td class='ok'>" . number_format($giaSauGiam) . "đ</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='warning'>⚠️ Chưa có sản phẩm nào được gán khuyến mãi. Hãy vào Admin > Sản phẩm > Chỉnh sửa để gán khuyến mãi.</p>";
        }
    }
    
    // 4. Hướng dẫn
    echo "<h2>4. Hướng dẫn sử dụng</h2>";
    echo "<ol>";
    echo "<li><strong>Thêm khuyến mãi:</strong> Vào Admin > Khuyến mãi > Thêm mới</li>";
    echo "<li><strong>Gán khuyến mãi cho sản phẩm:</strong> Vào Admin > Sản phẩm > Chỉnh sửa > Chọn khuyến mãi từ dropdown</li>";
    echo "<li><strong>Xem mega menu:</strong> Hover vào 'KHUYẾN MÃI' trên navbar trang chủ</li>";
    echo "<li><strong>Xem tất cả sản phẩm khuyến mãi:</strong> <a href='" . APP_URL . "/Home/allPromotions'>Trang khuyến mãi</a></li>";
    echo "</ol>";
    
    echo "<h2>5. SQL cần chạy (nếu thiếu cột)</h2>";
    echo "<pre style='background:#f5f5f5;padding:15px;border-radius:8px;'>";
    echo "-- Thêm cột vào tblsanpham\n";
    echo "ALTER TABLE tblsanpham ADD COLUMN promotion_id INT NULL DEFAULT NULL;\n";
    echo "ALTER TABLE tblsanpham ADD COLUMN discount_percent INT NULL DEFAULT NULL;\n\n";
    echo "-- Thêm cột vào promotions\n";
    echo "ALTER TABLE promotions ADD COLUMN name VARCHAR(255) NULL;\n";
    echo "ALTER TABLE promotions ADD COLUMN icon VARCHAR(50) NULL DEFAULT '🎁';\n\n";
    echo "-- Cập nhật tên cho promotions\n";
    echo "UPDATE promotions SET name = CONCAT('Khuyến mãi ', code) WHERE name IS NULL;\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
?>
