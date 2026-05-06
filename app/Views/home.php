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
            padding-top: 76px;
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

        /* YouTube Video Background Hero Section */
        .hero-section {
            position: relative;
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        .video-background {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            pointer-events: none; /* Không cho phép click vào video */
        }

        .video-background iframe {
            width: 100vw;
            height: 56.25vw;
            min-height: 100vh;
            min-width: 177.77vh;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.65);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        /* Cards & Images */
        .custom-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
        }

        .custom-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            border-color: #3b82f6;
        }

        .showcase-img {
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            transition: transform 0.5s ease;
            width: 100%;
        }
        
        .showcase-img:hover { transform: scale(1.02); }

        /* Interactive Mouse Section */
        .interactive-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 120px 0;
            color: white;
            border-radius: 20px;
        }

        .music-note {
            position: absolute;
            font-size: 3rem;
            color: rgba(255, 255, 255, 0.05);
            pointer-events: none;
            transition: transform 0.2s ease-out;
        }

        /* Blog Section */
        .blog-img {
            height: 200px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
            width: 100%;
        }

        /* Footer */
        footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 60px 0 20px 0;
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
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Blog</a></li>
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
        <div class="video-background">
            <iframe 
                src="https://www.youtube.com/embed/wNCDWk8mxXs?autoplay=1&mute=1&playlist=wNCDWk8mxXs&loop=1&controls=0&disablekb=1&fs=0&modestbranding=1&playsinline=1" 
                frameborder="0" 
                allow="autoplay; fullscreen" 
                allowfullscreen>
            </iframe>
        </div>
        <div class="hero-overlay"></div>
        
        <div class="container hero-content" data-aos="zoom-in" data-aos-duration="1500">
            <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill letter-spacing-1">KHƠI NGUỒN CẢM HỨNG</span>
            <h1 class="display-2 fw-bolder mb-4 text-white">Giai Điệu Của Riêng Bạn</h1>
            <p class="lead mb-5 text-light mx-auto" style="max-width: 600px;">
                Trải nghiệm âm thanh đỉnh cao với các dòng nhạc cụ được chế tác tinh xảo. Đánh thức đam mê và thể hiện cá tính âm nhạc của bạn.
            </p>
            <button class="btn btn-primary btn-lg px-5 py-3 rounded-pill me-3 shadow-lg fw-bold">Khám Phá Ngay</button>
        </div>
    </section>

    <section class="container mt-5 pt-4 text-center" data-aos="fade-up">
        <p class="text-uppercase fw-bold text-secondary mb-4">Đối tác thương hiệu hàng đầu</p>
        <div class="row justify-content-center align-items-center opacity-75">
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold m-0"><i class="fab fa-yamaha"></i> YAMAHA</h4></div>
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold m-0">Fender</h4></div>
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold m-0">Roland</h4></div>
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold m-0">KORG</h4></div>
            <div class="col-4 col-md-2 mb-3"><h4 class="fw-bold m-0">Taylor</h4></div>
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
                    Sự kết hợp hoàn hảo giữa kỹ tác thủ công truyền thống và công nghệ âm thanh tiên tiến. Phím đàn ngà voi mang lại cảm giác chân thực trên từng nốt nhạc.
                </p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Âm thanh cộng hưởng chuẩn Studio</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Thiết kế sang trọng, điểm nhấn phòng khách</li>
                </ul>
                <a href="#" class="btn btn-outline-primary rounded-pill px-4 py-2">Xem chi tiết <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <section class="container mt-5 pt-5 mb-5" data-aos="fade-up">
        <div class="interactive-section text-center" id="parallaxArea">
            <i class="fas fa-music music-note" style="top: 20%; left: 10%;" data-speed="-5"></i>
            <i class="fas fa-guitar music-note" style="top: 70%; left: 80%;" data-speed="8"></i>
            <i class="fas fa-headphones music-note" style="top: 30%; left: 70%;" data-speed="-3"></i>
            <i class="fas fa-drum music-note" style="top: 60%; left: 20%;" data-speed="6"></i>
            <i class="fas fa-compact-disc music-note" style="top: 80%; left: 50%;" data-speed="-7"></i>
            
            <div class="position-relative" style="z-index: 2;">
                <h2 class="display-4 fw-bold mb-4">Sống Cùng Đam Mê</h2>
                <p class="lead w-75 mx-auto mb-4" style="opacity: 0.9;">
                    "Âm nhạc không chỉ là những âm thanh, mà là cảm xúc được cất lên thành lời."
                    Hãy để Melody Shop giúp bạn tìm thấy người bạn đồng hành hoàn hảo nhất cho hành trình âm nhạc của mình.
                </p>
                <button class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-dark">Lên Ngay Combo Dành Cho Bạn</button>
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
                    <p class="text-primary fw-bold">Từ 1.200.000 ₫</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="custom-card p-3 text-center">
                    <i class="fas fa-microphone fa-3x text-secondary mb-3"></i>
                    <h6 class="fw-bold">Micro Thu Âm</h6>
                    <p class="text-primary fw-bold">Từ 850.000 ₫</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="custom-card p-3 text-center">
                    <i class="fas fa-bolt fa-3x text-secondary mb-3"></i>
                    <h6 class="fw-bold">Amply Guitar</h6>
                    <p class="text-primary fw-bold">Từ 2.500.000 ₫</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="custom-card p-3 text-center">
                    <i class="fas fa-sliders-h fa-3x text-secondary mb-3"></i>
                    <h6 class="fw-bold">Pedal & Phôi</h6>
                    <p class="text-primary fw-bold">Từ 500.000 ₫</p>
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
                        <h5 class="fw-bold">Cách chọn Guitar cho người mới bắt đầu</h5>
                        <p class="footer-text small">Tìm hiểu các tiêu chí quan trọng để chọn được cây đàn phù hợp nhất với vóc dáng và phong cách của bạn.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="custom-card h-100">
                    <img src="https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 2">
                    <div class="p-4">
                        <span class="badge bg-primary mb-2">Review</span>
                        <h5 class="fw-bold">Đánh giá chi tiết Roland RP-30</h5>
                        <p class="footer-text small">Liệu đây có phải là cây đàn Piano điện quốc dân trong tầm giá dưới 20 triệu? Cùng chuyên gia mổ xẻ chi tiết.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="custom-card h-100">
                    <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=600&auto=format&fit=crop" class="blog-img" alt="Blog 3">
                    <div class="p-4">
                        <span class="badge bg-primary mb-2">Sự kiện</span>
                        <h5 class="fw-bold">Sự kiện Workshop: Kỹ thuật Slap Bass</h5>
                        <p class="footer-text small">Đăng ký tham gia ngay buổi workshop cuối tuần này cùng tay bass hàng đầu Việt Nam.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5 pt-5 mb-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold">Khách Hàng Nói Gì?</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-right">
                <div class="custom-card p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-size: 20px;">A</div>
                        <div>
                            <h6 class="fw-bold mb-0">Anh Tuấn</h6>
                            <small class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></small>
                        </div>
                    </div>
                    <p class="footer-text fst-italic">"Đã mua cây Fender Stratocaster ở đây. Chất lượng âm thanh tuyệt vời, nhân viên tư vấn rất có tâm. Sẽ ủng hộ shop dài dài."</p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="custom-card p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-size: 20px;">H</div>
                        <div>
                            <h6 class="fw-bold mb-0">Hương Ly</h6>
                            <small class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></small>
                        </div>
                    </div>
                    <p class="footer-text fst-italic">"Piano điện giao đến đóng gói cẩn thận, lắp ráp nhanh chóng. Các bạn KTV hướng dẫn sử dụng rất nhiệt tình. Rất ưng ý!"</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5 py-5" data-aos="zoom-in">
        <div class="custom-card p-5 text-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none;">
            <h2 class="fw-bold mb-3">Nhận Voucher Giảm Giá 10%</h2>
            <p class="mb-4 opacity-75">Đăng ký email để nhận ngay mã giảm giá và thông tin các nhạc cụ mới nhất.</p>
            <div class="input-group mb-3 mx-auto" style="max-width: 500px;">
                <input type="email" class="form-control form-control-lg" placeholder="Nhập email của bạn...">
                <button class="btn btn-dark px-4 fw-bold" type="button">Đăng ký ngay</button>
            </div>
        </div>
    </section>

    <footer class="mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-3"><i class="fas fa-music text-primary me-2"></i>Melody Shop</h4>
                    <p class="footer-text">Mang đến những nhạc cụ chất lượng nhất để bạn tự tin tỏa sáng và viết nên giai điệu của riêng mình.</p>
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
                        <li class="mb-2"><a href="#" class="footer-text">Thiết bị phòng thu</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-3">Chính sách</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-text">Bảo hành & Đổi trả</a></li>
                        <li class="mb-2"><a href="#" class="footer-text">Chính sách bảo mật</a></li>
                        <li class="mb-2"><a href="#" class="footer-text">Hướng dẫn trả góp</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="fw-bold mb-3">Liên hệ</h5>
                    <ul class="list-unstyled footer-text">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> 123 Đường Âm Nhạc, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i> 1900 1000 (Miễn phí)</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> contact@melodyshop.vn</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: var(--border-color); opacity: 0.2;">
            <div class="text-center footer-text small">
                &copy; 2024 Melody Shop. Đồ án môn học PHP Kiến trúc MVC.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // 1. Khởi tạo hiệu ứng cuộn trang
        AOS.init({ once: true, offset: 100 });

        // 2. Smart Navbar
        let prevScrollpos = window.pageYOffset;
        const navbar = document.getElementById("smartNavbar");

        window.onscroll = function() {
            let currentScrollPos = window.pageYOffset;
            if (currentScrollPos <= 50) {
                navbar.style.top = "0";
                navbar.style.boxShadow = "none";
            } else {
                navbar.style.boxShadow = "0 4px 10px rgba(0,0,0,0.1)";
                if (prevScrollpos > currentScrollPos) {
                    navbar.style.top = "0";
                } else {
                    navbar.style.top = "-100px";
                }
            }
            prevScrollpos = currentScrollPos;
        }

        // 3. Xử lý Dark/Light Theme
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

        // 4. Parallax Mouse Effect cho Section "Trạm Cảm Hứng"
        const parallaxArea = document.getElementById('parallaxArea');
        const notes = document.querySelectorAll('.music-note');

        if(parallaxArea) {
            parallaxArea.addEventListener('mousemove', (e) => {
                // Tính toán vị trí tương đối của chuột so với trung tâm màn hình
                const x = (e.clientX / window.innerWidth) - 0.5;
                const y = (e.clientY / window.innerHeight) - 0.5;

                notes.forEach(note => {
                    const speed = note.getAttribute('data-speed');
                    // Di chuyển ngược hoặc xuôi theo thuộc tính data-speed
                    note.style.transform = `translate(${x * speed * 20}px, ${y * speed * 20}px)`;
                });
            });
        }
    </script>
</body>
</html>