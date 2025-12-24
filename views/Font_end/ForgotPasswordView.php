<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - ToyShop</title>
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
        .forgot-box {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            animation: fadeIn 0.4s ease;
            text-align: center;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .forgot-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e31837, #ff4757);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        .forgot-icon i {
            font-size: 36px;
            color: #fff;
        }
        .forgot-box h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .forgot-box p {
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .form-group { margin-bottom: 25px; text-align: left; }
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
            border-color: #e31837;
            box-shadow: 0 0 0 3px rgba(227,24,55,0.1);
        }
        .btn-reset {
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
        }
        .btn-reset:hover {
            background: linear-gradient(135deg, #002266, #001a4d);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,51,153,0.3);
        }
        .info-box {
            background: #e8f4fd;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            text-align: left;
        }
        .info-box h4 {
            color: #003399;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .info-box p {
            margin: 0;
            font-size: 13px;
            color: #555;
        }
        .link-group {
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
    </style>
</head>
<body>

<div class="forgot-box">
    <div class="forgot-icon">
        <i class="fa-solid fa-key"></i>
    </div>
    
    <h2>Quên mật khẩu?</h2>
    <p>Đừng lo! Nhập email đăng ký của bạn, chúng tôi sẽ gửi mật khẩu mới cho bạn.</p>

    <div class="info-box">
        <h4>📧 Lưu ý:</h4>
        <p>Mật khẩu mới sẽ được gửi đến email của bạn. Vui lòng kiểm tra cả hộp thư spam nếu không thấy email.</p>
    </div>

    <form action="<?= APP_URL ?>/AuthController/resetPassword" method="POST">
        <div class="form-group">
            <label>Email đăng ký</label>
            <div class="input-wrap">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Nhập email của bạn" required>
            </div>
        </div>

        <button type="submit" class="btn-reset">📨 Gửi mật khẩu mới</button>
    </form>

    <div class="link-group">
        <a href="<?= APP_URL ?>/AuthController/ShowLogin">🔐 Quay lại đăng nhập</a>
        <a href="<?= APP_URL ?>/Home">🏠 Quay về trang chủ</a>
    </div>
</div>

</body>
</html>
