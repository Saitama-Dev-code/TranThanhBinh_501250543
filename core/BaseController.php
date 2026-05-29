<?php
// Đường dẫn file: core/BaseController.php

class BaseController {
    /**
     * Hàm gọi View và truyền dữ liệu
     * @param string $view Tên file view (không cần đuôi .php)
     * @param array $data Dữ liệu truyền ra view (mặc định là rỗng)
     */
    protected function render($view, $data = []) {
        // Hàm extract giúp biến các key của mảng thành các biến độc lập 
        // VD: ['title' => 'TTB'] sẽ thành biến $title
        extract($data);

        $viewFile = __DIR__ . '/../app/Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        }
    }

    /**
     * Xác thực Token CSRF cho các yêu cầu POST nhạy cảm
     */
    protected function verifyCSRF() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("<h2 style='color:red; text-align:center; margin-top:50px;'>Lỗi bảo mật: Token CSRF không hợp lệ hoặc đã hết hạn! Vui lòng tải lại trang và thử lại.</h2>");
            }
        }
    }
}
?>