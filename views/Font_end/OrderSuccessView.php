<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - ToyShop</title>
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
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #28a745;
        }
        
        h2 { margin-bottom: 15px; font-size: 24px; color: #28a745; }
        
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
        
        .cod-notice {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            color: #856404;
            text-align: left;
        }
        .cod-notice strong { color: var(--primary-red); }
        
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
        <div class="result-icon">✓</div>
        <h2>Đặt hàng thành công!</h2>
        <p class="result-message">Cảm ơn bạn đã đặt hàng tại ToyShop. Đơn hàng của bạn đang được xử lý.</p>
        
        <div class="order-details">
            <div class="detail-row">
                <span>Mã đơn hàng:</span>
                <strong><?= htmlspecialchars($orderCode ?? '') ?></strong>
            </div>
            <div class="detail-row">
                <span>Tổng tiền:</span>
                <strong><?= number_format($totalAmount ?? 0, 0, ',', '.') ?> ₫</strong>
            </div>
            <div class="detail-row">
                <span>Phương thức thanh toán:</span>
                <strong>Thanh toán khi nhận hàng (COD)</strong>
            </div>
        </div>
        
        <div class="cod-notice">
            💰 <strong>Lưu ý:</strong> Bạn sẽ thanh toán <strong><?= number_format($totalAmount ?? 0, 0, ',', '.') ?> ₫</strong> khi nhận hàng. 
            Vui lòng chuẩn bị đúng số tiền để thuận tiện cho việc giao hàng.
        </div>
        
        <div class="btn-group">
            <a href="<?= APP_URL ?>/Home" class="btn btn-secondary">Tiếp tục mua sắm</a>
            <a href="<?= APP_URL ?>/Home/orderHistory" class="btn btn-primary">Xem đơn hàng</a>
        </div>
        
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
