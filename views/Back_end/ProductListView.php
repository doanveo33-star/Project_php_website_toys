<?php
$products = $data['productList'] ?? [];
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h2 style="margin: 0; color: #333;">🎮 Quản lý sản phẩm đồ chơi</h2>
    <a href="<?= APP_URL ?>/Product/create" 
       style="padding: 12px 20px; background: #28a745; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600;">
        ➕ Thêm sản phẩm
    </a>
</div>

<?php if(isset($_SESSION['success'])): ?>
    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<!-- THỐNG KÊ -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px;">
    <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="font-size: 32px; margin-bottom: 10px;">📦</div>
        <div style="font-size: 24px; font-weight: 700; color: #003399;"><?= count($products) ?></div>
        <div style="color: #666; font-size: 14px;">Tổng sản phẩm</div>
    </div>
    <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="font-size: 32px; margin-bottom: 10px;">🧱</div>
        <div style="font-size: 24px; font-weight: 700; color: #e31837;"><?= count(array_filter($products, fn($p) => $p['maLoaiSP'] == 'LEGO')) ?></div>
        <div style="color: #666; font-size: 14px;">Sản phẩm LEGO</div>
    </div>
    <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="font-size: 32px; margin-bottom: 10px;">🤖</div>
        <div style="font-size: 24px; font-weight: 700; color: #28a745;"><?= count(array_filter($products, fn($p) => $p['maLoaiSP'] == 'Robot')) ?></div>
        <div style="color: #666; font-size: 14px;">Robot & Điều khiển</div>
    </div>
    <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div style="font-size: 32px; margin-bottom: 10px;">⚠️</div>
        <div style="font-size: 24px; font-weight: 700; color: #ffc107;"><?= count(array_filter($products, fn($p) => ($p['soluong'] ?? 0) < 10)) ?></div>
        <div style="color: #666; font-size: 14px;">Sắp hết hàng</div>
    </div>
</div>

<!-- BẢNG SẢN PHẨM -->
<div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: linear-gradient(135deg, #003399 0%, #002266 100%); color: #fff;">
                <th style="padding: 15px; text-align: center;">#</th>
                <th style="padding: 15px; text-align: left;">Ảnh</th>
                <th style="padding: 15px; text-align: left;">Mã SP</th>
                <th style="padding: 15px; text-align: left;">Tên sản phẩm</th>
                <th style="padding: 15px; text-align: left;">Loại</th>
                <th style="padding: 15px; text-align: center;">Độ tuổi</th>
                <th style="padding: 15px; text-align: right;">Giá nhập</th>
                <th style="padding: 15px; text-align: right;">Giá bán</th>
                <th style="padding: 15px; text-align: center;">Tồn kho</th>
                <th style="padding: 15px; text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($products)): $i = 1; ?>
                <?php foreach($products as $v): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px; text-align: center;"><?= $i++ ?></td>
                    <td style="padding: 15px;">
                        <img src="<?= APP_URL ?>/public/Images/<?= $v['hinhanh'] ?: 'default.png' ?>" 
                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;"
                             onerror="this.src='<?= APP_URL ?>/public/Images/default.png'">
                    </td>
                    <td style="padding: 15px;"><strong style="color: #003399;"><?= htmlspecialchars($v['masp']) ?></strong></td>
                    <td style="padding: 15px; max-width: 200px;">
                        <?= htmlspecialchars($v['tensp']) ?>
                    </td>
                    <td style="padding: 15px;">
                        <span style="background: #e3f2fd; color: #1976d2; padding: 4px 10px; border-radius: 15px; font-size: 12px;">
                            <?= htmlspecialchars($v['maLoaiSP']) ?>
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <?php if(!empty($v['doTuoi'])): ?>
                            <span style="background: #fff3e0; color: #e65100; padding: 4px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                                🎯 <?= htmlspecialchars($v['doTuoi']) ?>
                            </span>
                        <?php else: ?>
                            <span style="color: #999;">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px; text-align: right; color: #666;">
                        <?= number_format($v['giaNhap'] ?? 0) ?> ₫
                    </td>
                    <td style="padding: 15px; text-align: right; font-weight: 700; color: #e31837;">
                        <?= number_format($v['giaXuat'] ?? 0) ?> ₫
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <?php 
                        $sl = $v['soluong'] ?? 0;
                        $bgColor = $sl < 10 ? '#fff3cd' : ($sl < 50 ? '#d4edda' : '#d1ecf1');
                        $textColor = $sl < 10 ? '#856404' : ($sl < 50 ? '#155724' : '#0c5460');
                        ?>
                        <span style="background: <?= $bgColor ?>; color: <?= $textColor ?>; padding: 4px 12px; border-radius: 15px; font-weight: 600;">
                            <?= $sl ?>
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="<?= APP_URL ?>/Product/edit/<?= $v['masp'] ?>" 
                           style="display: inline-block; padding: 6px 12px; background: #ffc107; color: #333; text-decoration: none; border-radius: 6px; margin-right: 5px;">
                            ✏️
                        </a>
                        <a href="<?= APP_URL ?>/Product/delete/<?= $v['masp'] ?>" 
                           onclick="return confirm('Xóa sản phẩm này?')" 
                           style="display: inline-block; padding: 6px 12px; background: #e31837; color: #fff; text-decoration: none; border-radius: 6px;">
                            🗑️
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" style="padding: 60px; text-align: center;">
                        <div style="font-size: 64px; margin-bottom: 15px;">📦</div>
                        <p style="color: #666; font-size: 16px;">Chưa có sản phẩm nào</p>
                        <a href="<?= APP_URL ?>/Product/create" 
                           style="display: inline-block; margin-top: 15px; padding: 12px 25px; background: #003399; color: #fff; text-decoration: none; border-radius: 8px;">
                            ➕ Thêm sản phẩm đầu tiên
                        </a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
