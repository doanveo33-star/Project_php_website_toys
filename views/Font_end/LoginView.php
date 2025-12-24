<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - ToyShop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e31837 0%, #003399 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 20px;
        }
        .login-box {
            width: 100%;
            max-width: 420px;
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
        .login-box h2 {
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
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #e31837, #c41530);
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #c41530, #a01025);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(227,24,55,0.3);
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
            color: #003399;
            font-weight: 500;
            transition: 0.2s;
        }
        .link-group a:hover {
            color: #e31837;
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }
        .divider span {
            padding: 0 15px;
            color: #999;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="logo-section">
        <div class="icon">🎮</div>
        <h1>TOYSHOP</h1>
    </div>
    
    <h2>Đăng nhập tài khoản</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="<?= APP_URL ?>/AuthController/login" method="POST">
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
                <input type="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
        </div>

        <button type="submit" class="btn-login">🔐 Đăng nhập</button>
    </form>

    <div class="divider"><span>hoặc</span></div>

    <div class="link-group">
        <a href="<?= APP_URL ?>/AuthController/ShowRegister">📝 Chưa có tài khoản? Đăng ký ngay</a>
        <a href="<?= APP_URL ?>/AuthController/ShowForgotPassword">🔑 Quên mật khẩu?</a>
        <a href="<?= APP_URL ?>/Home">🏠 Quay về trang chủ</a>
    </div>
</div>

</body>
</html>
