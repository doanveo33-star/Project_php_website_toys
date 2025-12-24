<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác thực OTP - ToyShop</title>
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
        .otp-box {
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
        .otp-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #003399, #0055cc);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        .otp-icon i {
            font-size: 36px;
            color: #fff;
        }
        .otp-box h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .otp-box p {
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .otp-box p strong {
            color: #003399;
        }
        .form-group { margin-bottom: 25px; }
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
            padding: 16px 16px 16px 50px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 20px;
            letter-spacing: 8px;
            text-align: center;
            outline: none;
            transition: 0.3s;
        }
        .input-wrap input:focus {
            border-color: #003399;
            box-shadow: 0 0 0 3px rgba(0,51,153,0.1);
        }
        .btn-verify {
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
        }
        .btn-verify:hover {
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
            font-size: 14px;
        }
        .timer {
            background: #fff3cd;
            color: #856404;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .timer i { margin-right: 8px; }
        .link-group {
            margin-top: 25px;
        }
        .link-group a {
            display: inline-block;
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

<div class="otp-box">
    <div class="otp-icon">
        <i class="fa-solid fa-shield-halved"></i>
    </div>
    
    <h2>Xác thực OTP</h2>
    <p>Chúng tôi đã gửi mã xác thực đến email của bạn.<br>Vui lòng nhập mã <strong>6 chữ số</strong> để hoàn tất đăng ký.</p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="timer">
        <i class="fa-solid fa-clock"></i>
        Mã OTP có hiệu lực trong <strong>3 phút</strong>
    </div>

    <form action="<?= APP_URL ?>/AuthController/verifyOtp" method="POST">
        <div class="form-group">
            <div class="input-wrap">
                <i class="fa-solid fa-key"></i>
                <input type="text" name="otp" placeholder="------" maxlength="6" pattern="[0-9]{6}" required autofocus>
            </div>
        </div>

        <button type="submit" class="btn-verify">✓ Xác nhận</button>
    </form>

    <div class="link-group">
        <a href="<?= APP_URL ?>/AuthController/ShowRegister">← Quay lại đăng ký</a>
    </div>
</div>

</body>
</html>
