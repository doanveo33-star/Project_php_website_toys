<!-- THÔNG BÁO -->
<?php if(isset($_SESSION['success'])): ?>
    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
    
    <!-- HEADER -->
    <div style="background: linear-gradient(135deg, #003399 0%, #002266 100%); color: #fff; padding: 20px 25px;">
        <h2 style="margin: 0; font-size: 20px;">
            🎮 <?php echo isset($data['editItem']) ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm đồ chơi mới'; ?>
        </h2>
    </div>

    <form 
        action="<?php echo isset($data['editItem']) 
            ? APP_URL . '/Product/edit/' . $data['editItem']['masp'] 
            : APP_URL . '/Product/create'; ?>" 
        method="post" 
        enctype="multipart/form-data"
        style="padding: 25px;"
    >
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            <!-- CỘT TRÁI -->
            <div>
                <!-- HÌNH ẢNH PREVIEW -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Hình ảnh sản phẩm</label>
                    <?php 
                    if (isset($data['editItem']) && $data['editItem']['hinhanh']) {
                        echo "<img src='" . APP_URL . "/public/Images/" . $data['editItem']['hinhanh'] . "' style='width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #eee; margin-bottom: 10px; display: block;'>";
                    } else { ?>
                        <div style="width: 150px; height: 150px; background: #f5f5f5; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 48px; margin-bottom: 10px;">🎮</div>
                    <?php } ?>
                    <input type="file" name="uploadfile" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <!-- MÃ SẢN PHẨM -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Mã sản phẩm <span style="color: #e31837;">*</span></label>
                    <input type="text" name="txt_masp" 
                        value="<?php echo isset($data['editItem']) ? $data['editItem']['masp'] : ''; ?>"
                        <?php echo isset($data['editItem']) ? 'readonly style="background: #f5f5f5;"' : ''; ?>
                        placeholder="VD: LEGO001, VTK4..."
                        style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                        required>
                </div>

                <!-- TÊN SẢN PHẨM -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Tên sản phẩm <span style="color: #e31837;">*</span></label>
                    <input type="text" name="txt_tensp" 
                        value="<?php echo isset($data['editItem']) ? htmlspecialchars($data['editItem']['tensp']) : ''; ?>"
                        placeholder="VD: Robot Biến Hình STRIKE VECTO"
                        style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                        required>
                </div>

                <!-- LOẠI SẢN PHẨM -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Loại sản phẩm <span style="color: #e31837;">*</span></label>
                    <select name="txt_maloaisp" style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" required>
                        <option value="">-- Chọn loại đồ chơi --</option>
                        <?php
                        foreach ($data["producttype"] as $v) {
                            $sel = isset($data['editItem']) && $data['editItem']['maLoaiSP'] == $v["maLoaiSP"] ? "selected" : "";
                            echo "<option value='{$v["maLoaiSP"]}' $sel>{$v["tenLoaiSP"]}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- CỘT PHẢI -->
            <div>
                <!-- ĐỘ TUỔI -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Độ tuổi phù hợp</label>
                    <select name="txt_dotuoi" style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                        <option value="">-- Chọn độ tuổi --</option>
                        <?php
                        $ages = ['0-2', '1+', '3+', '4+', '5+', '6+', '8+', '10+', '12+', '14+', '16+'];
                        foreach ($ages as $age) {
                            $sel = isset($data['editItem']) && ($data['editItem']['doTuoi'] ?? '') == $age ? "selected" : "";
                            echo "<option value='$age' $sel>$age tuổi</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- SỐ LƯỢNG -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Số lượng tồn kho</label>
                    <input type="number" name="txt_soluong" min="0"
                        value="<?php echo isset($data['editItem']) ? $data['editItem']['soluong'] : '0'; ?>"
                        style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>

                <!-- GIÁ NHẬP & GIÁ XUẤT -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Giá nhập (VNĐ) <span style="color: #e31837;">*</span></label>
                        <input type="number" name="txt_gianhap" min="0"
                            value="<?php echo isset($data['editItem']) ? ($data['editItem']['giaNhap'] ?? 0) : ''; ?>"
                            placeholder="0"
                            style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                            required>
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Giá bán (VNĐ) <span style="color: #e31837;">*</span></label>
                        <input type="number" name="txt_giaxuat" min="0"
                            value="<?php echo isset($data['editItem']) ? ($data['editItem']['giaXuat'] ?? 0) : ''; ?>"
                            placeholder="0"
                            style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                            required>
                    </div>
                </div>

                <!-- KHUYẾN MÃI -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                        🏷️ Chương trình khuyến mãi
                    </label>
                    <select name="txt_promotion_id" id="promotionSelect" onchange="updateDiscountPreview()" 
                        style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; background: #fff;">
                        <option value="">-- Không áp dụng khuyến mãi --</option>
                        <?php
                        $promotions = $data['promotions'] ?? [];
                        foreach ($promotions as $promo) {
                            $sel = isset($data['editItem']) && ($data['editItem']['promotion_id'] ?? '') == $promo['id'] ? "selected" : "";
                            $discountText = $promo['type'] == 'percent' ? "-{$promo['value']}%" : "-" . number_format($promo['value']) . "đ";
                            $promoName = $promo['name'] ?? $promo['code'];
                            echo "<option value='{$promo['id']}' data-type='{$promo['type']}' data-value='{$promo['value']}' $sel>";
                            echo "🎁 {$promoName} ({$discountText})";
                            echo "</option>";
                        }
                        ?>
                    </select>
                    <div id="discountPreview" style="margin-top: 10px; padding: 10px; background: #fff3cd; border-radius: 8px; display: none;">
                        <span style="color: #856404;">💰 Giá sau khuyến mãi: <strong id="discountedPrice">0</strong> đ</span>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function updateDiscountPreview() {
            const select = document.getElementById('promotionSelect');
            const preview = document.getElementById('discountPreview');
            const priceInput = document.querySelector('input[name="txt_giaxuat"]');
            const discountedPriceEl = document.getElementById('discountedPrice');
            
            const selectedOption = select.options[select.selectedIndex];
            const type = selectedOption.dataset.type;
            const value = parseFloat(selectedOption.dataset.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            
            if (select.value && price > 0) {
                let discountedPrice = price;
                if (type === 'percent') {
                    discountedPrice = price - (price * value / 100);
                } else {
                    discountedPrice = price - value;
                }
                discountedPrice = Math.max(0, discountedPrice);
                discountedPriceEl.textContent = discountedPrice.toLocaleString('vi-VN');
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        }
        
        // Update preview when price changes
        document.querySelector('input[name="txt_giaxuat"]').addEventListener('input', updateDiscountPreview);
        // Initial check
        updateDiscountPreview();
        </script>

        <!-- MÔ TẢ - FULL WIDTH -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Mô tả sản phẩm</label>
            <textarea name="txt_mota" rows="4" 
                placeholder="Nhập mô tả chi tiết về sản phẩm..."
                style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;"><?php echo isset($data['editItem']) ? htmlspecialchars($data['editItem']['mota'] ?? '') : ''; ?></textarea>
        </div>

        <!-- BUTTONS -->
        <div style="display: flex; gap: 15px; justify-content: flex-end; padding-top: 20px; border-top: 1px solid #eee;">
            <a href="<?php echo APP_URL; ?>/Product/" 
                style="padding: 12px 25px; background: #6c757d; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600;">
                ← Quay lại
            </a>
            <button type="submit" 
                style="padding: 12px 30px; background: <?php echo isset($data['editItem']) ? '#ffc107' : '#28a745'; ?>; color: <?php echo isset($data['editItem']) ? '#333' : '#fff'; ?>; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                <?php echo isset($data['editItem']) ? '✏️ Cập nhật' : '✅ Lưu sản phẩm'; ?>
            </button>
        </div>
    </form>
</div>
