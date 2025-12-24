<?php
$products = $data['products'] ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đánh giá sản phẩm - ToyShop</title>
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
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; min-height: 100vh; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 15px; }
        
        /* HEADER */
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
        
        /* BREADCRUMB */
        .breadcrumb { padding: 15px 0; background: #fff; border-bottom: 1px solid #eee; }
        .breadcrumb a { color: var(--primary-blue); text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb span { color: #666; }
        
        /* PAGE HEADER */
        .page-header { background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%); padding: 40px 0; color: #fff; text-align: center; }
        .page-header h1 { font-size: 32px; margin-bottom: 10px; }
        .page-header p { font-size: 16px; opacity: 0.9; }
        .page-icon { font-size: 48px; margin-bottom: 15px; }
        
        /* SEARCH */
        .search-section { padding: 30px 0; }
        .search-input-wrapper { max-width: 600px; margin: 0 auto; }
        .search-input-wrapper input {
            width: 100%;
            padding: 15px 25px;
            border: 2px solid #ddd;
            border-radius: 50px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .search-input-wrapper input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 4px 20px rgba(0,51,153,0.15);
        }
        
        /* ALERT */
        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; max-width: 600px; margin-left: auto; margin-right: auto; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffc107; }
        .alert a { color: var(--primary-blue); font-weight: 600; }
        
        /* PRODUCTS GRID */
        .products-section { padding: 30px 0 60px; }
        .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
        
        .product-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,51,153,0.15);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            padding: 15px;
            background: var(--light-gray);
        }
        .product-info { padding: 15px; }
        .product-info h3 { 
            color: var(--text-dark); 
            font-size: 14px; 
            font-weight: 600;
            margin-bottom: 8px; 
            height: 40px;
            overflow: hidden;
            line-height: 1.4;
        }
        .product-category { 
            color: #666; 
            font-size: 12px; 
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .review-stats {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }
        .stars { color: var(--yellow); font-size: 14px; }
        .review-count { color: #666; font-size: 13px; }
        
        .review-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: var(--primary-red);
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }
        .review-btn:hover { background: #c41530; transform: scale(1.02); }
        
        /* NO RESULTS */
        .no-results { 
            text-align: center; 
            padding: 60px 20px; 
            background: #fff; 
            border-radius: 12px;
            display: none;
        }
        .no-results .icon { font-size: 64px; margin-bottom: 20px; }
        .no-results h3 { font-size: 20px; color: #333; margin-bottom: 10px; }
        .no-results p { color: #666; }
        
        /* FOOTER */
        .main-footer { background: var(--dark-blue); color: #fff; padding: 40px 0 20px; }
        .footer-content { text-align: center; }
        .footer-logo { font-size: 24px; font-weight: 800; color: var(--yellow); margin-bottom: 15px; }
        .footer-text { font-size: 14px; opacity: 0.8; }
        
        /* RESPONSIVE */
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
                    <input type="text" placeholder="Tìm kiếm sản phẩm...">
                    <button type="button">🔍</button>
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
        <span>Đánh giá sản phẩm</span>
    </div>
</div>

<div class="page-header">
    <div class="container">
        <div class="page-icon">⭐</div>
        <h1>Đánh Giá Sản Phẩm</h1>
        <p>Chia sẻ trải nghiệm của bạn về sản phẩm</p>
    </div>
</div>

<section class="search-section">
    <div class="container">
        <div class="search-input-wrapper">
            <input type="text" id="searchInput" placeholder="🔍 Tìm kiếm sản phẩm để đánh giá..." onkeyup="searchProducts()">
        </div>
        
        <?php if (!isset($_SESSION['user'])): ?>
        <div class="alert alert-warning" style="margin-top: 20px;">
            ⚠️ Vui lòng <a href="<?= APP_URL ?>/AuthController/ShowLogin">đăng nhập</a> để gửi đánh giá
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="products-section">
    <div class="container">
        <div class="products-grid" id="productsGrid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?= APP_URL ?>/public/Images/<?= $product['hinhanh'] ?: 'default.png' ?>" 
                         alt="<?= htmlspecialchars($product['tensp']) ?>"
                         onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                    <div class="product-info">
                        <h3><?= htmlspecialchars($product['tensp']) ?></h3>
                        <p class="product-category"><?= htmlspecialchars($product['maLoaiSP']) ?></p>
                        <div class="review-stats">
                            <span class="stars">
                                <?php 
                                $avgRating = round($product['avg_rating'] ?? 0);
                                for ($i = 1; $i <= 5; $i++): 
                                ?>
                                    <?= $i <= $avgRating ? '⭐' : '☆' ?>
                                <?php endfor; ?>
                            </span>
                            <span class="review-count">(<?= $product['total_reviews'] ?? 0 ?> đánh giá)</span>
                        </div>
                        <a href="<?= APP_URL ?>/Home/reviewProduct/<?= $product['masp'] ?>" class="review-btn">
                            ✍️ Viết đánh giá
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; color:#666; grid-column: 1/-1; padding: 40px;">Chưa có sản phẩm nào</p>
            <?php endif; ?>
        </div>
        
        <div class="no-results" id="noResults">
            <div class="icon">😕</div>
            <h3>Không tìm thấy sản phẩm</h3>
            <p>Thử tìm kiếm với từ khóa khác</p>
        </div>
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
function searchProducts() {
    var input = document.getElementById('searchInput').value.toLowerCase();
    var cards = document.querySelectorAll('.product-card');
    var grid = document.getElementById('productsGrid');
    var noResults = document.getElementById('noResults');
    var found = 0;
    
    cards.forEach(function(card) {
        var name = card.querySelector('h3').textContent.toLowerCase();
        var category = card.querySelector('.product-category').textContent.toLowerCase();
        
        if (name.includes(input) || category.includes(input)) {
            card.style.display = 'block';
            found++;
        } else {
            card.style.display = 'none';
        }
    });
    
    if (found === 0 && input !== '') {
        noResults.style.display = 'block';
        grid.style.display = 'none';
    } else {
        noResults.style.display = 'none';
        grid.style.display = 'grid';
    }
}
</script>
</body>
</html>
