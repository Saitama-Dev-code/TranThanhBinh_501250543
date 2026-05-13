<?php
/**
 * =========================================================================
 * CLASS: ProductController (Kế thừa từ BaseController)
 * - MỤC ĐÍCH: Nhận yêu cầu từ URL, gọi Models lấy dữ liệu, tính toán toán học
 * (chia số trang), sau đó đẩy toàn bộ dữ liệu ra View hiển thị.
 * - ĐƯỜNG DẪN GỌI ĐẾN: index.php?controller=product&action=index
 * =========================================================================
 */
require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/Product.php';
require_once ROOT_PATH . '/app/Models/Category.php';

class ProductController extends BaseController {
    
    public function index() {
        // 1. Nhận các tham số từ thanh URL (nếu có) thông qua biến siêu toàn cục $_GET
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        if ($page < 1) $page = 1; // Đảm bảo trang luôn >= 1

        // 2. Thiết lập thông số phân trang theo đúng file README
        $limit = 6; // 6 sản phẩm/trang
        $offset = ($page - 1) * $limit; // Công thức tính vị trí bắt đầu lấy CSDL

        // 3. Khởi tạo Models
        $productModel = new Product();
        $categoryModel = new Category();

        // 4. Lấy dữ liệu từ Database
        $categories = $categoryModel->getAll();
        $products = $productModel->getFilteredProducts($keyword, $categoryId, $limit, $offset);
        $totalProducts = $productModel->getTotalProducts($keyword, $categoryId);

        // 5. Thuật toán tính tổng số trang (Ví dụ: 13 SP / 6 = 2.1 => làm tròn lên 3 trang)
        $totalPages = ceil($totalProducts / $limit);

        // 6. Đóng gói toàn bộ dữ liệu vào một mảng để truyền ra View
        $data = [
            'pageTitle' => 'Cửa Hàng Nhạc Cụ - TTB Music',
            'categories' => $categories,
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'currentKeyword' => $keyword,
            'currentCategory' => $categoryId
        ];

        // 7. Gọi hàm render (của BaseController) để load file app/Views/sanpham.php
        $this->render('sanpham', $data);
    }
}
?>