<?php
/**
 * Check độ tuổi trong database
 */
require_once 'app/config.php';

$pdo = new PDO('mysql:host=localhost;dbname=websitedochoi;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

echo "<h2>Kiểm tra dữ liệu độ tuổi trong tblsanpham</h2>";

// Lấy tất cả giá trị doTuoi
$stmt = $pdo->query("SELECT DISTINCT doTuoi, COUNT(*) as count FROM tblsanpham WHERE doTuoi IS NOT NULL AND doTuoi != '' GROUP BY doTuoi ORDER BY doTuoi");
$ages = $stmt->fetchAll();

echo "<h3>Các giá trị doTuoi trong database:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>doTuoi</th><th>Số sản phẩm</th><th>Hex Value</th></tr>";
foreach ($ages as $age) {
    $hexValue = bin2hex($age['doTuoi']);
    echo "<tr>";
    echo "<td>" . htmlspecialchars($age['doTuoi']) . "</td>";
    echo "<td>{$age['count']}</td>";
    echo "<td>{$hexValue}</td>";
    echo "</tr>";
}
echo "</table>";

// Test với giá trị từ URL
echo "<h3>Test tìm kiếm:</h3>";
$testValues = ['5+', '5', '5 tuổi', '5tuoi'];
foreach ($testValues as $val) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM tblsanpham WHERE doTuoi = ?");
    $stmt->execute([$val]);
    $result = $stmt->fetch();
    echo "<p>Tìm với '$val': {$result['count']} sản phẩm</p>";
}

// Hiển thị một số sản phẩm có doTuoi
echo "<h3>Một số sản phẩm có doTuoi:</h3>";
$stmt = $pdo->query("SELECT masp, tensp, doTuoi FROM tblsanpham WHERE doTuoi IS NOT NULL AND doTuoi != '' LIMIT 10");
$products = $stmt->fetchAll();
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Mã SP</th><th>Tên SP</th><th>Độ tuổi</th></tr>";
foreach ($products as $p) {
    echo "<tr>";
    echo "<td>{$p['masp']}</td>";
    echo "<td>{$p['tensp']}</td>";
    echo "<td>" . htmlspecialchars($p['doTuoi']) . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
