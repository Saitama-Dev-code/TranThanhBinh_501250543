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
            --nav-bg: #ffffff;
            --hero-bg: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
        }

        :root[data-theme="dark"] {
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --card-bg: #1e293b;
            --border-color: #334155;
            --nav-bg: #0f172a;
            --hero-bg: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Navbar Custom */
        .navbar {
            background-color: var(--nav-bg);
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.3s;
        }
        
        .navbar-brand, .nav-link {
            color: var(--text-color) !important;
        }

        /* Hero Section */
        .hero-section {
            background: var(--hero-bg);
            padding: 120px 0;
            border-bottom: 1px solid var(--border-color);
        }

        /* Product Card */
        .product-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: #3b82f6;
        }

        /* Footer */
        footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 40px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-music text-primary me-2"></i>TTB Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars" style="color: var(--text-color);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Danh mục</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <button id="theme-toggle" class="btn btn-outline-secondary rounded-circle me-3">
                        <i class="fas fa-moon"></i>
                    </button>
                    <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-shopping-cart"></i> (0)</a>
                    <a href="#" class="btn btn-primary"><i class="fas fa-user"></i> Đăng nhập</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Giai Điệu Của Riêng Bạn</h1>
            <p class="lead mb-4">Melody Shop cung cấp các dòng nhạc cụ chính hãng, chất lượng cao dành cho cả người mới bắt đầu và dân chuyên nghiệp.</p>
            <button class="btn btn-primary btn-lg px-5 rounded-pill me-2">Khám Phá Ngay</button>
        </div>
    </section>

    <div class="container my-5">
        <h3 class="text-center fw-bold mb-4" data-aos="fade-up">Danh Mục Nổi Bật</h3>
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="p-4 rounded product-card">
                    <i class="fas fa-guitar fa-3x text-primary mb-3"></i>
                    <h5>Guitar</h5>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="p-4 rounded product-card">
                    <i class="fas fa-ring fa-3x text-primary mb-3"></i> <h5>Trống</h5>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="p-4 rounded product-card">
                    <i class="fas fa-keyboard fa-3x text-primary mb-3"></i>
                    <h5>Piano & Organ</h5>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="p-4 rounded product-card">
                    <i class="fas fa-headphones fa-3x text-primary mb-3"></i>
                    <h5>Phụ kiện</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h3 class="text-center fw-bold mb-4" data-aos="fade-up">Nhạc Cụ Bán Chạy</h3>
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="product-card p-4 h-100 d-flex flex-column text-center">
                    <div class="mb-3"><i class="fas fa-guitar fa-5x text-secondary"></i></div>
                    <h5 class="fw-bold mt-auto">Acoustic Guitar Yamaha F310</h5>
                    <p class="text-danger fw-bold fs-5 mb-2">3.500.000 đ</p>
                    <button class="btn btn-outline-primary mt-2"><i class="fas fa-cart-plus"></i> Thêm giỏ hàng</button>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="product-card p-4 h-100 d-flex flex-column text-center">
                    <div class="mb-3"><i class="fas fa-keyboard fa-5x text-secondary"></i></div>
                    <h5 class="fw-bold mt-auto">Piano Điện Roland RP-30</h5>
                    <p class="text-danger fw-bold fs-5 mb-2">16.900.000 đ</p>
                    <button class="btn btn-outline-primary mt-2"><i class="fas fa-cart-plus"></i> Thêm giỏ hàng</button>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="product-card p-4 h-100 d-flex flex-column text-center">
                    <div class="mb-3"><i class="fas fa-drum fa-5x text-secondary"></i></div>
                    <h5 class="fw-bold mt-auto">Trống Cơ Pearl Roadshow</h5>
                    <p class="text-danger fw-bold fs-5 mb-2">12.500.000 đ</p>
                    <button class="btn btn-outline-primary mt-2"><i class="fas fa-cart-plus"></i> Thêm giỏ hàng</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <h5 class="fw-bold"><i class="fas fa-music text-primary"></i> TTB Shop</h5>
            <p>Dự án đồ án PHP - Kiến trúc MVC</p>
            <p>&copy; 2026 Trần Thanh Bình - 501250543</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Khởi tạo animation cuộn trang
        AOS.init({ once: true, offset: 50 });

        // Xử lý Dark/Light Theme
        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        const icon = themeToggleBtn.querySelector('i');

        // Kiểm tra LocalStorage xem người dùng đã chọn theme nào trước đó chưa
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
                icon.className = 'fas fa-sun text-warning'; // Đổi icon thành mặt trời khi ở chế độ tối
            } else {
                icon.className = 'fas fa-moon text-dark'; // Đổi icon thành mặt trăng khi ở chế độ sáng
            }
        }
    </script>
</body>
</html>