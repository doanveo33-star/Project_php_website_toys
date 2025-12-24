<?php
class Product extends Controller
{
    // Mặc định khi vào /Product/
    public function index()
    {
        $this->show();
    }
    
    public function show()
    {
        $obj = $this->model("AdProducModel");

        // Lấy danh sách sản phẩm (không cần join với bảng size nữa)
        $sql = "SELECT * FROM tblsanpham ORDER BY createDate DESC, masp ASC";
        $data = $obj->select($sql);

        $this->view("adminPage", [
            "page" => "ProductListView",
            "productList" => $data
        ]);
    }

    public function delete($masp)
    {
        $obj = $this->model("AdProducModel");

        // Xóa sản phẩm
        $result = $obj->delete("tblsanpham", $masp);

        if ($result) {
            $_SESSION['success'] = "Xóa sản phẩm thành công";
        } else {
            $_SESSION['error'] = "Lỗi khi xóa sản phẩm";
        }

        header("Location:" . APP_URL . "/Product/");
        exit();
    }

    public function create()
    {
        $obj = $this->model("AdProducModel");
        $obj2 = $this->model("AdProductTypeModel");
        $promoModel = $this->model("PromotionModel");
        
        $producttype = $obj2->all("tblloaisp");
        $promotions = $promoModel->getAllActive();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $masp = preg_replace('/\s+/', '', $_POST["txt_masp"]);
            $tensp = trim($_POST["txt_tensp"]);
            $maloaisp = $_POST["txt_maloaisp"];
            $soluong = (int)($_POST["txt_soluong"] ?? 0);
            $mota = trim($_POST["txt_mota"] ?? '');
            $giaNhap = (int)($_POST["txt_gianhap"] ?? 0);
            $giaXuat = (int)($_POST["txt_giaxuat"] ?? 0);
            $doTuoi = $_POST["txt_dotuoi"] ?? '';
            $promotionId = !empty($_POST["txt_promotion_id"]) ? (int)$_POST["txt_promotion_id"] : null;
            
            // Tính discount_percent từ promotion
            $discountPercent = null;
            if ($promotionId) {
                foreach ($promotions as $promo) {
                    if ($promo['id'] == $promotionId && $promo['type'] == 'percent') {
                        $discountPercent = (int)$promo['value'];
                        break;
                    }
                }
            }

            // Kiểm tra mã sản phẩm đã tồn tại chưa
            $existing = $obj->find("tblsanpham", $masp);
            if ($existing) {
                $_SESSION['error'] = "Mã sản phẩm '$masp' đã tồn tại!";
                header("Location: " . APP_URL . "/Product/create");
                exit();
            }

            // Upload ảnh
            $hinhanh = "default.png";
            if (!empty($_FILES["uploadfile"]["name"])) {
                $ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
                $hinhanh = 'product_' . time() . '_' . uniqid() . '.' . $ext;
                
                $target_dir = "./public/Images/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
                move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_dir . $hinhanh);
            }

            // INSERT sản phẩm với promotion
            $sql = "INSERT INTO tblsanpham (masp, maLoaiSP, tensp, hinhanh, soluong, giaNhap, giaXuat, doTuoi, mota, promotion_id, discount_percent, createDate) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";
            
            try {
                $result = $obj->query($sql, [$masp, $maloaisp, $tensp, $hinhanh, $soluong, $giaNhap, $giaXuat, $doTuoi, $mota, $promotionId, $discountPercent]);
                $_SESSION['success'] = "Thêm sản phẩm thành công!";
            } catch (Exception $e) {
                $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            }

            header("Location: " . APP_URL . "/Product/");
            exit();
        }

        $this->view("adminPage", [
            "page" => "ProductView",
            "producttype" => $producttype,
            "promotions" => $promotions
        ]);
    }

    public function edit($masp)
    {
        $obj = $this->model("AdProducModel");
        $obj2 = $this->model("AdProductTypeModel");
        $promoModel = $this->model("PromotionModel");

        $producttype = $obj2->all("tblloaisp");
        $promotions = $promoModel->getAllActive();
        $product = $obj->find("tblsanpham", $masp);

        if (!$product) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm";
            header("Location: " . APP_URL . "/Product/");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $tensp = trim($_POST["txt_tensp"]);
            $maloaisp = $_POST["txt_maloaisp"];
            $soluong = (int)($_POST["txt_soluong"] ?? 0);
            $mota = trim($_POST["txt_mota"] ?? '');
            $giaNhap = (int)($_POST["txt_gianhap"] ?? 0);
            $giaXuat = (int)($_POST["txt_giaxuat"] ?? 0);
            $doTuoi = $_POST["txt_dotuoi"] ?? '';
            $promotionId = !empty($_POST["txt_promotion_id"]) ? (int)$_POST["txt_promotion_id"] : null;
            
            // Tính discount_percent từ promotion
            $discountPercent = null;
            if ($promotionId) {
                foreach ($promotions as $promo) {
                    if ($promo['id'] == $promotionId && $promo['type'] == 'percent') {
                        $discountPercent = (int)$promo['value'];
                        break;
                    }
                }
            }

            // Ảnh
            $hinhanh = $product['hinhanh'];
            if (!empty($_FILES["uploadfile"]["name"])) {
                $ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
                $hinhanh = 'product_' . time() . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "./public/Images/" . $hinhanh);
            }

            // UPDATE sản phẩm với promotion
            $sql = "UPDATE tblsanpham SET 
                    maLoaiSP = ?,
                    tensp = ?,
                    hinhanh = ?,
                    soluong = ?,
                    giaNhap = ?,
                    giaXuat = ?,
                    doTuoi = ?,
                    mota = ?,
                    promotion_id = ?,
                    discount_percent = ?
                    WHERE masp = ?";
            
            try {
                $obj->query($sql, [$maloaisp, $tensp, $hinhanh, $soluong, $giaNhap, $giaXuat, $doTuoi, $mota, $promotionId, $discountPercent, $masp]);
                $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
            } catch (Exception $e) {
                $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            }

            header("Location: " . APP_URL . "/Product/");
            exit();
        }

        $this->view("adminPage", [
            "page" => "ProductView",
            "producttype" => $producttype,
            "promotions" => $promotions,
            "editItem" => $product
        ]);
    }
}
