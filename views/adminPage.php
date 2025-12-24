<!doctype html>
<html lang="vi">
<head>
    <title>Quản trị - ToyShop Admin</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        :root {
            --primary-blue: #003399;
            --dark-blue: #002266;
            --primary-red: #e31837;
            --yellow: #ffd700;
            --white: #ffffff;
            --light-gray: #f5f7fa;
            --text-dark: #2c3e50;
            --border-color: #e1e8ed;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --info: #3498db;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: var(--light-gray); min-height: 100vh; }
        
        /* SIDEBAR */
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: var(--white);
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }
        .sidebar-header {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }
        .sidebar-logo {
            font-size: 26px;
            font-weight: 800;
            color: var(--yellow);
            text-decoration: none;
            display: block;
        }
        .sidebar-subtitle {
            font-size: 11px;
            color: rgba(255,255,255,0.6);
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .sidebar-menu { list-style: none; padding: 15px 0; }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 25px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: rgba(255,255,255,0.1);
            color: var(--yellow);
            border-left-color: var(--yellow);
        }
        .sidebar-menu li a .icon { font-size: 18px; width: 24px; text-align: center; }
        .menu-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 10px 20px; }
        
        /* MAIN CONTENT */
        .admin-main { margin-left: 260px; min-height: 100vh; }
        .admin-header {
            background: var(--white);
            padding: 18px 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border-color);
        }
        .admin-header h1 { font-size: 20px; color: var(--text-dark); font-weight: 600; }
        .admin-user { display: flex; align-items: center; gap: 12px; }
        .admin-user span { font-size: 14px; color: #666; }
        .admin-user .avatar {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }
        .admin-container { padding: 25px 30px; }
        
        /* STATS GRID */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
        .stat-card {
            background: var(--white);
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 18px;
            border: 1px solid var(--border-color);
            transition: all 0.3s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .stat-icon {
            width: 55px; height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }
        .stat-icon.blue { background: linear-gradient(135deg, #e3f2fd, #bbdefb); }
        .stat-icon.green { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); }
        .stat-icon.orange { background: linear-gradient(135deg, #fff3e0, #ffe0b2); }
        .stat-icon.red { background: linear-gradient(135deg, #ffebee, #ffcdd2); }
        .stat-info h3 { font-size: 26px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
        .stat-info p { font-size: 13px; color: #7f8c8d; }
        
        /* PAGE HEADER */
        .page-header { margin-bottom: 25px; }
        .page-title { font-size: 22px; font-weight: 700; color: var(--text-dark); display: flex; align-items: center; gap: 10px; }
        
        /* CARDS */
        .card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }
        .card-header {
            padding: 18px 22px;
            background: linear-gradient(135deg, #f8f9fa, #fff);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--text-dark);
            font-size: 15px;
        }
        .card-body { padding: 22px; }
        
        /* TABLE */
        .table-responsive { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table thead { background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue)); }
        .table th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            color: var(--white);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-dark);
            vertical-align: middle;
        }
        .table tbody tr:hover { background: #f8fafc; }
        .table tbody tr:last-child td { border-bottom: none; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        /* PRODUCT IMAGE */
        .product-img {
            width: 60px; height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        
        /* BADGES */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .badge-primary { background: #cce5ff; color: #004085; }
        
        /* STOCK INDICATORS */
        .stock-ok { color: var(--success); font-weight: 700; font-size: 16px; }
        .stock-low { color: var(--warning); font-weight: 700; font-size: 16px; }
        .stock-out { color: var(--danger); font-weight: 700; font-size: 16px; }
        
        /* BUTTONS */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.3s;
        }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-primary { background: var(--primary-blue); color: var(--white); }
        .btn-primary:hover { background: var(--dark-blue); transform: translateY(-1px); }
        .btn-danger { background: var(--danger); color: var(--white); }
        .btn-danger:hover { background: #c0392b; }
        .btn-success { background: var(--success); color: var(--white); }
        .btn-success:hover { background: #219a52; }
        .btn-warning { background: var(--warning); color: var(--white); }
        .btn-warning:hover { background: #e67e22; }
        .btn-secondary { background: #95a5a6; color: var(--white); }
        .btn-secondary:hover { background: #7f8c8d; }
        .btn-info { background: var(--info); color: var(--white); }
        .btn-info:hover { background: #2980b9; }
        
        .action-btns { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }
        
        /* FORMS */
        .form-row { display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end; }
        .form-group { margin-bottom: 18px; flex: 1; min-width: 180px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark); font-size: 13px; }
        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            background: var(--white);
        }
        .form-control:focus { outline: none; border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(0,51,153,0.1); }
        textarea.form-control { min-height: 100px; resize: vertical; }
        select.form-control { cursor: pointer; }
        
        /* ALERTS */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn-close { background: none; border: none; font-size: 20px; cursor: pointer; opacity: 0.5; }
        .btn-close:hover { opacity: 1; }
        
        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 50px 20px; color: #95a5a6; }
        .empty-state .icon { font-size: 50px; margin-bottom: 15px; opacity: 0.5; }
        .empty-state p { font-size: 15px; }
        
        /* RESPONSIVE */
        @media (max-width: 1400px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 992px) {
            .admin-sidebar { width: 70px; }
            .sidebar-logo span, .sidebar-subtitle, .sidebar-menu li a span { display: none; }
            .sidebar-menu li a { justify-content: center; padding: 14px; }
            .admin-main { margin-left: 70px; }
            .admin-container { padding: 20px 15px; }
        }
        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr; }
            .form-row { flex-direction: column; }
            .form-group { min-width: 100%; }
        }
    </style>
</head>
<body>

<aside class="admin-sidebar">
    <div class="sidebar-header">
        <a href="<?php echo APP_URL;?>/Admin/" class="sidebar-logo">🎮 <span>TOYSHOP</span></a>
        <div class="sidebar-subtitle">Admin Panel</div>
    </div>
    
    <ul class="sidebar-menu">
        <li><a href="<?php echo APP_URL;?>/Admin/"><span class="icon">📊</span><span>Dashboard</span></a></li>
        <div class="menu-divider"></div>
        <li><a href="<?php echo APP_URL;?>/ProductType/"><span class="icon">📁</span><span>Loại sản phẩm</span></a></li>
        <li><a href="<?php echo APP_URL;?>/Product/"><span class="icon">🎮</span><span>Sản phẩm</span></a></li>
        <div class="menu-divider"></div>
        <li><a href="<?php echo APP_URL;?>/Admin/orderList"><span class="icon">📦</span><span>Đơn hàng</span></a></li>
        <li><a href="<?php echo APP_URL;?>/Admin/promotionList"><span class="icon">🎁</span><span>Khuyến mãi</span></a></li>
        <li><a href="<?php echo APP_URL;?>/Admin/inventory"><span class="icon">📈</span><span>Kho hàng</span></a></li>
        <div class="menu-divider"></div>
        <li><a href="<?php echo APP_URL;?>/Admin/reviewList"><span class="icon">⭐</span><span>Đánh giá</span></a></li>
        <li><a href="<?php echo APP_URL;?>/Admin/userList"><span class="icon">👥</span><span>Người dùng</span></a></li>
        <div class="menu-divider"></div>
        <li><a href="<?php echo APP_URL;?>/Home"><span class="icon">🏠</span><span>Về trang chủ</span></a></li>
    </ul>
</aside>

<main class="admin-main">
    <header class="admin-header">
        <h1>🎮 ToyShop Admin</h1>
        <div class="admin-user">
            <span>Admin</span>
            <div class="avatar">A</div>
        </div>
    </header>
    
    <div class="admin-container">
        <?php require_once "./views/Back_end/".$data["page"].".php"; ?>
    </div>
</main>

</body>
</html>
