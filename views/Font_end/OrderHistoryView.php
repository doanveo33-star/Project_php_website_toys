<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Lịch sử đơn hàng - ToyShop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        .header-container { max-width: 1400px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { font-size: 24px; font-weight: 800; color: var(--yellow); text-decoration: none; }
        .main-nav { display: flex; gap: 25px; }
        .main-nav a { color: #fff; text-decoration: none; font-size: 14px; font-weight: 500; }
        .main-nav a:hover { color: var(--yellow); }
        .header-right { display: flex; align-items: center; gap: 15px; }
        .header-right a { color: #fff; text-decoration: none; }
        .cart-link { position: relative; font-size: 22px; }
        .cart-count { position: absolute; top: -8px; right: -10px; background: var(--primary-red); color: #fff; font-size: 11px; min-width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        
        /* Page Header */
        .page-header { background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue)); color: #fff; padding: 40px 0; text-align: center; }
        .page-header h1 { font-size: 32px; margin-bottom: 10px; }
        .page-header p { opacity: 0.9; }
        
        /* Container */
        .container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
        
        /* Table */
        .orders-table { width: 100%; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
        .orders-table thead { background: var(--primary-blue); color: #fff; }
        .orders-table th { padding: 15px 12px; text-align: left; font-size: 13px; font-weight: 600; }
        .orders-table td { padding: 15px 12px; border-bottom: 1px solid #eee; font-size: 14px; vertical-align: top; }
        .orders-table tbody tr:hover { background: #f8faff; }
        .orders-table tbody tr:last-child td { border-bottom: none; }
        
        /* Order Code */
        .order-code { font-weight: 700; color: var(--primary-blue); }
        
        /* Amount Info */
        .amount-info { font-size: 13px; }
        .amount-total { font-weight: 600; color: var(--text-dark); }
        .amount-paid { color: #28a745; margin-top: 4px; }
        .amount-lack { color: var(--primary-red); margin-top: 4px; }
        
        /* Status Badge */
        .badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        
        /* Payment Method */
        .payment-method { font-size: 13px; color: #666; }
        
        /* Buttons */
        .btn { display: inline-block; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-info { background: var(--primary-blue); color: #fff; }
        .btn-info:hover { background: var(--dark-blue); }
        .btn-primary { background: var(--primary-red); color: #fff; margin-top: 8px; }
        .btn-primary:hover { background: #c41530; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        
        /* Empty State */
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state .icon { font-size: 64px; margin-bottom: 20px; }
        .empty-state h3 { color: #666; margin-bottom: 15px; }
        .empty-state a { display: inline-block; padding: 12px 30px; background: var(--primary-red); color: #fff; text-decoration: none; border-radius: 25px; font-weight: 600; }
        
        /* Alert */
        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .orders-table { display: block; overflow-x: auto; }
        }
        @media (max-width: 768px) {
            .main-nav { display: none; }
            .orders-table th, .orders-table td { padding: 10px 8px; font-size: 12px; }
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
            <a href="<?= APP_URL ?>/Home/newArrivals">Hàng mới</a>
            <a href="<?= APP_URL ?>/Home/favorites">Yêu thích</a>
        </nav>
        <div class="header-right">
            <?php if (isset($_SESSION['user'])): ?>
                <span style="color: var(--yellow); font-size: 14px;">👤 <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
            <?php endif; ?>
            <a href="<?= APP_URL ?>/Home/order" class="cart-link">
                🛒
                <span class="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?></span>
            </a>
        </div>
    </div>
</header>

<div class="page-header">
    <h1>📋 Lịch sử đơn hàng</h1>
    <p>Theo dõi và quản lý các đơn hàng của bạn</p>
</div>

<div class="container">
    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($data['orders'])): ?>
    <table class="orders-table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Người nhận</th>
                <th>Địa chỉ giao hàng</th>
                <th>SĐT</th>
                <th>Trạng thái</th>
                <th>Thanh toán</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data['orders'] as $order): 
            $status = $order['transaction_info'] ?? '';
            $pm = $order['payment_method'] ?? '';
        ?>
            <tr>
                <td><span class="order-code"><?= htmlspecialchars($order['order_code']) ?></span></td>
                <td><?= htmlspecialchars($order['created_at']) ?></td>
                <td>
                    <div class="amount-info">
                        <div class="amount-total"><?= number_format($order['total_amount'], 0, ',', '.') ?> ₫</div>
                        <?php if ($status == 'dathanhtoan'): ?>
                            <div class="amount-paid">✓ Đã thanh toán đủ</div>
                        <?php elseif (isset($order['received_amount']) && $order['received_amount'] > 0): ?>
                            <div class="amount-paid">Đã TT: <?= number_format($order['received_amount'], 0, ',', '.') ?>₫</div>
                            <div class="amount-lack">Còn: <?= number_format($order['lack_amount'], 0, ',', '.') ?>₫</div>
                        <?php endif; ?>
                    </div>
                </td>
                <td><?= htmlspecialchars($order['receiver']) ?></td>
                <td><?= htmlspecialchars(($order['delivery_method'] ?? '') === 'store' ? 'Lấy tại cửa hàng' : ($order['address'] ?? '')) ?></td>
                <td><?= htmlspecialchars($order['phone']) ?></td>
                <td>
                    <?php if ($status == 'dathanhtoan'): ?>
                        <span class="badge badge-success">Đã thanh toán</span>
                    <?php elseif ($status == 'thanhtoanthieu'): ?>
                        <span class="badge badge-warning">Thanh toán thiếu</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Chưa thanh toán</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="payment-method">
                    <?php 
                        if ($pm == 'bank_before') echo 'Chuyển khoản trước';
                        elseif ($pm == 'bank_after' || $pm == 'bank') echo 'CK sau khi nhận';
                        else echo 'Tiền mặt (COD)';
                    ?>
                    </span>
                </td>
                <td>
                    <a href="<?= APP_URL ?>/Home/orderDetail/<?= $order['id'] ?>" class="btn btn-info btn-sm">Xem chi tiết</a>
                    <?php 
                    $isBank = in_array($pm, ['bank', 'bank_before', 'bank_after']);
                    $needsPayment = empty($status) || $status == 'chothanhtoan' || $status == 'thanhtoanthieu';
                    if ($isBank && $needsPayment): 
                    ?>
                    <form action="<?= APP_URL ?>/Home/vnpayPay" method="POST" style="display: inline;">
                        <input type="hidden" name="order_code" value="<?= htmlspecialchars($order['order_code']) ?>">
                        <input type="hidden" name="amount" value="<?= isset($order['lack_amount']) && $order['lack_amount'] > 0 ? $order['lack_amount'] : $order['total_amount'] ?>">
                        <button type="submit" class="btn btn-primary btn-sm">
                            💳 Thanh toán
                        </button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state" style="background: #fff; border-radius: 12px;">
        <div class="icon">📦</div>
        <h3>Bạn chưa có đơn hàng nào</h3>
        <p style="color: #999; margin-bottom: 20px;">Hãy khám phá và mua sắm những sản phẩm yêu thích!</p>
        <a href="<?= APP_URL ?>/Home">🛍️ Mua sắm ngay</a>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
