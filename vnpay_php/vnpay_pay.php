<?php 
require_once("./config.php");
require_once("../app/config.php");
require_once("../app/DB.php");
require_once("../models/OrderModel.php");

$amount = isset($_SESSION['totalAmount']) ? $_SESSION['totalAmount'] : 0;
$orderCode = isset($_SESSION['orderCode']) ? $_SESSION['orderCode'] : '';

// Lấy thông tin đơn hàng từ DB nếu có
$orderInfo = null;
$lackAmount = 0;
$receivedAmount = 0;
$totalAmount = 0;

if ($orderCode) {
    $orderModel = new OrderModel();
    $orders = $orderModel->select("SELECT * FROM orders WHERE order_code = ?", [$orderCode]);
    if (!empty($orders)) {
        $orderInfo = $orders[0];
        $totalAmount = $orderInfo['total_amount'] ?? 0;
        $receivedAmount = $orderInfo['received_amount'] ?? 0;
        $lackAmount = $orderInfo['lack_amount'] ?? ($totalAmount - $receivedAmount);
        if ($lackAmount < 0) $lackAmount = 0;
        
        if ($amount <= 0) {
            $amount = $lackAmount;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanh toán đơn hàng - ToyShop</title>
    <style>
        :root {
            --primary-red: #e31837;
            --primary-blue: #003399;
            --dark-blue: #002266;
            --yellow: #ffd700;
            --light-gray: #f5f5f5;
            --text-dark: #333;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: var(--light-gray); min-height: 100vh; }
        
        /* Header */
        .site-header { background: var(--primary-blue); padding: 15px 0; }
        .header-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { font-size: 24px; font-weight: 800; color: var(--yellow); text-decoration: none; }
        .main-nav { display: flex; gap: 25px; }
        .main-nav a { color: #fff; text-decoration: none; font-size: 14px; font-weight: 500; }
        .main-nav a:hover { color: var(--yellow); }
        
        /* Container */
        .payment-container {
            width: 92%;
            max-width: 650px;
            margin: 40px auto;
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,51,153,0.1);
        }
        
        .payment-header { text-align: center; margin-bottom: 30px; }
        .payment-header h2 { color: var(--primary-blue); font-size: 26px; margin-bottom: 8px; }
        .order-code { color: #666; font-size: 15px; }
        .order-code strong { color: var(--primary-blue); }
        
        /* Order Summary */
        .order-summary {
            background: linear-gradient(135deg, #f0f5ff, #e8f0ff);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-blue);
        }
        .order-summary h3 { color: var(--primary-blue); margin-bottom: 15px; font-size: 16px; }
        .summary-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #ccc; font-size: 15px; }
        .summary-row:last-child { border-bottom: none; }
        .summary-row.total { font-weight: 700; font-size: 18px; color: var(--primary-red); border-top: 2px solid var(--primary-blue); margin-top: 10px; padding-top: 15px; border-bottom: none; }
        .text-success { color: #28a745; font-weight: 600; }
        .text-danger { color: var(--primary-red); font-weight: 600; }
        
        /* Form */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark); font-size: 15px; }
        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .form-control:focus { outline: none; border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(0,51,153,0.1); }
        
        /* Payment Methods */
        .payment-methods { margin-bottom: 25px; }
        .payment-methods h3 { color: var(--primary-blue); margin-bottom: 15px; font-size: 16px; }
        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px 18px;
            border: 2px solid #e5e5e5;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-option:hover { border-color: var(--primary-blue); background: #f8faff; }
        .payment-option.selected { border-color: var(--primary-blue); background: #f0f5ff; }
        .payment-option input[type="radio"] { margin-right: 12px; width: 18px; height: 18px; accent-color: var(--primary-blue); }
        .payment-option span { flex: 1; font-size: 14px; color: var(--text-dark); }
        .payment-option img { width: 32px; height: 32px; object-fit: contain; }
        
        /* Buttons */
        .btn-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn {
            flex: 1;
            padding: 16px 24px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            border: none;
            transition: all 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-red), #c41530);
            color: white;
            box-shadow: 0 4px 15px rgba(227,24,55,0.3);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(227,24,55,0.4); }
        .btn-secondary { background: #e5e5e5; color: var(--text-dark); }
        .btn-secondary:hover { background: #d5d5d5; }
        
        /* Amount helper */
        .amount-helper { display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap; }
        .amount-btn {
            padding: 10px 16px;
            background: #f0f5ff;
            border: 2px solid var(--primary-blue);
            border-radius: 8px;
            color: var(--primary-blue);
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .amount-btn:hover { background: var(--primary-blue); color: white; }
        
        /* Note */
        .note {
            background: #fff9e6;
            border-left: 4px solid var(--yellow);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #856404;
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

<div class="payment-container">
    <div class="payment-header">
        <h2>💳 Thanh toán đơn hàng</h2>
        <p class="order-code">Mã đơn hàng: <strong><?= htmlspecialchars($orderCode) ?></strong></p>
    </div>
    
    <?php if ($orderInfo): ?>
    <div class="order-summary">
        <h3>📋 Thông tin đơn hàng</h3>
        <div class="summary-row">
            <span>Tổng tiền đơn hàng:</span>
            <span><?= number_format($totalAmount, 0, ',', '.') ?> ₫</span>
        </div>
        <?php if ($receivedAmount > 0): ?>
        <div class="summary-row">
            <span>Đã thanh toán:</span>
            <span class="text-success"><?= number_format($receivedAmount, 0, ',', '.') ?> ₫</span>
        </div>
        <?php endif; ?>
        <div class="summary-row total">
            <span>Còn phải thanh toán:</span>
            <span class="text-danger"><?= number_format($lackAmount, 0, ',', '.') ?> ₫</span>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if ($lackAmount > 0 && $lackAmount != $amount): ?>
    <div class="note">
        💡 <strong>Lưu ý:</strong> Bạn có thể thanh toán một phần hoặc toàn bộ số tiền còn thiếu.
    </div>
    <?php endif; ?>
    
    <form action="vnpay_create_payment.php" method="post">
        <div class="form-group">
            <label for="amount">Số tiền thanh toán (VNĐ)</label>
            <input class="form-control" id="amount" name="amount" type="number" 
                   min="10000" max="<?= $lackAmount > 0 ? $lackAmount : 100000000 ?>" 
                   value="<?= $amount ?>" required>
            
            <?php if ($lackAmount > 0): ?>
            <div class="amount-helper">
                <button type="button" class="amount-btn" onclick="setAmount(<?= $lackAmount ?>)">
                    💰 Thanh toán toàn bộ (<?= number_format($lackAmount, 0, ',', '.') ?>₫)
                </button>
                <?php if ($lackAmount >= 100000): ?>
                <button type="button" class="amount-btn" onclick="setAmount(<?= floor($lackAmount/2) ?>)">
                    Thanh toán 50%
                </button>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="payment-methods">
            <h3>Chọn phương thức thanh toán</h3>
            
            <label class="payment-option selected">
                <input type="radio" name="bankCode" value="" checked>
                <span>Cổng thanh toán VNPAY (QR Code, Thẻ, Ví điện tử)</span>
                <img src="https://cdn-icons-png.flaticon.com/512/6963/6963703.png" alt="">
            </label>
            
            <label class="payment-option">
                <input type="radio" name="bankCode" value="VNPAYQR">
                <span>Quét mã VNPAY QR</span>
                <img src="https://cdn-icons-png.flaticon.com/512/3388/3388930.png" alt="">
            </label>
            
            <label class="payment-option">
                <input type="radio" name="bankCode" value="VNBANK">
                <span>Thẻ ATM / Tài khoản ngân hàng nội địa</span>
                <img src="https://cdn-icons-png.flaticon.com/512/2331/2331949.png" alt="">
            </label>
            
            <label class="payment-option">
                <input type="radio" name="bankCode" value="INTCARD">
                <span>Thẻ thanh toán quốc tế (Visa, Master, JCB)</span>
                <img src="https://cdn-icons-png.flaticon.com/512/349/349221.png" alt="">
            </label>
        </div>
        
        <input type="hidden" name="language" value="vn">
        
        <div class="btn-group">
            <a href="<?= APP_URL ?>/Home/order" class="btn btn-secondary">← Quay lại</a>
            <button type="submit" class="btn btn-primary">Thanh toán ngay →</button>
        </div>
    </form>
</div>

<script>
function setAmount(value) {
    document.getElementById('amount').value = value;
}

// Highlight selected payment option
document.querySelectorAll('.payment-option').forEach(opt => {
    opt.addEventListener('click', function() {
        document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
    });
});
</script>
</body>
</html>
