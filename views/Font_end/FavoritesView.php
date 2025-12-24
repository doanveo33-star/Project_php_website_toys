<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm yêu thích - ToyShop</title>
    <style>
        :root {
            --primary-red: #e31837;
            --primary-blue: #003399;
            --dark-blue: #002266;
            --yellow: #ffd700;
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
        
        .page-header { background: linear-gradient(135deg, #e31837 0%, #c41530 100%); padding: 40px 0; color: #fff; text-align: center; }
        .page-header h1 { font-size: 32px; margin-bottom: 10px; }
        .page-header p { font-size: 16px; opacity: 0.9; }
        .page-icon { font-size: 48px; margin-bottom: 15px; }
        
        .products-section { padding: 30px 0; }
        .products-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .products-count { font-size: 14px; color: #666; }
        .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
        
        .product-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.08); transition: all 0.3s; position: relative; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,51,153,0.15); }
        .remove-btn { position: absolute; top: 12px; right: 12px; background: var(--primary-red); border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; z-index: 2; color: #fff; font-size: 16px; transition: all 0.3s; }
        .remove-btn:hover { background: #c41530; transform: scale(1.1); }
        .product-image-wrapper { position: relative; width: 100%; height: 220px; overflow: hidden; background: var(--light-gray); }
        .product-image-wrapper img { width: 100%; height: 100%; object-fit: contain; padding: 15px; transition: transform 0.3s; }
        .product-card:hover .product-image-wrapper img { transform: scale(1.05); }
        .product-info { padding: 15px; }
        .product-brand { font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 5px; }
        .product-name { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; line-height: 1.4; height: 40px; overflow: hidden; }
        .product-sku { font-size: 11px; color: #999; margin-bottom: 10px; }
        .price-wrapper { margin-bottom: 15px; }
        .current-price { font-size: 18px; font-weight: 700; color: var(--primary-red); }
        .add-cart-btn { width: 100%; background: var(--primary-red); color: #fff; border: none; padding: 12px 20px; border-radius: 25px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .add-cart-btn:hover { background: #c41530; transform: scale(1.02); }
        
        .empty-favorites { text-align: center; padding: 80px 20px; background: #fff; border-radius: 12px; }
        .empty-favorites .icon { font-size: 80px; margin-bottom: 20px; }
        .empty-favorites h3 { font-size: 24px; color: #333; margin-bottom: 10px; }
        .empty-favorites p { color: #666; margin-bottom: 25px; font-size: 16px; }
        .empty-favorites a { display: inline-block; padding: 15px 40px; background: var(--primary-red); color: #fff; text-decoration: none; border-radius: 25px; font-weight: 600; font-size: 16px; }
        .empty-favorites a:hover { background: #c41530; }
        
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
        <span>Sản phẩm yêu thích</span>
    </div>
</div>

<div class="page-header">
    <div class="container">
        <div class="page-icon">❤️</div>
        <h1>Sản Phẩm Yêu Thích</h1>
        <p>Những sản phẩm bạn đã lưu để mua sau</p>
    </div>
</div>

<section class="products-section">
    <div class="container">
        <?php if (!empty($products)): ?>
        <div class="products-header">
            <div class="products-count">Bạn có <strong><?= count($products) ?></strong> sản phẩm yêu thích</div>
        </div>
        
        <div class="products-grid" id="productsGrid">
            <?php foreach ($products as $p): ?>
            <div class="product-card" id="product-<?= $p['masp'] ?>">
                <button class="remove-btn" onclick="removeFavorite('<?= $p['masp'] ?>')" title="Xóa khỏi yêu thích">✕</button>
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
                    <div class="price-wrapper">
                        <span class="current-price"><?= number_format($p['giaXuat'] ?? 0) ?> ₫</span>
                    </div>
                    <button class="add-cart-btn" onclick="addToCart('<?= $p['masp'] ?>')">🛒 Thêm vào giỏ hàng</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-favorites">
            <div class="icon">💔</div>
            <h3>Chưa có sản phẩm yêu thích</h3>
            <p>Hãy khám phá và thêm sản phẩm vào danh sách yêu thích của bạn!</p>
            <a href="<?= APP_URL ?>/Home/">🛍️ Khám phá ngay</a>
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

function removeFavorite(masp) {
    if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi yêu thích?')) return;
    
    fetch('<?= APP_URL ?>/Home/toggleFavorite', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'masp=' + masp
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success) {
            var card = document.getElementById('product-' + masp);
            if (card) {
                card.style.transition = 'all 0.3s';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.8)';
                setTimeout(function() {
                    card.remove();
                    // Check if no products left
                    var grid = document.getElementById('productsGrid');
                    if (grid && grid.children.length === 0) {
                        location.reload();
                    }
                }, 300);
            }
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
</script>
</body>
</html>
