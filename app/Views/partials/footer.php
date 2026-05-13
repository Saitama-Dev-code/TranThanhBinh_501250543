<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/partials/footer.php
 * MÔ TẢ: Chứa phần <footer>, Modal Đăng nhập Glassmorphism, gọi Component Chatbot và các JS dùng chung.
 * CÁCH SỬ DỤNG: Include vào cuối mỗi file View.
 * =========================================================================
 */
?>
    <footer class="mt-5 pt-5" style="background-color: var(--card-bg); border-top: 1px solid var(--border-color); padding: 60px 0 20px 0; position: relative; z-index: 10;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-3"><i class="fas fa-music text-primary me-2"></i>TTB MUSIC</h4>
                    <p class="text-muted" style="color: var(--text-color) !important; opacity: 0.8;">Hệ thống mua bán và cho thuê nhạc cụ hàng đầu, giúp bạn tự tin tỏa sáng và viết nên giai điệu của riêng mình.</p>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-4">
                    <h5 class="fw-bold mb-3">Danh mục</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php?controller=product&action=index" class="text-decoration-none" style="color: var(--text-color); opacity: 0.8;">Guitar & Bass</a></li>
                        <li class="mb-2"><a href="index.php?controller=product&action=index" class="text-decoration-none" style="color: var(--text-color); opacity: 0.8;">Piano & Organ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-3">Dịch vụ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-warning fw-bold text-decoration-none">Cho Thuê Nhạc Cụ</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none" style="color: var(--text-color); opacity: 0.8;">Bảo hành & Sửa chữa</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="fw-bold mb-3">Liên hệ</h5>
                    <ul class="list-unstyled" style="color: var(--text-color); opacity: 0.8;">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Quận 1, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i> 1900 1000</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: var(--border-color); opacity: 0.2;">
            <div class="text-center small" style="color: var(--text-color); opacity: 0.8;">
                &copy; 2024 TTB MUSIC. Dự án PHP MVC.
            </div>
        </div>
    </footer>

    <style>
        .animated-border-wrapper { position: relative; border-radius: 1.6rem; z-index: 1; padding: 2px; }
        .animated-border-wrapper::before { content: ""; position: absolute; inset: 0; border-radius: 1.6rem; background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899, #3b82f6); background-size: 300% 300%; animation: gradientBorderMove 6s linear infinite; z-index: -1; }
        @keyframes gradientBorderMove { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .glass-panel { background: var(--card-bg); backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px); border: 1px solid var(--border-color); border-radius: 1.5rem; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); position: relative; overflow: hidden; z-index: 1; }
        .form-watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); font-size: 12rem; font-weight: 900; color: var(--text-color); opacity: 0.03; z-index: 0; pointer-events: none; user-select: none; }
        .modal-body-content { position: relative; z-index: 2; }
        [data-theme="dark"] .glass-panel { box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4); }
        [data-theme="dark"] .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        .modern-input { background: rgba(128, 128, 128, 0.05) !important; border: 1px solid var(--border-color); color: var(--text-color) !important; border-radius: 0.75rem; transition: all 0.3s ease; }
        .modern-input:focus { background: rgba(128, 128, 128, 0.1) !important; border-color: #3b82f6; box-shadow: 0 0 15px rgba(59, 130, 246, 0.2); }
        .form-floating label { color: var(--text-color); opacity: 0.6; }
        .btn-glow { background: #3b82f6; border: none; transition: 0.3s; }
        .btn-glow:hover { background: #2563eb; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4); }
        .social-btn { background: rgba(128, 128, 128, 0.05); border: 1px solid var(--border-color); color: var(--text-color); transition: all 0.3s; }
        .social-btn:hover { background: rgba(128, 128, 128, 0.1); transform: translateY(-2px); }
        .social-btn.google:hover { color: #ea4335; border-color: #ea4335; }
        .social-btn.facebook:hover { color: #1877f2; border-color: #1877f2; }
    </style>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="animated-border-wrapper">
                    <div class="glass-panel p-4 border-0">
                        <div class="form-watermark"><i class="fas fa-music"></i></div>
                        <div class="modal-body-content">
                            <div class="modal-header border-0 pb-3 px-0 position-relative d-flex justify-content-center text-center">
                                <div>
                                    <h3 class="modal-title fw-bolder mb-1" style="color: var(--text-color);">
                                        <i class="fas fa-user-circle text-primary me-2"></i>Đăng Nhập
                                    </h3>
                                    <p class="small mb-0" style="color: var(--text-color); opacity: 0.7;">Viết tiếp giai điệu của bạn tại TTB Music.</p>
                                </div>
                                <button type="button" class="btn-close position-absolute top-0 end-0 mt-1" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body px-0 pb-0 pt-2">
                                <form action="index.php?controller=auth&action=login" method="POST">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control modern-input" id="floatingEmail" name="email" placeholder="name@example.com" required>
                                        <label for="floatingEmail"><i class="fas fa-envelope me-2"></i>Email của bạn</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control modern-input" id="floatingPassword" name="password" placeholder="Password" required>
                                        <label for="floatingPassword"><i class="fas fa-lock me-2"></i>Mật khẩu</label>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label small" for="rememberMe" style="color: var(--text-color); opacity: 0.8;">Nhớ tài khoản</label>
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
                                    <button class="btn social-btn google w-50 rounded-pill py-2 fw-semibold"><i class="fab fa-google me-2"></i> Google</button>
                                    <button class="btn social-btn facebook w-50 rounded-pill py-2 fw-semibold"><i class="fab fa-facebook-f me-2"></i> Facebook</button>
                                </div>
                                <div class="mt-4 pt-3 text-center">
                                    <p class="mb-0 small" style="color: var(--text-color);">Chưa có tài khoản? <a href="index.php?controller=auth&action=register" class="text-primary text-decoration-none fw-bolder fs-6">Tạo ngay</a></p>
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

        let prevScrollpos = window.pageYOffset;
        const navbar = document.getElementById("smartNavbar");
        if(navbar) {
            window.onscroll = function() {
                let currentScrollPos = window.pageYOffset;
                if (currentScrollPos <= 50) {
                    navbar.style.top = "0"; navbar.style.boxShadow = "none";
                } else {
                    navbar.style.boxShadow = "0 4px 15px rgba(0,0,0,0.1)";
                    if (prevScrollpos > currentScrollPos) { navbar.style.top = "0"; } 
                    else { navbar.style.top = "-100px"; }
                }
                prevScrollpos = currentScrollPos;
            }
        }

        const themeToggleBtn = document.getElementById('theme-toggle');
        if(themeToggleBtn) {
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
        }

        const parallaxContainer = document.getElementById('global-parallax');
        if(parallaxContainer) {
            const fontIcons = ['fa-music', 'fa-guitar', 'fa-headphones', 'fa-drum', 'fa-play'];
            const notes = [];
            let mouseX = -1000, mouseY = -1000;

            for (let i = 0; i < 50; i++) {
                let wrapper = document.createElement('div');
                wrapper.className = 'note-wrapper';
                wrapper.style.left = Math.random() * 100 + 'vw';
                wrapper.style.top = Math.random() * 100 + 'vh';
                wrapper.style.animationDelay = (Math.random() * 10) + 's';

                let iconElem = document.createElement('i');
                let randomIcon = fontIcons[Math.floor(Math.random() * fontIcons.length)];
                iconElem.className = `fas ${randomIcon} note-icon`;
                iconElem.style.fontSize = (Math.random() * 1.5 + 0.5) + 'rem';

                wrapper.appendChild(iconElem);
                parallaxContainer.appendChild(wrapper);

                notes.push({ wrapper: wrapper, icon: iconElem, currentX: 0, currentY: 0 });
            }

            window.addEventListener('mousemove', (e) => { mouseX = e.clientX; mouseY = e.clientY; });

            function animateRepel() {
                notes.forEach(note => {
                    let rect = note.wrapper.getBoundingClientRect();
                    let iconCenterX = rect.left + rect.width / 2;
                    let iconCenterY = rect.top + rect.height / 2;

                    let dx = iconCenterX - mouseX;
                    let dy = iconCenterY - mouseY;
                    let distance = Math.sqrt(dx * dx + dy * dy);

                    const repelRadius = 150; 
                    if (distance < repelRadius) {
                        let force = (repelRadius - distance) / repelRadius;
                        let angle = Math.atan2(dy, dx);
                        let pushX = Math.cos(angle) * force * 60;
                        let pushY = Math.sin(angle) * force * 60;
                        note.icon.style.transition = 'none';
                        note.icon.style.transform = `translate(${pushX}px, ${pushY}px)`;
                    } else {
                        note.icon.style.transition = 'transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1)';
                        note.icon.style.transform = `translate(0px, 0px)`;
                    }
                });
                requestAnimationFrame(animateRepel);
            }
            animateRepel();
        }
    </script>
</body>
</html>