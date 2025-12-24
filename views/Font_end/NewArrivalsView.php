<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hàng Mới - ToyShop</title>
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
        
        .main-header { background: var(--primary-blue); padding: 15px 0; position: sticky; top: 0; z-index: 1000; }
        .header-content { display: flex; align-items: center; justify-content: space-between; gap: 30px; }
        .logo-text { font-size: 28px; font-weight: 800; color: var(--yellow); text-decoration: none; }
        .search-wrapper { flex: 1; max-width: 550px; }
        .search-box { display: flex; background: #fff; border-radius: 25px; overflow: hidden; }
        .search-box input { flex: 1; border: none; padding: 12px 20px; font-size: 14px; outline: none; }
        .search-box button { background: var(--yellow); border: none; padding: 12px 25px; cursor: pointer; }
        .header-actions { display: flex; align-items: center; gap: 20px; }
        .header-btn { display: flex; flex-direction: column; align-items: center; color: #fff; text-decoration: none; font-size: 12px; }
        .header-btn .icon { font-size: 24px; margin-bottom: 3px; }
        .cart-btn { position: relative; }
        .cart-count { position: absolute; top: -5px; right: -5px; background: var(--primary-red); color: #fff; font-size: 11px; min-width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        
        .breadcrumb { padding: 15px 0; background: #fff; border-bottom: 1px solid #eee; }
        .breadcrumb a { color: var(--primary-blue); text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb span { color: #666; }
        
        .page-header { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 40px 0; color: #fff; text-align: center; }
        .page-header h1 { font-size: 32px; margin-bottom: 10px; }
        .page-header p { font-size: 16px; opacity: 0.9; }
        .category-icon { font-size: 48px; margin-bottom: 15px; }
        
        .products-section { padding: 30px 0; }
        .products-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
        .products-count { font-size: 14px; color: #666; }
        .sort-select { padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; cursor: pointer; }
        .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
        
        .product-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.08); transition: all 0.3s; position: relative; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,51,153,0.15); }
        .new-badge { position: absolute; top: 12px; left: 12px; background: #28a745; color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 2; }
        .favorite-btn { position: absolute; top: 12px; right: 12px; background: #fff; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .favorite-btn:hover { background: #ffe0e0; }
        .product-image-wrapper { position: relative; width: 100%; height: 220px; overflow: hidden; background: var(--light-gray); }
        .product-image-wrapper img { width: 100%; height: 100%; object-fit: contain; padding: 15px; transition: transform 0.3s; }
        .product-card:hover .product-image-wrapper img { transform: scale(1.05); }
        .product-info { padding: 15px; }
        .product-brand { font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 5px; }
        .product-name { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; line-height: 1.4; height: 40px; overflow: hidden; }
        .product-sku { font-size: 11px; color: #999; margin-bottom: 10px; }
        .product-age { font-size: 12px; color: var(--primary-blue); margin-bottom: 10px; font-weight: 600; }
        .price-wrapper { margin-bottom: 15px; }
        .current-price { font-size: 18px; font-weight: 700; color: var(--primary-red); }
        .add-cart-btn { width: 100%; background: var(--primary-red); color: #fff; border: none; padding: 12px 20px; border-radius: 25px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .add-cart-btn:hover { background: #c41530; transform: scale(1.02); }
        
        .no-products { text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; }
        .no-products .icon { font-size: 64px; margin-bottom: 20px; }
        .no-products h3 { font-size: 20px; color: #333; margin-bottom: 10px; }
        .no-products p { color: #666; margin-bottom: 20px; }
        .no-products a { display: inline-block; padding: 12px 30px; background: var(--primary-blue); color: #fff; text-decoration: none; border-radius: 25px; font-weight: 600; }
        
        .main-footer { background: var(--dark-blue); color: #fff; padding: 40px 0 20px; margin-top: 40px; }
        .footer-content { text-align: center; }
        .footer-logo { font-size: 24px; font-weight: 800; color: var(--yellow); margin-bottom: 15px; }
        .footer-text { font-size: 14px; opacity: 0.8; }
        
        @media (max-width: 1200px) { .products-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 992px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .products-grid { grid-template-columns: 1fr; } .page-header h1 { font-size: 24px; } }
    </style>
</head>
<body>

<header class="main-header">
    <div class="container">
        <div class="header-content">
            <a href="<?= APP_URL ?>/Home/" class="logo-text">🎮 TOYSHOP</a>
            <div class="search-wrapper">
                <div class="search-box">
                    <input type="text" id="productSearch" placeholder="Tìm kiếm sản phẩm...">
                    <button type="button" onclick="searchProducts()">🔍</button>
                </div>
            </div>
            <div class="header-actions">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="<?= APP_URL ?>/Home/orderHistory" class="header-btn">
                        <span class="icon">👤</span>
                        <span><?= htmlspecialchars($_SESSION['user']['fullname']) ?></span>
                    </a>
                    <a href="<?= APP_URL ?>/AuthController/logout" class="header-btn">
                        <span class="icon">🚪</span>
                        <span>Đăng xuất</span>
                    </a>
                <?php else: ?>
                    <a href="<?= APP_URL ?>/AuthController/ShowLogin" class="header-btn">
                        <span class="icon">👤</span>
                        <span>Đăng nhập</span>
                    </a>
                <?php endif; ?>
                <a href="<?= APP_URL ?>/Home/order" class="header-btn cart-btn">
                    <span class="icon">🛒</span>
                    <span>Giỏ hàng</span>
                    <span class="cart-count"><?php
                        $count = 0;
                        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                if (is_array($item) && isset($item['qty'])) $count += (int)$item['qty'];
                            }
                        }
                        echo $count;
                    ?></span>
                </a>
            </div>
        </div>
    </div>
</header>

<div class="breadcrumb">
    <div class="container">
        <a href="<?= APP_URL ?>/Home/">Trang chủ</a>
        <span> / </span>
        <span>Hàng Mới</span>
    </div>
</div>

<div class="page-header">
    <div class="container">
        <div class="category-icon">🆕</div>
        <h1>Hàng Mới Về</h1>
        <p>Khám phá những sản phẩm mới nhất tại ToyShop</p>
    </div>
</div>

<section class="products-section">
    <div class="container">
        <div class="products-header">
            <div class="products-count">Hiển thị <strong><?= count($products ?? []) ?></strong> sản phẩm mới</div>
            <select class="sort-select" onchange="sortProducts(this.value)">
                <option value="default">Sắp xếp: Mặc định</option>
                <option value="price-asc">Giá: Thấp đến cao</option>
                <option value="price-desc">Giá: Cao đến thấp</option>
            </select>
        </div>
        
        <?php if (!empty($products)): ?>
        <div class="products-grid" id="productsGrid">
            <?php foreach ($products as $p): ?>
            <div class="product-card" data-price="<?= $p['giaXuat'] ?? 0 ?>" data-name="<?= htmlspecialchars($p['tensp']) ?>">
                <span class="new-badge">🆕 MỚI</span>
                <button class="favorite-btn" onclick="toggleFavorite(this)" data-masp="<?= $p['masp'] ?>">❤️</button>
                <div class="product-image-wrapper">
                    <a href="<?= APP_URL ?>/Home/quickBuy/<?= $p['masp'] ?>" title="Mua ngay">
                        <img src="<?= APP_URL ?>/public/Images/<?= $p['hinhanh'] ?>" alt="<?= htmlspecialchars($p['tensp']) ?>" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                    </a>
                </div>
                <div class="product-info">
                    <div class="product-brand"><?= htmlspecialchars($p['thuongHieu'] ?? '') ?></div>
                    <h3 class="product-name">
                        <a href="<?= APP_URL ?>/Home/detail/<?= $p['masp'] ?>" style="color: inherit; text-decoration: none;">
                            <?= htmlspecialchars($p['tensp']) ?>
                        </a>
                    </h3>
                    <div class="product-sku">SKU: <?= $p['masp'] ?></div>
                    <?php if (!empty($p['doTuoi'])): ?>
                    <div class="product-age">🎯 Độ tuổi: <?= htmlspecialchars($p['doTuoi']) ?></div>
                    <?php endif; ?>
                    <div class="price-wrapper">
                        <span class="current-price"><?= number_format($p['giaXuat'] ?? 0) ?> ₫</span>
                    </div>
                    <button class="add-cart-btn" onclick="addToCart('<?= $p['masp'] ?>')">🛒 Thêm vào giỏ hàng</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="no-products">
            <div class="icon">📦</div>
            <h3>Chưa có sản phẩm mới</h3>
            <p>Vui lòng quay lại sau để xem sản phẩm mới nhất!</p>
            <a href="<?= APP_URL ?>/Home/">← Quay về trang chủ</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<footer class="main-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">🎮 TOYSHOP</div>
            <p class="footer-text">© 2025 ToyShop. Hệ thống cửa hàng đồ chơi trẻ em chính hãng.</p>
        </div>
    </div>
</footer>

<script>
function addToCart(masp) {
    fetch('<?= APP_URL ?>/Home/addToCart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'masp=' + masp + '&qty=1'
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success) {
            alert('Đã thêm vào giỏ hàng!');
            var cartCount = document.querySelector('.cart-count');
            if (cartCount) cartCount.textContent = data.totalQty;
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    });
}

function toggleFavorite(btn) {
    var masp = btn.dataset.masp;
    if (!masp) return;
    
    fetch('<?= APP_URL ?>/Home/toggleFavorite', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'masp=' + masp
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success) {
            btn.classList.toggle('active', data.isFavorite);
            btn.style.background = data.isFavorite ? '#ffe0e0' : '#fff';
            btn.innerHTML = data.isFavorite ? '💖' : '❤️';
        }
    });
}

function searchProducts() {
    var keyword = document.getElementById('productSearch').value.trim();
    if (keyword) window.location.href = '<?= APP_URL ?>/Home/search?q=' + encodeURIComponent(keyword);
}

document.getElementById('productSearch').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') searchProducts();
});

function sortProducts(sortBy) {
    var grid = document.getElementById('productsGrid');
    if (!grid) return;
    var cards = Array.from(grid.querySelectorAll('.product-card'));
    cards.sort(function(a, b) {
        var priceA = parseFloat(a.dataset.price) || 0;
        var priceB = parseFloat(b.dataset.price) || 0;
        if (sortBy === 'price-asc') return priceA - priceB;
        if (sortBy === 'price-desc') return priceB - priceA;
        return 0;
    });
    cards.forEach(function(card) { grid.appendChild(card); });
}
</script>
</body>
</html>
