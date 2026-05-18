<?php
/**
 * =========================================================================
 * CLASS: ProductController (Kế thừa từ BaseController)
 * - MỤC ĐÍCH: Nhận yêu cầu từ URL, gọi Models lấy dữ liệu, tính toán phân trang
 *   sau đó đẩy toàn bộ dữ liệu ra View hiển thị.
 * - ĐƯỜNG DẪN GỌI ĐẾN: index.php?controller=product&action=index
 * =========================================================================
 */

// Load các file cần thiết: BaseController, Product Model, Category Model
require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/Product.php';
require_once ROOT_PATH . '/app/Models/Category.php';

class ProductController extends BaseController {

    /**
     * ACTION: index (Hiển thị danh sách sản phẩm với bộ lọc nâng cao)
     * - TIẾP NHẬN: Tất cả tham số lọc từ URL ($_GET)
     * - XỬ LÝ: Gọi Product Model để lấy dữ liệu theo điều kiện lọc
     * - TRẢ VỀ: Giao diện sanpham.php với dữ liệu sản phẩm đã lọc
     */
    public function index() {
        // =================================================================
        // BƯỚC 1: TIẾP NHẬN THAM SỐ TỪ URL ($_GET)
        // =================================================================
        // Các tham số tìm kiếm và lọc nâng cao
        $keyword     = isset($_GET['search']) ? trim($_GET['search']) : '';
        $categoryId  = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $priceMin    = isset($_GET['price_min']) ? (float)$_GET['price_min'] : null;
        $priceMax    = isset($_GET['price_max']) ? (float)$_GET['price_max'] : null;
        $brand       = isset($_GET['brand']) ? trim($_GET['brand']) : null;
        $inStock     = isset($_GET['in_stock']) ? (int)$_GET['in_stock'] : null;
        $isRentable  = isset($_GET['is_rentable']) ? (int)$_GET['is_rentable'] : null;
        $page        = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Đảm bảo page luôn >= 1 (tránh lỗi offset âm)
        if ($page < 1) $page = 1;

        // =================================================================
        // BƯỚC 2: CẤU HÌNH PHÂN TRANG / INFINITE SCROLL
        // =================================================================
        // Mỗi lần load (phân trang hoặc infinite scroll) sẽ hiển thị 12 sản phẩm
        // Lý do: Vì layout mới có card lớn hơn nên 12 là con số hợp lý
        $limit = 12;
        // Công thức tính offset: (trang - 1) * số sản phẩm mỗi trang
        $offset = ($page - 1) * $limit;

        // =================================================================
        // BƯỚC 3: KHỞI TẠO MODELS
        // =================================================================
        // Product Model: Dùng để truy vấn sản phẩm với bộ lọc
        $productModel = new Product();
        // Category Model: Dùng để lấy danh sách danh mục (hiển thị sidebar)
        $categoryModel = new Category();

        // =================================================================
        // BƯỚC 4: LẤY DỮ LIỆU TỪ DATABASE
        // =================================================================
        // Lấy danh sách danh mục để hiển thị sidebar lọc
        $categories = $categoryModel->getAll();

        // Lấy danh sách thương hiệu để hiển thị trong bộ lọc
        $brands = $productModel->getAllBrands();

        // Lấy danh sách sản phẩm đã lọc theo tất cả điều kiện
        // Hàm getFilteredProducts sẽ tự động xây dựng câu SQL động
        $products = $productModel->getFilteredProducts(
            $keyword,       // Từ khóa tìm kiếm
            $categoryId,     // ID danh mục
            $priceMin,       // Giá tối thiểu
            $priceMax,       // Giá tối đa
            $brand,          // Thương hiệu
            $inStock,        // Chỉ còn hàng (1) hoặc tất cả (null)
            $isRentable,     // Chỉ sản phẩm cho thuê (1)
            $limit,          // Số sản phẩm mỗi lần load
            $offset          // Vị trí bắt đầu
        );

        // Đếm tổng số sản phẩm thỏa điều kiện lọc (để tính tổng trang)
        $totalProducts = $productModel->getTotalProducts(
            $keyword,
            $categoryId,
            $priceMin,
            $priceMax,
            $brand,
            $inStock,
            $isRentable
        );

        // =================================================================
        // BƯỚC 5: TÍNH TOÁN PHÂN TRANG
        // =================================================================
        // Ví dụ: 25 sản phẩm / 12 mỗi trang = 2.08 => làm tròn lên = 3 trang
        $totalPages = ceil($totalProducts / $limit);

        // =================================================================
        // BƯỚC 6: ĐÓNG GÓI DỮ LIỆU VÀ TRUYỀN RA VIEW
        // =================================================================
        // Tất cả dữ liệu được đặt trong mảng $data để truyền cho View
        $data = [
            // Tiêu đề trang
            'pageTitle' => 'Cửa Hàng Nhạc Cụ - TTB Music',

            // Dữ liệu danh mục (sidebar)
            'categories' => $categories,

            // Danh sách thương hiệu (bộ lọc)
            'brands' => $brands,

            // Danh sách sản phẩm đã lọc
            'products' => $products,

            // Thông tin phân trang
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'totalProducts' => $totalProducts,

            // Giữ lại các tham số lọc hiện tại (để giử trạng thái lọc)
            'currentKeyword' => $keyword,
            'currentCategory' => $categoryId,
            'currentPriceMin' => $priceMin,
            'currentPriceMax' => $priceMax,
            'currentBrand' => $brand,
            'currentInStock' => $inStock,
            'currentIsRentable' => $isRentable
        ];

        // =================================================================
        // BƯỚC 7: RENDER VIEW
        // =================================================================
        // Gọi hàm render() từ BaseController để load file sanpham.php
        $this->render('sanpham', $data);
    }

    /**
     * ACTION: detail (Hiển thị chi tiết một sản phẩm)
     * - TIẾP NHẬN: ID sản phẩm từ URL ($_GET['id'])
     * - TRẢ VỀ: Giao diện chi tiết sản phẩm
     */
    public function detail() {
        $productModel = new Product();
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $product = $productModel->getById($productId);

        if (!$product) {
            die("Sản phẩm không tồn tại!");
        }

        $data = [
            'pageTitle' => $product['name'] . ' - TTB Music',
            'product' => $product
        ];

        $this->render('product_detail', $data);
    }
}
?>