<!DOCTYPE html>
<html lang="vi" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melody Shop - Đánh Thức Đam Mê</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Khai báo biến màu sắc cho Light/Dark Theme */
        :root[data-theme="light"] {
            --bg-color: #f8fafc;
            --text-color: #0f172a;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --nav-bg: rgba(255, 255, 255, 0.95);
        }

        :root[data-theme="dark"] {
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --card-bg: #1e293b;
            --border-color: #334155;
            --nav-bg: rgba(15, 23, 42, 0.95);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
            overflow-x: hidden;
        }

        /* Smart Navbar */
        .navbar {
            background-color: var(--nav-bg);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            transition: top 0.4s ease-in-out, background-color 0.3s;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
        }
        
        .navbar-brand, .nav-link { color: var(--text-color) !important; }

        /* Đẩy body xuống một khoảng bằng chiều cao navbar để không bị che mất nội dung */
        body { padding-top: 76px; }

        /* Video Hero Section */
        .hero-section {
            position: relative;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        /* Lớp phủ mờ màu đen để chữ luôn nổi bật trên nền video */
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .hero-video {
            position: absolute;
            top: 50%; left: 50%;
            min-width: 100%; min-height: 100%;
            width: auto; height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white; /* Luôn giữ màu trắng ở Hero bất kể theme */
        }

        /* Product Card */
        .product-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            border-color: #3b82f6;
        }

        /* Showcase Image */
        .showcase-img {
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            transition: transform 0.5s ease;
            width: 100%;
        }
        .showcase-img:hover { transform: scale(1.02); }

        /* Footer */
        footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 50px 0 20px 0;
            margin-top: 80px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg" id="smartNavbar">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">
                <i class="fas fa-music text-primary me-2"></i>Melody
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars" style="color: var(--text-color);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Thương hiệu</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Bảo hành</a></li>
                </ul>
                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    <button id="theme-toggle" class="btn btn-outline-secondary rounded-circle me-3">
                        <i class="fas fa-moon"></i>
                    </button>
                    <a href="#" class="btn btn-outline-primary me-2 rounded-pill px-3"><i class="fas fa-shopping-cart"></i> Giỏ hàng (0)</a>
                    <a href="#" class="btn btn-primary rounded-pill px-4"><i class="fas fa-user"></i> Đăng nhập</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <video class="hero-video" autoplay loop muted playsinline>
            <source src="https://assets.mixkit.co/videos/preview/mixkit-playing-an-electric-guitar-2882-large.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        
        <div class="container hero-content" data-aos="zoom-out" data-aos-duration="1500">
            <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill letter-spacing-1">BỘ SƯU TẬP 2024</span>
            <h1 class="display-2 fw-bolder mb-4 text-white">Giai Điệu Của Riêng Bạn</h1>
            <p class="lead mb-5 text-light mx-auto" style="max-width: 600px;">
                Trải nghiệm âm thanh đỉnh cao với các dòng nhạc cụ được chế tác tinh xảo. Đánh thức đam mê và thể hiện cá tính âm nhạc của bạn.
            </p>
            <button class="btn btn-primary btn-lg px-5 py-3 rounded-pill me-3 shadow-lg fw-bold">Khám Phá Ngay</button>
            <button class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold"><i class="fas fa-play me-2"></i> Xem Video</button>
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
                <p class="fs-5 mb-4 text-muted" style="color: var(--text-color) !important; opacity: 0.8;">
                    Sự kết hợp hoàn hảo giữa kỹ tác thủ công truyền thống và công nghệ âm thanh tiên tiến. Phím đàn ngà voi mang lại cảm giác chân thực trên từng nốt nhạc.
                </p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Âm thanh cộng hưởng chuẩn Studio</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Thiết kế sang trọng, điểm nhấn phòng khách</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Bảo hành chính hãng 10 năm</li>
                </ul>
                <a href="#" class="btn btn-outline-primary rounded-pill px-4 py-2">Xem chi tiết <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <section class="container mt-5 pt-5">
        <div class="row align-items-center flex-lg-row-reverse">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-left" data-aos-duration="1000">
                <img src="https://images.unsplash.com/photo-1516924962500-2b4b3b99ea02?q=80&w=1000&auto=format&fit=crop" alt="Electric Guitar" class="showcase-img">
            </div>
            <div class="col-lg-5 me-lg-auto" data-aos="fade-right" data-aos-duration="1000">
                <h6 class="text-primary fw-bold text-uppercase tracking-wide mb-2">Bùng nổ sân khấu</h6>
                <h2 class="display-5 fw-bold mb-4">Electric Guitar Series</h2>
                <p class="fs-5 mb-4 text-muted" style="color: var(--text-color) !important; opacity: 0.8;">
                    Khai phóng năng lượng rock n' roll bên trong bạn. Pickup nam châm Alnico cho âm thanh gầm gừ đầy uy lực nhưng vẫn giữ được độ trong trẻo khi cần thiết.
                </p>
                <a href="#" class="btn btn-outline-primary rounded-pill px-4 py-2">Khám phá ngay <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <div class="container mt-5 pt-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase">Bán chạy nhất</h6>
            <h2 class="display-6 fw-bold">Nhạc Cụ Dành Cho Bạn</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="product-card p-4 h-100 d-flex flex-column text-center position-relative">
                    <span class="badge bg-danger position-absolute top-0 end-0 m-3">-15%</span>
                    <div class="mb-4 mt-2"><i class="fas fa-guitar fa-5x text-secondary"></i></div>
                    <h5 class="fw-bold">Acoustic Yamaha F310</h5>
                    <p class="text-muted small">Mặt top gỗ vân sam, âm mộc chuẩn xác.</p>
                    <div class="mt-auto">
                        <p class="text-primary fw-bold fs-4 mb-3">3.500.000 ₫ <span class="text-decoration-line-through text-muted fs-6 ms-2">4.100.000 ₫</span></p>
                        <button class="btn btn-primary w-100 rounded-pill"><i class="fas fa-cart-plus me-2"></i> Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="product-card p-4 h-100 d-flex flex-column text-center">
                    <div class="mb-4 mt-2"><i class="fas fa-keyboard fa-5x text-secondary"></i></div>
                    <h5 class="fw-bold">Piano Điện Roland RP-30</h5>
                    <p class="text-muted small">Phím búa gõ chân thực, 15 âm sắc tích hợp.</p>
                    <div class="mt-auto">
                        <p class="text-primary fw-bold fs-4 mb-3">16.900.000 ₫</p>
                        <button class="btn btn-primary w-100 rounded-pill"><i class="fas fa-cart-plus me-2"></i> Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="product-card p-4 h-100 d-flex flex-column text-center">
                    <div class="mb-4 mt-2"><i class="fas fa-drum fa-5x text-secondary"></i></div>
                    <h5 class="fw-bold">Trống Cơ Pearl Roadshow</h5>
                    <p class="text-muted small">Bộ 5 trống tiêu chuẩn, đi kèm Cymbal và ghế.</p>
                    <div class="mt-auto">
                        <p class="text-primary fw-bold fs-4 mb-3">12.500.000 ₫</p>
                        <button class="btn btn-primary w-100 rounded-pill"><i class="fas fa-cart-plus me-2"></i> Thêm giỏ hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-3"><i class="fas fa-music text-primary me-2"></i>Melody Shop</h4>
                    <p class="text-muted">Mang đến những nhạc cụ chất lượng nhất để bạn tự tin tỏa sáng và viết nên giai điệu của riêng mình.</p>
                </div>
                <div class="col-lg-2 offset-lg-2 col-md-4">
                    <h5 class="fw-bold mb-3">Sản phẩm</h5>
                    <ul class="list-unstyled text-muted">
                        <li><a href="#" class="text-decoration-none text-muted">Guitar</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Piano & Organ</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Trống</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-8">
                    <h5 class="fw-bold mb-3">Đăng ký nhận tin</h5>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email của bạn..." aria-label="Email">
                        <button class="btn btn-primary" type="button"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: var(--border-color);">
            <div class="text-center text-muted small">
                &copy; 2024 Melody Shop. Dự án PHP MVC.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // 1. Khởi tạo hiệu ứng cuộn trang (AOS)
        AOS.init({ once: true, offset: 120 });

        // 2. Xử lý Smart Navbar (Ẩn khi cuộn xuống, hiện khi cuộn lên)
        let prevScrollpos = window.pageYOffset;
        const navbar = document.getElementById("smartNavbar");

        window.onscroll = function() {
            let currentScrollPos = window.pageYOffset;
            
            // Nếu ở sát trên cùng thì luôn hiện và bỏ bóng (shadow)
            if (currentScrollPos <= 50) {
                navbar.style.top = "0";
                navbar.style.boxShadow = "none";
            } else {
                // Thêm bóng mờ khi đã cuộn xuống
                navbar.style.boxShadow = "0 4px 10px rgba(0,0,0,0.1)";
                
                if (prevScrollpos > currentScrollPos) {
                    navbar.style.top = "0"; // Cuộn lên -> Hiện
                } else {
                    navbar.style.top = "-100px"; // Cuộn xuống -> Ẩn
                }
            }
            prevScrollpos = currentScrollPos;
        }

        // 3. Xử lý Dark/Light Theme (Giữ nguyên từ bản trước)
        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        const icon = themeToggleBtn.querySelector('i');

        const savedTheme = localStorage.getItem('theme') || 'dark';
        htmlElement.setAttribute('data-theme', savedTheme);
        updateIcon(savedTheme);

        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            if (theme === 'dark') {
                icon.className = 'fas fa-sun text-warning';
            } else {
                icon.className = 'fas fa-moon text-dark';
            }
        }
    </script>
</body>
</html>