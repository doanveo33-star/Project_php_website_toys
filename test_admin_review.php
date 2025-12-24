<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load như Admin controller
require_once 'app/config.php';
require_once 'app/DB.php';
require_once 'app/Controller.php';
require_once 'models/BaseModel.php';
require_once 'models/ReviewModel.php';

echo "<h2>Test Admin Review</h2>";

// Test 1: Trực tiếp PDO
echo "<h3>1. Query trực tiếp PDO:</h3>";
$pdo = new PDO('mysql:host=localhost;dbname=websitedochoi;charset=utf8mb4', 'root', '');
$result = $pdo->query("SELECT * FROM reviews")->fetchAll(PDO::FETCH_ASSOC);
echo "<p>Số lượng từ PDO: <strong>" . count($result) . "</strong></p>";

// Test 2: ReviewModel
echo "<h3>2. Query từ ReviewModel:</h3>";
$reviewModel = new ReviewModel();
$reviews = $reviewModel->getAllReviews();
echo "<p>Số lượng từ Model: <strong>" . count($reviews) . "</strong></p>";

if (!empty($reviews)) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>User</th><th>Product</th><th>Rating</th><th>Status</th></tr>";
    foreach ($reviews as $r) {
        echo "<tr><td>{$r['id']}</td><td>{$r['user_name']}</td><td>{$r['product_id']}</td><td>{$r['rating']}</td><td>{$r['status']}</td></tr>";
    }
    echo "</table>";
}

// Test 3: Kiểm tra database name trong DB class
echo "<h3>3. Kiểm tra DB class:</h3>";
$db = new DB();
// Reflection để xem private property
$reflection = new ReflectionClass($db);
$dbnameProp = $reflection->getProperty('dbname');
$dbnameProp->setAccessible(true);
echo "<p>Database name trong DB class: <strong>" . $dbnameProp->getValue($db) . "</strong></p>";

echo "<hr><a href='".APP_URL."/Admin/reviewList'>Đi đến Admin Reviews</a>";
