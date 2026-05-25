<?php

/**
 * =========================================================================
 * TÊN FILE: app/Views/partials/header.php
 * MÔ TẢ: Khôi phục 100% CSS gốc của bạn để không làm hỏng hiệu ứng trang Home.
 * CHỈ BỔ SUNG: Hiệu ứng Active cho Menu và Preloader hiện mỗi khi F5.
 * =========================================================================
 */

// =========================================================================
// KIỂM TRA ĐIỀU HƯỚNG BẰNG TÊN CONTROLLER TRÊN URL
// - Biến $_GET['controller'] lấy từ URL (vd: index.php?controller=product)
// - Toán tử ?? 'home' nghĩa là: Nếu không có controller nào trên URL thì mặc định là 'home'
// =========================================================================
$currentController = $_GET['controller'] ?? 'home';

// =========================================================================
// LOGIC HIỂN THỊ PRELOADER (MÀN HÌNH CHỜ)
// - Tắt preloader cho cửa hàng (controller 'product') và giỏ hàng (controller 'cart')
//   để tránh việc load màn hình chờ gây gián đoạn trải nghiệm người dùng.
// =========================================================================
$isFiltering = ($currentController == 'product' || $currentController == 'cart');

if (isset($_GET['spa']) && $_GET['spa'] == '1') {
    echo '<title-meta data-title="' . htmlspecialchars($pageTitle ?? 'TTB - Giai Điệu Của Riêng Bạn') . '"></title-meta>';
    return;
}
?>
<!DOCTYPE html>
<html lang="vi" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'TTB - Giai Điệu Của Riêng Bạn' ?></title>
    
    <!-- Google Fonts cho Logo và thiết kế hiện đại -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&family=Inter:wght@300;400;600;800;900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Gốc -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- CÁC THƯ VIỆN HIỆU ỨNG MỚI ĐƯỢC THÊM VÀO -->
    <!-- 1. AOS (Animate On Scroll): Hiệu ứng trượt khi cuộn chuột -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- 2. Boxicons: Bộ icon hiện đại, mảnh, hỗ trợ xoay/nhấp nháy -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- 3. Animate.css: Hiệu ứng chuyển động (bounce, pulse) cho các thẻ HTML -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- 4. Hover.css: Hiệu ứng di chuột cho nút bấm, thẻ bài (Card) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css" />
    <!-- 5. Lordicon: Hỗ trợ load các Icon dạng hoạt hình Lottie mượt mà -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>

    <style>
        :root {
            --nav-height: 76px; /* Chiều cao mặc định của Navbar */
        }
        /* ================= BIẾN MÀU SẮC (THEME) ================= */
        :root[data-theme="light"] {
            --bg-color: #f8fafc;
            --text-color: #0f172a;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --nav-bg: rgba(255, 255, 255, 0.85);
            --watermark-color: rgba(0, 0, 0, 0.03);
            --faq-bg: #f1f5f9;
        }

        :root[data-theme="dark"] {
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --card-bg: #1e293b;
            --border-color: #334155;
            --nav-bg: rgba(15, 23, 42, 0.85);
            --watermark-color: rgba(255, 255, 255, 0.02);
            --faq-bg: #334155;
        }

        /* Ẩn hoàn toàn thanh cuộn dọc mặc định của trình duyệt Google Chrome/Edge/Safari/Firefox */
        html {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        html::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        body::-webkit-scrollbar {
            display: none;
        }

        /* GIỮ NGUYÊN CSS BODY GỐC: Tránh xung đột với Parallax và hiệu ứng nốt nhạc */
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
            transition: background-color 0.4s ease, color 0.4s ease;
            overflow-x: hidden;
            padding-top: var(--nav-height, 76px);
            position: relative;
        }

        /* ================= WATERMARK & NỀN PARALLAX ================= */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18vw;
            font-weight: 900;
            color: var(--watermark-color);
            z-index: -2;
            pointer-events: none;
            user-select: none;
            white-space: nowrap;
            transition: color 0.4s ease;
        }

        #global-parallax {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            pointer-events: none;
            overflow: hidden;
        }

        @keyframes organicFloat {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-30px);
            }
        }

        .note-wrapper {
            position: absolute;
            animation: organicFloat 10s ease-in-out infinite;
        }

        .note-icon {
            color: var(--text-color);
            opacity: 0.1;
            transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* ================= NAVBAR ================= */
        /* CSS cho thanh điều hướng trên cùng */
        .navbar {
            background-color: var(--nav-bg);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(12px); /* Tạo hiệu ứng kính mờ (Glassmorphism) */
            transition: top 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55), background-color 0.4s;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
        }

        .navbar-brand,
        .nav-link {
            color: var(--text-color) !important;
            font-weight: 600;
        }

        .navbar-brand i {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: inline-block;
        }

        .navbar-brand:hover i {
            transform: scale(1.2) rotate(-15deg);
            color: #3b82f6 !important;
        }

        /* ================= LOGO MORPHING HIGHTECH (TTB -> 7IB) ================= */
        .navbar-brand-modern {
            display: inline-flex;
            align-items: center;
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 1.6rem;
            color: var(--text-color) !important;
            text-decoration: none;
            /* font-style: italic; Bỏ nghiêng để vuông vức hơn */
            transition: color 0.4s ease;
            gap: 1px;
        }

        .navbar-brand-modern:hover {
            color: #3b82f6 !important;
        }

        .logo-icon-spin {
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), color 0.4s;
            margin-right: 4px;
        }
        .navbar-brand-modern:hover .logo-icon-spin {
            transform: rotate(360deg) scale(1.2);
            color: #3b82f6 !important;
        }

        /* Khung dựng chữ T thứ 1 */
        .char-t1 {
            position: relative;
            display: inline-block;
            width: 18px; /* Rút gọn bớt để sát nhau hơn */
            height: 24px;
            margin-right: 0px;
        }
        .char-t1 .bar-top {
            position: absolute;
            top: 2px;
            left: 0;
            width: 18px;
            height: 5px; /* Dày hơn cho vuông vức */
            background-color: var(--text-color);
            border-radius: 0px; /* Bỏ bo tròn để vuông vức */
            transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.4s;
            transform-origin: right center;
        }
        .char-t1 .bar-stem {
            position: absolute;
            top: 2px;
            left: 6.5px;
            width: 5px;
            height: 20px;
            background-color: var(--text-color);
            border-radius: 0px;
            transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.4s;
            transform-origin: top center;
        }

        /* Khung dựng chữ T thứ 2 */
        .char-t2 {
            position: relative;
            display: inline-block;
            width: 18px;
            height: 24px;
            margin-right: 0px;
            transition: transform 0.4s ease;
        }
        .char-t2 .bar-top {
            position: absolute;
            top: 2px;
            left: 0;
            width: 18px;
            height: 5px;
            background-color: var(--text-color);
            border-radius: 0px;
            transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.4s;
            transform-origin: center center;
        }
        .char-t2 .bar-stem {
            position: absolute;
            top: 2px;
            left: 6.5px;
            width: 5px;
            height: 20px;
            background-color: var(--text-color);
            border-radius: 0px;
            transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.4s;
            transform-origin: top center;
        }

        /* Chữ B */
        .char-b {
            font-size: 1.7rem;
            line-height: 24px;
            font-weight: 900;
            display: inline-block;
            color: var(--text-color);
            transition: transform 0.4s ease, color 0.4s ease;
            font-family: 'Outfit', sans-serif;
            margin-left: -2px; /* Sát lại hơn */
        }

        /* Hover chuyển TTB thành 7IB */
        .navbar-brand-modern:hover .char-t1 .bar-top {
            transform: scaleX(0.5) translateX(2px); /* Rút gọn vừa phải */
            background-color: #3b82f6 !important;
        }
        .navbar-brand-modern:hover .char-t1 .bar-stem {
            transform: rotate(15deg) translateX(4px); /* Nghiêng rõ nét hơn */
            background-color: #3b82f6 !important;
        }
        .navbar-brand-modern:hover .char-t2 {
            transform: translateX(-6px); /* Sát lại hơn */
        }
        .navbar-brand-modern:hover .char-t2 .bar-top {
            transform: scaleX(0); 
        }
        .navbar-brand-modern:hover .char-t2 .bar-stem {
            background-color: #3b82f6 !important;
        }
        .navbar-brand-modern:hover .char-b {
            color: #3b82f6 !important;
            transform: translateX(-12px) scale(1.05); /* Sát lại hơn nữa */
        }

        .nav-link {
            position: relative;
            padding-bottom: 5px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #3b82f6;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        /* HIỆU ỨNG ACTIVE (MỚI): Luôn hiện gạch chân và đổi màu khi đang ở đúng trang */
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }

        .nav-link.active {
            color: #3b82f6 !important;
        }

        /* ================= PRELOADER SÓNG NHẠC GRADIENT ================= */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #0f172a;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: opacity 0.8s ease, visibility 0.8s;
        }

        .loader-content {
            text-align: center;
        }

        .music-waves {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            height: 50px;
            gap: 6px;
            margin-bottom: 25px;
        }

        .music-waves span {
            width: 8px;
            height: 10px;
            /* Dải màu Gradient sáng rực rỡ */
            background: linear-gradient(to top, #3b82f6, #64ffda);
            border-radius: 4px;
            /* Hiệu ứng phát sáng phản quang */
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.6);
            animation: wave-animation 1.2s infinite ease-in-out;
        }

        .music-waves span:nth-child(2) { animation-delay: 0.1s; }
        .music-waves span:nth-child(3) { animation-delay: 0.2s; }
        .music-waves span:nth-child(4) { animation-delay: 0.3s; }
        .music-waves span:nth-child(5) { animation-delay: 0.4s; }

        @keyframes wave-animation {
            0%, 100% { height: 10px; }
            50% { height: 50px; background: linear-gradient(to top, #64ffda, #3b82f6); box-shadow: 0 0 15px rgba(59, 130, 246, 0.8); }
        }

        .loader-text {
            color: white;
            font-weight: 800;
            letter-spacing: 5px;
            margin-bottom: 5px;
            margin-top: 15px;
        }

        .loader-subtext {
            color: #8892b0;
            font-style: italic;
            font-size: 0.9rem;
        }

        .preloader-hidden {
            opacity: 0;
            visibility: hidden;
        }

        /* ================= PARTICLE BACKGROUND CANVAS ================= */
        #particle-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            pointer-events: auto; /* Cho phép bắt sự kiện chuột trên toàn bộ mảng nền */
        }

        /* CSS dùng chung cho các khối Card và Hover */
        .custom-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: box-shadow 0.4s ease;
            cursor: pointer;
        }

        .custom-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-color: #3b82f6;
        }

        .simple-hover-icon {
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .custom-card:hover .simple-hover-icon {
            transform: scale(1.15);
            color: #3b82f6 !important;
        }

        /* ================= SPA CORE LAYOUT & TRANSITIONS ================= */
        #spa-viewport {
            position: relative;
            width: 100%;
            min-height: 150vh;
        }
        .spa-page {
            display: none;
            width: 100%;
        }
        .spa-page.active {
            display: block;
        }

        /* Lớp bọc tạm thời khi đang slide transition */
        .spa-viewport-transitioning {
            overflow: hidden;
            height: 100vh;
            position: fixed;
            width: 100%;
        }

        .spa-page.spa-leaving {
            display: block !important;
            position: fixed;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: 10;
            pointer-events: none;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
        }

        .spa-page.spa-entering {
            display: block !important;
            position: fixed;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: 20;
            pointer-events: none;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
        }

        /* Slide Trái (Đi tới) */
        .spa-page.slide-left-leaving {
            transform: translateX(-100%);
            opacity: 0.7;
        }
        .spa-page.slide-left-entering-start {
            transform: translateX(100%);
        }
        .spa-page.slide-left-entering-end {
            transform: translateX(0);
        }

        /* Slide Phải (Quay lại) */
        .spa-page.slide-right-leaving {
            transform: translateX(100%);
            opacity: 0.7;
        }
        .spa-page.slide-right-entering-start {
            transform: translateX(-100%);
        }
        .spa-page.slide-right-entering-end {
            transform: translateX(0);
        }

        /* Slide Lên (Shop -> Detail) */
        .spa-page.slide-up-leaving {
            transform: translateY(-50px);
            opacity: 0.5;
        }
        .spa-page.slide-up-entering-start {
            transform: translateY(100vh);
        }
        .spa-page.slide-up-entering-end {
            transform: translateY(0);
        }

        /* Slide Xuống (Detail -> Shop) */
        .spa-page.slide-down-leaving {
            transform: translateY(100vh) !important;
            opacity: 1 !important; /* ✅ Không ẩn dần, trượt hẳn xuống dưới */
            z-index: 25; /* Đè lên trang shop bên dưới */
        }
        .spa-page.slide-down-entering-start {
            transform: translateY(-50px);
            opacity: 0.5;
        }
        .spa-page.slide-down-entering-end {
            transform: translateY(0);
            opacity: 1;
        }

        /* ================= CART SLIDE OVERLAY ================= */
        .spa-page#page-cart {
            display: block !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 1050; /* Đè lên navbar (1030) */
            background: rgba(15, 23, 42, 0.95); /* ✅ Thay đổi thành 0.95 tối vững để triệt tiêu lag của blur */
            transform: translateY(-100%);
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            overflow-y: auto;
            pointer-events: none;
            scrollbar-width: none; /* ✅ Ẩn thanh cuộn trên Firefox */
            -ms-overflow-style: none; /* ✅ Ẩn thanh cuộn trên IE/Edge */
        }
        .spa-page#page-cart::-webkit-scrollbar {
            display: none; /* ✅ Ẩn thanh cuộn trên Chrome/Safari/Opera */
        }
        .spa-page#page-cart.active-overlay {
            transform: translateY(0);
            pointer-events: auto;
        }

        /* ================= DETAIL SLIDE SHEET OVERLAY ================= */
        .spa-page#page-detail {
            display: block !important;
            position: fixed;
            top: var(--nav-height, 76px); /* Bắt đầu ngay dưới Navbar */
            left: 0;
            width: 100%;
            height: calc(100vh - var(--nav-height, 76px)); /* Chiều cao còn lại dưới Navbar */
            z-index: 1020; /* Nằm dưới navbar (1030) */
            padding-top: 0; /* Sát khít với Navbar, không cần padding nữa */
            background: var(--bg-color);
            transform: translateY(100vh);
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            overflow-y: auto;
            pointer-events: none;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .spa-page#page-detail::-webkit-scrollbar {
            display: none;
        }
        .spa-page#page-detail.active-sheet {
            transform: none;
            pointer-events: auto;
        }

        /* Thêm nút Đóng giỏ hàng ở vị trí nổi bật */
        .cart-close-btn-wrapper {
            position: absolute;
            top: 25px;
            right: 25px;
            z-index: 10;
        }
        .btn-cart-close {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-cart-close:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
            transform: rotate(90deg);
        }

        /* Tối ưu màu sắc cho giỏ hàng ở Light Theme (tím khói bán trong suốt để nhìn xuyên qua watermark nền) */
        :root[data-theme="light"] .spa-page#page-cart {
            background: rgba(245, 243, 255, 0.88) !important;
        }
        :root[data-theme="light"] .btn-cart-close {
            background: rgba(15, 23, 42, 0.05) !important;
            border-color: #e2e8f0 !important;
            color: #475569 !important;
        }
        :root[data-theme="light"] .btn-cart-close:hover {
            background: #ef4444 !important;
            color: white !important;
            border-color: #ef4444 !important;
        }

        /* Ảnh ảo dùng cho Morph Zoom */
        .morph-temp-image {
            position: fixed;
            pointer-events: none;
            z-index: 99999;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.65s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* Morph transition classes */
        .spa-page.morph-leaving {
            display: block !important;
            position: fixed;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: 10;
            pointer-events: none;
            transition: opacity 0.4s ease;
            opacity: 0;
        }
        .spa-page.morph-entering {
            display: block !important;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 20;
            pointer-events: none;
            transition: opacity 0.4s ease;
            opacity: 0;
        }
        .spa-page.morph-entering-active {
            opacity: 1;
        }

        /* ================================================================================
           USER DROPDOWN ACCOUNT MENU (HOVER EFFECT & GLASSMORPHISM)
           ================================================================================ */
        .user-dropdown-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .user-dropdown-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 12px;
            width: 260px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 15px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 1050;
        }
        
        .user-dropdown-wrapper:hover .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .user-dropdown-header {
            padding: 0 20px 10px;
            text-align: left;
        }
        
        .user-dropdown-header .user-name {
            font-weight: 700;
            color: var(--text-color);
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .user-dropdown-header .user-email {
            font-size: 0.8rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .user-dropdown-menu .dropdown-divider {
            border-top: 1px solid var(--border-color);
            margin: 8px 0;
            opacity: 0.3;
        }
        
        .user-dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: var(--text-color);
            font-size: 0.88rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        
        .user-dropdown-menu .dropdown-item i {
            color: var(--text-muted);
            width: 20px;
            text-align: center;
            transition: color 0.25s ease;
        }
        
        .user-dropdown-menu .dropdown-item:hover {
            background: rgba(59, 130, 246, 0.08);
            color: #3b82f6 !important;
            padding-left: 25px;
        }
        
        .user-dropdown-menu .dropdown-item:hover i {
            color: #3b82f6 !important;
        }
        
        .user-dropdown-menu .dropdown-item.logout-item:hover {
            background: rgba(239, 68, 68, 0.08);
            color: #ef4444 !important;
        }
        
        .user-dropdown-menu .dropdown-item.logout-item:hover i {
            color: #ef4444 !important;
        }

        /* ================================================================================
           CẬP NHẬT GIAO DIỆN TÀI KHOẢN & ĐĂNG NHẬP MỚI
           ================================================================================ */

        /* 1. Tăng độ tương phản chữ xám (text-muted) trong Dark Theme của Cửa hàng */
        :root[data-theme="dark"] .text-muted {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        /* 2. Hiệu ứng Morph mượt mà (Fade-in và Scale) khi chuyển trạng thái đăng nhập/đăng xuất */
        .nav-user-control-morph {
            animation: navControlMorph 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        @keyframes navControlMorph {
            0% {
                opacity: 0;
                transform: scale(0.92);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* 3. Style Nút Đăng nhập mới: Xanh dương Gradient cao cấp */
        .navbar-login-btn {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.35) !important;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
        }
        .navbar-login-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5) !important;
            background: linear-gradient(135deg, #1d4ed8, #2563eb) !important;
        }

        /* 4. Style Dropdown Khách hàng: Viền Neon & Glassmorphism Tím-Xanh Ngọc */
        .user-dropdown-wrapper .user-dropdown-btn {
            background: rgba(139, 92, 246, 0.12) !important;
            border: 1px solid rgba(6, 182, 212, 0.45) !important;
            color: var(--text-color) !important;
            font-weight: 600 !important;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.2), 0 0 5px rgba(6, 182, 212, 0.2) !important;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
        }
        .user-dropdown-wrapper:hover .user-dropdown-btn {
            background: rgba(139, 92, 246, 0.22) !important;
            border-color: rgba(6, 182, 212, 0.75) !important;
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.45), 0 0 8px rgba(6, 182, 212, 0.4) !important;
            transform: translateY(-1px);
        }
        
        .user-dropdown-menu.glass-dropdown {
            background: rgba(20, 15, 40, 0.85) !important;
            backdrop-filter: blur(25px) !important;
            -webkit-backdrop-filter: blur(25px) !important;
            border: 1px solid rgba(6, 182, 212, 0.5) !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4), 
                        0 0 15px rgba(139, 92, 246, 0.35), 
                        0 0 5px rgba(6, 182, 212, 0.25) !important;
        }
        
        :root[data-theme="light"] .user-dropdown-menu.glass-dropdown {
            background: rgba(250, 245, 255, 0.92) !important;
            border: 1px solid rgba(139, 92, 246, 0.25) !important;
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15) !important;
        }
    </style>
</head>

<body id="top">
    <script>
        // Kiểm tra theme ngay lập tức để tránh bị chớp màn hình
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    <?php if (!$isFiltering): ?>
    <div id="preloader">
        <div class="loader-content">
            <div class="music-waves">
                <span></span><span></span><span></span><span></span><span></span>
            </div>
            <h2 class="loader-text animate__animated animate__fadeInUp">TTB MUSIC</h2>
            <p class="loader-subtext animate__animated animate__fadeInUp animate__delay-1s">Đang chuẩn bị giai điệu...</p>
        </div>
    </div>
    <?php endif; ?>

    <script>
        /**
         * [cite_start]XỬ LÝ PRELOADER: window.load đảm bảo hiện hiệu ứng khi F5 trang[cite: 1043].
         */
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(() => {
                    preloader.classList.add('preloader-hidden');
                }, 1000);
            }
        });
    </script>

    <div class="watermark">TTB MUSIC</div>
    
    <!-- Hệ Thống Mưa Âm Nhạc Bằng Canvas (Siêu Mượt & Tương Tác Thật) -->
    <canvas id="particle-canvas"></canvas>

    <script>
        // JAVASCRIPT CANVAS PARTICLE SYSTEM
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');
        
        let width, height;
        let particles = [];
        const icons = ['♪', '♫', '♬', '♩'];
        
        // Cấu hình chuột
        let mouse = { x: null, y: null, radius: 120 };
        
        window.addEventListener('mousemove', function(e) {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        class Particle {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height - height; // Bắt đầu ngẫu nhiên từ trên xuống
                this.size = Math.random() * 20 + 15;
                this.speedY = Math.random() * 1 + 0.5;
                this.icon = icons[Math.floor(Math.random() * icons.length)];
                this.baseOpacity = Math.random() * 0.1 + 0.1; // Độ mờ cơ bản từ 0.1 - 0.2 (Rõ hơn)
                this.opacity = this.baseOpacity;
                this.angle = Math.random() * 360;
                this.spin = (Math.random() - 0.5) * 2;
                
                // Trạng thái hover
                this.isHovered = false;
                this.hoverScale = 1;
            }

            update() {
                this.y += this.speedY;
                this.angle += this.spin;

                // Nếu rơi khỏi màn hình thì đưa lên trên cùng và vị trí x hoàn toàn ngẫu nhiên mới
                if (this.y > height + 50) {
                    this.y = -50;
                    this.x = Math.random() * width;
                    this.speedY = Math.random() * 1 + 0.5; // Random lại tốc độ
                }

                // Tương tác vật lý với chuột
                let dx = mouse.x - this.x;
                let dy = mouse.y - this.y;
                let distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < mouse.radius) {
                    this.isHovered = true;
                    // Nảy ra xa chuột một chút
                    this.x -= dx / 15;
                    this.y -= dy / 15;
                } else {
                    this.isHovered = false;
                }
                
                // Animation mượt mà khi hover
                if (this.isHovered) {
                    this.hoverScale = Math.min(this.hoverScale + 0.1, 1.8);
                    this.opacity = Math.min(this.opacity + 0.05, 0.9);
                } else {
                    this.hoverScale = Math.max(this.hoverScale - 0.05, 1);
                    this.opacity = Math.max(this.opacity - 0.02, this.baseOpacity);
                }
            }

            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.angle * Math.PI / 180);
                ctx.scale(this.hoverScale, this.hoverScale);
                
                // Xác định màu sắc tương phản với Theme hiện tại
                const isLight = document.documentElement.getAttribute('data-theme') === 'light';
                const baseColor = isLight ? `rgba(15, 23, 42, ${this.opacity})` : `rgba(255, 255, 255, ${this.opacity})`;
                
                ctx.fillStyle = this.isHovered ? `rgba(59, 130, 246, ${this.opacity})` : baseColor;
                
                if (this.isHovered) {
                    ctx.shadowBlur = 20;
                    ctx.shadowColor = '#3b82f6';
                } else {
                    ctx.shadowBlur = 0;
                }

                ctx.font = `bold ${this.size}px Arial`;
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(this.icon, 0, 0);
                
                ctx.restore();
            }
        }

        // Tạo mảng hạt (Giảm bớt để không rối)
        for (let i = 0; i < 30; i++) {
            particles.push(new Particle());
        }

        // Vòng lặp vẽ liên tục
        function animate() {
            ctx.clearRect(0, 0, width, height);
            
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            
            requestAnimationFrame(animate);
        }
        animate();
    </script>

    <nav class="navbar navbar-expand-lg" id="smartNavbar">
        <div class="container">
            <a class="navbar-brand-modern" href="index.php?controller=home" data-no-spa>
                <i class="fas fa-music text-primary me-2 logo-icon-spin"></i>
                <span class="char-t1">
                    <span class="bar-top"></span>
                    <span class="bar-stem"></span>
                </span>
                <span class="char-t2">
                    <span class="bar-top"></span>
                    <span class="bar-stem"></span>
                </span>
                <span class="char-b">B</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars" style="color: var(--text-color);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentController == 'home') ? 'active' : '' ?>"
                            href="index.php?controller=home">
                            Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentController == 'product') ? 'active' : '' ?>"
                            href="index.php?controller=product&action=index">Cửa hàng</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Cho Thuê Nhạc Cụ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                </ul>

                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    <button id="theme-toggle" class="btn btn-outline-secondary rounded-circle me-3">
                        <i class="fas fa-moon"></i>
                    </button>
                    <?php
                    /*
                     * NÚT GIỎ HÀNG:
                     * - Link đến trang cart (CartController::index())
                     * - Badge hiển thị tổng số sản phẩm trong giỏ (từ $_SESSION['cart'])
                     * - JS sẽ gọi AJAX CartController::count() để giữ badge luôn đúng
                     */
                    $cartCount = 0;
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        // Tính tổng số lượng từ session hiện tại
                        foreach ($_SESSION['cart'] as $item) {
                            $cartCount += (int)($item['quantity'] ?? 0);
                        }
                    }
                    ?>
                    <a href="index.php?controller=cart&action=index"
                       class="btn btn-outline-primary me-2 rounded-pill px-3 position-relative nav-cart-btn"
                       style="display:inline-flex; align-items:center; gap:6px;">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?= $cartCount ?></span>
                    </a>
                    <div id="navbar-user-control" style="display: inline-block;">
                        <?php if (isset($_SESSION['user'])): ?>
                            <!-- Dropdown tài khoản khách hàng khi đã đăng nhập (sử dụng Morph transition và Glassmorphism tím-xanh ngọc) -->
                            <div class="user-dropdown-wrapper nav-user-control-morph">
                                <a href="index.php?controller=profile&action=index" class="btn rounded-pill px-4 user-dropdown-btn">
                                    <i class="fas fa-user-circle" style="font-size: 1.1rem;"></i> 
                                    <span><?= htmlspecialchars($_SESSION['user']['full_name']) ?></span>
                                    <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                                </a>
                                <div class="user-dropdown-menu glass-dropdown">
                                    <div class="user-dropdown-header">
                                        <div class="user-name"><?= htmlspecialchars($_SESSION['user']['full_name']) ?></div>
                                        <div class="user-email"><?= htmlspecialchars($_SESSION['user']['email']) ?></div>
                                    </div>
                                    <hr class="dropdown-divider">
                                    <a href="index.php?controller=profile&action=index" class="dropdown-item">
                                        <i class="fas fa-history me-2"></i> Đơn mua hàng
                                    </a>
                                    <a href="index.php?controller=profile&action=index#rentals-pane" class="dropdown-item">
                                        <i class="fas fa-calendar-alt me-2"></i> Hợp đồng thuê
                                    </a>
                                    <a href="index.php?controller=profile&action=index#password-pane" class="dropdown-item">
                                        <i class="fas fa-key me-2"></i> Đổi mật khẩu
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="index.php?controller=auth&action=logout" class="dropdown-item logout-item" data-no-spa>
                                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Nút Đăng nhập dạng xanh dương gradient chuyển động khi chưa đăng nhập (khi click sẽ gọi window.showAuthSheet) -->
                            <button type="button" class="btn navbar-login-btn rounded-pill px-4 nav-user-control-morph" onclick="if(window.showAuthSheet) { window.showAuthSheet(); } else { console.error('showAuthSheet is not defined'); }">
                                <i class="fas fa-user"></i> Đăng nhập
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script>
        // Đo chiều cao thực tế của Navbar động để căn chỉnh khoảng cách các sheet/detail-page
        window.updateNavHeight = () => {
            const nav = document.getElementById('smartNavbar');
            if (nav) {
                const rect = nav.getBoundingClientRect();
                const height = rect.height || nav.offsetHeight;
                if (height > 0) {
                    document.documentElement.style.setProperty('--nav-height', height + 'px');
                }
            }
        };
        // Chạy ngay lập tức khi script load
        window.updateNavHeight();
        // Chạy khi DOMContentLoaded
        window.addEventListener('DOMContentLoaded', window.updateNavHeight);
        // Chạy khi load xong hoàn toàn (ảnh, style...)
        window.addEventListener('load', window.updateNavHeight);
        // Chạy khi resize window
        window.addEventListener('resize', window.updateNavHeight);
        
        // Theo dõi sự thay đổi của class/attributes của nav (ví dụ khi scroll hoặc toggle menu)
        (function() {
            const navEl = document.getElementById('smartNavbar');
            if (navEl) {
                const observer = new MutationObserver(window.updateNavHeight);
                observer.observe(navEl, { attributes: true, childList: true, subtree: true });
            }
        })();

        // Global listener for dropdown tab links and AJAX logout
        document.addEventListener('click', (e) => {
            // 1. Tab switches for profile dropdown items
            const item = e.target.closest('.user-dropdown-menu .dropdown-item');
            if (item && item.getAttribute('href')) {
                const href = item.getAttribute('href');
                if (href.includes('#')) {
                    const hash = href.substring(href.indexOf('#'));
                    const tabEl = document.querySelector(`button[data-bs-target="${hash}"]`);
                    if (tabEl) {
                        const tab = new bootstrap.Tab(tabEl);
                        tab.show();
                    }
                }
            }

            // 2. AJAX Logout handling (No Page Reload)
            const logoutBtn = e.target.closest('.logout-item, .logout-btn');
            if (logoutBtn) {
                e.preventDefault();
                
                logoutBtn.style.pointerEvents = 'none';
                
                fetch('index.php?controller=auth&action=logout&ajax=1')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Replace user dropdown with login button in navbar
                        const container = document.getElementById('navbar-user-control');
                        if (container) {
                            container.innerHTML = `
                                <button type="button" class="btn navbar-login-btn rounded-pill px-4 nav-user-control-morph" onclick="if(window.showAuthSheet) { window.showAuthSheet(); } else { console.error('showAuthSheet is not defined'); }">
                                    <i class="fas fa-user"></i> Đăng nhập
                                </button>
                            `;
                        }
                        
                        // If currently on profile page, redirect to home page via SPA
                        const activePage = document.querySelector('.spa-page.active');
                        if (activePage && activePage.id === 'page-profile') {
                            if (window.navigateToSPA) {
                                window.navigateToSPA('index.php?controller=home');
                            } else {
                                window.location.href = 'index.php?controller=home';
                            }
                        }
                    } else {
                        alert('Đăng xuất thất bại. Vui lòng thử lại!');
                        logoutBtn.style.pointerEvents = '';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Lỗi kết nối máy chủ!');
                    logoutBtn.style.pointerEvents = '';
                });
            }
        });
    </script>
    <div class="main-content-wrapper" style="min-height: 150vh;">
        <div id="spa-viewport">
            <?php
            $activePageId = 'page-home';
            if ($currentController === 'product') {
                if (isset($_GET['action']) && $_GET['action'] === 'detail') {
                    $activePageId = 'page-detail';
                } else {
                    $activePageId = 'page-shop';
                }
            } else if ($currentController === 'cart') {
                $activePageId = 'page-cart';
            } else if ($currentController === 'profile') {
                $activePageId = 'page-profile';
            } else if ($currentController === 'auth') {
                $activePageId = 'page-auth';
            }
            ?>
            <div id="<?= $activePageId ?>" class="spa-page active">