<?php
// QUAN TRỌNG: Start session TRƯỚC KHI output bất kỳ HTML nào
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../app/config.php");
require_once("../app/DB.php");
require_once("./config.php");
require_once("../models/OrderModel.php");
require_once("../models/OrderDetailModel.php");
require_once("../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

$vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}

$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// Xử lý kết quả thanh toán
$paymentSuccess = false;
$message = '';
$orderCode = $_GET['vnp_TxnRef'] ?? '';
$paidAmount = isset($_GET['vnp_Amount']) ? ($_GET['vnp_Amount'] / 100) : 0;

// Lấy thông tin đơn hàng
$orderInfo = null;
$lackAmount = 0;

if ($secureHash == $vnp_SecureHash) {
    if ($_GET['vnp_ResponseCode'] == '00') {
        // Thanh toán thành công - cập nhật đơn hàng
        $orderModel = new OrderModel();
        $orderModel->updateReceivedAmountAndStatus($orderCode, $paidAmount);
        
        // Lấy thông tin đơn hàng sau khi cập nhật
        $orders = $orderModel->select("SELECT * FROM orders WHERE order_code = ?", [$orderCode]);
        if (!empty($orders)) {
            $orderInfo = $orders[0];
            $lackAmount = $orderInfo['lack_amount'] ?? 0;
        }
        
        $paymentSuccess = true;
        $message = 'Thanh toán thành công!';
        
        // Giảm số lượng tồn kho cho các sản phẩm trong đơn hàng
        if ($orderInfo) {
            $orderDetailModel = new OrderDetailModel();
            $orderDetails = $orderDetailModel->getByOrderId($orderInfo['id']);
            
            $pdo = new PDO('mysql:host=localhost;dbname=websitedochoi;charset=utf8mb4', 'root', '');
            foreach ($orderDetails as $item) {
                $productId = $item['product_id'];
                $quantity = $item['quantity'];
                
                // Giảm số lượng tồn kho
                $stmt = $pdo->prepare("UPDATE tblsanpham SET soluong = GREATEST(0, soluong - ?) WHERE masp = ?");
                $stmt->execute([$quantity, $productId]);
            }
        }
        
        // Lưu thông báo vào session
        $_SESSION['payment_success'] = true;
        $_SESSION['payment_message'] = 'Thanh toán đơn hàng ' . $orderCode . ' thành công!';
        
        // Gửi email xác nhận đơn hàng
        $userEmail = $orderInfo['user_email'] ?? ($_SESSION['user']['email'] ?? null);
        if ($orderInfo && !empty($userEmail)) {
            $orderDetailModel = new OrderDetailModel();
            $orderDetails = $orderDetailModel->getByOrderId($orderInfo['id']);
            $orderInfo['email'] = $userEmail;
            $orderInfo['fullname'] = $orderInfo['receiver'] ?? ($_SESSION['user']['fullname'] ?? 'Quý khách');
            sendOrderConfirmationEmail($orderInfo, $orderDetails, $paidAmount);
        }
        
        // Xóa session thanh toán
        unset($_SESSION['cart']);
        unset($_SESSION['orderCode']);
        unset($_SESSION['totalAmount']);
    } else {
        $message = 'Giao dịch không thành công. Mã lỗi: ' . $_GET['vnp_ResponseCode'];
        $_SESSION['payment_error'] = $message;
    }
} else {
    $message = 'Chữ ký không hợp lệ!';
    $_SESSION['payment_error'] = $message;
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kết quả thanh toán - ToyShop</title>
    <style>
        :root {
            --primary-red: #e31837;
            --primary-blue: #003399;
            --dark-blue: #002266;
            --yellow: #ffd700;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; min-height: 100vh; }
        
        .site-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            padding: 15px 0;
        }
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--yellow);
            text-decoration: none;
        }
        .main-nav { display: flex; gap: 25px; }
        .main-nav a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        .main-nav a:hover { color: var(--yellow); }
        
        .result-container {
            max-width: 550px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .result-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 50px;
        }
        .result-icon.success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #28a745;
        }
        .result-icon.error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: var(--primary-red);
        }
        
        h2 { margin-bottom: 15px; font-size: 24px; }
        h2.success { color: #28a745; }
        h2.error { color: var(--primary-red); }
        
        .result-message { color: #666; margin-bottom: 25px; font-size: 15px; }
        
        .order-details {
            background: linear-gradient(135deg, #f0f5ff, #e8efff);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: left;
            border-left: 4px solid var(--primary-blue);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #ccc;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-row strong { color: var(--primary-blue); }
        
        .lack-warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            color: #856404;
        }
        .lack-warning strong { color: var(--primary-red); }
        
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            padding: 14px 28px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-red), #c41530);
            color: #fff;
            box-shadow: 0 4px 15px rgba(227,24,55,0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(227,24,55,0.4);
        }
        .btn-secondary {
            background: var(--primary-blue);
            color: #fff;
        }
        .btn-secondary:hover { background: var(--dark-blue); }
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #333;
        }
        .btn-warning:hover { background: #e0a800; }
        
        .countdown {
            margin-top: 25px;
            color: #999;
            font-size: 14px;
        }
        .countdown span {
            font-weight: bold;
            color: var(--primary-blue);
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <a href="<?= APP_URL ?>/Home" class="logo">🎮 TOYSHOP</a>
            <nav class="main-nav">
                <a href="<?= APP_URL ?>/Home">Trang chủ</a>
                <a href="<?= APP_URL ?>/Home#products">Sản phẩm</a>
                <a href="<?= APP_URL ?>/Home/orderHistory">Lịch sử đơn hàng</a>
            </nav>
        </div>
    </header>

    <div class="result-container">
        <?php if ($paymentSuccess): ?>
            <div class="result-icon success">✓</div>
            <h2 class="success">Thanh toán thành công!</h2>
            <p class="result-message">Cảm ơn bạn đã thanh toán. Đơn hàng của bạn đã được cập nhật.</p>
            
            <div class="order-details">
                <div class="detail-row">
                    <span>Mã đơn hàng:</span>
                    <strong><?= htmlspecialchars($orderCode) ?></strong>
                </div>
                <div class="detail-row">
                    <span>Số tiền đã thanh toán:</span>
                    <strong><?= number_format($paidAmount, 0, ',', '.') ?> ₫</strong>
                </div>
                <div class="detail-row">
                    <span>Mã giao dịch VNPAY:</span>
                    <strong><?= htmlspecialchars($_GET['vnp_TransactionNo'] ?? '') ?></strong>
                </div>
                <div class="detail-row">
                    <span>Ngân hàng:</span>
                    <strong><?= htmlspecialchars($_GET['vnp_BankCode'] ?? '') ?></strong>
                </div>
            </div>
            
            <?php if ($lackAmount > 0): ?>
            <div class="lack-warning">
                ⚠️ Đơn hàng còn thiếu <strong><?= number_format($lackAmount, 0, ',', '.') ?> ₫</strong>. 
                Bạn có thể thanh toán nốt số tiền còn lại.
            </div>
            
            <div class="btn-group">
                <a href="<?= APP_URL ?>/Home/orderHistory" class="btn btn-secondary">Xem lịch sử đơn hàng</a>
                <form action="<?= APP_URL ?>/Home/vnpayPay" method="POST" style="display:inline;">
                    <input type="hidden" name="order_code" value="<?= htmlspecialchars($orderCode) ?>">
                    <input type="hidden" name="amount" value="<?= $lackAmount ?>">
                    <button type="submit" class="btn btn-warning">Thanh toán nốt <?= number_format($lackAmount, 0, ',', '.') ?> ₫</button>
                </form>
            </div>
            <?php else: ?>
            <div class="btn-group">
                <a href="<?= APP_URL ?>/Home" class="btn btn-secondary">Về trang chủ</a>
                <a href="<?= APP_URL ?>/Home/orderHistory" class="btn btn-primary">Xem lịch sử đơn hàng</a>
            </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="result-icon error">✗</div>
            <h2 class="error">Thanh toán thất bại</h2>
            <p class="result-message"><?= htmlspecialchars($message) ?></p>
            
            <div class="btn-group">
                <a href="<?= APP_URL ?>/Home/orderHistory" class="btn btn-secondary">Xem lịch sử đơn hàng</a>
                <a href="<?= APP_URL ?>/Home" class="btn btn-primary">Về trang chủ</a>
            </div>
        <?php endif; ?>
        
        <p class="countdown">
            Tự động chuyển về lịch sử đơn hàng sau <span id="countdown">5</span> giây...
        </p>
    </div>
    
    <script>
        var seconds = 5;
        var countdown = document.getElementById('countdown');
        var timer = setInterval(function() {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = '<?= APP_URL ?>/Home/orderHistory';
            }
        }, 1000);
    </script>
</body>
</html>

<?php
// Hàm gửi email xác nhận đơn hàng
function sendOrderConfirmationEmail($order, $orderDetails, $paidAmount) {
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'chitogelovehoi@gmail.com';
        $mail->Password = 'mkur ygbo jbyz xtwi';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('chitogelovehoi@gmail.com', 'ToyShop - Đồ Chơi Trẻ Em');
        $mail->addAddress($order['email'], $order['fullname']);

        $mail->isHTML(true);
        $mail->Subject = "🎮 Xác nhận đơn hàng #{$order['order_code']} - ToyShop";
        
        // Tạo nội dung email
        $itemsHtml = '';
        $pdo = new PDO('mysql:host=localhost;dbname=websitedochoi;charset=utf8mb4', 'root', '');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        foreach ($orderDetails as $item) {
            $productName = $item['product_name'] ?? $item['tensp'] ?? 'Sản phẩm';
            
            // Lấy giá từ tblsanpham
            $stmt = $pdo->prepare("SELECT giaXuat FROM tblsanpham WHERE masp = ?");
            $stmt->execute([$item['product_id']]);
            $productInfo = $stmt->fetch();
            $price = $productInfo['giaXuat'] ?? $item['price'] ?? 0;
            $subtotal = $price * $item['quantity'];
            
            $itemsHtml .= "<tr>
                <td style='padding:12px; border-bottom:1px solid #eee;'>{$productName}</td>
                <td style='padding:12px; border-bottom:1px solid #eee; text-align:center;'>{$item['quantity']}</td>
                <td style='padding:12px; border-bottom:1px solid #eee; text-align:right;'>" . number_format($price, 0, ',', '.') . " ₫</td>
                <td style='padding:12px; border-bottom:1px solid #eee; text-align:right;'>" . number_format($subtotal, 0, ',', '.') . " ₫</td>
            </tr>";
        }
        
        $lackAmount = $order['lack_amount'] ?? 0;
        $lackHtml = '';
        if ($lackAmount > 0) {
            $lackHtml = "<p style='color:#e31837; font-weight:bold;'>⚠️ Còn thiếu: " . number_format($lackAmount, 0, ',', '.') . " ₫</p>";
        }
        
        $mail->Body = "
        <div style='font-family:Arial,sans-serif; max-width:600px; margin:0 auto;'>
            <div style='background:linear-gradient(135deg, #003399 0%, #002266 100%); padding:25px; text-align:center;'>
                <h1 style='color:#ffd700; margin:0; font-size:28px;'>🎮 TOYSHOP</h1>
                <p style='color:#fff; margin:10px 0 0; font-size:14px;'>Đồ Chơi Trẻ Em Chính Hãng</p>
            </div>
            
            <div style='padding:30px; background:#fff;'>
                <h2 style='color:#003399; margin-top:0;'>✅ Thanh toán thành công!</h2>
                <p style='color:#555;'>Xin chào <strong>{$order['fullname']}</strong>,</p>
                <p style='color:#555;'>Cảm ơn bạn đã thanh toán tại <strong style='color:#e31837;'>ToyShop</strong>. Đơn hàng của bạn đã được xác nhận.</p>
                
                <div style='background:#f0f5ff; padding:20px; border-radius:10px; margin:20px 0; border-left:4px solid #003399;'>
                    <h3 style='color:#003399; margin-top:0;'>📦 Thông tin đơn hàng</h3>
                    <p><strong>Mã đơn hàng:</strong> <span style='color:#e31837;'>{$order['order_code']}</span></p>
                    <p><strong>Ngày đặt:</strong> {$order['created_at']}</p>
                    <p><strong>Địa chỉ giao hàng:</strong> {$order['address']}</p>
                    <p><strong>Số điện thoại:</strong> {$order['phone']}</p>
                </div>
                
                <div style='margin:20px 0;'>
                    <h3 style='color:#003399; border-bottom:2px solid #003399; padding-bottom:10px;'>🛒 Chi tiết sản phẩm</h3>
                    <table style='width:100%; border-collapse:collapse;'>
                        <thead>
                            <tr style='background:#003399;'>
                                <th style='padding:12px; text-align:left; color:#fff;'>Sản phẩm</th>
                                <th style='padding:12px; text-align:center; color:#fff;'>SL</th>
                                <th style='padding:12px; text-align:right; color:#fff;'>Đơn giá</th>
                                <th style='padding:12px; text-align:right; color:#fff;'>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>{$itemsHtml}</tbody>
                    </table>
                </div>
                
                <div style='background:linear-gradient(135deg, #e31837, #c41530); padding:20px; border-radius:10px; margin:20px 0; color:#fff;'>
                    <p style='margin:5px 0;'><strong>Tổng tiền:</strong> " . number_format($order['total_amount'], 0, ',', '.') . " ₫</p>
                    <p style='margin:5px 0;'><strong>Đã thanh toán:</strong> " . number_format($paidAmount, 0, ',', '.') . " ₫</p>
                    {$lackHtml}
                </div>
                
                <div style='background:#fff3cd; border-radius:10px; padding:15px; margin:20px 0; border-left:4px solid #ffc107;'>
                    <p style='margin:0; color:#856404; font-size:14px;'>📞 <strong>Hotline:</strong> 1900 1234 | 📧 <strong>Email:</strong> support@toyshop.vn</p>
                </div>
                
                <p style='color:#666;'>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
                <p style='color:#666;'>Trân trọng,<br><strong style='color:#003399;'>🎮 ToyShop - Đồ Chơi Trẻ Em</strong></p>
            </div>
            
            <div style='background:#003399; padding:20px; text-align:center;'>
                <p style='color:#fff; margin:0; font-size:13px;'>© 2025 ToyShop - Website Đồ Chơi Trẻ Em Chính Hãng</p>
                <p style='color:#ffd700; margin:10px 0 0; font-size:12px;'>🚚 Miễn phí giao hàng đơn từ 500k | ⚡ Giao hàng hỏa tốc 4 tiếng</p>
            </div>
        </div>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>