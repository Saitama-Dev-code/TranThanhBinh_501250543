<?php
// Đường dẫn file: app/Controllers/AuthController.php

require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/User.php';

class AuthController extends BaseController {
    


    // =========================================================================
    // ĐIỀU HƯỚNG GIAO DIỆN
    // - Chỉ có tác dụng gọi ra các file giao diện (.php) trong thư mục Views
    // =========================================================================
    public function login() {
        $_SESSION['open_login_modal'] = true;
        header('Location: index.php');
        exit;
    }

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
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        $isAjax = isset($_GET['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');

        // Lưu tạm thông tin để điền lại vào form nếu có lỗi
        $_SESSION['auth_fullname'] = $fullname;
        $_SESSION['auth_email'] = $email;
        
        // Kiểm tra validation cơ bản
        if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {
            $msg = "Vui lòng điền đầy đủ thông tin!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            $_SESSION['auth_error'] = $msg;
            header('Location: index.php?controller=auth&action=register');
            exit;
        }

        // Kiểm tra định dạng email hợp lệ
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Định dạng Email không hợp lệ!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            $_SESSION['auth_error'] = $msg;
            header('Location: index.php?controller=auth&action=register');
            exit;
        }

        // Kiểm tra độ dài mật khẩu (tối thiểu 6 ký tự)
        if (strlen($password) < 6) {
            $msg = "Mật khẩu phải có độ dài tối thiểu 6 ký tự!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            $_SESSION['auth_error'] = $msg;
            header('Location: index.php?controller=auth&action=register');
            exit;
        }

        // Kiểm tra mật khẩu khớp nhau
        if ($password !== $confirmPassword) {
            $msg = "Mật khẩu xác nhận không khớp!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            $_SESSION['auth_error'] = $msg;
            header('Location: index.php?controller=auth&action=register');
            exit;
        }

        $userModel = new User();
        
        // Kiểm tra email đã tồn tại chưa
        $existingUser = $userModel->getByEmail($email);
        if ($existingUser) {
            $msg = "Email này đã được sử dụng! Vui lòng sử dụng email khác.";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            $_SESSION['auth_error'] = $msg;
            header('Location: index.php?controller=auth&action=register');
            exit;
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
            // Lấy lại user vừa tạo để tự động đăng nhập
            $newUser = $userModel->getByEmail($email);
            if ($newUser) {
                $_SESSION['user'] = [
                    'id' => $newUser['id'],
                    'full_name' => $newUser['full_name'],
                    'email' => $newUser['email'],
                    'role' => $newUser['role']
                ];
            }
            
            // Xóa session tạm
            unset($_SESSION['auth_fullname'], $_SESSION['auth_email'], $_SESSION['auth_error']);
            
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'user' => $_SESSION['user']
                ]);
                exit;
            }

            // Chuyển hướng thẳng tới trang chủ
            header('Location: index.php');
            exit;
        } else {
            $msg = "Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            $_SESSION['auth_error'] = $msg;
            header('Location: index.php?controller=auth&action=register');
            exit;
        }
    }

    // =========================================================================
    // XỬ LÝ DỮ LIỆU QUÊN MẬT KHẨU (AJAX OTP)
    // =========================================================================
    public function forgotSubmit() {
        $this->verifyCSRF();
        
        $email = trim($_POST['email'] ?? '');
        $isAjax = isset($_GET['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
        
        if (empty($email)) {
            $msg = "Vui lòng nhập Email!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            die($msg);
        }

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if (!$user) {
            $msg = "Email này không tồn tại trong hệ thống!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            die($msg);
        }

        // Sinh mã OTP 6 số ngẫu nhiên để kiểm thử
        $otp = rand(100000, 999999);
        
        // Cập nhật reset_token trong CSDL làm OTP
        $userModel->update($user['id'], [
            'reset_token' => $otp
        ]);

        // Ghi mã OTP vào file log để kiểm thử
        $logDir = 'C:/Users/TTB/.gemini/antigravity/brain/a862bee9-1c11-4ae9-aaab-8c3bec8f9d24/scratch';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }
        $logFile = $logDir . '/otp_log.txt';
        $logContent = "[" . date('Y-m-d H:i:s') . "] Email: " . $email . " | OTP: " . $otp . "\n";
        @file_put_contents($logFile, $logContent, FILE_APPEND);

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => "Mã OTP khôi phục mật khẩu đã được gửi đến email của bạn! (Vui lòng kiểm tra file log kiểm thử)",
                'email' => $email
            ]);
            exit;
        }

        // Fallback
        echo "<h2 style='color:white; text-align:center; margin-top:50px;'>Mã OTP khôi phục mật khẩu đã được gửi đến email của bạn! (Kiểm tra file log)</h2>";
    }

    // =========================================================================
    // XỬ LÝ ĐẶT LẠI MẬT KHẨU MỚI (AJAX RESET PASSWORD)
    // =========================================================================
    public function resetPasswordSubmit() {
        $this->verifyCSRF();
        
        $email = trim($_POST['email'] ?? '');
        $otp = trim($_POST['otp'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        $isAjax = isset($_GET['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');

        if (empty($email) || empty($otp) || empty($password) || empty($confirmPassword)) {
            $msg = "Vui lòng nhập đầy đủ tất cả các trường!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            die($msg);
        }

        if (strlen($password) < 6) {
            $msg = "Mật khẩu mới phải có độ dài tối thiểu 6 ký tự!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            die($msg);
        }

        if ($password !== $confirmPassword) {
            $msg = "Mật khẩu xác nhận không khớp!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            die($msg);
        }

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if (!$user) {
            $msg = "Không tìm thấy người dùng!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            die($msg);
        }

        // Kiểm tra OTP
        if (empty($user['reset_token']) || $user['reset_token'] !== $otp) {
            $msg = "Mã OTP không chính xác hoặc đã hết hạn!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            die($msg);
        }

        // Băm mật khẩu mới và đặt reset_token = NULL
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $success = $userModel->update($user['id'], [
            'password' => $hashedPassword,
            'reset_token' => null
        ]);

        if ($success) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập bằng mật khẩu mới.'
                ]);
                exit;
            }
            header('Location: index.php?controller=auth&action=login');
            exit;
        } else {
            $msg = "Lỗi hệ thống khi cập nhật mật khẩu!";
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
            die($msg);
        }
    }

    // =========================================================================
    // XỬ LÝ DỮ LIỆU ĐĂNG NHẬP
    // =========================================================================
    public function loginSubmit() {
        $this->verifyCSRF();
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Lưu lại email để người dùng không phải gõ lại nếu lỗi
        $_SESSION['auth_email_login'] = $email;

        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = "Vui lòng nhập Email và Mật khẩu!";
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $userModel = new User();
        
        // Tìm User theo Email
        $user = $userModel->getByEmail($email);
        
        // Kiểm tra mật khẩu (hỗ trợ cả hash bcrypt và mật khẩu nhập tay chưa mã hóa ở Database cũ)
        $isPasswordValid = false;
        
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $isPasswordValid = true;
            } elseif ($user['password'] === $password) { // Fallback cho DB cũ
                $isPasswordValid = true;
                // Nâng cấp mật khẩu lên Bcrypt
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $userModel->updatePassword($user['id'], $newHash);
            }
        }
        
        $isAjax = isset($_GET['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');

        if ($isPasswordValid) {
            // Xử lý Remember Me (Nhớ mật khẩu)
            $remember = isset($_POST['remember']) && ($_POST['remember'] === '1' || $_POST['remember'] === 'true');
            if ($remember) {
                // Tạo cookie lưu ID user được mã hóa kèm chữ ký bảo mật (sống 30 ngày)
                $cookieValue = $user['id'] . '|' . md5($user['id'] . 'TTB_MUSIC_SECRET_KEY');
                setcookie('remember_me', $cookieValue, time() + 30 * 24 * 3600, '/');
            } else {
                // Xóa cookie remember_me nếu không tick
                setcookie('remember_me', '', time() - 3600, '/');
            }

            // Lưu session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            
            unset($_SESSION['login_error'], $_SESSION['auth_email_login']);
            
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'user' => $_SESSION['user']
                ]);
                exit;
            }

            // Chuyển hướng về trang chủ
            header('Location: index.php');
            exit;
        } else { 
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Sai email hoặc mật khẩu!'
                ]);
                exit;
            }
            $_SESSION['login_error'] = "Sai email hoặc mật khẩu!";
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    // =========================================================================
    // ĐĂNG XUẤT
    // =========================================================================
    public function logout() {
        // Xóa cookie remember_me
        setcookie('remember_me', '', time() - 3600, '/');

        // Hủy session đăng nhập
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        
        // Hỗ trợ AJAX logout không load lại trang
        if (isset($_GET['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }

        // Chuyển hướng về trang chủ (fallback)
        header('Location: index.php');
        exit;
    }

    // =========================================================================
    // XỬ LÝ ĐỔI MẬT KHẨU (AJAX / POST)
    // =========================================================================
    public function changePassword() {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Bạn chưa đăng nhập!'
            ]);
            exit;
        }

        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true);

        $oldPassword = isset($jsonData['old_password']) ? trim($jsonData['old_password']) : '';
        $newPassword = isset($jsonData['new_password']) ? trim($jsonData['new_password']) : '';
        $confirmPassword = isset($jsonData['confirm_password']) ? trim($jsonData['confirm_password']) : '';

        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng nhập đầy đủ tất cả các trường!'
            ]);
            exit;
        }

        if (strlen($newPassword) < 6) {
            echo json_encode([
                'success' => false,
                'message' => 'Mật khẩu mới phải có ít nhất 6 ký tự!'
            ]);
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            echo json_encode([
                'success' => false,
                'message' => 'Mật khẩu mới và mật khẩu xác nhận không khớp!'
            ]);
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $userModel = new User();
        $user = $userModel->getById($userId);

        if (!$user) {
            echo json_encode([
                'success' => false,
                'message' => 'Tài khoản không tồn tại!'
            ]);
            exit;
        }

        $isOldValid = false;
        if (password_verify($oldPassword, $user['password'])) {
            $isOldValid = true;
        } elseif ($user['password'] === $oldPassword) {
            $isOldValid = true;
        }

        if (!$isOldValid) {
            echo json_encode([
                'success' => false,
                'message' => 'Mật khẩu hiện tại không chính xác!'
            ]);
            exit;
        }

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $success = $userModel->updatePassword($userId, $hashed);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Đổi mật khẩu thành công!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi hệ thống khi cập nhật mật khẩu!'
            ]);
        }
        exit;
    }
}
?>