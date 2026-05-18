<?php
// Đường dẫn file: app/Controllers/AuthController.php

require_once ROOT_PATH . '/core/BaseController.php';

class AuthController extends BaseController {
    
    // =========================================================================
    // HÀM KIỂM TRA BẢO MẬT (CSRF)
    // - Được gọi ở đầu các hàm xử lý form (POST) để chống tấn công giả mạo form
    // - So sánh token gửi lên từ form với token đang lưu trong phiên làm việc
    // =========================================================================
    private function verifyCSRF() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                // Nếu sai token, dừng thực thi toàn bộ luồng và in ra lỗi
                die("<h2 style='color:red; text-align:center; margin-top:50px;'>Lỗi bảo mật: Token CSRF không hợp lệ hoặc đã hết hạn! Vui lòng quay lại và thử lại.</h2>");
            }
        }
    }

    // =========================================================================
    // ĐIỀU HƯỚNG GIAO DIỆN
    // - Chỉ có tác dụng gọi ra các file giao diện (.php) trong thư mục Views
    // =========================================================================
    public function register() {
        $this->render('register', ['pageTitle' => 'Đăng ký tài khoản - TTB Music']);
    }

    public function forgot() {
        $this->render('forgot', ['pageTitle' => 'Khôi phục mật khẩu - TTB Music']);
    }

    // =========================================================================
    // XỬ LÝ DỮ LIỆU ĐĂNG KÝ
    // =========================================================================
    public function registerSubmit() {
        $this->verifyCSRF(); // Bước 1: Kiểm tra bảo mật form
        
        // Bước 2: Lấy dữ liệu người dùng nhập (Toán tử ?? '' chống lỗi khi người dùng không nhập)
        $fullname = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Bước 3: Mã hóa mật khẩu bằng thuật toán Bcrypt (Chống lộ mật khẩu thật nếu DB bị hack)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // TODO: Mở comment phần dưới khi kết nối Database
        // $userModel = new User();
        // $userModel->insert(['full_name' => $fullname, 'email' => $email, 'password' => $hashedPassword, 'role' => 0]);
        
        echo "<h2 style='color:white; text-align:center; margin-top:50px;'>Đăng ký thành công! Mật khẩu đã được mã hóa Bcrypt: <br> <small>{$hashedPassword}</small></h2>";
    }

    // =========================================================================
    // XỬ LÝ DỮ LIỆU QUÊN MẬT KHẨU
    // =========================================================================
    public function forgotSubmit() {
        $this->verifyCSRF();
        
        $email = $_POST['email'] ?? '';
        
        // Tạo token ngẫu nhiên và thiết lập thời gian sống (30 phút)
        $resetToken = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        
        echo "<h2 style='color:white; text-align:center; margin-top:50px;'>Đã xử lý an toàn (Có CSRF).<br>Token phục hồi sẽ hết hạn vào: {$expires}</h2>";
    }

    // =========================================================================
    // XỬ LÝ DỮ LIỆU ĐĂNG NHẬP
    // =========================================================================
    public function loginSubmit() {
        $this->verifyCSRF();
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // TODO: Lấy hash từ DB và dùng hàm password_verify để kiểm tra xem mật khẩu có khớp không
        // $user = $userModel->getByEmail($email);
        // if ($user && password_verify($password, $user['password'])) {
        //     $_SESSION['user'] = $user;
        // } else { echo 'Sai email hoặc mật khẩu'; }
        
        echo "<h2 style='color:white; text-align:center; margin-top:50px;'>Đang xử lý kiểm tra tài khoản (Đã xác minh CSRF)...</h2>";
    }
}
?>