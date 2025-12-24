<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'app/config.php';

echo "<h2>🔧 Sửa bảng Reviews</h2>";

$pdo = new PDO('mysql:host=localhost;dbname=websitedochoi;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Xem cấu trúc bảng hiện tại
echo "<h3>1. Cấu trúc bảng reviews hiện tại:</h3>";
$columns = $pdo->query("DESCRIBE reviews")->fetchAll(PDO::FETCH_ASSOC);
$columnNames = array_column($columns, 'Field');
echo "<p>Các cột: <strong>" . implode(', ', $columnNames) . "</strong></p>";

// 2. Xóa bảng cũ và tạo lại đúng cấu trúc
echo "<h3>2. Tạo lại bảng reviews với cấu trúc đúng:</h3>";

$pdo->exec("DROP TABLE IF EXISTS reviews");
echo "<p>✅ Đã xóa bảng cũ</p>";

$createSQL = "CREATE TABLE `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `user_name` VARCHAR(255) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL,
  `product_id` VARCHAR(50) NOT NULL,
  `rating` INT NOT NULL DEFAULT 5,
  `comment` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `status` VARCHAR(20) DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$pdo->exec($createSQL);
echo "<p>✅ Đã tạo bảng mới với cấu trúc đúng</p>";

// 3. Thêm dữ liệu mẫu
echo "<h3>3. Thêm đánh giá mẫu:</h3>";

$sql = "INSERT INTO reviews (user_id, user_name, user_email, product_id, rating, comment, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $pdo->prepare($sql);

$stmt->execute([1, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '01', 5, 'Sản phẩm rất tốt, con tôi rất thích! Đóng gói cẩn thận, giao hàng nhanh.', 'pending']);
$stmt->execute([2, 'Trần Thị B', 'tranthib@gmail.com', '02', 4, 'Đồ chơi chất lượng cao, giá cả hợp lý. Sẽ mua thêm lần sau.', 'pending']);
$stmt->execute([3, 'Lê Văn C', 'levanc@gmail.com', '03', 5, 'Tuyệt vời! Shop uy tín, sản phẩm đúng mô tả. Highly recommend!', 'pending']);

echo "<p>✅ Đã thêm 3 đánh giá mẫu</p>";

// 4. Kiểm tra kết quả
echo "<h3>4. Danh sách đánh giá:</h3>";
$reviews = $pdo->query("SELECT * FROM reviews")->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>";
echo "<tr style='background:#003399;color:#fff;'><th>ID</th><th>User</th><th>Email</th><th>Product</th><th>Rating</th><th>Comment</th><th>Status</th></tr>";
foreach ($reviews as $r) {
    echo "<tr>";
    echo "<td>{$r['id']}</td>";
    echo "<td>{$r['user_name']}</td>";
    echo "<td>{$r['user_email']}</td>";
    echo "<td>{$r['product_id']}</td>";
    echo "<td>{$r['rating']} ⭐</td>";
    echo "<td>" . substr($r['comment'], 0, 50) . "...</td>";
    echo "<td><span style='background:#ffc107;padding:3px 8px;border-radius:10px;'>{$r['status']}</span></td>";
    echo "</tr>";
}
echo "</table>";

echo "<p><strong>Tổng: " . count($reviews) . " đánh giá</strong></p>";

echo "<hr>";
echo "<p><a href='".APP_URL."/Admin/reviewList' style='display:inline-block;padding:12px 25px;background:#003399;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;'>👉 Đi đến Admin Reviews</a></p>";
