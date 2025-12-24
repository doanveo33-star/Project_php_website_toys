<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - ToyShop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #003399 0%, #e31837 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 20px;
        }
        .register-box {
            width: 100%;
            max-width: 450px;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            animation: fadeIn 0.4s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo-section {
            text-align: center;
            margin-bottom: 25px;
        }
        .logo-section .icon { font-size: 50px; }
        .logo-section h1 {
            font-size: 28px;
            color: #003399;
            margin-top: 10px;
        }
        .register-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-size: 22px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #999;
        }
        .input-wrap input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }
        .input-wrap input:focus {
            border-color: #003399;
            box-shadow: 0 0 0 3px rgba(0,51,153,0.1);
        }
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #003399, #002266);
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #002266, #001a4d);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,51,153,0.3);
        }
        .error-msg {
            background: #ffe6e6;
            color: #e31837;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        .link-group {
            text-align: center;
            margin-top: 25px;
        }
        .link-group a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #e31837;
            font-weight: 500;
            transition: 0.2s;
        }
        .link-group a:hover {
            color: #003399;
        }
        .benefits {
            background: #f0f7ff;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
        }
        .benefits h4 {
            color: #003399;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .benefits ul {
            list-style: none;
            font-size: 13px;
            color: #555;
        }
        .benefits li {
            padding: 5px 0;
        }
        .benefits li::before {
            content: '✓ ';
            color: #2ecc71;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="register-box">
    <div class="logo-section">
        <div class="icon">🎮</div>
        <h1>TOYSHOP</h1>
    </div>
    
    <h2>Đăng ký thành viên</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="benefits">
        <h4>🎁 Quyền lợi thành viên:</h4>
        <ul>
            <li>Tích điểm đổi quà hấp dẫn</li>
            <li>Nhận thông báo khuyến mãi sớm nhất</li>
            <li>Theo dõi đơn hàng dễ dàng</li>
            <li>Ưu đãi sinh nhật đặc biệt</li>
        </ul>
    </div>

    <form action="<?= APP_URL ?>/AuthController/register" method="POST">
        <div class="form-group">
            <label>Họ và tên</label>
            <div class="input-wrap">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="fullname" placeholder="Nhập họ tên đầy đủ" required>
            </div>
        </div>

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Nhập email của bạn" required>
            </div>
        </div>

        <div class="form-group">
            <label>Mật khẩu</label>
            <div class="input-wrap">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Tạo mật khẩu (ít nhất 6 ký tự)" required minlength="6">
            </div>
        </div>

        <button type="submit" class="btn-register">📝 Đăng ký ngay</button>
    </form>

    <div class="link-group">
        <a href="<?= APP_URL ?>/AuthController/ShowLogin">🔐 Đã có tài khoản? Đăng nhập</a>
        <a href="<?= APP_URL ?>/Home">🏠 Quay về trang chủ</a>
    </div>
</div>

</body>
</html>
