<?php
/**
 * Test VNPay Flow - Debug file
 */
session_start();
require_once 'app/config.php';
require_once 'app/DB.php';

echo "<h2>🔍 VNPay Debug Test</h2>";

// 1. Check session
echo "<h3>1. Session Status</h3>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "Session Status: " . session_status() . "\n";
echo "User logged in: " . (isset($_SESSION['user']) ? 'Yes' : 'No') . "\n";
if (isset($_SESSION['user'])) {
    echo "User email: " . ($_SESSION['user']['email'] ?? 'N/A') . "\n";
    echo "User ID: " . ($_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? 'N/A') . "\n";
}
echo "Cart items: " . (isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0) . "\n";
echo "Order Code: " . ($_SESSION['orderCode'] ?? 'N/A') . "\n";
echo "Total Amount: " . ($_SESSION['totalAmount'] ?? 'N/A') . "\n";
echo "</pre>";

// 2. Check database connection
echo "<h3>2. Database Connection</h3>";
try {
    $pdo = DB::getInstance();
    echo "<p style='color:green;'>✅ Database connected successfully</p>";
    
    // Check orders table
    $stmt = $pdo->query("SHOW COLUMNS FROM orders");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Orders table columns: " . implode(', ', $columns) . "</p>";
    
    // Check order_details table
    $stmt = $pdo->query("SHOW COLUMNS FROM order_details");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Order_details table columns: " . implode(', ', $columns) . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Database error: " . $e->getMessage() . "</p>";
}

// 3. Check VNPay config
echo "<h3>3. VNPay Config</h3>";
if (file_exists('vnpay_php/config.php')) {
    include 'vnpay_php/config.php';
    echo "<pre>";
    echo "VNP TmnCode: " . ($vnp_TmnCode ?? 'N/A') . "\n";
    echo "VNP URL: " . ($vnp_Url ?? 'N/A') . "\n";
    echo "VNP Return URL: " . ($vnp_Returnurl ?? 'N/A') . "\n";
    echo "Hash Secret: " . (isset($vnp_HashSecret) ? substr($vnp_HashSecret, 0, 10) . '...' : 'N/A') . "\n";
    echo "</pre>";
} else {
    echo "<p style='color:red;'>❌ VNPay config file not found</p>";
}

// 4. Check cart structure
echo "<h3>4. Cart Structure</h3>";
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<pre>";
    print_r($_SESSION['cart']);
    echo "</pre>";
} else {
    echo "<p>Cart is empty</p>";
}

// 5. Test order creation
echo "<h3>5. Test Links</h3>";
echo "<p><a href='" . APP_URL . "/Home/order'>Go to Cart</a></p>";
echo "<p><a href='" . APP_URL . "/Home/checkoutInfo'>Go to Checkout</a></p>";
echo "<p><a href='" . APP_URL . "/vnpay_php/vnpay_pay.php'>Go to VNPay Pay (direct)</a></p>";

// 6. Recent orders
echo "<h3>6. Recent Orders</h3>";
try {
    $stmt = $pdo->query("SELECT id, order_code, total_amount, transaction_info, created_at FROM orders ORDER BY id DESC LIMIT 5");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($orders) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Order Code</th><th>Total</th><th>Status</th><th>Created</th></tr>";
        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>{$order['id']}</td>";
            echo "<td>{$order['order_code']}</td>";
            echo "<td>" . number_format($order['total_amount']) . "đ</td>";
            echo "<td>{$order['transaction_info']}</td>";
            echo "<td>{$order['created_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No orders found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
}
?>
