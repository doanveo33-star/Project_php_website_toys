<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['product']['tensp'] ?? 'LEGO') ?> - ToyShop</title>
    <style>
        :root {
            --primary-red: #e31837;
            --primary-blue: #003399;
            --dark-blue: #002266;
            --yellow: #ffd700;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --text-dark: #333333;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 15px; }
        
        /* HEADER */
        .main-header { background: var(--primary-blue); padding: 15px 0; }
        .header-content { display: flex; align-items: center; justify-content: space-between; gap: 30px; }
        .logo-text { font-size: 28px; font-weight: 800; color: var(--yellow); text-decoration: none; }
        
        /* BREADCRUMB */
        .breadcrumb { padding: 15px 0; background: #fff; border-bottom: 1px solid #eee; }
        .breadcrumb a { color: var(--primary-blue); text-decoration: none; }
        .breadcrumb span { color: #666; }
        
        /* PRODUCT DETAIL */
        .product-detail { padding: 40px 0; }
        .product-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; background: #fff; padding: 30px; border-radius: 12px; }
        
        .product-gallery { text-align: center; }
        .product-main-image { width: 100%; max-width: 450px; height: 450px; object-fit: contain; background: var(--light-gray); border-radius: 12px; padding: 20px; }
        
        .product-info-detail h1 { font-size: 24px; color: var(--text-dark); margin-bottom: 15px; line-height: 1.4; }
        .product-theme-badge { display: inline-block; background: var(--primary-blue); color: #fff; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 15px; }
        
        .product-meta-info { display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
        .meta-item { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #666; }
        .meta-item .icon { font-size: 18px; }
        
        .price-section { background: #fff3f3; padding: 20px; border-radius: 12px; margin-bottom: 25px; }
        .price-label { font-size: 13px; color: #666; margin-bottom: 5px; }
        .price-current { font-size: 32px; font-weight: 700; color: var(--primary-red); }
        .price-original { font-size: 18px; color: #999; text-decoration: line-through; margin-left: 15px; }
        .discount-tag { display: inline-block; background: var(--primary-red); color: #fff; padding: 5px 12px; border-radius: 5px; font-size: 14px; font-weight: 600; margin-left: 15px; }
        
        .quantity-section { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .quantity-label { font-weight: 600; }
        .quantity-input { display: flex; align-items: center; border: 2px solid #ddd; border-radius: 8px; overflow: hidden; }
        .quantity-input button { width: 40px; height: 40px; border: none; background: #f5f5f5; cursor: pointer; font-size: 18px; }
        .quantity-input button:hover { background: #eee; }
        .quantity-input input { width: 60px; height: 40px; border: none; text-align: center; font-size: 16px; font-weight: 600; }
        
        .action-buttons { display: flex; gap: 15px; margin-bottom: 25px; }
        .btn-add-cart { flex: 1; background: var(--primary-red); color: #fff; border: none; padding: 15px 30px; border-radius: 30px; font-size: 16px; font-weight: 600; cursor: pointer; }
        .btn-add-cart:hover { background: #c41530; }
        .btn-buy-now { flex: 1; background: var(--primary-blue); color: #fff; border: none; padding: 15px 30px; border-radius: 30px; font-size: 16px; font-weight: 600; cursor: pointer; }
        .btn-buy-now:hover { background: var(--dark-blue); }
        
        .product-description { margin-top: 30px; padding-top: 30px; border-top: 1px solid #eee; }
        .product-description h3 { font-size: 18px; margin-bottom: 15px; color: var(--text-dark); }
        .product-description p { color: #666; line-height: 1.8; }
        
        /* RELATED PRODUCTS */
        .related-section { padding: 40px 0; }
        .section-title { font-size: 24px; font-weight: 700; color: var(--primary-blue); margin-bottom: 25px; }
        .related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
        .related-card { background: #fff; border-radius: 12px; overflow: hidden; text-decoration: none; transition: all 0.3s; }
        .related-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .related-card img { width: 100%; height: 180px; object-fit: contain; background: var(--light-gray); padding: 15px; }
        .related-card-info { padding: 15px; }
        .related-card-name { font-size: 13px; color: var(--text-dark); margin-bottom: 8px; height: 36px; overflow: hidden; }
        .related-card-price { font-size: 16px; font-weight: 700; color: var(--primary-red); }
        
        @media (max-width: 992px) { .product-detail-grid { grid-template-columns: 1fr; } .related-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .related-grid { grid-template-columns: 1fr; } .action-buttons { flex-direction: column; } }
    </style>
</head>
<body>

<?php $product = $data['product'] ?? []; $theme = $data['theme'] ?? []; ?>

<!-- HEADER -->
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <a href="<?= APP_URL ?>/Home/" class="logo-text">🎮 TOYSHOP</a>
            <a href="<?= APP_URL ?>/Home/order" style="color: #fff; text-decoration: none;">🛒 Giỏ hàng</a>
        </div>
    </div>
</header>

<!-- BREADCRUMB -->
<div class="breadcrumb">
    <div class="container">
        <a href="<?= APP_URL ?>/Home/">Trang chủ</a>
        <span> / </span>
        <a href="#">LEGO</a>
        <span> / </span>
        <a href="<?= APP_URL ?>/Home/legoByTheme/<?= $product['ma_theme'] ?>"><?= htmlspecialchars($theme['ten_theme'] ?? '') ?></a>
        <span> / </span>
        <span><?= htmlspecialchars($product['tensp'] ?? '') ?></span>
    </div>
</div>

<!-- PRODUCT DETAIL -->
<section class="product-detail">
    <div class="container">
        <div class="product-detail-grid">
            <div class="product-gallery">
                <img src="<?= APP_URL ?>/public/images/<?= $product['hinhanh'] ?>" alt="" class="product-main-image">
            </div>
            
            <div class="product-info-detail">
                <span class="product-theme-badge">🧱 <?= htmlspecialchars($theme['ten_theme'] ?? 'LEGO') ?></span>
                <h1><?= htmlspecialchars($product['tensp']) ?></h1>
                
                <div class="product-meta-info">
                    <div class="meta-item"><span class="icon">🧩</span> <?= $product['soManhGhep'] ?? 0 ?> mảnh ghép</div>
                    <div class="meta-item"><span class="icon">👶</span> Độ tuổi: <?= $product['doTuoi'] ?? 'N/A' ?></div>
                    <div class="meta-item"><span class="icon">📦</span> SKU: <?= $product['masp'] ?></div>
                </div>
                
                <?php 
                $hasDiscount = !empty($product['giaKhuyenMai']) && $product['giaKhuyenMai'] < $product['giaXuat'];
                $discountPercent = $hasDiscount ? round((1 - $product['giaKhuyenMai'] / $product['giaXuat']) * 100) : 0;
                ?>
                <div class="price-section">
                    <div class="price-label">Giá bán:</div>
                    <?php if ($hasDiscount): ?>
                    <span class="price-current"><?= number_format($product['giaKhuyenMai']) ?> ₫</span>
                    <span class="price-original"><?= number_format($product['giaXuat']) ?> ₫</span>
                    <span class="discount-tag">-<?= $discountPercent ?>%</span>
                    <?php else: ?>
                    <span class="price-current"><?= number_format($product['giaXuat']) ?> ₫</span>
                    <?php endif; ?>
                </div>
                
                <div class="quantity-section">
                    <span class="quantity-label">Số lượng:</span>
                    <div class="quantity-input">
                        <button type="button" onclick="changeQty(-1)">−</button>
                        <input type="number" id="qty" value="1" min="1" max="99">
                        <button type="button" onclick="changeQty(1)">+</button>
                    </div>
                    <span style="color: #666; font-size: 14px;">Còn <?= $product['soluong'] ?? 0 ?> sản phẩm</span>
                </div>
                
                <div class="action-buttons">
                    <button class="btn-add-cart" onclick="addToCart()">🛒 Thêm Vào Giỏ Hàng</button>
                    <button class="btn-buy-now" onclick="buyNow()">⚡ Mua Ngay</button>
                </div>
                
                <div class="product-description">
                    <h3>Mô tả sản phẩm</h3>
                    <p><?= nl2br(htmlspecialchars($product['mota'] ?? 'Chưa có mô tả')) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RELATED PRODUCTS -->
<?php if (!empty($data['relatedProducts'])): ?>
<section class="related-section">
    <div class="container">
        <h2 class="section-title">Sản phẩm liên quan</h2>
        <div class="related-grid">
            <?php foreach ($data['relatedProducts'] as $rp): ?>
            <a href="<?= APP_URL ?>/Home/legoDetail/<?= $rp['masp'] ?>" class="related-card">
                <img src="<?= APP_URL ?>/public/images/<?= $rp['hinhanh'] ?>" alt="">
                <div class="related-card-info">
                    <div class="related-card-name"><?= htmlspecialchars($rp['tensp']) ?></div>
                    <div class="related-card-price"><?= number_format($rp['giaKhuyenMai'] ?? $rp['giaXuat']) ?> ₫</div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    let val = parseInt(input.value) || 1;
    val = Math.max(1, Math.min(99, val + delta));
    input.value = val;
}

function addToCart() {
    const qty = document.getElementById('qty').value;
    fetch('<?= APP_URL ?>/Home/addLegoToCart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `masp=<?= $product['masp'] ?>&qty=${qty}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Đã thêm vào giỏ hàng!');
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    });
}

function buyNow() {
    addToCart();
    setTimeout(() => {
        window.location.href = '<?= APP_URL ?>/Home/order';
    }, 500);
}
</script>

</body>
</html>
