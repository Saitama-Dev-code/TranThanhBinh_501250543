<!DOCTYPE html>
<html lang="vi" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root[data-theme="dark"] {
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --card-bg: rgba(30, 41, 59, 0.85);
            --border-color: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--bg-color); color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }

        /* Nền không gian Parallax */
        #bg-elements { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; }
        .glow-orb {
            position: absolute; border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, transparent 70%);
            animation: float 15s infinite ease-in-out alternate;
        }
        @keyframes float { 0% { transform: translateY(0px) scale(1); } 100% { transform: translateY(-50px) scale(1.2); } }

        /* Form Glassmorphism */
        .register-container { width: 100%; max-width: 500px; padding: 20px; z-index: 1; }

        .glass-panel {
            background: var(--card-bg); backdrop-filter: blur(20px);
            border: 1px solid var(--border-color); border-radius: 1.5rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3); position: relative;
        }

        .glass-panel::before {
            content: ""; position: absolute; top: 0; left: 10%; width: 80%; height: 1px;
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
        }

        .modern-input {
            background: rgba(255, 255, 255, 0.05) !important; border: 1px solid var(--border-color);
            color: var(--text-color) !important; border-radius: 0.75rem;
        }
        .modern-input:focus { border-color: #3b82f6; box-shadow: 0 0 15px rgba(59, 130, 246, 0.3); }
        .form-floating label { color: var(--text-color); opacity: 0.6; }

        .btn-glow { background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; transition: 0.3s; }
        .btn-glow:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(139, 92, 246, 0.5); }
        
        .back-btn {
            position: absolute; top: 20px; left: 20px; color: var(--text-color);
            text-decoration: none; font-weight: bold; opacity: 0.7; transition: 0.3s;
        }
        .back-btn:hover { opacity: 1; color: #3b82f6; transform: translateX(-5px); }
    </style>
</head>
<body>

    <div id="bg-elements">
        <div class="glow-orb" style="width: 400px; height: 400px; top: -10%; left: -10%;"></div>
        <div class="glow-orb" style="width: 600px; height: 600px; bottom: -20%; right: -10%; animation-delay: -5s;"></div>
    </div>

    <a href="index.php" class="back-btn"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>

    <div class="register-container">
        <div class="glass-panel p-5">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-warning rounded-circle mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-key fs-3 text-dark"></i>
                </div>
                <h2 class="fw-bolder">Quên Mật Khẩu</h2>
                <p class="text-muted small">Nhập email của bạn, hệ thống sẽ gửi liên kết để đặt lại mật khẩu mới.</p>
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

</body>
</html>