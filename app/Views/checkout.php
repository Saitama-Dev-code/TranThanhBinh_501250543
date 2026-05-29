<?php
// Đường dẫn file: app/Views/checkout.php
require_once ROOT_PATH . '/app/Views/partials/header.php';
?>

<style>
    /* Styling riêng cho trang Checkout đảm bảo tính đồng bộ với theme TTB Music */
    .checkout-container {
        margin-top: 120px;
        margin-bottom: 80px;
    }
    
    .checkout-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 30px;
        backdrop-filter: blur(20px);
        box-shadow: var(--box-shadow);
    }
    
    .checkout-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-color);
    }

    .form-control {
        background: var(--bg-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px 20px;
        color: var(--text-color);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background: var(--card-bg);
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        color: var(--text-color);
    }

    .order-summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .order-summary-item:last-child {
        border-bottom: none;
    }

    .order-summary-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 15px;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-title {
        font-weight: 600;
        margin: 0;
        font-size: 0.95rem;
        color: var(--text-color);
    }
    
    .item-meta {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    .item-price-total {
        font-weight: 700;
        color: #3b82f6;
    }

    .checkout-btn {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        border: none;
        border-radius: 12px;
        padding: 15px;
        font-size: 1.1rem;
        font-weight: 700;
        width: 100%;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        color: white;
    }
</style>

<div class="container checkout-container">
    <div class="row g-5">
        
        <!-- Cột trái: Form thông tin thanh toán -->
        <div class="col-lg-7">
            <div class="checkout-card">
                <h3 class="checkout-title"><i class="fas fa-map-marker-alt me-2"></i> Thông tin giao hàng</h3>
                
                <?php if (!isset($_SESSION['user'])): ?>
                    <div class="alert alert-info rounded-3" style="background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.2); color: var(--text-color);">
                        <i class="fas fa-info-circle me-2"></i> Bạn đang thanh toán dưới dạng khách vãng lai. <a href="index.php?controller=auth&action=login" class="fw-bold" style="color: #3b82f6;">Đăng nhập ngay</a> để lưu lịch sử mua hàng.
                    </div>
                <?php endif; ?>

                <form action="index.php?controller=checkout&action=process" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <div class="mb-4">
                        <label class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="fullname" placeholder="Nhập họ và tên người nhận" required 
                               value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="phone" placeholder="Nhập số điện thoại liên hệ" required 
                               value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" rows="3" placeholder="Nhập chi tiết số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..." required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Ghi chú cho đơn hàng (Tùy chọn)</label>
                        <textarea class="form-control" name="notes" rows="2" placeholder="Ví dụ: Giao hàng giờ hành chính..."></textarea>
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">
                    
                    <h5 class="fw-bold mb-3" style="color: var(--text-color);">Phương thức thanh toán</h5>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="paymentCOD" value="COD" checked>
                        <label class="form-check-label" for="paymentCOD" style="color: var(--text-color);">
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>
                    <!-- Có thể thêm các phương thức thanh toán khác ở đây sau này -->

                    <button type="submit" class="checkout-btn mt-4">
                        Xác nhận Đặt hàng <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Cột phải: Tóm tắt đơn hàng -->
        <div class="col-lg-5">
            <div class="checkout-card" style="position: sticky; top: 120px;">
                <h3 class="checkout-title"><i class="fas fa-shopping-bag me-2"></i> Tóm tắt đơn hàng</h3>
                
                <div class="order-items-list mb-4">
                    <?php if (isset($cartItems) && is_array($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <div class="order-summary-item">
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="order-summary-img">
                                <div class="item-details">
                                    <h6 class="item-title"><?= htmlspecialchars($item['name']) ?></h6>
                                    <p class="item-meta">SL: <?= $item['quantity'] ?> | <?= htmlspecialchars($item['color'] ?? '') ?> <?= htmlspecialchars($item['version'] ?? '') ?></p>
                                </div>
                                <div class="item-price-total">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> ₫
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 text-muted">
                    <span>Tạm tính:</span>
                    <span><?= number_format($totalPrice, 0, ',', '.') ?> ₫</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4 text-muted">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>

                <hr style="border-color: var(--border-color);">

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="fs-5 fw-bold" style="color: var(--text-color);">Tổng cộng:</span>
                    <span class="fs-4 fw-bolder" style="color: #3b82f6;"><?= number_format($totalPrice, 0, ',', '.') ?> ₫</span>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php
require_once ROOT_PATH . '/app/Views/partials/footer.php';
?>
