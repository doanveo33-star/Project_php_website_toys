<?php
class Home extends Controller{
    
    /**
     * Live Search API - Tìm kiếm sản phẩm realtime
     */
    public function liveSearch() {
        header('Content-Type: application/json');
        
        $keyword = $_GET['q'] ?? '';
        $keyword = trim($keyword);
        
        if (strlen($keyword) < 2) {
            echo json_encode([]);
            exit();
        }
        
        $productModel = $this->model('AdProducModel');
        
        // Tìm kiếm trong tblsanpham với JOIN để lấy tên loại
        $sql = "SELECT p.masp, p.tensp, p.hinhanh, p.giaXuat, p.discount_percent, p.doTuoi, l.tenLoaiSP 
                FROM tblsanpham p 
                LEFT JOIN tblloaisp l ON p.maLoaiSP = l.maLoaiSP 
                WHERE p.tensp LIKE ? OR p.masp LIKE ? 
                ORDER BY p.tensp ASC 
                LIMIT 10";
        
        $searchTerm = '%' . $keyword . '%';
        $results = $productModel->select($sql, [$searchTerm, $searchTerm]);
        
        echo json_encode($results);
        exit();
    }
    
    /**
     * Trang kết quả tìm kiếm
     */
    public function search() {
        $keyword = $_GET['q'] ?? '';
        $keyword = trim($keyword);
        
        $productModel = $this->model('AdProducModel');
        
        $products = [];
        if ($keyword) {
            $sql = "SELECT * FROM tblsanpham WHERE tensp LIKE ? OR masp LIKE ? ORDER BY tensp ASC";
            $searchTerm = '%' . $keyword . '%';
            $products = $productModel->select($sql, [$searchTerm, $searchTerm]);
        }
        
        $this->view("Font_end/CategoryProductsView", [
            "category" => [
                'tenLoaiSP' => '🔍 Kết quả tìm kiếm: "' . htmlspecialchars($keyword) . '"',
                'moTaLoaiSP' => 'Tìm thấy ' . count($products) . ' sản phẩm'
            ],
            "categoryIcon" => '🔍',
            "products" => $products
        ]);
    }
    
        // Hiển thị lịch sử đơn hàng cho người dùng đã đăng nhập
    public function orderHistory() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/AuthController/ShowLogin');
            exit();
        }
        $orderModel = $this->model('OrderModel');
        $userId = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? null;
        $orders = [];
        if ($userId !== null) {
            $orders = $orderModel->getOrdersByUser($userId);
        }
        $this->view("Font_end/OrderHistoryView", ["orders" => $orders]);
    }
        // Lưu thông tin giao hàng, hóa đơn và chi tiết hóa đơn

   public function show()
{
    // Website Đồ Chơi - Lấy giá trực tiếp từ tblsanpham (không cần bảng size)
    $productModel = $this->model("AdProducModel");

    // Lấy danh mục đồ chơi (không bao gồm LEGO - LEGO có menu riêng)
    $categoryList = $productModel->getCategoryList();
    
    // Thêm icon cho từng loại
    $categoryIcons = [
        'Robot & Điều khiển' => '🤖',
        'Búp bê & Phụ kiện' => '👧',
        'Đồ chơi giáo dục' => '🧠',
        'Xe mô hình' => '🚗',
        'Đồ chơi ngoài trời' => '⚽',
        'Board Game' => '🎲',
        'Đồ chơi nhồi bông' => '🧸'
    ];
    
    $categories = [];
    foreach ($categoryList as $cat) {
        // Bỏ qua LEGO trong danh mục chung (LEGO có menu riêng)
        if (stripos($cat['tenLoaiSP'], 'LEGO') !== false) continue;
        
        $categories[] = [
            'maLoaiSP' => $cat['maLoaiSP'],
            'tenLoaiSP' => $cat['tenLoaiSP'],
            'icon' => $categoryIcons[$cat['tenLoaiSP']] ?? '🎮'
        ];
    }

    // Lấy tất cả sản phẩm (không phải LEGO) - giá đã có sẵn trong tblsanpham
    $allProducts = $productModel->select("SELECT * FROM tblsanpham WHERE maLoaiSP NOT LIKE '%LEGO%'");
    $products = [];
    
    foreach ($allProducts as $sp) {
        $products[] = [
            'masp' => $sp['masp'],
            'tensp' => $sp['tensp'],
            'hinhanh' => $sp['hinhanh'],
            'mota' => $sp['mota'] ?? '',
            'maLoaiSP' => $sp['maLoaiSP'],
            'gia_ban' => $sp['giaXuat'] ?? 0,
            'gia_khuyen_mai' => $sp['giaXuat'] ?? 0,
            'thuong_hieu' => $sp['thuongHieu'] ?? ''
        ];
    }

    // ========== LẤY DỮ LIỆU LEGO ==========
    // Lấy đối tượng LEGO (Bé Trai, Bé Gái, Mầm Non, Người Lớn)
    $legoDoituong = $productModel->select("SELECT * FROM tbl_lego_doituong ORDER BY id");
    
    // Lấy theme LEGO (City, Ninjago, Minecraft, etc.)
    $legoThemes = $productModel->select("SELECT * FROM tbl_lego_theme ORDER BY ten_theme");
    
    // Lấy sản phẩm LEGO nổi bật (6 sản phẩm mới nhất có khuyến mãi)
    $legoProducts = $productModel->select("SELECT * FROM tbl_lego_sanpham WHERE giaKhuyenMai IS NOT NULL ORDER BY createDate DESC LIMIT 6");
    
    // Nếu không đủ 6 sản phẩm khuyến mãi, lấy thêm sản phẩm khác
    if (count($legoProducts) < 6) {
        $remaining = 6 - count($legoProducts);
        $existingIds = array_column($legoProducts, 'masp');
        $excludeIds = !empty($existingIds) ? "'" . implode("','", $existingIds) . "'" : "''";
        $moreProducts = $productModel->select("SELECT * FROM tbl_lego_sanpham WHERE masp NOT IN ($excludeIds) ORDER BY createDate DESC LIMIT $remaining");
        $legoProducts = array_merge($legoProducts, $moreProducts);
    }
    
    // ========== LẤY LEGO CATEGORIES CHO MEGA MENU SẢN PHẨM ==========
    // Lấy các loại LEGO từ tblloaisp (LEGO1, LEGO2, LEGO3, LEGO4)
    $legoCategories = $productModel->select("SELECT * FROM tblloaisp WHERE maLoaiSP LIKE 'LEGO%' ORDER BY maLoaiSP");
    
    // Lấy sản phẩm LEGO theo từng loại để hiển thị khi hover
    $legoProductsByCategory = [];
    foreach ($legoCategories as $legoCat) {
        $legoProds = $productModel->select(
            "SELECT masp, tensp, hinhanh, giaXuat as gia_ban, maLoaiSP FROM tblsanpham WHERE maLoaiSP = ? ORDER BY createDate DESC LIMIT 6",
            [$legoCat['maLoaiSP']]
        );
        $legoProductsByCategory[$legoCat['maLoaiSP']] = $legoProds;
    }

    // ========== LẤY SẢN PHẨM ĐỘC QUYỀN ONLINE ==========
    $exclusiveProducts = $productModel->select(
        "SELECT * FROM tblsanpham WHERE maLoaiSP = 'ĐocQuyenOnline' ORDER BY createDate DESC"
    );
    
    // ========== LẤY DỮ LIỆU ĐỘ TUỔI ==========
    // Lấy danh sách độ tuổi có sản phẩm
    $ageGroups = $productModel->select(
        "SELECT DISTINCT doTuoi FROM tblsanpham WHERE doTuoi IS NOT NULL AND doTuoi != '' ORDER BY CAST(REPLACE(doTuoi, '+', '') AS UNSIGNED)"
    );
    
    // Lấy sản phẩm theo từng độ tuổi để hiển thị khi hover
    $productsByAge = [];
    foreach ($ageGroups as $age) {
        $ageValue = $age['doTuoi'];
        $ageProds = $productModel->select(
            "SELECT masp, tensp, hinhanh, giaXuat as gia_ban, doTuoi FROM tblsanpham WHERE doTuoi = ? ORDER BY createDate DESC LIMIT 6",
            [$ageValue]
        );
        $productsByAge[$ageValue] = $ageProds;
    }
    
    // ========== LẤY DỮ LIỆU KHUYẾN MÃI ==========
    $promoModel = $this->model('PromotionModel');
    $activePromotions = $promoModel->getAllActive();
    
    // Lấy sản phẩm theo từng khuyến mãi
    $productsByPromotion = [];
    foreach ($activePromotions as $promo) {
        $promoProds = $productModel->select(
            "SELECT masp, tensp, hinhanh, giaXuat as gia_ban, discount_percent FROM tblsanpham WHERE promotion_id = ? ORDER BY createDate DESC LIMIT 6",
            [$promo['id']]
        );
        $productsByPromotion[$promo['id']] = $promoProds;
    }
    
    // Lấy đánh giá (nếu có)
    $reviews = [];
    try {
        $reviewModel = $this->model('ReviewModel');
        $reviews = $reviewModel->getAllReviews('approved');
        $reviews = array_slice($reviews, 0, 8);
    } catch (Exception $e) {
        // Bỏ qua nếu chưa có bảng reviews
    }
    
    $this->view("homePage", [
        "categories" => $categories,
        "products" => $products,
        "reviews" => $reviews,
        // Dữ liệu LEGO cho mega menu riêng
        "legoDoituong" => $legoDoituong,
        "legoThemes" => $legoThemes,
        "legoProducts" => $legoProducts,
        // Dữ liệu LEGO categories cho mega menu SẢN PHẨM
        "legoCategories" => $legoCategories,
        "legoProductsByCategory" => $legoProductsByCategory,
        // Sản phẩm Độc Quyền Online
        "exclusiveProducts" => $exclusiveProducts,
        // Dữ liệu độ tuổi cho mega menu
        "ageGroups" => $ageGroups,
        "productsByAge" => $productsByAge,
        // Dữ liệu khuyến mãi cho mega menu
        "activePromotions" => $activePromotions,
        "productsByPromotion" => $productsByPromotion
    ]);
}

    /**
     * Trang sản phẩm theo độ tuổi
     */
    public function byAge($age) {
        $productModel = $this->model("AdProducModel");
        
        // Decode URL parameter
        $age = urldecode($age);
        
        // Thử tìm với nhiều format khác nhau
        $products = $productModel->select(
            "SELECT * FROM tblsanpham WHERE doTuoi = ? OR doTuoi = ? OR doTuoi LIKE ? ORDER BY createDate DESC",
            [$age, str_replace('+', '', $age), $age . '%']
        );
        
        // Nếu không tìm thấy, thử tìm theo số tuổi
        if (empty($products)) {
            $ageNum = preg_replace('/[^0-9]/', '', $age);
            if ($ageNum) {
                $products = $productModel->select(
                    "SELECT * FROM tblsanpham WHERE doTuoi LIKE ? ORDER BY createDate DESC",
                    ['%' . $ageNum . '%']
                );
            }
        }
        
        $this->view("Font_end/CategoryProductsView", [
            "category" => [
                'tenLoaiSP' => 'Đồ chơi cho bé từ ' . $age . ' tuổi',
                'moTaLoaiSP' => 'Các sản phẩm đồ chơi phù hợp với trẻ từ ' . $age . ' tuổi trở lên'
            ],
            "categoryIcon" => '👶',
            "products" => $products
        ]);
    }

    /**
     * Trang sản phẩm theo khuyến mãi
     */
    public function promotion($promoId = null) {
        $productModel = $this->model("AdProducModel");
        $promoModel = $this->model("PromotionModel");
        
        if ($promoId) {
            // Lấy thông tin khuyến mãi
            $promo = $promoModel->select("SELECT * FROM promotions WHERE id = ?", [$promoId]);
            $promo = $promo[0] ?? null;
            
            if (!$promo) {
                header('Location: ' . APP_URL . '/Home/allPromotions');
                exit();
            }
            
            // Lấy sản phẩm theo khuyến mãi
            $products = $productModel->select(
                "SELECT * FROM tblsanpham WHERE promotion_id = ? ORDER BY createDate DESC",
                [$promoId]
            );
            
            $discountText = $promo['type'] == 'percent' ? "-{$promo['value']}%" : "-" . number_format($promo['value']) . "đ";
            $promoName = $promo['name'] ?? $promo['code'];
            
            $this->view("Font_end/CategoryProductsView", [
                "category" => [
                    'tenLoaiSP' => '🏷️ ' . $promoName . ' (' . $discountText . ')',
                    'moTaLoaiSP' => 'Các sản phẩm đang được giảm giá trong chương trình ' . $promoName
                ],
                "categoryIcon" => '🎁',
                "products" => $products,
                "isPromotion" => true
            ]);
        } else {
            // Redirect to all promotions
            header('Location: ' . APP_URL . '/Home/allPromotions');
            exit();
        }
    }
    
    /**
     * Trang tất cả khuyến mãi
     */
    public function allPromotions() {
        $productModel = $this->model("AdProducModel");
        $promoModel = $this->model("PromotionModel");
        
        // Lấy tất cả khuyến mãi đang hoạt động
        $promotions = $promoModel->getAllActive();
        
        // Lấy tất cả sản phẩm có khuyến mãi
        $products = $productModel->select(
            "SELECT * FROM tblsanpham WHERE promotion_id IS NOT NULL AND discount_percent IS NOT NULL ORDER BY discount_percent DESC, createDate DESC"
        );
        
        $this->view("Font_end/CategoryProductsView", [
            "category" => [
                'tenLoaiSP' => '🔥 Tất cả sản phẩm khuyến mãi',
                'moTaLoaiSP' => 'Tổng hợp tất cả sản phẩm đang được giảm giá'
            ],
            "categoryIcon" => '🏷️',
            "products" => $products,
            "promotions" => $promotions,
            "isPromotion" => true
        ]);
    }

    /**
     * Trang Hàng Mới - Hiển thị sản phẩm mới nhất
     */
    public function newArrivals() {
        $productModel = $this->model("AdProducModel");
        
        // Lấy sản phẩm từ loại "SanPhamMoi" (Hàng Mới)
        $products = $productModel->select(
            "SELECT * FROM tblsanpham WHERE maLoaiSP = 'SanPhamMoi' ORDER BY createDate DESC"
        );
        
        $this->view("Font_end/NewArrivalsView", [
            "products" => $products
        ]);
    }
    
    /**
     * Trang Độc Quyền Online
     */
    public function exclusive() {
        $productModel = $this->model("AdProducModel");
        
        // Lấy sản phẩm từ loại "ĐocQuyenOnline"
        $products = $productModel->select(
            "SELECT * FROM tblsanpham WHERE maLoaiSP = 'ĐocQuyenOnline' ORDER BY createDate DESC"
        );
        
        $this->view("Font_end/CategoryProductsView", [
            "category" => [
                'tenLoaiSP' => 'Độc Quyền Online',
                'moTaLoaiSP' => 'Sản phẩm độc quyền chỉ có khi mua Online'
            ],
            "categoryIcon" => '🌟',
            "products" => $products
        ]);
    }
    
    /**
     * Toggle sản phẩm yêu thích (AJAX)
     */
    public function toggleFavorite() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        $masp = $_POST['masp'] ?? null;
        if (!$masp) {
            echo json_encode(['success' => false, 'message' => 'Thiếu mã sản phẩm']);
            exit();
        }
        
        // Khởi tạo favorites nếu chưa có
        if (!isset($_SESSION['favorites'])) {
            $_SESSION['favorites'] = [];
        }
        
        $isFavorite = false;
        
        // Toggle: nếu đã có thì xóa, chưa có thì thêm
        if (in_array($masp, $_SESSION['favorites'])) {
            $_SESSION['favorites'] = array_diff($_SESSION['favorites'], [$masp]);
            $isFavorite = false;
        } else {
            $_SESSION['favorites'][] = $masp;
            $isFavorite = true;
        }
        
        echo json_encode([
            'success' => true,
            'isFavorite' => $isFavorite,
            'totalFavorites' => count($_SESSION['favorites'])
        ]);
        exit();
    }
    
    /**
     * Trang sản phẩm yêu thích
     */
    public function favorites() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $productModel = $this->model("AdProducModel");
        $products = [];
        
        if (!empty($_SESSION['favorites'])) {
            $favoriteIds = $_SESSION['favorites'];
            $placeholders = implode(',', array_fill(0, count($favoriteIds), '?'));
            $products = $productModel->select(
                "SELECT * FROM tblsanpham WHERE masp IN ($placeholders)",
                $favoriteIds
            );
        }
        
        $this->view("Font_end/FavoritesView", [
            "products" => $products
        ]);
    }

    public function orderDetail($orderId)
{
    // Chưa đăng nhập thì đá về login
    if (!isset($_SESSION['user'])) {
        header('Location: ' . APP_URL . '/AuthController/ShowLogin');
        exit();
    }

    $orderModel = $this->model("OrderModel");
    $orderDetailModel = $this->model("OrderDetailModel");

    // ✅ LẤY THÔNG TIN ĐƠN HÀNG
    $order = $orderModel->getOrderById($orderId);

    if (!$order) {
        die("Đơn hàng không tồn tại");
    }

    // ✅ CHỈ CHO XEM ĐƠN CỦA CHÍNH MÌNH (check cả user_id và user_email)
    $userId = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? null;
    $userEmail = $_SESSION['user']['email'] ?? '';
    
    $orderUserId = $order['user_id'] ?? null;
    $orderUserEmail = $order['user_email'] ?? '';
    
    // Cho phép xem nếu trùng user_id HOẶC trùng email
    $canView = ($userId && $orderUserId && $userId == $orderUserId) || 
               ($userEmail && $orderUserEmail && $userEmail === $orderUserEmail);
    
    if (!$canView) {
        die("Bạn không có quyền xem đơn hàng này");
    }

    // ✅ CHI TIẾT ĐƠN HÀNG
    $details = $orderDetailModel->getByOrderId($orderId);

    // ✅ LOAD VIEW RIÊNG
    $this->view("Font_end/OrderDetailView", [
        "orderId" => $orderId,
        "order"   => $order,
        "details" => $details
    ]);
}

 
    public function addtocard($masp) {
    $size = $_GET['size'] ?? '';

    if ($size == '') die("Chưa chọn size bánh");

    $model = $this->model("AdProducModel");

    $row = $model->select(
        "SELECT giaXuat FROM tbl_sanpham_size WHERE masp=? AND size=? LIMIT 1",
        [$masp, $size]
    );

    $price = $row[0]['giaXuat'];

    if (!isset($_SESSION['cart'][$masp][$size])) {
        $_SESSION['cart'][$masp][$size] = [
            'masp' => $masp,
            'size' => $size,
            'price' => $price,
            'qty' => 1
        ];
    } else {
        $_SESSION['cart'][$masp][$size]['qty']++;
    }

    header("Location: " . APP_URL . "/Home/order");
    exit();
}


public function addToCartAjax($masp) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $size = $_GET['size'] ?? '';

    if ($size == '') {
        echo json_encode(['success' => false]);
        exit();
    }

    if (!isset($_SESSION['cart'][$masp][$size])) {
        $_SESSION['cart'][$masp][$size] = [
            'masp' => $masp,
            'size' => $size,
            'qty'  => 1
        ];
    } else {
        $_SESSION['cart'][$masp][$size]['qty']++;
    }

    $totalQty = 0;
    foreach ($_SESSION['cart'] as $sizes) {
        foreach ($sizes as $item) {
            $totalQty += $item['qty'];
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'totalQty' => $totalQty
    ]);
    exit();
}

/**
 * Thêm sản phẩm đồ chơi vào giỏ hàng (không cần size)
 */
public function addToCart() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    header('Content-Type: application/json');
    
    $masp = $_POST['masp'] ?? null;
    $qty = (int)($_POST['qty'] ?? 1);
    
    if (!$masp) {
        echo json_encode(['success' => false, 'message' => 'Thiếu mã sản phẩm']);
        exit();
    }
    
    // Lấy thông tin sản phẩm từ DB - dùng AdProducModel
    $productModel = $this->model('AdProducModel');
    $product = $productModel->find('tblsanpham', $masp);
    
    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
        exit();
    }
    
    // Tính giá sau khuyến mãi
    $giaGoc = $product['giaXuat'] ?? 0;
    $discountPercent = $product['discount_percent'] ?? 0;
    $giaSauGiam = $discountPercent > 0 ? round($giaGoc * (100 - $discountPercent) / 100) : $giaGoc;
    
    // Khởi tạo cart nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Thêm hoặc cập nhật số lượng
    if (isset($_SESSION['cart'][$masp]) && isset($_SESSION['cart'][$masp]['qty'])) {
        $_SESSION['cart'][$masp]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$masp] = [
            'masp' => $masp,
            'tensp' => $product['tensp'],
            'hinhanh' => $product['hinhanh'],
            'giaXuat' => $giaSauGiam, // Lưu giá sau giảm
            'giaGoc' => $giaGoc, // Lưu giá gốc để hiển thị
            'discount_percent' => $discountPercent,
            'qty' => $qty
        ];
    }
    
    // Tính tổng số lượng
    $totalQty = 0;
    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item) && isset($item['qty'])) {
            $totalQty += $item['qty'];
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Đã thêm vào giỏ hàng',
        'totalQty' => $totalQty
    ]);
    exit();
}

/**
 * Quick Buy - Thêm sản phẩm vào giỏ và chuyển đến trang đặt hàng
 */
public function quickBuy($masp) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Lấy thông tin sản phẩm từ DB
    $productModel = $this->model('AdProducModel');
    $product = $productModel->find('tblsanpham', $masp);
    
    if (!$product) {
        header('Location: ' . APP_URL . '/Home/');
        exit();
    }
    
    // Tính giá sau khuyến mãi
    $giaGoc = $product['giaXuat'] ?? 0;
    $discountPercent = $product['discount_percent'] ?? 0;
    $giaSauGiam = $discountPercent > 0 ? round($giaGoc * (100 - $discountPercent) / 100) : $giaGoc;
    
    // Khởi tạo cart nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Thêm sản phẩm vào giỏ (hoặc tăng số lượng nếu đã có)
    if (isset($_SESSION['cart'][$masp]) && isset($_SESSION['cart'][$masp]['qty'])) {
        $_SESSION['cart'][$masp]['qty'] += 1;
    } else {
        $_SESSION['cart'][$masp] = [
            'masp' => $masp,
            'tensp' => $product['tensp'],
            'hinhanh' => $product['hinhanh'],
            'giaXuat' => $giaSauGiam, // Lưu giá sau giảm
            'giaGoc' => $giaGoc,
            'discount_percent' => $discountPercent,
            'qty' => 1
        ];
    }
    
    // Chuyển đến trang đặt hàng
    header('Location: ' . APP_URL . '/Home/order');
    exit();
}



    public function delete($masp, $size = '')
{
    // Cấu trúc mới (đồ chơi không có size)
    if (isset($_SESSION['cart'][$masp]) && isset($_SESSION['cart'][$masp]['qty'])) {
        unset($_SESSION['cart'][$masp]);
    }
    // Cấu trúc cũ (có size)
    elseif ($size && isset($_SESSION['cart'][$masp][$size])) {
        unset($_SESSION['cart'][$masp][$size]);
        if (empty($_SESSION['cart'][$masp])) {
            unset($_SESSION['cart'][$masp]);
        }
    }
    // Fallback: xóa theo masp
    elseif (isset($_SESSION['cart'][$masp])) {
        unset($_SESSION['cart'][$masp]);
    }

    header("Location: " . APP_URL . "/Home/order");
    exit();
}


    public function update()
{
    if (isset($_POST['qty'])) {
        foreach ($_POST['qty'] as $masp => $sizes) {
            foreach ($sizes as $size => $qty) {
                // Cấu trúc mới (đồ chơi không có size) - size = 'default' hoặc ''
                if (($size === 'default' || $size === '') && isset($_SESSION['cart'][$masp]) && isset($_SESSION['cart'][$masp]['qty'])) {
                    $_SESSION['cart'][$masp]['qty'] = max(1, (int)$qty);
                }
                // Cấu trúc cũ (có size)
                elseif (isset($_SESSION['cart'][$masp][$size])) {
                    $_SESSION['cart'][$masp][$size]['qty'] = max(1, (int)$qty);
                }
            }
        }
    }

    if (isset($_POST['addon_qty'])) {
        foreach ($_POST['addon_qty'] as $masp => $qty) {
            $key = 'addon_' . (int)$masp;

            if (isset($_SESSION['cart'][$key])) {
                $_SESSION['cart'][$key]['qty'] = max(1, (int)$qty);
            }
        }
    }

    header("Location: " . APP_URL . "/Home/order");
}


private function getPhuKienForOrder()
{
    $model = $this->model("AdProducModel");

    // Lấy danh sách phụ kiện (dùng đúng giá trị maLoaiSP như trong DB: "Phụ kiện")
    $rows = $model->select(
        "SELECT * FROM tblsanpham WHERE maLoaiSP = ? ORDER BY masp DESC",
        ['Phụ kiện']
    );

    // Nếu bảng size có giá, lấy giá nhỏ nhất từ tbl_sanpham_size
    foreach ($rows as &$r) {
        // ưu tiên trường 'gia' nếu có
        if (!empty($r['gia'])) {
            $r['display_price'] = (float)$r['gia'];
            continue;
        }

        // cố gắng lấy giá từ tbl_sanpham_size (min giaXuat)
        $sizes = $model->select(
            "SELECT MIN(giaXuat) AS minPrice FROM tbl_sanpham_size WHERE masp = ?",
            [$r['masp']]
        );

        $minPrice = 0;
        if (!empty($sizes) && isset($sizes[0]['minPrice'])) {
            $minPrice = (float)$sizes[0]['minPrice'];
        }

        $r['display_price'] = $minPrice;
    }
    unset($r);

    return $rows;
}



    public function order()
{
    // nếu cart rỗng -> render view trống (hoặc redirect)
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $this->view("Font_end/OrderView", [
            "listProductOrder" => [],
            "phuKien" => $this->getPhuKienForOrder()
        ]);
        return;
    }

    $model = $this->model("AdProducModel");
    $listProductOrder = [];

    foreach ($_SESSION['cart'] as $key => $value) {

        // 1) Nếu key là chuỗi bắt đầu bằng 'addon_' -> là phụ kiện
        if (is_string($key) && str_starts_with($key, 'addon_')) {
            $masp    = $value['masp'] ?? null;
            $tensp   = $value['tensp'] ?? ($masp ? ($model->find('tblsanpham', $masp)['tensp'] ?? '') : '');
            $hinhanh = $value['hinhanh'] ?? ($masp ? ($model->find('tblsanpham', $masp)['hinhanh'] ?? '') : '');
            $gia     = isset($value['gia']) ? (float)$value['gia'] : (float)($value['giaXuat'] ?? 0);
            $qty     = isset($value['qty']) ? (int)$value['qty'] : 1;

            $listProductOrder[] = [
                'masp'      => $masp,
                'tensp'     => $tensp,
                'hinhanh'   => $hinhanh,
                'size'      => 'addon',
                'gia'       => $gia,
                'qty'       => $qty,
                'thanhtien' => $gia * $qty,
                'type'      => 'addon'
            ];
            continue;
        }

        // 2) Đồ chơi (không có size) - cấu trúc mới: $_SESSION['cart'][$masp] = ['masp'=>..., 'tensp'=>..., 'qty'=>...]
        if (is_array($value) && isset($value['masp']) && isset($value['qty'])) {
            $masp = $value['masp'];
            $sp = $model->find("tblsanpham", $masp);
            $tensp = $value['tensp'] ?? ($sp['tensp'] ?? '');
            $hinhanh = $value['hinhanh'] ?? ($sp['hinhanh'] ?? '');
            $price = isset($value['giaXuat']) ? (float)$value['giaXuat'] : (float)($sp['giaXuat'] ?? 0);
            $qty = (int)$value['qty'];

            $listProductOrder[] = [
                'masp'      => $masp,
                'tensp'     => $tensp,
                'hinhanh'   => $hinhanh,
                'size'      => '',
                'gia'       => $price,
                'qty'       => $qty,
                'thanhtien' => $price * $qty,
                'type'      => 'product'
            ];
            continue;
        }

        // 3) Cấu trúc cũ (có size): $value = [ size => [...], size2 => [...] ]
        if (is_array($value)) {
            foreach ($value as $size => $item) {
                if (!is_array($item)) continue;

                $masp = $item['masp'] ?? $key;
                $sp = $model->find("tblsanpham", $masp);
                $tensp = $item['tensp'] ?? ($sp['tensp'] ?? '');
                $hinhanh = $item['hinhanh'] ?? ($sp['hinhanh'] ?? '');

                if (isset($item['price'])) {
                    $price = (float)$item['price'];
                } elseif (isset($item['giaXuat'])) {
                    $price = (float)$item['giaXuat'];
                } else {
                    $row = $model->select(
                        "SELECT giaXuat FROM tbl_sanpham_size WHERE masp=? AND size=? LIMIT 1",
                        [$masp, $size]
                    );
                    $price = !empty($row) && isset($row[0]['giaXuat']) ? (float)$row[0]['giaXuat'] : (float)($sp['giaXuat'] ?? 0);
                }

                $qty = isset($item['qty']) ? (int)$item['qty'] : 1;

                $listProductOrder[] = [
                    'masp'      => $masp,
                    'tensp'     => $tensp,
                    'hinhanh'   => $hinhanh,
                    'size'      => $size,
                    'gia'       => $price,
                    'qty'       => $qty,
                    'thanhtien' => $price * $qty,
                    'type'      => 'product'
                ];
            }
        }
    }

    $phuKien = $this->getPhuKienForOrder();
    
    // Lấy sản phẩm liên quan dựa trên loại sản phẩm trong giỏ hàng
    $relatedProducts = [];
    $cartCategories = [];
    $cartMasp = [];
    
    // Thu thập các loại sản phẩm và mã sản phẩm trong giỏ
    foreach ($listProductOrder as $item) {
        if (!empty($item['masp'])) {
            $cartMasp[] = $item['masp'];
            $sp = $model->find("tblsanpham", $item['masp']);
            if ($sp && !empty($sp['maLoaiSP'])) {
                $cartCategories[$sp['maLoaiSP']] = true;
            }
        }
    }
    
    // Lấy sản phẩm cùng loại (không trùng với sản phẩm trong giỏ)
    if (!empty($cartCategories)) {
        $categoryList = array_keys($cartCategories);
        $placeholders = implode(',', array_fill(0, count($categoryList), '?'));
        
        // Loại trừ sản phẩm đã có trong giỏ
        $excludeMasp = !empty($cartMasp) ? implode(',', array_fill(0, count($cartMasp), '?')) : "''";
        
        $sql = "SELECT * FROM tblsanpham WHERE maLoaiSP IN ($placeholders)";
        $params = $categoryList;
        
        if (!empty($cartMasp)) {
            $sql .= " AND masp NOT IN ($excludeMasp)";
            $params = array_merge($params, $cartMasp);
        }
        
        $sql .= " ORDER BY RAND() LIMIT 8";
        
        $relatedProducts = $model->select($sql, $params);
    }
    
    // Nếu không có sản phẩm liên quan, lấy sản phẩm ngẫu nhiên
    if (empty($relatedProducts)) {
        $excludeMasp = !empty($cartMasp) ? implode(',', array_fill(0, count($cartMasp), '?')) : "''";
        $sql = "SELECT * FROM tblsanpham";
        $params = [];
        
        if (!empty($cartMasp)) {
            $sql .= " WHERE masp NOT IN ($excludeMasp)";
            $params = $cartMasp;
        }
        
        $sql .= " ORDER BY RAND() LIMIT 8";
        $relatedProducts = $model->select($sql, $params);
    }

    $this->view("Font_end/OrderView", [
        "listProductOrder" => $listProductOrder,
        "phuKien" => $phuKien,
        "relatedProducts" => $relatedProducts
    ]);
}

public function addAddon()
{
    if (!isset($_POST['masp'])) {
        echo 'missing masp';
        return;
    }

    $masp = (int)$_POST['masp'];
    $model = $this->model('AdProducModel');

    $p = $model->getAddonPrice($masp);
    if (!$p) {
        echo 'addon not found';
        return;
    }

    $key = 'addon_' . $masp;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ✅ nếu đã có → tăng
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['qty']++;
    } else {
        $_SESSION['cart'][$key] = [
            'masp'    => $masp,
            'tensp'   => $p['tensp'],
            'hinhanh' => $p['hinhanh'],
            'gia'     => (int)$p['giaXuat'], // ✅ GIÁ ĐÚNG
            'qty'     => 1,
            'type'    => 'addon'
        ];
    }

    echo 'ok';
}



public function updateAddon()
{
    if (!isset($_POST['addon_qty'])) return;

    foreach ($_POST['addon_qty'] as $masp => $qty) {
        $key = 'addon_' . (int)$masp;

        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['qty'] = max(1, (int)$qty);
        }
    }

    header("Location: " . APP_URL . "/Home/order");
}

public function removeAddon($masp)
{
    $key = 'addon_' . (int)$masp;

    unset($_SESSION['cart'][$key]);

    header("Location: " . APP_URL . "/Home/order");
}


    public function checkout() {

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        header("Location: " . APP_URL . "/Home/order");
        exit();
    }

    if (!isset($_SESSION['user'])) {
        header("Location: " . APP_URL . "/AuthController/ShowLogin");
        exit();
    }

    $cartSession = $_SESSION['cart'];
    $productModel = $this->model("ProductModel");

    $cart = [];
    $total = 0;

    foreach ($cartSession as $item) {

        // LẤY LẠI GIÁ & TÊN TỪ DB
        $product = $productModel->getById($item['masp']);

        if (!$product) continue;

        $price = (float)$product['gia'];
        $qty   = (int)$item['qty'];
        $lineTotal = $price * $qty;

        $total += $lineTotal;

        $cart[] = [
            'masp'  => $item['masp'],
            'tensp'=> $product['tensp'],
            'gia'   => $price,
            'qty'   => $qty
        ];
    }

    $promotionModel = $this->model("PromotionModel");
        $this->view("homePage", [
        "page" => "CheckoutInfoView",
        "listProductOrder" => $cart,
        "total" => $total
    ]);
}


    public function checkoutSave() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/AuthController/Show');
            exit();
        }
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (empty($cart)) {
            $this->view("homePage", [
                "page" => "OrderView",
                "listProductOrder" => [],
                "success" => "Giỏ hàng trống!"
            ]);
            return;
        }
        $receiver = isset($_POST['receiver']) ? trim($_POST['receiver']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        if ($receiver === '' || $phone === '' || $address === '') {
            echo '<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin giao hàng!</div>';
            $this->view("homePage", ["page" => "CheckoutInfoView"]);
            return;
        }
        
        $orderModel = $this->model("OrderModel");
        $promotionModel = $this->model("PromotionModel");
        $orderDetailModel = $this->model("OrderDetailModel");
        $productModel = $this->model("AdProducModel");
        
        $user = $_SESSION['user'];
        $orderCode = 'HD' . time();
        $transaction_info = "chothanhtoan";
        $created_at = date('Y-m-d H:i:s');
        
        // Tính tổng tiền từ giỏ hàng (cấu trúc mới)
        $totalAmount = 0;
        $cartItems = [];
        foreach ($cart as $key => $item) {
            if (!is_array($item) || !isset($item['masp'])) continue;
            
            $giaXuat = $item['giaXuat'] ?? 0;
            $qty = $item['qty'] ?? 1;
            $thanhtien = $giaXuat * $qty;
            $totalAmount += $thanhtien;
            
            $cartItems[] = [
                'masp' => $item['masp'],
                'tensp' => $item['tensp'] ?? '',
                'hinhanh' => $item['hinhanh'] ?? '',
                'giaXuat' => $giaXuat,
                'qty' => $qty,
                'thanhtien' => $thanhtien
            ];
        }
        
        // Check for coupon code
        $coupon_code = isset($_POST['coupon_code']) ? trim($_POST['coupon_code']) : null;
        $discount_amount = 0;
        if ($coupon_code) {
            $validation = $promotionModel->validateCode($coupon_code, $totalAmount);
            if (!$validation['success']) {
                $this->view("homePage", ["page" => "CheckoutInfoView", 'coupon_message' => $validation['message']]);
                return;
            }
            $discount_amount = $validation['discount_amount'];
        }
        
        // Lưu đơn hàng
        $orderId = $orderModel->createOrderWithShipping($orderCode, $totalAmount, $user['email'], $receiver, $phone, $address, $created_at, $transaction_info, $coupon_code, $discount_amount);
        
        // Lưu chi tiết đơn hàng
        foreach ($cartItems as $item) {
            $orderDetailModel->addOrderDetail(
                $orderId,
                $item['masp'],
                $item['qty'],
                $item['giaXuat'],
                $item['giaXuat'],
                $item['thanhtien'],
                $item['hinhanh'],
                $item['tensp']
            );
        }
        
        $_SESSION['orderCode'] = $orderCode;
        $_SESSION['totalAmount'] = $totalAmount - $discount_amount;
        
        $payment_method = $_POST['payment_method'] ?? 'cod';
        
        if ($payment_method == 'vnpay') {
            header('Location: ' . APP_URL . '/vnpay_php/vnpay_pay.php');
            exit();
        } else {
            // COD - Giảm tồn kho ngay
            foreach ($cartItems as $item) {
                $productModel->query(
                    "UPDATE tblsanpham SET soluong = GREATEST(0, soluong - ?) WHERE masp = ?",
                    [$item['qty'], $item['masp']]
                );
            }
            
            // Xóa giỏ hàng
            $_SESSION['cart'] = [];
            
            $this->view("Font_end/OrderSuccessView", [
                "orderCode" => $orderCode,
                "totalAmount" => $totalAmount - $discount_amount
            ]);
        }
    }  

        // Xử lý khi VNPAY redirect về
        public function vnpayReturn() {
            // Lấy tất cả params VNPAY trả về
            $data = $_GET;
            //$vnp_HashSecret = defined('VNP_HASH_SECRET') ? VNP_HASH_SECRET : '';
            $vnp_HashSecret = "QK4ZU6CQVZ4BLPP9ZJMDJFY9I59F9TXK";
            if (isset($data['vnp_SecureHash'])) {
                $secureHash = $data['vnp_SecureHash'];
                unset($data['vnp_SecureHash']);
                unset($data['vnp_SecureHashType']);
                ksort($data);
                $hashData = '';
                foreach ($data as $key => $value) {
                    if (($key !== 'vnp_SecureHash') && ($key !== 'vnp_SecureHashType')) {
                        $hashData .= $key . '=' . $value . '&';
                    }
                }
                $hashData = rtrim($hashData, '&');
                $calculatedHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

                if ($calculatedHash === $secureHash) {
                    // signature ok -> kiểm tra mã trả về
                    $vnp_ResponseCode = isset($_GET['vnp_ResponseCode']) ? $_GET['vnp_ResponseCode'] : '';
                    $vnp_TxnRef = isset($_GET['vnp_TxnRef']) ? $_GET['vnp_TxnRef'] : '';

                    if ($vnp_ResponseCode === '00') {
                        // Thanh toán thành công
                        // Update received amount and status
                        $paidAmount = isset($_GET['vnp_Amount']) ? ($_GET['vnp_Amount'] / 100) : 0;
                        $orderModel = new OrderModel();
                        $orderModel->updateReceivedAmountAndStatus($vnp_TxnRef, $paidAmount);

                        // If order had a coupon_code, increment promotion usage
                        $order = $orderModel->select("SELECT * FROM orders WHERE order_code = ?", [$vnp_TxnRef]);
                        if (!empty($order) && !empty($order[0]['coupon_code'])) {
                            $promoModel = $this->model('PromotionModel');
                            $promo = $promoModel->getByCode($order[0]['coupon_code']);
                            if ($promo && !empty($promo['id'])) {
                                $promoModel->incrementUsage($promo['id']);
                            }
                        }

                        $message = "Thanh toán VNPAY thành công. Mã đơn: $vnp_TxnRef";
                    } else {
                        $message = "Thanh toán VNPAY không thành công. Mã trả về: " . htmlspecialchars($vnp_ResponseCode);
                    }
                } else {
                    $message = 'Chu ky khong hop le.';
                }
            } else {
                $message = 'Tham so chua duoc truyen.';
            }

            $this->view("Font_end/OrderView", [
            "listProductOrder" => [],
            "success" => $message
        ]);

        }

        // Hiển thị form nhập thông tin giao hàng sau khi đăng ký hoặc đăng nhập
        public function checkoutInfo()
{
    if (!isset($_SESSION['user'])) {
        header('Location: ' . APP_URL . '/AuthController/ShowLogin');
        exit();
    }

    if (empty($_SESSION['cart'])) {
        header("Location: " . APP_URL . "/Home/order");
        exit();
    }

    $model = $this->model("AdProducModel"); // kiểm tra tên model đúng với file bạn có
    $listProductOrder = [];
    $total = 0;

    foreach ($_SESSION['cart'] as $k => $entry) {

        // nếu entry không phải mảng => skip
        if (!is_array($entry)) continue;

        // --------- CASE A: entry là 1 item (associative item with 'masp' or 'size') ----------
        // ví dụ: $_SESSION['cart'][] = ['masp'=>..., 'size'=>..., 'price'=>..., 'qty'=>...]
        if (isset($entry['masp']) || isset($entry['size'])) {
            $masp = $entry['masp'] ?? ($entry['product_id'] ?? $k);
            $size = $entry['size'] ?? ($entry['size_name'] ?? '');
            $price = $this->getPriceFromItemOrDb($model, $masp, $size, $entry);
            $qty = isset($entry['qty']) ? (int)$entry['qty'] : 1;
            $thanhTien = $price * $qty;
            $total += $thanhTien;

            $listProductOrder[] = [
                'masp'     => $masp,
                'tensp'    => $entry['tensp'] ?? ($model->find('tblsanpham', $masp)['tensp'] ?? ''),
                'hinhanh'  => $entry['hinhanh'] ?? ($model->find('tblsanpham', $masp)['hinhanh'] ?? ''),
                'size'     => $size,
                'gia'      => $price,
                'qty'      => $qty,
                'thanhtien'=> $thanhTien
            ];
            continue;
        }

        // --------- CASE B: entry là nhóm sizes cho 1 masp ----------
        // ví dụ: $_SESSION['cart'][$masp] = [ '13x6cm' => item, '17x7.5cm' => item, ... ]
        foreach ($entry as $maybeSize => $maybeItem) {
            if (!is_array($maybeItem)) continue;

            $masp = $maybeItem['masp'] ?? $k; // fallback: key $k là masp
            $size = $maybeItem['size'] ?? $maybeSize;
            $price = $this->getPriceFromItemOrDb($model, $masp, $size, $maybeItem);
            $qty = isset($maybeItem['qty']) ? (int)$maybeItem['qty'] : 1;
            $thanhTien = $price * $qty;
            $total += $thanhTien;

            $listProductOrder[] = [
                'masp'     => $masp,
                'tensp'    => $maybeItem['tensp'] ?? ($model->find('tblsanpham', $masp)['tensp'] ?? ''),
                'hinhanh'  => $maybeItem['hinhanh'] ?? ($model->find('tblsanpham', $masp)['hinhanh'] ?? ''),
                'size'     => $size,
                'gia'      => $price,
                'qty'      => $qty,
                'thanhtien'=> $thanhTien
            ];
        }
    }

    // Trả về view CheckoutInfoView
    $this->view("Font_end/CheckoutInfoView", [
        "listProductOrder" => $listProductOrder,
        "total" => $total
    ]);
}


/**
 * Helper: lấy giá (ưu tiên từ item), nếu không có -> query DB theo masp+size
 */
private function getPriceFromItemOrDb($productModel, $masp, $size, $item)
{
    // Kiểm tra các key thường gặp
    if (!empty($item['price'])) return (float)$item['price'];
    if (!empty($item['gia'])) return (float)$item['gia'];
    if (!empty($item['giaXuat'])) return (float)$item['giaXuat'];
    if (!empty($item['giaxuat'])) return (float)$item['giaxuat'];

    // Nếu không có giá trong session -> lấy từ bảng size (nếu có size)
    if (!empty($size) && $size !== 'default' && $size !== '') {
        $r = $productModel->select("SELECT giaXuat FROM tbl_sanpham_size WHERE masp=? AND size=? LIMIT 1", [$masp, $size]);
        if (!empty($r) && isset($r[0]['giaXuat'])) return (float)$r[0]['giaXuat'];
    }

    // Fallback: lấy giá từ tblsanpham (đồ chơi không có size)
    $sp = $productModel->find("tblsanpham", $masp);
    if (!empty($sp)) {
        if (isset($sp['giaXuat'])) return (float)$sp['giaXuat'];
        if (isset($sp['gia'])) return (float)$sp['gia'];
    }

    return 0.0;
}

/**
 * Helper: kiểm tra xem mảng có phải associative hay là list numeric-index
 */
private function is_assoc(array $arr)
{
    if ([] === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}



        public function vnpayPay() {
            if (!isset($_POST['order_code']) || !isset($_POST['amount'])) {
                header('Location: ' . APP_URL . '/Home');
                exit();
            }

            $orderCode = $_POST['order_code'];
            $amount = $_POST['amount'];

            // Store in session for vnpay processing
            $_SESSION['orderCode'] = $orderCode;
            $_SESSION['totalAmount'] = $amount;

            // Redirect to VNPAY payment page
            header('Location: ' . APP_URL . '/vnpay_php/vnpay_pay.php');
            exit();
        }
    public function index() {
    $this->show();
}

    // ================= TRANG DANH MỤC SẢN PHẨM =================
    
    /**
     * Hiển thị sản phẩm theo danh mục
     */
    public function category($maLoaiSP) {
        $productModel = $this->model("AdProducModel");
        
        // Lấy thông tin danh mục
        $categoryData = $productModel->select("SELECT * FROM tblloaisp WHERE maLoaiSP = ?", [$maLoaiSP]);
        $category = $categoryData[0] ?? null;
        
        if (!$category) {
            header('Location: ' . APP_URL . '/Home');
            exit();
        }
        
        // Lấy sản phẩm thuộc danh mục này
        $products = $productModel->select(
            "SELECT * FROM tblsanpham WHERE maLoaiSP = ? ORDER BY createDate DESC",
            [$maLoaiSP]
        );
        
        // Icon cho danh mục
        $categoryIcons = [
            'Robot' => '🤖',
            'BupBe' => '👧',
            'GiaoDuc' => '🧠',
            'XeMoHinh' => '🚗',
            'NgoaiTroi' => '⚽',
            'BoardGame' => '🎲',
            'NhoiBong' => '🧸',
            // LEGO categories
            'LEGO1' => '👦',  // Bé Trai
            'LEGO2' => '👧',  // Bé Gái
            'LEGO3' => '👶',  // Bé Mầm Non
            'LEGO4' => '🧑'   // Người Lớn
        ];
        
        $this->view("Font_end/CategoryProductsView", [
            "category" => $category,
            "categoryIcon" => $categoryIcons[$maLoaiSP] ?? '🧱',
            "products" => $products
        ]);
    }

    // ================= LEGO PAGES =================
    
    /**
     * Hiển thị sản phẩm LEGO theo đối tượng (Bé Trai, Bé Gái, Mầm Non, Người Lớn)
     */
    public function legoByAudience($maDoituong) {
        $productModel = $this->model("AdProducModel");
        
        // Lấy thông tin đối tượng
        $doituong = $productModel->select("SELECT * FROM tbl_lego_doituong WHERE ma_doituong = ?", [$maDoituong]);
        $doituongInfo = $doituong[0] ?? null;
        
        // Lấy các theme thuộc đối tượng này
        $themes = $productModel->select("SELECT * FROM tbl_lego_theme WHERE ma_doituong = ?", [$maDoituong]);
        
        // Lấy tất cả sản phẩm LEGO thuộc các theme này
        $themeIds = array_column($themes, 'ma_theme');
        $products = [];
        if (!empty($themeIds)) {
            $placeholders = implode(',', array_fill(0, count($themeIds), '?'));
            $products = $productModel->select(
                "SELECT * FROM tbl_lego_sanpham WHERE ma_theme IN ($placeholders) ORDER BY createDate DESC",
                $themeIds
            );
        }
        
        $this->view("Font_end/LegoListView", [
            "title" => $doituongInfo['ten_doituong'] ?? 'LEGO',
            "doituong" => $doituongInfo,
            "themes" => $themes,
            "products" => $products
        ]);
    }
    
    /**
     * Hiển thị sản phẩm LEGO theo theme (City, Ninjago, Minecraft, etc.)
     */
    public function legoByTheme($maTheme) {
        $productModel = $this->model("AdProducModel");
        
        // Lấy thông tin theme
        $theme = $productModel->select("SELECT * FROM tbl_lego_theme WHERE ma_theme = ?", [$maTheme]);
        $themeInfo = $theme[0] ?? null;
        
        // Lấy sản phẩm LEGO thuộc theme này
        $products = $productModel->select(
            "SELECT * FROM tbl_lego_sanpham WHERE ma_theme = ? ORDER BY createDate DESC",
            [$maTheme]
        );
        
        $this->view("Font_end/LegoListView", [
            "title" => $themeInfo['ten_theme'] ?? 'LEGO',
            "theme" => $themeInfo,
            "products" => $products
        ]);
    }
    
    /**
     * Hiển thị chi tiết sản phẩm LEGO
     */
    public function legoDetail($masp) {
        $productModel = $this->model("AdProducModel");
        
        // Lấy thông tin sản phẩm LEGO
        $product = $productModel->select("SELECT * FROM tbl_lego_sanpham WHERE masp = ?", [$masp]);
        $productInfo = $product[0] ?? null;
        
        if (!$productInfo) {
            header('Location: ' . APP_URL . '/Home');
            exit();
        }
        
        // Lấy thông tin theme
        $theme = $productModel->select("SELECT * FROM tbl_lego_theme WHERE ma_theme = ?", [$productInfo['ma_theme']]);
        $themeInfo = $theme[0] ?? null;
        
        // Lấy sản phẩm liên quan (cùng theme)
        $relatedProducts = $productModel->select(
            "SELECT * FROM tbl_lego_sanpham WHERE ma_theme = ? AND masp != ? ORDER BY RAND() LIMIT 4",
            [$productInfo['ma_theme'], $masp]
        );
        
        $this->view("Font_end/LegoDetailView", [
            "product" => $productInfo,
            "theme" => $themeInfo,
            "relatedProducts" => $relatedProducts
        ]);
    }
    
    /**
     * Thêm sản phẩm LEGO vào giỏ hàng
     */
    public function addLegoToCart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        $masp = $_POST['masp'] ?? null;
        $qty = (int)($_POST['qty'] ?? 1);
        
        if (!$masp) {
            echo json_encode(['success' => false, 'message' => 'Thiếu mã sản phẩm']);
            exit();
        }
        
        // Lấy thông tin sản phẩm LEGO từ DB
        $productModel = $this->model('AdProducModel');
        $product = $productModel->select("SELECT * FROM tbl_lego_sanpham WHERE masp = ?", [$masp]);
        
        if (empty($product)) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
            exit();
        }
        
        $p = $product[0];
        $price = $p['giaKhuyenMai'] ?? $p['giaXuat'];
        
        // Khởi tạo cart nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Thêm hoặc cập nhật số lượng (key = LEGO_masp để phân biệt)
        $cartKey = 'LEGO_' . $masp;
        if (isset($_SESSION['cart'][$cartKey])) {
            $_SESSION['cart'][$cartKey]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$cartKey] = [
                'masp' => $masp,
                'ten_sp' => $p['tensp'],
                'hinh_anh' => $p['hinhanh'],
                'gia' => $price,
                'qty' => $qty,
                'type' => 'lego'
            ];
        }
        
        // Tính tổng số lượng
        $totalQty = 0;
        foreach ($_SESSION['cart'] as $item) {
            if (is_array($item) && isset($item['qty'])) {
                $totalQty += $item['qty'];
            }
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng',
            'totalQty' => $totalQty
        ]);
        exit();
    }
    public function placeOrder()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . APP_URL);
        exit;
    }

    // Nếu không cần bắt đăng nhập: bỏ phần này. Nhưng hiện bạn bắt đăng nhập:
    if (!isset($_SESSION['user'])) {
        $_SESSION['error'] = "Vui lòng đăng nhập để đặt hàng";
        header("Location: " . APP_URL . "/AuthController/ShowLogin");
        exit;
    }

    // Lấy user_id an toàn: ưu tiên session, fallback lookup bằng email
    $userId = $_SESSION['user']['user_id'] 
           ?? $_SESSION['user']['id'] 
           ?? null;

    if ($userId === null && !empty($_SESSION['user']['email'])) {
        // lookup trong DB để lấy user_id (dự phòng)
        $userModel = $this->model('UserModel');
        $row = $userModel->findByEmail($_SESSION['user']['email']);
        if ($row) {
            $userId = $row['user_id'] ?? $row['id'] ?? null;
            // cập nhật session để lần sau khỏi lookup
            $_SESSION['user']['user_id'] = $userId;
        }
    }

    // nếu vẫn null tuỳ bạn: cho phép NULL (guest order) hoặc bắt login.
    if ($userId === null) {
        // Option A: ép bắt login
        $_SESSION['error'] = "Không xác định được user. Vui lòng đăng nhập lại.";
        header("Location: " . APP_URL . "/AuthController/ShowLogin");
        exit;

        // Option B (nếu muốn cho guest order): comment đoạn trên và set $userId = null; 
        // Nhưng DB hiện user_id NOT NULL → cần phải thay cấu trúc DB để allow NULL.
    }

    if (empty($_SESSION['cart'])) {
        $_SESSION['error'] = "Giỏ hàng trống";
        header("Location: " . APP_URL . "/Home/order");
        exit;
    }

    // Lấy dữ liệu từ form
    $orderName     = trim($_POST['order_name'] ?? '');
    $orderPhone    = trim($_POST['order_phone'] ?? '');
    $receiver      = trim($_POST['receiver_name'] ?: $orderName);
    $receiverPhone = trim($_POST['receiver_phone'] ?: $orderPhone);
    $payment       = $_POST['payment'] ?? 'cod';
    $voucherCode   = $_POST['voucher_code'] ?? null;

    $discount = (float)($_POST['discount_amount'] ?? 0);
    $shipFee  = (float)($_POST['ship_fee'] ?? 0);
    $final    = (float)($_POST['final_amount'] ?? 0);

    $addressParts = [];
    if (!empty($_POST['address'])) $addressParts[] = trim($_POST['address']);
    if (!empty($_POST['ward']))    $addressParts[] = trim($_POST['ward']);
    if (!empty($_POST['district']))$addressParts[] = trim($_POST['district']);
    $address = implode(', ', $addressParts);

    $orderCode = 'HD' . time();
    
    // Xác định trạng thái thanh toán dựa trên phương thức
    // bank_before: chờ thanh toán (sẽ redirect VNPay)
    // bank_after: chờ thanh toán (thanh toán sau)
    // cod: chờ thanh toán (tiền mặt)
    $transaction = 'chothanhtoan';

    // LẤY PHƯƠNG THỨC GIAO HÀNG
    $deliveryMethod = $_POST['delivery_method'] ?? 'home';

    // LẤY PHƯƠNG THỨC THANH TOÁN
    $paymentMethod = $_POST['payment'] ?? 'cod';

    $orderModel = $this->model('OrderModel');

    $orderData = [
    'user_id' => $userId,
    'user_email' => $_SESSION['user']['email'] ?? null,
    'order_code' => $orderCode,
    'receiver' => $receiver,
    'phone' => $receiverPhone,
    'address' => $address,
    'delivery_method' => $deliveryMethod,   
    'payment_method' => $paymentMethod,     
    'total_amount' => $final,
    'discount_amount' => $discount,
    'coupon_code' => $voucherCode,
    'transaction_info' => $transaction,
    'note' => $_POST['note'] ?? null
];

    $orderId = $orderModel->createOrder($orderData);

    if (!$orderId) {
        $_SESSION['error'] = "Không thể tạo đơn hàng! Thử lại.";
        header("Location: " . APP_URL . "/Home/order");
        exit;
    }

    // Lưu chi tiết đơn hàng và trừ kho
    $productModel = $this->model('AdProducModel');
    
    foreach ($_SESSION['cart'] as $key => $item) {
        // Bỏ qua nếu không phải mảng
        if (!is_array($item)) continue;
        
        // Cấu trúc mới (đồ chơi không có size): $_SESSION['cart'][$masp] = ['masp'=>..., 'qty'=>...]
        if (isset($item['masp']) && isset($item['qty'])) {
            $masp = $item['masp'];
            $qty = (int)$item['qty'];
            $price = $item['giaXuat'] ?? $item['gia'] ?? $item['price'] ?? 0;
            $tensp = $item['tensp'] ?? '';
            $hinhanh = $item['hinhanh'] ?? '';
            
            // Lưu chi tiết đơn hàng
            $orderModel->insertOrderDetail([
                'order_id' => $orderId,
                'product_id' => $masp,
                'quantity' => $qty,
                'price' => (float)$price,
                'product_name' => $tensp,
                'product_image' => $hinhanh
            ]);
            
            // Trừ số lượng tồn kho
            $productModel->query(
                "UPDATE tblsanpham SET soluong = GREATEST(0, soluong - ?) WHERE masp = ?",
                [$qty, $masp]
            );
            continue;
        }
        
        // Cấu trúc cũ (có size): $_SESSION['cart'][$masp][$size] = [...]
        foreach ($item as $size => $subItem) {
            if (!is_array($subItem)) continue;
            
            $masp = $subItem['masp'] ?? $key;
            $qty = (int)($subItem['qty'] ?? 0);
            $price = $subItem['giaXuat'] ?? $subItem['price'] ?? $subItem['gia'] ?? 0;
            $tensp = $subItem['tensp'] ?? '';
            $hinhanh = $subItem['hinhanh'] ?? '';
            
            // Lưu chi tiết đơn hàng
            $orderModel->insertOrderDetail([
                'order_id' => $orderId,
                'product_id' => $masp,
                'quantity' => $qty,
                'price' => (float)$price,
                'product_name' => $tensp,
                'product_image' => $hinhanh
            ]);
            
            // Trừ số lượng tồn kho
            $productModel->query(
                "UPDATE tblsanpham SET soluong = GREATEST(0, soluong - ?) WHERE masp = ?",
                [$qty, $masp]
            );
        }
    }

    // Gửi email xác nhận đơn hàng
    $userEmail = $_SESSION['user']['email'] ?? null;
    if ($userEmail) {
        $orderDetails = $orderModel->getOrderDetailsByOrderId($orderId);
        $orderInfo = [
            'order_code' => $orderCode,
            'receiver' => $receiver,
            'phone' => $receiverPhone,
            'address' => $address,
            'total_amount' => $final,
            'discount_amount' => $discount,
            'payment_method' => $paymentMethod,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->sendOrderEmail($userEmail, $orderInfo, $orderDetails);
    }

    unset($_SESSION['cart']);
    
    // Nếu chọn "chuyển khoản trước" -> redirect sang VNPay ngay
    if ($paymentMethod === 'bank_before') {
        $_SESSION['orderCode'] = $orderCode;
        $_SESSION['totalAmount'] = $final;
        header('Location: ' . APP_URL . '/vnpay_php/vnpay_pay.php');
        exit;
    }
    
    // Các phương thức khác -> về trang lịch sử đơn hàng
    $_SESSION['success'] = "Đặt hàng thành công! Mã đơn: $orderCode";
    header("Location: " . APP_URL . "/Home/orderHistory");
    exit;
}

    // ================= ĐÁNH GIÁ SẢN PHẨM =================
    
    // Hiển thị danh sách sản phẩm để đánh giá
    public function reviewList() {
        $productModel = $this->model('AdProducModel');
        $reviewModel = $this->model('ReviewModel');
        
        // Lấy tất cả sản phẩm
        $products = $productModel->select("SELECT * FROM tblsanpham ORDER BY tensp");
        
        // Thêm thống kê đánh giá cho mỗi sản phẩm
        foreach ($products as &$product) {
            $stats = $reviewModel->getProductStats($product['masp']);
            $product['avg_rating'] = $stats['avg_rating'] ?? 0;
            $product['total_reviews'] = $stats['total_reviews'] ?? 0;
        }
        
        $this->view('Font_end/ReviewProductListView', ['products' => $products]);
    }
    
    // Hiển thị form đánh giá sản phẩm
    public function reviewProduct($masp) {
        $productModel = $this->model('AdProducModel');
        $reviewModel = $this->model('ReviewModel');
        
        // Lấy thông tin sản phẩm
        $product = $productModel->find('tblsanpham', $masp);
        if (!$product) {
            header('Location: ' . APP_URL . '/Home/reviewList');
            exit();
        }
        
        // Lấy đánh giá đã duyệt
        $reviews = $reviewModel->getByProduct($masp);
        
        // Lấy thống kê
        $stats = $reviewModel->getProductStats($masp);
        
        $this->view('Font_end/ReviewFormView', [
            'product' => $product,
            'reviews' => $reviews,
            'stats' => $stats
        ]);
    }
    
    // Xử lý gửi đánh giá
    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '/Home/reviewList');
            exit();
        }
        
        if (!isset($_SESSION['user'])) {
            $_SESSION['review_error'] = 'Vui lòng đăng nhập để gửi đánh giá';
            header('Location: ' . APP_URL . '/AuthController/ShowLogin');
            exit();
        }
        
        $productId = $_POST['product_id'] ?? '';
        $rating = (int)($_POST['rating'] ?? 5);
        $comment = trim($_POST['comment'] ?? '');
        
        // Validate
        if (empty($productId) || $rating < 1 || $rating > 5) {
            $_SESSION['review_error'] = 'Dữ liệu không hợp lệ';
            header('Location: ' . APP_URL . '/Home/reviewProduct/' . $productId);
            exit();
        }
        
        // Upload ảnh nếu có
        $imageName = null;
        if (isset($_FILES['review_image']) && $_FILES['review_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'public/images/reviews/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $ext = pathinfo($_FILES['review_image']['name'], PATHINFO_EXTENSION);
            $imageName = 'review_' . time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['review_image']['tmp_name'], $uploadDir . $imageName);
        }
        
        // Lưu đánh giá
        $reviewModel = $this->model('ReviewModel');
        $reviewModel->addReview([
            'user_id' => $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'],
            'user_name' => $_SESSION['user']['fullname'],
            'user_email' => $_SESSION['user']['email'],
            'product_id' => $productId,
            'rating' => $rating,
            'comment' => $comment,
            'image' => $imageName
        ]);
        
        $_SESSION['review_success'] = 'Cảm ơn bạn đã gửi đánh giá! Đánh giá sẽ được hiển thị sau khi được duyệt.';
        header('Location: ' . APP_URL . '/Home/reviewProduct/' . $productId);
        exit();
    }
    
    // ================= GỬI EMAIL XÁC NHẬN ĐƠN HÀNG =================
    private function sendOrderEmail($toEmail, $orderInfo, $orderDetails) {
        require_once __DIR__ . '/../vendor/autoload.php';
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'chitogelovehoi@gmail.com';
            $mail->Password = 'mkur ygbo jbyz xtwi';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('chitogelovehoi@gmail.com', 'ToyShop - Đồ Chơi Trẻ Em');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = "🎮 Xác nhận đơn hàng #{$orderInfo['order_code']} - ToyShop";
            
            // Tạo danh sách sản phẩm
            $itemsHtml = '';
            $productModel = $this->model('AdProducModel');
            foreach ($orderDetails as $item) {
                // Lấy tên sản phẩm
                $product = $productModel->select("SELECT tensp, giaXuat FROM tblsanpham WHERE masp = ?", [$item['product_id']]);
                $productName = $product[0]['tensp'] ?? 'Sản phẩm';
                $price = $product[0]['giaXuat'] ?? $item['price'] ?? 0;
                $subtotal = $price * $item['quantity'];
                
                $itemsHtml .= "<tr>
                    <td style='padding:12px; border-bottom:1px solid #eee;'>{$productName}</td>
                    <td style='padding:12px; border-bottom:1px solid #eee; text-align:center;'>{$item['quantity']}</td>
                    <td style='padding:12px; border-bottom:1px solid #eee; text-align:right;'>" . number_format($price, 0, ',', '.') . " ₫</td>
                    <td style='padding:12px; border-bottom:1px solid #eee; text-align:right;'>" . number_format($subtotal, 0, ',', '.') . " ₫</td>
                </tr>";
            }
            
            // Phương thức thanh toán
            $paymentText = match($orderInfo['payment_method'] ?? 'cod') {
                'vnpay' => 'Thanh toán qua VNPay',
                'bank_before' => 'Chuyển khoản trước',
                'bank_after' => 'Chuyển khoản sau khi nhận hàng',
                default => 'Thanh toán tiền mặt khi nhận hàng (COD)'
            };
            
            $discountHtml = '';
            if (($orderInfo['discount_amount'] ?? 0) > 0) {
                $discountHtml = "<tr><td style='padding:5px 0;'>Giảm giá:</td><td style='text-align:right; color:#e31837;'>-" . number_format($orderInfo['discount_amount'], 0, ',', '.') . " ₫</td></tr>";
            }
            
            $mail->Body = "
            <div style='font-family:Arial,sans-serif; max-width:600px; margin:0 auto; background:#fff;'>
                <div style='background:linear-gradient(135deg, #003399 0%, #002266 100%); padding:25px; text-align:center;'>
                    <h1 style='color:#ffd700; margin:0; font-size:28px;'>🎮 TOYSHOP</h1>
                    <p style='color:#fff; margin:10px 0 0; font-size:14px;'>Đồ Chơi Trẻ Em Chính Hãng</p>
                </div>
                
                <div style='padding:30px;'>
                    <h2 style='color:#003399; margin-top:0;'>✅ Đặt hàng thành công!</h2>
                    <p style='color:#555; font-size:15px;'>Xin chào <strong>{$orderInfo['receiver']}</strong>,</p>
                    <p style='color:#555; font-size:15px;'>Cảm ơn bạn đã đặt hàng tại <strong style='color:#e31837;'>ToyShop</strong>. Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
                    
                    <div style='background:#f0f5ff; border-radius:10px; padding:20px; margin:25px 0; border-left:4px solid #003399;'>
                        <h3 style='color:#003399; margin-top:0; padding-bottom:10px;'>📦 Thông tin đơn hàng</h3>
                        <table style='width:100%; font-size:14px;'>
                            <tr><td style='padding:8px 0; color:#666;'>Mã đơn hàng:</td><td style='padding:8px 0;'><strong style='color:#e31837;'>{$orderInfo['order_code']}</strong></td></tr>
                            <tr><td style='padding:8px 0; color:#666;'>Ngày đặt:</td><td style='padding:8px 0;'>{$orderInfo['created_at']}</td></tr>
                            <tr><td style='padding:8px 0; color:#666;'>Người nhận:</td><td style='padding:8px 0;'>{$orderInfo['receiver']}</td></tr>
                            <tr><td style='padding:8px 0; color:#666;'>Số điện thoại:</td><td style='padding:8px 0;'>{$orderInfo['phone']}</td></tr>
                            <tr><td style='padding:8px 0; color:#666;'>Địa chỉ:</td><td style='padding:8px 0;'>{$orderInfo['address']}</td></tr>
                            <tr><td style='padding:8px 0; color:#666;'>Thanh toán:</td><td style='padding:8px 0;'>{$paymentText}</td></tr>
                        </table>
                    </div>
                    
                    <div style='margin:25px 0;'>
                        <h3 style='color:#003399; border-bottom:2px solid #003399; padding-bottom:10px;'>🛒 Chi tiết sản phẩm</h3>
                        <table style='width:100%; border-collapse:collapse; font-size:14px;'>
                            <thead>
                                <tr style='background:#003399;'>
                                    <th style='padding:12px; text-align:left; color:#fff;'>Sản phẩm</th>
                                    <th style='padding:12px; text-align:center; color:#fff;'>SL</th>
                                    <th style='padding:12px; text-align:right; color:#fff;'>Đơn giá</th>
                                    <th style='padding:12px; text-align:right; color:#fff;'>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>{$itemsHtml}</tbody>
                        </table>
                    </div>
                    
                    <div style='background:linear-gradient(135deg, #e31837 0%, #c41530 100%); border-radius:10px; padding:20px; margin:25px 0; color:#fff;'>
                        <table style='width:100%; font-size:15px; color:#fff;'>
                            {$discountHtml}
                            <tr><td style='padding:10px 0; font-size:18px;'><strong>💰 Tổng thanh toán:</strong></td><td style='text-align:right; font-size:22px;'><strong style='color:#ffd700;'>" . number_format($orderInfo['total_amount'], 0, ',', '.') . " ₫</strong></td></tr>
                        </table>
                    </div>
                    
                    <div style='background:#fff3cd; border-radius:10px; padding:15px; margin:25px 0; border-left:4px solid #ffc107;'>
                        <p style='margin:0; color:#856404; font-size:14px;'>📞 <strong>Hotline:</strong> 1900 1234 | 📧 <strong>Email:</strong> support@toyshop.vn</p>
                    </div>
                    
                    <p style='color:#666; font-size:14px;'>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
                    <p style='color:#666; font-size:14px;'>Trân trọng,<br><strong style='color:#003399;'>🎮 ToyShop - Đồ Chơi Trẻ Em</strong></p>
                </div>
                
                <div style='background:#003399; padding:20px; text-align:center;'>
                    <p style='color:#fff; margin:0; font-size:13px;'>© 2025 ToyShop - Website Đồ Chơi Trẻ Em Chính Hãng</p>
                    <p style='color:#ffd700; margin:10px 0 0; font-size:12px;'>🚚 Miễn phí giao hàng đơn từ 500k | ⚡ Giao hàng hỏa tốc 4 tiếng</p>
                </div>
            </div>";

            $mail->send();
            return true;
        } catch (\Exception $e) {
            // Log lỗi nếu cần
            error_log("Send email error: " . $e->getMessage());
            return false;
        }
    }
}

