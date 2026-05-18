<!DOCTYPE html>
<html lang="vi" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root[data-theme="light"] { --bg-color: #f8fafc; --text-color: #0f172a; --card-bg: rgba(255, 255, 255, 0.85); --border-color: #e2e8f0; }
        :root[data-theme="dark"] { --bg-color: #0f172a; --text-color: #f8fafc; --card-bg: rgba(15, 23, 42, 0.85); --border-color: rgba(255, 255, 255, 0.1); }
        
        body {
            background-color: var(--bg-color); color: var(--text-color); font-family: 'Segoe UI', sans-serif;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden; transition: 0.4s ease;
        }

        .auth-container { width: 100%; max-width: 500px; padding: 20px; z-index: 1; }

        .animated-border-wrapper { position: relative; border-radius: 1.6rem; padding: 2px; width: 100%; }
        .animated-border-wrapper::before {
            content: ""; position: absolute; inset: 0; border-radius: 1.6rem;
            /* Đã thay đổi dải màu sang tông Xanh Ocean */
            background: linear-gradient(45deg, #00c6ff, #0072ff, #4facfe, #00c6ff);
            background-size: 300% 300%; animation: gradientBorderMove 6s linear infinite; z-index: -1;
        }
        @keyframes gradientBorderMove { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

        .glass-panel { background: var(--card-bg); backdrop-filter: blur(25px); border-radius: 1.5rem; position: relative; overflow: hidden; z-index: 1; width: 100%; }
        .form-watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); font-size: 15rem; font-weight: 900; color: var(--text-color); opacity: 0.03; z-index: 0; pointer-events: none; }
        .form-content { position: relative; z-index: 2; }

        .modern-input { background: rgba(128, 128, 128, 0.05) !important; border: 1px solid var(--border-color); color: var(--text-color) !important; border-radius: 0.75rem; transition: 0.3s ease; }
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
        .form-floating label { color: var(--text-color); opacity: 0.6; }
        .btn-glow { background: #3b82f6; border: none; transition: 0.3s; }
        .btn-glow:hover { background: #2563eb; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4); }
        
        .top-btn { color: var(--text-color); text-decoration: none; font-weight: bold; opacity: 0.7; transition: 0.3s; z-index: 10; }
        .top-btn:hover { opacity: 1; color: #3b82f6; }
        .back-btn:hover { transform: translateX(-5px); }

        #bg-elements { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; }
        .glow-orb { position: absolute; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%); animation: float 15s infinite ease-in-out alternate; }
        @keyframes float { 0% { transform: translateY(0px) scale(1); } 100% { transform: translateY(-50px) scale(1.2); } }

        /* Hiệu ứng hạt nền tương tự trang chủ */
        #global-parallax { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -3; pointer-events: none; overflow: hidden; }
        @keyframes organicFloat { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-30px); } }
        .note-wrapper { position: absolute; animation: organicFloat 10s ease-in-out infinite; }
        .note-icon { color: var(--text-color); opacity: 0.1; transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); }
    </style>
</head>
<body>
    <button id="theme-toggle" class="btn btn-outline-secondary rounded-circle position-absolute top-0 end-0 m-4 z-3"><i class="fas fa-moon"></i></button>
    
    <a href="index.php" class="position-absolute top-0 start-0 m-4 z-3 top-btn back-btn"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>

    <div id="bg-elements">
        <div class="glow-orb" style="width: 400px; height: 400px; top: -10%; left: -10%;"></div>
        <div class="glow-orb" style="width: 600px; height: 600px; bottom: -20%; right: -10%; animation-delay: -5s;"></div>
    </div>
    
    <div id="global-parallax"></div>

    <div class="auth-container">
        <div class="animated-border-wrapper">
            <div class="glass-panel p-5">
                <div class="form-watermark"><i class="fas fa-key"></i></div>
                <div class="form-content">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-key fs-3 text-dark"></i>
                        </div>
                        <h2 class="fw-bolder">Quên Mật Khẩu</h2>
                    </div>
                    <form action="index.php?controller=auth&action=forgotSubmit" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <div class="custom-floating mb-4">
                            <input type="email" class="form-control modern-input" id="email" name="email" placeholder=" " required>
                            <label for="email"><i class="fas fa-envelope me-2"></i>Email đã đăng ký</label>
                        </div>
                        <button type="submit" class="btn btn-glow btn-lg w-100 fw-bold rounded-pill text-white py-3">GỬI YÊU CẦU <i class="fas fa-paper-plane ms-2"></i></button>
                    </form>
                    <p class="text-center mt-4 mb-0 small"><a href="index.php" class="text-primary fw-bold text-decoration-none">Quay lại đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/partials/chat_and_scroll.php'; ?>

    <script>
        const themeBtn = document.getElementById('theme-toggle');
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
        themeBtn.querySelector('i').className = savedTheme === 'dark' ? 'fas fa-sun text-warning' : 'fas fa-moon text-dark';
        themeBtn.addEventListener('click', () => {
            const newTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            themeBtn.querySelector('i').className = newTheme === 'dark' ? 'fas fa-sun text-warning' : 'fas fa-moon text-dark';
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