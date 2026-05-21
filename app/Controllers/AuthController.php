<?php
// Đường dẫn file: app/Controllers/AuthController.php

require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/User.php';

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
        
        // Bước 2: Lấy dữ liệu người dùng nhập
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Kiểm tra validation cơ bản
        if (empty($fullname) || empty($email) || empty($password)) {
            die("<h2 style='color:red; text-align:center; margin-top:50px;'>Vui lòng điền đầy đủ thông tin!</h2>");
        }

        $userModel = new User();
        
        // Kiểm tra email đã tồn tại chưa
        $existingUser = $userModel->getByEmail($email);
        if ($existingUser) {
            die("<h2 style='color:red; text-align:center; margin-top:50px;'>Email này đã được sử dụng! Vui lòng đăng nhập hoặc dùng email khác.</h2>");
        }

        // Bước 3: Mã hóa mật khẩu bằng thuật toán Bcrypt
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Lưu vào CSDL
        $success = $userModel->insert([
            'full_name' => $fullname, 
            'email' => $email, 
            'password' => $hashedPassword, 
            'role' => 0
        ]);
        
        if ($success) {
            // Chuyển hướng tới trang đăng nhập
            echo "<script>alert('Đăng ký thành công! Vui lòng đăng nhập.'); window.location.href='index.php?controller=auth&action=register';</script>";
        } else {
            echo "<h2 style='color:red; text-align:center; margin-top:50px;'>Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại!</h2>";
        }
    }

    // =========================================================================
    // XỬ LÝ DỮ LIỆU QUÊN MẬT KHẨU
    // =========================================================================
    public function forgotSubmit() {
        $this->verifyCSRF();
        
        $email = trim($_POST['email'] ?? '');
        
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
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            die("<h2 style='color:red; text-align:center; margin-top:50px;'>Vui lòng nhập Email và Mật khẩu!</h2>");
        }

        $userModel = new User();
        
        // Tìm User theo Email
        $user = $userModel->getByEmail($email);
        
        // Kiểm tra User tồn tại và khớp mật khẩu
        if ($user && password_verify($password, $user['password'])) {
            // Lưu session (chỉ lưu các thông tin an toàn, không lưu password)
            $_SESSION['user'] = [
                'id' => $user['id'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            
            // Chuyển hướng về trang chủ
            header('Location: index.php');
            exit;
        } else { 
            echo "<script>alert('Sai email hoặc mật khẩu!'); window.history.back();</script>";
        }
    }

    // =========================================================================
    // ĐĂNG XUẤT
    // =========================================================================
    public function logout() {
        // Hủy session đăng nhập
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        // Chuyển hướng về trang chủ
        header('Location: index.php');
        exit;
    }
}
?>