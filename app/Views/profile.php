<?php
// Đường dẫn file: app/Views/profile.php
require_once ROOT_PATH . '/app/Views/partials/header.php';
?>

<style>
    /* Styling trang Profile đồng nhất với nhận diện thương hiệu TTB Music */
    .profile-container {
        margin-top: 120px;
        margin-bottom: 80px;
    }

    .profile-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 30px;
        backdrop-filter: blur(20px);
        box-shadow: var(--box-shadow);
        height: 100%;
    }

    .profile-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
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
    }

    .info-group {
        margin-bottom: 15px;
    }

    .info-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-color);
        background: var(--bg-color);
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
    }

    .logout-btn {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: #ef4444;
        color: white;
    }

    /* Bảng lịch sử đơn hàng */
    .table-orders {
        width: 100%;
        color: var(--text-color);
    }

    .table-orders th {
        color: var(--text-muted);
        font-weight: 600;
        border-bottom: 2px solid var(--border-color);
        padding: 12px;
    }

    .table-orders td {
        padding: 15px 12px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-pending { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .status-shipping { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .status-completed { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .status-canceled { background: rgba(239, 68, 68, 0.15); color: #ef4444; }

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

    /* Style for Bootstrap 5 Nav-tabs in Profile */
    .profile-card .nav-tabs {
        border-bottom: 1px solid var(--border-color) !important;
        gap: 10px;
    }
    .profile-card .nav-link {
        color: var(--text-muted);
        border: none !important;
        border-radius: 10px 10px 0 0;
        background: transparent;
        font-weight: 600;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }
    .profile-card .nav-link:hover {
        color: var(--text-color);
        background: rgba(255, 255, 255, 0.05);
    }
    .profile-card .nav-link.active {
        color: #3b82f6 !important;
        background: rgba(59, 130, 246, 0.1) !important;
        border-bottom: 2px solid #3b82f6 !important;
    }
    .status-active { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .status-returned { background: rgba(16, 185, 129, 0.15); color: #10b981; }
</style>

<div class="container profile-container">
    <div class="row g-4">
        
        <!-- Cột trái: Thông tin cá nhân -->
        <div class="col-lg-4">
            <div class="profile-card text-center text-lg-start">
                <div class="text-center">
                    <!-- Lấy chữ cái đầu của tên làm Avatar -->
                    <div class="avatar-wrapper">
                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                    </div>
                    <h4 class="fw-bold mb-1" style="color: var(--text-color);"><?= htmlspecialchars($user['full_name']) ?></h4>
                    <p class="text-muted mb-4"><?= htmlspecialchars($user['email']) ?></p>
                </div>

                <div class="info-group">
                    <div class="info-label">Chức vụ</div>
                    <div class="info-value">
                        <?php 
                            if ($user['role'] == 1) echo '<span class="badge bg-danger">Quản trị viên</span>';
                            else echo 'Thành viên TTB';
                        ?>
                    </div>
                </div>

                <div class="mt-5">
                    <a href="index.php?controller=auth&action=logout" class="btn logout-btn" data-no-spa>
                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </div>

        <!-- Cột phải: Tabs Lịch sử Mua hàng & Thuê nhạc cụ -->
        <div class="col-lg-8">
            <div class="profile-card">
                <ul class="nav nav-tabs border-0 mb-4" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders-pane" type="button" role="tab" aria-controls="orders-pane" aria-selected="true">
                            <i class="fas fa-history me-2"></i>Đơn mua hàng
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="rentals-tab" data-bs-toggle="tab" data-bs-target="#rentals-pane" type="button" role="tab" aria-controls="rentals-pane" aria-selected="false">
                            <i class="fas fa-clock me-2"></i>Hợp đồng thuê
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-pane" type="button" role="tab" aria-controls="password-pane" aria-selected="false">
                            <i class="fas fa-key me-2"></i>Đổi mật khẩu
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="profileTabsContent">
                    <!-- Tab 1: Đơn mua hàng -->
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
                                                    <p>Bạn chưa đặt mua sản phẩm nào từ TTB Music.</p>
                                                    <a href="index.php?controller=product&action=index" class="btn btn-outline-primary rounded-pill mt-3">Khám phá ngay</a>
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
                                                            $statusClass = 'status-shipping';
                                                            $statusText = 'Đang giao';
                                                        } elseif ($order['status'] == 'completed') {
                                                            $statusClass = 'status-completed';
                                                            $statusText = 'Hoàn thành';
                                                        } elseif ($order['status'] == 'canceled') {
                                                            $statusClass = 'status-canceled';
                                                            $statusText = 'Đã hủy';
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
                    
                    <!-- Tab 2: Hợp đồng thuê -->
                    <div class="tab-pane fade" id="rentals-pane" role="tabpanel" aria-labelledby="rentals-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table-orders">
                                <thead>
                                    <tr>
                                        <th>Mã HĐ</th>
                                        <th>Nhạc cụ</th>
                                        <th>Thời hạn thuê</th>
                                        <th>Tổng phí</th>
                                        <th>Tiền cọc</th>
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
                                                    <p>Bạn chưa thực hiện thuê nhạc cụ nào tại TTB Music.</p>
                                                    <a href="index.php?controller=product&action=index" class="btn btn-outline-primary rounded-pill mt-3">Thuê ngay sản phẩm</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($rentals as $rental): ?>
                                            <tr>
                                                <td class="fw-bold">#R-<?= $rental['id'] ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="<?= htmlspecialchars($rental['product_image']) ?>" alt="<?= htmlspecialchars($rental['product_name']) ?>" style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-color);">
                                                        <span class="small fw-semibold text-truncate" style="max-width: 150px;" title="<?= htmlspecialchars($rental['product_name']) ?>">
                                                            <?= htmlspecialchars($rental['product_name']) ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="small">
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
                                                            $statusClass = 'status-active';
                                                            $statusText = 'Đang thuê';
                                                        } elseif ($rental['status'] == 'returned') {
                                                            $statusClass = 'status-returned';
                                                            $statusText = 'Đã trả';
                                                        } elseif ($rental['status'] == 'canceled') {
                                                            $statusClass = 'status-canceled';
                                                            $statusText = 'Đã hủy';
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
                    
                    <!-- Tab 3: Đổi mật khẩu -->
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.initProfilePage === 'function') {
        window.initProfilePage();
    }
});

window.initProfilePage = function() {
    const hash = window.location.hash;
    if (hash) {
        const tabEl = document.querySelector(`button[data-bs-target="${hash}"]`);
        if (tabEl) {
            const tab = new bootstrap.Tab(tabEl);
            tab.show();
        }
    }

    const form = document.getElementById('changePasswordForm');
    if (form) {
        if (form.dataset.listenerAttached) return;
        form.dataset.listenerAttached = 'true';

        form.addEventListener('submit', (e) => {
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
                    form.reset();
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

if (document.readyState !== 'loading') {
    window.initProfilePage();
} else {
    document.addEventListener('DOMContentLoaded', window.initProfilePage);
}
</script>

<?php
require_once ROOT_PATH . '/app/Views/partials/footer.php';
?>
