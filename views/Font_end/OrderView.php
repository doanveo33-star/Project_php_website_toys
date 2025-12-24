<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng - ToyShop</title>
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
        .header-right a { color: #fff; text-decoration: none; font-size: 14px; }
        
        /* CART PAGE */
        .cart-page { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        .cart-title { font-size: 28px; color: var(--primary-blue); margin-bottom: 10px; }
        .cart-count { color: #666; margin-bottom: 25px; }
        
        .cart-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            background: var(--primary-blue);
            color: #fff;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
        }
        
        .cart-item {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            align-items: center;
            background: #fff;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        .cart-item:last-of-type { border-radius: 0 0 10px 10px; }
        
        .product-box { display: flex; gap: 15px; align-items: center; }
        .cart-img { width: 80px; height: 80px; object-fit: contain; background: var(--light-gray); border-radius: 8px; padding: 5px; }
        .cart-name { font-weight: 600; color: var(--text-dark); margin-bottom: 5px; }
        .cart-meta { font-size: 12px; color: #999; }
        
        .price { font-weight: 600; color: var(--primary-red); }
        
        .qty { display: flex; align-items: center; gap: 5px; }
        .qty-btn { width: 32px; height: 32px; border: 1px solid #ddd; background: #fff; cursor: pointer; border-radius: 6px; font-size: 16px; }
        .qty-btn:hover { background: var(--light-gray); }
        .qty input { width: 50px; height: 32px; text-align: center; border: 1px solid #ddd; border-radius: 6px; }
        
        .total { font-weight: 700; color: var(--primary-blue); }
        .delete { display: block; margin-top: 8px; color: var(--primary-red); font-size: 12px; text-decoration: none; }
        .delete:hover { text-decoration: underline; }
        
        .cart-actions { display: flex; gap: 15px; margin-top: 25px; justify-content: flex-end; }
        .btn-update, .btn-order {
            padding: 14px 30px;
            border-radius: 25px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }
        .btn-update { background: #fff; color: var(--primary-blue); border: 2px solid var(--primary-blue); }
        .btn-update:hover { background: var(--primary-blue); color: #fff; }
        .btn-order { background: var(--primary-red); color: #fff; }
        .btn-order:hover { background: #c41530; }
        
        /* EMPTY CART */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 12px;
        }
        .empty-cart .icon { font-size: 64px; margin-bottom: 20px; }
        .empty-cart h3 { color: #666; margin-bottom: 15px; }
        .empty-cart a {
            display: inline-block;
            padding: 12px 30px;
            background: var(--primary-red);
            color: #fff;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .cart-header { display: none; }
            .cart-item { grid-template-columns: 1fr; gap: 15px; }
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
            <a href="<?= APP_URL ?>/Home/orderHistory">Đơn hàng</a>
        </nav>
        <div class="header-right">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?= APP_URL ?>/AuthController/logout">Đăng xuất</a>
            <?php else: ?>
                <a href="<?= APP_URL ?>/AuthController/ShowLogin">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="cart-page">
    <h1 class="cart-title">🛒 Giỏ hàng của bạn</h1>

    <?php if (empty($listProductOrder)): ?>
        <div class="empty-cart">
            <div class="icon">🛒</div>
            <h3>Giỏ hàng trống</h3>
            <p style="color: #999; margin-bottom: 20px;">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
            <a href="<?= APP_URL ?>/Home">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <p class="cart-count">Bạn có <strong><?= count($listProductOrder) ?></strong> sản phẩm trong giỏ hàng</p>

        <div class="cart-header">
            <div>Sản phẩm</div>
            <div>Giá</div>
            <div>Số lượng</div>
            <div>Tạm tính</div>
        </div>

        <form action="<?= APP_URL ?>/Home/update" method="post">
            <?php foreach ($listProductOrder as $v): ?>
                <?php 
                if (($v['type'] ?? 'product') === 'addon') continue;
                $thanhTien = $v['gia'] * $v['qty'];
                ?>
                <div class="cart-item">
                    <div class="product-box">
                        <img src="<?= APP_URL ?>/public/images/<?= htmlspecialchars($v['hinhanh']) ?>" class="cart-img">
                        <div>
                            <div class="cart-name"><?= htmlspecialchars($v['tensp']) ?></div>
                            <div class="cart-meta">SKU: <?= $v['masp'] ?></div>
                        </div>
                    </div>

                    <div class="price"><?= number_format($v['gia'], 0, ',', '.') ?> ₫</div>

                    <div class="qty">
                        <button type="button" class="qty-btn minus">−</button>
                        <input type="number" name="qty[<?= $v['masp'] ?>][<?= !empty($v['size']) ? $v['size'] : 'default' ?>]" value="<?= $v['qty'] ?>" min="1">
                        <button type="button" class="qty-btn plus">+</button>
                    </div>

                    <div class="total">
                        <?= number_format($thanhTien, 0, ',', '.') ?> ₫
                        <a class="delete" href="<?= APP_URL ?>/Home/delete/<?= $v['masp'] ?>/<?= !empty($v['size']) ? urlencode($v['size']) : 'default' ?>" onclick="return confirm('Xoá sản phẩm này?')">Xoá</a>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="cart-actions">
                <button type="submit" class="btn-update">Cập nhật giỏ hàng</button>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="<?= APP_URL ?>/Home/checkoutInfo" class="btn-order">Tiến hành đặt hàng</a>
                <?php else: ?>
                    <a href="<?= APP_URL ?>/AuthController/ShowLogin" class="btn-order">Đăng nhập để đặt hàng</a>
                <?php endif; ?>
            </div>
        </form>
    <?php endif; ?>
</div>

    <!-- SẢN PHẨM LIÊN QUAN -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="related-section">
        <h2 class="related-title">🎁 Sản phẩm bạn có thể thích</h2>
        <div class="related-grid">
            <?php foreach ($relatedProducts as $rp): 
                $discountPercent = $rp['discount_percent'] ?? 0;
                $giaGoc = $rp['giaXuat'] ?? 0;
                $giaSauGiam = $discountPercent > 0 ? round($giaGoc * (100 - $discountPercent) / 100) : $giaGoc;
            ?>
            <a href="<?= APP_URL ?>/Home/quickBuy/<?= $rp['masp'] ?>" class="related-card">
                <?php if ($discountPercent > 0): ?>
                <span class="related-badge">-<?= $discountPercent ?>%</span>
                <?php endif; ?>
                <img src="<?= APP_URL ?>/public/Images/<?= $rp['hinhanh'] ?>" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                <div class="related-info">
                    <div class="related-name"><?= htmlspecialchars($rp['tensp']) ?></div>
                    <div class="related-price">
                        <?php if ($discountPercent > 0): ?>
                        <span class="sale-price"><?= number_format($giaSauGiam) ?> ₫</span>
                        <span class="old-price"><?= number_format($giaGoc) ?> ₫</span>
                        <?php else: ?>
                        <span class="sale-price"><?= number_format($giaGoc) ?> ₫</span>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="related-btn">🛒 Thêm vào giỏ</button>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
/* RELATED PRODUCTS */
.related-section {
    margin-top: 40px;
    padding: 30px;
    background: #fff;
    border-radius: 12px;
}
.related-title {
    font-size: 22px;
    color: var(--primary-blue);
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--light-gray);
}
.related-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.related-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 15px;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s;
    position: relative;
    display: flex;
    flex-direction: column;
}
.related-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,51,153,0.15);
    border-color: var(--primary-blue);
}
.related-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: var(--primary-red);
    color: #fff;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 700;
}
.related-card img {
    width: 100%;
    height: 120px;
    object-fit: contain;
    margin-bottom: 12px;
}
.related-info {
    flex: 1;
}
.related-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
    line-height: 1.4;
    height: 36px;
    overflow: hidden;
}
.related-price {
    margin-bottom: 12px;
}
.related-price .sale-price {
    font-size: 15px;
    font-weight: 700;
    color: var(--primary-red);
}
.related-price .old-price {
    font-size: 12px;
    color: #999;
    text-decoration: line-through;
    margin-left: 5px;
}
.related-btn {
    width: 100%;
    padding: 10px;
    background: var(--primary-blue);
    color: #fff;
    border: none;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}
.related-btn:hover {
    background: var(--dark-blue);
}

@media (max-width: 992px) {
    .related-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .related-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .related-grid { grid-template-columns: 1fr; }
}
</style>

<script>
document.addEventListener('click', e => {
    if (e.target.classList.contains('plus')) {
        e.target.previousElementSibling.value++;
    }
    if (e.target.classList.contains('minus')) {
        const i = e.target.nextElementSibling;
        i.value = Math.max(1, i.value - 1);
    }
});
</script>

</body>
</html>
