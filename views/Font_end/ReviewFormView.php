<?php
$product = $data['product'] ?? [];
$reviews = $data['reviews'] ?? [];
$stats = $data['stats'] ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đánh giá - <?= htmlspecialchars($product['tensp'] ?? '') ?> - ToyShop</title>
    <style>
        :root {
            --primary-red: #e31837;
            --primary-blue: #003399;
            --dark-blue: #002266;
            --yellow: #ffd700;
            --light-gray: #f5f5f5;
            --text-dark: #333;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: var(--light-gray); min-height: 100vh; }
        
        .site-header { background: var(--primary-blue); padding: 15px 0; }
        .header-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { font-size: 24px; font-weight: 800; color: var(--yellow); text-decoration: none; }
        .main-nav { display: flex; gap: 25px; }
        .main-nav a { color: #fff; text-decoration: none; font-size: 14px; font-weight: 500; }
        .main-nav a:hover { color: var(--yellow); }
        
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: var(--primary-blue); text-decoration: none; margin-bottom: 20px; font-weight: 600; }
        .back-link:hover { color: var(--primary-red); }
        
        .product-header { background: #fff; border-radius: 16px; padding: 25px; display: flex; gap: 25px; margin-bottom: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .product-header img { width: 140px; height: 140px; object-fit: contain; border-radius: 12px; background: var(--light-gray); padding: 10px; }
        .product-header-info h1 { color: var(--primary-blue); font-size: 22px; margin-bottom: 10px; }
        .product-header-info p { color: #666; font-size: 14px; }
        .rating-stats { display: flex; align-items: center; gap: 15px; margin-top: 15px; }
        .avg-rating { text-align: center; }
        .avg-rating .number { font-size: 42px; font-weight: 700; color: var(--primary-red); }
        .avg-rating .stars { color: #f39c12; font-size: 18px; }
        .avg-rating .count { color: #666; font-size: 13px; margin-top: 5px; }
</style>
</head>
<body>
<header class="site-header">
    <div class="header-container">
        <a href="<?= APP_URL ?>/Home" class="logo">🎮 TOYSHOP</a>
        <nav class="main-nav">
            <a href="<?= APP_URL ?>/Home">Trang chủ</a>
            <a href="<?= APP_URL ?>/Home/reviewList">Đánh giá</a>
            <a href="<?= APP_URL ?>/Home/orderHistory">Đơn hàng</a>
        </nav>
    </div>
</header>

<div class="container">
    <a href="<?= APP_URL ?>/Home/reviewList" class="back-link">← Quay lại danh sách sản phẩm</a>
    
    <?php if(isset($_SESSION['review_success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['review_success']; unset($_SESSION['review_success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['review_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['review_error']; unset($_SESSION['review_error']); ?></div>
    <?php endif; ?>
    
    <div class="product-header">
        <img src="<?= APP_URL ?>/public/Images/<?= $product['hinhanh'] ?: 'default.png' ?>" alt="">
        <div class="product-header-info">
            <h1><?= htmlspecialchars($product['tensp'] ?? '') ?></h1>
            <p>Loại: <?= htmlspecialchars($product['maLoaiSP'] ?? '') ?></p>
            <?php if ($stats && ($stats['total_reviews'] ?? 0) > 0): ?>
            <div class="rating-stats">
                <div class="avg-rating">
                    <div class="number"><?= number_format($stats['avg_rating'], 1) ?></div>
                    <div class="stars"><?php for ($i = 1; $i <= 5; $i++) echo $i <= round($stats['avg_rating']) ? '⭐' : '☆'; ?></div>
                    <div class="count"><?= $stats['total_reviews'] ?> đánh giá</div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if (isset($_SESSION['user'])): ?>
    <div class="review-form-card">
        <h2>✍️ Viết đánh giá của bạn</h2>
        <form action="<?= APP_URL ?>/Home/submitReview" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['masp'] ?? '') ?>">
            <div class="form-group">
                <label class="form-label">Đánh giá của bạn *</label>
                <div class="star-rating">
                    <input type="radio" name="rating" value="5" id="star5" required><label for="star5">★</label>
                    <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
                    <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
                    <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
                    <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Nhận xét của bạn</label>
                <textarea name="comment" class="form-control" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Thêm hình ảnh (tùy chọn)</label>
                <div class="image-upload">
                    <label class="upload-btn">📷 Chọn ảnh<input type="file" name="review_image" accept="image/*" onchange="previewImage(this)"></label>
                    <img id="preview" class="preview-img">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">📤 Gửi đánh giá</button>
        </form>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">⚠️ Vui lòng <a href="<?= APP_URL ?>/AuthController/ShowLogin">đăng nhập</a> để gửi đánh giá</div>
    <?php endif; ?>

    <div class="reviews-list">
        <h2>📝 Đánh giá từ khách hàng (<?= count($reviews) ?>)</h2>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
            <div class="review-item">
                <div class="review-header">
                    <span class="review-user">👤 <?= htmlspecialchars($review['user_name']) ?></span>
                    <span class="review-date"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></span>
                </div>
                <div class="review-stars"><?php for ($i = 1; $i <= 5; $i++) echo $i <= $review['rating'] ? '⭐' : '☆'; ?></div>
                <?php if ($review['comment']): ?><div class="review-comment"><?= nl2br(htmlspecialchars($review['comment'])) ?></div><?php endif; ?>
                <?php if ($review['image']): ?><img src="<?= APP_URL ?>/public/Images/reviews/<?= $review['image'] ?>" class="review-image" alt=""><?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty-reviews">Chưa có đánh giá nào. Hãy là người đầu tiên!</p>
        <?php endif; ?>
    </div>
</div>

<style>
    .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
    .alert-success { background: #d4edda; color: #155724; }
    .alert-danger { background: #f8d7da; color: #721c24; }
    .alert-warning { background: #fff3cd; color: #856404; }
    .alert a { color: var(--primary-blue); font-weight: 600; }
    
    .review-form-card { background: #fff; border-radius: 16px; padding: 30px; margin-bottom: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .review-form-card h2 { color: var(--primary-blue); margin-bottom: 25px; font-size: 20px; }
    
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 10px; font-weight: 600; color: var(--text-dark); font-size: 14px; }
    .form-control { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.3s; }
    .form-control:focus { outline: none; border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(0,51,153,0.1); }
    textarea.form-control { min-height: 120px; resize: vertical; }
    
    .star-rating { display: flex; gap: 5px; flex-direction: row-reverse; justify-content: flex-end; }
    .star-rating input { display: none; }
    .star-rating label { font-size: 36px; color: #ddd; cursor: pointer; transition: all 0.2s; }
    .star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label { color: #f39c12; transform: scale(1.1); }
    
    .image-upload input[type="file"] { display: none; }
    .upload-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; background: #f0f5ff; border: 2px dashed var(--primary-blue); border-radius: 10px; cursor: pointer; color: var(--primary-blue); font-weight: 600; transition: all 0.3s; }
    .upload-btn:hover { background: #e0ebff; }
    .preview-img { max-width: 200px; margin-top: 15px; border-radius: 10px; display: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    
    .btn { padding: 14px 35px; border-radius: 50px; font-size: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.3s; }
    .btn-primary { background: linear-gradient(135deg, var(--primary-red), #c41530); color: #fff; box-shadow: 0 4px 15px rgba(227,24,55,0.3); }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(227,24,55,0.4); }
    
    .reviews-list { margin-top: 30px; }
    .reviews-list h2 { color: var(--primary-blue); margin-bottom: 20px; font-size: 20px; }
    .review-item { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #eee; }
    .review-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
    .review-user { font-weight: 600; color: var(--primary-blue); }
    .review-date { color: #999; font-size: 13px; }
    .review-stars { color: #f39c12; margin-bottom: 12px; font-size: 16px; }
    .review-comment { color: #555; line-height: 1.7; font-size: 14px; }
    .review-image { max-width: 200px; margin-top: 15px; border-radius: 10px; }
    .empty-reviews { color: #999; text-align: center; padding: 40px; font-size: 15px; }
</style>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) { preview.src = e.target.result; preview.style.display = 'block'; }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
