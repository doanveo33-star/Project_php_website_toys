<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'app/config.php';
require_once 'app/DB.php';
require_once 'models/BaseModel.php';
require_once 'models/ReviewModel.php';

echo "<h2>Debug Model</h2>";

// Test ReviewModel
$reviewModel = new ReviewModel();

// Test 1: Kiểm tra $this->db có tồn tại không
echo "<h3>1. Kiểm tra kết nối DB trong ReviewModel:</h3>";
$reflection = new ReflectionClass($reviewModel);
$dbProp = $reflection->getProperty('db');
$dbProp->setAccessible(true);
$dbValue = $dbProp->getValue($reviewModel);
echo "<p>DB connection: " . ($dbValue ? "OK (PDO object)" : "NULL - LỖI!") . "</p>";

// Test 2: Thử query đơn giản
echo "<h3>2. Test select đơn giản:</h3>";
try {
    $result = $reviewModel->select("SELECT * FROM reviews");
    echo "<p>Kết quả select: " . count($result) . " rows</p>";
    echo "<pre>";
    print_r($result);
    echo "</pre>";
} catch (Exception $e) {
    echo "<p style='color:red'>Lỗi: " . $e->getMessage() . "</p>";
}

// Test 3: Test getAllReviews
echo "<h3>3. Test getAllReviews():</h3>";
try {
    $reviews = $reviewModel->getAllReviews();
    echo "<p>Kết quả getAllReviews: " . count($reviews) . " rows</p>";
    echo "<pre>";
    print_r($reviews);
    echo "</pre>";
} catch (Exception $e) {
    echo "<p style='color:red'>Lỗi: " . $e->getMessage() . "</p>";
}

// Test 4: Test query trực tiếp với JOIN
echo "<h3>4. Test query với JOIN:</h3>";
$pdo = new PDO('mysql:host=localhost;dbname=websitedochoi;charset=utf8mb4', 'root', '');
$sql = "SELECT r.*, p.tensp, p.hinhanh as product_image 
        FROM reviews r 
        LEFT JOIN tblsanpham p ON r.product_id = p.masp
        ORDER BY r.created_at DESC";
$result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
echo "<p>Kết quả JOIN: " . count($result) . " rows</p>";
echo "<pre>";
print_r($result);
echo "</pre>";
