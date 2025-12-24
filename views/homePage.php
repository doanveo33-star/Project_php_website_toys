<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToyShop - Đồ Chơi Trẻ Em Chính Hãng</title>
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
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #fff; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 15px; }
        
        /* TOP BAR */
        .top-bar { background: var(--primary-red); color: #fff; padding: 8px 0; font-size: 13px; }
        .top-bar .container { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
        .top-bar-left { display: flex; gap: 25px; flex-wrap: wrap; }
        .top-bar-right a { color: #fff; text-decoration: none; }
        
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
        
        /* NAV MENU - MÀU XANH ĐỒNG NHẤT */
        .nav-menu { background: var(--dark-blue); position: relative; }
        .nav-menu .container { display: flex; align-items: center; gap: 0; }
        .nav-item { position: relative; }
        .nav-link { display: flex; align-items: center; gap: 6px; padding: 12px 16px; color: #fff; text-decoration: none; font-size: 13px; font-weight: 600; cursor: pointer; white-space: nowrap; }
        .nav-link:hover { background: rgba(255,255,255,0.1); }
        .nav-link .arrow { font-size: 8px; transition: transform 0.3s; }
        .nav-item:hover .arrow { transform: rotate(180deg); }
        
        /* NÚT KHUYẾN MÃI - MÀU VÀNG NỔI BẬT */
        .nav-promo-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 15px;
            background: var(--yellow);
            color: var(--text-dark);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            border-radius: 4px;
            margin: 0 8px;
            text-transform: uppercase;
        }
        .nav-promo-btn:hover { background: #ffed4a; }
        
        /* ĐỘC QUYỀN ONLINE - HIGHLIGHT */
        .nav-exclusive {
            background: rgba(255,255,255,0.15);
            border-radius: 4px;
            margin: 0 3px;
        }
        .nav-exclusive:hover { background: rgba(255,255,255,0.25); }
        
        /* YÊU THÍCH */
        .nav-favorite { position: relative; }
        .favorite-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            background: var(--primary-red);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            border-radius: 50%;
            margin-left: 5px;
        }
        .favorite-btn.active { background: #ffe0e0 !important; }
        .favorite-btn.active::after { content: '💖'; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        
        /* MEGA MENU */
        .mega-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            min-width: 900px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 0 0 12px 12px;
            display: none;
            z-index: 1000;
        }
        .nav-item:hover .mega-menu { display: flex; }
        
        .mega-menu-left {
            width: 220px;
            background: #f8f9fa;
            padding: 15px 0;
            border-right: 1px solid #eee;
        }
        .mega-category {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            cursor: pointer;
        }
        .mega-category:hover, .mega-category.active {
            background: #fff;
            color: var(--primary-red);
            border-left: 3px solid var(--primary-red);
        }
        .mega-category .cat-icon { font-size: 20px; }
        
        .mega-menu-right {
            flex: 1;
            padding: 20px;
            display: flex;
            gap: 20px;
        }
        .mega-products {
            flex: 1;
        }
        .mega-products-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-red);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-red);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .mega-product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .mega-product-card {
            text-decoration: none;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .mega-product-card:hover {
            background: #f5f5f5;
            transform: translateY(-3px);
        }
        .mega-product-card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 8px;
        }
        .mega-product-card .name {
            font-size: 12px;
            color: var(--text-dark);
            line-height: 1.3;
            height: 32px;
            overflow: hidden;
        }
        .mega-product-card .price {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary-red);
            margin-top: 5px;
        }
        .mega-product-card .old-price {
            font-size: 11px;
            color: #999;
            text-decoration: line-through;
        }
        .mega-product-card .discount {
            display: inline-block;
            background: var(--primary-red);
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            position: absolute;
            top: 5px;
            left: 5px;
        }
        
        /* LEGO MEGA MENU - 3 COLUMNS */
        .lego-mega-menu {
            display: none;
            min-width: 1000px;
            padding: 0;
        }
        .nav-item:hover .lego-mega-menu { display: flex; }
        
        .lego-column {
            flex: 1;
            padding: 20px;
            border-right: 1px solid #eee;
        }
        .lego-column:last-child { border-right: none; }
        
        .lego-column-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-red);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-red);
        }
        
        .lego-menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .lego-menu-item:hover, .lego-menu-item.active {
            background: #fff;
            color: var(--primary-red);
            border-left-color: var(--primary-red);
        }
        .lego-icon { font-size: 20px; }
        
        .lego-categories-column { 
            min-width: 220px; 
            max-width: 250px;
            background: #f8f9fa;
        }
        .lego-products-column { 
            min-width: 500px; 
            flex: 2;
        }
        
        .lego-themes-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .lego-theme-item {
            display: inline-block;
            padding: 8px 14px;
            background: #f5f5f5;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            border-radius: 20px;
            transition: all 0.2s;
        }
        .lego-theme-item:hover {
            background: var(--primary-red);
            color: #fff;
        }
        
        .lego-products-column { min-width: 350px; }
        
        .lego-featured-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .lego-product-card {
            text-decoration: none;
            text-align: center;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .lego-product-card:hover {
            background: #f5f5f5;
            transform: translateY(-3px);
        }
        .lego-product-card img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 6px;
        }
        .lego-product-name {
            font-size: 11px;
            color: var(--text-dark);
            line-height: 1.3;
            height: 28px;
            overflow: hidden;
            margin-bottom: 4px;
        }
        .lego-product-price {
            font-size: 12px;
        }
        .lego-sale-price {
            font-weight: 700;
            color: var(--primary-red);
        }
        .lego-old-price {
            font-size: 10px;
            color: #999;
            text-decoration: line-through;
            margin-left: 4px;
        }
        
        /* CATEGORY SECTION */
        /* BANNER SLIDER */
        .banner-section { padding: 20px 0; background: var(--light-gray); }
        .banner-slider { position: relative; overflow: hidden; border-radius: 12px; }
        .banner-wrapper { overflow: hidden; }
        .banner-track { display: flex; transition: transform 0.5s ease-in-out; }
        .banner-slide { min-width: 100%; }
        .banner-slide img { width: 100%; height: 500px; object-fit: cover; display: block; }
        .banner-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.9);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        .banner-arrow:hover { background: #fff; transform: translateY(-50%) scale(1.1); }
        .banner-prev { left: 15px; }
        .banner-next { right: 15px; }
        .banner-dots { text-align: center; padding: 15px 0; }
        .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 5px;
            background: #ccc;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
        }
        .dot.active, .dot:hover { background: var(--primary-red); transform: scale(1.2); }
        
        @media (max-width: 768px) {
            .banner-slide img { height: 200px; }
            .banner-arrow { width: 40px; height: 40px; font-size: 16px; }
        }
        

        
        /* SECTION TITLE */
        .section-header { text-align: center; padding: 50px 0 30px; }
        .section-title { font-size: 32px; font-weight: 700; color: var(--primary-blue); position: relative; display: inline-block; }
        .section-title::after { content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: var(--primary-red); border-radius: 2px; }
        
        /* PRODUCTS */
        .products-section { padding: 20px 0 60px; background: #fff; }
        .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
        .product-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.08); transition: all 0.3s; position: relative; border: 1px solid #eee; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,51,153,0.15); }
        .discount-badge { position: absolute; top: 12px; left: 12px; background: var(--primary-red); color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 2; }
        .favorite-btn { position: absolute; top: 12px; right: 12px; background: #fff; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; z-index: 2; }
        .product-image-wrapper { position: relative; width: 100%; height: 220px; overflow: hidden; background: var(--light-gray); }
        .product-image-wrapper img { width: 100%; height: 100%; object-fit: contain; padding: 15px; }
        .promo-label { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(90deg, var(--primary-red), #ff4757); color: #fff; padding: 8px 15px; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .promo-label .online-tag { background: var(--yellow); color: var(--text-dark); padding: 2px 8px; border-radius: 3px; font-weight: 700; }
        .product-info { padding: 15px; }
        .product-brand { font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 5px; }
        .product-name { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; line-height: 1.4; height: 40px; overflow: hidden; }
        .product-sku { font-size: 11px; color: #999; margin-bottom: 10px; }
        .price-wrapper { margin-bottom: 15px; }
        .current-price { font-size: 18px; font-weight: 700; color: var(--primary-red); }
        .original-price { font-size: 13px; color: #999; text-decoration: line-through; margin-left: 8px; }
        .add-cart-btn { width: 100%; background: var(--primary-red); color: #fff; border: none; padding: 12px 20px; border-radius: 25px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .add-cart-btn:hover { background: #c41530; }
        
        /* WHY US */
        .why-us-section { padding: 60px 0; background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%); color: #fff; }
        .why-us-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; }
        .why-us-item { text-align: center; padding: 30px 20px; background: rgba(255,255,255,0.1); border-radius: 12px; }
        .why-us-icon { font-size: 48px; margin-bottom: 15px; }
        .why-us-title { font-size: 16px; font-weight: 700; margin-bottom: 10px; }
        .why-us-desc { font-size: 13px; opacity: 0.9; }
        
        /* FOOTER */
        .main-footer { background: var(--dark-blue); color: #fff; padding: 60px 0 30px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .footer-col h4 { font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--yellow); }
        .footer-col p, .footer-col a { font-size: 14px; color: rgba(255,255,255,0.8); line-height: 1.8; text-decoration: none; display: block; }
        .footer-col a:hover { color: var(--yellow); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; text-align: center; font-size: 13px; opacity: 0.7; }
        
        /* SEARCH DROPDOWN */
        .search-wrapper { position: relative; }
        .search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1001;
            display: none;
        }
        .search-dropdown.active { display: block; }
        .search-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--text-dark);
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }
        .search-item:hover { background: #f8f9fa; }
        .search-item:last-child { border-bottom: none; }
        .search-item img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 6px;
            background: #f5f5f5;
        }
        .search-item-info { flex: 1; }
        .search-item-name { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 3px; }
        .search-item-price { font-size: 14px; font-weight: 700; color: var(--primary-red); }
        .search-item-price .old-price { font-size: 12px; color: #999; text-decoration: line-through; margin-left: 8px; font-weight: 400; }
        .search-item-category { font-size: 11px; color: #888; }
        .search-no-result { padding: 20px; text-align: center; color: #666; }
        .search-loading { padding: 20px; text-align: center; color: #666; }
        
        /* RESPONSIVE */
        @media (max-width: 1200px) { .products-grid { grid-template-columns: repeat(3, 1fr); } .mega-menu { min-width: 700px; } .mega-product-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 992px) { .products-grid { grid-template-columns: repeat(2, 1fr); } .why-us-grid, .footer-grid { grid-template-columns: repeat(2, 1fr); } .mega-menu { display: none !important; } }
        @media (max-width: 768px) { .top-bar { display: none; } .category-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 576px) { .products-grid, .category-grid { grid-template-columns: repeat(2, 1fr); } .why-us-grid, .footer-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-left">
            <span>🚚 Miễn phí giao hàng đơn từ 500k</span>
            <span>⚡ Giao hàng hỏa tốc 4 tiếng</span>
            <span>👥 Chương trình thành viên</span>
            <span>🏪 Hệ thống 200 cửa hàng</span>
        </div>
        <div class="top-bar-right">
            <a href="#">Hotline: 1900 1234</a>
        </div>
    </div>
</div>

<!-- MAIN HEADER -->
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <!-- Logo đã chuyển xuống navbar, để trống hoặc có thể thêm gì đó -->
            <a href="<?= APP_URL ?>/Home/" class="logo-text">🎮 TOYSHOP</a>
            
            <div class="search-wrapper">
                <div class="search-box">
                    <input type="text" id="productSearch" placeholder="Nhập từ khóa để tìm kiếm (vd: lắp ráp, mô hình, búp bê...)" autocomplete="off">
                    <button type="button" onclick="searchProducts()">🔍</button>
                </div>
                <div class="search-dropdown" id="searchDropdown"></div>
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

<!-- NAVIGATION MENU -->
<nav class="nav-menu">
    <div class="container">
        <?php 
        $categories = $data['categories'] ?? [];
        $categoryIcons = ['LEGO'=>'🧱', 'Robot'=>'🤖', 'BupBe'=>'👧', 'GiaoDuc'=>'🧠', 'XeMoHinh'=>'🚗', 'NgoaiTroi'=>'⚽', 'BoardGame'=>'🎲', 'NhoiBong'=>'🧸'];
        $products = $data['products'] ?? [];
        $featured = array_slice($products, 0, 6);
        ?>
        
        <!-- NÚT SIÊU SALE - MÀU VÀNG -->
        <a href="<?= APP_URL ?>/Home/promotion" class="nav-promo-btn">
            🎁 SIÊU SALE
        </a>
        
        <!-- ĐỘC QUYỀN ONLINE -->
        <a href="<?= APP_URL ?>/Home/exclusive" class="nav-link nav-exclusive">
            🌟 ĐỘC QUYỀN ONLINE
        </a>
        
        <!-- LEGO MEGA MENU - 2 CỘT (DANH MỤC + SẢN PHẨM HOVER) -->
        <div class="nav-item">
            <a class="nav-link">
                🧱 LEGO <span class="arrow">▼</span>
            </a>
            <div class="mega-menu lego-mega-menu" id="legoMegaMenu">
                <!-- Cột 1: LEGO theo đối tượng (4 loại) -->
                <div class="lego-column lego-categories-column">
                    <div class="lego-column-title">👥 LEGO THEO ĐỐI TƯỢNG</div>
                    <?php 
                    $legoCategories = $data['legoCategories'] ?? [];
                    $legoProductsByCategory = $data['legoProductsByCategory'] ?? [];
                    $legoIcons = [
                        'LEGO1' => '👦',
                        'LEGO2' => '👧',
                        'LEGO3' => '👶',
                        'LEGO4' => '🧑'
                    ];
                    foreach ($legoCategories as $index => $legoCat): 
                        $legoProds = $legoProductsByCategory[$legoCat['maLoaiSP']] ?? [];
                    ?>
                    <a href="<?= APP_URL ?>/Home/category/<?= $legoCat['maLoaiSP'] ?>" 
                       class="lego-menu-item <?= $index === 0 ? 'active' : '' ?>"
                       data-category="<?= $legoCat['maLoaiSP'] ?>"
                       data-title="<?= htmlspecialchars($legoCat['tenLoaiSP']) ?>"
                       data-products='<?= json_encode($legoProds) ?>'>
                        <span class="lego-icon"><?= $legoIcons[$legoCat['maLoaiSP']] ?? '🧱' ?></span>
                        <?= htmlspecialchars($legoCat['tenLoaiSP']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Cột 2: Sản phẩm LEGO (thay đổi khi hover) -->
                <div class="lego-column lego-products-column">
                    <div class="lego-column-title" id="legoProductsTitle">
                        <?= htmlspecialchars($legoCategories[0]['tenLoaiSP'] ?? 'LEGO') ?>
                    </div>
                    <div class="lego-featured-grid" id="legoProductsGrid">
                        <?php 
                        // Hiển thị sản phẩm của loại LEGO đầu tiên mặc định
                        $firstCatProducts = $legoProductsByCategory[$legoCategories[0]['maLoaiSP'] ?? ''] ?? [];
                        foreach ($firstCatProducts as $lp): 
                        ?>
                        <a href="<?= APP_URL ?>/Home/detail/<?= $lp['masp'] ?>" class="lego-product-card">
                            <img src="<?= APP_URL ?>/public/Images/<?= $lp['hinhanh'] ?>" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                            <div class="lego-product-name"><?= htmlspecialchars($lp['tensp']) ?></div>
                            <div class="lego-product-price">
                                <span class="lego-sale-price"><?= number_format($lp['gia_ban'] ?? $lp['giaXuat'] ?? 0) ?>đ</span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ĐỒ CHƠI THEO ĐỘ TUỔI - MEGA MENU -->
        <div class="nav-item">
            <a class="nav-link">
                👶 ĐỘ TUỔI <span class="arrow">▼</span>
            </a>
            <div class="mega-menu lego-mega-menu" id="ageMegaMenu">
                <!-- Cột 1: Danh sách độ tuổi -->
                <div class="lego-column lego-categories-column">
                    <div class="lego-column-title">🎯 CHỌN ĐỘ TUỔI</div>
                    <?php 
                    $ageGroups = $data['ageGroups'] ?? [];
                    $productsByAge = $data['productsByAge'] ?? [];
                    $ageIcons = [
                        '1+' => '👶', '4+' => '🧒', '5+' => '🧒', '6+' => '👦',
                        '8+' => '👧', '10+' => '🧑', '12+' => '👨', '14+' => '🧔', '16+' => '👴'
                    ];
                    foreach ($ageGroups as $index => $age): 
                        $ageValue = $age['doTuoi'];
                        $ageProds = $productsByAge[$ageValue] ?? [];
                    ?>
                    <a href="<?= APP_URL ?>/Home/byAge/<?= urlencode($ageValue) ?>" 
                       class="lego-menu-item <?= $index === 0 ? 'active' : '' ?>"
                       data-age="<?= htmlspecialchars($ageValue) ?>"
                       data-title="Đồ chơi cho bé <?= htmlspecialchars($ageValue) ?>"
                       data-products='<?= json_encode($ageProds) ?>'>
                        <span class="lego-icon"><?= $ageIcons[$ageValue] ?? '🎮' ?></span>
                        Từ <?= htmlspecialchars($ageValue) ?> tuổi
                    </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Cột 2: Sản phẩm theo độ tuổi (thay đổi khi hover) -->
                <div class="lego-column lego-products-column">
                    <div class="lego-column-title" id="ageProductsTitle">
                        <?= !empty($ageGroups) ? 'Đồ chơi cho bé ' . ($ageGroups[0]['doTuoi'] ?? '') . ' tuổi' : 'Đồ chơi theo độ tuổi' ?>
                    </div>
                    <div class="lego-featured-grid" id="ageProductsGrid">
                        <?php 
                        $firstAgeProducts = !empty($ageGroups) ? ($productsByAge[$ageGroups[0]['doTuoi']] ?? []) : [];
                        foreach ($firstAgeProducts as $ap): 
                        ?>
                        <a href="<?= APP_URL ?>/Home/quickBuy/<?= $ap['masp'] ?>" class="lego-product-card">
                            <img src="<?= APP_URL ?>/public/Images/<?= $ap['hinhanh'] ?>" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                            <div class="lego-product-name"><?= htmlspecialchars($ap['tensp']) ?></div>
                            <div class="lego-product-price">
                                <span class="lego-sale-price"><?= number_format($ap['gia_ban'] ?? 0) ?>đ</span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    
        
        <!-- SẢN PHẨM DROPDOWN - MEGA MENU VỚI HOVER -->
        <div class="nav-item">
            <a class="nav-link">
                🎁 SẢN PHẨM <span class="arrow">▼</span>
            </a>
            <div class="mega-menu" id="productMegaMenu">
                <div class="mega-menu-left">
                    <?php 
                    // Chỉ hiển thị các danh mục KHÔNG phải LEGO (LEGO đã có mega menu riêng)
                    foreach ($categories as $index => $cat): 
                        // Lấy sản phẩm của danh mục này
                        $catProducts = array_filter($products, fn($p) => $p['maLoaiSP'] === $cat['maLoaiSP']);
                        $catProducts = array_slice(array_values($catProducts), 0, 6);
                    ?>
                    <a href="<?= APP_URL ?>/Home/category/<?= $cat['maLoaiSP'] ?>" 
                       class="mega-category <?= $index === 0 ? 'active' : '' ?>" 
                       data-category="<?= $cat['maLoaiSP'] ?>"
                       data-products='<?= json_encode($catProducts) ?>'>
                        <span class="cat-icon"><?= $categoryIcons[$cat['maLoaiSP']] ?? '🎮' ?></span>
                        <?= htmlspecialchars($cat['tenLoaiSP']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <div class="mega-menu-right">
                    <div class="mega-products">
                        <div class="mega-products-title" id="megaProductsTitle">🔥 SẢN PHẨM NỔI BẬT</div>
                        <div class="mega-product-grid" id="megaProductGrid">
                            <?php foreach ($featured as $p): ?>
                            <a href="<?= APP_URL ?>/Home/detail/<?= $p['masp'] ?>" class="mega-product-card">
                                <img src="<?= APP_URL ?>/public/Images/<?= $p['hinhanh'] ?>" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                                <div class="name"><?= htmlspecialchars($p['tensp']) ?></div>
                                <div class="price"><?= number_format($p['gia_ban']) ?>đ</div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- KHUYẾN MÃI MEGA MENU -->
        <div class="nav-item">
            <a class="nav-link" style="color: var(--yellow);">
                🏷️ KHUYẾN MÃI <span class="arrow">▼</span>
            </a>
            <div class="mega-menu lego-mega-menu" id="promoMegaMenu">
                <!-- Cột 1: Danh sách khuyến mãi -->
                <div class="lego-column lego-categories-column">
                    <div class="lego-column-title">🔥 CHƯƠNG TRÌNH KHUYẾN MÃI</div>
                    <?php 
                    $activePromotions = $data['activePromotions'] ?? [];
                    $productsByPromotion = $data['productsByPromotion'] ?? [];
                    $promoIcons = ['🎁', '🎉', '💥', '🔥', '⚡', '🎊', '💰', '🏷️'];
                    foreach ($activePromotions as $index => $promo): 
                        $promoProds = $productsByPromotion[$promo['id']] ?? [];
                        $promoType = $promo['type'] ?? 'percent';
                        $promoValue = $promo['value'] ?? 0;
                        $discountText = $promoType == 'percent' ? "-{$promoValue}%" : "-" . number_format($promoValue) . "đ";
                        $promoName = $promo['name'] ?? $promo['code'] ?? 'Khuyến mãi';
                        $icon = $promoIcons[$index % count($promoIcons)];
                    ?>
                    <a href="<?= APP_URL ?>/Home/promotion/<?= $promo['id'] ?>" 
                       class="lego-menu-item <?= $index === 0 ? 'active' : '' ?>"
                       data-promo-id="<?= $promo['id'] ?>"
                       data-title="<?= htmlspecialchars($promoName) ?> (<?= $discountText ?>)"
                       data-products='<?= json_encode($promoProds) ?>'>
                        <span class="lego-icon"><?= $icon ?></span>
                        <?= htmlspecialchars($promoName) ?> <span style="color: var(--primary-red); font-weight: 700;"><?= $discountText ?></span>
                    </a>
                    <?php endforeach; ?>
                    <?php if (empty($activePromotions)): ?>
                    <p style="padding: 15px; color: #666; font-size: 14px;">Chưa có chương trình khuyến mãi nào</p>
                    <?php endif; ?>
                    <a href="<?= APP_URL ?>/Home/allPromotions" class="lego-menu-item" style="background: #f0f5ff; margin-top: 10px;">
                        <span class="lego-icon">👉</span>
                        Xem tất cả ưu đãi
                    </a>
                </div>
                
                <!-- Cột 2: Sản phẩm khuyến mãi (thay đổi khi hover) -->
                <div class="lego-column lego-products-column">
                    <div class="lego-column-title" id="promoProductsTitle">
                        <?= !empty($activePromotions) ? htmlspecialchars($activePromotions[0]['name'] ?? $activePromotions[0]['code']) : 'Sản phẩm khuyến mãi' ?>
                    </div>
                    <div class="lego-featured-grid" id="promoProductsGrid">
                        <?php 
                        $firstPromoProducts = !empty($activePromotions) ? ($productsByPromotion[$activePromotions[0]['id']] ?? []) : [];
                        foreach ($firstPromoProducts as $pp): 
                            $discountPercent = $pp['discount_percent'] ?? 0;
                            $discountBadge = $discountPercent ? "-{$discountPercent}%" : '';
                            $giaGoc = $pp['gia_ban'] ?? 0;
                            $giaSauGiam = $discountPercent > 0 ? round($giaGoc * (100 - $discountPercent) / 100) : $giaGoc;
                        ?>
                        <a href="<?= APP_URL ?>/Home/quickBuy/<?= $pp['masp'] ?>" class="lego-product-card" style="position: relative;">
                            <?php if ($discountBadge): ?>
                            <span style="position: absolute; top: 5px; left: 5px; background: var(--primary-red); color: #fff; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 700;"><?= $discountBadge ?></span>
                            <?php endif; ?>
                            <img src="<?= APP_URL ?>/public/Images/<?= $pp['hinhanh'] ?>" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                            <div class="lego-product-name"><?= htmlspecialchars($pp['tensp']) ?></div>
                            <div class="lego-product-price">
                                <?php if ($discountPercent > 0): ?>
                                <span class="lego-sale-price"><?= number_format($giaSauGiam) ?>đ</span>
                                <span style="text-decoration: line-through; color: #999; font-size: 10px; display: block;"><?= number_format($giaGoc) ?>đ</span>
                                <?php else: ?>
                                <span class="lego-sale-price"><?= number_format($giaGoc) ?>đ</span>
                                <?php endif; ?>
                            </div>
                        </a>
                        <?php endforeach; ?>
                        <?php if (empty($firstPromoProducts)): ?>
                        <p style="padding: 20px; color: #666; grid-column: 1/-1;">Chưa có sản phẩm trong chương trình này</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- HÀNG MỚI -->
        <a href="<?= APP_URL ?>/Home/newArrivals" class="nav-link">
            🆕 HÀNG MỚI
        </a>
        
        <!-- ĐÁNH GIÁ SẢN PHẨM -->
        <a href="<?= APP_URL ?>/Home/reviewList" class="nav-link">⭐ ĐÁNH GIÁ</a>
        
        <!-- YÊU THÍCH -->
        <a href="<?= APP_URL ?>/Home/favorites" class="nav-link nav-favorite">
            ❤️ YÊU THÍCH
            <span class="favorite-count" id="navFavoriteCount"><?php
                $favCount = isset($_SESSION['favorites']) ? count($_SESSION['favorites']) : 0;
                echo $favCount;
            ?></span>
        </a>
    </div>
</nav>


<!-- BANNER SLIDER -->
<section class="banner-section">
    <div class="container">
        <div class="banner-slider">
            <button class="banner-arrow banner-prev" onclick="prevSlide()">❮</button>
            
            <div class="banner-wrapper">
                <div class="banner-track" id="bannerTrack">
                    <!-- Banner 1 -->
                    <div class="banner-slide">
                        <a href="#">
                            <img src="<?= APP_URL ?>/public/Images/Logo/Banner1.webp" alt="Banner 1" onerror="this.src='https://via.placeholder.com/1200x400/e31837/ffffff?text=BANNER+1+-+SALE+UP+TO+50%25'">
                        </a>
                    </div>
                    <!-- Banner 2 -->
                    <div class="banner-slide">
                        <a href="#">
                            <img src="<?= APP_URL ?>/public/Images/Logo/Banner2.webp" alt="Banner 2" onerror="this.src='https://via.placeholder.com/1200x400/003399/ffffff?text=BANNER+2+-+NEW+ARRIVALS'">
                        </a>
                    </div>
                    <!-- Banner 3 -->
                    <div class="banner-slide">
                        <a href="#">
                            <img src="<?= APP_URL ?>/public/Images/Logo/Banner3.webp" alt="Banner 3" onerror="this.src='https://via.placeholder.com/1200x400/ffd700/333333?text=BANNER+3+-+LEGO+COLLECTION'">
                        </a>
                    </div>
                    <!-- Banner 4 -->
                    <div class="banner-slide">
                        <a href="#">
                            <img src="<?= APP_URL ?>/public/Images/Logo/Banner4.webp" alt="Banner 4" onerror="this.src='https://via.placeholder.com/1200x400/28a745/ffffff?text=BANNER+4+-+FREE+SHIPPING'">
                        </a>
                    </div>
                </div>
            </div>
            
            <button class="banner-arrow banner-next" onclick="nextSlide()">❯</button>
        </div>
        
        <!-- Dots indicator -->
        <div class="banner-dots">
            <span class="dot active" onclick="goToSlide(0)"></span>
            <span class="dot" onclick="goToSlide(1)"></span>
            <span class="dot" onclick="goToSlide(2)"></span>
            <span class="dot" onclick="goToSlide(3)"></span>
        </div>
    </div>
</section>



<!-- SẢN PHẨM ĐỘC QUYỀN ONLINE -->
<section class="products-section" id="products">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">🌟 Độc Quyền Online</h2>
        </div>
        
        <?php $exclusiveProducts = $data['exclusiveProducts'] ?? []; ?>
        <?php if (!empty($exclusiveProducts)): ?>
        <div class="products-grid">
            <?php foreach ($exclusiveProducts as $p): ?>
            <div class="product-card" data-category="<?= $p['maLoaiSP'] ?>">
                <span class="discount-badge">ĐỘC QUYỀN</span>
                <button class="favorite-btn" onclick="toggleFavorite(this)" data-masp="<?= $p['masp'] ?>">❤️</button>
                
                <div class="product-image-wrapper">
                    <a href="<?= APP_URL ?>/Home/quickBuy/<?= $p['masp'] ?>" title="Mua ngay">
                        <img src="<?= APP_URL ?>/public/Images/<?= $p['hinhanh'] ?>" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                    </a>
                    <div class="promo-label">
                        <span>GIÁ ĐỘC QUYỀN</span>
                        <span class="online-tag">ONLINE</span>
                    </div>
                </div>
                
                <div class="product-info">
                    <div class="product-brand"><?= htmlspecialchars($p['thuongHieu'] ?? '') ?></div>
                    <h3 class="product-name"><?= htmlspecialchars($p['tensp']) ?></h3>
                    <div class="product-sku">SKU: <?= $p['masp'] ?></div>
                    <div class="price-wrapper">
                        <span class="current-price"><?= number_format($p['giaXuat'] ?? 0) ?> ₫</span>
                    </div>
                    <button class="add-cart-btn" onclick="addToCart('<?= $p['masp'] ?>')">🛒 Thêm Vào Giỏ Hàng</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p style="text-align: center; color: #666; padding: 40px;">Chưa có sản phẩm độc quyền online. Vui lòng quay lại sau!</p>
        <?php endif; ?>
    </div>
</section>

<img src="<?= APP_URL ?>/public/Images/Logo/1280X496.webp" alt="Divider" style="width: 100%; margin: 40px 0;" onerror="this.style.display='none'">


<!-- ĐÁNH GIÁ TỪ KHÁCH HÀNG -->
<section class="reviews-section" style="padding: 60px 0; background: #fff;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">⭐ Đánh Giá Từ Khách Hàng</h2>
        </div>
        
        <?php 
        $reviews = $data['reviews'] ?? [];
        if (!empty($reviews)): 
        ?>
        <div class="reviews-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 30px;">
            <?php foreach (array_slice($reviews, 0, 8) as $review): ?>
            <div class="review-card" style="background: var(--light-gray); border-radius: 12px; padding: 20px; border: 1px solid #eee;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700;">
                        <?= strtoupper(substr($review['user_name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--text-dark);"><?= htmlspecialchars($review['user_name'] ?? 'Khách hàng') ?></div>
                        <div style="color: #f39c12; font-size: 14px;">
                            <?php for ($i = 1; $i <= 5; $i++) echo $i <= ($review['rating'] ?? 5) ? '★' : '☆'; ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($review['tensp'])): ?>
                <div style="font-size: 12px; color: var(--primary-blue); margin-bottom: 8px; font-weight: 600;">
                    🎮 <?= htmlspecialchars($review['tensp']) ?>
                </div>
                <?php endif; ?>
                <p style="color: #555; font-size: 14px; line-height: 1.6; margin: 0;">
                    "<?= htmlspecialchars(mb_substr($review['comment'] ?? '', 0, 100)) ?><?= strlen($review['comment'] ?? '') > 100 ? '...' : '' ?>"
                </p>
                <div style="font-size: 12px; color: #999; margin-top: 10px;">
                    <?= date('d/m/Y', strtotime($review['created_at'] ?? 'now')) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <a href="<?= APP_URL ?>/Home/reviewList" style="display: inline-block; padding: 12px 30px; background: var(--primary-blue); color: #fff; text-decoration: none; border-radius: 25px; font-weight: 600;">Xem tất cả đánh giá →</a>
        </div>
        <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #666;">
            <p style="font-size: 48px; margin-bottom: 15px;">⭐</p>
            <p>Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm!</p>
            <a href="<?= APP_URL ?>/Home/reviewList" style="display: inline-block; margin-top: 15px; padding: 12px 30px; background: var(--primary-red); color: #fff; text-decoration: none; border-radius: 25px; font-weight: 600;">Viết đánh giá →</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- TẠI SAO CHỌN CHÚNG TÔI -->
<section class="why-us-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title" style="color: #fff;">Tại Sao Chọn ToyShop?</h2>
        </div>
        <div class="why-us-grid">
            <div class="why-us-item">
                <div class="why-us-icon">✅</div>
                <div class="why-us-title">100% Chính Hãng</div>
                <div class="why-us-desc">Cam kết sản phẩm chính hãng</div>
            </div>
            <div class="why-us-item">
                <div class="why-us-icon">🚚</div>
                <div class="why-us-title">Giao Hàng Nhanh</div>
                <div class="why-us-desc">Giao hàng hỏa tốc 4 tiếng</div>
            </div>
            <div class="why-us-item">
                <div class="why-us-icon">💰</div>
                <div class="why-us-title">Giá Tốt Nhất</div>
                <div class="why-us-desc">Cam kết giá tốt nhất</div>
            </div>
            <div class="why-us-item">
                <div class="why-us-icon">🔄</div>
                <div class="why-us-title">Đổi Trả Dễ Dàng</div>
                <div class="why-us-desc">Đổi trả trong 30 ngày</div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>🎮 TOYSHOP</h4>
                <p>Hệ thống cửa hàng đồ chơi trẻ em chính hãng hàng đầu Việt Nam.</p>
                <p>📍 123 Đường ABC, Quận 1, TP.HCM</p>
                <p>📞 Hotline: 1900 1234</p>
            </div>
            <div class="footer-col">
                <h4>Hỗ Trợ</h4>
                <a href="#">Hướng dẫn mua hàng</a>
                <a href="#">Chính sách đổi trả</a>
                <a href="#">Phương thức thanh toán</a>
            </div>
            <div class="footer-col">
                <h4>Về ToyShop</h4>
                <a href="#">Giới thiệu</a>
                <a href="#">Hệ thống cửa hàng</a>
                <a href="#">Liên hệ</a>
            </div>
            <div class="footer-col">
                <h4>Danh Mục</h4>
                <a href="#">Đồ chơi LEGO</a>
                <a href="#">Robot & Điều khiển</a>
                <a href="#">Búp bê</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 ToyShop. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
// Add to Cart
function addToCart(masp) {
    fetch('<?= APP_URL ?>/Home/addToCart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `masp=${masp}&qty=1`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Đã thêm vào giỏ hàng!');
            location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    });
}

// Search - Live Search với dropdown
const searchInput = document.getElementById('productSearch');
const searchDropdown = document.getElementById('searchDropdown');
let searchTimeout = null;

function searchProducts() {
    const keyword = searchInput.value.trim();
    if (keyword) {
        window.location.href = '<?= APP_URL ?>/Home/search?q=' + encodeURIComponent(keyword);
    }
}

// Live search khi gõ
searchInput.addEventListener('input', function() {
    const keyword = this.value.trim();
    
    // Clear timeout cũ
    if (searchTimeout) clearTimeout(searchTimeout);
    
    // Nếu rỗng thì ẩn dropdown
    if (keyword.length < 2) {
        searchDropdown.classList.remove('active');
        return;
    }
    
    // Debounce 300ms
    searchTimeout = setTimeout(() => {
        searchDropdown.innerHTML = '<div class="search-loading">🔍 Đang tìm kiếm...</div>';
        searchDropdown.classList.add('active');
        
        fetch('<?= APP_URL ?>/Home/liveSearch?q=' + encodeURIComponent(keyword))
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    searchDropdown.innerHTML = '<div class="search-no-result">😕 Không tìm thấy sản phẩm nào</div>';
                } else {
                    searchDropdown.innerHTML = data.map(p => {
                        const discountPercent = p.discount_percent || 0;
                        const giaGoc = Number(p.giaXuat || 0);
                        const giaSauGiam = discountPercent > 0 ? Math.round(giaGoc * (100 - discountPercent) / 100) : giaGoc;
                        const priceHtml = discountPercent > 0 
                            ? `${giaSauGiam.toLocaleString('vi-VN')} ₫ <span class="old-price">${giaGoc.toLocaleString('vi-VN')} ₫</span>`
                            : `${giaGoc.toLocaleString('vi-VN')} ₫`;
                        
                        return `
                            <a href="<?= APP_URL ?>/Home/quickBuy/${p.masp}" class="search-item">
                                <img src="<?= APP_URL ?>/public/Images/${p.hinhanh || 'default.png'}" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                                <div class="search-item-info">
                                    <div class="search-item-name">${p.tensp}</div>
                                    <div class="search-item-price">${priceHtml}</div>
                                    <div class="search-item-category">${p.tenLoaiSP || ''}</div>
                                </div>
                            </a>
                        `;
                    }).join('');
                }
            })
            .catch(err => {
                searchDropdown.innerHTML = '<div class="search-no-result">❌ Có lỗi xảy ra</div>';
            });
    }, 300);
});

// Ẩn dropdown khi click ra ngoài
document.addEventListener('click', function(e) {
    if (!e.target.closest('.search-wrapper')) {
        searchDropdown.classList.remove('active');
    }
});

// Enter để search trang kết quả
searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        searchDropdown.classList.remove('active');
        searchProducts();
    }
});

// Toggle Favorite
function toggleFavorite(btn) {
    const masp = btn.dataset.masp;
    if (!masp) {
        console.log('No masp found');
        return;
    }
    
    fetch('<?= APP_URL ?>/Home/toggleFavorite', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'masp=' + masp
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.classList.toggle('active', data.isFavorite);
            btn.style.background = data.isFavorite ? '#ffe0e0' : '#fff';
            btn.innerHTML = data.isFavorite ? '💖' : '❤️';
            
            // Update favorite count in navbar
            const countEl = document.getElementById('navFavoriteCount');
            if (countEl) countEl.textContent = data.totalFavorites;
        }
    })
    .catch(err => console.error('Error:', err));
}



// ========== LEGO MEGA MENU HOVER ==========
const legoMenuItems = document.querySelectorAll('#legoMegaMenu .lego-menu-item');
const legoProductsGrid = document.getElementById('legoProductsGrid');
const legoProductsTitle = document.getElementById('legoProductsTitle');

legoMenuItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
        // Update active state
        legoMenuItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');
        
        // Get products data
        const products = JSON.parse(this.dataset.products || '[]');
        const categoryTitle = this.dataset.title || 'LEGO';
        
        // Update title
        if (legoProductsTitle) {
            legoProductsTitle.textContent = categoryTitle;
        }
        
        // Render products
        if (legoProductsGrid && products.length > 0) {
            legoProductsGrid.innerHTML = products.map(p => `
                <a href="<?= APP_URL ?>/Home/detail/${p.masp}" class="lego-product-card">
                    <img src="<?= APP_URL ?>/public/Images/${p.hinhanh || 'default.png'}" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                    <div class="lego-product-name">${p.tensp}</div>
                    <div class="lego-product-price">
                        <span class="lego-sale-price">${Number(p.gia_ban || p.giaXuat || 0).toLocaleString('vi-VN')}đ</span>
                    </div>
                </a>
            `).join('');
        } else if (legoProductsGrid) {
            legoProductsGrid.innerHTML = '<p style="padding:20px; color:#666;">Chưa có sản phẩm trong danh mục này</p>';
        }
    });
});

// ========== MEGA MENU SẢN PHẨM HOVER ==========
const megaCategories = document.querySelectorAll('#productMegaMenu .mega-category');
const megaProductGrid = document.getElementById('megaProductGrid');
const megaProductsTitle = document.getElementById('megaProductsTitle');

megaCategories.forEach(cat => {
    cat.addEventListener('mouseenter', function() {
        // Update active state
        megaCategories.forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        
        // Get products data
        const products = JSON.parse(this.dataset.products || '[]');
        const categoryName = this.textContent.trim();
        
        // Update title
        if (megaProductsTitle) {
            megaProductsTitle.textContent = categoryName;
        }
        
        // Render products
        if (megaProductGrid && products.length > 0) {
            megaProductGrid.innerHTML = products.map(p => `
                <a href="<?= APP_URL ?>/Home/detail/${p.masp}" class="mega-product-card">
                    <img src="<?= APP_URL ?>/public/Images/${p.hinhanh || 'default.png'}" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                    <div class="name">${p.tensp}</div>
                    <div class="price">${Number(p.gia_ban).toLocaleString('vi-VN')}đ</div>
                </a>
            `).join('');
        } else if (megaProductGrid) {
            megaProductGrid.innerHTML = '<p style="padding:20px; color:#666;">Chưa có sản phẩm trong danh mục này</p>';
        }
    });
});

// ========== AGE MEGA MENU HOVER ==========
const ageMenuItems = document.querySelectorAll('#ageMegaMenu .lego-menu-item');
const ageProductsGrid = document.getElementById('ageProductsGrid');
const ageProductsTitle = document.getElementById('ageProductsTitle');

ageMenuItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
        // Update active state
        ageMenuItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');
        
        // Get products data
        const products = JSON.parse(this.dataset.products || '[]');
        const title = this.dataset.title || 'Đồ chơi theo độ tuổi';
        
        // Update title
        if (ageProductsTitle) {
            ageProductsTitle.textContent = title;
        }
        
        // Render products
        if (ageProductsGrid && products.length > 0) {
            ageProductsGrid.innerHTML = products.map(p => `
                <a href="<?= APP_URL ?>/Home/quickBuy/${p.masp}" class="lego-product-card">
                    <img src="<?= APP_URL ?>/public/Images/${p.hinhanh || 'default.png'}" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                    <div class="lego-product-name">${p.tensp}</div>
                    <div class="lego-product-price">
                        <span class="lego-sale-price">${Number(p.gia_ban || 0).toLocaleString('vi-VN')}đ</span>
                    </div>
                </a>
            `).join('');
        } else if (ageProductsGrid) {
            ageProductsGrid.innerHTML = '<p style="padding:20px; color:#666;">Chưa có sản phẩm cho độ tuổi này</p>';
        }
    });
});

// ========== PROMO MEGA MENU HOVER ==========
const promoMenuItems = document.querySelectorAll('#promoMegaMenu .lego-menu-item');
const promoProductsGrid = document.getElementById('promoProductsGrid');
const promoProductsTitle = document.getElementById('promoProductsTitle');

promoMenuItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
        // Update active state
        promoMenuItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');
        
        // Get products data
        const products = JSON.parse(this.dataset.products || '[]');
        const title = this.dataset.title || 'Sản phẩm khuyến mãi';
        
        // Update title
        if (promoProductsTitle) {
            promoProductsTitle.textContent = title;
        }
        
        // Render products with discount badge and discounted price
        if (promoProductsGrid && products.length > 0) {
            promoProductsGrid.innerHTML = products.map(p => {
                const discountPercent = p.discount_percent || 0;
                const discountBadge = discountPercent ? `<span style="position:absolute;top:5px;left:5px;background:#e31837;color:#fff;padding:3px 8px;border-radius:12px;font-size:11px;font-weight:700;">-${discountPercent}%</span>` : '';
                const giaGoc = Number(p.gia_ban || 0);
                const giaSauGiam = discountPercent > 0 ? Math.round(giaGoc * (100 - discountPercent) / 100) : giaGoc;
                const priceHtml = discountPercent > 0 
                    ? `<span class="lego-sale-price">${giaSauGiam.toLocaleString('vi-VN')}đ</span><span style="text-decoration:line-through;color:#999;font-size:10px;display:block;">${giaGoc.toLocaleString('vi-VN')}đ</span>`
                    : `<span class="lego-sale-price">${giaGoc.toLocaleString('vi-VN')}đ</span>`;
                return `
                <a href="<?= APP_URL ?>/Home/quickBuy/${p.masp}" class="lego-product-card" style="position:relative;">
                    ${discountBadge}
                    <img src="<?= APP_URL ?>/public/Images/${p.hinhanh || 'default.png'}" alt="" onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                    <div class="lego-product-name">${p.tensp}</div>
                    <div class="lego-product-price">${priceHtml}</div>
                </a>
            `}).join('');
        } else if (promoProductsGrid) {
            promoProductsGrid.innerHTML = '<p style="padding:20px; color:#666; grid-column:1/-1;">Chưa có sản phẩm trong chương trình này</p>';
        }
    });
});

// ========== BANNER SLIDER ==========
let currentSlide = 0;
const totalSlides = 4;
const track = document.getElementById('bannerTrack');
const dots = document.querySelectorAll('.dot');

function updateSlider() {
    if (track) {
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateSlider();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateSlider();
}

function goToSlide(index) {
    currentSlide = index;
    updateSlider();
}

// Auto slide every 5 seconds
setInterval(nextSlide, 5000);
</script>

<script>!function(s,u,b,i,z){var o,t,r,y;s[i]||(s._sbzaccid=z,s[i]=function(){s[i].q.push(arguments)},s[i].q=[],s[i]("setAccount",z),r=["widget.subiz.net","storage.googleapis"+(t=".com"),"app.sbz.workers.dev",i+"a"+(o=function(k,t){var n=t<=6?5:o(k,t-1)+o(k,t-3);return k!==t?n:n.toString(32)})(20,20)+t,i+"b"+o(30,30)+t,i+"c"+o(40,40)+t],(y=function(k){var t,n;s._subiz_init_2094850928430||r[k]&&(t=u.createElement(b),n=u.getElementsByTagName(b)[0],t.async=1,t.src="https://"+r[k]+"/sbz/app.js?accid="+z,n.parentNode.insertBefore(t,n),setTimeout(y,2e3,k+1))})(0))}(window,document,"script","subiz", "acsnbbwlonkkickkunqc")</script>

</body>
</html>
