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

        // 2. Xác định User ID
        $userId = 0;
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
        } else {
            // Nếu là khách vãng lai, tự động tạo tài khoản nhanh dựa trên SĐT (mật khẩu mặc định là SĐT)
            $userModel = new User();
            // Email giả hoặc rỗng (bảng users thiết kế email DEFAULT NULL)
            $guestEmail = "guest_{$phone}@ttbmusic.com";
            $existing = $userModel->getByEmail($guestEmail);
            
            if ($existing) {
                $userId = $existing['id'];
            } else {
                $hashedPass = password_hash($phone, PASSWORD_DEFAULT);
                $userModel->insert([
                    'full_name' => $fullname,
                    'email' => $guestEmail,
                    'password' => $hashedPass,
                    'phone' => $phone,
                    'address' => $address,
                    'role' => 0
                ]);
                // Lấy ID vừa tạo (Cần thêm hàm getLastInsertId trong BaseModel, hoặc query lại)
                // Vì BaseModel chưa có getLastInsertId cho insert, ta đành query lại
                $newGuest = $userModel->getByEmail($guestEmail);
                $userId = $newGuest['id'];
            }
        }

        // 3. Tính tổng tiền
        $cartItems = $_SESSION['cart'];
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Nối thêm ghi chú vào địa chỉ nếu có
        $fullAddress = $address;
        if (!empty($notes)) {
            $fullAddress .= " | Ghi chú: " . $notes;
        }

        // 4. Khởi tạo Đơn hàng (Bảng orders)
        $orderModel = new Order();
        $orderId = $orderModel->createOrder($userId, $totalPrice, $fullAddress, $phone);

        if ($orderId) {
            // 5. Lưu Chi tiết Đơn hàng (Bảng order_details)
            $orderDetailModel = new OrderDetail();
            $success = $orderDetailModel->insertDetails($orderId, $cartItems);

            if ($success) {
                // 6. Xóa giỏ hàng
                unset($_SESSION['cart']);
                
                // Hiển thị thông báo thành công (Có thể render view success riêng)
                echo "<div style='text-align:center; padding: 100px; font-family: sans-serif;'>
                        <h1 style='color: #10b981;'>Đặt hàng thành công!</h1>
                        <p>Mã đơn hàng của bạn là: <strong>#TTB{$orderId}</strong></p>
                        <p>Chúng tôi sẽ sớm liên hệ với bạn qua số điện thoại <strong>{$phone}</strong> để xác nhận.</p>
                        <br><br>
                        <a href='index.php' style='padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 5px;'>Quay lại trang chủ</a>
                      </div>";
                exit;
            }
        }
        
        die("<h2 style='color:red; text-align:center;'>Có lỗi xảy ra khi xử lý đơn hàng. Vui lòng thử lại!</h2>");
    }
}
?>
