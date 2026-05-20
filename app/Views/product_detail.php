<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/product_detail.php
 * MÔ TẢ: Giao diện trang chi tiết sản phẩm.
 *
 * NỀN RIÊNG BIỆT: Sóng âm thanh Canvas (Ripple Waveform - màu tím/indigo)
 *   - home.php    → Nốt nhạc rơi từ trên xuống (header.php)
 *   - sanpham.php → Nốt nhạc bay từ dưới lên (#product-canvas)
 *   - product_detail.php → Vòng tròn Ripple sóng âm lan rộng từ trung tâm
 *
 * CẤU TRÚC TRANG:
 *   1. Header (navbar, preloader)
 *   2. Canvas Ripple nền
 *   3. Breadcrumb điều hướng
 *   4. Khu vực chính: Gallery trái | Thông tin phải
 *   5. Tab mô tả / thông số kỹ thuật
 *   6. Footer
 * =========================================================================
 */

// Gọi header dùng chung (chứa <html>, <head>, navbar)
include __DIR__ . '/partials/header.php';
?>

<!-- ============================================================
     CSS RIÊNG CHO TRANG CHI TIẾT SẢN PHẨM
     ============================================================ -->
<style>
/* ================================================================================
   BIẾN MÀU THEO THEME - sửa lỗi chữ tắt ở nền sáng
   ================================================================================ */
[data-theme="dark"]  { --text-muted: rgba(255,255,255,0.55); --text-faint: rgba(255,255,255,0.35); }
[data-theme="light"] { --text-muted: rgba(15,23,42,0.55);   --text-faint: rgba(15,23,42,0.35); }
[data-theme="dark"]  { --variant-btn-bg: rgba(255,255,255,0.06); --variant-btn-border: rgba(255,255,255,0.15); }
[data-theme="light"] { --variant-btn-bg: rgba(15,23,42,0.05);   --variant-btn-border: rgba(15,23,42,0.18); }

/* ================================================================================
   ẨN CANVAS NỐT NHẠC RƠI TOÀN CỤC CỦA HEADER (TRANG NÀY DÙNG NỀN RIÊNG)
   ================================================================================ */
#particle-canvas {
    display: none !important;
}

/* ================================================================================
   PHẦN 1: CANVAS NỀN GLOWING MELODY CONSTELLATION (ĐẶC TRƯNG TRANG CHI TIẾT)
   Hiệu ứng: Các nốt nhạc phát sáng bay lơ lửng, liên kết bằng đường nối
   khi ở gần nhau (<150px) tạo mạng tinh thể mờ ảo. Chuột đẩy nhẹ hạt ra xa.
   ================================================================================ */

/* Canvas cố định toàn màn hình, z-index âm để nằm dưới nội dung */
#detail-canvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: -1;
    pointer-events: none;
}

/* ================================================================================
   PHẦN 2: BREADCRUMB ĐIỀU HƯỚNG
   ================================================================================ */
.detail-breadcrumb {
    padding: 16px 0;
    margin-bottom: 8px;
}

.detail-breadcrumb a {
    color: var(--text-muted);   /* ✅ theo theme */
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.2s;
}

.detail-breadcrumb a:hover {
    color: #8b5cf6; /* Tím - đồng bộ với theme ripple canvas */
}

.detail-breadcrumb .separator {
    margin: 0 8px;
    opacity: 0.4;
    font-size: 0.85rem;
}

.detail-breadcrumb .current {
    color: #a78bfa; /* Tím sáng */
    font-size: 0.85rem;
    font-weight: 600;
}

/* ================================================================================
   PHẦN 3: GALLERY ẢNH SẢN PHẨM (CỘT TRÁI)
   ================================================================================ */

/* Container tổng của gallery - giúp hình ảnh dính mượt mà khi cuộn trang */
@media (min-width: 992px) {
    .product-gallery {
        position: -webkit-sticky;
        position: sticky;
        top: 110px; /* Khoảng cách cách header */
        align-self: start; /* Cần thiết để không bị sê dịch hoặc nhảy giật khi cuộn */
    }
}

/* Khung ảnh chính lớn */
.main-image-frame {
    background: linear-gradient(135deg,
        rgba(139, 92, 246, 0.08),
        rgba(99, 102, 241, 0.06));
    border: 1px solid rgba(139, 92, 246, 0.2);
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    height: 420px;
    margin-bottom: 12px;
}

/* Ảnh chính */
#main-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
}

#main-product-image:hover {
    transform: scale(1.04);
}

/* Badge trạng thái đặt trên ảnh */
.image-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 5;
}

.image-badge.rent {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    color: #000;
}

.image-badge.in-stock {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.image-badge.low-stock {
    background: rgba(239, 68, 68, 0.9);
    color: white;
    animation: badgePulse 2s infinite;
}

@keyframes badgePulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Dãy thumbnail ảnh màu sắc phía dưới */
.thumbnail-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* Mỗi ô thumbnail */
.thumb-item {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.25s ease;
    flex-shrink: 0;
}

.thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Thumbnail đang được chọn */
.thumb-item.active {
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.3);
}

.thumb-item:hover {
    border-color: rgba(139, 92, 246, 0.5);
    transform: scale(1.08);
}

/* ================================================================================
   PHẦN 4: THÔNG TIN SẢN PHẨM (CỘT PHẢI)
   ================================================================================ */

/* Card thông tin chính */
.product-info-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 32px;
    backdrop-filter: blur(10px);
}

/* Thương hiệu */
.detail-brand {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #8b5cf6;  /* Tím - đồng bộ canvas */
    margin-bottom: 10px;
}

/* Tên sản phẩm */
.detail-name {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--text-color);
    line-height: 1.3;
    margin-bottom: 16px;
}

/* Khu vực giá */
.price-section {
    background: linear-gradient(135deg,
        rgba(139, 92, 246, 0.08),
        rgba(99, 102, 241, 0.05));
    border: 1px solid rgba(139, 92, 246, 0.15);
    border-radius: 14px;
    padding: 18px 20px;
    margin-bottom: 22px;
}

/* Giá bán chính */
.detail-price {
    font-size: 2rem;
    font-weight: 900;
    color: #8b5cf6;   /* Tím để khác với trang sanpham (xanh) */
    display: flex;
    align-items: baseline;
    gap: 6px;
}

.detail-price .currency {
    font-size: 1.1rem;
    font-weight: 700;
}

/* Giá thuê/ngày */
.rent-price {
    font-size: 0.9rem;
    color: #f59e0b;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ================================================================================
   PHẦN 5: CHỌN BIẾN THỂ (MÀU SẮC & PHIÊN BẢN)
   ================================================================================ */

.variant-section {
    margin-bottom: 20px;
}

/* Nhãn tiêu đề mỗi nhóm - dùng --text-muted theo theme */
.variant-section-label {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--text-muted);   /* ✅ theo theme */
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Dòng chứa các nút chọn */
.variant-section-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* Nút chọn màu / phiên bản - nền và viền theo theme */
.detail-variant-btn {
    padding: 8px 18px;
    background: var(--variant-btn-bg);       /* ✅ theo theme */
    border: 1px solid var(--variant-btn-border); /* ✅ theo theme */
    border-radius: 10px;
    color: var(--text-color);               /* ✅ theo theme */
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    gap: 7px;
}

.detail-variant-btn:hover {
    border-color: rgba(139, 92, 246, 0.6);
    background: rgba(139, 92, 246, 0.15);
    color: var(--text-color);
}

/* Nút đang được chọn */
.detail-variant-btn.selected {
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
}

/* Chấm màu nhỏ trong nút chọn màu - viền theo theme */
.color-dot-lg {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 1px solid var(--text-faint);    /* ✅ theo theme */
    flex-shrink: 0;
}

/* ================================================================================
   PHẦN 6: SỐ LƯỢNG VÀ NÚT MUA
   ================================================================================ */

/* Khu vực chọn số lượng */
.qty-wrapper {
    display: flex;
    align-items: center;
    gap: 0;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    width: fit-content;
}

.qty-btn {
    width: 40px;
    height: 44px;
    background: rgba(139, 92, 246, 0.1);
    border: none;
    color: var(--text-color);
    font-size: 1.2rem;
    cursor: pointer;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-btn:hover {
    background: rgba(139, 92, 246, 0.25);
}

/* Input số lượng */
#qty-input {
    width: 56px;
    height: 44px;
    text-align: center !important;
    border: none;
    background: transparent;
    color: var(--text-color);
    font-size: 1.1rem;
    font-weight: 700;
    outline: none;
    line-height: 44px !important;
    padding: 0 !important;
    -moz-appearance: textfield !important; /* Ẩn nút mũi tên trên Firefox */
}
/* Ẩn nút mũi tên (spin button) trên Chrome/Safari/Edge */
#qty-input::-webkit-outer-spin-button,
#qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none !important;
    margin: 0 !important;
}

/* Nút Thêm vào giỏ hàng */
.btn-detail-cart {
    flex: 1;
    padding: 14px;
    background: linear-gradient(135deg, #7c3aed, #8b5cf6, #a78bfa);
    border: none;
    border-radius: 14px;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-detail-cart:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.45);
}

/* Nút Thuê nhạc cụ (chỉ hiện khi is_rentable = 1) */
.btn-detail-rent {
    padding: 14px 20px;
    background: transparent;
    border: 2px solid #f59e0b;
    border-radius: 14px;
    color: #f59e0b;
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-detail-rent:hover {
    background: #f59e0b;
    color: #000;
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4);
}

/* ================================================================================
   PHẦN 7: TÍNH TRẢ GÓP
   ================================================================================ */

/* Card trả góp thu gọn */
.installment-card {
    background: rgba(139, 92, 246, 0.06);
    border: 1px solid rgba(139, 92, 246, 0.15);
    border-radius: 14px;
    padding: 18px;
    margin-top: 20px;
}

.installment-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #a78bfa;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Select chọn số tháng trả góp */
.installment-select {
    background: var(--bg-color);
    border: 1px solid rgba(139, 92, 246, 0.3);
    border-radius: 10px;
    color: var(--text-color);
    padding: 8px 12px;
    font-size: 0.9rem;
    width: 100%;
    cursor: pointer;
    outline: none;
    margin-bottom: 10px;
}

/* Kết quả tính trả góp */
.installment-result {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9rem;
}

.installment-monthly {
    font-size: 1.3rem;
    font-weight: 800;
    color: #8b5cf6;
}

/* ================================================================================
   PHẦN 8: TAB MÔ TẢ / THÔNG SỐ KỸ THUẬT
   ================================================================================ */

.detail-tabs {
    margin-top: 50px;
}

/* Nav tab tùy chỉnh */
.detail-tab-nav {
    display: flex;
    gap: 0;
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 28px;
}

/* Mỗi tab - chữ theo theme */
.detail-tab-btn {
    padding: 14px 28px;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    color: var(--text-muted);   /* ✅ theo theme */
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.25s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.detail-tab-btn:hover {
    color: #a78bfa;
}

/* Tab đang active */
.detail-tab-btn.active {
    color: #8b5cf6;
    border-bottom-color: #8b5cf6;
}

/* Nội dung tab */
.tab-content-panel {
    display: none;
    animation: fadeInTab 0.35s ease;
}

.tab-content-panel.active {
    display: block;
}

@keyframes fadeInTab {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Nội dung mô tả - chữ theo theme */
.description-content {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 28px;
    line-height: 1.8;
    color: var(--text-color);   /* ✅ theo theme */
    font-size: 0.95rem;
}

/* Bảng thông số kỹ thuật */
.specs-table {
    width: 100%;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
}

.specs-table tr:not(:last-child) {
    border-bottom: 1px solid var(--border-color);
}

.specs-table td {
    padding: 14px 20px;
    font-size: 0.9rem;
}

.specs-table td:first-child {
    color: var(--text-muted);   /* ✅ theo theme */
    font-weight: 600;
    width: 40%;
    background: rgba(139, 92, 246, 0.04);
}

.specs-table td:last-child {
    color: var(--text-color);
}
</style>

<!-- Canvas nền Ripple Sóng Âm - RIÊNG của trang chi tiết -->
<canvas id="detail-canvas"></canvas>

<!-- ============================================================
     NỘI DUNG CHÍNH TRANG CHI TIẾT
     ============================================================ -->
<div class="container my-5 pt-2">

    <!-- BREADCRUMB: Điều hướng trang hiện tại -->
    <nav class="detail-breadcrumb">
        <!-- Link về trang chủ -->
        <a href="index.php?controller=home">
            <i class="fas fa-home"></i> Trang chủ
        </a>
        <span class="separator">/</span>

        <!-- Link về cửa hàng -->
        <a href="index.php?controller=product&action=index">Cửa hàng</a>
        <span class="separator">/</span>

        <!-- Tên sản phẩm hiện tại (không phải link) -->
        <?php
        /*
         * htmlspecialchars() chuyển các ký tự đặc biệt (<, >, ", &) thành
         * HTML entity an toàn, tránh lỗi XSS khi tên SP chứa ký tự lạ.
         * $product được truyền từ ProductController::detail()
         */
        ?>
        <span class="current"><?= htmlspecialchars($product['name']) ?></span>
    </nav>

    <!-- ============================================================
         PHẦN CHÍNH: 2 CỘT (GALLERY | THÔNG TIN)
         ============================================================ -->
    <div class="row g-4">

        <!-- =======================
             CỘT TRÁI: GALLERY ẢNH
             ======================= -->
        <div class="col-lg-5">
            <div class="product-gallery">

                <!-- KHUNG ẢNH CHÍNH -->
                <div class="main-image-frame">
                    <?php
                    /*
                     * Hiển thị badge trạng thái kho hàng dựa vào cột 'stock'
                     * - stock = 0     → "Hết hàng" (đỏ)
                     * - stock <= 5    → "Còn 5 sản phẩm" (vàng/cảnh báo)
                     * - stock > 5     → "Còn hàng" (xanh)
                     */
                    if ($product['stock'] <= 0): ?>
                        <span class="image-badge low-stock">
                            <i class="fas fa-times-circle"></i> Hết hàng
                        </span>
                    <?php elseif ($product['stock'] <= 5): ?>
                        <span class="image-badge low-stock">
                            <i class="fas fa-exclamation-triangle"></i>
                            Còn <?= $product['stock'] ?> sản phẩm
                        </span>
                    <?php else: ?>
                        <span class="image-badge in-stock">
                            <i class="fas fa-check-circle"></i> Còn hàng
                        </span>
                    <?php endif; ?>

                    <?php
                    /*
                     * Hiển thị badge "Cho thuê" nếu is_rentable = 1 (tinyint trong DB)
                     * Đặt thêm ở góc phải phía dưới để không đè lên badge stock
                     */
                    if ($product['is_rentable']): ?>
                        <span class="image-badge rent" style="left: auto; right: 16px; top: 16px;">
                            <i class="fas fa-calendar-alt"></i> Cho thuê
                        </span>
                    <?php endif; ?>

                    <!-- Ảnh chính (thay đổi khi chọn màu sắc) -->
                    <img
                        id="main-product-image"
                        src="<?= htmlspecialchars($product['image'] ?? 'https://via.placeholder.com/600x400') ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>"
                        loading="lazy"
                    >
                </div>

                <?php
                /*
                 * THUMBNAIL ẢNH THEO MÀU SẮC
                 * Nếu sản phẩm có biến thể màu sắc ($colors), hiển thị dãy
                 * thumbnail để người dùng click chuyển ảnh chính.
                 * $colors được truyền từ Controller (mảng lấy từ DB)
                 */
                if (!empty($colors)): ?>
                <div class="thumbnail-row">
                    <!-- Thumbnail đầu tiên: ảnh mặc định của sản phẩm -->
                    <div class="thumb-item active" id="thumb-default"
                         onclick="switchImage('<?= htmlspecialchars($product['image'] ?? '') ?>', this)">
                        <img src="<?= htmlspecialchars($product['image'] ?? '') ?>"
                             alt="Mặc định">
                    </div>

                    <?php
                    /*
                     * Vòng lặp tạo thumbnail cho từng màu sắc.
                     * $c['image_url'] → ảnh riêng của màu đó (nếu có)
                     * $c['name']      → tên màu (VD: "Sunburst", "Black")
                     * Nếu không có ảnh riêng thì dùng ảnh chính của SP
                     */
                    foreach ($colors as $c): ?>
                        <div class="thumb-item"
                             id="thumb-<?= htmlspecialchars($c['name']) ?>"
                             onclick="switchImage('<?= htmlspecialchars($c['image_url'] ?? $product['image'] ?? '') ?>', this)"
                             title="<?= htmlspecialchars($c['name']) ?>">
                            <img src="<?= htmlspecialchars($c['image_url'] ?? $product['image'] ?? '') ?>"
                                 alt="<?= htmlspecialchars($c['name']) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div><!-- /.product-gallery -->
        </div><!-- /.col-lg-5 -->

        <!-- =======================
             CỘT PHẢI: THÔNG TIN
             ======================= -->
        <div class="col-lg-7">
            <div class="product-info-card">

                <!-- THƯƠNG HIỆU & TÊN -->
                <div class="detail-brand">
                    <i class="fas fa-tag"></i>
                    <?= htmlspecialchars($product['brand'] ?? 'Khác') ?>
                </div>
                <h1 class="detail-name"><?= htmlspecialchars($product['name']) ?></h1>

                <!-- KHU VỰC GIÁ -->
                <div class="price-section">
                    <?php
                    /*
                     * number_format($price, 0, ',', '.') → định dạng tiền VNĐ
                     * Ví dụ: 18500000 → "18.500.000"
                     * - Tham số 2 (0): không lấy số thập phân
                     * - Tham số 3 (','): dấu phân thập
                     * - Tham số 4 ('.'): dấu phân nghìn
                     */
                    ?>
                    <div class="detail-price">
                        <?= number_format($product['price'], 0, ',', '.') ?>
                        <span class="currency">₫</span>
                    </div>

                    <?php
                    /*
                     * Chỉ hiển thị giá thuê nếu is_rentable=1 VÀ rent_price_day không null
                     * && (AND) → cả hai điều kiện phải đúng
                     */
                    if ($product['is_rentable'] && $product['rent_price_day']): ?>
                        <div class="rent-price">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Giá thuê:</span>
                            <strong><?= number_format($product['rent_price_day'], 0, ',', '.') ?>₫/ngày</strong>
                            <?php if ($product['deposit_price']): ?>
                                <span class="ms-2" style="opacity: 0.7;">
                                    · Cọc: <?= number_format($product['deposit_price'], 0, ',', '.') ?>₫
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php
                /*
                 * PHẦN CHỌN MÀU SẮC
                 * Chỉ render HTML nếu mảng $colors có phần tử (không rỗng)
                 * !empty() trả về true khi mảng có ít nhất 1 phần tử
                 */
                if (!empty($colors)): ?>
                <div class="variant-section">
                    <div class="variant-section-label">
                        <i class="fas fa-palette"></i>
                        Màu sắc
                        <!-- Hiển thị màu đang chọn bên cạnh nhãn -->
                        <span id="selected-color-name" style="color: #a78bfa; font-weight: 700; margin-left: 4px;"></span>
                    </div>
                    <div class="variant-section-options" id="color-options">
                        <?php foreach ($colors as $c): ?>
                            <button
                                class="detail-variant-btn color-btn"
                                data-color="<?= htmlspecialchars($c['name']) ?>"
                                data-image="<?= htmlspecialchars($c['image_url'] ?? $product['image'] ?? '') ?>"
                                onclick="selectColor(this)"
                            >
                                <!-- Chấm màu tròn nhỏ, màu lấy từ cột 'value' trong DB -->
                                <span class="color-dot-lg"
                                      style="background: <?= htmlspecialchars($c['value'] ?? '#888') ?>">
                                </span>
                                <?= htmlspecialchars($c['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php
                /*
                 * PHẦN CHỌN PHIÊN BẢN
                 * Tương tự màu sắc, chỉ hiện khi có dữ liệu trong $versions
                 */
                if (!empty($versions)): ?>
                <div class="variant-section">
                    <div class="variant-section-label">
                        <i class="fas fa-layer-group"></i>
                        Phiên bản
                        <span id="selected-version-name" style="color: #a78bfa; font-weight: 700; margin-left: 4px;"></span>
                    </div>
                    <div class="variant-section-options" id="version-options">
                        <?php foreach ($versions as $v): ?>
                            <button
                                class="detail-variant-btn version-btn"
                                data-version="<?= htmlspecialchars($v['name']) ?>"
                                onclick="selectVersion(this)"
                            >
                                <?= htmlspecialchars($v['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- SỐ LƯỢNG & NÚT HÀNH ĐỘNG -->
                <div class="d-flex align-items-center gap-3 mt-3 mb-4">
                    <!-- Chọn số lượng -->
                    <div class="qty-wrapper">
                        <!-- Nút giảm (-) -->
                        <button class="qty-btn" onclick="changeQty(-1)" title="Giảm số lượng">−</button>
                        <!-- Input số lượng, min=1 để không âm -->
                        <input type="number" id="qty-input" value="1" min="1"
                               max="<?= (int)$product['stock'] ?>">
                        <!-- Nút tăng (+) -->
                        <button class="qty-btn" onclick="changeQty(1)" title="Tăng số lượng">+</button>
                    </div>

                    <!-- Hiển thị tồn kho còn lại -->
                    <span style="font-size: 0.8rem; color: rgba(255,255,255,0.4);">
                        <i class="fas fa-boxes"></i>
                        Còn <?= (int)$product['stock'] ?> sản phẩm
                    </span>
                </div>

                <!-- NÚT MUA / THUÊ -->
                <div class="d-flex gap-3">
                    <!-- Nút Thêm vào giỏ (luôn hiển thị) -->
                    <button class="btn-detail-cart" id="btn-add-to-cart"
                            data-product-id="<?= (int)$product['id'] ?>"
                            onclick="addToCart(<?= (int)$product['id'] ?>)">
                        <i class="bx bx-cart-add" style="font-size: 1.3rem;"></i>
                        Thêm vào giỏ hàng
                    </button>

                    <?php
                    /*
                     * Nút THUÊ chỉ hiển thị nếu sản phẩm có is_rentable = 1
                     * Điều kiện PHP: if ($product['is_rentable'])
                     * Giá trị 1 trong PHP được coi là true, 0 là false
                     */
                    if ($product['is_rentable']): ?>
                        <button class="btn-detail-rent"
                                onclick="openRentModal(<?= (int)$product['id'] ?>)">
                            <i class="fas fa-calendar-check"></i>
                            Thuê ngay
                        </button>
                    <?php endif; ?>
                </div>

                <!-- TÍNH TRẢ GÓP -->
                <?php
                /*
                 * Chỉ hiển thị tính trả góp nếu giá sản phẩm >= 5 triệu
                 * (Trả góp không hợp lý với SP giá rẻ)
                 */
                if ($product['price'] >= 5000000): ?>
                <div class="installment-card">
                    <div class="installment-title">
                        <i class="fas fa-credit-card"></i>
                        Tính trả góp 0% lãi suất
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <!-- Select số tháng trả góp -->
                            <select class="installment-select" id="installment-months"
                                    onchange="calcInstallment()">
                                <option value="3">3 tháng</option>
                                <option value="6" selected>6 tháng</option>
                                <option value="12">12 tháng</option>
                                <option value="24">24 tháng</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="installment-result">
                                <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">Mỗi tháng:</span>
                                <!-- Giá trị được tính bằng JS -->
                                <span class="installment-monthly" id="installment-price">
                                    <?= number_format($product['price'] / 6, 0, ',', '.') ?>₫
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- THÔNG TIN GIAO HÀNG (luôn hiển thị) -->
                <div class="d-flex gap-4 mt-4 pt-3" style="border-top: 1px solid var(--border-color);">
                    <div class="text-center">
                        <i class="fas fa-shipping-fast" style="color: #8b5cf6; font-size: 1.3rem;"></i>
                        <div style="font-size: 0.75rem; margin-top: 4px; opacity: 0.7;">Giao hỏa tốc</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-shield-alt" style="color: #8b5cf6; font-size: 1.3rem;"></i>
                        <div style="font-size: 0.75rem; margin-top: 4px; opacity: 0.7;">Bảo hành 1 năm</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-undo" style="color: #8b5cf6; font-size: 1.3rem;"></i>
                        <div style="font-size: 0.75rem; margin-top: 4px; opacity: 0.7;">Đổi trả 30 ngày</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-headset" style="color: #8b5cf6; font-size: 1.3rem;"></i>
                        <div style="font-size: 0.75rem; margin-top: 4px; opacity: 0.7;">Tư vấn 24/7</div>
                    </div>
                </div>

            </div><!-- /.product-info-card -->
        </div><!-- /.col-lg-7 -->
    </div><!-- /.row -->

    <!-- ============================================================
         PHẦN PHÍA DƯỚI: TAB MÔ TẢ & THÔNG SỐ KỸ THUẬT
         ============================================================ -->
    <div class="detail-tabs">
        <!-- Nav Tab -->
        <div class="detail-tab-nav">
            <button class="detail-tab-btn active" onclick="switchTab('desc', this)">
                <i class="fas fa-align-left"></i> Mô tả sản phẩm
            </button>
            <button class="detail-tab-btn" onclick="switchTab('specs', this)">
                <i class="fas fa-list-ul"></i> Thông số kỹ thuật
            </button>
        </div>

        <!-- Tab Mô tả -->
        <div class="tab-content-panel active" id="tab-desc">
            <div class="description-content">
                <?php
                /*
                 * nl2br() chuyển ký tự xuống dòng (\n) trong DB
                 * thành thẻ <br> để hiển thị đúng trên trình duyệt.
                 * htmlspecialchars() vẫn được gọi trước để chống XSS.
                 */
                echo nl2br(htmlspecialchars($product['description'] ?? 'Chưa có mô tả cho sản phẩm này.'));
                ?>
            </div>
        </div>

        <!-- Tab Thông số kỹ thuật -->
        <div class="tab-content-panel" id="tab-specs">
            <table class="specs-table">
                <tbody>
                    <?php
                    /*
                     * Bảng thông số được xây dựng từ dữ liệu sản phẩm trong DB.
                     * Mỗi dòng kiểm tra !empty() trước khi render để không
                     * hiển thị các dòng "trống" thiếu thông tin.
                     */
                    ?>
                    <tr>
                        <td>Thương hiệu</td>
                        <td><?= htmlspecialchars($product['brand'] ?? '—') ?></td>
                    </tr>
                    <tr>
                        <td>Danh mục</td>
                        <td><?= htmlspecialchars($product['category_name'] ?? '—') ?></td>
                    </tr>
                    <tr>
                        <td>Tình trạng kho</td>
                        <td>
                            <?php
                            // Hiển thị trạng thái kho với màu sắc tương ứng
                            if ($product['stock'] <= 0): ?>
                                <span style="color: #ef4444; font-weight: 600;">
                                    <i class="fas fa-times-circle"></i> Hết hàng
                                </span>
                            <?php elseif ($product['stock'] <= 5): ?>
                                <span style="color: #f59e0b; font-weight: 600;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Còn <?= (int)$product['stock'] ?> sản phẩm (sắp hết)
                                </span>
                            <?php else: ?>
                                <span style="color: #10b981; font-weight: 600;">
                                    <i class="fas fa-check-circle"></i>
                                    Còn hàng (<?= (int)$product['stock'] ?> sản phẩm)
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Giá bán</td>
                        <td style="color: #8b5cf6; font-weight: 700; font-size: 1.05rem;">
                            <?= number_format($product['price'], 0, ',', '.') ?>₫
                        </td>
                    </tr>
                    <?php if ($product['is_rentable']): ?>
                    <tr>
                        <td>Giá thuê / ngày</td>
                        <td style="color: #f59e0b; font-weight: 600;">
                            <?= number_format($product['rent_price_day'], 0, ',', '.') ?>₫
                        </td>
                    </tr>
                    <tr>
                        <td>Tiền cọc thuê</td>
                        <td><?= number_format($product['deposit_price'] ?? 0, 0, ',', '.') ?>₫</td>
                    </tr>
                    <?php endif; ?>
                    <?php if (!empty($colors)): ?>
                    <tr>
                        <td>Màu sắc có sẵn</td>
                        <td>
                            <?php
                            /*
                             * array_column($colors, 'name') lấy ra mảng chỉ gồm cột 'name'
                             * implode(', ', ...) nối các phần tử mảng bằng dấu phẩy
                             * Kết quả: "Sunburst, Black, Natural"
                             */
                            echo htmlspecialchars(implode(', ', array_column($colors, 'name')));
                            ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if (!empty($versions)): ?>
                    <tr>
                        <td>Phiên bản</td>
                        <td><?= htmlspecialchars(implode(', ', array_column($versions, 'name'))) ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.detail-tabs -->

</div><!-- /.container -->

<!-- ============================================================
     JAVASCRIPT TRANG CHI TIẾT SẢN PHẨM
     ============================================================ -->
<script>
/* ================================================================================
   PHẦN 1: CANVAS GLOWING MELODY CONSTELLATION - NỀN RIÊNG TRANG CHI TIẾT
   Cơ chế: Các nốt nhạc phát sáng bay lơ lửng ngẫu nhiên. Khi khoảng cách
   giữa 2 hạt < 150px, vẽ đường nối liên kết phát sáng mờ ảo dạng mạng
   tinh thể (constellation). Di chuột gần đẩy nhẹ hạt ra xa (repel effect).
   Màu sắc: Dải tím-indigo (#7c3aed → #6366f1 → #a78bfa)
   ================================================================================ */
(function() {
    const canvas = document.getElementById('detail-canvas');
    if (!canvas) return; // Thoát an toàn nếu canvas không tồn tại

    const ctx = canvas.getContext('2d');
    let width, height;

    // Vị trí chuột hiện tại (để tính lực đẩy repel)
    const mouse = { x: null, y: null, radius: 150 };

    // Mảng ký tự nốt nhạc để random gán cho mỗi hạt
    const musicSymbols = ['♪', '♫', '♬', '♩', '🎵', '🎶', '🎼'];

    // Mảng lưu tất cả các hạt (nodes) đang hoạt động
    let particles = [];

    // Khoảng cách tối đa để vẽ đường nối giữa 2 hạt
    const LINK_DISTANCE = 150;

    // Số lượng hạt (vừa phải để không rối mắt trên trang chi tiết)
    const PARTICLE_COUNT = 50;

    /**
     * Resize canvas theo kích thước cửa sổ
     * Quan trọng: phải gọi khi window resize để tránh vẽ sai tọa độ
     */
    function resizeCanvas() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas(); // Gọi ngay lập tức khi khởi động

    // Lắng nghe vị trí chuột để tính lực đẩy (repel)
    window.addEventListener('mousemove', function(e) {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });

    // Reset vị trí chuột khi rời khỏi cửa sổ
    window.addEventListener('mouseout', function() {
        mouse.x = null;
        mouse.y = null;
    });

    /**
     * CLASS MusicNode: Đại diện một nốt nhạc phát sáng trong mạng lưới
     * - x, y: Tọa độ hiện tại (bay lơ lửng ngẫu nhiên)
     * - baseX, baseY: Tọa độ gốc (dùng để kéo về khi hết repel)
     * - vx, vy: Vận tốc di chuyển (px/frame)
     * - size: Kích thước ký tự nốt nhạc
     * - symbol: Ký tự nốt nhạc ngẫu nhiên
     * - hue: Màu sắc HSL (dao động trong dải tím 250-290)
     * - glowRadius: Bán kính vầng sáng xung quanh nốt nhạc
     * - pulsePhase: Pha nhịp đập (để hiệu ứng nhấp nháy nhẹ lệch nhau)
     */
    class MusicNode {
        constructor() {
            // Vị trí khởi tạo ngẫu nhiên
            this.x = Math.random() * width;
            this.y = Math.random() * height;

            // Lưu vị trí gốc ban đầu
            this.baseX = this.x;
            this.baseY = this.y;

            // Vận tốc bay nhẹ nhàng (di chuyển rất chậm)
            this.vx = (Math.random() - 0.5) * 0.6;
            this.vy = (Math.random() - 0.5) * 0.6;

            // Kích thước nốt nhạc (px)
            this.size = Math.random() * 10 + 12;

            // Random ký tự nốt nhạc
            this.symbol = musicSymbols[Math.floor(Math.random() * musicSymbols.length)];

            // Dải màu tím-indigo: HSL hue 250-290
            this.hue = Math.floor(Math.random() * 40) + 250;

            // Bán kính vầng sáng phát ra xung quanh
            this.glowRadius = Math.random() * 20 + 15;

            // Pha nhịp đập lệch nhau (mỗi hạt nhấp nháy khác thời điểm)
            this.pulsePhase = Math.random() * Math.PI * 2;

            // Độ sáng cơ bản (dao động nhẹ)
            this.baseOpacity = Math.random() * 0.3 + 0.4;
        }

        update() {
            // Di chuyển theo vận tốc hiện tại
            this.x += this.vx;
            this.y += this.vy;

            // Nảy lại khi chạm rìa màn hình (bounce effect)
            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;

            // Giữ trong phạm vi màn hình
            this.x = Math.max(0, Math.min(width, this.x));
            this.y = Math.max(0, Math.min(height, this.y));

            // ============================================================
            // TƯƠNG TÁC: LỰC ĐẨY (REPEL) KHI CHUỘT ĐẾN GẦN
            // Khi khoảng cách hạt-chuột < mouse.radius (150px):
            //   Tính vector hướng từ chuột → hạt, đẩy hạt ra xa.
            //   Lực đẩy tỉ lệ nghịch với khoảng cách (càng gần càng mạnh)
            // ============================================================
            if (mouse.x !== null && mouse.y !== null) {
                const dx = this.x - mouse.x;
                const dy = this.y - mouse.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < mouse.radius) {
                    // Cường độ đẩy: gần hơn → mạnh hơn
                    const force = (mouse.radius - dist) / mouse.radius;
                    const angle = Math.atan2(dy, dx);

                    // Đẩy hạt ra xa theo hướng ngược con trỏ chuột
                    this.x += Math.cos(angle) * force * 5;
                    this.y += Math.sin(angle) * force * 5;
                }
            }

            // Cập nhật pha nhịp đập (để vầng sáng nhấp nháy)
            this.pulsePhase += 0.02;
        }

        draw() {
            // Tính opacity nhấp nháy theo sin wave
            const pulse = Math.sin(this.pulsePhase) * 0.15 + this.baseOpacity;

            ctx.save();

            // ============================================================
            // VẼ VẦNG SÁNG (GLOW) XUNG QUANH NỐT NHẠC
            // Dùng radialGradient tạo hiệu ứng phát sáng mờ ảo
            // ============================================================
            const gradient = ctx.createRadialGradient(
                this.x, this.y, 0,
                this.x, this.y, this.glowRadius
            );
            gradient.addColorStop(0, `hsla(${this.hue}, 80%, 70%, ${pulse * 0.4})`);
            gradient.addColorStop(0.5, `hsla(${this.hue}, 70%, 60%, ${pulse * 0.15})`);
            gradient.addColorStop(1, `hsla(${this.hue}, 60%, 50%, 0)`);

            ctx.beginPath();
            ctx.arc(this.x, this.y, this.glowRadius, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();

            // ============================================================
            // VẼ KÝ TỰ NỐT NHẠC Ở TÂM
            // ============================================================
            ctx.font = `${this.size}px serif`;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = `hsla(${this.hue}, 75%, 75%, ${pulse})`;
            ctx.fillText(this.symbol, this.x, this.y);

            ctx.restore();
        }
    }

    // Khởi tạo các hạt nốt nhạc ban đầu
    for (let i = 0; i < PARTICLE_COUNT; i++) {
        particles.push(new MusicNode());
    }

    /**
     * VẼ ĐƯỜNG NỐI GIỮA CÁC HẠT GẦN NHAU (CONSTELLATION LINES)
     * Duyệt từng cặp hạt, nếu khoảng cách < LINK_DISTANCE:
     * - Vẽ đường nối mỏng, độ đậm giảm dần theo khoảng cách
     * - Tạo hiệu ứng mạng lưới tinh thể phát sáng mờ ảo
     */
    function drawConstellationLinks() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const a = particles[i];
                const b = particles[j];

                // Tính khoảng cách Euclid giữa 2 hạt
                const dx = a.x - b.x;
                const dy = a.y - b.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                // Chỉ vẽ đường nối nếu đủ gần
                if (dist < LINK_DISTANCE) {
                    // Opacity giảm dần khi xa hơn (fade effect tự nhiên)
                    const opacity = (1 - dist / LINK_DISTANCE) * 0.25;

                    // Màu trung bình giữa 2 hạt
                    const avgHue = (a.hue + b.hue) / 2;

                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.strokeStyle = `hsla(${avgHue}, 60%, 65%, ${opacity})`;
                    ctx.lineWidth = 0.8;
                    ctx.stroke();
                }
            }
        }
    }

    /**
     * Vòng lặp hoạt hình chính
     * requestAnimationFrame đảm bảo chạy ~60fps mượt mà
     * và tự dừng khi tab mất focus (tiết kiệm CPU)
     */
    function animate() {
        // Xóa toàn bộ canvas mỗi frame
        ctx.clearRect(0, 0, width, height);

        // Vẽ đường nối trước (nằm phía sau các nốt nhạc)
        drawConstellationLinks();

        // Cập nhật và vẽ từng nốt nhạc
        particles.forEach(p => {
            p.update();
            p.draw();
        });

        // Lên lịch frame tiếp theo
        requestAnimationFrame(animate);
    }

    animate(); // Bắt đầu vòng lặp
})(); // IIFE: tự gọi để không leak biến ra ngoài

/* ================================================================================
   PHẦN 2: CHUYỂN ẢNH CHỦ KHI CLICK THUMBNAIL
   ================================================================================ */

/**
 * Hàm switchImage: Chuyển ảnh chính khi click thumbnail
 * @param {string} src - URL ảnh mới
 * @param {HTMLElement} thumbEl - Phần tử thumbnail được click
 */
function switchImage(src, thumbEl) {
    // Lấy thẻ img chính và cập nhật src
    const mainImg = document.getElementById('main-product-image');
    if (mainImg && src) {
        mainImg.style.opacity = '0'; // Fade out
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1'; // Fade in
        }, 200);
    }

    // Bỏ class active khỏi tất cả thumbnail, thêm vào cái vừa click
    document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
    if (thumbEl) thumbEl.classList.add('active');
}

/* ================================================================================
   PHẦN 3: CHỌN MÀU SẮC & PHIÊN BẢN
   ================================================================================ */

/**
 * Chọn màu sắc: highlight nút và đổi ảnh chính + thumbnail tương ứng
 * @param {HTMLElement} btn - Nút màu được click
 */
function selectColor(btn) {
    // Bỏ selected khỏi tất cả nút màu
    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('selected'));

    // Thêm selected vào nút vừa click
    btn.classList.add('selected');

    // Cập nhật tên màu đang chọn hiển thị bên cạnh nhãn
    const nameEl = document.getElementById('selected-color-name');
    if (nameEl) nameEl.textContent = '– ' + btn.dataset.color;

    // Chuyển ảnh chính sang ảnh của màu này
    const imgSrc = btn.dataset.image;
    if (imgSrc) {
        const mainImg = document.getElementById('main-product-image');
        if (mainImg) {
            mainImg.style.opacity = '0';
            setTimeout(() => {
                mainImg.src = imgSrc;
                mainImg.style.opacity = '1';
            }, 200);
        }

        // Đồng bộ active trên thumbnail tương ứng
        document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
        const matchThumb = document.getElementById('thumb-' + btn.dataset.color);
        if (matchThumb) matchThumb.classList.add('active');
    }
}

/**
 * Chọn phiên bản: chỉ highlight nút, không đổi ảnh
 * @param {HTMLElement} btn - Nút phiên bản được click
 */
function selectVersion(btn) {
    document.querySelectorAll('.version-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');

    const nameEl = document.getElementById('selected-version-name');
    if (nameEl) nameEl.textContent = '– ' + btn.dataset.version;
}

/* ================================================================================
   PHẦN 4: ĐIỀU KHIỂN SỐ LƯỢNG
   ================================================================================ */

/**
 * Tăng / giảm số lượng sản phẩm
 * @param {number} delta - +1 hoặc -1
 */
function changeQty(delta) {
    const input = document.getElementById('qty-input');
    if (!input) return;

    const current = parseInt(input.value) || 1;
    const max = parseInt(input.max) || 999;
    const newVal = Math.min(max, Math.max(1, current + delta));
    input.value = newVal;

    // Cập nhật giá trả góp khi số lượng thay đổi
    calcInstallment();
}

/* ================================================================================
   PHẦN 5: TÍNH TRẢ GÓP
   ================================================================================ */

/**
 * Tính và hiển thị tiền trả góp mỗi tháng
 * Công thức: Giá SP / Số tháng (trả góp 0% không có lãi suất)
 */
function calcInstallment() {
    const select = document.getElementById('installment-months');
    const resultEl = document.getElementById('installment-price');
    if (!select || !resultEl) return;

    // Giá gốc lấy từ PHP (embed vào JS dưới dạng số nguyên)
    const price = <?= (float)$product['price'] ?>;
    const months = parseInt(select.value) || 6;
    const qty = parseInt(document.getElementById('qty-input')?.value) || 1;

    // Tính tiền mỗi tháng (làm tròn lên đến nghìn đồng)
    const monthly = Math.ceil((price * qty) / months / 1000) * 1000;

    // Format và hiển thị (dùng Intl.NumberFormat để định dạng VNĐ)
    resultEl.textContent = new Intl.NumberFormat('vi-VN').format(monthly) + '₫';
}

/* ================================================================================
   PHẦN 6: CHUYỂN TAB MÔ TẢ / THÔNG SỐ
   ================================================================================ */

/**
 * Chuyển tab (Mô tả / Thông số kỹ thuật)
 * @param {string} tabId - ID của tab cần hiển thị ('desc' hoặc 'specs')
 * @param {HTMLElement} btnEl - Nút tab được click
 */
function switchTab(tabId, btnEl) {
    // Ẩn tất cả tab content
    document.querySelectorAll('.tab-content-panel').forEach(p => p.classList.remove('active'));

    // Bỏ active khỏi tất cả nút tab
    document.querySelectorAll('.detail-tab-btn').forEach(b => b.classList.remove('active'));

    // Hiển thị tab được chọn
    const panel = document.getElementById('tab-' + tabId);
    if (panel) panel.classList.add('active');

    // Highlight nút tab đang active
    if (btnEl) btnEl.classList.add('active');
}

/* ================================================================================
   PHẦN 7: THÊM VÀO GIỎ HÀNG (AJAX)
   ================================================================================ */

/**
 * Thêm sản phẩm vào giỏ hàng bằng AJAX (không reload trang)
 * @param {number} productId - ID sản phẩm
 */
function addToCart(productId) {
    const qty = parseInt(document.getElementById('qty-input')?.value) || 1;
    const selectedColor = document.querySelector('.color-btn.selected')?.dataset.color || '';
    const selectedVersion = document.querySelector('.version-btn.selected')?.dataset.version || '';
    const btn = document.getElementById('btn-add-to-cart');

    // Hiệu ứng loading trên nút
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
    }

    // Gửi AJAX request đến CartController
    fetch('index.php?controller=cart&action=add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            product_id: productId,
            quantity: qty,
            color: selectedColor,
            version: selectedVersion,
            csrf_token: '<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>'
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Thành công: Cập nhật badge giỏ hàng trên navbar
            const cartBadge = document.getElementById('cart-count');
            if (cartBadge) cartBadge.textContent = data.cart_count;

            // Hiệu ứng thành công trên nút
            if (btn) {
                btn.innerHTML = '<i class="fas fa-check"></i> Đã thêm vào giỏ!';
                btn.style.background = 'linear-gradient(135deg, #10b981, #34d399)';
                // Reset sau 2 giây
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bx bx-cart-add" style="font-size:1.3rem"></i> Thêm vào giỏ hàng';
                    btn.style.background = '';
                }, 2000);
            }
        } else {
            alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="bx bx-cart-add" style="font-size:1.3rem"></i> Thêm vào giỏ hàng';
            }
        }
    })
    .catch(() => {
        // Lỗi mạng hoặc server
        alert('Không thể kết nối. Vui lòng thử lại.');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-cart-add" style="font-size:1.3rem"></i> Thêm vào giỏ hàng';
        }
    });
}

/**
 * Mở modal thuê nhạc cụ (placeholder - sẽ implement ở đợt sau)
 * @param {number} productId - ID sản phẩm cần thuê
 */
function openRentModal(productId) {
    // TODO: Implement modal chọn ngày thuê (sẽ làm ở đợt phát triển tiếp theo)
    alert('Tính năng thuê nhạc cụ đang được phát triển. Vui lòng liên hệ 1900 1000 để được hỗ trợ!');
}

// Khởi tạo: tính trả góp ngay khi trang load
calcInstallment();

// Thêm CSS transition cho ảnh chính (fade effect)
document.getElementById('main-product-image')?.setAttribute(
    'style',
    'transition: opacity 0.2s ease; width: 100%; height: 100%; object-fit: cover;'
);
</script>

<?php
// Gọi footer (chứa </body>, </html>, Bootstrap JS, Modal đăng nhập)
include __DIR__ . '/partials/footer.php';
?>
