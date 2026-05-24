<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/cart.php
 * MÔ TẢ: Trang giỏ hàng - hiển thị sản phẩm đã thêm, tính tổng tiền,
 *         cập nhật số lượng và xóa sản phẩm qua AJAX.
 * DỮ LIỆU NHẬN TỪ CONTROLLER:
 *   $cartItems   : mảng các item trong giỏ hàng (từ $_SESSION['cart'])
 *   $totalAmount : tổng tiền cần thanh toán
 *   $totalQty    : tổng số lượng sản phẩm
 * =========================================================================
 */
include __DIR__ . '/partials/header.php';
?>

<style>
/* ================================================================
   CART PAGE – STYLE RIÊNG CHO TRANG GIỎ HÀNG
   Sử dụng CSS variables (--card-bg, --text-color, ...) để tương
   thích với cả nền sáng lẫn nền tối.
   ================================================================ */

/* Nền Ripple giống product_detail (màu xanh dương - tím) */
#cart-canvas {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: -1;
    pointer-events: none;
    opacity: 0.5;
}

/* ---- Tiêu đề trang ---- */
.cart-title {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ---- Layout 2 cột: [Danh sách SP] [Tóm tắt đơn hàng] ---- */
.cart-layout {
    display: flex;
    gap: 24px;
    align-items: flex-start;
}
.cart-items-col {
    flex: 1;
    min-width: 0;
}
.cart-summary-col {
    width: 320px;
    flex-shrink: 0;
    position: sticky;  /* Cột tóm tắt dính theo khi scroll */
    top: 90px;
}

/* ---- Card bọc nội dung (glassmorphism) ---- */
.cart-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    padding: 24px;
    backdrop-filter: blur(10px);
    margin-bottom: 16px;
}

/* ---- Mỗi dòng sản phẩm trong giỏ ---- */
.cart-item {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    padding: 16px 0;
    border-bottom: 1px solid var(--border-color);
    transition: opacity 0.3s ease;
}
.cart-item:last-child { border-bottom: none; }
.cart-item.removing   { opacity: 0; }  /* Hiệu ứng xóa */

/* Ảnh sản phẩm */
.cart-item-img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 12px;
    flex-shrink: 0;
    border: 1px solid var(--border-color);
}
.cart-item-img-placeholder {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    flex-shrink: 0;
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
}

/* Thông tin sản phẩm */
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-name {
    font-weight: 700;
    font-size: 1rem;
    color: var(--text-color);
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cart-item-variant {
    font-size: 0.8rem;
    color: var(--text-muted, rgba(100,116,139,0.9));
    margin-bottom: 8px;
}
.cart-item-price {
    font-size: 1rem;
    font-weight: 700;
    color: #7c3aed;
}

/* Điều khiển số lượng */
.qty-controls {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
}
.qty-btn {
    width: 30px; height: 30px;
    border-radius: 50%;
    border: 1px solid var(--border-color);
    background: var(--card-bg);
    color: var(--text-color);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 700;
    transition: all 0.2s;
}
.qty-btn:hover {
    background: #7c3aed;
    color: white;
    border-color: #7c3aed;
}
.qty-display {
    min-width: 32px;
    text-align: center;
    font-weight: 700;
    font-size: 1rem;
    color: var(--text-color);
}

/* Nút xóa */
.btn-remove-item {
    background: none;
    border: none;
    color: #ef4444;
    cursor: pointer;
    font-size: 1.1rem;
    padding: 4px 8px;
    border-radius: 8px;
    transition: all 0.2s;
    flex-shrink: 0;
}
.btn-remove-item:hover {
    background: rgba(239,68,68,0.1);
    transform: scale(1.1);
}

/* Tổng tiền của từng item */
.cart-item-total {
    font-weight: 700;
    font-size: 1rem;
    color: var(--text-color);
    min-width: 100px;
    text-align: right;
    flex-shrink: 0;
    align-self: center;
}

/* ---- Cột tóm tắt đơn hàng (Summary) ---- */
.summary-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border-color);
}
.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    font-size: 0.9rem;
    color: var(--text-color);
}
.summary-label { opacity: 0.7; }
.summary-value { font-weight: 600; }
.summary-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 2px solid var(--border-color);
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text-color);
}
.summary-total-price {
    font-size: 1.3rem;
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Nút Thanh toán */
.btn-checkout {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #7c3aed, #6366f1);
    border: none;
    border-radius: 12px;
    color: white;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}
.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(124, 58, 237, 0.35);
    color: white;
}

/* Nút Tiếp tục mua sắm */
.btn-continue {
    width: 100%;
    padding: 12px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    color: var(--text-color);
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}
.btn-continue:hover {
    border-color: #7c3aed;
    color: #7c3aed;
}

/* ---- Giỏ trống ---- */
.cart-empty {
    text-align: center;
    padding: 60px 20px;
}
.cart-empty-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.4;
}
.cart-empty h3 {
    color: var(--text-color);
    font-weight: 700;
    margin-bottom: 10px;
}
.cart-empty p {
    color: var(--text-muted, rgba(100,116,139,0.9));
    margin-bottom: 24px;
}

/* ---- Toast thông báo ---- */
.cart-toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: var(--card-bg);
    color: var(--text-color);
    border: 1px solid var(--border-color);
    padding: 14px 20px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    z-index: 9999;
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    max-width: 320px;
}
.cart-toast.show {
    transform: translateY(0);
    opacity: 1;
}
.cart-toast i { color: #22c55e; font-size: 1.2rem; }

/* Responsive */
@media (max-width: 768px) {
    .cart-layout     { flex-direction: column; }
    .cart-summary-col { width: 100%; position: static; }
    .cart-item-total  { display: none; }
}

/* Hiệu ứng kéo trượt từ trên xuống khi tải trang giỏ hàng */
@keyframes cartSlideDown {
    0% {
        transform: translateY(-80px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}
.cart-entrance {
    animation: cartSlideDown 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>

<!-- Nút Đóng giỏ hàng SPA Overlay -->
<div class="cart-close-btn-wrapper">
    <button type="button" class="btn-cart-close" id="btn-close-cart-overlay" title="Quay lại">
        <i class="fas fa-times"></i>
    </button>
</div>

<!-- Canvas Ripple sóng âm (giống product_detail nhưng màu xanh dương) -->
<canvas id="cart-canvas"></canvas>

<div class="container my-5 pt-3 cart-entrance">

    <!-- Tiêu đề trang -->
    <div class="mb-4">
        <h1 class="cart-title">
            <i class="fas fa-shopping-cart me-2" style="-webkit-text-fill-color:#3b82f6;"></i>
            Giỏ hàng của bạn
        </h1>
        <?php
        /*
         * Hiển thị số sản phẩm trong giỏ.
         * $totalQty: tổng số lượng sản phẩm (tính ở Controller).
         */
        ?>
        <p class="text-muted mb-0" id="cart-subtitle">
            <?= $totalQty ?> sản phẩm đang chờ thanh toán
        </p>
    </div>

    <?php
    /*
     * PHÂN NHÁNH HIỂN THỊ CƠ BẢN:
     * Cả hai trạng thái luôn được in ra DOM. Trạng thái không phù hợp sẽ bị ẩn (display: none).
     * Bằng cách này, JS có thể chuyển đổi mượt mà mà không cần reload.
     */
    $isEmpty = empty($cartItems);
    ?>

    <!-- TRẠNG THÁI GIỎ TRỐNG -->
    <div class="cart-card" id="empty-cart-layout" style="<?= $isEmpty ? '' : 'display: none;' ?>">
        <div class="cart-empty">
            <div class="cart-empty-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>Giỏ hàng trống!</h3>
            <p>Bạn chưa thêm sản phẩm nào vào giỏ hàng.<br>Hãy khám phá cửa hàng để tìm nhạc cụ ưa thích!</p>
            <a href="index.php?controller=product&action=index"
               class="btn btn-primary rounded-pill px-4 py-2">
                <i class="fas fa-music me-2"></i>Khám phá cửa hàng
            </a>
        </div>
    </div>

    <!-- LAYOUT 2 CỘT: [Danh sách SP] [Tóm tắt] -->
    <div class="cart-layout" id="full-cart-layout" style="<?= $isEmpty ? 'display: none;' : '' ?>">

            <!-- CỘT TRÁI: DANH SÁCH SẢN PHẨM -->
            <div class="cart-items-col">
                <div class="cart-card">
                    <div id="cart-items-list">
                        <?php
                        /*
                         * Vòng lặp hiển thị từng sản phẩm trong giỏ.
                         * $cartItems: mảng từ Controller, key là cart_key (vd: "12_do_standard").
                         * Mỗi item có: product_id, name, price, image, quantity, stock, color, version.
                         */
                        foreach ($cartItems as $cartKey => $item):
                            // Tính tổng tiền của 1 dòng
                            $lineTotal = $item['price'] * $item['quantity'];
                            // Kiểm tra xem biến thể có được chọn không
                            $hasVariant = !empty($item['color']) || !empty($item['version']);
                        ?>
                            <!-- DÒNG SẢN PHẨM: data-key dùng JS xác định item -->
                            <div class="cart-item" id="item-<?= htmlspecialchars($cartKey) ?>"
                                 data-key="<?= htmlspecialchars($cartKey) ?>"
                                 data-price="<?= $item['price'] ?>"
                                 data-stock="<?= $item['stock'] ?>">

                                <!-- Ảnh sản phẩm -->
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?= htmlspecialchars($item['image']) ?>"
                                         alt="<?= htmlspecialchars($item['name']) ?>"
                                         class="cart-item-img"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="cart-item-img-placeholder" style="display:none;">
                                        <i class="fas fa-music"></i>
                                    </div>
                                <?php else: ?>
                                    <div class="cart-item-img-placeholder">
                                        <i class="fas fa-music"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Thông tin sản phẩm -->
                                <div class="cart-item-info">
                                    <div class="cart-item-name">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </div>

                                    <?php if ($hasVariant): ?>
                                        <!-- Hiển thị biến thể đã chọn -->
                                        <div class="cart-item-variant">
                                            <?php if (!empty($item['color'])): ?>
                                                <span><i class="fas fa-palette me-1"></i><?= htmlspecialchars($item['color']) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($item['version'])): ?>
                                                <span class="ms-2"><i class="fas fa-tag me-1"></i><?= htmlspecialchars($item['version']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Giá đơn vị -->
                                    <div class="cart-item-price">
                                        <?= number_format($item['price'], 0, ',', '.') ?> ₫
                                    </div>

                                    <!-- Điều khiển số lượng -->
                                    <div class="qty-controls">
                                        <?php
                                        /*
                                         * Nút giảm số lượng:
                                         * - Nếu qty > 1 → giảm 1
                                         * - Nếu qty = 1 → xóa item (hỏi xác nhận)
                                         * onclick gọi JS updateQty(cartKey, delta)
                                         */
                                        ?>
                                        <button class="qty-btn"
                                                onclick="updateQty('<?= htmlspecialchars($cartKey) ?>', -1)"
                                                title="Giảm số lượng">
                                            <i class="fas fa-minus" style="font-size:0.7rem;"></i>
                                        </button>

                                        <!-- Hiển thị số lượng hiện tại -->
                                        <span class="qty-display" id="qty-<?= htmlspecialchars($cartKey) ?>">
                                            <?= $item['quantity'] ?>
                                        </span>

                                        <?php
                                        /*
                                         * Nút tăng số lượng:
                                         * Disabled khi đã đạt tồn kho tối đa (data-stock).
                                         */
                                        ?>
                                        <button class="qty-btn"
                                                onclick="updateQty('<?= htmlspecialchars($cartKey) ?>', 1)"
                                                title="Tăng số lượng"
                                                <?= $item['quantity'] >= $item['stock'] ? 'disabled style="opacity:0.4;cursor:not-allowed;"' : '' ?>>
                                            <i class="fas fa-plus" style="font-size:0.7rem;"></i>
                                        </button>

                                        <span style="font-size:0.75rem; color:var(--text-muted, rgba(100,116,139,0.8));">
                                            Còn <?= $item['stock'] ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Tổng tiền dòng -->
                                <div class="cart-item-total" id="line-<?= htmlspecialchars($cartKey) ?>">
                                    <?= number_format($lineTotal, 0, ',', '.') ?> ₫
                                </div>

                                <!-- Nút xóa -->
                                <button class="btn-remove-item"
                                        onclick="removeItem('<?= htmlspecialchars($cartKey) ?>')"
                                        title="Xóa sản phẩm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </div><!-- /.cart-item -->
                        <?php endforeach; ?>
                    </div><!-- /#cart-items-list -->
                </div><!-- /.cart-card -->
            </div><!-- /.cart-items-col -->

            <!-- CỘT PHẢI: TÓM TẮT ĐƠN HÀNG -->
            <div class="cart-summary-col">
                <div class="cart-card">
                    <div class="summary-title">
                        <i class="fas fa-receipt me-2 text-primary"></i>Tóm tắt đơn hàng
                    </div>

                    <!-- Tạm tính -->
                    <div class="summary-row">
                        <span class="summary-label">Tạm tính (<?= $totalQty ?> sp)</span>
                        <span class="summary-value" id="subtotal">
                            <?= number_format($totalAmount, 0, ',', '.') ?> ₫
                        </span>
                    </div>

                    <!-- Phí vận chuyển -->
                    <div class="summary-row">
                        <span class="summary-label">Phí vận chuyển</span>
                        <span class="summary-value" style="color:#22c55e;">
                            Miễn phí
                        </span>
                    </div>

                    <!-- Giảm giá (placeholder cho sau) -->
                    <div class="summary-row" id="discount-row" style="display:none;">
                        <span class="summary-label">Giảm giá</span>
                        <span class="summary-value" style="color:#ef4444;" id="discount-value">0 ₫</span>
                    </div>

                    <!-- Tổng cộng -->
                    <div class="summary-total">
                        <span>Tổng cộng</span>
                        <span class="summary-total-price" id="grand-total">
                            <?= number_format($totalAmount, 0, ',', '.') ?> ₫
                        </span>
                    </div>

                    <?php
                    /*
                     * Nút Thanh toán: link đến CheckoutController.
                     * Hiện tại route = index.php?controller=order&action=checkout
                     * (Sẽ tạo OrderController ở bước tiếp theo)
                     */
                    ?>
                    <a href="index.php?controller=order&action=checkout"
                       class="btn-checkout" id="btn-checkout">
                        <i class="fas fa-lock"></i> Tiến hành thanh toán
                    </a>

                    <!-- Tiếp tục mua sắm -->
                    <a href="index.php?controller=product&action=index"
                       class="btn-continue">
                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                </div><!-- /.cart-card (summary) -->

                <!-- Thông tin thêm -->
                <div class="cart-card" style="padding:16px;">
                    <div style="font-size:0.82rem; color:var(--text-muted,rgba(100,116,139,0.9));">
                        <div class="mb-2">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            Thanh toán bảo mật 256-bit SSL
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-undo text-primary me-2"></i>
                            Đổi trả miễn phí trong 30 ngày
                        </div>
                        <div>
                            <i class="fas fa-headset text-primary me-2"></i>
                            Hỗ trợ 24/7: 1800-6868
                        </div>
                    </div>
                </div>
            </div><!-- /.cart-summary-col -->

        </div><!-- /.cart-layout -->
    </div><!-- /.cart-layout wrapper -->
</div><!-- /.container -->
<!-- Toast thông báo -->
<div class="cart-toast" id="cart-toast">
    <i class="fas fa-check-circle"></i>
    <span id="toast-message">Đã cập nhật giỏ hàng!</span>
</div>

<!-- Custom Confirmation Modal (Khung câu hỏi xóa sản phẩm) -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false" style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-panel p-4" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 1.5rem; box-shadow: 0 15px 35px rgba(0,0,0,0.4); color: var(--text-color) !important;">
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-circle text-warning fa-3x mb-3 animate__animated animate__pulse animate__infinite"></i>
                <h5 class="fw-bold mb-3" style="color: var(--text-color);">Xác nhận xóa</h5>
                <p class="mb-4" id="delete-modal-msg" style="color: var(--text-color); opacity: 0.8;">Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?</p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn rounded-pill px-4" data-bs-dismiss="modal" style="color: var(--text-color); border: 1px solid var(--border-color); background: transparent; transition: all 0.2s;">Hủy</button>
                    <button type="button" class="btn btn-danger rounded-pill px-4" id="btn-confirm-delete">Đồng ý xóa</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * ================================================================
 * JAVASCRIPT TRANG GIỎ HÀNG
 * ================================================================
 */

/* --------------------------------------------------------
   HÀM HELPER: Định dạng số tiền → "18.500.000 ₫"
   -------------------------------------------------------- */
function formatMoney(amount) {
    // Dùng toLocaleString('vi-VN') để có dấu phân nghìn kiểu Việt
    return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
}

/* --------------------------------------------------------
   HÀM: showToast(message, isError)
   Hiển thị thông báo nhỏ ở góc dưới phải màn hình.
   isError = true → màu đỏ (thất bại)
   -------------------------------------------------------- */
function showToast(message, isError = false) {
    const toast = document.getElementById('cart-toast');
    const icon  = toast.querySelector('i');
    const msg   = document.getElementById('toast-message');

    // Đổi màu icon theo loại thông báo
    icon.className = isError
        ? 'fas fa-times-circle'
        : 'fas fa-check-circle';
    icon.style.color = isError ? '#ef4444' : '#22c55e';

    msg.textContent = message;
    toast.classList.add('show');

    // Tự ẩn sau 2.5 giây
    setTimeout(() => toast.classList.remove('show'), 2500);
}

/* --------------------------------------------------------
   HÀM: updateNavBadge(count)
   Cập nhật số trên badge giỏ hàng ở navbar.
   -------------------------------------------------------- */
function updateNavBadge(count) {
    const cartCounts = document.querySelectorAll('.cart-count');
    cartCounts.forEach(c => {
        c.textContent = count;
    });
}

/* --------------------------------------------------------
   HÀM: updateQty(cartKey, delta)
   Tăng (delta=+1) hoặc giảm (delta=-1) số lượng item.
   Gửi POST AJAX đến CartController::update().
   -------------------------------------------------------- */
/* --------------------------------------------------------
   KHỞI TẠO MODAL XÁC NHẬN XÓA (Khung câu hỏi thiết kế riêng)
   -------------------------------------------------------- */
let deleteAction = null;
let deleteModal = null;

window.initCartPage = function() {
    const modalEl = document.getElementById('deleteConfirmModal');
    if (modalEl) {
        deleteModal = new bootstrap.Modal(modalEl);
    }
    
    const confirmBtn = document.getElementById('btn-confirm-delete');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            if (deleteAction) {
                deleteAction();
            }
            if (deleteModal) {
                deleteModal.hide();
            }
        });
    }

    // Xử lý nút đóng giỏ hàng
    const closeCartBtn = document.getElementById('btn-close-cart-overlay');
    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', () => {
            const fallbackUrl = window.spaBackgroundUrl || 'index.php?controller=home';
            if (typeof window.hideCartOverlaySPA === 'function') {
                window.hideCartOverlaySPA();
                if (history.length > 1) {
                    history.back();
                } else {
                    window.navigateToSPA(fallbackUrl);
                }
            } else {
                const cartPage = document.getElementById('page-cart');
                if (cartPage && cartPage.classList.contains('active-overlay')) {
                    cartPage.classList.remove('active-overlay');
                    document.body.style.overflow = '';
                    setTimeout(() => {
                        cartPage.style.display = 'none';
                    }, 700);
                }
                window.location.href = fallbackUrl;
            }
        });
    }
};

/**
 * Hiển thị khung câu hỏi xác nhận xóa sản phẩm
 * @param {string} itemName - Tên sản phẩm cần xóa
 * @param {function} onConfirm - Callback thực thi khi đồng ý xóa
 */
function showDeleteConfirm(itemName, onConfirm) {
    const msgEl = document.getElementById('delete-modal-msg');
    if (msgEl) {
        msgEl.innerHTML = `Bạn có chắc chắn muốn xóa sản phẩm <strong style="color: #60a5fa !important;">${itemName}</strong> khỏi giỏ hàng?`;
    }
    deleteAction = onConfirm;
    if (deleteModal) {
        deleteModal.show();
    }
}

/**
 * Cập nhật dòng chữ phụ đề giỏ hàng (số lượng sp đang chờ thanh toán)
 * @param {number} count - Tổng số lượng
 */
function updateCartSubtitle(count) {
    const subtitleEl = document.getElementById('cart-subtitle');
    if (subtitleEl) {
        subtitleEl.textContent = `${count} sản phẩm đang chờ thanh toán`;
    }
}

/* --------------------------------------------------------
   HÀM: updateQty(cartKey, delta)
   Tăng (delta=+1) hoặc giảm (delta=-1) số lượng item.
   -------------------------------------------------------- */
function updateQty(cartKey, delta) {
    const row     = document.getElementById('item-' + cartKey);
    const qtyEl   = document.getElementById('qty-' + cartKey);
    const stock   = parseInt(row.dataset.stock);
    const price   = parseFloat(row.dataset.price);

    let currentQty = parseInt(qtyEl.textContent);
    let newQty     = currentQty + delta;

    // Khi người dùng bấm giảm số lượng về 0 → Hiện khung câu hỏi xác nhận trước khi xóa
    if (newQty === 0) {
        const name = row.querySelector('.cart-item-name').textContent.trim();
        showDeleteConfirm(name, () => {
            performUpdateQty(cartKey, 0, price, row);
        });
        return;
    } else if (newQty < 0) {
        newQty = 0;
    }

    // Không cho vượt tồn kho
    if (newQty > stock) {
        showToast('Đã đạt số lượng tối đa có thể mua!', true);
        return;
    }

    performUpdateQty(cartKey, newQty, price, row);
}

/* --------------------------------------------------------
   HÀM: performUpdateQty(cartKey, newQty, price, row)
   Gửi POST AJAX đến CartController::update() để lưu thay đổi.
   -------------------------------------------------------- */
function performUpdateQty(cartKey, newQty, price, row) {
    const qtyEl   = document.getElementById('qty-' + cartKey);
    const lineEl  = document.getElementById('line-' + cartKey);

    fetch('index.php?controller=cart&action=update', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ cart_key: cartKey, quantity: newQty })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            showToast('Lỗi cập nhật!', true);
            return;
        }

        if (data.removed) {
            // Item bị xóa (newQty = 0): animate rồi remove khỏi DOM
            row.classList.add('removing');
            setTimeout(() => {
                row.remove();
                updateCartSubtitle(data.cart_count);
                // Kiểm tra nếu giỏ trống → hiện empty state mượt mà
                if (document.querySelectorAll('.cart-item').length === 0) {
                    showEmptyCart();
                }
            }, 350);
            showToast('Đã xóa sản phẩm khỏi giỏ.');
        } else {
            // Cập nhật UI: số lượng + tổng dòng + tổng cộng
            qtyEl.textContent   = newQty;
            lineEl.textContent  = formatMoney(price * newQty);
            document.getElementById('subtotal').textContent   = formatMoney(data.grand_total);
            document.getElementById('grand-total').textContent = formatMoney(data.grand_total);
            updateCartSubtitle(data.cart_count);
        }

        // Cập nhật badge navbar
        updateNavBadge(data.cart_count);
    })
    .catch(() => showToast('Mất kết nối, thử lại sau!', true));
}

/* --------------------------------------------------------
   HÀM: removeItem(cartKey)
   Xóa hoàn toàn một item khỏi giỏ hàng.
   -------------------------------------------------------- */
function removeItem(cartKey) {
    const row = document.getElementById('item-' + cartKey);
    if (!row) return;
    const name = row.querySelector('.cart-item-name').textContent.trim();

    // Hiện khung câu hỏi xác nhận trước khi xóa hoàn toàn
    showDeleteConfirm(name, () => {
        row.classList.add('removing'); // Animate mờ dần

        fetch('index.php?controller=cart&action=remove', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ cart_key: cartKey })
        })
        .then(res => res.json())
        .then(data => {
            setTimeout(() => {
                row.remove();

                // Cập nhật tổng tiền
                if (data.success) {
                    document.getElementById('subtotal').textContent    = formatMoney(data.grand_total);
                    document.getElementById('grand-total').textContent = formatMoney(data.grand_total);
                    updateNavBadge(data.cart_count);
                    updateCartSubtitle(data.cart_count);
                }

                // Nếu giỏ trống sau khi xóa → hiện empty state
                const remaining = document.querySelectorAll('.cart-item');
                if (remaining.length === 0) {
                    showEmptyCart();
                }
            }, 350);

            showToast('Đã xóa sản phẩm khỏi giỏ hàng.');
        })
        .catch(() => {
            row.classList.remove('removing');
            showToast('Mất kết nối, thử lại sau!', true);
        });
    });
}

/* --------------------------------------------------------
   HÀM: showEmptyCart()
   Hiện giao diện giỏ trống mượt mà với hiệu ứng trượt & mờ dần cao cấp
   -------------------------------------------------------- */
function showEmptyCart() {
    const fullLayout = document.getElementById('full-cart-layout');
    const emptyLayout = document.getElementById('empty-cart-layout');
    if (fullLayout && emptyLayout) {
        fullLayout.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        fullLayout.style.transform = 'translateY(15px)';
        fullLayout.style.opacity = '0';
        setTimeout(() => {
            fullLayout.style.display = 'none';
            emptyLayout.style.display = 'block';
            emptyLayout.style.opacity = '0';
            emptyLayout.style.transform = 'translateY(-15px)';
            // Trigger reflow
            void emptyLayout.offsetWidth;
            emptyLayout.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            emptyLayout.style.transform = 'translateY(0)';
            emptyLayout.style.opacity = '1';
        }, 400);
    }
}

/* --------------------------------------------------------
   CANVAS BIOLUMINESCENT RIBBON FLOW (nền sóng cực quang neon)
   -------------------------------------------------------- */
(function() {
    const canvas = document.getElementById('cart-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let W, H;
    let time = 0;

    // Hủy các listener cũ của Cart nếu có
    if (window.cartCanvasCleanup) {
        window.cartCanvasCleanup();
    }

    function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
    }
    const onMouseMove = (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    };

    window.addEventListener('resize', resize);
    window.addEventListener('mousemove', onMouseMove);

    window.cartCanvasCleanup = function() {
        window.removeEventListener('resize', resize);
        window.removeEventListener('mousemove', onMouseMove);
    };

    resize();

    // Định nghĩa các dải sóng ruy băng cực quang phát sáng
    const ribbons = [
        {
            yPercent: 0.3,
            amplitude: 45,
            frequency: 0.0015,
            speed: 0.015,
            pointsCount: 300,
            baseColor: '56, 189, 248' // màu cyan/sky-blue
        },
        {
            yPercent: 0.5,
            amplitude: 60,
            frequency: 0.001,
            speed: 0.01,
            pointsCount: 350,
            baseColor: '139, 92, 246' // màu tím purple
        },
        {
            yPercent: 0.7,
            amplitude: 50,
            frequency: 0.002,
            speed: 0.02,
            pointsCount: 250,
            baseColor: '236, 72, 153' // màu hồng neon
        }
    ];

    let mouseX = -1000, mouseY = -1000;

    function drawRibbon(rb) {
        const centerY = H * rb.yPercent;
        
        ctx.beginPath();
        for (let i = 0; i <= rb.pointsCount; i++) {
            const x = (W / rb.pointsCount) * i;
            
            let waveY = Math.sin(x * rb.frequency + time * rb.speed) * rb.amplitude;
            waveY += Math.cos(x * (rb.frequency * 1.5) - time * (rb.speed * 0.8)) * (rb.amplitude * 0.4);
            
            const dx = x - mouseX;
            const dy = (centerY + waveY) - mouseY;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 150) {
                const push = (150 - dist) * 0.25;
                waveY += mouseY > centerY + waveY ? -push : push;
            }
            
            const y = centerY + waveY;
            
            if (i === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
            
            if (i % 3 === 0) {
                ctx.save();
                ctx.beginPath();
                ctx.arc(x, y, Math.random() * 1.5 + 0.5, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${rb.baseColor}, ${Math.random() * 0.35 + 0.15})`;
                ctx.shadowBlur = 8;
                ctx.shadowColor = `rgb(${rb.baseColor})`;
                ctx.fill();
                ctx.restore();
            }
        }
        
        ctx.save();
        ctx.strokeStyle = `rgba(${rb.baseColor}, 0.08)`;
        ctx.lineWidth = 4;
        ctx.shadowBlur = 15;
        ctx.shadowColor = `rgb(${rb.baseColor})`;
        ctx.stroke();
        
        ctx.strokeStyle = `rgba(${rb.baseColor}, 0.15)`;
        ctx.lineWidth = 1.5;
        ctx.stroke();
        ctx.restore();
    }

    function loop() {
        if (!canvas || !document.body.contains(canvas)) {
            if (window.cartCanvasCleanup) {
                window.cartCanvasCleanup();
                window.cartCanvasCleanup = null;
            }
            return;
        }
        ctx.clearRect(0, 0, W, H);
        time += 0.8;
        
        ribbons.forEach(drawRibbon);
        
        requestAnimationFrame(loop);
    }
    loop();
})();

// Tự động khởi chạy logic sự kiện cho giỏ hàng
if (document.readyState !== 'loading') {
    window.initCartPage();
} else {
    document.addEventListener('DOMContentLoaded', window.initCartPage);
}
</script>

<?php
// Footer của trang
include __DIR__ . '/partials/footer.php';
?>
