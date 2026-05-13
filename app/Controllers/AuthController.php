<?php
// Đường dẫn file: app/Controllers/AuthController.php

require_once ROOT_PATH . '/core/BaseController.php';

class AuthController extends BaseController {
    
    // Hàm xử lý khi người dùng submit form đăng nhập ở Modal
    public function login() {
        // Tạm thời hiển thị text để test luồng, sau này sẽ viết code check Database ở đây
        echo "<h2 style='color:white; text-align:center; margin-top:50px;'>Đang xử lý kiểm tra tài khoản trong Database...</h2>";
    }

    // Hàm điều hướng sang giao diện trang Đăng Ký
    public function register() {
        $data = [
            'pageTitle' => 'Đăng ký tài khoản - TTB Music'
        ];
        // Gọi file app/Views/register.php
        $this->render('register', $data);
    }

    // Hàm điều hướng sang giao diện trang Quên Mật Khẩu
    public function forgot() {
        $data = [
            'pageTitle' => 'Khôi phục mật khẩu - TTB Music'
        ];
        // Gọi file app/Views/forgot.php
        $this->render('forgot', $data);
    }
}
?>