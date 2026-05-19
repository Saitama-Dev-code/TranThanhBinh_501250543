<?php
// Đường dẫn file: public/index.php

// Bật hiển thị lỗi trong quá trình phát triển
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// === TỰ ĐỘNG CẬP NHẬT BẢNG PRODUCT_VARIANTS ===
require_once dirname(__DIR__) . '/core/db.inc';
try {
    $db_fix = Database::getInstance()->getConnection();
    $check_table = $db_fix->query("SHOW TABLES LIKE 'product_variants'");
    if ($check_table->rowCount() == 0) {
        $sql = "CREATE TABLE `product_variants` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `product_id` int(11) NOT NULL,
            `variant_type` enum('color','version') NOT NULL,
            `name` varchar(100) NOT NULL,
            `value` varchar(100) DEFAULT NULL,
            `image_url` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $db_fix->exec($sql);
        
        // Chèn dữ liệu mẫu
        $db_fix->exec("INSERT INTO `product_variants` (`product_id`, `variant_type`, `name`, `value`, `image_url`) VALUES
            (1, 'color', 'Gỗ tự nhiên', '#D2B48C', 'https://images.unsplash.com/photo-1550291652-6ea9114a47b1?q=80&w=600'),
            (1, 'color', 'Sunburst', '#8B4513', 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?q=80&w=600'),
            (1, 'version', 'Standard', 'std', NULL),
            (1, 'version', 'Premium', 'pre', NULL),
            (2, 'color', 'Đen nhám', '#1a1a1a', 'https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?q=80&w=600'),
            (2, 'color', 'Trắng sứ', '#f8f9fa', 'https://images.unsplash.com/photo-1552422535-c45813c61732?q=80&w=600'),
            (2, 'version', 'RP-30 Basic', 'basic', NULL),
            (2, 'version', 'RP-30 Plus', 'plus', NULL)");
    }
} catch (Exception $e) {}
// === HẾT ĐOẠN CODE CẬP NHẬT ===

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

define('ROOT_PATH', dirname(__DIR__));

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