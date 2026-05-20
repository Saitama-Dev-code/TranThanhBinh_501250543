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

        // BỔ SUNG: Lấy biến thể cho từng sản phẩm
        if ($products) {
            foreach ($products as &$p) {
                $p['variants'] = $productModel->getVariantsByProductId($p['id']);
            }
        }

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
     * ACTION: detail (Hiển thị trang chi tiết một sản phẩm)
     *
     * LUỒNG XỬ LÝ:
     *   URL: index.php?controller=product&action=detail&id=5
     *   1. Lấy ID từ URL → kiểm tra hợp lệ
     *   2. Truy vấn DB lấy thông tin sản phẩm kèm tên danh mục
     *   3. Lấy biến thể (màu sắc & phiên bản) từ bảng product_variants
     *   4. Đóng gói data → render view product_detail.php
     */
    public function detail() {
        // =================================================================
        // BƯỚC 1: LẤY VÀ KIỂM TRA ID SẢN PHẨM TỪ URL
        // =================================================================
        // (int) ép kiểu về số nguyên → tránh SQL Injection ngay từ đầu
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // ID không hợp lệ (0 hoặc âm) → không cần truy vấn DB
        if ($productId <= 0) {
            header('Location: index.php?controller=product&action=index');
            exit;
        }

        // =================================================================
        // BƯỚC 2: KHỞI TẠO MODEL VÀ LẤY THÔNG TIN SẢN PHẨM
        // =================================================================
        $productModel  = new Product();
        $categoryModel = new Category();

        // Lấy thông tin sản phẩm kèm tên danh mục (JOIN trong Model)
        $product = $productModel->getByIdWithCategory($productId);

        // Nếu không tìm thấy sản phẩm → trả về trang lỗi thân thiện
        if (!$product) {
            // Đặt HTTP status 404 để SEO hiểu đây là trang không tồn tại
            http_response_code(404);
            die("<div style='text-align:center;padding:100px;font-family:sans-serif;'>
                    <h2>😕 Sản phẩm không tồn tại</h2>
                    <p>Sản phẩm có thể đã bị xóa hoặc ID không hợp lệ.</p>
                    <a href='index.php?controller=product&action=index'
                       style='color:#8b5cf6;'>← Quay về cửa hàng</a>
                 </div>");
        }

        // =================================================================
        // BƯỚC 3: LẤY BIẾN THỂ (MÀU SẮC & PHIÊN BẢN) TỪ DB
        // =================================================================
        // getVariantsByProductId trả về mảng ['colors' => [...], 'versions' => [...]]
        $variants = $productModel->getVariantsByProductId($productId);

        // Tách riêng để View dùng dễ hơn: $colors, $versions
        $colors   = $variants['colors'];
        $versions = $variants['versions'];

        // =================================================================
        // BƯỚC 4: ĐÓNG GÓI DATA VÀ RENDER VIEW
        // =================================================================
        $data = [
            // Tiêu đề tab trình duyệt: "Tên SP - TTB Music"
            'pageTitle' => htmlspecialchars($product['name']) . ' - TTB Music',

            // Toàn bộ thông tin sản phẩm (kèm category_name từ JOIN)
            'product'   => $product,

            // Mảng biến thể màu sắc (dùng trong gallery thumbnail + chọn màu)
            'colors'    => $colors,

            // Mảng phiên bản (Standard, Premium...)
            'versions'  => $versions,
        ];

        // Gọi BaseController::render() → load file app/Views/product_detail.php
        // $data sẽ được extract() thành các biến trong View:
        //   $pageTitle, $product, $colors, $versions
        $this->render('product_detail', $data);
    }
}

?>