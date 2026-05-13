-- =========================================================================
-- FILE: Database/shopnhaccu.sql
-- MÔ TẢ: Cấu trúc cơ sở dữ liệu cho dự án TTB Music (Website Bán & Cho Thuê Nhạc Cụ)
-- DBMS: MySQL / MariaDB (Dành cho Laragon/XAMPP)
-- =========================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- Tạo Database và sử dụng charset utf8mb4 để hỗ trợ tiếng Việt có dấu và Emoji hoàn hảo
CREATE DATABASE IF NOT EXISTS `shopnhaccu` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `shopnhaccu`;

-- --------------------------------------------------------
-- 1. BẢNG USERS (Quản lý khách hàng, Admin và Đăng nhập MXH)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL UNIQUE,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Khách, 1: Super Admin, 2: QL Sản phẩm, 3: QL Đơn hàng',
  `provider` varchar(50) DEFAULT NULL COMMENT 'google, facebook, zalo',
  `provider_id` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm 1 tài khoản Admin mặc định (Mật khẩu: 123456 - Lát nữa sẽ dùng password_hash trong PHP để băm sau)
INSERT INTO `users` (`full_name`, `email`, `password`, `role`) VALUES
('Admin TTB', 'admin@ttbmusic.com', '123456', 1);

-- --------------------------------------------------------
-- 2. BẢNG CATEGORIES (Danh mục nhạc cụ)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu danh mục
INSERT INTO `categories` (`name`, `icon`) VALUES
('Guitar & Bass', 'fas fa-guitar'),
('Piano & Keyboard', 'fas fa-stop'),
('Trống & Bộ gõ', 'fas fa-drum'),
('Âm thanh Studio', 'fas fa-headphones-alt');

-- --------------------------------------------------------
-- 3. BẢNG PRODUCTS (Danh sách nhạc cụ)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_rentable` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1: Cho thuê, 0: Chỉ bán',
  `rent_price_day` decimal(10,2) DEFAULT NULL,
  `deposit_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu sản phẩm (Link ảnh từ Unsplash/PNG)
INSERT INTO `products` (`category_id`, `name`, `price`, `image`, `description`, `stock`, `is_rentable`, `rent_price_day`, `deposit_price`) VALUES
(1, 'Acoustic Yamaha F310', 3500000.00, 'https://images.unsplash.com/photo-1550291652-6ea9114a47b1?q=80&w=600&auto=format&fit=crop', 'Gỗ vân sam, âm mộc chuẩn. Lựa chọn tuyệt vời cho người mới.', 15, 1, 150000.00, 2000000.00),
(2, 'Roland Midi Keyboard RP-30', 16900000.00, 'https://images.unsplash.com/photo-1595069906974-f0ae90cefc70?q=80&w=600&auto=format&fit=crop', 'Phím gõ chân thực, siêu nhạy, chuẩn studio.', 5, 0, NULL, NULL),
(3, 'Trống Pearl Roadshow', 12500000.00, 'https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?q=80&w=600&auto=format&fit=crop', 'Bộ 5 trống tiêu chuẩn kèm đầy đủ Hardware.', 3, 1, 500000.00, 10000000.00);

-- --------------------------------------------------------
-- 4. BẢNG ORDERS (Đơn mua hàng)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','shipping','completed','canceled') NOT NULL DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `receiver_phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 5. BẢNG ORDER_DETAILS (Chi tiết đơn mua hàng)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `order_details`;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 6. BẢNG RENTALS (Hợp đồng thuê nhạc cụ)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `rentals`;
CREATE TABLE `rentals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `actual_return` date DEFAULT NULL,
  `total_rent_fee` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','active','returned','canceled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 7. BẢNG RENTAL_DETAILS (Chi tiết đồ thuê)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `rental_details`;
CREATE TABLE `rental_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rental_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`rental_id`) REFERENCES `rentals`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;