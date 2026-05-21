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
                    <a href="index.php?controller=auth&action=logout" class="btn logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </div>

        <!-- Cột phải: Lịch sử đơn hàng -->
        <div class="col-lg-8">
            <div class="profile-card">
                <h3 class="profile-title"><i class="fas fa-history me-2"></i> Lịch sử mua hàng</h3>
                
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
        </div>
        
    </div>
</div>

<?php
require_once ROOT_PATH . '/app/Views/partials/footer.php';
?>
