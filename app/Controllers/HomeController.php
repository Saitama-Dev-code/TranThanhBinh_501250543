<?php
// Đường dẫn file: app/Controllers/HomeController.php

// Gọi lớp cha
require_once __DIR__ . '/../../core/BaseController.php';

// Tương lai chúng ta sẽ require file Product Model ở đây để lấy dữ liệu nhạc cụ

class HomeController extends BaseController {
    
    // Hàm xử lý mặc định khi vào trang chủ
    public function index() {
        // Tương lai: Gọi Model ở đây để lấy danh sách Guitar, Piano...
        // Hiện tại: Truyền thử một biến title ra View
        $data = [
            'pageTitle' => 'Trang Chủ - TTB Music'
        ];

        // Gọi hàm render từ lớp cha để hiển thị giao diện 'home.php'
        $this->render('home', $data);
    }
}
?>