<!DOCTYPE html>
<html lang="vi" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTB - Giai Điệu Của Riêng Bạn</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ==========================================================================
           1. BIẾN MÀU SẮC (THEME)
           ========================================================================== */
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

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.4s ease, color 0.4s ease;
            overflow-x: hidden;
            padding-top: 76px;
            position: relative;
        }

        /* ==========================================================================
           2. WATERMARK & HIỆU ỨNG HẠT LƠ LỬNG (NÉ CHUỘT)
           ========================================================================== */
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

        /* ==========================================================================
           3. NAVBAR THÔNG MINH
           ========================================================================== */
        .navbar {
            background-color: var(--nav-bg);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(12px);
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

        .nav-link:hover::after {
            width: 80%;
        }

        /* ==========================================================================
           4. HERO SECTION (VIDEO NỀN)
           ========================================================================== */
        .hero-section {
            position: relative;
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .video-background iframe {
            width: 100vw;
            height: 56.25vw;
            min-height: 100vh;
            min-width: 177.77vh;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        /* ==========================================================================
           5. THƯƠNG HIỆU: CHẠY NGANG & NẢY KẸO DẺO
           ========================================================================== */
        .marquee-wrapper {
            display: flex;
            overflow: hidden;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            background: var(--card-bg);
            padding: 25px 0;
            width: 100%;
        }

        .marquee-content {
            display: flex;
            flex-shrink: 0;
            animation: marqueeScroll 25s linear infinite;
        }

        @keyframes marqueeScroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .brand-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 45px;
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-color);
            cursor: pointer;
            opacity: 0.6;
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s, color 0.3s;
            white-space: nowrap;
        }

        .brand-item:hover {
            opacity: 1;
            color: #3b82f6;
            transform: translateY(-12px) scale(1.15);
        }

        /* ==========================================================================
           6. CARD SẢN PHẨM (CHUẨN E-COMMERCE TỐI GIẢN)
           ========================================================================== */
        .product-card-clean {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            position: relative;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .product-card-clean:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .img-container {
            position: relative;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            z-index: 1;
            overflow: hidden;
            border-radius: 8px;
        }

        .img-container img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .product-card-clean:hover .img-container img {
            transform: scale(1.1);
        }

        .pickup-badge {
            position: absolute;
            top: -15px;
            left: -15px;
            background-color: #dc2626;
            color: #ffffff;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.4);
            z-index: 10;
            transform: rotate(-15deg);
        }

        /* ==========================================================================
           7. CÁC THÀNH PHẦN KHÁC (PHỤ KIỆN, FAQ, TIN TỨC, FOOTER)
           ========================================================================== */
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

        .showcase-img {
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transition: transform 0.5s ease;
            width: 100%;
        }

        .showcase-img:hover {
            transform: scale(1.02);
        }

        .blog-img {
            height: 220px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
            width: 100%;
            transition: transform 0.5s ease;
        }

        .blog-img-wrapper {
            overflow: hidden;
            border-radius: 12px 12px 0 0;
        }

        .custom-card:hover .blog-img {
            transform: scale(1.05);
        }

        .accordion-item {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }

        .accordion-button {
            background-color: var(--card-bg);
            color: var(--text-color);
            font-weight: bold;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--faq-bg);
            color: #3b82f6;
            box-shadow: none;
        }

        .accordion-body {
            color: var(--text-color);
            opacity: 0.9;
        }

        footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 60px 0 20px 0;
            position: relative;
            z-index: 10;
        }

        .footer-text {
            color: var(--text-color);
            opacity: 0.8;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-text:hover {
            opacity: 1;
            color: #3b82f6;
        }

        /* ==========================================================================
           8. Preloader
           ========================================================================== */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #0a192f;
            /* Màu xanh dương tối đồng bộ */
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.8s ease, visibility 0.8s;
        }

        .loader-content {
            text-align: center;
        }

        /* Hiệu ứng sóng âm */
        .music-waves {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            height: 40px;
            gap: 5px;
            margin-bottom: 20px;
        }

        .music-waves span {
            width: 6px;
            height: 10px;
            background: #64ffda;
            /* Màu xanh ngọc thương hiệu */
            animation: wave-animation 1.2s infinite ease-in-out;
        }

        .music-waves span:nth-child(2) {
            animation-delay: 0.1s;
        }

        .music-waves span:nth-child(3) {
            animation-delay: 0.2s;
        }

        .music-waves span:nth-child(4) {
            animation-delay: 0.3s;
        }

        .music-waves span:nth-child(5) {
            animation-delay: 0.4s;
        }

        @keyframes wave-animation {

            0%,
            100% {
                height: 10px;
            }

            50% {
                height: 40px;
            }
        }

        .loader-text {
            color: white;
            font-weight: 800;
            letter-spacing: 5px;
            margin-bottom: 5px;
            animation: pulse 2s infinite;
        }

        .loader-subtext {
            color: #8892b0;
            font-style: italic;
            font-size: 0.9rem;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Class ẩn preloader */
        .preloader-hidden {
            opacity: 0;
            visibility: hidden;
        }

        /* ==========================================================================
           9. Modal đăng nhập
           ========================================================================== */
        /* ================= MODAL ĐĂNG NHẬP (FROSTED WATERMARK) ================= */

        /* ================= HIỆU ỨNG VIÊN CHUYỂN ĐỘNG (ANIMATED BORDER) ================= */
        .animated-border-wrapper {
            position: relative;
            border-radius: 1.6rem;
            z-index: 1;
            padding: 2px;
            /* Độ dày của viền gradient */
        }

        .animated-border-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 1.6rem;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899, #3b82f6);
            background-size: 300% 300%;
            animation: gradientBorderMove 6s linear infinite;
            z-index: -1;
        }

        @keyframes gradientBorderMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .glass-panel {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        /* Chữ Watermark chìm bên trong form */
        .form-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 12rem;
            font-weight: 900;
            color: var(--text-color);
            opacity: 0.03;
            /* Siêu mờ */
            z-index: 0;
            pointer-events: none;
            user-select: none;
        }

        /* Đẩy nội dung form lên trên watermark */
        .modal-body-content {
            position: relative;
            z-index: 2;
        }

        [data-theme="dark"] .glass-panel {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .modern-input {
            background: rgba(128, 128, 128, 0.05) !important;
            border: 1px solid var(--border-color);
            color: var(--text-color) !important;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .modern-input:focus {
            background: rgba(128, 128, 128, 0.1) !important;
            border-color: #3b82f6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }

        .form-floating label {
            color: var(--text-color);
            opacity: 0.6;
        }

        .btn-glow {
            background: #3b82f6;
            border: none;
            transition: 0.3s;
        }

        .btn-glow:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .social-btn {
            background: rgba(128, 128, 128, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            transition: all 0.3s;
        }

        .social-btn:hover {
            background: rgba(128, 128, 128, 0.1);
            transform: translateY(-2px);
        }

        .social-btn.google:hover {
            color: #ea4335;
            border-color: #ea4335;
        }

        .social-btn.facebook:hover {
            color: #1877f2;
            border-color: #1877f2;
        }
    </style>
</head>

<body>

    <div id="preloader">
        <div class="loader-content">
            <div class="music-waves">
                <span></span><span></span><span></span><span></span><span></span>
            </div>
            <h2 class="loader-text">TTB MUSIC</h2>
            <p class="loader-subtext">Đang tinh chỉnh giai điệu...</p>
        </div>
    </div>

    <style>

    </style>

    <script>
        // JS xử lý tắt màn hình Loading sau khi trang web tải xong
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            // Tạo độ trễ nhẹ 1s để khách kịp cảm nhận hiệu ứng
            setTimeout(() => {
                preloader.classList.add('preloader-hidden');
            }, 1000);
        });
    </script>

    <div class="watermark">TTB MUSIC</div>

    <div id="global-parallax"></div>

    <nav class="navbar navbar-expand-lg" id="smartNavbar">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">
                <i class="fas fa-music text-primary me-2"></i>TTB
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars" style="color: var(--text-color);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Cửa hàng</a></li>
                    <li class="nav-item"><a class="nav-link text-warning fw-bold" href="#">Cho Thuê Nhạc Cụ</a></li>
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
    <section class="hero-section text-center">
        <div class="video-background">
            <iframe src="https://www.youtube.com/embed/wNCDWk8mxXs?autoplay=1&mute=1&playlist=wNCDWk8mxXs&loop=1&controls=0&disablekb=1&fs=0&modestbranding=1&playsinline=1" frameborder="0" allow="autoplay; fullscreen"></iframe>
        </div>
        <div class="hero-overlay"></div>

        <div class="container hero-content" data-aos="zoom-in" data-aos-duration="1500">
            <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill">TTB COLLECTION 2024</span>
            <h1 class="display-2 fw-bolder mb-4 text-white">Giai Điệu Của Riêng Bạn</h1>
            <p class="lead mb-5 text-light mx-auto" style="max-width: 600px;">Hệ thống mua bán và cho thuê nhạc cụ chuyên nghiệp nhất. Thỏa mãn đam mê không lo về giá.</p>
            <button class="btn btn-primary btn-lg px-5 py-3 rounded-pill me-3 fw-bold">Khám Phá Ngay</button>
        </div>
    </section>

    <section class="marquee-wrapper my-5">
        <div class="marquee-content">
            <div class="brand-item"><i class="fas fa-record-vinyl me-2"></i> YAMAHA</div>
            <div class="brand-item"><i class="fas fa-guitar me-2"></i> FENDER</div>
            <div class="brand-item"><i class="fas fa-keyboard me-2"></i> ROLAND</div>
            <div class="brand-item"><i class="fas fa-drum me-2"></i> PEARL</div>
            <div class="brand-item"><i class="fas fa-headphones me-2"></i> MARSHALL</div>
            <div class="brand-item"><i class="fas fa-music me-2"></i> KORG</div>
        </div>
        <div class="marquee-content">
            <div class="brand-item"><i class="fas fa-record-vinyl me-2"></i> YAMAHA</div>
            <div class="brand-item"><i class="fas fa-guitar me-2"></i> FENDER</div>
            <div class="brand-item"><i class="fas fa-keyboard me-2"></i> ROLAND</div>
            <div class="brand-item"><i class="fas fa-drum me-2"></i> PEARL</div>
            <div class="brand-item"><i class="fas fa-headphones me-2"></i> MARSHALL</div>
            <div class="brand-item"><i class="fas fa-music me-2"></i> KORG</div>
        </div>
    </section>

    <section class="container mt-5 pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                <img src="https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?q=80&w=1000&auto=format&fit=crop" alt="Premium Piano" class="showcase-img">
            </div>
            <div class="col-lg-5 offset-lg-1" data-aos="fade-left" data-aos-duration="1000">
                <h6 class="text-primary fw-bold text-uppercase tracking-wide mb-2">Đẳng cấp hoàng gia</h6>
                <h2 class="display-5 fw-bold mb-4">Grand Piano Premium</h2>
                <p class="fs-5 mb-4" style="opacity: 0.8;">Sự kết hợp hoàn hảo giữa kỹ tác thủ công truyền thống và công nghệ âm thanh tiên tiến.</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Âm thanh cộng hưởng chuẩn Studio</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Thiết kế sang trọng, điểm nhấn phòng khách</li>
                </ul>
                <a href="#" class="btn btn-outline-primary rounded-pill px-4 py-2">Xem chi tiết <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <div class="container mt-5 pt-5 mb-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase">Bán chạy nhất</h6>
            <h2 class="display-6 fw-bold">Sản Phẩm Đang Hot Tại TTB</h2>
        </div>

        <div class="row g-5">
            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="product-card-clean">
                    <div class="pickup-badge">Pickup!</div>
                    <div class="img-container">
                        <img src="https://images.unsplash.com/photo-1550291652-6ea9114a47b1?q=80&w=600&auto=format&fit=crop" alt="Guitar">
                    </div>
                    <div class="text-center mt-auto">
                        <h5 class="fw-bold">Acoustic Yamaha F310</h5>
                        <p class="small text-muted mb-2">Gỗ vân sam, âm mộc chuẩn</p>
                        <p class="text-primary fw-bold fs-4 mb-3">3.500.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100"><i class="fas fa-shopping-cart me-2"></i>Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="product-card-clean">
                    <div class="pickup-badge bg-success">Mới!</div>
                    <div class="img-container">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR46ScgYanHHB2xG4ycGOi1boH4OPV5hEnnaQ&s" alt="Piano">
                    </div>
                    <div class="text-center mt-auto">
                        <h5 class="fw-bold">Roland Midi Keyboard</h5>
                        <p class="small text-muted mb-2">Phím gõ chân thực, siêu nhạy</p>
                        <p class="text-primary fw-bold fs-4 mb-3">16.900.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100"><i class="fas fa-shopping-cart me-2"></i>Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="product-card-clean">
                    <div class="pickup-badge bg-warning text-dark">Hot!</div>
                    <div class="img-container">
                        <img src="https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?q=80&w=600&auto=format&fit=crop" alt="Drum">
                    </div>
                    <div class="text-center mt-auto">
                        <h5 class="fw-bold">Trống Pearl Roadshow</h5>
                        <p class="small text-muted mb-2">Bộ 5 trống tiêu chuẩn</p>
                        <p class="text-primary fw-bold fs-4 mb-3">12.500.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100"><i class="fas fa-shopping-cart me-2"></i>Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="container mt-5 pt-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold">Tại Sao Chọn TTB Music?</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="custom-card p-4 h-100">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3 simple-hover-icon"></i>
                    <h5 class="fw-bold">Bảo hành 10 năm</h5>
                    <p class="mb-0" style="opacity: 0.8;">Cam kết hàng chính hãng, bảo hành trọn đời tại mọi chi nhánh.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="custom-card p-4 h-100">
                    <i class="fas fa-shipping-fast fa-3x text-primary mb-3 simple-hover-icon"></i>
                    <h5 class="fw-bold">Giao hàng Hỏa tốc</h5>
                    <p class="mb-0" style="opacity: 0.8;">Miễn phí vận chuyển toàn quốc cho đơn hàng từ 2.000.000đ.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="custom-card p-4 h-100">
                    <i class="fas fa-retweet fa-3x text-primary mb-3 simple-hover-icon"></i>
                    <h5 class="fw-bold">Dịch vụ Cho thuê</h5>
                    <p class="mb-0" style="opacity: 0.8;">Thỏa mãn đam mê với chi phí tiết kiệm qua dịch vụ thuê nhạc cụ.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5 pt-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase">Không thể thiếu</h6>
            <h2 class="display-6 fw-bold">Phụ Kiện Chính Hãng</h2>
        </div>
        <div class="row g-4">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="custom-card p-4 text-center">
                    <i class="fas fa-headphones-alt fa-3x text-secondary mb-3 simple-hover-icon"></i>
                    <h6 class="fw-bold">Tai nghe kiểm âm</h6>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="custom-card p-4 text-center">
                    <i class="fas fa-microphone fa-3x text-secondary mb-3 simple-hover-icon"></i>
                    <h6 class="fw-bold">Micro Thu Âm</h6>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="custom-card p-4 text-center">
                    <i class="fas fa-bolt fa-3x text-secondary mb-3 simple-hover-icon"></i>
                    <h6 class="fw-bold">Amply Guitar</h6>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="custom-card p-4 text-center">
                    <i class="fas fa-sliders-h fa-3x text-secondary mb-3 simple-hover-icon"></i>
                    <h6 class="fw-bold">Pedal & Phôi</h6>
                </div>
            </div>
        </div>
    </div>

    <section class="container mt-5 pt-5 mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4" data-aos="fade-up">
            <div>
                <h6 class="text-primary fw-bold text-uppercase">Cẩm nang âm nhạc</h6>
                <h2 class="display-6 fw-bold">Tin Tức Mới Nhất</h2>
            </div>
            <a href="#" class="btn btn-outline-primary rounded-pill d-none d-md-block">Xem tất cả</a>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="custom-card h-100">
                    <div class="blog-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 1">
                    </div>
                    <div class="p-4">
                        <span class="badge bg-primary mb-2">Hướng dẫn</span>
                        <h5 class="fw-bold">Cách chọn Guitar cho người mới</h5>
                        <p class="small mt-2" style="opacity: 0.8;">Các tiêu chí quan trọng để chọn đàn phù hợp với vóc dáng và phong cách.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="custom-card h-100">
                    <div class="blog-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1501612780327-45045538702b?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 2">
                    </div>
                    <div class="p-4">
                        <span class="badge bg-success mb-2">Review</span>
                        <h5 class="fw-bold">Đánh giá chi tiết Roland RP-30</h5>
                        <p class="small mt-2" style="opacity: 0.8;">Liệu đây có phải là cây đàn Piano điện quốc dân trong tầm giá?</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="custom-card h-100">
                    <div class="blog-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 3">
                    </div>
                    <div class="p-4">
                        <span class="badge bg-warning text-dark mb-2">Sự kiện</span>
                        <h5 class="fw-bold">Sự kiện Workshop: Kỹ thuật Slap</h5>
                        <p class="small mt-2" style="opacity: 0.8;">Đăng ký tham gia ngay buổi workshop cùng tay bass hàng đầu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5 pt-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase">Hỗ trợ khách hàng</h6>
            <h2 class="display-6 fw-bold">Câu Hỏi Thường Gặp (FAQ)</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item mb-3 rounded border">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="fas fa-question-circle text-primary me-2"></i> Quy trình thuê nhạc cụ tại TTB diễn ra thế nào?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chọn nhạc cụ dán nhãn <strong>"Cho Thuê"</strong>, chọn ngày trên lịch. Hệ thống tự tính tiền thuê và tiền cọc. Nhạc cụ được giao tận nhà.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3 rounded border">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="fas fa-tools text-primary me-2"></i> Chính sách bảo hành của TTB kéo dài bao lâu?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                TTB bảo hành chính hãng từ <strong>1 đến 10 năm</strong>. Trong 30 ngày đầu, hỗ trợ lỗi 1 đổi 1 tận nhà miễn phí.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item rounded border">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="fas fa-credit-card text-primary me-2"></i> Shop có hỗ trợ mua trả góp không?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có! TTB hỗ trợ trả góp 0% lãi suất qua thẻ tín dụng của hơn 25 ngân hàng.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5 pt-5 mb-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold">Khách Hàng Nói Gì Về TTB?</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-right">
                <div class="custom-card p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-size: 20px;">T</div>
                        <div>
                            <h6 class="fw-bold mb-0">Anh Tuấn</h6>
                            <small class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></small>
                        </div>
                    </div>
                    <p class="fst-italic" style="opacity: 0.8;">"Đã mua cây Fender Stratocaster ở TTB. Chất lượng tuyệt vời, nhân viên tư vấn rất có tâm. Hỗ trợ cho thuê nhạc cụ rất tiện lợi!"</p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="custom-card p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-size: 20px;">L</div>
                        <div>
                            <h6 class="fw-bold mb-0">Hương Ly</h6>
                            <small class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></small>
                        </div>
                    </div>
                    <p class="fst-italic" style="opacity: 0.8;">"Thuê đàn Piano 1 tháng ở TTB để tập trước khi quyết định mua. Thủ tục cực kỳ nhanh gọn, tiền cọc rõ ràng."</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5 py-5" data-aos="zoom-in">
        <div class="custom-card p-5 text-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none;">
            <h2 class="fw-bold mb-3">Nhận Voucher Giảm Giá 10%</h2>
            <p class="mb-4 opacity-75">Đăng ký email để nhận ngay mã giảm giá và thông tin các nhạc cụ mới nhất tại TTB.</p>
            <div class="input-group mb-3 mx-auto" style="max-width: 500px;">
                <input type="email" class="form-control form-control-lg" placeholder="Nhập email của bạn...">
                <button class="btn btn-dark px-4 fw-bold" type="button">Đăng ký</button>
            </div>
        </div>
    </section>

    <footer class="mt-5 pt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-3"><i class="fas fa-music text-primary me-2"></i>TTB MUSIC</h4>
                    <p class="footer-text">Hệ thống mua bán và cho thuê nhạc cụ hàng đầu, giúp bạn tự tự tin tỏa sáng và viết nên giai điệu của riêng mình.</p>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-4">
                    <h5 class="fw-bold mb-3">Danh mục</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-text">Guitar & Bass</a></li>
                        <li class="mb-2"><a href="#" class="footer-text">Piano & Organ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-3">Dịch vụ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-text text-warning fw-bold">Cho Thuê Nhạc Cụ</a></li>
                        <li class="mb-2"><a href="#" class="footer-text">Bảo hành & Sửa chữa</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="fw-bold mb-3">Liên hệ</h5>
                    <ul class="list-unstyled footer-text">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Quận 1, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i> 1900 1000</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: var(--border-color); opacity: 0.2;">
            <div class="text-center footer-text small">
                &copy; 2024 TTB MUSIC. Dự án PHP MVC.
            </div>
        </div>
    </footer>

    <?php include __DIR__ . '/partials/chat_and_scroll.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Khởi chạy AOS Animation
        AOS.init({
            once: true,
            offset: 100
        });

        // JAVASCRIPT: Logic ẩn hiện Smart Navbar khi cuộn trang
        let prevScrollpos = window.pageYOffset;
        const navbar = document.getElementById("smartNavbar");
        window.onscroll = function() {
            let currentScrollPos = window.pageYOffset;
            if (currentScrollPos <= 50) {
                navbar.style.top = "0";
                navbar.style.boxShadow = "none";
            } else {
                navbar.style.boxShadow = "0 4px 15px rgba(0,0,0,0.1)";
                if (prevScrollpos > currentScrollPos) {
                    navbar.style.top = "0";
                } else {
                    navbar.style.top = "-100px";
                }
            }
            prevScrollpos = currentScrollPos;
        }

        // JAVASCRIPT: Logic nút Bật/Tắt Light/Dark Theme
        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        const icon = themeToggleBtn.querySelector('i');
        const savedTheme = localStorage.getItem('theme') || 'dark';
        htmlElement.setAttribute('data-theme', savedTheme);
        icon.className = savedTheme === 'dark' ? 'fas fa-sun text-warning' : 'fas fa-moon text-dark';

        themeToggleBtn.addEventListener('click', () => {
            const newTheme = htmlElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            icon.className = newTheme === 'dark' ? 'fas fa-sun text-warning' : 'fas fa-moon text-dark';
        });

        // JAVASCRIPT: Logic các hạt nốt nhạc bay và né con trỏ chuột
        const parallaxContainer = document.getElementById('global-parallax');
        const fontIcons = ['fa-music', 'fa-guitar', 'fa-headphones', 'fa-drum', 'fa-play'];
        const notes = [];
        let mouseX = -1000,
            mouseY = -1000;

        // Sinh ra 50 hạt nền
        for (let i = 0; i < 50; i++) {
            let wrapper = document.createElement('div');
            wrapper.className = 'note-wrapper';
            wrapper.style.left = Math.random() * 100 + 'vw';
            wrapper.style.top = Math.random() * 100 + 'vh';
            wrapper.style.animationDelay = (Math.random() * 10) + 's';

            let iconElem = document.createElement('i');
            let randomIcon = fontIcons[Math.floor(Math.random() * fontIcons.length)];
            iconElem.className = `fas ${randomIcon} note-icon`;
            iconElem.style.fontSize = (Math.random() * 1.5 + 0.5) + 'rem';

            wrapper.appendChild(iconElem);
            parallaxContainer.appendChild(wrapper);

            notes.push({
                wrapper: wrapper,
                icon: iconElem,
                currentX: 0,
                currentY: 0
            });
        }

        // Cập nhật vị trí chuột
        window.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        // Hàm animation né chuột
        function animateRepel() {
            notes.forEach(note => {
                let rect = note.wrapper.getBoundingClientRect();
                let iconCenterX = rect.left + rect.width / 2;
                let iconCenterY = rect.top + rect.height / 2;

                let dx = iconCenterX - mouseX;
                let dy = iconCenterY - mouseY;
                let distance = Math.sqrt(dx * dx + dy * dy);

                const repelRadius = 150; // Khoảng cách né là 150px

                if (distance < repelRadius) {
                    let force = (repelRadius - distance) / repelRadius;
                    let angle = Math.atan2(dy, dx);
                    let pushX = Math.cos(angle) * force * 60;
                    let pushY = Math.sin(angle) * force * 60;

                    note.icon.style.transition = 'none';
                    note.icon.style.transform = `translate(${pushX}px, ${pushY}px)`;
                } else {
                    note.icon.style.transition = 'transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1)';
                    note.icon.style.transform = `translate(0px, 0px)`;
                }
            });
            requestAnimationFrame(animateRepel);
        }

        animateRepel();
    </script>
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">

                <div class="animated-border-wrapper">
                    <div class="glass-panel p-4 border-0">

                        <div class="form-watermark"><i class="fas fa-music"></i></div>

                        <div class="modal-body-content">
                            <div class="modal-header border-0 pb-3 px-0 position-relative d-flex justify-content-center text-center">
                                <div>
                                    <h3 class="modal-title fw-bolder mb-1" id="loginModalLabel" style="color: var(--text-color);">
                                        <i class="fas fa-user-circle text-primary me-2"></i>Đăng Nhập
                                    </h3>
                                    <p class="small mb-0" style="color: var(--text-color); opacity: 0.7;">Viết tiếp giai điệu của bạn tại TTB Music.</p>
                                </div>
                                <button type="button" class="btn-close position-absolute top-0 end-0 mt-1" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body px-0 pb-0 pt-2">
                                <form action="index.php?controller=auth&action=login" method="POST">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control modern-input" id="floatingEmail" name="email" placeholder="name@example.com" required>
                                        <label for="floatingEmail"><i class="fas fa-envelope me-2"></i>Email của bạn</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control modern-input" id="floatingPassword" name="password" placeholder="Password" required>
                                        <label for="floatingPassword"><i class="fas fa-lock me-2"></i>Mật khẩu</label>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label small" for="rememberMe" style="color: var(--text-color); opacity: 0.8;">Nhớ tài khoản</label>
                                        </div>
                                        <a href="index.php?controller=auth&action=forgot" class="text-primary text-decoration-none small fw-bold">Quên mật khẩu?</a>
                                    </div>

                                    <button type="submit" class="btn btn-glow btn-lg w-100 fw-bold rounded-pill text-white py-3">
                                        ĐĂNG NHẬP <i class="fas fa-sign-in-alt ms-2"></i>
                                    </button>
                                </form>

                                <div class="position-relative my-4 text-center">
                                    <hr style="border-color: var(--border-color); opacity: 0.5;">
                                    <span class="position-absolute top-50 start-50 translate-middle px-3 small fw-semibold" style="background-color: var(--card-bg); color: var(--text-color); opacity: 0.6;">
                                        Hoặc tiếp tục với
                                    </span>
                                </div>

                                <div class="d-flex gap-3">
                                    <button class="btn social-btn google w-50 rounded-pill py-2 fw-semibold">
                                        <i class="fab fa-google me-2"></i> Google
                                    </button>
                                    <button class="btn social-btn facebook w-50 rounded-pill py-2 fw-semibold">
                                        <i class="fab fa-facebook-f me-2"></i> Facebook
                                    </button>
                                </div>

                                <div class="mt-4 pt-3 text-center">
                                    <p class="mb-0 small" style="color: var(--text-color);">
                                        Chưa có tài khoản? <a href="index.php?controller=auth&action=register" class="text-primary text-decoration-none fw-bolder fs-6">Tạo ngay</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
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

        // Kiểm tra xem hàm (action) có tồn tại trong Controller không
        if (method_exists($controller, $actionName)) {
            $controller->$actionName();
        } else {
            die("Lỗi 404: Không tìm thấy phương thức {$actionName} trong {$controllerName}!");
        }
    } else {
        die("Lỗi 404: Không tìm thấy trang (Controller {$controllerName} không tồn tại)!");
    }
    ?>
</body>

</html>