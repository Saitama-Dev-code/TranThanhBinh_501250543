<?php
// Đường dẫn file: app/Controllers/ProfileController.php

require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/Order.php';
require_once ROOT_PATH . '/app/Models/Rental.php';

class ProfileController extends BaseController {

    // Hiển thị trang Quản lý tài khoản
    public function index() {
        // 1. Yêu cầu đăng nhập: Nếu chưa đăng nhập thì chuyển hướng về trang Login
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $user = $_SESSION['user'];

        // 2. Khởi tạo Order Model để lấy danh sách lịch sử mua hàng của user này
        $orderModel = new Order();
        $orders = $orderModel->getOrdersByUser($user['id']);

        // 3. Khởi tạo Rental Model để lấy danh sách hợp đồng thuê của user này
        $rentalModel = new Rental();
        $rentals = $rentalModel->getRentalsByUser($user['id']);

        // 4. Render ra giao diện Profile
        $this->render('profile', [
            'pageTitle' => 'Quản lý Tài khoản - TTB Music',
            'user' => $user,
            'orders' => $orders,
            'rentals' => $rentals
        ]);
    }

    // AJAX Cập nhật thông tin cá nhân
    public function updateInfo() {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Bạn chưa đăng nhập!'
            ]);
            exit;
        }

        // Lấy dữ liệu từ FormData (POST)
        $fullName = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';

        if (empty($fullName)) {
            echo json_encode([
                'success' => false,
                'message' => 'Họ và tên không được để trống!'
            ]);
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $userModel = new User();

        // Tiến hành cập nhật
        $success = $userModel->update($userId, [
            'full_name' => $fullName,
            'phone' => $phone,
            'address' => $address
        ]);

        if ($success) {
            // Cập nhật lại session
            $_SESSION['user']['full_name'] = $fullName;
            
            echo json_encode([
                'success' => true,
                'message' => 'Cập nhật thông tin cá nhân thành công!',
                'user' => [
                    'full_name' => $fullName,
                    'phone' => $phone,
                    'address' => $address
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu thông tin. Vui lòng thử lại!'
            ]);
        }
        exit;
    }
}
?>
