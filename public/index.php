<?php
// Đường dẫn file: public/index.php

// Bật hiển thị lỗi trong quá trình phát triển
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

define('ROOT_PATH', dirname(__DIR__));

// Tự động đăng nhập qua Cookie Remember Me
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_me'])) {
    $parts = explode('|', $_COOKIE['remember_me']);
    if (count($parts) === 2) {
        $userId = $parts[0];
        $hash = $parts[1];
        if ($hash === md5($userId . 'TTB_MUSIC_SECRET_KEY')) {
            require_once ROOT_PATH . '/app/Models/User.php';
            $userModel = new User();
            $user = $userModel->getById((int)$userId);
            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
            }
        }
    }
}

// Lấy tên Controller và Action từ URL (Mặc định là Home và index)
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'HomeController';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// Đường dẫn tới file Controller
$controllerFile = ROOT_PATH . '/app/Controllers/' . $controllerName . '.php';

// Kiểm tra xem file Controller có tồn tại không
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Khởi tạo Controller
    $controller = new $controllerName();
    
    // Kiểm tra xem hàm (action) có tồn tại không
    if (method_exists($controller, $actionName)) {
        $controller->$actionName();
    } else {
        die("Lỗi 404: Không tìm thấy phương thức {$actionName} trong {$controllerName}!");
    }
} else {
    die("Lỗi 404: Không tìm thấy trang (Controller {$controllerName} không tồn tại)!");
}
?>