<?php
// Đường dẫn file: public/index.php

// Bật hiển thị lỗi trong quá trình phát triển
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Khởi tạo session cho chức năng giỏ hàng và đăng nhập
session_start();

define('ROOT_PATH', dirname(__DIR__));

// Nạp file HomeController
require_once ROOT_PATH . '/app/Controllers/HomeController.php';

// Thay vì gọi View trực tiếp, ta Khởi tạo Controller và chạy hàm index()
$app = new HomeController();
$app->index();
?>