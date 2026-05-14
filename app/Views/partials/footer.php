<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/partials/footer.php
 * MÔ TẢ: Fix hiệu ứng Hover Social Icons, Link trượt và khôi phục nội dung Modal.
 * =========================================================================
 */
?>
    </div> 

    <footer class="mt-5 pt-5" style="background-color: var(--card-bg); border-top: 1px solid var(--border-color); padding: 60px 0 20px 0; position: relative; z-index: 10;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up">
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

                <div class="col-lg-2 offset-lg-1 col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="fw-bold mb-3" style="color: var(--text-color);">Cửa hàng</h5>
                    <ul class="list-unstyled footer-link-list">
                        <li><a href="index.php?controller=product">Guitar & Bass</a></li>
                        <li><a href="index.php?controller=product">Piano & Organ</a></li>
                        <li><a href="index.php?controller=product">Trống & Bộ gõ</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="fw-bold mb-3" style="color: var(--text-color);">Dịch vụ</h5>
                    <ul class="list-unstyled footer-link-list">
                        <li><a href="#" class="text-warning fw-bold">Cho Thuê Nhạc Cụ</a></li>
                        <li><a href="#">Bảo hành tận nơi</a></li>
                        <li><a href="#">Học viện TTB</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
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
    </style>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="animated-border-wrapper">
                    <div class="glass-panel p-4">
                        <div class="form-watermark">TTB</div>
                        <div class="modal-body-content">
                            <div class="modal-header border-0 pb-3 px-0 position-relative d-flex justify-content-center text-center">
                                <div>
                                    <h3 class="modal-title fw-bolder mb-1" style="color: var(--text-color);">
                                        <i class="fas fa-user-circle text-primary me-2"></i>Đăng Nhập
                                    </h3>
                                    <p class="small mb-0" style="color: var(--text-color); opacity: 0.7;">Kết nối đam mê tại TTB Music.</p>
                                </div>
                                <button type="button" class="btn-close position-absolute top-0 end-0 mt-1" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body px-0">
                                <form action="index.php?controller=auth&action=login" method="POST">
                                    <div class="custom-floating mb-4">
                                        <input type="email" class="form-control modern-input" id="logEmail" name="email" placeholder=" " required>
                                        <label for="logEmail">Email của bạn</label>
                                    </div>
                                    <div class="custom-floating mb-4">
                                        <input type="password" class="form-control modern-input" id="logPass" name="password" placeholder=" " required>
                                        <label for="logPass">Mật khẩu</label>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remMe">
                                            <label class="form-check-label small" for="remMe" style="color: var(--text-color); opacity: 0.8;">Nhớ mật khẩu</label>
                                        </div>
                                        <a href="index.php?controller=auth&action=forgot" class="text-primary text-decoration-none small fw-bold">Quên mật khẩu?</a>
                                    </div>

                                    <button type="submit" class="btn btn-glow btn-lg w-100 fw-bold rounded-pill text-white py-3">ĐĂNG NHẬP <i class="fas fa-sign-in-alt ms-2"></i></button>
                                </form>

                                <div class="position-relative my-4 text-center">
                                    <hr style="border-color: var(--border-color); opacity: 0.5;">
                                    <span class="position-absolute top-50 start-50 translate-middle px-3 small fw-semibold" style="background-color: var(--card-bg); color: var(--text-color); opacity: 0.6;">Hoặc tiếp tục với</span>
                                </div>
                                
                                <div class="d-flex gap-3">
                                    <button class="btn social-btn w-50 rounded-pill py-2 fw-semibold"><i class="fab fa-google me-2 text-danger"></i> Google</button>
                                    <button class="btn social-btn w-50 rounded-pill py-2 fw-semibold"><i class="fab fa-facebook-f me-2 text-primary"></i> Facebook</button>
                                </div>

                                <div class="text-center mt-4 mb-2">
                                    <span class="small" style="color: var(--text-color); opacity: 0.8;">Chưa có tài khoản?</span>
                                    <a href="index.php?controller=auth&action=register" class="text-primary text-decoration-none small fw-bold ms-1">Tạo ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/chat_and_scroll.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        AOS.init({ once: true, offset: 100 });

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

        // Smart Navbar
        let prevS = window.pageYOffset;
        const nav = document.getElementById("smartNavbar");
        window.addEventListener('scroll', () => {
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
</body>
</html>