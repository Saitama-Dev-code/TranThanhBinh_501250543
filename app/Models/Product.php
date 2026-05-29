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
     * HÀM: Lấy danh sách sản phẩm theo điều kiện (Lọc nâng cao, Tìm kiếm, Phân trang/Infinite Scroll)
     * - CÁCH HOẠT ĐỘNG: Tạo ra câu SQL động (nối chuỗi WHERE tùy điều kiện).
     * - @param string $keyword Từ khóa tìm kiếm (mặc định rỗng)
     * @param int|null $categoryId ID danh mục cần lọc (mặc định null)
     * @param float|null $priceMin Giá tối thiểu (VD: 1000000)
     * @param float|null $priceMax Giá tối đa (VD: 50000000)
     * @param string|null $brand Thương hiệu cần lọc (VD: 'Yamaha')
     * @param int|null $inStock Lọc theo tồn kho: 1 = chỉ còn hàng, 0 = tất cả
     * @param int|null $isRentable Lọc sản phẩm cho thuê: 1 = chỉ sản phẩm cho thuê
     * @param int $limit Số lượng SP trên 1 trang / lần load (mặc định 6)
     * @param int $offset Vị trí bắt đầu lấy dữ liệu (Phục vụ phân trang/Infinite Scroll)
     */
    public function getFilteredProducts(
        $keyword = '',
        $categoryId = null,
        $priceMin = null,
        $priceMax = null,
        $brand = null,
        $inStock = null,
        $isRentable = null,
        $limit = 6,
        $offset = 0
    ) {
        // =================================================================
        // BƯỚC 1: XÂY DỰNG CÂU SQL ĐỘNG
        // =================================================================
        // Bắt đầu với điều kiện luôn đúng "1=1" để tiện nối AND sau đó
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];

        // -----------------------------------------------------------------
        // ĐIỀU KIỆN 1: Từ khóa tìm kiếm (tìm trong tên sản phẩm)
        // -----------------------------------------------------------------
        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = "%{$keyword}%";
        }

        // -----------------------------------------------------------------
        // ĐIỀU KIỆN 2: Lọc theo danh mục (Guitar, Piano...)
        // -----------------------------------------------------------------
        if (!empty($categoryId)) {
            $sql .= " AND category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        // -----------------------------------------------------------------
        // ĐIỀU KIỆN 3: Lọc theo khoảng giá (price_min <= giá <= price_max)
        // -----------------------------------------------------------------
        if ($priceMin !== null && $priceMin > 0) {
            $sql .= " AND price >= :price_min";
            $params[':price_min'] = (float)$priceMin;
        }
        if ($priceMax !== null && $priceMax > 0) {
            $sql .= " AND price <= :price_max";
            $params[':price_max'] = (float)$priceMax;
        }

        // -----------------------------------------------------------------
        // ĐIỀU KIỆN 4: Lọc theo thương hiệu (Yamaha, Fender, Roland...)
        // -----------------------------------------------------------------
        if (!empty($brand)) {
            $sql .= " AND brand = :brand";
            $params[':brand'] = $brand;
        }

        // -----------------------------------------------------------------
        // ĐIỀU KIỆN 5: Lọc theo tình trạng kho (chỉ còn hàng / tất cả)
        // -----------------------------------------------------------------
        if ($inStock !== null && $inStock == 1) {
            $sql .= " AND stock > 0";
        }

        // -----------------------------------------------------------------
        // ĐIỀU KIỆN 6: Lọc sản phẩm cho thuê (is_rentable = 1)
        // -----------------------------------------------------------------
        if ($isRentable !== null && $isRentable == 1) {
            $sql .= " AND is_rentable = 1";
        }

        // =================================================================
        // BƯỚC 2: SẮP XẾP VÀ PHÂN TRANG
        // =================================================================
        // Sắp xếp mới nhất, nối thêm chuỗi LIMIT...OFFSET cho phân trang
        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        // =================================================================
        // BƯỚC 3: THỰC THI TRUY VẤN VỚI PREPARED STATEMENTS
        // =================================================================
        $stmt = $this->db->prepare($sql);

        // Bind từng tham số một cách an toàn (chống SQL Injection)
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        // PDO::PARAM_INT bắt buộc ép kiểu số nguyên để tránh lỗi LIMIT/OFFSET
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * HÀM: Đếm tổng số lượng sản phẩm thỏa điều kiện lọc
     * - CÁCH HOẠT ĐỘNG: Giống hàm getFilteredProducts nhưng dùng SELECT COUNT(*)
     * - Dùng để tính tổng số trang hoặc kiểm tra còn sản phẩm để load thêm không
     */
    public function getTotalProducts(
        $keyword = '',
        $categoryId = null,
        $priceMin = null,
        $priceMax = null,
        $brand = null,
        $inStock = null,
        $isRentable = null
    ) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $params = [];

        // Áp dụng lại tất cả các điều kiện lọc như hàm getFilteredProducts
        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = "%{$keyword}%";
        }
        if (!empty($categoryId)) {
            $sql .= " AND category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }
        if ($priceMin !== null && $priceMin > 0) {
            $sql .= " AND price >= :price_min";
            $params[':price_min'] = (float)$priceMin;
        }
        if ($priceMax !== null && $priceMax > 0) {
            $sql .= " AND price <= :price_max";
            $params[':price_max'] = (float)$priceMax;
        }
        if (!empty($brand)) {
            $sql .= " AND brand = :brand";
            $params[':brand'] = $brand;
        }
        if ($inStock !== null && $inStock == 1) {
            $sql .= " AND stock > 0";
        }
        if ($isRentable !== null && $isRentable == 1) {
            $sql .= " AND is_rentable = 1";
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }

    /**
     * HÀM: Lấy danh sách tất cả thương hiệu (Dùng để render bộ lọc thương hiệu)
     * - CÁCH HOẠT ĐỘNG: SELECT DISTINCT brand để lấy danh sách không trùng lặp
     */
    public function getAllBrands() {
        $sql = "SELECT DISTINCT brand FROM {$this->table} ORDER BY brand ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * HÀM: Lấy sản phẩm theo ID (không JOIN - dùng cho các mục đích nhanh)
     */
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * HÀM: Lấy sản phẩm theo ID + JOIN tên danh mục (dùng cho trang Chi Tiết)
     *
     * CÁCH HOẠT ĐỘNG:
     *   - JOIN bảng categories để lấy tên danh mục (category_name)
     *     thay vì chỉ lấy category_id (số)
     *   - LEFT JOIN đảm bảo SP không có danh mục vẫn được trả về (category_name = NULL)
     *
     * KẾT QUẢ TRẢ VỀ (mảng 1 dòng hoặc false nếu không tìm thấy):
     *   id, name, price, image, description, stock, brand,
     *   is_rentable, rent_price_day, deposit_price,
     *   category_id, category_name  ← thêm từ JOIN
     *
     * @param int $id ID sản phẩm cần lấy
     * @return array|false Mảng dữ liệu sản phẩm hoặc false nếu không tìm thấy
     */
    public function getByIdWithCategory($id) {
        $sql = "SELECT
                    p.*,
                    c.name AS category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        // PDO::PARAM_INT: ép kiểu an toàn, tránh SQL Injection
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // fetch() trả về mảng kết quả (1 dòng) hoặc false nếu không có
        return $stmt->fetch();
    }

    /**
     * HÀM: Lấy danh sách biến thể của một sản phẩm
     * - Trả về mảng chứa màu sắc và phiên bản
     */
    public function getVariantsByProductId($productId) {
        $sql = "SELECT * FROM product_variants WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $variants = $stmt->fetchAll();

        // Phân loại biến thể để dễ sử dụng ở View
        $result = [
            'colors' => [],
            'versions' => []
        ];

        foreach ($variants as $v) {
            if ($v['variant_type'] == 'color') {
                $result['colors'][] = $v;
            } else {
                $result['versions'][] = $v;
            }
        }

        return $result;
    }

    /**
     * HÀM: Lấy danh sách sản phẩm ngẫu nhiên (nổi bật)
     * - @param int $limit Số lượng sản phẩm cần lấy (mặc định 6)
     * - @param int|null $excludeId ID sản phẩm cần loại trừ
     */
    public function getRandomProducts($limit = 6, $excludeId = null) {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        if ($excludeId !== null) {
            $sql .= " AND id != :exclude_id";
        }
        $sql .= " ORDER BY RAND() LIMIT " . (int)$limit;
        
        $stmt = $this->db->prepare($sql);
        if ($excludeId !== null) {
            $stmt->bindValue(':exclude_id', (int)$excludeId, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * HÀM: Cập nhật giảm số lượng hàng tồn kho của sản phẩm khi bán
     * @param int $productId ID sản phẩm
     * @param int $quantity Số lượng bán
     * @return bool
     */
    public function deductStock($productId, $quantity) {
        $sql = "UPDATE {$this->table} SET stock = stock - :quantity WHERE id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', (int)$productId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>