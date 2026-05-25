<?php
// Đường dẫn file: app/Views/profile.php
require_once ROOT_PATH . '/app/Views/partials/header.php';
?>

<style>
    /* Styling trang Profile đồng nhất với nhận diện thương hiệu TTB Music */
    .profile-wrapper {
        position: relative;
        min-height: 100vh;
        width: 100%;
        padding-top: 120px;
        padding-bottom: 80px;
        z-index: 2;
    }

    .profile-container-inner {
        position: relative;
        z-index: 3;
    }

    .avatar-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 3rem;
        font-weight: bold;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        border: 3px solid rgba(255, 255, 255, 0.2);
    }

    .info-group {
        margin-bottom: 15px;
    }

    .info-label {
        font-size: 0.82rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .info-value {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-color);
        background: rgba(128, 128, 128, 0.05);
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
    }

    .logout-btn {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 50px;
        padding: 12px 20px;
        font-weight: 700;
        width: 100%;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: #ef4444;
        color: white;
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        transform: translateY(-2px);
    }

    /* Bảng lịch sử đơn hàng */
    .table-orders {
        width: 100%;
        color: var(--text-color);
    }

    .table-orders th {
        color: var(--text-muted);
        font-weight: 700;
        border-bottom: 2px solid var(--border-color);
        padding: 12px;
        font-size: 0.9rem;
    }

    .table-orders td {
        padding: 15px 12px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .status-pending { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .status-shipping { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .status-completed { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .status-canceled { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
    .status-active { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .status-returned { background: rgba(16, 185, 129, 0.15); color: #10b981; }

    .empty-orders {
        text-align: center;
        padding: 40px;
        color: var(--text-muted);
    }
    
    .empty-orders i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: var(--border-color);
    }

    /* Tabs styling trong Profile Card */
    .profile-glass-card .nav-tabs {
        border-bottom: 1px solid var(--border-color) !important;
        gap: 8px;
    }
    
    .profile-glass-card .nav-link {
        color: var(--text-muted);
        border: none !important;
        border-radius: 12px 12px 0 0;
        background: transparent;
        font-weight: 700;
        padding: 12px 18px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .profile-glass-card .nav-link:hover {
        color: var(--text-color);
        background: rgba(255, 255, 255, 0.04);
    }
    
    .profile-glass-card .nav-link.active {
        color: #3b82f6 !important;
        background: rgba(59, 130, 246, 0.1) !important;
        border-bottom: 3px solid #3b82f6 !important;
    }

    /* CSS cho nút quay lại ở trang profile */
    .profile-back-btn {
        background: rgba(128, 128, 128, 0.06);
        border: 1px solid var(--border-color);
        color: var(--text-color);
        width: 100%;
        padding: 12px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .profile-back-btn:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.4);
        color: #3b82f6;
        transform: translateY(-2px);
    }

    /* Giao diện input nhập liệu hiện đại */
    .profile-glass-card .modern-input {
        background: rgba(128, 128, 128, 0.05) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-color) !important;
        border-radius: 12px !important;
        padding: 12px 15px !important;
        transition: all 0.3s ease;
    }
    
    .profile-glass-card .modern-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important;
    }
</style>

<div class="profile-wrapper">
    <!-- Canvas hoạt ảnh riêng biệt vẽ các bong bóng phát sáng bay chậm rãi -->
    <canvas id="profile-bg-canvas"></canvas>

    <div class="container profile-container-inner">
        <div class="row g-4">
            
            <!-- Cột trái: Thông tin cá nhân cơ bản -->
            <div class="col-lg-4">
                <div class="profile-glass-card p-4 text-center text-lg-start">
                    <div class="text-center mb-4">
                        <!-- Lấy chữ cái đầu của tên làm Avatar -->
                        <div class="avatar-wrapper" id="profile-avatar">
                            <?= strtoupper(substr($user['full_name'] ?? 'U', 0, 1)) ?>
                        </div>
                        <h4 class="fw-bold mb-1" id="profile-display-name" style="color: var(--text-color);"><?= htmlspecialchars($user['full_name']) ?></h4>
                        <p class="text-muted mb-3" style="font-size: 0.9rem;"><?= htmlspecialchars($user['email']) ?></p>
                        <span class="badge bg-primary px-3 py-2 rounded-pill small">
                            <i class="fas fa-crown me-1 text-warning"></i> <?= ($user['role'] == 1) ? 'Quản trị viên' : 'Thành viên TTB' ?>
                        </span>
                    </div>

                    <div class="info-group">
                        <div class="info-label"><i class="fas fa-phone me-1"></i> Số điện thoại</div>
                        <div class="info-value" id="profile-display-phone">
                            <?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : '<span class="text-muted">Chưa cập nhật</span>' ?>
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-label"><i class="fas fa-map-marker-alt me-1"></i> Địa chỉ nhận hàng</div>
                        <div class="info-value" id="profile-display-address">
                            <?= !empty($user['address']) ? htmlspecialchars($user['address']) : '<span class="text-muted">Chưa cập nhật</span>' ?>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <a href="index.php?controller=auth&action=logout" class="btn logout-btn">
                            <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất tài khoản
                        </a>
                    </div>

                    <!-- Nút Quay lại trang trước nổi bật dưới card -->
                    <div class="mt-3">
                        <button type="button" class="profile-back-btn" onclick="if(window.hideProfileSheet) { window.hideProfileSheet(); } else { window.history.back(); }">
                            <i class="fas fa-arrow-left"></i> Quay lại trang trước
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Các Tab Lịch sử mua hàng, thuê nhạc cụ, cập nhật thông tin và đổi mật khẩu -->
            <div class="col-lg-8">
                <div class="profile-glass-card p-4">
                    <ul class="nav nav-tabs border-0 mb-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders-pane" type="button" role="tab" aria-controls="orders-pane" aria-selected="true">
                                <i class="fas fa-history me-2"></i>Lịch sử mua
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rentals-tab" data-bs-toggle="tab" data-bs-target="#rentals-pane" type="button" role="tab" aria-controls="rentals-pane" aria-selected="false">
                                <i class="fas fa-calendar-alt me-2"></i>Hợp đồng thuê
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-pane" type="button" role="tab" aria-controls="info-pane" aria-selected="false">
                                <i class="fas fa-user-edit me-2"></i>Cập nhật thông tin
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-pane" type="button" role="tab" aria-controls="password-pane" aria-selected="false">
                                <i class="fas fa-key me-2"></i>Đổi mật khẩu
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="profileTabsContent">
                        
                        <!-- TAB 1: Lịch sử mua hàng -->
                        <div class="tab-pane fade show active" id="orders-pane" role="tabpanel" aria-labelledby="orders-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table-orders">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn</th>
                                            <th>Ngày đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($orders)): ?>
                                            <tr>
                                                <td colspan="4">
                                                    <div class="empty-orders">
                                                        <i class="fas fa-box-open"></i>
                                                        <h5>Chưa có đơn hàng nào</h5>
                                                        <p class="small text-muted">Bạn chưa đặt mua sản phẩm nào từ TTB Music.</p>
                                                        <a href="index.php?controller=product&action=index" class="btn btn-outline-primary rounded-pill mt-2 px-4">Khám phá ngay</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td class="fw-bold">#TTB<?= $order['id'] ?></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                                    <td class="fw-bold" style="color: #3b82f6;">
                                                        <?= number_format($order['total_price'], 0, ',', '.') ?> ₫
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $statusClass = 'status-pending';
                                                            $statusText = 'Đang xử lý';
                                                            if ($order['status'] == 'shipping') {
                                                                $statusClass = 'status-shipping'; $statusText = 'Đang giao';
                                                            } elseif ($order['status'] == 'completed') {
                                                                $statusClass = 'status-completed'; $statusText = 'Hoàn thành';
                                                            } elseif ($order['status'] == 'canceled') {
                                                                $statusClass = 'status-canceled'; $statusText = 'Đã hủy';
                                                            }
                                                        ?>
                                                        <span class="badge-status <?= $statusClass ?>"><?= $statusText ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- TAB 2: Hợp đồng thuê nhạc cụ -->
                        <div class="tab-pane fade" id="rentals-pane" role="tabpanel" aria-labelledby="rentals-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table-orders">
                                    <thead>
                                        <tr>
                                            <th>Mã HĐ</th>
                                            <th>Nhạc cụ</th>
                                            <th>Thời hạn</th>
                                            <th>Tổng phí</th>
                                            <th>Cọc</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($rentals)): ?>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="empty-orders">
                                                        <i class="fas fa-calendar-times"></i>
                                                        <h5>Chưa có hợp đồng thuê nào</h5>
                                                        <p class="small text-muted">Bạn chưa thực hiện thuê nhạc cụ nào tại TTB Music.</p>
                                                        <a href="index.php?controller=product&action=index" class="btn btn-outline-primary rounded-pill mt-2 px-4">Thuê ngay sản phẩm</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($rentals as $rental): ?>
                                                <tr>
                                                    <td class="fw-bold">#R-<?= $rental['id'] ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <img src="<?= htmlspecialchars($rental['product_image']) ?>" alt="<?= htmlspecialchars($rental['product_name']) ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-color);">
                                                            <span class="small fw-semibold text-truncate" style="max-width: 120px;" title="<?= htmlspecialchars($rental['product_name']) ?>">
                                                                <?= htmlspecialchars($rental['product_name']) ?>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="small" style="font-size:0.78rem;">
                                                            <div>Từ: <span class="fw-bold"><?= date('d/m/Y', strtotime($rental['start_date'])) ?></span></div>
                                                            <div>Đến: <span class="fw-bold"><?= date('d/m/Y', strtotime($rental['end_date'])) ?></span></div>
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold" style="color: #3b82f6;">
                                                        <?= number_format($rental['total_rent_fee'], 0, ',', '.') ?> ₫
                                                    </td>
                                                    <td class="fw-bold text-warning">
                                                        <?= number_format($rental['deposit_amount'], 0, ',', '.') ?> ₫
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $statusClass = 'status-pending';
                                                            $statusText = 'Chờ duyệt';
                                                            if ($rental['status'] == 'active') {
                                                                $statusClass = 'status-active'; $statusText = 'Đang thuê';
                                                            } elseif ($rental['status'] == 'returned') {
                                                                $statusClass = 'status-returned'; $statusText = 'Đã trả';
                                                            } elseif ($rental['status'] == 'canceled') {
                                                                $statusClass = 'status-canceled'; $statusText = 'Đã hủy';
                                                            }
                                                        ?>
                                                        <span class="badge-status <?= $statusClass ?>"><?= $statusText ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- TAB 3: Cập nhật thông tin cá nhân (Họ tên, SĐT, Địa chỉ) qua AJAX -->
                        <div class="tab-pane fade" id="info-pane" role="tabpanel" aria-labelledby="info-tab" tabindex="0">
                            <div class="p-3" style="max-width: 550px; margin: 0 auto;">
                                <h4 class="fw-bold mb-4 text-primary" style="font-family: 'Outfit', sans-serif;">
                                    <i class="fas fa-user-edit me-2"></i>Thay đổi thông tin liên hệ
                                </h4>
                                
                                <form id="updateInfoForm">
                                    <div class="mb-3">
                                        <label for="infoFullName" class="form-label fw-semibold" style="font-size:0.9rem; color: var(--text-color);">Họ và tên</label>
                                        <input type="text" class="form-control modern-input" id="infoFullName" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="infoPhone" class="form-label fw-semibold" style="font-size:0.9rem; color: var(--text-color);">Số điện thoại</label>
                                        <input type="text" class="form-control modern-input" id="infoPhone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Nhập số điện thoại nhận hàng...">
                                    </div>
                                    <div class="mb-4">
                                        <label for="infoAddress" class="form-label fw-semibold" style="font-size:0.9rem; color: var(--text-color);">Địa chỉ nhận hàng</label>
                                        <textarea class="form-control modern-input" id="infoAddress" name="address" rows="3" placeholder="Nhập địa chỉ chi tiết (Số nhà, đường, phường/xã, quận/huyện...)..."><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                                    </div>
                                    
                                    <div class="alert alert-danger d-none" id="infoErrorAlert"></div>
                                    <div class="alert alert-success d-none" id="infoSuccessAlert"></div>
                                    
                                    <button type="submit" class="btn btn-glow w-100 fw-bold rounded-pill text-white py-3" id="btnSubmitInfo">
                                        LƯU THAY ĐỔI <i class="fas fa-save ms-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- TAB 4: Đổi mật khẩu qua AJAX -->
                        <div class="tab-pane fade" id="password-pane" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                            <div class="p-3" style="max-width: 500px; margin: 0 auto;">
                                <h4 class="fw-bold mb-4 text-primary" style="font-family: 'Outfit', sans-serif;"><i class="fas fa-lock me-2"></i>Thay đổi mật khẩu</h4>
                                
                                <form id="changePasswordForm">
                                    <div class="custom-floating mb-3">
                                        <input type="password" class="form-control modern-input" id="oldPassword" name="old_password" placeholder=" " required>
                                        <label for="oldPassword">Mật khẩu hiện tại</label>
                                    </div>
                                    <div class="custom-floating mb-3">
                                        <input type="password" class="form-control modern-input" id="newPassword" name="new_password" placeholder=" " required>
                                        <label for="newPassword">Mật khẩu mới (tối thiểu 6 ký tự)</label>
                                    </div>
                                    <div class="custom-floating mb-4">
                                        <input type="password" class="form-control modern-input" id="confirmPassword" name="confirm_password" placeholder=" " required>
                                        <label for="confirmPassword">Xác nhận mật khẩu mới</label>
                                    </div>
                                    
                                    <div class="alert alert-danger d-none" id="passwordErrorAlert"></div>
                                    <div class="alert alert-success d-none" id="passwordSuccessAlert"></div>
                                    
                                    <button type="submit" class="btn btn-glow w-100 fw-bold rounded-pill text-white py-3" id="btnSubmitPassword">
                                        CẬP NHẬT MẬT KHẨU <i class="fas fa-save ms-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
// Logic khởi chạy Canvas nền Glowing Ripple Bubbles và AJAX
(function() {
    let animId;
    
    // Đảm bảo không bị lặp lại khởi tạo
    window.startProfileBubbles = () => {
        const canvas = document.getElementById('profile-bg-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        
        let w, h;
        let bubbles = [];
        
        function resize() {
            w = canvas.width = canvas.offsetWidth;
            h = canvas.height = canvas.offsetHeight;
        }
        
        window.addEventListener('resize', resize);
        resize();
        
        // Cấu hình vật lý bong bóng
        class Bubble {
            constructor() {
                this.x = Math.random() * w;
                this.y = Math.random() * h;
                this.r = Math.random() * 45 + 15;
                this.vx = (Math.random() - 0.5) * 0.8;
                this.vy = (Math.random() - 0.5) * 0.8;
                
                // Chọn một dải màu từ xanh ngọc sang tím hồng phát sáng
                const colors = [
                    { r: 6, g: 182, b: 212, a: 0.15 },  // Xanh Cyan
                    { r: 139, g: 92, b: 246, a: 0.18 }, // Tím Violet
                    { r: 59, g: 130, b: 246, a: 0.16 }, // Xanh dương
                    { r: 236, g: 72, b: 153, a: 0.12 }  // Hồng Neon
                ];
                this.color = colors[Math.floor(Math.random() * colors.length)];
                this.pulseSpeed = Math.random() * 0.02 + 0.005;
                this.pulsePhase = Math.random() * Math.PI;
                this.scale = 1;
            }
            
            update(mx, my, mRad) {
                this.x += this.vx;
                this.y += this.vy;
                this.pulsePhase += this.pulseSpeed;
                
                // Biên độ nở bong bóng
                this.scale = 1 + Math.sin(this.pulsePhase) * 0.12;
                
                // Giới hạn va chạm biên màn hình để dội lại nhẹ nhàng
                if (this.x < -this.r) this.x = w + this.r;
                if (this.x > w + this.r) this.x = -this.r;
                if (this.y < -this.r) this.y = h + this.r;
                if (this.y > h + this.r) this.y = -this.r;
                
                // Tương tác đẩy ra xa khỏi chuột
                if (mx !== null && my !== null) {
                    let dx = this.x - mx;
                    let dy = this.y - my;
                    let dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < mRad) {
                        let force = (mRad - dist) / mRad;
                        let angle = Math.atan2(dy, dx);
                        
                        // Nảy nhẹ ra xa chuột
                        this.x += Math.cos(angle) * force * 4;
                        this.y += Math.sin(angle) * force * 4;
                        this.scale = 1.35 * (1 + force * 0.2); // Tăng kích thước phát sáng
                    }
                }
            }
            
            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                
                // Tạo Gradient Radial phát sáng hào quang (Ripple)
                let grad = ctx.createRadialGradient(0, 0, 0, 0, 0, this.r * this.scale);
                
                const c = this.color;
                grad.addColorStop(0, `rgba(${c.r}, ${c.g}, ${c.b}, ${c.a * 1.5})`);
                grad.addColorStop(0.5, `rgba(${c.r}, ${c.g}, ${c.b}, ${c.a * 0.6})`);
                grad.addColorStop(1, 'rgba(0, 0, 0, 0)');
                
                ctx.fillStyle = grad;
                ctx.beginPath();
                ctx.arc(0, 0, this.r * this.scale, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            }
        }
        
        // Khởi tạo các bong bóng
        bubbles = [];
        const count = Math.min(25, Math.floor((w * h) / 32000));
        for (let i = 0; i < count; i++) {
            bubbles.push(new Bubble());
        }
        
        // Tọa độ chuột
        let mouseX = null, mouseY = null;
        const mouseRadius = 140;
        
        const profilePage = document.getElementById('page-profile');
        if (profilePage) {
            profilePage.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                // Phải bù trừ vị trí tương đối so với canvas
                mouseX = e.clientX - rect.left;
                mouseY = e.clientY - rect.top;
            });
            profilePage.addEventListener('mouseleave', () => {
                mouseX = null;
                mouseY = null;
            });
        }
        
        function tick() {
            ctx.clearRect(0, 0, w, h);
            
            // Vẽ các hạt bong bóng
            bubbles.forEach(b => {
                b.update(mouseX, mouseY, mouseRadius);
                b.draw();
            });
            
            animId = requestAnimationFrame(tick);
        }
        
        cancelAnimationFrame(animId);
        tick();
    };
    
    window.stopProfileBubbles = () => {
        cancelAnimationFrame(animId);
    };
})();

// Xử lý các Form AJAX khi tải trang
document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.initProfilePage === 'function') {
        window.initProfilePage();
    }
});

window.initProfilePage = function() {
    // 1. Đồng bộ tab hash
    const hash = window.location.hash;
    if (hash) {
        const tabEl = document.querySelector(`button[data-bs-target="${hash}"]`);
        if (tabEl) {
            const tab = new bootstrap.Tab(tabEl);
            tab.show();
        }
    }

    // 2. Chạy Canvas nền bong bóng
    if (window.startProfileBubbles) {
        window.startProfileBubbles();
    }

    // 3. AJAX Cập nhật thông tin cá nhân
    const infoForm = document.getElementById('updateInfoForm');
    if (infoForm) {
        if (infoForm.dataset.listenerAttached) return;
        infoForm.dataset.listenerAttached = 'true';

        infoForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const submitBtn = document.getElementById('btnSubmitInfo');
            const errorAlert = document.getElementById('infoErrorAlert');
            const successAlert = document.getElementById('infoSuccessAlert');

            errorAlert.classList.add('d-none');
            successAlert.classList.add('d-none');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...';

            const formData = new FormData(infoForm);
            
            fetch('index.php?controller=profile&action=updateInfo', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'LƯU THAY ĐỔI <i class="fas fa-save ms-2"></i>';
                
                if (data.success) {
                    successAlert.textContent = data.message;
                    successAlert.classList.remove('d-none');
                    
                    // Cập nhật lại UI thông tin hiển thị tại cột trái
                    const nameDisp = document.getElementById('profile-display-name');
                    if (nameDisp) nameDisp.textContent = data.user.full_name;
                    
                    const avatarDisp = document.getElementById('profile-avatar');
                    if (avatarDisp) avatarDisp.textContent = data.user.full_name.substring(0, 1).toUpperCase();
                    
                    const phoneDisp = document.getElementById('profile-display-phone');
                    if (phoneDisp) phoneDisp.textContent = data.user.phone ? data.user.phone : 'Chưa cập nhật';
                    
                    const addrDisp = document.getElementById('profile-display-address');
                    if (addrDisp) addrDisp.textContent = data.user.address ? data.user.address : 'Chưa cập nhật';

                    // Cập nhật tên hiển thị của tài khoản trên Navbar
                    const navUserSpan = document.querySelector('.user-dropdown-btn span');
                    if (navUserSpan) navUserSpan.textContent = data.user.full_name;
                    
                    const dropUserName = document.querySelector('.user-dropdown-header .user-name');
                    if (dropUserName) dropUserName.textContent = data.user.full_name;
                    
                } else {
                    errorAlert.textContent = data.message;
                    errorAlert.classList.remove('d-none');
                }
            })
            .catch(err => {
                console.error(err);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'LƯU THAY ĐỔI <i class="fas fa-save ms-2"></i>';
                errorAlert.textContent = 'Lỗi kết nối máy chủ khi cập nhật thông tin!';
                errorAlert.classList.remove('d-none');
            });
        });
    }

    // 4. AJAX Đổi mật khẩu
    const formPass = document.getElementById('changePasswordForm');
    if (formPass) {
        if (formPass.dataset.listenerAttached) return;
        formPass.dataset.listenerAttached = 'true';

        formPass.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const submitBtn = document.getElementById('btnSubmitPassword');
            const errorAlert = document.getElementById('passwordErrorAlert');
            const successAlert = document.getElementById('passwordSuccessAlert');
            
            const oldPassword = document.getElementById('oldPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            errorAlert.classList.add('d-none');
            successAlert.classList.add('d-none');

            if (newPassword.length < 6) {
                errorAlert.textContent = 'Mật khẩu mới phải có ít nhất 6 ký tự!';
                errorAlert.classList.remove('d-none');
                return;
            }

            if (newPassword !== confirmPassword) {
                errorAlert.textContent = 'Mật khẩu xác nhận không khớp!';
                errorAlert.classList.remove('d-none');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';

            fetch('index.php?controller=auth&action=changePassword', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    old_password: oldPassword,
                    new_password: newPassword,
                    confirm_password: confirmPassword
                })
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'CẬP NHẬT MẬT KHẨU <i class="fas fa-save ms-2"></i>';
                
                if (data.success) {
                    successAlert.textContent = data.message;
                    successAlert.classList.remove('d-none');
                    formPass.reset();
                } else {
                    errorAlert.textContent = data.message;
                    errorAlert.classList.remove('d-none');
                }
            })
            .catch(err => {
                console.error(err);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'CẬP NHẬT MẬT KHẨU <i class="fas fa-save ms-2"></i>';
                errorAlert.textContent = 'Lỗi kết nối máy chủ!';
                errorAlert.classList.remove('d-none');
            });
        });
    }
};

// Dọn dẹp canvas khi đóng sheet profile
window.profileCanvasCleanup = function() {
    if (window.stopProfileBubbles) {
        window.stopProfileBubbles();
    }
};

if (document.readyState !== 'loading') {
    window.initProfilePage();
} else {
    document.addEventListener('DOMContentLoaded', window.initProfilePage);
}
</script>

<?php
require_once ROOT_PATH . '/app/Views/partials/footer.php';
?>
