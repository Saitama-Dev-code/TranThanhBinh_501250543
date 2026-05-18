<?php
// Đường dẫn file: app/Controllers/AuthController.php

require_once ROOT_PATH . '/core/BaseController.php';

class AuthController extends BaseController {
    
    // Kiểm tra CSRF Token chung
    private function verifyCSRF() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("<h2 style='color:red; text-align:center; margin-top:50px;'>Lỗi bảo mật: Token CSRF không hợp lệ hoặc đã hết hạn! Vui lòng quay lại và thử lại.</h2>");
            }
        }
    }

    // Hàm điều hướng sang giao diện trang Đăng Ký
    public function register() {
        $this->render('register', ['pageTitle' => 'Đăng ký tài khoản - TTB Music']);
    }

    // Xử lý submit form Đăng Ký
    public function registerSubmit() {
        $this->verifyCSRF();
        
        $fullname = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Hash mật khẩu bằng Bcrypt chống lộ mật khẩu thật
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // TODO: Gọi Model lưu vào Database
        // $userModel = new User();
        // $userModel->insert(['full_name' => $fullname, 'email' => $email, 'password' => $hashedPassword, 'role' => 0]);
        
        echo "<h2 style='color:white; text-align:center; margin-top:50px;'>Đăng ký thành công! Mật khẩu đã được mã hóa Bcrypt: <br> <small>{$hashedPassword}</small></h2>";
    }

    // Hàm điều hướng sang giao diện trang Quên Mật Khẩu
    public function forgot() {
        $this->render('forgot', ['pageTitle' => 'Khôi phục mật khẩu - TTB Music']);
    }

    // Xử lý submit form Quên Mật Khẩu
    public function forgotSubmit() {
        $this->verifyCSRF();
        
        $email = $_POST['email'] ?? '';
        
        // TODO: Tạo reset_token và lưu kèm hạn sử dụng (reset_token_expires) vào Database
        $resetToken = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        
        echo "<h2 style='color:white; text-align:center; margin-top:50px;'>Đã xử lý an toàn (Có CSRF).<br>Token phục hồi sẽ hết hạn vào: {$expires}</h2>";
    }

    // Hàm xử lý submit form Đăng nhập
    public function loginSubmit() {
        $this->verifyCSRF();
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // TODO: Lấy hash từ DB và dùng password_verify
        // $user = $userModel->getByEmail($email);
        // if ($user && password_verify($password, $user['password'])) {
        //     $_SESSION['user'] = $user;
        // } else { echo 'Sai email hoặc mật khẩu'; }
        
        echo "<h2 style='color:white; text-align:center; margin-top:50px;'>Đang xử lý kiểm tra tài khoản (Đã xác minh CSRF)...</h2>";
    }
}
?>