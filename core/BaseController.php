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
        
        // Kiểm tra xem file giao diện có tồn tại không trước khi load
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("Lỗi kiến trúc MVC: Không tìm thấy file View -> " . $view);
        }
    }
}
?>