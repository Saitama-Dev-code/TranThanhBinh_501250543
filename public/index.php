<?php
// Bật hiển thị lỗi trong quá trình phát triển
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Bắt đầu session cho giỏ hàng và đăng nhập sau này
session_start();

// Định nghĩa thư mục gốc để dễ dàng include file
define('ROOT_PATH', dirname(__DIR__));

// Tạm thời điều hướng thẳng vào View Trang chủ (Sau này sẽ thay bằng Router Class)
require_once ROOT_PATH . '/app/Views/home.php';