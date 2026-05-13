<!DOCTYPE html>
<html lang="vi" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* ================= BIẾN MÀU SẮC ĐỒNG BỘ THEME ================= */
        :root[data-theme="light"] {
            --bg-color: #f8fafc;
            --text-color: #0f172a;
            --card-bg: rgba(255, 255, 255, 0.85);
            --border-color: #e2e8f0;
        }

        :root[data-theme="dark"] {
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --card-bg: rgba(15, 23, 42, 0.85);
            --border-color: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--bg-color); color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden; transition: background-color 0.4s ease, color 0.4s ease;
        }

        /* ================= NỀN PARALLAX ORB ================= */
        #bg-elements { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; }
        .glow-orb {
            position: absolute; border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
            animation: float 15s infinite ease-in-out alternate;
        }
        @keyframes float { 0% { transform: translateY(0px) scale(1); } 100% { transform: translateY(-50px) scale(1.2); } }

        /* ================= FORM GLASSMORPHISM & ANIMATED BORDER ================= */
        .register-container { width: 100%; max-width: 500px; padding: 20px; z-index: 1; }

        .animated-border-modal {
            position: relative; background: transparent; border: none; border-radius: 1.2rem; z-index: 1;
        }
        .animated-border-modal::before {
            content: ""; position: absolute; inset: -2px; border-radius: 1.25rem;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899, #3b82f6);
            background-size: 300% 300%; animation: gradientBorderMove 6s linear infinite; z-index: -2;
        }
        @keyframes gradientBorderMove { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

        .modal-inner-glass {
            background: var(--card-bg); backdrop-filter: blur(20px); border-radius: 1.2rem;
            position: relative; overflow: hidden; z-index: -1; height: 100%; width: 100%;
        }

        /* ================= CÁC THÀNH PHẦN BÊN TRONG ================= */
        .modern-input {
            background: rgba(128, 128, 128, 0.05) !important; border: 1px solid var(--border-color);
            color: var(--text-color) !important; border-radius: 0.75rem; transition: all 0.3s ease;
        }
        .modern-input:focus { border-color: #3b82f6; box-shadow: 0 0 15px rgba(59, 130, 246, 0.3); }
        .form-floating label { color: var(--text-color); opacity: 0.6; }

        .btn-glow { background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; transition: 0.3s; }
        .btn-glow:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(139, 92, 246, 0.5); }
        
        .top-btn {
            color: var(--text-color); text-decoration: none; font-weight: bold; opacity: 0.7; transition: 0.3s; z-index: 10;
        }
        .top-btn:hover { opacity: 1; color: #3b82f6; }
        .back-btn:hover { transform: translateX(-5px); }
    </style>
</head>
<body>

    <div id="bg-elements">
        <div class="glow-orb" style="width: 400px; height: 400px; top: -10%; left: -10%;"></div>
        <div class="glow-orb" style="width: 600px; height: 600px; bottom: -20%; right: -10%; animation-delay: -5s;"></div>
    </div>

    <a href="index.php" class="position-absolute top-0 start-0 m-4 top-btn back-btn"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
    <button id="theme-toggle" class="btn btn-outline-secondary rounded-circle position-absolute top-0 end-0 m-4 z-3">
        <i class="fas fa-moon"></i>
    </button>

    <div class="register-container">
        <div class="animated-border-modal p-0">
            <div class="modal-inner-glass p-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-key fs-3 text-dark"></i>
                    </div>
                    <h2 class="fw-bolder">Quên Mật Khẩu</h2>
                    <p class="small" style="opacity: 0.7;">Nhập email của bạn, hệ thống sẽ gửi liên kết để đặt lại mật khẩu mới.</p>
                </div>

                <form action="#" method="POST">
                    <div class="form-floating mb-4">
                        <input type="email" class="form-control modern-input" id="email" name="email" placeholder="Email" required>
                        <label for="email"><i class="fas fa-envelope me-2"></i>Email đã đăng ký</label>
                    </div>

                    <button type="submit" class="btn btn-glow btn-lg w-100 fw-bold rounded-pill text-white py-3">
                        GỬI YÊU CẦU <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>