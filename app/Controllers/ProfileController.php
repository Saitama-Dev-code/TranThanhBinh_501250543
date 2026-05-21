<?php
// Đường dẫn file: app/Controllers/ProfileController.php

require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/Order.php';

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

        // 3. Render ra giao diện Profile
        $this->render('profile', [
            'pageTitle' => 'Quản lý Tài khoản - TTB Music',
            'user' => $user,
            'orders' => $orders
        ]);
    }
}
?>
