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
           1. CẤU HÌNH BIẾN MÀU SẮC (THEME)
           ========================================================================== */
        :root[data-theme="light"] {
            --bg-color: #f8fafc;
            --text-color: #0f172a;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --nav-bg: rgba(255, 255, 255, 0.85);
            --watermark-color: rgba(0, 0, 0, 0.03);
        }

        :root[data-theme="dark"] {
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --card-bg: #1e293b;
            --border-color: #334155;
            --nav-bg: rgba(15, 23, 42, 0.85);
            --watermark-color: rgba(255, 255, 255, 0.02);
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
           2. HIỆU ỨNG WATERMARK & FULL-PAGE PARALLAX (HẠT BAY TOÀN TRANG)
           ========================================================================== */
        .watermark {
            position: fixed;
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            font-size: 18vw; font-weight: 900;
            color: var(--watermark-color);
            z-index: -2; pointer-events: none; user-select: none;
            white-space: nowrap; transition: color 0.4s ease;
        }

        #global-parallax {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: -1; pointer-events: none;
        }
        
        .floating-note {
            position: absolute; color: var(--text-color); opacity: 0.05;
            transition: transform 0.1s linear; 
        }

        /* ==========================================================================
           3. NAVBAR THÔNG MINH (TRƯỢT LÊN/XUỐNG)
           ========================================================================== */
        .navbar {
            background-color: var(--nav-bg);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(12px);
            transition: top 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55), background-color 0.4s;
            position: fixed; width: 100%; top: 0; z-index: 1030;
        }
        .navbar-brand, .nav-link { color: var(--text-color) !important; font-weight: 600; }

        /* ==========================================================================
           4. HERO SECTION (VIDEO NỀN)
           ========================================================================== */
        .hero-section {
            position: relative; height: 90vh; display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .video-background {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none;
        }
        .video-background iframe {
            width: 100vw; height: 56.25vw; min-height: 100vh; min-width: 177.77vh;
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        }
        .hero-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 1;
        }
        .hero-content { position: relative; z-index: 2; color: white; }

        /* ==========================================================================
           5. HIỆU ỨNG THƯƠNG HIỆU: KẸO DẺO & TRƯỢT NGANG MƯỢT MÀ KHÔNG VẤP
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
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        /* Keyframes kẹo dẻo (nhún và nảy lên) */
        @keyframes jellyBounce {
            0%   { transform: scale3d(1, 1, 1); }
            30%  { transform: scale3d(1.25, 0.75, 1); } 
            40%  { transform: scale3d(0.75, 1.25, 1); } 
            50%  { transform: scale3d(1.15, 0.85, 1); }
            65%  { transform: scale3d(0.95, 1.05, 1); }
            75%  { transform: scale3d(1.05, 0.95, 1); }
            100% { transform: scale3d(1, 1, 1) translateY(-10px); }
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
            transition: opacity 0.3s;
            white-space: nowrap;
        }

        .brand-item:hover {
            opacity: 1;
            color: #3b82f6;
            animation: jellyBounce 0.8s both;
        }

        /* ==========================================================================
           6. HIỆU ỨNG SẢN PHẨM CUT-OUT ĐÀN HỒI (ELASTIC POP-OUT)
           ========================================================================== */
        .elastic-card {
            background-color: transparent; border: none; position: relative; padding-top: 80px; cursor: pointer;
        }

        .elastic-bg {
            background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px;
            height: 100%; padding: 100px 20px 30px 20px; 
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); position: relative; z-index: 1;
        }

        /* Ảnh PNG thật */
        .elastic-img {
            width: 75%; position: absolute; top: -10px; left: 12.5%; z-index: 2;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            filter: drop-shadow(0 15px 15px rgba(0,0,0,0.4));
        }

        .elastic-card:hover .elastic-bg {
            transform: rotate(3deg) scale(1.02); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); border-color: #3b82f6;
        }

        .elastic-card:hover .elastic-img {
            transform: translateY(-50px) scale(1.15) rotate(-3deg); 
        }

        /* ==========================================================================
           7. CÁC COMPONENT CHUẨN (CARD, HÌNH ẢNH, FOOTER)
           ========================================================================== */
        .custom-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .custom-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); border-color: #3b82f6; }
        .showcase-img { border-radius: 15px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); transition: transform 0.5s ease; width: 100%; }
        .showcase-img:hover { transform: scale(1.02); }
        .blog-img { height: 200px; object-fit: cover; border-radius: 12px 12px 0 0; width: 100%; }
        
        footer {
            background-color: var(--card-bg); border-top: 1px solid var(--border-color); padding: 60px 0 20px 0;
            position: relative; z-index: 10;
        }
        .footer-text { color: var(--text-color); opacity: 0.8; text-decoration: none; transition: 0.3s; }
        .footer-text:hover { opacity: 1; color: #3b82f6; }
    </style>
</head>
<body>

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
                    <a href="#" class="btn btn-primary rounded-pill px-4"><i class="fas fa-user"></i> Đăng nhập</a>
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
            <div class="brand-item"><i class="fas fa-record-vinyl me-2"></i> YAMAHA</div> <div class="brand-item"><i class="fas fa-guitar me-2"></i> FENDER</div>
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
                <img src="https://images.unsplash.com/photo-1552422535-c45813c61732?q=80&w=1000&auto=format&fit=crop" alt="Premium Piano" class="showcase-img">
            </div>
            <div class="col-lg-5 offset-lg-1" data-aos="fade-left" data-aos-duration="1000">
                <h6 class="text-primary fw-bold text-uppercase tracking-wide mb-2">Đẳng cấp hoàng gia</h6>
                <h2 class="display-5 fw-bold mb-4">Grand Piano Premium</h2>
                <p class="fs-5 mb-4" style="opacity: 0.8;">
                    Sự kết hợp hoàn hảo giữa kỹ tác thủ công truyền thống và công nghệ âm thanh tiên tiến.
                </p>
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
            <p>Di chuột vào sản phẩm để xem hiệu ứng 3D Cut-out đàn hồi cực mượt</p>
        </div>
        
        <div class="row g-5">
            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="elastic-card">
                    <img src="https://freepngimg.com/thumb/guitar/2-2-guitar-png-pic.png" alt="Guitar" class="elastic-img" style="top: -30px;">
                    <div class="elastic-bg text-center d-flex flex-column">
                        <span class="badge bg-danger position-absolute top-0 end-0 m-3 z-3">Cho Thuê</span>
                        <h5 class="fw-bold mt-auto pt-4">Acoustic Yamaha F310</h5>
                        <p class="small" style="opacity: 0.7;">Gỗ vân sam, âm mộc chuẩn</p>
                        <p class="text-primary fw-bold fs-4 mb-3">3.500.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100 mt-2">Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="elastic-card">
                    <img src="https://freepngimg.com/thumb/piano/3-2-piano-png-file.png" alt="Piano" class="elastic-img" style="transform: scale(1.1); top: 30px;">
                    <div class="elastic-bg text-center d-flex flex-column">
                        <h5 class="fw-bold mt-auto pt-4">Roland Midi Keyboard</h5>
                        <p class="small" style="opacity: 0.7;">Phím gõ chân thực, siêu nhạy</p>
                        <p class="text-primary fw-bold fs-4 mb-3">16.900.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100 mt-2">Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="elastic-card">
                    <img src="https://freepngimg.com/thumb/drum/1-2-drum-png.png" alt="Drum" class="elastic-img" style="top: 20px;">
                    <div class="elastic-bg text-center d-flex flex-column">
                        <h5 class="fw-bold mt-auto pt-4">Trống Pearl Roadshow</h5>
                        <p class="small" style="opacity: 0.7;">Bộ 5 trống tiêu chuẩn</p>
                        <p class="text-primary fw-bold fs-4 mb-3">12.500.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100 mt-2">Thêm giỏ hàng</button>
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
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Bảo hành 10 năm</h5>
                    <p class="mb-0" style="opacity: 0.8;">Cam kết hàng chính hãng, bảo hành trọn đời tại mọi chi nhánh.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="custom-card p-4 h-100">
                    <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Giao hàng Hỏa tốc</h5>
                    <p class="mb-0" style="opacity: 0.8;">Miễn phí vận chuyển toàn quốc cho đơn hàng từ 2.000.000đ.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="custom-card p-4 h-100">
                    <i class="fas fa-retweet fa-3x text-primary mb-3"></i>
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
                <div class="custom-card p-3 text-center">
                    <i class="fas fa-headphones-alt fa-3x text-secondary mb-3"></i>
                    <h6 class="fw-bold">Tai nghe kiểm âm</h6>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="custom-card p-3 text-center">
                    <i class="fas fa-microphone fa-3x text-secondary mb-3"></i>
                    <h6 class="fw-bold">Micro Thu Âm</h6>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="custom-card p-3 text-center">
                    <i class="fas fa-bolt fa-3x text-secondary mb-3"></i>
                    <h6 class="fw-bold">Amply Guitar</h6>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="custom-card p-3 text-center">
                    <i class="fas fa-sliders-h fa-3x text-secondary mb-3"></i>
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
                    <img src="https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 1">
                    <div class="p-4">
                        <span class="badge bg-primary mb-2">Hướng dẫn</span>
                        <h5 class="fw-bold">Cách chọn Guitar cho người mới</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="custom-card h-100">
                    <img src="https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 2">
                    <div class="p-4">
                        <span class="badge bg-primary mb-2">Review</span>
                        <h5 class="fw-bold">Đánh giá chi tiết Roland RP-30</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="custom-card h-100">
                    <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 3">
                    <div class="p-4">
                        <span class="badge bg-primary mb-2">Sự kiện</span>
                        <h5 class="fw-bold">Sự kiện Workshop: Kỹ thuật Slap</h5>
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

    <footer class="mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-3"><i class="fas fa-music text-primary me-2"></i>TTB MUSIC</h4>
                    <p class="footer-text">Hệ thống mua bán và cho thuê nhạc cụ hàng đầu, giúp bạn tự tin tỏa sáng và viết nên giai điệu của riêng mình.</p>
                    <div class="mt-3">
                        <a href="#" class="footer-text me-3 fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="footer-text me-3 fs-5"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="footer-text fs-5"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-4">
                    <h5 class="fw-bold mb-3">Danh mục</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-text">Guitar & Bass</a></li>
                        <li class="mb-2"><a href="#" class="footer-text">Piano & Organ</a></li>
                        <li class="mb-2"><a href="#" class="footer-text">Trống & Bộ gõ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-3">Dịch vụ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-text text-warning fw-bold">Cho Thuê Nhạc Cụ</a></li>
                        <li class="mb-2"><a href="#" class="footer-text">Bảo hành & Sửa chữa</a></li>
                        <li class="mb-2"><a href="#" class="footer-text">Hướng dẫn trả góp</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="fw-bold mb-3">Liên hệ</h5>
                    <ul class="list-unstyled footer-text">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Quận 1, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i> 1900 1000</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> contact@ttbmusic.vn</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: var(--border-color); opacity: 0.2;">
            <div class="text-center footer-text small">
                &copy; 2024 TTB MUSIC. Dự án PHP MVC.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // 1. Khởi tạo thư viện cuộn AOS
        AOS.init({ once: true, offset: 100 });

        // =====================================================================
        // SCRIPT 1: SMART NAVBAR (Ẩn hiện khi cuộn dạng cao su)
        // =====================================================================
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
                    navbar.style.top = "0"; // Cuộn lên -> Hiện ra
                } else {
                    navbar.style.top = "-100px"; // Cuộn xuống -> Giấu đi
                }
            }
            prevScrollpos = currentScrollPos;
        }

        // =====================================================================
        // SCRIPT 2: DARK/LIGHT THEME CƠ BẢN
        // =====================================================================
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

        // =====================================================================
        // SCRIPT 3: TẠO HẠT MƯA NỐT NHẠC VÀ BÁM THEO CHUỘT TOÀN TRANG
        // =====================================================================
        const parallaxContainer = document.getElementById('global-parallax');
        const icons = ['fa-music', 'fa-guitar', 'fa-headphones', 'fa-drum', 'fa-play'];
        const notes = []; 
        
        // Sinh ra 20 hạt ngẫu nhiên
        for(let i = 0; i < 20; i++) {
            let note = document.createElement('i');
            let randomIcon = icons[Math.floor(Math.random() * icons.length)];
            note.className = `fas ${randomIcon} floating-note`;
            
            note.style.left = Math.random() * 100 + 'vw';
            note.style.top = Math.random() * 100 + 'vh';
            note.style.fontSize = (Math.random() * 2 + 1) + 'rem';
            note.dataset.speed = (Math.random() * 4 - 2).toFixed(2); 
            
            parallaxContainer.appendChild(note);
            notes.push(note);
        }

        window.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth) - 0.5;
            const y = (e.clientY / window.innerHeight) - 0.5;

            requestAnimationFrame(() => {
                notes.forEach(note => {
                    const speed = parseFloat(note.dataset.speed);
                    note.style.transform = `translate(${x * speed * 50}px, ${y * speed * 50}px)`;
                });
            });
        });
    </script>
</body>
</html>