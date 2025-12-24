<?php
// ToyShop Checkout - Updated 2025
$listProductOrder = $data['listProductOrder'] ?? [];
$total = (float)($data['total'] ?? 0);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng - ToyShop</title>
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
        
        /* HEADER */
        .site-header { background: var(--primary-blue); padding: 15px 0; }
        .header-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { font-size: 24px; font-weight: 800; color: var(--yellow); text-decoration: none; }
        .main-nav { display: flex; gap: 25px; }
        .main-nav a { color: #fff; text-decoration: none; font-size: 14px; font-weight: 500; }
        .main-nav a:hover { color: var(--yellow); }
        .header-right { display: flex; align-items: center; gap: 15px; }
        .header-right a { color: #fff; text-decoration: none; font-size: 14px; }
        .cart-link { position: relative; font-size: 22px; }
        .cart-count { position: absolute; top: -8px; right: -10px; background: var(--primary-red); color: #fff; font-size: 11px; min-width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        
        /* CHECKOUT HEADER */
        .checkout-header { background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue)); color: #fff; padding: 40px 0; text-align: center; }
        .checkout-header h1 { font-size: 32px; margin-bottom: 10px; }
        .checkout-header p { opacity: 0.9; font-size: 16px; }
        
        /* MAIN CONTAINER */
        .checkout-container { max-width: 1100px; margin: 30px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 380px; gap: 30px; }
        
        /* LEFT FORM */
        .left { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
        .section-title { color: var(--primary-blue); font-size: 18px; font-weight: 700; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 3px solid var(--primary-red); display: flex; align-items: center; gap: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 14px; color: #555; margin-bottom: 6px; font-weight: 500; }
        .form-group input[type="text"], .form-group textarea { 
            width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: all 0.3s; 
        }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--primary-blue); outline: none; box-shadow: 0 0 0 3px rgba(0,51,153,0.1); }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .checkbox-group { display: flex; align-items: center; gap: 8px; margin: 15px 0; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--primary-blue); }
        .checkbox-group label { font-size: 14px; color: #555; cursor: pointer; }
        .section-divider { margin: 30px 0; }
        
        /* RIGHT SUMMARY */
        .right { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); height: fit-content; position: sticky; top: 20px; }
        .right h3 { color: var(--primary-blue); font-size: 20px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .order-items { max-height: 280px; overflow-y: auto; margin-bottom: 20px; }
        .order-item { display: flex; justify-content: space-between; align-items: flex-start; padding: 12px 0; border-bottom: 1px solid #eee; }
        .order-item:last-child { border-bottom: none; }
        .order-item .item-name { font-size: 14px; color: var(--text-dark); flex: 1; line-height: 1.4; }
        .order-item .item-price { font-size: 14px; font-weight: 700; color: var(--primary-red); white-space: nowrap; margin-left: 15px; }
        
        .summary-row { display: flex; justify-content: space-between; padding: 10px 0; font-size: 14px; border-top: 1px solid #eee; }
        .summary-row:first-child { border-top: none; }
        .summary-row.ship { color: #666; }
        
        .total-row { display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue)); color: #fff; padding: 18px 20px; border-radius: 10px; margin-top: 15px; }
        .total-row span { font-size: 16px; }
        .total-row strong { font-size: 24px; color: var(--yellow); }
        
        /* PAYMENT SECTION */
        .checkout-box { max-width: 1100px; margin: 0 auto 30px; padding: 0 20px; }
        .checkout-section { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
        
        .ship-info { background: linear-gradient(135deg, #e8f4fd, #f0f7ff); padding: 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid var(--primary-blue); }
        .ship-info h4 { color: var(--primary-blue); margin-bottom: 10px; font-size: 16px; }
        .ship-info ul { margin-left: 20px; font-size: 14px; color: #555; line-height: 1.8; }
        
        .payment-title { color: var(--primary-blue); font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .payment-options { display: flex; flex-direction: column; gap: 12px; }
        .payment-option { display: flex; align-items: center; gap: 15px; padding: 18px 20px; border: 2px solid #e0e0e0; border-radius: 12px; cursor: pointer; transition: all 0.3s; }
        .payment-option:hover { border-color: var(--primary-blue); background: #f8faff; }
        .payment-option.selected { border-color: var(--primary-blue); background: #f0f5ff; }
        .payment-option input { display: none; }
        .radio-circle { width: 22px; height: 22px; border: 2px solid #ccc; border-radius: 50%; position: relative; transition: all 0.3s; flex-shrink: 0; }
        .payment-option input:checked + .radio-circle { border-color: var(--primary-blue); background: var(--primary-blue); }
        .payment-option input:checked + .radio-circle::after { content: ''; position: absolute; top: 5px; left: 5px; width: 8px; height: 8px; background: #fff; border-radius: 50%; }
        .payment-text { flex: 1; font-size: 15px; font-weight: 500; color: var(--text-dark); }
        .payment-icon { width: 40px; height: 40px; object-fit: contain; }
        
        .payment-note { font-size: 13px; color: #666; margin-top: 20px; padding: 15px; background: #fff9e6; border-radius: 8px; border-left: 4px solid var(--yellow); }
        
        /* ORDER BUTTON */
        .order-btn-wrap { text-align: center; padding: 30px 20px; }
        .order-btn { background: linear-gradient(135deg, var(--primary-red), #c41530); color: #fff; border: none; padding: 18px 80px; font-size: 18px; font-weight: 700; border-radius: 50px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(227,24,55,0.3); }
        .order-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(227,24,55,0.4); }
        
        /* RESPONSIVE */
        @media (max-width: 900px) { 
            .checkout-container { grid-template-columns: 1fr; } 
            .right { position: static; } 
        }
    </style>
</head>
<body>
<form action="<?= APP_URL ?>/Home/placeOrder" method="POST">

<header class="site-header">
    <div class="header-container">
        <a href="<?= APP_URL ?>/Home" class="logo">🎮 TOYSHOP</a>
        <nav class="main-nav">
            <a href="<?= APP_URL ?>/Home">Trang chủ</a>
            <a href="<?= APP_URL ?>/Home#products">Sản phẩm</a>
            <a href="<?= APP_URL ?>/Home/newArrivals">Hàng mới</a>
            <a href="<?= APP_URL ?>/Home/orderHistory">Đơn hàng</a>
        </nav>
        <div class="header-right">
            <?php if (isset($_SESSION['user'])): ?>
                <span style="color: var(--yellow);">👤 <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
            <?php endif; ?>
            <a href="<?= APP_URL ?>/Home/order" class="cart-link">
                🛒
                <span class="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?></span>
            </a>
        </div>
    </div>
</header>

<div class="checkout-header">
    <h1>🛒 Xác nhận đơn hàng</h1>
    <p>Vui lòng kiểm tra và điền đầy đủ thông tin trước khi thanh toán</p>
</div>

<div class="checkout-container">
    
<div class="left">
    <h3 class="section-title">👤 Thông tin người đặt</h3>
    <div class="form-group">
        <label>Họ và tên *</label>
        <input type="text" name="order_name" required placeholder="Nhập họ và tên">
    </div>
    <div class="form-group">
        <label>Số điện thoại *</label>
        <input type="text" name="order_phone" required placeholder="Nhập số điện thoại">
    </div>

    <div class="section-divider"></div>
    
    <h3 class="section-title">📦 Thông tin người nhận</h3>
    <div class="checkbox-group">
        <input type="checkbox" id="same_info">
        <label for="same_info">Giống thông tin người đặt</label>
    </div>
    <div class="form-group">
        <label>Họ và tên</label>
        <input type="text" name="receiver_name" id="receiver_name" placeholder="Nhập họ và tên người nhận">
    </div>
    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" name="receiver_phone" id="receiver_phone" placeholder="Nhập số điện thoại người nhận">
    </div>

    <div class="section-divider"></div>
    
    <h3 class="section-title">📍 Địa chỉ nhận hàng</h3>
    <div class="checkbox-group">
        <input type="checkbox" id="pickup_store">
        <label for="pickup_store">Lấy tại cửa hàng</label>
    </div>
    <input type="hidden" id="delivery_method" name="delivery_method" value="home">
    <div class="form-group">
        <label>Quận/Huyện</label>
        <input type="text" name="district" id="district" placeholder="Nhập quận/huyện">
    </div>
    <div class="form-group">
        <label>Phường/Xã</label>
        <input type="text" name="ward" id="ward" placeholder="Nhập phường/xã">
    </div>
    <div class="form-group">
        <label>Địa chỉ cụ thể *</label>
        <input type="text" name="address" required placeholder="Số nhà, tên đường...">
    </div>

    <div class="section-divider"></div>
    
    <h3 class="section-title">📝 Ghi chú</h3>
    <div class="form-group">
        <textarea name="note" placeholder="Ghi chú thêm cho đơn hàng (nếu có)..."></textarea>
    </div>

    <input type="hidden" name="ship_fee" id="shipInput" value="0">
    <input type="hidden" name="final_amount" id="finalInput" value="<?= $total ?>">
</div>

<div class="right">
    <h3>💳 Đơn hàng của bạn</h3>
    <div class="order-items">
        <?php if (empty($listProductOrder)): ?>
            <p style="color: var(--primary-red); text-align: center; padding: 20px;">Không có sản phẩm trong giỏ hàng</p>
        <?php else: ?>
            <?php foreach ($listProductOrder as $v): ?>
                <?php $thanhTien = $v['gia'] * $v['qty']; ?>
                <div class="order-item">
                    <span class="item-name">
                        <?= htmlspecialchars($v['tensp']) ?>
                        <?= !empty($v['size']) && $v['size'] !== 'default' ? ' ('.$v['size'].')' : '' ?>
                        <strong>x<?= $v['qty'] ?></strong>
                    </span>
                    <span class="item-price"><?= number_format($thanhTien, 0, ',', '.') ?>₫</span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div class="summary-row">
        <span>Tổng tiền sản phẩm:</span>
        <strong style="color: var(--text-dark);"><?= number_format($total, 0, ',', '.') ?>₫</strong>
    </div>
    <div class="summary-row ship">
        <span>Phí vận chuyển:</span>
        <strong id="ship-fee"><?= $total >= 350000 ? 'Miễn phí' : '30,000₫' ?></strong>
    </div>
    
    <div class="total-row">
        <span>Tổng thanh toán:</span>
        <strong id="total-pay"><?= number_format($total + ($total >= 350000 ? 0 : 30000), 0, ',', '.') ?>₫</strong>
    </div>
</div>

</div>

<div class="checkout-box">
    <div class="checkout-section">
        <div class="ship-info">
            <h4>🚚 Thông tin vận chuyển</h4>
            <ul>
                <li>Đơn hàng dưới 350,000₫: Phí ship 30,000₫</li>
                <li>Đơn hàng từ 350,000₫: <strong style="color: var(--primary-blue);">Miễn phí vận chuyển</strong></li>
                <li>Thời gian giao hàng: 2-4 ngày làm việc</li>
            </ul>
        </div>

        <h3 class="payment-title">💳 Phương thức thanh toán</h3>
        <div class="payment-options">
            <label class="payment-option">
                <input type="radio" name="payment" value="bank_before" checked>
                <span class="radio-circle"></span>
                <span class="payment-text">Chuyển khoản trước (qua VNPay)</span>
                <img src="https://cdn-icons-png.flaticon.com/512/6404/6404100.png" class="payment-icon" alt="VNPay">
            </label>
            <label class="payment-option">
                <input type="radio" name="payment" value="bank_after">
                <span class="radio-circle"></span>
                <span class="payment-text">Chuyển khoản sau khi nhận hàng</span>
                <img src="https://cdn-icons-png.flaticon.com/512/2830/2830284.png" class="payment-icon" alt="Bank">
            </label>
            <label class="payment-option">
                <input type="radio" name="payment" value="cod">
                <span class="radio-circle"></span>
                <span class="payment-text">Thanh toán tiền mặt khi nhận hàng (COD)</span>
                <img src="https://cdn-icons-png.flaticon.com/512/2489/2489756.png" class="payment-icon" alt="COD">
            </label>
        </div>
        
        <div class="payment-note">
            💡 <strong>Lưu ý:</strong> Chuyển khoản trước giúp đơn hàng được xử lý và giao nhanh hơn!
        </div>
    </div>
</div>

<div class="order-btn-wrap">
    <button class="order-btn" type="submit">🛒 Đặt hàng ngay</button>
</div>

</form>

<script>
// Same info checkbox
document.getElementById("same_info").addEventListener("change", function() {
    const checked = this.checked;
    const orderName = document.querySelector('input[name="order_name"]').value;
    const orderPhone = document.querySelector('input[name="order_phone"]').value;
    const receiverName = document.getElementById("receiver_name");
    const receiverPhone = document.getElementById("receiver_phone");
    if (checked) {
        receiverName.value = orderName;
        receiverPhone.value = orderPhone;
        receiverName.setAttribute("readonly", true);
        receiverPhone.setAttribute("readonly", true);
    } else {
        receiverName.value = "";
        receiverPhone.value = "";
        receiverName.removeAttribute("readonly");
        receiverPhone.removeAttribute("readonly");
    }
});

// Pickup store checkbox
document.getElementById("pickup_store").addEventListener("change", function() {
    const checked = this.checked;
    const district = document.getElementById("district");
    const ward = document.getElementById("ward");
    const address = document.querySelector('input[name="address"]');
    const deliveryMethod = document.getElementById("delivery_method");
    if (checked) {
        district.value = ""; ward.value = ""; address.value = "";
        district.setAttribute("readonly", true);
        ward.setAttribute("readonly", true);
        address.setAttribute("readonly", true);
        address.removeAttribute("required");
        deliveryMethod.value = "store";
    } else {
        district.removeAttribute("readonly");
        ward.removeAttribute("readonly");
        address.removeAttribute("readonly");
        address.setAttribute("required", true);
        deliveryMethod.value = "home";
    }
});

// Payment option highlight
document.querySelectorAll('.payment-option').forEach(opt => {
    opt.addEventListener('click', function() {
        document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
    });
});
document.querySelector('.payment-option').classList.add('selected');

// Calculate shipping
const baseTotal = <?= $total ?>;
const shipFee = baseTotal >= 350000 ? 0 : 30000;
const finalTotal = baseTotal + shipFee;
document.getElementById('shipInput').value = shipFee;
document.getElementById('finalInput').value = finalTotal;
</script>
</body>
</html>
