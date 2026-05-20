<?php
/**
 * =========================================================================
 * CLASS: CartController
 * MỤC ĐÍCH: Quản lý giỏ hàng lưu trong PHP Session.
 *   - Không cần bảng DB riêng cho giỏ hàng.
 *   - $_SESSION['cart'] là mảng các sản phẩm đã thêm.
 *   - Mỗi item có: product_id, name, price, image, quantity, color, version.
 *
 * CÁC ACTION:
 *   index()  → Hiển thị trang giỏ hàng (cart.php)
 *   add()    → AJAX: Thêm 1 sản phẩm vào giỏ (POST JSON)
 *   update() → AJAX: Cập nhật số lượng sản phẩm (POST JSON)
 *   remove() → AJAX: Xóa 1 sản phẩm khỏi giỏ (POST JSON)
 *   count()  → AJAX: Trả về tổng số lượng sản phẩm trong giỏ (GET JSON)
 *
 * CÁCH GỌI:
 *   index.php?controller=cart&action=index   → Trang giỏ hàng
 *   index.php?controller=cart&action=add     → AJAX thêm SP
 *   index.php?controller=cart&action=update  → AJAX cập nhật SL
 *   index.php?controller=cart&action=remove  → AJAX xóa SP
 *   index.php?controller=cart&action=count   → AJAX đếm SP
 * =========================================================================
 */

require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/Product.php';

class CartController extends BaseController {

    /**
     * ACTION: index
     * Hiển thị trang giỏ hàng với danh sách sản phẩm đã thêm.
     * Tính tổng tiền và số lượng từ $_SESSION['cart'].
     */
    public function index() {
        // Khởi tạo giỏ hàng nếu chưa có trong session
        // $_SESSION['cart'] = [ 'cart_key' => [...item data...], ... ]
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Lấy danh sách items từ session để hiển thị
        $cartItems = $_SESSION['cart'];

        // Tính tổng tiền: cộng price * quantity của từng item
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Tính tổng số lượng sản phẩm (dùng cho badge navbar)
        $totalQty = array_sum(array_column($cartItems, 'quantity'));

        // Đẩy dữ liệu ra view cart.php
        $this->render('cart', [
            'pageTitle'   => 'Giỏ hàng – TTB Music',
            'cartItems'   => $cartItems,
            'totalAmount' => $totalAmount,
            'totalQty'    => $totalQty,
        ]);
    }

    /**
     * ACTION: add (AJAX - POST)
     * Thêm sản phẩm vào giỏ hàng.
     *
     * INPUT (JSON body hoặc POST form):
     *   product_id : int   – ID sản phẩm
     *   quantity   : int   – Số lượng muốn thêm (mặc định 1)
     *   color      : string – Màu đã chọn (nếu có)
     *   version    : string – Phiên bản đã chọn (nếu có)
     *
     * OUTPUT (JSON):
     *   { "success": true, "cart_count": 3, "message": "Đã thêm vào giỏ!" }
     *   hoặc { "success": false, "message": "Lỗi..." }
     */
    public function add() {
        // Đặt header JSON để trình duyệt biết đây là API response
        header('Content-Type: application/json; charset=utf-8');

        // Chỉ cho phép POST method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
            exit;
        }

        // Đọc dữ liệu gửi lên:
        // Hỗ trợ cả JSON body (fetch API) và form POST (form submit thông thường)
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            // Fallback: dùng $_POST nếu không phải JSON
            $input = $_POST;
        }

        // Lấy và validate product_id
        $productId = isset($input['product_id']) ? (int)$input['product_id'] : 0;
        if ($productId <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ.']);
            exit;
        }

        // Số lượng muốn thêm (tối thiểu 1)
        $qty     = max(1, (int)($input['quantity'] ?? 1));
        // Màu và phiên bản đã chọn (nếu có)
        $color   = trim($input['color']   ?? '');
        $version = trim($input['version'] ?? '');

        // Lấy thông tin sản phẩm từ DB để có tên, giá, ảnh, tồn kho
        $productModel = new Product();
        $product = $productModel->getById($productId);

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
            exit;
        }

        // Kiểm tra tồn kho
        if ($product['stock'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm đã hết hàng.']);
            exit;
        }

        // Tạo "cart key" duy nhất cho từng sản phẩm + biến thể
        // Nếu cùng SP nhưng khác màu/version → key khác nhau → item riêng biệt
        // VD: "12_do_standard" hoặc "12__" nếu không chọn biến thể
        $cartKey = $productId . '_' . $color . '_' . $version;

        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$cartKey])) {
            // Nếu sản phẩm (cùng biến thể) đã có trong giỏ → tăng số lượng
            $newQty = $_SESSION['cart'][$cartKey]['quantity'] + $qty;
            // Giới hạn không vượt quá tồn kho
            $_SESSION['cart'][$cartKey]['quantity'] = min($newQty, $product['stock']);
        } else {
            // Sản phẩm chưa có trong giỏ → thêm mới
            $_SESSION['cart'][$cartKey] = [
                'product_id' => $productId,
                'name'       => $product['name'],
                'price'      => (float)$product['price'],
                'image'      => $product['image'] ?? '',
                'quantity'   => min($qty, $product['stock']),
                'stock'      => (int)$product['stock'],
                'color'      => $color,
                'version'    => $version,
                'cart_key'   => $cartKey,
            ];
        }

        // Tính tổng số lượng sản phẩm trong giỏ (tất cả items)
        $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));

        echo json_encode([
            'success'    => true,
            'message'    => 'Đã thêm "' . htmlspecialchars($product['name']) . '" vào giỏ hàng!',
            'cart_count' => $cartCount,
        ]);
        exit;
    }

    /**
     * ACTION: update (AJAX - POST)
     * Cập nhật số lượng của một sản phẩm trong giỏ.
     *
     * INPUT (JSON):
     *   cart_key : string – Key duy nhất của item trong giỏ
     *   quantity : int    – Số lượng mới (nếu = 0 → xóa item)
     *
     * OUTPUT (JSON):
     *   { "success": true, "cart_count": 2, "item_total": 500000, "grand_total": 1200000 }
     */
    public function update() {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

        $cartKey = $input['cart_key'] ?? '';
        $qty     = (int)($input['quantity'] ?? 0);

        if (empty($cartKey) || !isset($_SESSION['cart'][$cartKey])) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm trong giỏ.']);
            exit;
        }

        if ($qty <= 0) {
            // Số lượng = 0 → xóa item khỏi giỏ
            unset($_SESSION['cart'][$cartKey]);
        } else {
            // Giới hạn số lượng không vượt tồn kho
            $maxStock = $_SESSION['cart'][$cartKey]['stock'];
            $_SESSION['cart'][$cartKey]['quantity'] = min($qty, $maxStock);
        }

        // Tính lại tổng tiền của item và toàn giỏ
        $itemTotal  = 0;
        $grandTotal = 0;
        if (isset($_SESSION['cart'][$cartKey])) {
            $itemTotal = $_SESSION['cart'][$cartKey]['price'] * $_SESSION['cart'][$cartKey]['quantity'];
        }
        foreach ($_SESSION['cart'] as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }

        $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));

        echo json_encode([
            'success'     => true,
            'cart_count'  => $cartCount,
            'item_total'  => $itemTotal,
            'grand_total' => $grandTotal,
            'removed'     => ($qty <= 0),
        ]);
        exit;
    }

    /**
     * ACTION: remove (AJAX - POST)
     * Xóa hoàn toàn một item khỏi giỏ hàng.
     *
     * INPUT (JSON):
     *   cart_key : string – Key của item cần xóa
     *
     * OUTPUT (JSON):
     *   { "success": true, "cart_count": 1, "grand_total": 800000 }
     */
    public function remove() {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
            exit;
        }

        $input   = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $cartKey = $input['cart_key'] ?? '';

        if (!empty($cartKey) && isset($_SESSION['cart'][$cartKey])) {
            unset($_SESSION['cart'][$cartKey]);
        }

        // Tính lại tổng
        $grandTotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }
        $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));

        echo json_encode([
            'success'     => true,
            'cart_count'  => $cartCount,
            'grand_total' => $grandTotal,
        ]);
        exit;
    }

    /**
     * ACTION: count (AJAX - GET)
     * Trả về tổng số lượng sản phẩm trong giỏ.
     * Dùng để cập nhật badge navbar khi load trang.
     *
     * OUTPUT (JSON):
     *   { "count": 5 }
     */
    public function count() {
        header('Content-Type: application/json; charset=utf-8');

        $count = 0;
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            $count = array_sum(array_column($_SESSION['cart'], 'quantity'));
        }

        echo json_encode(['count' => $count]);
        exit;
    }
}
?>
