<?php
require_once __DIR__ . "/BaseModel.php";

class ToyModel extends BaseModel {

    /**
     * Lấy tất cả loại đồ chơi
     */
    public function getAllCategories() {
        try {
            $sql = "SELECT * FROM tbl_loai_dochoi WHERE trang_thai = 1 ORDER BY thu_tu ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ToyModel::getAllCategories error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy tất cả sản phẩm đồ chơi
     */
    public function getAllProducts($limit = null) {
        try {
            $sql = "SELECT p.*, c.ten_loai 
                    FROM tbl_dochoi p 
                    LEFT JOIN tbl_loai_dochoi c ON p.ma_loai = c.ma_loai 
                    WHERE p.trang_thai = 1 
                    ORDER BY p.noi_bat DESC, p.created_at DESC";
            if ($limit) {
                $sql .= " LIMIT " . (int)$limit;
            }
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ToyModel::getAllProducts error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy sản phẩm nổi bật
     */
    public function getFeaturedProducts($limit = 8) {
        try {
            $sql = "SELECT p.*, c.ten_loai 
                    FROM tbl_dochoi p 
                    LEFT JOIN tbl_loai_dochoi c ON p.ma_loai = c.ma_loai 
                    WHERE p.trang_thai = 1 AND p.noi_bat = 1 
                    ORDER BY p.created_at DESC 
                    LIMIT :limit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ToyModel::getFeaturedProducts error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy sản phẩm theo loại
     */
    public function getProductsByCategory($maLoai, $limit = null) {
        try {
            $sql = "SELECT p.*, c.ten_loai 
                    FROM tbl_dochoi p 
                    LEFT JOIN tbl_loai_dochoi c ON p.ma_loai = c.ma_loai 
                    WHERE p.trang_thai = 1 AND p.ma_loai = :maLoai 
                    ORDER BY p.noi_bat DESC, p.created_at DESC";
            if ($limit) {
                $sql .= " LIMIT " . (int)$limit;
            }
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':maLoai', $maLoai);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ToyModel::getProductsByCategory error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy chi tiết sản phẩm
     */
    public function getProductById($maSp) {
        try {
            $sql = "SELECT p.*, c.ten_loai 
                    FROM tbl_dochoi p 
                    LEFT JOIN tbl_loai_dochoi c ON p.ma_loai = c.ma_loai 
                    WHERE p.ma_sp = :maSp";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':maSp', $maSp);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ToyModel::getProductById error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function searchProducts($keyword) {
        try {
            $keyword = "%{$keyword}%";
            $sql = "SELECT p.*, c.ten_loai 
                    FROM tbl_dochoi p 
                    LEFT JOIN tbl_loai_dochoi c ON p.ma_loai = c.ma_loai 
                    WHERE p.trang_thai = 1 
                    AND (p.ten_sp LIKE :kw1 OR p.mo_ta LIKE :kw2 OR p.thuong_hieu LIKE :kw3 OR p.sku LIKE :kw4)
                    ORDER BY p.noi_bat DESC, p.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':kw1', $keyword);
            $stmt->bindParam(':kw2', $keyword);
            $stmt->bindParam(':kw3', $keyword);
            $stmt->bindParam(':kw4', $keyword);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ToyModel::searchProducts error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Thêm sản phẩm mới
     */
    public function insertProduct($data) {
        try {
            $sql = "INSERT INTO tbl_dochoi 
                    (ma_loai, ten_sp, sku, hinh_anh, mo_ta, gia_nhap, gia_ban, gia_khuyen_mai, so_luong, thuong_hieu, do_tuoi_phu_hop, xuat_xu, noi_bat) 
                    VALUES 
                    (:ma_loai, :ten_sp, :sku, :hinh_anh, :mo_ta, :gia_nhap, :gia_ban, :gia_khuyen_mai, :so_luong, :thuong_hieu, :do_tuoi, :xuat_xu, :noi_bat)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ma_loai', $data['ma_loai']);
            $stmt->bindParam(':ten_sp', $data['ten_sp']);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':hinh_anh', $data['hinh_anh']);
            $stmt->bindParam(':mo_ta', $data['mo_ta']);
            $stmt->bindParam(':gia_nhap', $data['gia_nhap']);
            $stmt->bindParam(':gia_ban', $data['gia_ban']);
            $stmt->bindParam(':gia_khuyen_mai', $data['gia_khuyen_mai']);
            $stmt->bindParam(':so_luong', $data['so_luong']);
            $stmt->bindParam(':thuong_hieu', $data['thuong_hieu']);
            $stmt->bindParam(':do_tuoi', $data['do_tuoi_phu_hop']);
            $stmt->bindParam(':xuat_xu', $data['xuat_xu']);
            $stmt->bindParam(':noi_bat', $data['noi_bat']);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("ToyModel::insertProduct error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật sản phẩm
     */
    public function updateProduct($maSp, $data) {
        try {
            $sql = "UPDATE tbl_dochoi SET 
                    ma_loai = :ma_loai,
                    ten_sp = :ten_sp,
                    sku = :sku,
                    hinh_anh = :hinh_anh,
                    mo_ta = :mo_ta,
                    gia_nhap = :gia_nhap,
                    gia_ban = :gia_ban,
                    gia_khuyen_mai = :gia_khuyen_mai,
                    so_luong = :so_luong,
                    thuong_hieu = :thuong_hieu,
                    do_tuoi_phu_hop = :do_tuoi,
                    xuat_xu = :xuat_xu,
                    noi_bat = :noi_bat
                    WHERE ma_sp = :ma_sp";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ma_sp', $maSp);
            $stmt->bindParam(':ma_loai', $data['ma_loai']);
            $stmt->bindParam(':ten_sp', $data['ten_sp']);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':hinh_anh', $data['hinh_anh']);
            $stmt->bindParam(':mo_ta', $data['mo_ta']);
            $stmt->bindParam(':gia_nhap', $data['gia_nhap']);
            $stmt->bindParam(':gia_ban', $data['gia_ban']);
            $stmt->bindParam(':gia_khuyen_mai', $data['gia_khuyen_mai']);
            $stmt->bindParam(':so_luong', $data['so_luong']);
            $stmt->bindParam(':thuong_hieu', $data['thuong_hieu']);
            $stmt->bindParam(':do_tuoi', $data['do_tuoi_phu_hop']);
            $stmt->bindParam(':xuat_xu', $data['xuat_xu']);
            $stmt->bindParam(':noi_bat', $data['noi_bat']);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("ToyModel::updateProduct error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa sản phẩm (soft delete)
     */
    public function deleteProduct($maSp) {
        try {
            $sql = "UPDATE tbl_dochoi SET trang_thai = 0 WHERE ma_sp = :ma_sp";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ma_sp', $maSp);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("ToyModel::deleteProduct error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Đếm sản phẩm
     */
    public function countProducts() {
        try {
            $sql = "SELECT COUNT(*) FROM tbl_dochoi WHERE trang_thai = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("ToyModel::countProducts error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Tăng lượt xem
     */
    public function incrementView($maSp) {
        try {
            $sql = "UPDATE tbl_dochoi SET luot_xem = luot_xem + 1 WHERE ma_sp = :ma_sp";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ma_sp', $maSp);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
