<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giai Điệu Vàng - Cửa Hàng Nhạc Cụ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Tông màu xanh dương tối hiện đại */
        body {
            background-color: #0f172a; /* Slate 900 */
            color: #f8fafc; /* Slate 50 */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Custom Header/Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 100px 0;
            border-bottom: 1px solid #334155;
        }

        /* Card sản phẩm nổi bật */
        .product-card {
            background-color: #1e293b;
            border: 1px solid #334155;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            border-color: #3b82f6; /* Blue 500 */
        }
    </style>
</head>
<body>

    <section class="hero-section text-center" data-aos="fade-down" data-aos-duration="1000">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Đánh Thức Đam Mê Âm Nhạc</h1>
            <p class="lead mb-4">Khám phá bộ sưu tập nhạc cụ cao cấp với giá tốt nhất thị trường.</p>
            <button class="btn btn-primary btn-lg px-4 rounded-pill">Xem Sản Phẩm Ngay</button>
        </div>
    </section>

    <div class="container my-5">
        <h2 class="text-center mb-5" data-aos="fade-up">Nhạc Cụ Nổi Bật</h2>
        
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="product-card p-3 h-100 text-center">
                    <i class="fas fa-guitar fa-4x mb-3 text-primary"></i>
                    <h4>Acoustic Guitar Yamaha</h4>
                    <p class="text-muted">Âm thanh mộc mạc, phù hợp cho người mới bắt đầu.</p>
                    <h5 class="text-info">2.500.000 VNĐ</h5>
                    <button class="btn btn-outline-light mt-2">Thêm giỏ hàng</button>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="product-card p-3 h-100 text-center">
                    <i class="fas fa-music fa-4x mb-3 text-primary"></i>
                    <h4>Piano Điện Roland</h4>
                    <p class="text-muted">Phím gõ chân thực, tích hợp nhiều âm sắc.</p>
                    <h5 class="text-info">15.000.000 VNĐ</h5>
                    <button class="btn btn-outline-light mt-2">Thêm giỏ hàng</button>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="product-card p-3 h-100 text-center">
                    <i class="fas fa-drum fa-4x mb-3 text-primary"></i>
                    <h4>Trống Cơ Pearl</h4>
                    <p class="text-muted">Bùng nổ sân khấu với dàn trống chất lượng cao.</p>
                    <h5 class="text-info">20.500.000 VNĐ</h5>
                    <button class="btn btn-outline-light mt-2">Thêm giỏ hàng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Khởi tạo hiệu ứng cuộn chuột
        AOS.init({
            once: true, // Chỉ chạy animation 1 lần khi cuộn xuống
            offset: 100 // Khoảng cách cuộn trước khi hiện
        });
    </script>
</body>
</html>