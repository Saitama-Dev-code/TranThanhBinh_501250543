<?php
/**
 * =========================================================================
 * CLASS: Product (Kế thừa từ BaseModel)
 * - MỤC ĐÍCH: Xử lý các truy vấn phức tạp của bảng `products` như tìm kiếm, lọc, phân trang.
 * - BẢO MẬT: Bắt buộc dùng Prepared Statements (bindValue) để chống SQL Injection.
 * =========================================================================
 */
require_once ROOT_PATH . '/core/BaseModel.php';

class Product extends BaseModel {
    public function __construct() {
        parent::__construct();
        $this->table = 'products';
    }

    /**
     * HÀM: Lấy danh sách sản phẩm theo điều kiện (Lọc, Tìm kiếm, Phân trang)
     * - CÁCH HOẠT ĐỘNG: Tạo ra câu SQL động (nối chuỗi WHERE tùy điều kiện). 
     * - @param string $keyword Từ khóa tìm kiếm (mặc định rỗng)
     * - @param int $categoryId ID của danh mục cần lọc (mặc định null)
     * - @param int $limit Số lượng SP trên 1 trang (Yêu cầu đồ án: 6)
     * - @param int $offset Vị trí bắt đầu lấy dữ liệu (Phục vụ phân trang)
     */
    public function getFilteredProducts($keyword = '', $categoryId = null, $limit = 6, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];

        // Nếu người dùng có nhập từ khóa tìm kiếm
        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = "%{$keyword}%";
        }

        // Nếu người dùng có bấm chọn 1 danh mục cụ thể
        if (!empty($categoryId)) {
            $sql .= " AND category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        // Sắp xếp mới nhất và nối thêm chuỗi phân trang LIMIT ... OFFSET ...
        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        // Bind dữ liệu an toàn
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        // PDO::PARAM_INT bắt buộc ép kiểu số nguyên để tránh lỗi cú pháp LIMIT của SQL
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * HÀM: Đếm tổng số lượng sản phẩm (Phục vụ việc vẽ số trang 1, 2, 3...)
     * - CÁCH HOẠT ĐỘNG: Giống hệt hàm trên nhưng thay SELECT * bằng SELECT COUNT(*)
     */
    public function getTotalProducts($keyword = '', $categoryId = null) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = "%{$keyword}%";
        }

        if (!empty($categoryId)) {
            $sql .= " AND category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }
}
?>