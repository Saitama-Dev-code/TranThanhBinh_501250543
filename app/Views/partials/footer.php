<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/partials/footer.php
 * MÔ TẢ: Fix hiệu ứng Hover Social Icons, Link trượt và khôi phục nội dung Modal.
 * =========================================================================
 */
if (isset($_GET['spa']) && $_GET['spa'] == '1') {
    return;
}
?>
            </div> <!-- Close active page container -->
        </div> <!-- Close spa-viewport -->
    </div> <!-- Close main-content-wrapper -->

    <footer class="mt-5 pt-5" data-aos="fade-up" data-aos-offset="50" data-aos-once="true" style="background-color: var(--card-bg); border-top: 1px solid var(--border-color); padding: 60px 0 20px 0; position: relative; z-index: 10;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="fw-bold mb-3"><i class="fas fa-music text-primary me-2"></i>TTB MUSIC</h4>
                    <p class="mb-4" style="color: var(--text-color); opacity: 0.8;">
                        Hệ thống cung cấp nhạc cụ hàng đầu, nơi khơi nguồn những giai điệu bất hủ và trải nghiệm âm nhạc đỉnh cao.
                    </p>
                    
                    <div class="d-flex gap-3">
                        <a href="#" class="social-circle-icon fb" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-circle-icon zl" title="Zalo"><i class="fas fa-comment-dots"></i></a>
                        <a href="#" class="social-circle-icon yt" title="Youtube"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-circle-icon ins" title="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 offset-lg-1 col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="fw-bold mb-3" style="color: var(--text-color);">Cửa hàng</h5>
                    <ul class="list-unstyled footer-link-list">
                        <li><a href="index.php?controller=product&action=index&category=1">Guitar & Bass</a></li>
                        <li><a href="index.php?controller=product&action=index&category=2">Piano & Organ</a></li>
                        <li><a href="index.php?controller=product&action=index&category=3">Trống & Bộ gõ</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <h5 class="fw-bold mb-3" style="color: var(--text-color);">Dịch vụ</h5>
                    <ul class="list-unstyled footer-link-list">
                        <li><a href="#" class="text-warning fw-bold">Cho Thuê Nhạc Cụ</a></li>
                        <li><a href="#">Bảo hành tận nơi</a></li>
                        <li><a href="#">Học viện TTB</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <h5 class="fw-bold mb-3" style="color: var(--text-color);">Liên hệ</h5>
                    <ul class="list-unstyled" style="color: var(--text-color); opacity: 0.8;">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Quận 1, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i> 1900 1000</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> contact@ttb.music</li>
                    </ul>
                </div>
            </div>

            <hr class="mt-5 mb-4" style="border-color: var(--border-color); opacity: 0.2;">
            <div class="text-center small pb-3" style="color: var(--text-color); opacity: 0.6;">
                &copy; 2024 <strong>TTB MUSIC</strong>. Dự án PHP MVC chuẩn hướng đối tượng.
            </div>
        </div>
    </footer>

    <style>
        /* 1. HIỆU ỨNG ICON MXH JELLY */
        .social-circle-icon {
            width: 42px; height: 42px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(128, 128, 128, 0.1);
            color: var(--text-color); border: 1px solid var(--border-color);
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
        }
        .social-circle-icon:hover {
            transform: translateY(-8px) scale(1.15);
            color: #fff !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .social-circle-icon.fb:hover { background: #1877f2; border-color: #1877f2; }
        .social-circle-icon.zl:hover { background: #0068ff; border-color: #0068ff; }
        .social-circle-icon.yt:hover { background: #ff0000; border-color: #ff0000; }
        .social-circle-icon.ins:hover { background: #e4405f; border-color: #e4405f; }

        /* 2. HIỆU ỨNG LINK TRƯỢT SANG PHẢI */
        .footer-link-list li { margin-bottom: 12px; }
        .footer-link-list a {
            color: var(--text-color); text-decoration: none; opacity: 0.7;
            display: inline-block; transition: all 0.3s ease; position: relative;
        }
        .footer-link-list a:hover {
            opacity: 1; color: #3b82f6 !important; padding-left: 12px;
        }
        .footer-link-list a::before {
            content: '›'; position: absolute; left: -5px;
            opacity: 0; transition: 0.3s; font-weight: bold;
        }
        .footer-link-list a:hover::before { opacity: 1; left: 0px; }

        /* 3. MODAL GLASSMORPHISM & FULL CONTENT */
        body.modal-open {
            overflow: auto !important;
            padding-right: 0 !important;
        }
        .animated-border-wrapper { position: relative; border-radius: 1.6rem; z-index: 1; padding: 2px; }
        .animated-border-wrapper::before { 
            content: ""; position: absolute; inset: 0; border-radius: 1.6rem; 
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899, #3b82f6); 
            background-size: 300% 300%; animation: gradientBorderMove 6s linear infinite; z-index: 0; 
        }
        @keyframes gradientBorderMove { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        
        .glass-panel { 
            background: var(--card-bg); backdrop-filter: blur(25px); border: 1px solid var(--border-color); 
            border-radius: 1.5rem; position: relative; overflow: hidden; z-index: 1; 
        }
        .form-watermark { 
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); 
            font-size: 10rem; font-weight: 900; color: var(--text-color); opacity: 0.03; z-index: 0; pointer-events: none; 
        }
        .modal-body-content { position: relative; z-index: 2; }
        
        .modern-input { 
            background: rgba(128, 128, 128, 0.05) !important; border: 1px solid var(--border-color); 
            color: var(--text-color) !important; border-radius: 0.75rem; 
        }
        
        .custom-floating { position: relative; }
        .custom-floating .modern-input { padding: 1rem 1.25rem; height: auto; }
        .custom-floating label {
            position: absolute; top: 50%; left: 1rem; transform: translateY(-50%);
            background: var(--card-bg); padding: 0 0.4rem; color: var(--text-color); opacity: 0.3;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); pointer-events: none; border-radius: 4px;
        }
        .custom-floating .modern-input:focus ~ label,
        .custom-floating .modern-input:not(:placeholder-shown) ~ label {
            top: 0; transform: translateY(-50%) scale(0.85);
            color: #3b82f6; opacity: 1; font-weight: 600;
        }
        .custom-floating .modern-input:focus {
            border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }
        .btn-glow { background: #3b82f6; border: none; transition: 0.3s; }
        .btn-glow:hover { background: #2563eb; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4); }
        
        .social-btn { 
            background: rgba(128, 128, 128, 0.05); border: 1px solid var(--border-color); 
            color: var(--text-color); transition: 0.3s; 
        }
        .social-btn:hover { background: rgba(128, 128, 128, 0.1); transform: translateY(-2px); }

        /* 4. HOẠT ẢNH ĐÓNG GÓI SẢN PHẨM (PACKAGING FLY TO CART) */
        .packaging-container {
            position: fixed;
            z-index: 999999;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.9s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.9s ease-out;
        }
        .packaging-box {
            position: relative;
            width: 75px;
            height: 65px;
            background: #cd7f32; /* Màu giấy các-tông */
            border: 2px solid #b87333;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            transform: scale(0);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s;
        }
        .packaging-box::before, .packaging-box::after {
            content: '';
            position: absolute;
            top: -12px;
            width: 50%;
            height: 12px;
            background: #d28c46;
            border: 2px solid #b87333;
            box-sizing: border-box;
            transition: transform 0.4s ease;
            transform-origin: bottom center;
            z-index: 3;
        }
        .packaging-box::before {
            left: 0;
            border-top-left-radius: 4px;
            transform: rotate(-75deg);
        }
        .packaging-box::after {
            right: 0;
            border-top-right-radius: 4px;
            transform: rotate(75deg);
        }
        .packaging-box.closed::before {
            transform: rotate(0deg);
            background: #cd7f32;
        }
        .packaging-box.closed::after {
            transform: rotate(0deg);
            background: #cd7f32;
        }
        .packaging-tape {
            position: absolute;
            top: -2px;
            left: 20%;
            width: 60%;
            height: 4px;
            background: #8b5cf6;
            opacity: 0;
            z-index: 4;
            transition: opacity 0.2s ease 0.3s;
            box-shadow: 0 0 8px rgba(139, 92, 246, 0.8);
        }
        .packaging-box.closed .packaging-tape {
            opacity: 1;
        }
        .packaging-img {
            position: absolute;
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 6px;
            z-index: 2;
            transition: transform 0.5s cubic-bezier(0.55, 0.085, 0.68, 0.53), opacity 0.4s;
            transform: translateY(-20px) scale(1);
            opacity: 1;
        }
        .packaging-img.packed {
            transform: translateY(10px) scale(0.1);
            opacity: 0;
        }
        .sparkle-particle {
            position: fixed;
            pointer-events: none;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            z-index: 999999;
            animation: sparkleExplode 0.6s cubic-bezier(0.1, 0.8, 0.3, 1) forwards;
        }
        @keyframes sparkleExplode {
            0% { transform: translate(0, 0) scale(1); opacity: 1; }
            100% { transform: translate(var(--tx), var(--ty)) scale(0); opacity: 0; }
        }

        /* ================================================================================
           CSS CHO AUTH SHEET TRƯỢT LÊN TOÀN MÀN HÌNH & GLASSMORPHISM CARD
           ================================================================================ */
        #page-auth-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 1060; /* Đè lên navbar và ngang hàng cart overlay */
            background: rgba(10, 8, 20, 0.88); /* Nền tối sâu */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            transform: translateY(100%);
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            overflow-y: auto;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #page-auth-overlay.active-sheet {
            transform: translateY(0);
            pointer-events: auto;
        }
        
        /* Canvas vẽ sóng nhạc phát sáng (Audio Waveform) */
        #auth-waves-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        
        /* Card chứa form đăng nhập/đăng ký */
        .auth-glass-card {
            position: relative;
            width: 100%;
            max-width: 480px;
            background: rgba(25, 20, 45, 0.65);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(6, 182, 212, 0.4);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 
                        0 0 20px rgba(139, 92, 246, 0.25), 
                        0 0 10px rgba(6, 182, 212, 0.15);
            padding: 35px 30px;
            z-index: 2;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        /* Chế độ Light theme */
        :root[data-theme="light"] .auth-glass-card {
            background: rgba(255, 255, 255, 0.85);
            border-color: rgba(139, 92, 246, 0.25);
            box-shadow: 0 15px 35px rgba(139, 92, 246, 0.15);
        }

        .auth-card-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 11rem;
            font-weight: 900;
            color: var(--text-color);
            opacity: 0.02;
            z-index: 0;
            pointer-events: none;
        }
        
        .auth-card-content {
            position: relative;
            z-index: 2;
        }

        /* Tab Switcher */
        .auth-tabs {
            display: flex;
            background: rgba(128, 128, 128, 0.08);
            padding: 4px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: 1px solid var(--border-color);
        }
        
        .auth-tab-btn {
            flex: 1;
            padding: 10px;
            text-align: center;
            border: none;
            background: transparent;
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.7;
        }
        
        .auth-tab-btn.active {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: #ffffff;
            opacity: 1;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        /* Form slide transitions */
        .auth-form-wrapper {
            display: flex;
            width: 200%;
            transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1);
        }
        
        .auth-form-pane {
            width: 50%;
            transition: opacity 0.45s ease;
        }
        
        .auth-form-pane.inactive {
            opacity: 0;
            pointer-events: none;
        }

        /* Button Quay lại ở dưới cùng */
        .auth-back-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            background: rgba(128, 128, 128, 0.06);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            color: var(--text-color);
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        
        .auth-back-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.4);
            color: #ef4444;
            transform: translateY(-2px);
        }
    </style>

    <!-- ================================================================================
         TRANG AUTH OVERLAY (AUTH SHEET) TRƯỢT TỪ DƯỚI LÊN THAY THẾ CHO MODAL CŨ
         ================================================================================ -->
    <div id="page-auth-overlay">
        <!-- Canvas vẽ sóng âm thanh phát sáng (Audio Waveform) -->
        <canvas id="auth-waves-canvas"></canvas>
        
        <div class="auth-glass-card animate__animated animate__slideInUp">
            <div class="auth-card-watermark">TTB</div>
            <div class="auth-card-content">
                <!-- Header tiêu đề -->
                <div class="text-center mb-4">
                    <h3 class="fw-bolder mb-1" style="color: var(--text-color);" id="auth-card-title">
                        <i class="fas fa-user-circle text-primary me-2"></i>Đăng Nhập
                    </h3>
                    <p class="small mb-0" style="color: var(--text-color); opacity: 0.7;" id="auth-card-subtitle">Kết nối đam mê tại TTB Music.</p>
                </div>
                
                <!-- Tab chọn chế độ (Đăng nhập / Đăng ký) -->
                <div class="auth-tabs">
                    <button type="button" class="auth-tab-btn active" id="btn-tab-login" onclick="window.switchAuthTab('login')">Đăng nhập</button>
                    <button type="button" class="auth-tab-btn" id="btn-tab-register" onclick="window.switchAuthTab('register')">Đăng ký</button>
                </div>
                
                <!-- Vùng chứa 2 form dạng trượt mượt mà -->
                <div style="overflow: hidden; width: 100%;">
                    <div class="auth-form-wrapper" id="auth-form-wrapper">
                        
                        <!-- FORM ĐĂNG NHẬP -->
                        <div class="auth-form-pane" id="pane-login">
                            <div class="alert alert-danger d-none mx-0 mb-3" id="ajaxLoginError" style="border-radius: 0.5rem; font-size: 0.9rem;"></div>
                            
                            <form id="loginForm" action="index.php?controller=auth&action=loginSubmit" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <div class="custom-floating mb-3">
                                    <input type="email" class="form-control modern-input" id="logEmail" name="email" placeholder=" " value="<?= htmlspecialchars($_SESSION['auth_email_login'] ?? '') ?>" required>
                                    <label for="logEmail">Email của bạn</label>
                                </div>    
                                <div class="custom-floating mb-3">
                                    <input type="password" class="form-control modern-input" id="logPass" name="password" placeholder=" " required>
                                    <label for="logPass">Mật khẩu</label>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remMe">
                                        <label class="form-check-label small" for="remMe" style="color: var(--text-color); opacity: 0.8;">Nhớ mật khẩu</label>
                                    </div>
                                    <a href="index.php?controller=auth&action=forgot" class="text-primary text-decoration-none small fw-bold">Quên mật khẩu?</a>
                                </div>

                                <button type="submit" class="btn btn-glow btn-lg w-100 fw-bold rounded-pill text-white py-3">ĐĂNG NHẬP <i class="fas fa-sign-in-alt ms-2"></i></button>
                            </form>
                            
                            <div class="position-relative my-3 text-center">
                                <hr style="border-color: var(--border-color); opacity: 0.5;">
                                <span class="position-absolute top-50 start-50 translate-middle px-3 small fw-semibold" style="background-color: var(--card-bg); color: var(--text-color); opacity: 0.6;">Hoặc tiếp tục với</span>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button class="btn social-btn w-50 rounded-pill py-2 fw-semibold"><i class="fab fa-google me-2 text-danger"></i> Google</button>
                                <button class="btn social-btn w-50 rounded-pill py-2 fw-semibold"><i class="fab fa-facebook-f me-2 text-primary"></i> Facebook</button>
                            </div>
                            
                            <!-- Tài khoản mẫu -->
                            <div class="p-3 mt-3 rounded-3 text-start" style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.15); font-size: 0.8rem;">
                                <div class="fw-bold mb-1 text-primary"><i class="fas fa-info-circle me-1"></i> Tài khoản khách mẫu (kiểm thử):</div>
                                <div style="color: var(--text-color); opacity: 0.8;"><strong>Email:</strong> customer@ttbmusic.com</div>
                                <div style="color: var(--text-color); opacity: 0.8;"><strong>Mật khẩu:</strong> 123456</div>
                            </div>
                        </div>
                        
                        <!-- FORM ĐĂNG KÝ -->
                        <div class="auth-form-pane inactive" id="pane-register">
                            <div class="alert alert-danger d-none mx-0 mb-3" id="ajaxRegisterError" style="border-radius: 0.5rem; font-size: 0.9rem;"></div>
                            
                            <form id="registerForm" action="index.php?controller=auth&action=registerSubmit" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <div class="custom-floating mb-3">
                                    <input type="text" class="form-control modern-input" id="regName" name="fullname" placeholder=" " required>
                                    <label for="regName">Họ và tên</label>
                                </div>
                                <div class="custom-floating mb-3">
                                    <input type="email" class="form-control modern-input" id="regEmail" name="email" placeholder=" " required>
                                    <label for="regEmail">Email đăng ký</label>
                                </div>
                                <div class="custom-floating mb-3">
                                    <input type="password" class="form-control modern-input" id="regPass" name="password" placeholder=" " required>
                                    <label for="regPass">Mật khẩu (tối thiểu 6 ký tự)</label>
                                </div>
                                <div class="custom-floating mb-4">
                                    <input type="password" class="form-control modern-input" id="regConfirmPass" name="confirm_password" placeholder=" " required>
                                    <label for="regConfirmPass">Xác nhận mật khẩu</label>
                                </div>

                                <button type="submit" class="btn btn-glow btn-lg w-100 fw-bold rounded-pill text-white py-3">ĐĂNG KÝ NGAY <i class="fas fa-user-plus ms-2"></i></button>
                            </form>
                            
                            <div class="position-relative my-3 text-center">
                                <hr style="border-color: var(--border-color); opacity: 0.5;">
                                <span class="position-absolute top-50 start-50 translate-middle px-3 small fw-semibold" style="background-color: var(--card-bg); color: var(--text-color); opacity: 0.6;">Hoặc đăng ký nhanh</span>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button class="btn social-btn w-50 rounded-pill py-2 fw-semibold"><i class="fab fa-google me-2 text-danger"></i> Google</button>
                                <button class="btn social-btn w-50 rounded-pill py-2 fw-semibold"><i class="fab fa-facebook-f me-2 text-primary"></i> Facebook</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <!-- Nút Quay lại trang trước đặt nổi bật ở dưới cùng của Card để đóng sheet -->
                <button type="button" class="auth-back-btn" onclick="window.hideAuthSheet()">
                    <i class="fas fa-arrow-left"></i> Quay lại trang trước
                </button>
            </div>
        </div>
    </div>

    <!-- Tải thông báo lỗi từ Session lên Form nếu có -->
    <?php if(isset($_SESSION['login_error']) || isset($_SESSION['open_login_modal'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (window.showAuthSheet) {
                    window.showAuthSheet();
                }
                <?php if(isset($_SESSION['login_error'])): ?>
                    const errAlert = document.getElementById('ajaxLoginError');
                    if (errAlert) {
                        errAlert.textContent = "<?= htmlspecialchars($_SESSION['login_error']) ?>";
                        errAlert.classList.remove('d-none');
                    }
                <?php endif; ?>
            });
        </script>
        <?php 
            unset($_SESSION['login_error']);
            unset($_SESSION['open_login_modal']);
        ?>
    <?php endif; ?>

    <?php include __DIR__ . '/chat_and_scroll.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        const isHomePageInitial = document.querySelector('.spa-page.active')?.id === 'page-home';
        AOS.init({ 
            once: !isHomePageInitial, /* Nếu không phải home thì chỉ chạy 1 lần, tránh lặp lại kỳ cục */
            mirror: isHomePageInitial, /* Chỉ bật mirror cho trang chủ */
            offset: 100 
        });

        // Sử dụng ResizeObserver để tự động làm mới tọa độ AOS ngay khi kích thước trang thay đổi (ảnh/banner load xong)
        if (typeof ResizeObserver !== 'undefined') {
            let aosResizeTimeout;
            const aosResizeObserver = new ResizeObserver(() => {
                clearTimeout(aosResizeTimeout);
                aosResizeTimeout = setTimeout(() => {
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                }, 100);
            });
            aosResizeObserver.observe(document.body);
        }

        // Chốt chặn cuối cùng khi toàn bộ tài nguyên tải xong
        window.addEventListener('load', () => {
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        });

        // Logic Theme Toggle ổn định
        const themeBtn = document.getElementById('theme-toggle');
        const html = document.documentElement;
        if(themeBtn) {
            const icon = themeBtn.querySelector('i');
            const updateUI = (theme) => {
                icon.className = theme === 'dark' ? 'fas fa-sun text-warning' : 'fas fa-moon text-dark';
            };
            updateUI(html.getAttribute('data-theme'));

            themeBtn.addEventListener('click', () => {
                const current = html.getAttribute('data-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                updateUI(next);
            });
        }

        // Smart Navbar - Điều khiển ẩn/hiện navbar khi cuộn chuột mượt mà
        let prevS = window.pageYOffset;
        const nav = document.getElementById("smartNavbar");
        window.addEventListener('scroll', () => {
            // Kiểm tra xem trang chi tiết sản phẩm có đang mở không
            const detailContainer = document.getElementById('page-detail');
            const isDetailActive = detailContainer && detailContainer.classList.contains('active-sheet');
            if (isDetailActive) {
                if (nav) nav.style.top = "0"; // Giữ cố định hiển thị navbar
                return;
            }

            let currS = window.pageYOffset;
            if(nav) {
                if (currS <= 50) { nav.style.top = "0"; nav.style.boxShadow = "none"; }
                else {
                    nav.style.boxShadow = "0 4px 15px rgba(0,0,0,0.1)";
                    nav.style.top = (prevS > currS) ? "0" : "-100px";
                }
            }
            prevS = currS;
        });

        // Hiệu ứng hạt né chuột
        const ptn = document.getElementById('global-parallax');
        if(ptn) {
            const icons = ['fa-music', 'fa-guitar', 'fa-headphones', 'fa-drum', 'fa-play'];
            const notes = [];
            let mX = -1000, mY = -1000;
            for (let i = 0; i < 40; i++) {
                let w = document.createElement('div');
                w.className = 'note-wrapper';
                w.style.left = Math.random() * 100 + 'vw'; w.style.top = Math.random() * 100 + 'vh';
                let ic = document.createElement('i');
                ic.className = `fas ${icons[Math.floor(Math.random() * icons.length)]} note-icon`;
                ic.style.fontSize = (Math.random() * 1.2 + 0.5) + 'rem';
                w.appendChild(ic); ptn.appendChild(w);
                notes.push({ w, ic });
            }
            window.addEventListener('mousemove', (e) => { mX = e.clientX; mY = e.clientY; });
            function repel() {
                notes.forEach(n => {
                    let r = n.w.getBoundingClientRect();
                    let dx = (r.left + r.width/2) - mX, dy = (r.top + r.height/2) - mY;
                    let d = Math.sqrt(dx*dx + dy*dy);
                    if (d < 150) {
                        let f = (150 - d) / 150, a = Math.atan2(dy, dx);
                        n.ic.style.transform = `translate(${Math.cos(a)*f*50}px, ${Math.sin(a)*f*50}px)`;
                        n.ic.style.transition = 'none';
                    } else {
                        n.ic.style.transform = `translate(0,0)`;
                        n.ic.style.transition = 'transform 0.5s ease';
                    }
                });
                requestAnimationFrame(repel);
            }
            repel();
        }
    </script>
    <script>
    /**
     * HIỆU ỨNG THÊM VÀO GIỎ HÀNG (BAY & AJAX)
     * Dùng chung cho tất cả các trang
     */
    function addToCartAJAX(event, productId, qty = 1, color = '', version = '', imgUrl = '') {
        // Bảo vệ event.preventDefault() tránh lỗi nếu event không được định nghĩa hoặc không phải là sự kiện
        if (event && typeof event.preventDefault === 'function') {
            event.preventDefault();
        }
        const btn = event ? (event.currentTarget || event.target) : null;
        
        // 1. Gửi AJAX request thêm vào giỏ hàng
        fetch('index.php?controller=cart&action=add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                product_id: productId,
                quantity: qty,
                color: color,
                version: version,
                csrf_token: '<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>'
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // 2. Cập nhật số lượng giỏ hàng trên Header (.cart-count)
                const cartCounts = document.querySelectorAll('.cart-count');
                cartCounts.forEach(c => {
                    c.textContent = data.cart_count;
                    // Hiệu ứng giật nhún (bump) cho số lượng
                    c.style.display = 'inline-block';
                    c.style.transition = 'transform 0.15s ease-out';
                    c.style.transform = 'scale(1.4)';
                    setTimeout(() => c.style.transform = 'scale(1)', 150);
                });

                // 3. Thực hiện hiệu ứng Bay (Flying Animation)
                if (btn) {
                    if (imgUrl) {
                        flyToCart(btn, imgUrl);
                    } else {
                        // Cố gắng tìm ảnh gần nhất nếu không truyền (hỗ trợ .product-card ở Shop, .product-card-clean ở Home)
                        const container = btn.closest('.product-card') || btn.closest('.product-card-clean') || btn.closest('.product-card-layout2') || btn.closest('.product-gallery');
                        let src = '';
                        if (container) {
                            const img = container.querySelector('img');
                            if (img) src = img.src;
                        }
                        if (src) flyToCart(btn, src);
                    }
                }
            } else {
                alert(data.message || 'Lỗi thêm vào giỏ hàng.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Mất kết nối tới máy chủ.');
        });
    }

    function flyToCart(startElement, imgUrl) {
        // Tìm biểu tượng giỏ hàng đích trên Navbar (.nav-cart-btn)
        const cartIcon = document.querySelector('.nav-cart-btn .fa-shopping-cart') || document.querySelector('.fa-shopping-cart');
        if (!cartIcon || !startElement) return;

        // Tìm phần tử hình ảnh sản phẩm thực tế để lấy tọa độ bắt đầu bay
        const container = startElement.closest('.product-card') || startElement.closest('.product-card-clean') || startElement.closest('.product-card-layout2') || startElement.closest('.product-gallery') || startElement.closest('.card') || startElement;
        let imgEl = container ? container.querySelector('img') : null;
        if (!imgEl) {
            imgEl = document.getElementById('main-product-image');
        }

        const startRect = imgEl ? imgEl.getBoundingClientRect() : startElement.getBoundingClientRect();
        const endRect = cartIcon.getBoundingClientRect();

        // 1. Tạo container đóng gói ảo
        const pContainer = document.createElement('div');
        pContainer.className = 'packaging-container';
        pContainer.style.width = `${startRect.width}px`;
        pContainer.style.height = `${startRect.height}px`;
        pContainer.style.left = `${startRect.left}px`;
        pContainer.style.top = `${startRect.top}px`;
        
        // 2. Tạo hình ảnh sản phẩm mini
        const pImg = document.createElement('img');
        pImg.src = imgUrl;
        pImg.className = 'packaging-img';
        
        // 3. Tạo hộp các-tông
        const pBox = document.createElement('div');
        pBox.className = 'packaging-box';
        
        // Băng keo dán hộp
        const pTape = document.createElement('div');
        pTape.className = 'packaging-tape';
        pBox.appendChild(pTape);
        
        pContainer.appendChild(pBox);
        pContainer.appendChild(pImg);
        document.body.appendChild(pContainer);
        
        // Kích hoạt hiển thị hộp (scale lên) và sản phẩm chuẩn bị chui vào
        setTimeout(() => {
            pBox.style.transform = 'scale(1)';
            pBox.style.opacity = '1';
        }, 50);

        // Bước 1: Sản phẩm rơi vào hộp
        setTimeout(() => {
            pImg.classList.add('packed');
        }, 350);

        // Bước 2: Đóng nắp hộp và niêm phong băng keo
        setTimeout(() => {
            pBox.classList.add('closed');
            // Tạo hiệu ứng giật nhẹ khi niêm phong
            pBox.style.transform = 'scale(1.15)';
            setTimeout(() => {
                pBox.style.transform = 'scale(1)';
            }, 150);
        }, 800);

        // Bước 3: Bay đi tới giỏ hàng trên navbar
        setTimeout(() => {
            // Tính toán khoảng cách di chuyển
            const currentBoxRect = pBox.getBoundingClientRect();
            const dx = (endRect.left + endRect.width / 2) - (currentBoxRect.left + currentBoxRect.width / 2);
            const dy = (endRect.top + endRect.height / 2) - (currentBoxRect.top + currentBoxRect.height / 2);
            
            pContainer.style.transform = `translate(${dx}px, ${dy}px) scale(0.25)`;
            pContainer.style.opacity = '0.3';
        }, 1300);

        // Bước 4: Khi chạm đích, nổ hạt lấp lánh và xóa container
        setTimeout(() => {
            pContainer.remove();
            
            // Hiệu ứng nhún của biểu tượng giỏ hàng
            cartIcon.style.transition = 'transform 0.2s';
            cartIcon.style.transform = 'scale(1.4)';
            cartIcon.style.color = '#8b5cf6';
            setTimeout(() => {
                cartIcon.style.transform = 'scale(1)';
                cartIcon.style.color = '';
            }, 250);

            // Tạo các hạt lấp lánh (sparkles) nổ ra xung quanh giỏ hàng
            const colors = ['#3b82f6', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b'];
            for (let i = 0; i < 12; i++) {
                const sparkle = document.createElement('div');
                sparkle.className = 'sparkle-particle';
                sparkle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                sparkle.style.left = `${endRect.left + endRect.width / 2}px`;
                sparkle.style.top = `${endRect.top + endRect.height / 2}px`;
                
                // Hướng nổ ngẫu nhiên
                const angle = Math.random() * Math.PI * 2;
                const distance = 30 + Math.random() * 40;
                sparkle.style.setProperty('--tx', `${Math.cos(angle) * distance}px`);
                sparkle.style.setProperty('--ty', `${Math.sin(angle) * distance}px`);
                
                document.body.appendChild(sparkle);
                setTimeout(() => sparkle.remove(), 600);
            }
        }, 2200);
    }
    </script>
    
    <!-- =========================================================================
         PHẦN 12: SPA ROUTER & TRANSITION ENGINE (ZERO-RELOAD SPA)
         ========================================================================= -->
    <script>
    (function() {
        // 1. Ghi đè addEventListener và onload để thực thi script tải động qua AJAX
        const originalAddEventListener = EventTarget.prototype.addEventListener;
        EventTarget.prototype.addEventListener = function(type, listener, options) {
            if ((this === document || this === window) && (type === 'DOMContentLoaded' || type === 'load')) {
                if (document.readyState !== 'loading') {
                    setTimeout(() => {
                        try {
                            listener.call(this, new Event(type));
                        } catch (e) {
                            console.error("SPA: Lỗi thực thi listener trì hoãn:", e);
                        }
                    }, 10);
                    return;
                }
            }
            return originalAddEventListener.call(this, type, listener, options);
        };

        Object.defineProperty(window, 'onload', {
            set: function(listener) {
                if (typeof listener === 'function') {
                    setTimeout(() => {
                        try {
                            listener.call(window, new Event('load'));
                        } catch (e) {
                            console.error("SPA: Lỗi thực thi window.onload:", e);
                        }
                    }, 10);
                }
            },
            configurable: true
        });

        // 2. Chuyển tiếp cuộn chuột khi bật Auth Sheet
        const authSheetEl = document.getElementById('page-auth-overlay');
        if (authSheetEl) {
            authSheetEl.addEventListener('wheel', function(e) {
                // Chỉ chuyển tiếp cuộn chuột nếu bản thân sheet không có thanh cuộn hoặc cuộn hết cỡ
                const isScrollable = authSheetEl.scrollHeight > authSheetEl.clientHeight;
                if (!isScrollable) {
                    window.scrollBy(0, e.deltaY);
                }
            }, { passive: true });
        }

        // 3. Khởi tạo đối tượng định tuyến SPA
        const SPARouter = {
            isTransitioning: false,
            scrollPositions: {},
            backgroundPageUrl: null,
            lastClickedProductId: null,
            lastClickedProductImage: null,
            currentUrl: window.location.href,

            getPageIndex(url) {
                try {
                    const urlObj = new URL(url, window.location.href);
                    const controller = urlObj.searchParams.get('controller') || 'home';
                    const action = urlObj.searchParams.get('action') || 'index';
                    
                    if (controller === 'home') return 0;
                    if (controller === 'product') {
                        if (action === 'detail') return 2;
                        return 1;
                    }
                    if (controller === 'cart') return 3;
                    if (controller === 'profile') return 4;
                    if (controller === 'auth') return 5;
                    return 0;
                } catch (e) {
                    return 0;
                }
            },

            getPageContainerId(url) {
                try {
                    const urlObj = new URL(url, window.location.href);
                    const controller = urlObj.searchParams.get('controller') || 'home';
                    const action = urlObj.searchParams.get('action') || 'index';
                    
                    if (controller === 'home') return 'page-home';
                    if (controller === 'product') {
                        if (action === 'detail') return 'page-detail';
                        return 'page-shop';
                    }
                    if (controller === 'cart') return 'page-cart';
                    if (controller === 'profile') return 'page-profile';
                    if (controller === 'auth') return 'page-auth';
                    return 'page-home';
                } catch (e) {
                    return 'page-home';
                }
            },

            cleanUrl(url) {
                try {
                    const urlObj = new URL(url, window.location.href);
                    return urlObj.pathname + urlObj.search;
                } catch (e) {
                    return url;
                }
            },

            updateNavbar(url) {
                try {
                    const urlObj = new URL(url, window.location.href);
                    const controller = urlObj.searchParams.get('controller') || 'home';
                    
                    document.querySelectorAll('.nav-link').forEach(link => {
                        const href = link.getAttribute('href');
                        if (!href || href === '#' || href.trim() === '') {
                            link.classList.remove('active');
                            return;
                        }
                        const linkUrl = new URL(href, window.location.href);
                        const linkController = linkUrl.searchParams.get('controller') || 'home';
                        
                        if (linkController === controller) {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });
                } catch (e) {}
            },

            executeScripts(container) {
                const scripts = container.querySelectorAll('script');
                scripts.forEach(oldScript => {
                    if (oldScript.src && (oldScript.src.includes('bootstrap') || oldScript.src.includes('aos.js'))) {
                        return;
                    }
                    const newScript = document.createElement('script');
                    Array.from(oldScript.attributes).forEach(attr => {
                        newScript.setAttribute(attr.name, attr.value);
                    });
                    newScript.textContent = oldScript.textContent;
                    document.body.appendChild(newScript);
                    newScript.remove();
                });
            },

            // Xử lý giỏ hàng overlay trượt xuống
            showCartOverlay(url, htmlContent) {
                let cartContainer = document.getElementById('page-cart');
                if (!cartContainer) {
                    cartContainer = document.createElement('div');
                    cartContainer.id = 'page-cart';
                    cartContainer.className = 'spa-page';
                    document.getElementById('spa-viewport').appendChild(cartContainer);
                }

                // Tiêm nội dung mới
                cartContainer.innerHTML = htmlContent;
                this.executeScripts(cartContainer);

                // Khởi chạy modal và các logic giỏ hàng
                if (typeof window.initCartPage === 'function') {
                    window.initCartPage();
                }

                // Hiển thị overlay trượt xuống
                cartContainer.style.display = 'block';
                // Đọc offsetWidth để buộc reflow trước khi bật animation
                cartContainer.offsetWidth;
                cartContainer.classList.add('active-overlay');
                document.body.style.overflow = 'hidden'; // ✅ Khóa cuộn trang nền dưới giỏ hàng

                this.isTransitioning = false;
            },

            hideCartOverlay() {
                const cartContainer = document.getElementById('page-cart');
                if (cartContainer && cartContainer.classList.contains('active-overlay')) {
                    cartContainer.classList.remove('active-overlay');
                    
                    // Chỉ mở khóa cuộn body nếu không có page-detail active bên dưới
                    const detailContainer = document.getElementById('page-detail');
                    const isDetailActive = detailContainer && detailContainer.classList.contains('active-sheet');
                    if (!isDetailActive) {
                        document.body.style.overflow = '';
                    }

                    setTimeout(() => {
                        cartContainer.style.display = 'none';
                    }, 700);
                }
            },

            // Xử lý trang chi tiết sản phẩm sheet trượt lên
            showDetailSheet(url, htmlContent) {
                let detailContainer = document.getElementById('page-detail');
                if (!detailContainer) {
                    detailContainer = document.createElement('div');
                    detailContainer.id = 'page-detail';
                    detailContainer.className = 'spa-page';
                    document.getElementById('spa-viewport').appendChild(detailContainer);
                }

                // Tiêm nội dung mới
                detailContainer.innerHTML = htmlContent;
                this.executeScripts(detailContainer);

                // Cuộn trang chi tiết về đầu
                detailContainer.scrollTo({ top: 0 });

                // Khởi chạy các logic và canvas chi tiết sản phẩm
                if (typeof initDetailPage === 'function') {
                    initDetailPage();
                }

                // Hiển thị sheet trượt lên
                detailContainer.style.display = 'block';
                detailContainer.offsetWidth; // Reflow
                detailContainer.classList.add('active-sheet');
                document.body.style.overflow = 'hidden'; // Khóa cuộn trang nền

                // Cập nhật ngay trạng thái nút Lên đầu trang (ẩn đi vì trang chi tiết đang ở top)
                if (typeof window.updateScrollToTopBtn === 'function') {
                    window.updateScrollToTopBtn();
                }

                // Buộc Navbar hiển thị cố định ngay lập tức khi mở trang chi tiết sản phẩm
                const nav = document.getElementById("smartNavbar");
                if (nav) {
                    nav.style.top = "0";
                    nav.style.boxShadow = "0 4px 15px rgba(0,0,0,0.1)";
                    if (typeof window.updateNavHeight === 'function') {
                        window.updateNavHeight();
                    }
                }

                // Khởi tạo lại và làm tươi AOS cho các phần tử động mới chèn vào DOM
                if (typeof AOS !== 'undefined') {
                    try {
                        AOS.init({ 
                            once: true,
                            mirror: false,
                            offset: 100 
                        });
                        AOS.refresh();
                    } catch(aosErr) {}
                }

                this.isTransitioning = false;
            },

            hideDetailSheet() {
                const detailContainer = document.getElementById('page-detail');
                if (detailContainer && detailContainer.classList.contains('active-sheet')) {
                    detailContainer.classList.remove('active-sheet');
                    
                    // Chỉ mở khóa cuộn body nếu không có page-cart active bên dưới
                    const cartContainer = document.getElementById('page-cart');
                    const isCartActive = cartContainer && cartContainer.classList.contains('active-overlay');
                    if (!isCartActive) {
                        document.body.style.overflow = '';
                    }

                    // Cập nhật lại trạng thái nút Lên đầu trang theo trang cửa hàng/nền phía dưới
                    if (typeof window.updateScrollToTopBtn === 'function') {
                        window.updateScrollToTopBtn();
                    }
                    
                    // Dọn dẹp canvas và sự kiện
                    if (typeof window.detailCanvasCleanup === 'function') {
                        try { window.detailCanvasCleanup(); window.detailCanvasCleanup = null; } catch(e) { console.error(e); }
                    }

                    setTimeout(() => {
                        detailContainer.style.display = 'none';
                        detailContainer.remove(); // Xoá để giải phóng bộ nhớ và sự kiện
                    }, 700);
                }
            },

            async navigateTo(url, isBack = false) {
                if (this.isTransitioning) return;
                
                const fromUrl = this.currentUrl || window.location.href;
                const toUrl = url;
                
                const fromContainerId = this.getPageContainerId(fromUrl);
                const toContainerId = this.getPageContainerId(toUrl);

                // 🚀 Khắc phục tự lặp: Nếu click vào chính URL hiện tại (hoặc cùng trang)
                if (this.cleanUrl(toUrl) === this.cleanUrl(fromUrl)) {
                    const toParams = new URL(toUrl, window.location.href).searchParams;
                    const fromParams = new URL(fromUrl, window.location.href).searchParams;
                    if (toParams.toString() === fromParams.toString()) {
                        // Cùng tham số query -> cuộn lên đầu
                        if (toContainerId === 'page-detail') {
                            const detailSheet = document.getElementById('page-detail');
                            if (detailSheet) detailSheet.scrollTo({ top: 0, behavior: 'smooth' });
                        } else {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                        this.isTransitioning = false;
                        return;
                    }
                }
                
                // Luôn cập nhật currentUrl ngay từ đầu
                this.currentUrl = toUrl;
                
                const fromIndex = this.getPageIndex(fromUrl);
                const toIndex = this.getPageIndex(toUrl);

                // Nếu đích đến là Detail, tự động cập nhật productId phục vụ Morph Zoom
                if (toContainerId === 'page-detail') {
                    try {
                        const urlObj = new URL(toUrl, window.location.href);
                        const pid = urlObj.searchParams.get('id');
                        if (pid) {
                            this.lastClickedProductId = pid;
                        }
                    } catch (e) {}
                }

                // Lưu trạng thái cuộn của trang hiện tại trước khi chuyển đi
                if (fromContainerId !== 'page-cart') {
                    this.scrollPositions[this.cleanUrl(fromUrl)] = window.scrollY;
                }

                // Cập nhật lịch sử duyệt web
                if (!isBack) {
                    history.pushState(null, '', toUrl);
                }

                this.isTransitioning = true;

                // Xử lý riêng nếu đích đến là Giỏ hàng (Overlay trượt xuống)
                if (toContainerId === 'page-cart') {
                    // Lưu URL trang nền hiện tại
                    if (fromContainerId !== 'page-cart') {
                        this.backgroundPageUrl = fromUrl;
                        window.spaBackgroundUrl = fromUrl;
                    }
                    try {
                        const cleanToUrl = this.cleanUrl(toUrl);
                        const spaUrl = cleanToUrl + (cleanToUrl.includes('?') ? '&' : '?') + 'spa=1';
                        const res = await fetch(spaUrl);
                        const htmlText = await res.text();
                        
                        const doc = new DOMParser().parseFromString(htmlText, 'text/html');
                        const titleMeta = doc.querySelector('title-meta');
                        if (titleMeta) {
                            document.title = titleMeta.getAttribute('data-title') || document.title;
                        }
                        
                        this.showCartOverlay(toUrl, htmlText);
                    } catch (e) {
                        console.error("Lỗi AJAX tải giỏ hàng:", e);
                        this.isTransitioning = false;
                        window.location.href = toUrl; // fallback
                    }
                    return;
                }

                // Nếu đang ở Giỏ hàng và đi tới trang khác
                if (fromContainerId === 'page-cart') {
                    // Xem trang đích đã có trong DOM chưa
                    let toContainer = document.getElementById(toContainerId);
                    const isCached = (toContainer !== null);

                    if (isCached) {
                        // Cập nhật class active cho trang đích dưới nền nếu khác biệt
                        const currentActivePage = document.querySelector('.spa-page.active');
                        if (currentActivePage && currentActivePage.id !== toContainerId) {
                            currentActivePage.classList.remove('active');
                            toContainer.classList.add('active');
                        }

                        this.hideCartOverlay();
                        this.updateNavbar(toUrl);
                        this.isTransitioning = false;
                        return;
                    } else {
                        // Tải trang đích chèn xuống dưới overlay
                        try {
                            const cleanToUrl = this.cleanUrl(toUrl);
                            const spaUrl = cleanToUrl + (cleanToUrl.includes('?') ? '&' : '?') + 'spa=1';
                            const res = await fetch(spaUrl);
                            const htmlText = await res.text();

                            const parser = new DOMParser();
                            const doc = parser.parseFromString(htmlText, 'text/html');
                            
                            // Gỡ bỏ active của trang cũ
                            const currentActivePage = document.querySelector('.spa-page.active');
                            if (currentActivePage) {
                                currentActivePage.classList.remove('active');
                            }

                            toContainer = document.createElement('div');
                            toContainer.id = toContainerId;
                            toContainer.className = 'spa-page active';
                            
                            const titleMeta = doc.querySelector('title-meta');
                            if (titleMeta) {
                                const pageTitle = titleMeta.getAttribute('data-title') || document.title;
                                document.title = pageTitle;
                                toContainer.setAttribute('data-page-title', pageTitle);
                            }
                            
                            toContainer.innerHTML = htmlText;
                            
                            // Chèn trước page-cart để nằm ở dưới
                            const viewport = document.getElementById('spa-viewport');
                            const cartOverlay = document.getElementById('page-cart');
                            if (cartOverlay) {
                                viewport.insertBefore(toContainer, cartOverlay);
                            } else {
                                viewport.appendChild(toContainer);
                            }
                            
                            this.executeScripts(toContainer);
                            
                            if (toContainerId === 'page-shop' && typeof window.initShopPage === 'function') {
                                window.initShopPage();
                            } else if (toContainerId === 'page-home' && typeof window.initHomePage === 'function') {
                                window.initHomePage();
                            } else if (toContainerId === 'page-profile' && typeof window.initProfilePage === 'function') {
                                window.initProfilePage();
                            }

                            this.hideCartOverlay();
                            this.updateNavbar(toUrl);
                            this.isTransitioning = false;
                        } catch (e) {
                            console.error("Lỗi AJAX tải trang nền khi đóng giỏ hàng:", e);
                            this.isTransitioning = false;
                            window.location.href = toUrl;
                        }
                        return;
                    }
                }

                // Xử lý riêng nếu đích đến là Chi tiết sản phẩm (Sheet trượt từ dưới lên)
                if (toContainerId === 'page-detail') {
                    // Lưu URL trang nền hiện tại
                    if (fromContainerId !== 'page-detail' && fromContainerId !== 'page-cart') {
                        this.backgroundPageUrl = fromUrl;
                        window.spaBackgroundUrl = fromUrl;
                    }
                    try {
                        const cleanToUrl = this.cleanUrl(toUrl);
                        const spaUrl = cleanToUrl + (cleanToUrl.includes('?') ? '&' : '?') + 'spa=1';
                        const res = await fetch(spaUrl);
                        const htmlText = await res.text();
                        
                        const doc = new DOMParser().parseFromString(htmlText, 'text/html');
                        const titleMeta = doc.querySelector('title-meta');
                        if (titleMeta) {
                            document.title = titleMeta.getAttribute('data-title') || document.title;
                        }
                        
                        this.showDetailSheet(toUrl, htmlText);
                    } catch (e) {
                        console.error("Lỗi AJAX tải chi tiết sản phẩm:", e);
                        this.isTransitioning = false;
                        window.location.href = toUrl; // fallback
                    }
                    return;
                }

                // Nếu đang ở Chi tiết sản phẩm và đi tới trang khác
                if (fromContainerId === 'page-detail') {
                    // Xem trang đích đã có trong DOM chưa
                    let toContainer = document.getElementById(toContainerId);
                    const isCached = (toContainer !== null);

                    if (isCached) {
                        // Cập nhật class active cho trang đích dưới nền nếu khác biệt
                        const currentActivePage = document.querySelector('.spa-page.active');
                        if (currentActivePage && currentActivePage.id !== toContainerId) {
                            currentActivePage.classList.remove('active');
                            toContainer.classList.add('active');
                        }

                        // Kịch bản mượt nhất: Trang nền đã có sẵn bên dưới sheet
                        this.hideDetailSheet();
                        this.updateNavbar(toUrl);
                        this.isTransitioning = false;
                        return;
                    } else {
                        // Kịch bản truy cập trực tiếp: Phải tải trang nền chèn xuống dưới sheet
                        try {
                            const cleanToUrl = this.cleanUrl(toUrl);
                            const spaUrl = cleanToUrl + (cleanToUrl.includes('?') ? '&' : '?') + 'spa=1';
                            const res = await fetch(spaUrl);
                            const htmlText = await res.text();

                            const parser = new DOMParser();
                            const doc = parser.parseFromString(htmlText, 'text/html');
                            
                            // Gỡ bỏ active của trang cũ
                            const currentActivePage = document.querySelector('.spa-page.active');
                            if (currentActivePage) {
                                currentActivePage.classList.remove('active');
                            }

                            toContainer = document.createElement('div');
                            toContainer.id = toContainerId;
                            toContainer.className = 'spa-page active'; // Bật active ngay lập tức dưới nền
                            
                            const titleMeta = doc.querySelector('title-meta');
                            if (titleMeta) {
                                const pageTitle = titleMeta.getAttribute('data-title') || document.title;
                                document.title = pageTitle;
                                toContainer.setAttribute('data-page-title', pageTitle);
                            }
                            
                            toContainer.innerHTML = htmlText;
                            
                            // Chèn trước page-detail để nó nằm bên dưới sheet
                            const viewport = document.getElementById('spa-viewport');
                            const detailSheet = document.getElementById('page-detail');
                            if (detailSheet) {
                                viewport.insertBefore(toContainer, detailSheet);
                            } else {
                                viewport.appendChild(toContainer);
                            }
                            
                            // Thực thi scripts của trang đích
                            this.executeScripts(toContainer);
                            
                            if (toContainerId === 'page-shop' && typeof window.initShopPage === 'function') {
                                window.initShopPage();
                            } else if (toContainerId === 'page-home' && typeof window.initHomePage === 'function') {
                                window.initHomePage();
                            } else if (toContainerId === 'page-profile' && typeof window.initProfilePage === 'function') {
                                window.initProfilePage();
                            }

                            // Giờ trượt sheet detail xuống để lộ trang nền vừa chèn
                            this.hideDetailSheet();
                            this.updateNavbar(toUrl);
                            this.isTransitioning = false;
                        } catch (e) {
                            console.error("Lỗi AJAX tải trang nền khi đóng sheet:", e);
                            this.isTransitioning = false;
                            window.location.href = toUrl; // fallback
                        }
                        return;
                    }
                }

                try {
                    // Lấy hoặc tạo container trang đích
                    let toContainer = document.getElementById(toContainerId);
                    const isCached = (toContainer !== null);

                    // Tải trang AJAX nếu chưa có trong DOM
                    if (!isCached) {
                        const cleanToUrl = this.cleanUrl(toUrl);
                        const spaUrl = cleanToUrl + (cleanToUrl.includes('?') ? '&' : '?') + 'spa=1';
                        const res = await fetch(spaUrl);
                        const htmlText = await res.text();

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(htmlText, 'text/html');
                        
                        // Cập nhật tiêu đề trang
                        const titleMeta = doc.querySelector('title-meta');
                        if (titleMeta) {
                            const pageTitle = titleMeta.getAttribute('data-title') || document.title;
                            document.title = pageTitle;
                            toContainer = document.createElement('div');
                            toContainer.setAttribute('data-page-title', pageTitle);
                        } else {
                            toContainer = document.createElement('div');
                        }

                        toContainer.id = toContainerId;
                        toContainer.className = 'spa-page';
                        toContainer.innerHTML = htmlText;
                        document.getElementById('spa-viewport').appendChild(toContainer);

                        // Thực thi inline scripts trong trang mới an toàn
                        try {
                            this.executeScripts(toContainer);
                        } catch (scriptErr) {
                            console.error("SPA: Lỗi thực thi script trang mới:", scriptErr);
                        }
                    } else {
                        // Nếu đã có sẵn trong DOM (cached), chúng ta chỉ cần hiển thị nó lên
                        toContainer.style.display = 'block';
                        const cachedTitle = toContainer.getAttribute('data-page-title');
                        if (cachedTitle) {
                            document.title = cachedTitle;
                        }
                    }

                    const fromContainer = document.getElementById(fromContainerId);
                    
                    // Xác định hướng hoạt ảnh chuyển trang
                    let isRight = toIndex < fromIndex;
                    const isVerticalTransition = (fromContainerId === 'page-shop' && toContainerId === 'page-detail') ||
                                                 (fromContainerId === 'page-detail' && toContainerId === 'page-shop');
                    const isUp = (fromContainerId === 'page-shop' && toContainerId === 'page-detail');

                    // Lấy vị trí cuộn trang hiện tại và đích đến
                    const currentScroll = window.scrollY;
                    const savedScroll = this.scrollPositions[this.cleanUrl(toUrl)] || 0;

                    // Chuẩn bị chuyển trang
                    const viewport = document.getElementById('spa-viewport');
                    viewport.classList.add('spa-viewport-transitioning');

                    // Đóng băng trang cũ ở vị trí cuộn hiện tại để không bị nhảy giật
                    if (fromContainer) {
                        fromContainer.style.position = 'fixed';
                        fromContainer.style.top = `-${currentScroll}px`;
                        fromContainer.style.left = '0';
                        fromContainer.style.width = '100%';
                        fromContainer.style.height = '100vh';
                        fromContainer.style.overflow = 'hidden';
                        
                        fromContainer.classList.add('spa-leaving');
                        if (isVerticalTransition) {
                            fromContainer.classList.add(isUp ? 'slide-up-leaving' : 'slide-down-leaving');
                        } else {
                            fromContainer.classList.add(isRight ? 'slide-right-leaving' : 'slide-left-leaving');
                        }
                    }

                    // Cuộn trang mới đến vị trí đích
                    // Bù chiều cao tạm thời cho trang shop để tránh cuộn hụt khi trang chưa vẽ đủ chiều cao
                    if (toContainerId === 'page-shop') {
                        toContainer.style.minHeight = '3000px';
                    }
                    window.scrollTo(0, savedScroll);

                    // Thêm class bắt đầu transition cho toContainer
                    toContainer.classList.add('spa-entering');
                    if (isVerticalTransition) {
                        toContainer.classList.add(isUp ? 'slide-up-entering-start' : 'slide-down-entering-start');
                    } else {
                        toContainer.classList.add(isRight ? 'slide-right-entering-start' : 'slide-left-entering-start');
                    }
                    
                    // Buộc reflow
                    toContainer.offsetWidth;

                    // Chạy hoạt ảnh
                    if (isVerticalTransition) {
                        toContainer.classList.remove(isUp ? 'slide-up-entering-start' : 'slide-down-entering-start');
                        toContainer.classList.add(isUp ? 'slide-up-entering-end' : 'slide-down-entering-end');
                    } else {
                        toContainer.classList.remove(isRight ? 'slide-right-entering-start' : 'slide-left-entering-start');
                        toContainer.classList.add(isRight ? 'slide-right-entering-end' : 'slide-left-entering-end');
                    }

                    // Cập nhật trạng thái navbar
                    this.updateNavbar(toUrl);

                    // Chờ hoạt ảnh chuyển trang hoàn thành (600ms)
                    setTimeout(() => {
                        try {
                            // Dọn dẹp trang cũ bằng cách xóa hoàn toàn khỏi DOM
                            if (fromContainer) {
                                // Thực hiện dọn dẹp các sự kiện để tránh lỗi rò rỉ listener gây giật lag
                                if (fromContainerId === 'page-home' && typeof window.homePageCleanup === 'function') {
                                    try { window.homePageCleanup(); window.homePageCleanup = null; } catch(e) { console.error(e); }
                                } else if (fromContainerId === 'page-shop' && typeof window.shopPageCleanup === 'function') {
                                    try { window.shopPageCleanup(); window.shopPageCleanup = null; } catch(e) { console.error(e); }
                                } else if (fromContainerId === 'page-detail' && typeof window.detailCanvasCleanup === 'function') {
                                    try { window.detailCanvasCleanup(); window.detailCanvasCleanup = null; } catch(e) { console.error(e); }
                                }
                                fromContainer.remove();
                            }

                            toContainer.classList.remove(
                                'spa-entering', 'slide-left-entering-end', 'slide-right-entering-end',
                                'slide-up-entering-end', 'slide-down-entering-end'
                            );
                            toContainer.classList.add('active');
                            toContainer.style.display = 'block';

                            // Khôi phục lại chiều cao mặc định sau khi đã hoàn tất transition
                            if (toContainerId === 'page-shop') {
                                toContainer.style.minHeight = '';
                            }

                            // Xóa sạch tất cả các page container thừa thãi khác để tránh ô nhiễm CSS cục bộ
                            const pages = viewport.querySelectorAll('.spa-page');
                            pages.forEach(p => {
                                if (p.id !== toContainerId && p.id !== 'page-cart') {
                                    p.remove();
                                }
                            });

                            viewport.classList.remove('spa-viewport-transitioning');

                            // Phục hồi vị trí cuộn trang
                            window.scrollTo(0, savedScroll);

                            // Khởi chạy lại script khởi tạo của từng trang an toàn
                            try {
                                if (toContainerId === 'page-shop' && typeof window.initShopPage === 'function') {
                                    window.initShopPage();
                                } else if (toContainerId === 'page-detail' && typeof window.initDetailPage === 'function') {
                                    window.initDetailPage();
                                } else if (toContainerId === 'page-home' && typeof window.initHomePage === 'function') {
                                    window.initHomePage();
                                } else if (toContainerId === 'page-profile' && typeof window.initProfilePage === 'function') {
                                    window.initProfilePage();
                                }
                            } catch (initErr) {
                                console.error("SPA: Lỗi khởi chạy script khởi tạo trang mới:", initErr);
                            }

                            // Khởi tạo lại và làm tươi AOS cho các phần tử động mới chèn vào DOM
                            if (typeof AOS !== 'undefined') {
                                try {
                                    AOS.init({ 
                                        once: (toContainerId !== 'page-home'), // 🚀 Chỉ chạy 1 lần ở các trang khác để tránh lặp lại kỳ cục
                                        mirror: (toContainerId === 'page-home'), // 🚀 Chỉ bật mirror cho trang chủ
                                        offset: 100 
                                    });
                                    AOS.refresh();
                                } catch(aosErr) {}
                            }
                        } catch (transitionErr) {
                            console.error("SPA: Lỗi trong quá trình hoàn thành transition:", transitionErr);
                        } finally {
                            this.isTransitioning = false; // 🔓 Luôn giải phóng khóa điều hướng
                        }
                    }, 650);

                } catch (e) {
                    console.error("Lỗi AJAX tải trang:", e);
                    this.isTransitioning = false;
                    window.location.href = toUrl; // fallback
                }
            }
        };

        // Lắng nghe click để lưu Product ID phục vụ Morph Zoom
        document.addEventListener('mousedown', function(e) {
            const cardLink = e.target.closest('.product-card a[href*="id="]') || e.target.closest('.product-card-clean a[href*="id="]') || e.target.closest('.product-card-layout2 a[href*="id="]');
            if (cardLink) {
                try {
                    const url = new URL(cardLink.href);
                    const pid = url.searchParams.get('id');
                    if (pid) {
                        SPARouter.lastClickedProductId = pid;
                    }
                } catch (err) {}
            }
        });

        // Lắng nghe sự kiện đi lùi/tiến lịch sử trình duyệt
        window.addEventListener('popstate', function() {
            SPARouter.navigateTo(window.location.href, true);
        });

        // Hỗ trợ sự kiện click trên các anchor tags local
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;
            
            if (link.target === '_blank' || link.hasAttribute('data-no-spa') || link.closest('[data-no-spa]')) return;
            
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;
            
            try {
                const url = new URL(href, window.location.href);
                if (url.origin !== window.location.origin) return;
                
                e.preventDefault();
                SPARouter.navigateTo(href);
            } catch (err) {}
        });

        // Can thiệp submit GET Form (Tìm kiếm, bộ lọc)
        document.addEventListener('submit', function(e) {
            if (e.defaultPrevented) return;
            const form = e.target;
            if (form.method.toLowerCase() === 'get' && !form.hasAttribute('data-no-spa')) {
                const action = form.getAttribute('action') || 'index.php';
                try {
                    const url = new URL(action, window.location.href);
                    if (url.origin === window.location.origin) {
                        e.preventDefault();
                        const formData = new FormData(form);
                        const params = new URLSearchParams(formData);
                        const targetUrl = action + (action.includes('?') ? '&' : '?') + params.toString();
                        SPARouter.navigateTo(targetUrl);
                    }
                } catch (err) {}
            }
        });

        // Tự động kích hoạt overlay giỏ hàng hoặc sheet chi tiết trên trang load đầu tiên
        document.addEventListener('DOMContentLoaded', function() {
            const activePage = document.querySelector('.spa-page.active');
            if (activePage) {
                if (activePage.id === 'page-cart') {
                    activePage.classList.add('active-overlay');
                } else if (activePage.id === 'page-detail') {
                    activePage.classList.add('active-sheet');
                    document.body.style.overflow = 'hidden'; // ✅ Khóa cuộn trang nền dưới sheet
                    if (typeof window.updateNavHeight === 'function') {
                        window.updateNavHeight();
                    }
                }
            }
        });

        // =========================================================================
        // JAVASCRIPT ĐIỀU KHIỂN AUTH SHEET & VẼ CANVAS SÓNG NHẠC GRADIENT NỀN
        // =========================================================================
        (function() {
            const canvas = document.getElementById('auth-waves-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            
            let w, h;
            let animationFrameId;
            let phase = 0;
            
            function resize() {
                w = canvas.width = canvas.offsetWidth;
                h = canvas.height = canvas.offsetHeight;
            }
            
            window.addEventListener('resize', resize);
            resize();
            
            function drawWaves() {
                ctx.clearRect(0, 0, w, h);
                
                // Cấu hình 3 đường sóng khác nhau (biên độ, tần số, tốc độ, màu sắc)
                const waves = [
                    { amplitude: 45, frequency: 0.004, speed: 0.015, color: 'rgba(139, 92, 246, 0.28)', glow: 'rgba(139, 92, 246, 0.45)' },
                    { amplitude: 30, frequency: 0.006, speed: -0.012, color: 'rgba(6, 182, 212, 0.22)', glow: 'rgba(6, 182, 212, 0.35)' },
                    { amplitude: 18, frequency: 0.009, speed: 0.02, color: 'rgba(59, 130, 246, 0.18)', glow: 'rgba(59, 130, 246, 0.3)' }
                ];
                
                phase += 0.06;
                
                waves.forEach(wave => {
                    ctx.save();
                    ctx.beginPath();
                    ctx.strokeStyle = wave.color;
                    ctx.lineWidth = 3.5;
                    ctx.shadowBlur = 20;
                    ctx.shadowColor = wave.glow;
                    
                    // Vẽ sóng hình sin
                    for (let x = 0; x < w; x++) {
                        const y = h / 2 + Math.sin(x * wave.frequency + phase * wave.speed) * wave.amplitude 
                                    + Math.cos(x * 0.0015 - phase * 0.008) * 12;
                        if (x === 0) {
                            ctx.moveTo(x, y);
                        } else {
                            ctx.lineTo(x, y);
                        }
                    }
                    ctx.stroke();
                    ctx.restore();
                });
                
                animationFrameId = requestAnimationFrame(drawWaves);
            }
            
            window.startAuthWaves = () => {
                resize();
                cancelAnimationFrame(animationFrameId);
                drawWaves();
            };
            
            window.stopAuthWaves = () => {
                cancelAnimationFrame(animationFrameId);
            };
        })();

        // Các hàm toàn cục điều khiển Auth Sheet trượt lên/xuống
        window.showAuthSheet = () => {
            const overlay = document.getElementById('page-auth-overlay');
            if (overlay) {
                overlay.style.display = 'flex';
                // Đọc offsetWidth để trình duyệt reflow, sau đó add class active
                overlay.offsetWidth;
                overlay.classList.add('active-sheet');
                document.body.style.overflow = 'hidden'; // Khóa cuộn trang chính
                if (window.startAuthWaves) {
                    window.startAuthWaves();
                }
            }
        };

        window.hideAuthSheet = () => {
            const overlay = document.getElementById('page-auth-overlay');
            if (overlay) {
                overlay.classList.remove('active-sheet');
                document.body.style.overflow = ''; // Mở lại cuộn trang chính
                if (window.stopAuthWaves) {
                    window.stopAuthWaves();
                }
                // Chờ hiệu ứng trượt kết thúc rồi ẩn hẳn
                setTimeout(() => {
                    if (!overlay.classList.contains('active-sheet')) {
                        overlay.style.display = 'none';
                    }
                }, 600);
            }
        };

        window.switchAuthTab = (tab) => {
            const wrapper = document.getElementById('auth-form-wrapper');
            const tabs = document.querySelectorAll('.auth-tab-btn');
            const title = document.getElementById('auth-card-title');
            const subtitle = document.getElementById('auth-card-subtitle');
            
            const paneLogin = document.getElementById('pane-login');
            const paneRegister = document.getElementById('pane-register');
            
            if (tab === 'login') {
                if (wrapper) wrapper.style.transform = 'translateX(0)';
                document.getElementById('btn-tab-login').classList.add('active');
                document.getElementById('btn-tab-register').classList.remove('active');
                if (title) title.innerHTML = '<i class="fas fa-user-circle text-primary me-2"></i>Đăng Nhập';
                if (subtitle) subtitle.textContent = 'Kết nối đam mê tại TTB Music.';
                
                if (paneLogin) paneLogin.classList.remove('inactive');
                if (paneRegister) paneRegister.classList.add('inactive');
            } else {
                if (wrapper) wrapper.style.transform = 'translateX(-50%)';
                document.getElementById('btn-tab-login').classList.remove('active');
                document.getElementById('btn-tab-register').classList.add('active');
                if (title) title.innerHTML = '<i class="fas fa-user-plus text-primary me-2"></i>Đăng Ký';
                if (subtitle) subtitle.textContent = 'Tạo tài khoản mới và bắt đầu trải nghiệm.';
                
                if (paneLogin) paneLogin.classList.add('inactive');
                if (paneRegister) paneRegister.classList.remove('inactive');
            }
        };

        // =========================================================================
        // AJAX XỬ LÝ ĐĂNG NHẬP & ĐĂNG KÝ (MORPH NAVBAR, KHÔNG LOAD LẠI TRANG)
        // =========================================================================
        const loginForm = document.getElementById('loginForm');
        const loginErrorAlert = document.getElementById('ajaxLoginError');
        
        const registerForm = document.getElementById('registerForm');
        const registerErrorAlert = document.getElementById('ajaxRegisterError');

        const updateNavbarUserControl = (user) => {
            const container = document.getElementById('navbar-user-control');
            if (container) {
                const esc = (str) => {
                    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
                };
                
                container.innerHTML = `
                    <div class="user-dropdown-wrapper nav-user-control-morph">
                        <a href="index.php?controller=profile&action=index" class="btn rounded-pill px-4 user-dropdown-btn">
                            <i class="fas fa-user-circle" style="font-size: 1.1rem;"></i> 
                            <span>${esc(user.full_name)}</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                        </a>
                        <div class="user-dropdown-menu glass-dropdown">
                            <div class="user-dropdown-header">
                                <div class="user-name">${esc(user.full_name)}</div>
                                <div class="user-email">${esc(user.email)}</div>
                            </div>
                            <hr class="dropdown-divider">
                            <a href="index.php?controller=profile&action=index" class="dropdown-item">
                                <i class="fas fa-history me-2"></i> Đơn mua hàng
                            </a>
                            <a href="index.php?controller=profile&action=index#rentals-pane" class="dropdown-item">
                                <i class="fas fa-calendar-alt me-2"></i> Hợp đồng thuê
                            </a>
                            <a href="index.php?controller=profile&action=index#password-pane" class="dropdown-item">
                                <i class="fas fa-key me-2"></i> Đổi mật khẩu
                            </a>
                            <hr class="dropdown-divider">
                            <a href="index.php?controller=auth&action=logout" class="dropdown-item logout-item" data-no-spa>
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                `;
            }
        };

        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (loginErrorAlert) {
                    loginErrorAlert.classList.add('d-none');
                }
                
                const submitBtn = loginForm.querySelector('button[type="submit"]');
                const originalBtnHTML = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
                
                const formData = new FormData(loginForm);
                fetch('index.php?controller=auth&action=loginSubmit&ajax=1', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHTML;
                    
                    if (data.success) {
                        // Ẩn sheet đăng nhập
                        window.hideAuthSheet();
                        
                        // Xóa dữ liệu form
                        loginForm.reset();
                        
                        // Cập nhật Navbar với morph transition
                        updateNavbarUserControl(data.user);
                        
                        // Điều hướng về Home nếu đang ở các trang phục vụ auth
                        const activePage = document.querySelector('.spa-page.active');
                        if (activePage && (activePage.id === 'page-auth' || window.location.href.includes('register'))) {
                            SPARouter.navigateTo('index.php?controller=home');
                        }
                    } else {
                        if (loginErrorAlert) {
                            loginErrorAlert.textContent = data.message || 'Đăng nhập thất bại!';
                            loginErrorAlert.classList.remove('d-none');
                        } else {
                            alert(data.message || 'Đăng nhập thất bại!');
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHTML;
                    if (loginErrorAlert) {
                        loginErrorAlert.textContent = 'Lỗi kết nối máy chủ!';
                        loginErrorAlert.classList.remove('d-none');
                    } else {
                        alert('Lỗi kết nối máy chủ!');
                    }
                });
            });
        }

        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (registerErrorAlert) {
                    registerErrorAlert.classList.add('d-none');
                }
                
                const submitBtn = registerForm.querySelector('button[type="submit"]');
                const originalBtnHTML = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
                
                const formData = new FormData(registerForm);
                fetch('index.php?controller=auth&action=registerSubmit&ajax=1', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHTML;
                    
                    if (data.success) {
                        // Ẩn sheet đăng ký
                        window.hideAuthSheet();
                        
                        // Xóa dữ liệu form
                        registerForm.reset();
                        
                        // Cập nhật Navbar với morph transition
                        updateNavbarUserControl(data.user);
                        
                        // Điều hướng về Home nếu đang ở các trang phục vụ auth
                        const activePage = document.querySelector('.spa-page.active');
                        if (activePage && (activePage.id === 'page-auth' || window.location.href.includes('register'))) {
                            SPARouter.navigateTo('index.php?controller=home');
                        }
                    } else {
                        if (registerErrorAlert) {
                            registerErrorAlert.textContent = data.message || 'Đăng ký thất bại!';
                            registerErrorAlert.classList.remove('d-none');
                        } else {
                            alert(data.message || 'Đăng ký thất bại!');
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHTML;
                    if (registerErrorAlert) {
                        registerErrorAlert.textContent = 'Lỗi kết nối máy chủ!';
                        registerErrorAlert.classList.remove('d-none');
                    } else {
                        alert('Lỗi kết nối máy chủ!');
                    }
                });
            });
        }

        // Xuất ra phạm vi toàn cục để tiện sử dụng ở các trang con
        window.navigateToSPA = (url) => SPARouter.navigateTo(url);
        window.hideCartOverlaySPA = () => SPARouter.hideCartOverlay();
    })();
    </script>
</body>
</html>