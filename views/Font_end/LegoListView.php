<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'LEGO') ?> - ToyShop</title>
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
        .search-wrapper { flex: 1; max-width: 550px; }
        .search-box { display: flex; background: #fff; border-radius: 25px; overflow: hidden; }
        .search-box input { flex: 1; border: none; padding: 12px 20px; font-size: 14px; outline: none; }
        .search-box button { background: var(--yellow); border: none; padding: 12px 25px; cursor: pointer; }
        .header-actions { display: flex; align-items: center; gap: 20px; }
        .header-btn { display: flex; flex-direction: column; align-items: center; color: #fff; text-decoration: none; font-size: 12px; }
        .header-btn .icon { font-size: 24px; margin-bottom: 3px; }
        
        /* BREADCRUMB */
        .breadcrumb { padding: 15px 0; background: #fff; border-bottom: 1px solid #eee; }
        .breadcrumb a { color: var(--primary-blue); text-decoration: none; }
        .breadcrumb span { color: #666; }
        
        /* PAGE TITLE */
        .page-title { padding: 30px 0; background: linear-gradient(135deg, var(--primary-red) 0%, #ff4757 100%); color: #fff; text-align: center; }
        .page-title h1 { font-size: 32px; margin-bottom: 10px; }
        .page-title p { opacity: 0.9; }
        
        /* FILTERS */
        .filters-section { padding: 20px 0; background: #fff; margin-bottom: 20px; }
        .filters-row { display: flex; gap: 15px; flex-wrap: wrap; align-items: center; }
        .filter-btn { padding: 10px 20px; background: #f5f5f5; border: none; border-radius: 25px; cursor: pointer; font-size: 14px; transition: all 0.2s; }
        .filter-btn:hover, .filter-btn.active { background: var(--primary-red); color: #fff; }
        
        /* PRODUCTS GRID */
        .products-section { padding: 20px 0 60px; }
        .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
        .product-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.08); transition: all 0.3s; position: relative; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,51,153,0.15); }
        .discount-badge { position: absolute; top: 12px; left: 12px; background: var(--primary-red); color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 2; }
        .product-image-wrapper { position: relative; width: 100%; height: 220px; overflow: hidden; background: var(--light-gray); }
        .product-image-wrapper img { width: 100%; height: 100%; object-fit: contain; padding: 15px; }
        .product-info { padding: 15px; }
        .product-theme { font-size: 11px; color: var(--primary-blue); text-transform: uppercase; margin-bottom: 5px; font-weight: 600; }
        .product-name { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; line-height: 1.4; height: 40px; overflow: hidden; }
        .product-meta { font-size: 11px; color: #999; margin-bottom: 10px; }
        .price-wrapper { margin-bottom: 15px; }
        .current-price { font-size: 18px; font-weight: 700; color: var(--primary-red); }
        .original-price { font-size: 13px; color: #999; text-decoration: line-through; margin-left: 8px; }
        .add-cart-btn { width: 100%; background: var(--primary-red); color: #fff; border: none; padding: 12px 20px; border-radius: 25px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .add-cart-btn:hover { background: #c41530; }
        
        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; }
        .empty-state .icon { font-size: 64px; margin-bottom: 20px; }
        .empty-state h3 { color: #666; margin-bottom: 10px; }
        
        /* RESPONSIVE */
        @media (max-width: 1200px) { .products-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .products-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <a href="<?= APP_URL ?>/Home/" class="logo-text">🎮 TOYSHOP</a>
            <div class="search-wrapper">
                <div class="search-box">
                    <input type="text" placeholder="Tìm kiếm sản phẩm LEGO...">
                    <button type="button">🔍</button>
                </div>
            </div>
            <div class="header-actions">
                <a href="<?= APP_URL ?>/Home/order" class="header-btn">
                    <span class="icon">🛒</span>
                    <span>Giỏ hàng</span>
                </a>
            </div>
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
        <span><?= htmlspecialchars($data['title'] ?? 'Danh sách') ?></span>
    </div>
</div>

<!-- PAGE TITLE -->
<div class="page-title">
    <div class="container">
        <h1>🧱 <?= htmlspecialchars($data['title'] ?? 'LEGO') ?></h1>
        <p>Khám phá bộ sưu tập LEGO chính hãng tại ToyShop</p>
    </div>
</div>

<!-- FILTERS -->
<?php if (!empty($data['themes'])): ?>
<div class="filters-section">
    <div class="container">
        <div class="filters-row">
            <span style="font-weight: 600; margin-right: 10px;">Dòng sản phẩm:</span>
            <?php foreach ($data['themes'] as $theme): ?>
            <a href="<?= APP_URL ?>/Home/legoByTheme/<?= $theme['ma_theme'] ?>" class="filter-btn">
                <?= htmlspecialchars($theme['ten_theme']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- PRODUCTS -->
<section class="products-section">
    <div class="container">
        <?php 
        $products = $data['products'] ?? [];
        if (empty($products)): 
        ?>
        <div class="empty-state">
            <div class="icon">🧱</div>
            <h3>Chưa có sản phẩm nào</h3>
            <p>Vui lòng quay lại sau!</p>
        </div>
        <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $p): 
                $hasDiscount = !empty($p['giaKhuyenMai']) && $p['giaKhuyenMai'] < $p['giaXuat'];
                $discountPercent = $hasDiscount ? round((1 - $p['giaKhuyenMai'] / $p['giaXuat']) * 100) : 0;
            ?>
            <div class="product-card">
                <?php if ($hasDiscount): ?>
                <span class="discount-badge">-<?= $discountPercent ?>%</span>
                <?php endif; ?>
                
                <div class="product-image-wrapper">
                    <a href="<?= APP_URL ?>/Home/legoDetail/<?= $p['masp'] ?>">
                        <img src="<?= APP_URL ?>/public/images/<?= $p['hinhanh'] ?>" alt="<?= htmlspecialchars($p['tensp']) ?>">
                    </a>
                </div>
                
                <div class="product-info">
                    <div class="product-theme"><?= htmlspecialchars($p['ma_theme']) ?></div>
                    <h3 class="product-name"><?= htmlspecialchars($p['tensp']) ?></h3>
                    <div class="product-meta">
                        <?= $p['soManhGhep'] ?> mảnh ghép | <?= $p['doTuoi'] ?>
                    </div>
                    <div class="price-wrapper">
                        <?php if ($hasDiscount): ?>
                        <span class="current-price"><?= number_format($p['giaKhuyenMai']) ?> ₫</span>
                        <span class="original-price"><?= number_format($p['giaXuat']) ?> ₫</span>
                        <?php else: ?>
                        <span class="current-price"><?= number_format($p['giaXuat']) ?> ₫</span>
                        <?php endif; ?>
                    </div>
                    <button class="add-cart-btn" onclick="addLegoToCart('<?= $p['masp'] ?>')">🛒 Thêm Vào Giỏ</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
function addLegoToCart(masp) {
    fetch('<?= APP_URL ?>/Home/addLegoToCart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `masp=${masp}&qty=1`
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
</script>

</body>
</html>
