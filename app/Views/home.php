<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/home.php
 * MÔ TẢ: Giao diện trang chủ của website TTB Music.
 * KIẾN TRÚC: Gọi Header ở đầu và Footer ở cuối để đóng gói toàn bộ giao diện.
 * =========================================================================
 */
// 1. GỌI HEADER (Chứa thẻ <html>, <head>, Navbar, Preloader)
include __DIR__ . '/partials/header.php';
?>

<style>
    /* CSS dành riêng cho trang chủ */
    .hero-section { position: relative; height: 90vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .video-background { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
    .video-background iframe { width: 100vw; height: 56.25vw; min-height: 100vh; min-width: 177.77vh; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
    /* ================= DẢI THƯƠNG HIỆU & GỢN SÓNG (WAVE) ================= */
    .brand-wrapper { display: flex; flex-wrap: wrap; justify-content: center; align-items: center; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); background: var(--card-bg); padding: 30px 0; width: 100%; gap: 30px; }
    
    /* Khôi phục hiệu ứng Gợn sóng (Wave) nhịp nhàng */
    @keyframes subtlePulse {
        0%, 85%, 100% { transform: scale(1); opacity: 0.5; color: var(--text-color); }
        92% { transform: scale(1.15) translateY(-8px); opacity: 1; color: #3b82f6; text-shadow: 0 0 20px rgba(59, 130, 246, 0.6); }
    }
    
    .brand-item { display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 900; color: var(--text-color); cursor: pointer; opacity: 0.5; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); white-space: nowrap; animation: subtlePulse 8s infinite; }
    
    /* Tính toán Delay cho sóng truyền từ trái qua phải (11 items) */
    .brand-item:nth-child(1) { animation-delay: 0.0s; }
    .brand-item:nth-child(2) { animation-delay: 0.2s; }
    .brand-item:nth-child(3) { animation-delay: 0.4s; }
    .brand-item:nth-child(4) { animation-delay: 0.6s; }
    .brand-item:nth-child(5) { animation-delay: 0.8s; }
    .brand-item:nth-child(6) { animation-delay: 1.0s; }
    .brand-item:nth-child(7) { animation-delay: 1.2s; }
    .brand-item:nth-child(8) { animation-delay: 1.4s; }
    .brand-item:nth-child(9) { animation-delay: 1.6s; }
    .brand-item:nth-child(10) { animation-delay: 1.8s; }
    .brand-item:nth-child(11) { animation-delay: 2.0s; }
    
    .brand-item:hover { animation: none; opacity: 1; color: #3b82f6; transform: scale(1.2) translateY(-10px) !important; text-shadow: 0 10px 20px rgba(59, 130, 246, 0.5); z-index: 10; }

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
</style>

<section class="hero-section text-center">
    <div class="video-background">
        <iframe src="https://www.youtube.com/embed/wNCDWk8mxXs?autoplay=1&mute=1&playlist=wNCDWk8mxXs&loop=1&controls=0&disablekb=1&fs=0&modestbranding=1&playsinline=1" frameborder="0" allow="autoplay; fullscreen"></iframe>
    </div>
    <div class="hero-overlay"></div>
    <div class="container hero-content" data-aos="zoom-in" data-aos-duration="1500">
        <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill">TTB COLLECTION 2024</span>
        <h1 class="display-2 fw-bolder mb-4 text-white">Giai Điệu Của Riêng Bạn</h1>
        <p class="lead mb-5 text-light mx-auto" style="max-width: 600px;">Hệ thống mua bán và cho thuê nhạc cụ chuyên nghiệp nhất. Thỏa mãn đam mê không lo về giá.</p>
        <a href="index.php?controller=product&action=index" class="btn btn-primary btn-lg px-5 py-3 rounded-pill me-3 fw-bold text-decoration-none">Khám Phá Ngay</a>
    </div>
</section>

<section class="brand-wrapper my-5 container-fluid px-5">
    <div class="brand-item"><i class="fas fa-record-vinyl me-2"></i> YAMAHA</div>
    <div class="brand-item"><i class="fas fa-guitar me-2"></i> FENDER</div>
    <div class="brand-item"><i class="fas fa-keyboard me-2"></i> ROLAND</div>
    <div class="brand-item"><i class="fas fa-drum me-2"></i> PEARL</div>
    <div class="brand-item"><i class="fas fa-headphones me-2"></i> MARSHALL</div>
    <div class="brand-item"><i class="fas fa-music me-2"></i> KORG</div>
    <div class="brand-item"><i class="fas fa-guitar me-2"></i> KAWAI</div>
    <div class="brand-item"><i class="fas fa-keyboard me-2"></i> CASIO</div>
    <div class="brand-item"><i class="fas fa-guitar me-2"></i> GIBSON</div>
    <div class="brand-item"><i class="fas fa-guitar me-2"></i> IBANEZ</div>
    <div class="brand-item"><i class="fas fa-music me-2"></i> ESP</div>
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
            <a href="index.php?controller=product&action=index" class="btn btn-outline-primary rounded-pill px-4 py-2">Xem chi tiết <i class="fas fa-arrow-right ms-2"></i></a>
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
                    <button class="btn btn-outline-primary rounded-pill w-100"><i class='bx bx-cart-add fs-5 align-middle me-2'></i>Thêm giỏ hàng</button>
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
                    <button class="btn btn-outline-primary rounded-pill w-100"><i class='bx bx-cart-add fs-5 align-middle me-2'></i>Thêm giỏ hàng</button>
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
                    <button class="btn btn-outline-primary rounded-pill w-100"><i class='bx bx-cart-add fs-5 align-middle me-2'></i>Thêm giỏ hàng</button>
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

<?php
// 2. GỌI FOOTER VÀ KẾT THÚC TRANG
include __DIR__ . '/partials/footer.php';
?>