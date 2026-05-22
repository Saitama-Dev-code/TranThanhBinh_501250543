<?php
/**
 * VIEW: TRANG CHỦ (HOMEPAGE)
 * - Chứa Banner Hero với hiệu ứng video background, 3D tilt logo, và ripple effect.
 * - Showcase sản phẩm nổi bật với hiệu ứng Parallax và Glassmorphism.
 * - Hệ thống nốt nhạc rơi ngẫu nhiên trên toàn trang.
 */

// Gọi Header
include __DIR__ . '/partials/header.php';
?>

<style>
    /* CSS dành riêng cho trang chủ */
    .hero-section { position: relative; height: 90vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .video-background { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
    .video-background iframe { width: 100vw; height: 56.25vw; min-height: 100vh; min-width: 177.77vh; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
    
    /* Overlay làm tối video và làm nổi bật Slogan */
    .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.75); z-index: 2; pointer-events: none; }
    .hero-content { position: relative; z-index: 3; color: white; text-shadow: 2px 2px 15px rgba(0,0,0,0.9); }
    
    /* ================= DẢI THƯƠNG HIỆU MARQUEE CHẠY NGANG VÔ HẠN ================= */
    .brand-marquee-container {
        overflow: hidden;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        background: var(--card-bg);
        padding: 30px 0;
        width: 100%;
        display: flex;
        position: relative;
    }
    
    .brand-marquee-track {
        display: flex;
        width: max-content;
        gap: 60px;
    }
    
    .brand-marquee-group {
        display: flex;
        align-items: center;
        gap: 60px;
        animation: scrollMarquee 35s linear infinite;
        flex-shrink: 0;
    }
    
    /* Tạm dừng chạy khi di chuột vào toàn bộ khung */
    .brand-marquee-container:hover .brand-marquee-group {
        animation-play-state: paused;
    }
    
    @keyframes scrollMarquee {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(calc(-100% - 60px), 0, 0); }
    }
    
    .brand-item {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--text-color);
        cursor: pointer;
        opacity: 0.5;
        /* Hiệu ứng chuyển động mượt mà khi hover và khi rê chuột ra (tự rớt xuống chậm rãi) */
        transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), opacity 0.4s ease, color 0.4s ease, text-shadow 0.4s ease;
        white-space: nowrap;
    }
    
    /* Chỉ khi hover mới nhảy lên và sáng màu */
    .brand-item:hover {
        opacity: 1;
        color: #3b82f6;
        transform: translateY(-12px) scale(1.12);
        text-shadow: 0 10px 22px rgba(59, 130, 246, 0.5);
    }

    /* ================= HIỆU ỨNG CUỘN TƯƠNG TÁC (SCROLL-DRIVEN INTERACTIVE) ================= */
    /* Lớp cha lưu trữ tiến trình cuộn nhận từ JS */
    .scroll-track {
        --scroll-progress: 0;
    }
    
    /* Hiệu ứng lót nền dưới khối overlap để không bị lộ khung */
    .overlap-showcase-container {
        position: relative;
        background: var(--bg-color); /* Cùng màu nền trang */
        z-index: 1;
        overflow: visible; /* Quan trọng để không bị clipping */
        padding: 100px 0;
    }
    
    /* Đốm màu nền mờ - Từ nhỏ phóng to dần ở giữa */
    .scroll-blob {
        opacity: calc(0.3 * var(--scroll-progress)) !important;
        transform: scale(var(--scroll-progress)) !important;
        transition: transform 0.15s ease-out, opacity 0.15s ease-out;
    }
    
    /* Card nền màu phẳng */
    .scroll-shape {
        opacity: calc(0.9 * var(--scroll-progress)) !important;
        transform: scale(var(--scroll-progress)) !important;
        transition: transform 0.15s ease-out, opacity 0.15s ease-out;
    }
    
    /* Chủ thể bên trái - Góc trái trên đi xuống chéo, xoay từ -25deg về -8deg */
    .scroll-img-left {
        opacity: var(--scroll-progress) !important;
        transform: translate(calc(-100px * (1 - var(--scroll-progress))), calc(-100px * (1 - var(--scroll-progress)))) rotate(calc(-25deg + 17deg * var(--scroll-progress))) scale(calc(0.85 + 0.15 * var(--scroll-progress))) !important;
        transition: transform 0.15s ease-out, opacity 0.15s ease-out;
        /* Ngăn bị khung container che khuất khi chưa xuất hiện */
        will-change: transform, opacity;
    }
    
    /* Đè cấu hình hover mượt mà và tự rơi lại trạng thái cuộn */
    .scroll-img-left:hover {
        transform: translate(0, -15px) rotate(-5deg) scale(1.05) !important;
        z-index: 10 !important;
    }
    
    /* Chủ thể bên phải - Góc dưới phải đi lên chéo, xoay từ 25deg về 5deg */
    .scroll-img-right {
        opacity: var(--scroll-progress) !important;
        transform: translate(calc(100px * (1 - var(--scroll-progress))), calc(100px * (1 - var(--scroll-progress)))) rotate(calc(25deg - 20deg * var(--scroll-progress))) scale(calc(0.8 + 0.2 * var(--scroll-progress))) !important;
        transition: transform 0.15s ease-out, opacity 0.15s ease-out;
        will-change: transform, opacity;
    }
    
    .scroll-img-right:hover {
        transform: translate(0, -15px) rotate(8deg) scale(1.05) !important;
        z-index: 10 !important;
    }
    
    /* Cột chữ bên phải di chuyển từ phải qua */
    .scroll-text-col {
        opacity: var(--scroll-progress) !important;
        transform: translateX(calc(120px * (1 - var(--scroll-progress)))) !important;
        transition: transform 0.15s ease-out, opacity 0.15s ease-out;
    }
    
    /* Hiệu ứng trượt thẳng đứng tịnh tiến (không xoay) */
    .scroll-slide-up {
        opacity: var(--scroll-progress) !important;
        transform: translateY(calc(80px * (1 - var(--scroll-progress)))) !important;
        transition: transform 0.15s ease-out, opacity 0.15s ease-out;
    }

    .product-card-clean { background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; position: relative; padding: 20px; height: 100%; display: flex; flex-direction: column; transition: box-shadow 0.3s ease, border-color 0.3s ease; }
    .product-card-clean:hover { box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); border-color: #3b82f6; }
    .img-container { position: relative; height: 220px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; z-index: 1; overflow: hidden; border-radius: 8px; }
    .img-container img { height: 100%; width: 100%; object-fit: cover; transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1); }
    .product-card-clean:hover .img-container img { transform: scale(1.1); }
    
    .pickup-badge { position: absolute; top: -15px; left: -15px; background-color: #dc2626; color: #ffffff; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 14px; box-shadow: 0 4px 10px rgba(220, 38, 38, 0.4); z-index: 10; transform: rotate(-15deg); }
    
    .showcase-img { border-radius: 15px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); transition: transform 0.5s ease; width: 100%; }
    .showcase-img:hover { transform: scale(1.02); }
    .blog-img { height: 220px; object-fit: cover; border-radius: 12px 12px 0 0; width: 100%; transition: transform 0.5s ease; }
    .blog-img-wrapper { overflow: hidden; border-radius: 12px 12px 0 0; }
    .custom-card:hover .blog-img { transform: scale(1.05); }

    .accordion-item { background-color: var(--card-bg); border-color: var(--border-color); }
    .accordion-button { background-color: var(--card-bg); color: var(--text-color); font-weight: bold; }
    .accordion-button:not(.collapsed) { background-color: var(--faq-bg); color: #3b82f6; box-shadow: none; }
    .accordion-body { color: var(--text-color); opacity: 0.9; }

    /* ================= THIẾT KẾ LOGO LỚN TRÊN HERO BANNER ================= */
    .hero-logo-title {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-weight: 900;
        font-size: 8.5rem; 
        color: rgba(255, 255, 255, 0.45); /* Tăng độ sáng Watermark lên 0.45 để nổi bật hơn */
        gap: 0px; 
        margin-bottom: 0px;
        user-select: none;
        transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1), color 0.6s ease;
        position: relative;
        z-index: 10;
        padding: 0;
        background: transparent;
        backdrop-filter: none;
        border: none;
        box-shadow: none;
    }

    .hero-logo-title .char-t1, .hero-logo-title .char-t2, .hero-logo-title .char-b {
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Dựng chữ T1 to trong banner */
    .hero-logo-title .char-t1 {
        position: relative;
        display: inline-block;
        width: 85px;
        height: 110px;
    }
    .hero-logo-title .char-t1 .bar-top {
        position: absolute;
        top: 10px;
        left: 0;
        width: 85px;
        height: 20px;
        background-color: currentColor;
        transform-origin: right center;
    }
    .hero-logo-title .char-t1 .bar-stem {
        position: absolute;
        top: 10px;
        left: 32.5px;
        width: 20px;
        height: 100px;
        background-color: currentColor;
        transform-origin: top center;
    }

    /* Dựng chữ T2 to trong banner */
    .hero-logo-title .char-t2 {
        position: relative;
        display: inline-block;
        width: 85px;
        height: 110px;
    }
    .hero-logo-title .char-t2 .bar-top {
        position: absolute;
        top: 10px;
        left: 0;
        width: 85px;
        height: 20px;
        background-color: currentColor;
        transform-origin: center center;
    }
    .hero-logo-title .char-t2 .bar-stem {
        position: absolute;
        top: 10px;
        left: 32.5px;
        width: 20px;
        height: 100px;
        background-color: currentColor;
        transform-origin: top center;
    }

    /* Dựng chữ B to trong banner */
    .hero-logo-title .char-b {
        font-size: 9rem;
        line-height: 110px;
        font-weight: 900;
        display: inline-block;
        color: currentColor;
        font-family: 'Outfit', sans-serif;
        margin-left: -5px;
    }

    /* Chữ MUSIC */
    .hero-logo-title .text-music {
        font-size: 7rem;
        color: currentColor;
        margin-left: 20px;
        font-weight: 900;
        letter-spacing: 6px;
        transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    /* Khi hover vào logo container -> Hiện rõ và morphing */
    .hero-logo-title:hover {
        color: rgba(255, 255, 255, 0.95);
        transform: scale(1.05);
    }
    .hero-logo-title:hover .char-t1 .bar-top {
        transform: scaleX(0.55) translateX(5px);
        background-color: #3b82f6;
    }
    .hero-logo-title:hover .char-t1 .bar-stem {
        transform: rotate(15deg) translateX(8px);
        background-color: #3b82f6;
    }
    .hero-logo-title:hover .char-t2 {
        transform: translateX(-20px);
    }
    .hero-logo-title:hover .char-t2 .bar-top {
        transform: scaleX(0); 
    }
    .hero-logo-title:hover .char-t2 .bar-stem {
        background-color: #3b82f6;
    }
    .hero-logo-title:hover .char-b {
        color: #3b82f6;
        transform: translateX(-45px) scale(1.05);
    }
    .hero-logo-title:hover .text-music {
        transform: translateX(-65px);
        color: #ffffff;
        letter-spacing: 12px;
    }

    /* Watermark trên video */
    .video-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-12deg);
        font-size: 13vw;
        font-weight: 900;
        font-style: italic;
        color: rgba(255, 255, 255, 0.022); /* Rất mờ ảo hòa quyện video */
        pointer-events: none;
        user-select: none;
        z-index: 1; /* Sau text slogan, đè lên video */
        white-space: nowrap;
        font-family: 'Outfit', sans-serif;
        letter-spacing: 5px;
    }

    /* Video background có hỗ trợ filter bẻ cong */
    .video-warp-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    #ripple-circle {
        position: absolute;
        width: 450px; /* To hơn chút cho mượt */
        height: 450px;
        border-radius: 50%;
        pointer-events: none;
        z-index: 1; /* Đưa ra sau overlay và content để không ảnh hưởng Logo */
        /* Sử dụng backdrop-filter để chỉ bẻ cong phần nền dưới hình tròn này */
        backdrop-filter: url(#video-warp-filter);
        -webkit-backdrop-filter: url(#video-warp-filter);
        transform: translate(-50%, -50%);
        display: none; /* Chỉ hiện khi di chuột */
        transition: backdrop-filter 0.3s ease; /* Thêm transition cho mượt */
    }

    @media (max-width: 768px) {
        .hero-logo-title { font-size: 3rem; }
        .hero-logo-title .text-music { font-size: 3rem; }
        .hero-logo-title .char-t1, .hero-logo-title .char-t2 { width: 36px; height: 44px; }
        .hero-logo-title .char-t1 .bar-top, .hero-logo-title .char-t2 .bar-top { width: 36px; height: 6px; }
        .hero-logo-title .char-t1 .bar-stem, .hero-logo-title .char-t2 .bar-stem { left: 15px; width: 6px; height: 40px; }
        .hero-logo-title .char-b { font-size: 3.1rem; line-height: 44px; }
        .video-watermark { font-size: 10vw; }
    }

    /* ================= SHOWCASE GRAND PIANO GLASS BANNER ================= */
    .grand-piano-showcase {
        position: relative;
        height: 550px;
        overflow: hidden;
        border-radius: 24px;
        margin: 80px auto;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);
        /* Tránh bị cắt khung khi chưa xuất hiện */
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.6s ease-out;
    }
    
    .grand-piano-showcase.visible {
        visibility: visible;
        opacity: 1;
    }
    
    /* Nền của banner - Hiệu ứng cuộn Parallax phóng to thu nhỏ động */
    .piano-banner-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        z-index: 0;
        transform: scale(calc(1.15 - 0.1 * var(--scroll-progress))) translate3d(0, calc(-20px * (1 - var(--scroll-progress))), 0);
        transition: transform 0.1s ease-out;
    }
    
    .grand-piano-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(15, 23, 42, 0.85) 30%, rgba(15, 23, 42, 0.1) 80%);
        z-index: 1;
    }
    
    .grand-piano-container {
        position: relative;
        z-index: 2;
    }
    
    .piano-glass-card {
        background: rgba(30, 41, 59, 0.55);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 40px;
        max-width: 520px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    /* Hiệu ứng trượt ngang từ trái sang, xoay nhẹ, và hiện dần theo cuộn chuột */
    .scroll-slide-left {
        opacity: var(--scroll-progress) !important;
        transform: translateX(calc(-120px * (1 - var(--scroll-progress)))) rotate(calc(-3deg * (1 - var(--scroll-progress)))) scale(calc(0.92 + 0.08 * var(--scroll-progress))) !important;
        border-color: rgba(59, 130, 246, calc(0.08 + 0.22 * var(--scroll-progress))) !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, calc(0.3 + 0.2 * var(--scroll-progress))), 
                    0 0 30px rgba(59, 130, 246, calc(0.2 * var(--scroll-progress))) !important;
        transition: transform 0.1s ease-out, opacity 0.1s ease-out, border-color 0.2s, box-shadow 0.2s;
    }

    @media (max-width: 768px) {
        .grand-piano-showcase {
            height: auto;
            padding: 40px 0;
        }
        .piano-glass-card {
            margin: 0 15px;
            padding: 24px;
        }
    }
</style>

<section class="hero-section text-center" id="hero-banner">
    <!-- SVG Filter bẻ cong cục bộ trên video -->
    <svg style="display: none;">
      <defs>
        <filter id="video-warp-filter" x="-10%" y="-10%" width="120%" height="120%">
          <feTurbulence type="fractalNoise" baseFrequency="0.008" numOctaves="1" result="noise" seed="1"/>
          <feDisplacementMap in="SourceGraphic" in2="noise" scale="0" xChannelSelector="R" yChannelSelector="G" id="warp-displacement-map" />
        </filter>
      </defs>
    </svg>

    <!-- Khung video có hiệu ứng bẻ cong (warp) -->
    <div class="video-warp-container">
        <div class="video-background">
            <iframe src="https://www.youtube.com/embed/wNCDWk8mxXs?autoplay=1&mute=1&playlist=wNCDWk8mxXs&loop=1&controls=0&disablekb=1&fs=0&modestbranding=1&playsinline=1" frameborder="0" allow="autoplay; fullscreen"></iframe>
        </div>
    </div>
    
    <!-- Hiệu ứng Ripple (vòng tròn bẻ cong) chạy theo con trỏ chuột -->
    <div id="ripple-circle"></div>
    
    <div class="hero-overlay"></div>
    <div class="container hero-content" id="hero-content" data-aos="zoom-in" data-aos-duration="1500">
        
        <!-- Slogan chuyển thành tên thương hiệu to bản dạng morphing (Watermark style) -->
        <h1 class="hero-logo-title" id="hero-logo">
            <span class="char-t1">
                <span class="bar-top"></span>
                <span class="bar-stem"></span>
            </span>
            <span class="char-t2">
                <span class="bar-top"></span>
                <span class="bar-stem"></span>
            </span>
            <span class="char-b">B</span>
            <span class="text-music">MUSIC</span>
        </h1>
        
        <!-- Đã gỡ bỏ nút Khám phá ngay theo yêu cầu để tôn vinh Logo Watermark -->
    </div>
</section>

<!-- DẢI THƯƠNG HIỆU CHẠY NGANG VÔ HẠN (INFINITE MARQUEE) -->
<div class="brand-marquee-container my-5">
    <div class="brand-marquee-track">
        <!-- Nhóm 1 -->
        <div class="brand-marquee-group">
            <div class="brand-item"><i class="fas fa-record-vinyl me-2"></i> YAMAHA</div>
            <div class="brand-item"><i class="fas fa-guitar me-2"></i> FENDER</div>
            <div class="brand-item"><i class="fas fa-keyboard me-2"></i> ROLAND</div>
            <div class="brand-item"><i class="fas fa-drum me-2"></i> PEARL</div>
            <div class="brand-item"><i class="fas fa-headphones me-2"></i> MARSHALL</div>
            <div class="brand-item"><i class="fas fa-music me-2"></i> KORG</div>
            <div class="brand-item"><i class="fas fa-sliders-h me-2"></i> KAWAI</div>
            <div class="brand-item"><i class="fas fa-microphone-alt me-2"></i> SHURE</div>
        </div>
        <!-- Nhóm 2 (nhân bản giống hệt nhóm 1 để lặp vô tận không bị trống) -->
        <div class="brand-marquee-group" aria-hidden="true">
            <div class="brand-item"><i class="fas fa-record-vinyl me-2"></i> YAMAHA</div>
            <div class="brand-item"><i class="fas fa-guitar me-2"></i> FENDER</div>
            <div class="brand-item"><i class="fas fa-keyboard me-2"></i> ROLAND</div>
            <div class="brand-item"><i class="fas fa-drum me-2"></i> PEARL</div>
            <div class="brand-item"><i class="fas fa-headphones me-2"></i> MARSHALL</div>
            <div class="brand-item"><i class="fas fa-music me-2"></i> KORG</div>
            <div class="brand-item"><i class="fas fa-sliders-h me-2"></i> KAWAI</div>
            <div class="brand-item"><i class="fas fa-microphone-alt me-2"></i> SHURE</div>
        </div>
    </div>
</div>

<!-- =================================================================
     SECTION: HIỆU ỨNG XẾP LỚP (STAGGERED OVERLAP EFFECT)
     Sửa lỗi clipping: Bỏ hoàn toàn overflow-hidden để hình ảnh không bị cắt khi trôi chéo.
     Sử dụng JS để tính toán --scroll-progress nhằm tạo hiệu ứng trượt mượt mà.
     ================================================================= -->
<section class="container mt-5 pt-5 pb-5 scroll-track" style="overflow: visible !important;">
    <div class="row align-items-center">
        <?php
        /**
         * KHỐI HÌNH ẢNH OVERLAP (XẾP LỚP)
         * - scroll-img-left: Ảnh chính trôi từ trên-trái xuống.
         * - scroll-img-right: Ảnh phụ trôi từ dưới-phải lên.
         * - scroll-blob: Đốm màu mờ ảo làm nền cho hình ảnh.
         */
        ?>
        <div class="col-lg-6 position-relative mb-5 mb-lg-0" style="height: 500px; overflow: visible;">
            
            <!-- Khối màu nền mờ ảo (Soft Background Blob) -->
            <div class="position-absolute bg-primary rounded-circle scroll-blob" 
                 style="width: 350px; height: 350px; top: 10%; left: 10%; filter: blur(80px); z-index: 1;"></div>
                 
            <!-- Khối nền định hình (Shape Background) -->
            <div class="position-absolute rounded-4 scroll-shape" 
                 style="width: 380px; height: 380px; bottom: 0; left: 5; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.15)); z-index: 1;"></div>

            <!-- Chủ thể 1: Đàn Guitar điện / Nhạc cụ chính (Trượt từ trái, có góc xoay nhẹ mượt) -->
            <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=600&auto=format&fit=crop" 
                 alt="Modern Instrument" 
                 class="position-absolute rounded-4 shadow-lg scroll-img-left" 
                 style="width: 260px; height: 380px; top: 5%; left: 10%; object-fit: cover; z-index: 2;">
                 
            <!-- Chủ thể 2: Phụ kiện / Keyboard nhỏ đè lên góc dưới của Chủ thể 1 -->
            <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?q=80&w=400&auto=format&fit=crop" 
                 alt="Accessories" 
                 class="position-absolute rounded-4 shadow-lg scroll-img-right" 
                 style="width: 240px; height: 240px; bottom: 0%; right: 5%; object-fit: cover; z-index: 3; border: 10px solid var(--card-bg);">
        </div>

        <!-- Cột văn bản (Trượt và hiện dần lên đồng bộ với cuộn) -->
        <div class="col-lg-5 offset-lg-1 scroll-text-col">
            <h6 class="text-primary fw-bold text-uppercase tracking-wide mb-3" style="letter-spacing: 2px;">Không Gian Của Bạn</h6>
            <h2 class="display-5 fw-bold mb-4" style="line-height: 1.2;">Kết nối không gian,<br>Khơi nguồn cảm hứng</h2>
            <p class="fs-5 mb-4" style="color: var(--text-muted); line-height: 1.6;">
                Nền tảng TTB Studio tích hợp mọi công cụ bạn cần: giáo trình âm nhạc, lịch bảo dưỡng, kho tab bản nhạc số và kết nối trực tiếp đến các lớp học trực tuyến.
            </p>
            <ul class="list-unstyled mb-4" style="color: var(--text-color); opacity: 0.85;">
                <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i> Giáo trình học tương tác thông minh</li>
                <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i> Kho lưu trữ & đồng bộ thiết lập MIDI</li>
                <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i> Trợ lý luyện tập cá nhân hàng ngày</li>
            </ul>
            <a href="index.php?controller=product&action=index" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); border: none;">
                Trải Nghiệm Ngay <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="grand-piano-showcase container scroll-track p-0">
    <?php
    /**
     * SHOWCASE SẢN PHẨM GRAND PIANO PREMIUM
     * Thiết kế dạng Glassmorphism Banner với nền ảnh tĩnh ổn định.
     */
    ?>
    <!-- Nền của banner - Bỏ hiệu ứng kéo theo (Parallax) khi cuộn để hình ảnh ổn định -->
    <div class="piano-banner-bg" style="background-image: url('https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?q=80&w=1600&auto=format&fit=crop');"></div>
    <div class="grand-piano-overlay"></div>
    
    <div class="container grand-piano-container h-100 d-flex align-items-center">
        <!-- Khối chữ dạng thẻ kính mờ trượt từ bên trái sang khi cuộn tới -->
        <div class="piano-glass-card scroll-slide-left">
            <h6 class="text-primary fw-bold text-uppercase tracking-wide mb-2">
                <i class="fas fa-crown me-2"></i>Đẳng cấp hoàng gia
            </h6>
            <h2 class="display-5 fw-bold mb-4 text-white">Grand Piano Premium</h2>
            <p class="fs-5 mb-4 text-light" style="opacity: 0.9;">Sự kết hợp hoàn hảo giữa kỹ tác thủ công truyền thống và công nghệ âm thanh tiên tiến.</p>
            <ul class="list-unstyled mb-4 text-white-50">
                <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i> Âm thanh cộng hưởng chuẩn Studio</li>
                <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i> Thiết kế sang trọng, điểm nhấn phòng khách</li>
            </ul>
            <a href="index.php?controller=product&action=index" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); border: none; text-decoration: none;">
                Xem chi tiết <i class="fas fa-arrow-right ms-2"></i>
            </a>
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
            <div class="product-card-clean hvr-float">
                <div class="pickup-badge">Pickup!</div>
                <div class="img-container">
                    <img src="https://images.unsplash.com/photo-1550291652-6ea9114a47b1?q=80&w=600&auto=format&fit=crop" alt="Guitar">
                </div>
                <div class="text-center mt-auto">
                    <h5 class="fw-bold">Acoustic Yamaha F310</h5>
                    <p class="small text-muted mb-2">Gỗ vân sam, âm mộc chuẩn</p>
                    <p class="text-primary fw-bold fs-4 mb-3">3.500.000 ₫</p>
                    <button class="btn btn-outline-primary rounded-pill w-100" onclick="addToCartAJAX(event, 1)"><i class='bx bx-cart-add fs-5 align-middle me-2'></i>Thêm giỏ hàng</button>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="product-card-clean hvr-float">
                <div class="pickup-badge bg-success">Mới!</div>
                <div class="img-container">
                    <img src="https://images.unsplash.com/photo-1595069906974-f0ae90cefc70?q=80&w=600&auto=format&fit=crop" alt="Piano">
                </div>
                <div class="text-center mt-auto">
                    <h5 class="fw-bold">Roland Midi Keyboard</h5>
                    <p class="small text-muted mb-2">Phím gõ chân thực, siêu nhạy</p>
                    <p class="text-primary fw-bold fs-4 mb-3">16.900.000 ₫</p>
                    <button class="btn btn-outline-primary rounded-pill w-100" onclick="addToCartAJAX(event, 2)"><i class='bx bx-cart-add fs-5 align-middle me-2'></i>Thêm giỏ hàng</button>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="product-card-clean hvr-float">
                <div class="pickup-badge bg-warning text-dark">Hot!</div>
                <div class="img-container">
                    <img src="https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?q=80&w=600&auto=format&fit=crop" alt="Drum">
                </div>
                <div class="text-center mt-auto">
                    <h5 class="fw-bold">Trống Pearl Roadshow</h5>
                    <p class="small text-muted mb-2">Bộ 5 trống tiêu chuẩn</p>
                    <p class="text-primary fw-bold fs-4 mb-3">12.500.000 ₫</p>
                    <button class="btn btn-outline-primary rounded-pill w-100" onclick="addToCartAJAX(event, 3)"><i class='bx bx-cart-add fs-5 align-middle me-2'></i>Thêm giỏ hàng</button>
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
                <div class="blog-img-wrapper"><img src="https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 1"></div>
                <div class="p-4"><span class="badge bg-primary mb-2">Hướng dẫn</span><h5 class="fw-bold">Cách chọn Guitar cho người mới</h5><p class="small mt-2" style="opacity: 0.8;">Các tiêu chí quan trọng để chọn đàn phù hợp với vóc dáng và phong cách.</p></div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="custom-card h-100">
                <div class="blog-img-wrapper"><img src="https://images.unsplash.com/photo-1501612780327-45045538702b?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 2"></div>
                <div class="p-4"><span class="badge bg-success mb-2">Review</span><h5 class="fw-bold">Đánh giá chi tiết Roland RP-30</h5><p class="small mt-2" style="opacity: 0.8;">Liệu đây có phải là cây đàn Piano điện quốc dân trong tầm giá?</p></div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="custom-card h-100">
                <div class="blog-img-wrapper"><img src="https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 3"></div>
                <div class="p-4"><span class="badge bg-warning text-dark mb-2">Sự kiện</span><h5 class="fw-bold">Sự kiện Workshop: Kỹ thuật Slap</h5><p class="small mt-2" style="opacity: 0.8;">Đăng ký tham gia ngay buổi workshop cùng tay bass hàng đầu.</p></div>
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
                    <h2 class="accordion-header"><button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq1"><i class="fas fa-question-circle text-primary me-2"></i> Quy trình thuê nhạc cụ tại TTB diễn ra thế nào?</button></h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Chọn nhạc cụ dán nhãn <strong>"Cho Thuê"</strong>, chọn ngày trên lịch. Hệ thống tự tính tiền thuê và tiền cọc. Nhạc cụ được giao tận nhà.</div></div>
                </div>
                <div class="accordion-item mb-3 rounded border">
                    <h2 class="accordion-header"><button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq2"><i class="fas fa-tools text-primary me-2"></i> Chính sách bảo hành của TTB kéo dài bao lâu?</button></h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">TTB bảo hành chính hãng từ <strong>1 đến 10 năm</strong>. Trong 30 ngày đầu, hỗ trợ lỗi 1 đổi 1 tận nhà miễn phí.</div></div>
                </div>
                <div class="accordion-item rounded border">
                    <h2 class="accordion-header"><button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq3"><i class="fas fa-credit-card text-primary me-2"></i> Shop có hỗ trợ mua trả góp không?</button></h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Có! TTB hỗ trợ trả góp 0% lãi suất qua thẻ tín dụng của hơn 25 ngân hàng.</div></div>
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
                    <div><h6 class="fw-bold mb-0">Anh Tuấn</h6><small class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></small></div>
                </div>
                <p class="fst-italic" style="opacity: 0.8;">"Đã mua cây Fender Stratocaster ở TTB. Chất lượng tuyệt vời, nhân viên tư vấn rất có tâm. Hỗ trợ cho thuê nhạc cụ rất tiện lợi!"</p>
            </div>
        </div>
        <div class="col-md-6" data-aos="fade-left">
            <div class="custom-card p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success rounded-circle text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-size: 20px;">L</div>
                    <div><h6 class="fw-bold mb-0">Hương Ly</h6><small class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></small></div>
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

<script>
/**
 * =========================================================================
 * JAVASCRIPT: HIỆU ỨNG CUỘN TƯƠNG TÁC (SCROLL-DRIVEN PARALLAX FALLBACK)
 * - Tác dụng: Đo chiều cao viewport và tọa độ của các container .scroll-track.
 * - Tính toán tỉ lệ phần trăm cuộn của element (Progress từ 0 đến 1).
 * - Cập nhật biến CSS --scroll-progress trực tiếp cho CSS xử lý chuyển động.
 * =========================================================================
 */
document.addEventListener('DOMContentLoaded', function() {
    const trackedSections = document.querySelectorAll('.scroll-track');
    
    function updateScrollProgress() {
        const viewportHeight = window.innerHeight;
        
        trackedSections.forEach(section => {
            const rect = section.getBoundingClientRect();
            const elementHeight = rect.height;
            
            // Điểm bắt đầu xuất hiện (ở mép dưới màn hình)
            const enterStart = viewportHeight;
            // Điểm hoàn tất xuất hiện hoàn toàn (khoảng 20% từ mép trên màn hình)
            const enterEnd = viewportHeight * 0.20;
            
            // Điểm bắt đầu biến mất (khi đỉnh phần tử chạm mép trên màn hình)
            const exitStart = 0;
            // Điểm biến mất hoàn toàn (khi phần tử cuộn qua khỏi mép trên màn hình)
            const exitEnd = -elementHeight * 0.9;
            
            let progress = 0;
            
            if (rect.top > enterStart) {
                // Vẫn ở dưới màn hình
                progress = 0;
                section.classList.remove('visible');
            } else if (rect.top <= enterStart && rect.top > enterEnd) {
                // Đang xuất hiện khi cuộn màn hình xuống: tăng dần từ 0 lên 1.
                // Hoặc đang biến mất khi cuộn màn hình lên: giảm dần từ 1 về 0.
                progress = (enterStart - rect.top) / (enterStart - enterEnd);
                section.classList.add('visible');
            } else {
                // Đã xuất hiện đầy đủ hoặc trôi ra ngoài đỉnh màn hình: giữ nguyên 1 (không bị thu lại khi tiếp tục cuộn xuống)
                progress = 1;
                section.classList.add('visible');
            }
            
            // Gán giá trị biến CSS cho element tương ứng
            section.style.setProperty('--scroll-progress', progress.toFixed(4));
        });
    }
    
    // Sử dụng RequestAnimationFrame để tối ưu hóa hiệu năng, giảm giật lag khi cuộn
    let isScrolling = false;
    window.addEventListener('scroll', function() {
        if (!isScrolling) {
            isScrolling = true;
            window.requestAnimationFrame(function() {
                updateScrollProgress();
                isScrolling = false;
            });
        }
    }, { passive: true });
    
    // Lắng nghe cả sự kiện thay đổi kích thước cửa sổ
    window.addEventListener('resize', updateScrollProgress, { passive: true });
    
    // Gọi khởi tạo lần đầu ngay khi trang load xong
    updateScrollProgress();

    // =========================================================================
    // JAVASCRIPT: HIỆU ỨNG 3D TILT LOGO & DISPLACEMENT WARP VIDEO HERO
    // =========================================================================
    const heroBanner = document.getElementById('hero-banner');
    const heroLogo   = document.getElementById('hero-logo');
    const rippleCircle = document.getElementById('ripple-circle');
    const dispMap    = document.getElementById('warp-displacement-map');
    
    // XỬ LÝ DI CHUỘT TRÊN HERO BANNER
    if (heroBanner && heroLogo) {
        heroBanner.addEventListener('mousemove', function(e) {
            // Lấy tọa độ tương đối của chuột trong banner
            const rect = heroBanner.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const percentX = (mouseX - centerX) / centerX;
            const percentY = (mouseY - centerY) / centerY;
            
            // 1. NGHIÊNG 3D LOGO: Nghiêng theo hướng di chuột
            const maxTilt = 15; 
            const tiltY = percentX * maxTilt;
            const tiltX = -percentY * maxTilt;
            heroLogo.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translateY(-10px)`;
            
            // 2. HIỆU ỨNG RIPPLE THEO CHUỘT: Di chuyển vòng tròn bẻ cong
            if (rippleCircle) {
                rippleCircle.style.display = 'block';
                rippleCircle.style.left = mouseX + 'px';
                rippleCircle.style.top = mouseY + 'px';
                
                // Thay đổi cường độ bẻ cong dựa trên tốc độ di chuột
                if (dispMap) {
                    const currentSpeed = Math.abs(e.movementX || 0) + Math.abs(e.movementY || 0);
                    const scaleVal = Math.min(40 + currentSpeed * 2, 120); 
                    dispMap.setAttribute('scale', scaleVal);
                    
                    // Cập nhật seed của nhiễu động để tạo cảm giác sóng nước chuyển động liên tục
                    const turbulence = dispMap.previousElementSibling;
                    if (turbulence) {
                        turbulence.setAttribute('seed', Math.floor(Math.random() * 1000));
                    }
                }
            }
        });

        // TRẢ VỀ TRẠNG THÁI CŨ KHI RỜI CHUỘT
        heroBanner.addEventListener('mouseleave', function() {
            heroLogo.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
            if (rippleCircle) {
                rippleCircle.style.display = 'none';
            }
        });
    }
});
</script>

<?php
// 2. GỌI FOOTER VÀ KẾT THÚC TRANG
include __DIR__ . '/partials/footer.php';
?>