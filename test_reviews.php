<?php
/**
 * Test file để kiểm tra và sửa bảng reviews
 * Truy cập: http://localhost/websiteDoChoi/test_reviews.php
 */

require_once 'app/config.php';
require_once 'app/DB.php';

echo "<h2>🔍 Kiểm tra và sửa bảng Reviews</h2>";

try {
    $db = new DB();
    $pdo = $db->db;
    
    // 1. Kiểm tra cấu trúc bảng reviews
    echo "<h3>1. Cấu trúc bảng reviews hiện tại:</h3>";
    $columns = $pdo->query("DESCRIBE reviews")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='5' style='border-collapse:collapse; margin-bottom:20px;'>";
    echo "<tr style='background:#003399;color:#fff'><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>";
    foreach ($columns as $col) {
        echo "<tr><td>{$col['Field']}</td><td>{$col['Type']}</td><td>{$col['Null']}</td><td>{$col['Default']}</td></tr>";
    }
    echo "</table>";
    
    // Lấy danh sách tên cột
    $columnNames = array_column($columns, 'Field');
    echo "<p>Các cột: " . implode(', ', $columnNames) . "</p>";
    
    // 2. Kiểm tra xem có thiếu cột user_name, user_email không
    echo "<h3>2. Kiểm tra và thêm cột thiếu:</h3>";
    
    if (!in_array('user_name', $columnNames)) {
        $pdo->exec("ALTER TABLE reviews ADD COLUMN user_name VARCHAR(255) NOT NULL DEFAULT '' AFTER user_id");
        echo "<p style='color:green'>✅ Đã thêm cột user_name</p>";
    } else {
        echo "<p>✅ Cột user_name đã có</p>";
    }
    
    if (!in_array('user_email', $columnNames)) {
        $pdo->exec("ALTER TABLE reviews ADD COLUMN user_email VARCHAR(255) NOT NULL DEFAULT '' AFTER user_name");
        echo "<p style='color:green'>✅ Đã thêm cột user_email</p>";
    } else {
        echo "<p>✅ Cột user_email đã có</p>";
    }
    
    if (!in_array('image', $columnNames)) {
        $pdo->exec("ALTER TABLE reviews ADD COLUMN image VARCHAR(255) NULL AFTER comment");
        echo "<p style='color:green'>✅ Đã thêm cột image</p>";
    } else {
        echo "<p>✅ Cột image đã có</p>";
    }
    
    // 3. Đếm số đánh giá
    echo "<h3>3. Số lượng đánh giá:</h3>";
    $count = $pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
    echo "<p>Tổng số đánh giá: <strong>$count</strong></p>";
    
    // 4. Nếu chưa có đánh giá, thêm mẫu
    if ($count == 0) {
        echo "<h3>4. Thêm đánh giá mẫu:</h3>";
        
        // Lấy sản phẩm từ tblsanpham
        $products = $pdo->query("SELECT masp, tensp FROM tblsanpham LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($products)) {
            foreach ($products as $index => $product) {
                $userId = $index + 1;
                $names = ['Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C'];
                $emails = ['nguyenvana@test.com', 'tranthib@test.com', 'levanc@test.com'];
                $comments = [
                    'Sản phẩm rất tốt, con tôi rất thích! Đóng gói cẩn thận.',
                    'Đồ chơi chất lượng, giao hàng nhanh. Sẽ mua thêm.',
                    'Tuyệt vời! Giá cả hợp lý, shop uy tín.'
                ];
                $ratings = [5, 4, 5];
                
                $stmt = $pdo->prepare("INSERT INTO reviews (user_id, user_name, user_email, product_id, rating, comment, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
                $stmt->execute([$userId, $names[$index], $emails[$index], $product['masp'], $ratings[$index], $comments[$index]]);
                
                echo "<p style='color:green'>✅ Đã thêm đánh giá cho: {$product['tensp']}</p>";
            }
        } else {
            echo "<p style='color:red'>❌ Không tìm thấy sản phẩm nào trong tblsanpham</p>";
        }
    }
    
    // 5. Hiển thị tất cả đánh giá
    echo "<h3>5. Danh sách đánh giá:</h3>";
    $reviews = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($reviews)) {
        echo "<table border='1' cellpadding='10' style='border-collapse:collapse'>";
        echo "<tr style='background:#003399;color:#fff'><th>ID</th><th>User</th><th>Email</th><th>Product ID</th><th>Rating</th><th>Comment</th><th>Status</th></tr>";
        foreach ($reviews as $r) {
            echo "<tr>";
            echo "<td>{$r['id']}</td>";
            echo "<td>" . ($r['user_name'] ?? 'N/A') . "</td>";
            echo "<td>" . ($r['user_email'] ?? 'N/A') . "</td>";
            echo "<td>{$r['product_id']}</td>";
            echo "<td>{$r['rating']} ⭐</td>";
            echo "<td>" . substr($r['comment'] ?? '', 0, 40) . "...</td>";
            echo "<td>{$r['status']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:orange'>⚠️ Vẫn chưa có đánh giá nào</p>";
    }
    
    echo "<hr>";
    echo "<p><a href='" . APP_URL . "/Admin/reviewList' style='padding:10px 20px; background:#003399; color:#fff; text-decoration:none; border-radius:5px;'>👉 Quay lại trang Admin Đánh giá</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Lỗi: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
