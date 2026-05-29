<?php
// Đường dẫn file: app/Controllers/CheckoutController.php

require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/Order.php';
require_once ROOT_PATH . '/app/Models/OrderDetail.php';
require_once ROOT_PATH . '/app/Models/User.php';

class CheckoutController extends BaseController {

    // Hiển thị trang Checkout
    public function index() {
        // Kiểm tra nếu giỏ hàng rỗng thì đẩy về trang Giỏ hàng
        if (empty($_SESSION['cart'])) {
            header('Location: index.php?controller=cart&action=index');
            exit;
        }

        $cartItems = $_SESSION['cart'];
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Lấy thông tin user nếu đã đăng nhập
        $user = $_SESSION['user'] ?? null;
        if ($user) {
            // Lấy thêm thông tin SĐT và địa chỉ từ DB để tự điền form
            $userModel = new User();
            $userInfo = $userModel->getById($user['id']);
            $user = array_merge($user, $userInfo);
        }

        $this->render('checkout', [
            'pageTitle' => 'Thanh toán - TTB Music',
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'user' => $user
        ]);
    }

    // Xử lý luồng đặt hàng khi submit form
    public function process() {
        // 0. Xác thực bảo mật CSRF
        $this->verifyCSRF();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid Request");
        }

        // Nếu giỏ rỗng thì thoát
        if (empty($_SESSION['cart'])) {
            header('Location: index.php?controller=cart&action=index');
            exit;
        }

        // 1. Lấy dữ liệu từ form Checkout
        $fullname = trim($_POST['fullname'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        if (empty($fullname) || empty($phone) || empty($address)) {
            die("<h2 style='color:red; text-align:center;'>Vui lòng nhập đầy đủ thông tin giao hàng!</h2>");
        }

        $productModel = new Product();
        $cartItems = $_SESSION['cart'];

        // 1b. Kiểm tra hàng tồn kho trước khi thanh toán
        foreach ($cartItems as $item) {
            $prod = $productModel->getById($item['id']);
            if (!$prod) {
                die("<h2 style='color:red; text-align:center;'>Sản phẩm không tồn tại trong hệ thống!</h2>");
            }
            if ($prod['stock'] < $item['quantity']) {
                die("<h2 style='color:red; text-align:center;'>Sản phẩm \"" . htmlspecialchars($prod['name']) . "\" chỉ còn " . $prod['stock'] . " sản phẩm trong kho. Vui lòng quay lại giỏ hàng và cập nhật số lượng!</h2>");
            }
        }

        // 2. Thực hiện luồng lưu dữ liệu bọc trong Database Transaction
        $db = Database::getInstance()->getConnection();
        $db->beginTransaction();

        try {
            // Xác định User ID hoặc đăng ký khách vãng lai
            $userId = 0;
            $generatedPassword = null;
            $userModel = new User();

            if (isset($_SESSION['user'])) {
                $userId = $_SESSION['user']['id'];
            } else {
                // Khách vãng lai: Tạo tài khoản với email giả và mật khẩu ngẫu nhiên
                $guestEmail = "guest_{$phone}@ttbmusic.com";
                $existing = $userModel->getByEmail($guestEmail);
                
                if ($existing) {
                    $userId = $existing['id'];
                } else {
                    // Sinh mật khẩu ngẫu nhiên dài 8 ký tự
                    $generatedPassword = substr(bin2hex(random_bytes(4)), 0, 8);
                    $hashedPass = password_hash($generatedPassword, PASSWORD_DEFAULT);
                    $userModel->insert([
                        'full_name' => $fullname,
                        'email' => $guestEmail,
                        'password' => $hashedPass,
                        'phone' => $phone,
                        'address' => $address,
                        'role' => 0
                    ]);
                    
                    $newGuest = $userModel->getByEmail($guestEmail);
                    $userId = $newGuest['id'];
                }
            }

            // Tính tổng tiền
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            // Gộp ghi chú vào địa chỉ giao hàng
            $fullAddress = $address;
            if (!empty($notes)) {
                $fullAddress .= " | Ghi chú: " . $notes;
            }

            // Tạo đơn hàng
            $orderModel = new Order();
            $orderId = $orderModel->createOrder($userId, $totalPrice, $fullAddress, $phone);

            if (!$orderId) {
                throw new Exception("Không thể lưu đơn hàng vào hệ thống.");
            }

            // Lưu chi tiết đơn hàng
            $orderDetailModel = new OrderDetail();
            $orderDetailModel->insertDetails($orderId, $cartItems);

            // Cập nhật giảm số lượng tồn kho sản phẩm
            foreach ($cartItems as $item) {
                $productModel->deductStock($item['id'], $item['quantity']);
            }

            // Lưu thay đổi vào DB
            $db->commit();

            // Xóa giỏ hàng
            unset($_SESSION['cart']);

            // Hiển thị giao diện đặt hàng thành công bảo mật XSS
            $escFullname = htmlspecialchars($fullname);
            $escPhone = htmlspecialchars($phone);
            $escOrderId = htmlspecialchars($orderId);

            echo "<div style='text-align:center; padding: 100px; font-family: sans-serif; background: #0f172a; color: #f1f5f9; min-height: 100vh;'>
                    <div style='max-width: 600px; margin: 0 auto; background: #1e293b; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 1px solid #334155;'>
                        <h1 style='color: #10b981; margin-bottom: 20px;'>Đặt hàng thành công!</h1>
                        <p style='font-size: 1.1rem;'>Xin chào <strong>{$escFullname}</strong>,</p>
                        <p style='font-size: 1.1rem;'>Mã đơn hàng của bạn là: <strong style='color: #3b82f6;'>#TTB{$escOrderId}</strong></p>
                        <p>Chúng tôi sẽ sớm liên hệ với bạn qua số điện thoại <strong>{$escPhone}</strong> để xác nhận giao hàng.</p>";
                        
            if ($generatedPassword !== null) {
                $escEmail = htmlspecialchars($guestEmail);
                $escPass = htmlspecialchars($generatedPassword);
                echo "  <div style='background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); padding: 15px; border-radius: 10px; margin: 20px 0; text-align: left;'>
                            <h5 style='color: #3b82f6; margin-top: 0;'>Tài khoản khách vãng lai của bạn:</h5>
                            <p style='margin: 5px 0;'><strong>Tên đăng nhập (Email):</strong> {$escEmail}</p>
                            <p style='margin: 5px 0;'><strong>Mật khẩu ngẫu nhiên:</strong> <span style='background: #3b82f6; color: #fff; padding: 2px 6px; border-radius: 4px; font-family: monospace;'>{$escPass}</span></p>
                            <p style='font-size: 0.85rem; color: #94a3b8; margin-bottom: 0;'>* Hãy lưu lại thông tin này để đăng nhập và theo dõi đơn hàng sau này.</p>
                        </div>";
            }
            
            echo "      <br><br>
                        <a href='index.php' style='padding: 12px 30px; background: linear-gradient(135deg, #3b82f6, #60a5fa); color: white; text-decoration: none; border-radius: 10px; font-weight: bold; transition: all 0.3s;'>Quay lại trang chủ</a>
                    </div>
                  </div>";
            exit;

        } catch (Exception $e) {
            // Hủy toàn bộ thay đổi nếu có bất kỳ lỗi nào xảy ra
            $db->rollBack();
            die("<h2 style='color:red; text-align:center; margin-top:50px;'>Có lỗi xảy ra khi xử lý đơn hàng: " . htmlspecialchars($e->getMessage()) . ". Vui lòng thử lại!</h2>");
        }
    }
}
?>
