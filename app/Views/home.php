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
            position: relative; /* Để chứa watermark và floating elements */
        }

        /* ==========================================================================
           2. HIỆU ỨNG WATERMARK & FULL-PAGE PARALLAX (HẠT BAY)
           ========================================================================== */
        /* Chữ mờ to đùng nằm dưới cùng, không che click chuột */
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

        /* Vùng chứa các nốt nhạc bay toàn trang */
        #global-parallax {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: -1;
            pointer-events: none;
        }
        
        .floating-note {
            position: absolute;
            color: var(--text-color);
            opacity: 0.05;
            transition: transform 0.1s linear; /* Mượt mà khi di chuột */
        }

        /* ==========================================================================
           3. NAVBAR THÔNG MINH
           ========================================================================== */
        .navbar {
            background-color: var(--nav-bg);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(12px); /* Làm mờ nền đằng sau */
            transition: top 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55), background-color 0.4s;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
        }
        .navbar-brand, .nav-link { color: var(--text-color) !important; font-weight: 600; }

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
           5. HIỆU ỨNG KẸO DẺO (JELLY BOUNCE) & TRƯỢT NGANG (MARQUEE)
           ========================================================================== */
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            padding: 20px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            background: var(--card-bg);
        }
        
        .marquee-content {
            display: inline-block;
            animation: marqueeScroll 25s linear infinite;
        }

        /* Nhân đôi content để trượt liên tục không bị đứt quãng */
        .marquee-content.clone { position: absolute; left: 100%; top: 20px;}

        @keyframes marqueeScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        /* Định nghĩa hiệu ứng nhún kẹo dẻo */
        @keyframes jellyBounce {
            0%   { transform: scale3d(1, 1, 1); }
            30%  { transform: scale3d(1.25, 0.75, 1); } /* Ép lùn xuống, phình ngang */
            40%  { transform: scale3d(0.75, 1.25, 1); } /* Kéo dài lên, hóp ngang */
            50%  { transform: scale3d(1.15, 0.85, 1); }
            65%  { transform: scale3d(0.95, 1.05, 1); }
            75%  { transform: scale3d(1.05, 0.95, 1); }
            100% { transform: scale3d(1, 1, 1) translateY(-10px); } /* Dừng ở trạng thái bay lên 1 chút */
        }

        .brand-item {
            display: inline-flex;
            align-items: center;
            margin: 0 40px;
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-color);
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s;
        }

        .brand-item:hover {
            opacity: 1;
            color: #3b82f6; /* Đổi màu xanh khi hover */
            animation: jellyBounce 0.8s both; /* Gọi hàm kẹo dẻo */
        }

        /* ==========================================================================
           6. HIỆU ỨNG SẢN PHẨM CUT-OUT ĐÀN HỒI (ELASTIC POP-OUT)
           ========================================================================== */
        .elastic-card {
            background-color: transparent;
            border: none;
            position: relative;
            padding-top: 60px; /* Nhường chỗ cho ảnh trồi lên */
            cursor: pointer;
        }

        /* Hình khối nền đằng sau ảnh */
        .elastic-bg {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            height: 100%;
            padding: 80px 20px 20px 20px; /* Đẩy chữ xuống dưới ảnh */
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); /* Gia tốc đàn hồi */
            position: relative;
            z-index: 1;
        }

        /* Ảnh sản phẩm (Yêu cầu PNG tách nền) */
        .elastic-img {
            width: 80%;
            position: absolute;
            top: 0;
            left: 10%;
            z-index: 2;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3)); /* Đổ bóng khối cho ảnh PNG */
        }

        /* Khi hover vào nguyên cục card */
        .elastic-card:hover .elastic-bg {
            transform: rotate(3deg) scale(1.02); /* Nền xoay và phình to nhẹ */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: #3b82f6;
        }

        .elastic-card:hover .elastic-img {
            transform: translateY(-40px) scale(1.15); /* Ảnh bự lên và trồi hẳn ra ngoài nền */
        }

        /* ==========================================================================
           7. FOOTER
           ========================================================================== */
        footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 60px 0 20px 0;
            position: relative;
            z-index: 10; /* Đè lên đám mây hạt nốt nhạc */
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

    <section class="marquee-container my-5">
        <div class="marquee-content">
            <div class="brand-item"><i class="fab fa-yamaha me-2"></i> YAMAHA</div>
            <div class="brand-item"><i class="fas fa-guitar me-2"></i> FENDER</div>
            <div class="brand-item"><i class="fas fa-keyboard me-2"></i> ROLAND</div>
            <div class="brand-item"><i class="fas fa-drum me-2"></i> PEARL</div>
            <div class="brand-item"><i class="fas fa-headphones me-2"></i> MARSHALL</div>
            <div class="brand-item"><i class="fas fa-music me-2"></i> KORG</div>
        </div>
        <div class="marquee-content clone">
            <div class="brand-item"><i class="fab fa-yamaha me-2"></i> YAMAHA</div>
            <div class="brand-item"><i class="fas fa-guitar me-2"></i> FENDER</div>
            <div class="brand-item"><i class="fas fa-keyboard me-2"></i> ROLAND</div>
            <div class="brand-item"><i class="fas fa-drum me-2"></i> PEARL</div>
            <div class="brand-item"><i class="fas fa-headphones me-2"></i> MARSHALL</div>
            <div class="brand-item"><i class="fas fa-music me-2"></i> KORG</div>
        </div>
    </section>

    <div class="container mt-5 pt-5 mb-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase">Bán chạy nhất</h6>
            <h2 class="display-6 fw-bold">Sản Phẩm Đang Hot</h2>
            <p>Di chuột vào sản phẩm để xem hiệu ứng 3D Cut-out</p>
        </div>
        
        <div class="row g-5">
            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="elastic-card">
                    <img src="https://www.pngmart.com/files/6/Acoustic-Guitar-PNG-Transparent-Picture.png" alt="Guitar" class="elastic-img">
                    <div class="elastic-bg text-center d-flex flex-column">
                        <span class="badge bg-danger position-absolute top-0 end-0 m-3 z-3">Cho Thuê</span>
                        <h5 class="fw-bold mt-auto">Acoustic Yamaha F310</h5>
                        <p class="small" style="opacity: 0.7;">Gỗ vân sam, âm mộc chuẩn</p>
                        <p class="text-primary fw-bold fs-4 mb-3">3.500.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100 mt-2">Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="elastic-card">
                    <img src="https://www.pngmart.com/files/7/Keyboard-Piano-PNG-Image.png" alt="Piano" class="elastic-img" style="transform: scale(0.9); left: 5%;">
                    <div class="elastic-bg text-center d-flex flex-column">
                        <h5 class="fw-bold mt-auto">Piano Roland RP-30</h5>
                        <p class="small" style="opacity: 0.7;">Phím gõ chân thực</p>
                        <p class="text-primary fw-bold fs-4 mb-3">16.900.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100 mt-2">Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="elastic-card">
                    <img src="https://www.pngmart.com/files/7/Drum-Set-PNG-Photos.png" alt="Drum" class="elastic-img" style="top: 20px;">
                    <div class="elastic-bg text-center d-flex flex-column">
                        <h5 class="fw-bold mt-auto">Trống Pearl Roadshow</h5>
                        <p class="small" style="opacity: 0.7;">Bộ 5 trống tiêu chuẩn</p>
                        <p class="text-primary fw-bold fs-4 mb-3">12.500.000 ₫</p>
                        <button class="btn btn-outline-primary rounded-pill w-100 mt-2">Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5">
        <div class="container text-center">
            <h4 class="fw-bold mb-3"><i class="fas fa-music text-primary me-2"></i>TTB MUSIC</h4>
            <p class="footer-text">Dự án Đồ án PHP MVC - Hệ thống mua bán & cho thuê nhạc cụ.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Khởi tạo thư viện cuộn AOS
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
        const notes = []; // Mảng lưu trữ các phần tử HTML hạt
        
        // Sinh ra 20 hạt ngẫu nhiên rải rác trên màn hình
        for(let i = 0; i < 20; i++) {
            let note = document.createElement('i');
            // Chọn ngẫu nhiên 1 icon
            let randomIcon = icons[Math.floor(Math.random() * icons.length)];
            note.className = `fas ${randomIcon} floating-note`;
            
            // Random vị trí, kích thước và tốc độ bay (speed)
            note.style.left = Math.random() * 100 + 'vw';
            note.style.top = Math.random() * 100 + 'vh';
            note.style.fontSize = (Math.random() * 2 + 1) + 'rem';
            note.dataset.speed = (Math.random() * 4 - 2).toFixed(2); // Speed từ -2 đến 2
            
            parallaxContainer.appendChild(note);
            notes.push(note);
        }

        // Lắng nghe sự kiện di chuột trên TOÀN BỘ cửa sổ
        window.addEventListener('mousemove', (e) => {
            // Lấy tọa độ chuột so với tâm màn hình (từ -0.5 đến 0.5)
            const x = (e.clientX / window.innerWidth) - 0.5;
            const y = (e.clientY / window.innerHeight) - 0.5;

            // Dùng requestAnimationFrame để hoạt ảnh cực kỳ mượt, không bị lag CPU
            requestAnimationFrame(() => {
                notes.forEach(note => {
                    const speed = parseFloat(note.dataset.speed);
                    // Dịch chuyển phần tử bằng transform translate
                    note.style.transform = `translate(${x * speed * 50}px, ${y * speed * 50}px)`;
                });
            });
        });
    </script>
</body>
</html>