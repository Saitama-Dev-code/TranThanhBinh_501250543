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
// - Tắt preloader cho toàn bộ phân trang/cửa hàng (khi đang ở controller 'product')
//   để tránh việc người dùng click vào "Tất cả nhạc cụ" hoặc "Lọc" bị chớp màn hình.
// =========================================================================
$isFiltering = ($currentController == 'product');
?>
<!DOCTYPE html>
<html lang="vi" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'TTB - Giai Điệu Của Riêng Bạn' ?></title>

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

        /* GIỮ NGUYÊN CSS BODY GỐC: Tránh xung đột với Parallax và hiệu ứng nốt nhạc */
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
            transition: background-color 0.4s ease, color 0.4s ease;
            overflow-x: hidden;
            padding-top: 76px;
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
            animation: textPulse 2s infinite;
        }

        @keyframes textPulse {
            0%, 100% { opacity: 1; text-shadow: 0 0 10px rgba(255, 255, 255, 0.2); }
            50% { opacity: 0.6; text-shadow: none; }
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
            <h2 class="loader-text">TTB MUSIC</h2>
            <p class="loader-subtext">Đang chuẩn bị giai điệu...</p>
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
        let mouse = { x: null, y: null, radius: 100 };
        
        window.addEventListener('mousemove', function(e) {
            mouse.x = e.x;
            mouse.y = e.y;
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
                this.opacity = 0.05;
                this.color = '#cbd5e1'; // Màu mặc định mờ
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
                    this.opacity = Math.min(this.opacity + 0.05, 0.8);
                    this.color = '#3b82f6'; // Sáng màu xanh
                } else {
                    this.hoverScale = Math.max(this.hoverScale - 0.05, 1);
                    this.opacity = Math.max(this.opacity - 0.02, 0.05);
                    this.color = '#cbd5e1'; // Trở lại màu gốc
                }
            }

            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.angle * Math.PI / 180);
                ctx.scale(this.hoverScale, this.hoverScale);
                
                ctx.globalAlpha = this.opacity;
                ctx.fillStyle = this.color;
                
                if (this.isHovered) {
                    ctx.shadowBlur = 15;
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

        // Tạo mảng hạt
        for (let i = 0; i < 35; i++) {
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
            <a class="navbar-brand fw-bold fs-4" href="index.php?controller=home">
                <i class="fas fa-music text-primary me-2"></i>TTB
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars" style="color: var(--text-color);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentController == 'home') ? 'active' : '' ?>"
                            href="<?= ($currentController == 'home') ? '#top' : 'index.php?controller=home' ?>"
                            onclick="<?= ($currentController == 'home') ? 'window.scrollTo({top: 0, behavior: \'smooth\'}); return false;' : '' ?>">
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
                    <a href="#" class="btn btn-outline-primary me-2 rounded-pill px-3"><i class="fas fa-shopping-cart"></i> (0)</a>
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-user"></i> Đăng nhập
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <div class="main-content-wrapper" style="min-height: 75vh;">