<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/sanpham.php
 * MÔ TẢ: Trang hiển thị danh sách sản phẩm với bộ lọc nâng cao,
 * Infinite Scroll trong khung riêng, và card sản phẩm tương tác.
 * SỬ DỤNG: header.php và footer.php
 * =========================================================================
 */
include __DIR__ . '/partials/header.php';
?>

<style>
/* ================================================================================
   BIẾN MÀU BỔ SUNG THEO THEME (sửa lỗi chữ tắt ở nền sáng)
   Vấn đề: rgba(255,255,255,...) cứng → tắt khi nền sáng
   Giải pháp: dùng biến CSS tự động đổi theo data-theme
   ================================================================================ */

/* Màu chữ phụ (mờ hơn text chính) */
[data-theme="dark"]  { --text-muted: rgba(255,255,255,0.55); --text-faint: rgba(255,255,255,0.35); }
[data-theme="light"] { --text-muted: rgba(15,23,42,0.55);   --text-faint: rgba(15,23,42,0.35); }

/* Nền nút biến thể (màu/phiên bản) */
[data-theme="dark"]  { --variant-btn-bg: rgba(255,255,255,0.07); --variant-btn-border: rgba(255,255,255,0.14); }
[data-theme="light"] { --variant-btn-bg: rgba(15,23,42,0.06);   --variant-btn-border: rgba(15,23,42,0.18); }

/* ================================================================================
   PHẦN 1: CSS CHO BỘ LỌC NÂNG CAO (ADVANCED FILTER SIDEBAR)
   ================================================================================ */

/* Sidebar lọc và Danh mục */
.filter-sidebar, .category-sidebar {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    backdrop-filter: blur(10px);
}

.category-sidebar {
    position: relative;
    top: auto;
    z-index: 1;
}

.category-sidebar .list-group-item {
    transition: all 0.3s ease;
    border-radius: 8px !important;
    margin-bottom: 4px;
}

.category-sidebar .list-group-item:hover {
    background: rgba(59, 130, 246, 0.1) !important;
    color: #3b82f6 !important;
    padding-left: 15px !important;
}

.category-sidebar .list-group-item.text-primary {
    background: rgba(59, 130, 246, 0.15) !important;
}

.filter-sidebar {
    position: relative;
    top: auto;
}

/* Toggle button cho bộ lọc */
.filter-toggle-btn {
    width: 100%;
    padding: 12px 16px;
    background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(139,92,246,0.15));
    border: 1px solid rgba(59,130,246,0.3);
    border-radius: 12px;
    color: var(--text-color);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    transition: all 0.3s;
    margin-bottom: 12px;
}

.filter-toggle-btn:hover {
    background: linear-gradient(135deg, rgba(59,130,246,0.25), rgba(139,92,246,0.25));
    border-color: rgba(59,130,246,0.5);
}

.filter-toggle-btn .toggle-icon {
    transition: transform 0.3s ease;
    font-size: 0.8rem;
    color: #60a5fa;
}

.filter-toggle-btn.open .toggle-icon {
    transform: rotate(180deg);
}

/* Collapsible filter body */
.filter-collapsible {
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.4s ease, opacity 0.3s ease;
    opacity: 0;
}

.filter-collapsible.open {
    max-height: 1200px;
    opacity: 1;
}

.filter-sidebar::-webkit-scrollbar {
    width: 4px;
}

.filter-sidebar::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 4px;
}

/* Tiêu đề mỗi nhóm lọc */
.filter-group {
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
}

.filter-group:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.filter-title {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-color);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-title i {
    color: #3b82f6;
    font-size: 0.9rem;
}

/* Checkbox tùy chỉnh */
.filter-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.25s ease;
    margin-bottom: 6px;
}

.filter-checkbox:hover {
    background: rgba(59, 130, 246, 0.08);
}

.filter-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #3b82f6;
    cursor: pointer;
}

.filter-checkbox span {
    font-size: 0.9rem;
    color: var(--text-color);
    transition: color 0.25s;
}

.filter-checkbox:hover span {
    color: #3b82f6;
}

/* Khoảng giá - Range Slider */
.price-range-container {
    padding: 5px 0;
}

.price-inputs {
    display: flex;
    gap: 10px;
    margin-bottom: 12px;
}

.price-input-wrapper {
    flex: 1;
    position: relative;
}

.price-input-wrapper label {
    display: block;
    font-size: 0.75rem;
    color: rgba(255,255,255,0.6);
    margin-bottom: 4px;
}

.price-input {
    width: 100%;
    padding: 10px 12px 10px 35px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-color);
    color: var(--text-color);
    font-size: 0.85rem;
    transition: border-color 0.25s;
}

.price-input:focus {
    outline: none;
    border-color: #3b82f6;
}

.price-input-wrapper .currency-symbol {
    position: absolute;
    left: 12px;
    bottom: 10px;
    color: rgba(255,255,255,0.5);
    font-size: 0.85rem;
}

/* Range Slider kép */
.price-slider {
    position: relative;
    height: 6px;
    background: var(--border-color);
    border-radius: 3px;
    margin: 15px 0;
}

.price-slider-fill {
    position: absolute;
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #60a5fa);
    border-radius: 3px;
    left: 0%;
    right: 0%;
}

.price-slider input[type="range"] {
    position: absolute;
    width: 100%;
    height: 6px;
    background: transparent;
    pointer-events: none;
    -webkit-appearance: none;
    top: 0;
    left: 0;
}

.price-slider input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    background: #fff;
    border: 3px solid #3b82f6;
    border-radius: 50%;
    cursor: pointer;
    pointer-events: auto;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
    transition: transform 0.2s;
}

.price-slider input[type="range"]::-webkit-slider-thumb:hover {
    transform: scale(1.2);
}

.price-display {
    text-align: center;
    font-size: 0.9rem;
    font-weight: 600;
    color: #3b82f6;
    margin-top: 8px;
}

/* Nút Áp dụng / Xóa bộ lọc */
.filter-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.btn-apply-filter {
    flex: 1;
    padding: 12px;
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.btn-apply-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}

.btn-clear-filter {
    padding: 12px 16px;
    background: transparent;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    color: var(--text-color);
    font-weight: 500;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.25s;
}

.btn-clear-filter:hover {
    border-color: #ef4444;
    color: #ef4444;
    background: rgba(239, 68, 68, 0.05);
}

/* Badge hiển thị bộ lọc đang active */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: rgba(59, 130, 246, 0.15);
    border: 1px solid rgba(59, 130, 246, 0.3);
    border-radius: 20px;
    font-size: 0.8rem;
    color: #60a5fa;
    animation: fadeIn 0.3s ease;
}

.filter-tag .remove-tag {
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.filter-tag .remove-tag:hover {
    opacity: 1;
}

/* ================================================================================
   PHẦN 2: CSS CHO KHUNG SẢN PHẨM - INFINITE SCROLL TRONG KHUNG RIÊNG
   ================================================================================ */

/* Container bao bọc toàn bộ khu vực sản phẩm */
.products-frame {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    /* Chiều cao tối đa = 100vh - navbar - some padding */
    max-height: calc(100vh - 140px);
}

/* Lớp phủ mờ dần ở viền dưới (Fade effect) */
.products-frame::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 120px;
    background: linear-gradient(to top, var(--card-bg) 0%, transparent 100%);
    pointer-events: none;
    z-index: 10;
    opacity: 0;
    transition: opacity 0.4s;
}

.products-frame.is-scrolling::after {
    opacity: 1;
}

/* Vùng cuộn chính - Scroll theo chiều dọc trong khung riêng */
.products-scroll-container {
    height: calc(100vh - 140px);
    overflow-y: auto;
    overflow-x: hidden;
    padding: 24px;
    scroll-behavior: smooth;
    scrollbar-width: thin;
    scrollbar-color: var(--border-color) transparent;
}

.products-scroll-container::-webkit-scrollbar {
    width: 6px;
}

.products-scroll-container::-webkit-scrollbar-track {
    background: transparent;
}

.products-scroll-container::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 3px;
}

/* Grid hiển thị sản phẩm - 3 cột */
.products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    padding-bottom: 40px;
    align-items: stretch;
}

/* Đảm bảo product-item stretch để các card đều nhau */
.product-item {
    display: flex;
    height: 100%;
}

.product-wrapper {
    width: 100%;
    flex: 1;
    position: relative;
    perspective: 1000px;
}

/* Responsive: 2 cột trên tablet, 1 cột trên mobile */
@media (max-width: 1200px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .products-grid {
        grid-template-columns: 1fr;
    }
}

/* ================================================================================
   PHẦN 3: CSS CHO CARD SẢN PHẨM - HOVER HIỆN MÀU/LOẠI ĐỔI HÌNH
   ================================================================================ */

/* Card sản phẩm chính */
.product-card {
    background: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
}

/* Khi hover vào wrapper -> card nổi lên */
.product-wrapper:hover .product-card {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(59, 130, 246, 0.5);
}

/* Container chứa hình ảnh sản phẩm */
.product-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(139, 92, 246, 0.05));
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Zoom nhẹ khi hover */
.product-wrapper:hover .product-image {
    transform: scale(1.08);
}

/* Badge trạng thái (Cho thuê / Còn hàng) */
.product-badges {
    position: absolute;
    top: 12px;
    left: 12px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 5;
}

.badge-rent {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    color: #000;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-stock {
    background: rgba(16, 185, 129, 0.9);
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

.badge-stock.low {
    background: rgba(239, 68, 68, 0.9);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* ================================================================================
   PHẦN 3A: PANEL CHỌN MÀU SẮC - HIỆN LUÔN TRÊN CARD
   ================================================================================ */

/* Card không bị overflow:hidden để chiều cao tự nhiên */
.product-card {
    overflow: visible !important;
}

/* Bỏ overflow hidden ở image container vẫn cần giữ */
.product-image-container {
    overflow: hidden !important;
    border-radius: 16px 16px 0 0;
}

/* Panel màu sắc - hiện luôn, in-flow */
.variant-panel {
    margin: 0 -16px;
    padding: 10px 16px;
    background: linear-gradient(135deg,
        rgba(59, 130, 246, 0.07),
        rgba(139, 92, 246, 0.04));
    border-top: 1px solid rgba(59, 130, 246, 0.18);
    border-bottom: 1px solid rgba(59, 130, 246, 0.18);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* Tiêu đề nhóm tùy chọn - dùng --text-muted theo theme */
.variant-label {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);   /* ✅ tự đổi theo dark/light */
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Container chứa các nút chọn màu/loại */
.variant-options {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* Mỗi nút chọn màu/loại - nền và viền theo theme */
.variant-btn {
    padding: 6px 14px;
    background: var(--variant-btn-bg);      /* ✅ theo theme */
    border: 1px solid var(--variant-btn-border); /* ✅ theo theme */
    border-radius: 8px;
    color: var(--text-color);               /* ✅ theo theme */
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    gap: 5px;
}

.variant-btn:hover {
    background: rgba(59, 130, 246, 0.3);
    border-color: rgba(59, 130, 246, 0.5);
    color: #fff;
    transform: scale(1.05);
}

.variant-btn.selected {
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

/* Dot màu nhỏ trước text - viền theo theme */
.variant-btn .color-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 1px solid var(--text-faint);    /* ✅ theo theme */
}

/* ================================================================================
   PHẦN 4: CSS CHO THÔNG TIN SẢN PHẨM
   ================================================================================ */

/* Container thông tin sản phẩm */
.product-info {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Thương hiệu */
.product-brand {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #60a5fa;
    margin-bottom: 6px;
}

/* Tên sản phẩm */
.product-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 10px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Mô tả ngắn - dùng --text-muted theo theme */
.product-desc {
    font-size: 0.8rem;
    color: var(--text-muted);   /* ✅ theo theme */
    margin-bottom: 12px;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Container giá */
.product-pricing {
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid var(--border-color);
}

/* Giá chính */
.product-price {
    font-size: 1.25rem;
    font-weight: 800;
    color: #3b82f6;
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.product-price .currency {
    font-size: 0.85rem;
    font-weight: 600;
}

/* Giá thuê (nếu có) */
.product-rent-price {
    font-size: 0.8rem;
    color: #f59e0b;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Nút Thêm vào giỏ */
.btn-add-cart {
    width: 100%;
    padding: 12px;
    margin-top: 14px;
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-add-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.btn-add-cart i {
    font-size: 1.1rem;
}

/* ================================================================================
   PHẦN 5: LOADING & LOAD MORE
   ================================================================================ */

/* Spinner khi đang load thêm sản phẩm */
.loading-indicator {
    display: none;
    text-align: center;
    padding: 30px;
    grid-column: 1 / -1;
}

.loading-indicator.active {
    display: block;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 3px solid var(--border-color);
    border-top-color: #3b82f6;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-text {
    font-size: 0.9rem;
    color: var(--text-muted);   /* ✅ theo theme */
}

/* Nút "Xem thêm sản phẩm" */
.btn-load-more {
    display: none;
    grid-column: 1 / -1;
    text-align: center;
    padding: 20px;
}

.btn-load-more.active {
    display: block;
}

.btn-load-more-inner {
    padding: 14px 40px;
    background: transparent;
    border: 2px solid #3b82f6;
    border-radius: 30px;
    color: #3b82f6;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-load-more-inner:hover {
    background: #3b82f6;
    color: white;
    transform: scale(1.05);
}

/* Animation fadeIn cho sản phẩm mới load */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-item-new {
    animation: fadeInUp 0.5s ease forwards;
}

/* ================================================================================
   PHẦN 6: ANIMATION NỀN CHO TRANG SẢN PHẨM (KHÁC TRANG CHỦ)
   ================================================================================ */

/* Canvas particles cho trang sản phẩm */
#product-canvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: -1;
    pointer-events: none;
}
</style>

<!-- Canvas cho animation nền riêng của trang sản phẩm -->
<canvas id="product-canvas"></canvas>

<div class="container my-5 pt-4">
    <!-- Tiêu đề trang - Đặt ở trên cùng, căn giữa -->
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="font-size: 2rem; background: linear-gradient(135deg, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <i class="fas fa-music me-2" style="-webkit-text-fill-color: #3b82f6;"></i>Cửa hàng nhạc cụ
        </h2>
        <p class="text-muted mb-0">
            <?= isset($totalProducts) ? $totalProducts : 0 ?> sản phẩm
            <?php if(!empty($currentKeyword)): ?>
                - Tìm kiếm: "<strong><?= htmlspecialchars($currentKeyword) ?></strong>"
            <?php endif; ?>
            <?php if(!empty($currentCategory)): ?>
                - Danh mục: "<strong><?= htmlspecialchars($categories[$currentCategory]['name'] ?? '') ?></strong>"
            <?php endif; ?>
        </p>
    </div>

    <div class="row">
        <!-- ================================================================= -->
        <!-- CỘT TRÁI: DANH MỤC & BỘ LỌC -->
        <!-- ================================================================= -->
        <div class="col-lg-3 mb-4">
            <!-- 1. PHẦN DANH MỤC -->
            <div class="category-sidebar">
                <div class="filter-title mb-3">
                    <i class="fas fa-th-large"></i> Danh mục
                </div>
                <div class="list-group list-group-flush bg-transparent">
                    <a href="#" data-category="" 
                       class="category-link list-group-item list-group-item-action bg-transparent border-0 px-0 py-2 <?= empty($currentCategory) ? 'text-primary fw-bold' : 'text-white-50' ?>">
                        <i class="fas fa-chevron-right me-2 small"></i>Tất cả nhạc cụ
                    </a>
                    <?php
                    if (isset($categories) && is_array($categories)) {
                        foreach ($categories as $cat) {
                            $isActive = ($currentCategory ?? null) == $cat['id'];
                            $activeClass = $isActive ? 'text-primary fw-bold' : 'text-white-50';
                            echo '<a href="#" data-category="' . $cat['id'] . '"';
                            echo ' class="category-link list-group-item list-group-item-action bg-transparent border-0 px-0 py-2 ' . $activeClass . '">';
                            echo '<i class="' . $cat['icon'] . ' me-2"></i>' . $cat['name'];
                            echo '</a>';
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- 2. PHẦN BỘ LỌC NÂNG CAO -->
            <form id="filter-form" method="GET" action="index.php">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="index">
                <input type="hidden" name="category" id="filter-category" value="<?= $currentCategory ?? '' ?>">

                <div class="filter-sidebar">
                    <!-- Nút toggle bộ lọc -->
                    <button type="button" class="filter-toggle-btn" id="filter-toggle-btn">
                        <span><i class="fas fa-sliders-h me-2 text-primary"></i>Bộ lọc nâng cao
                            <span id="active-filter-count" class="badge bg-primary rounded-pill ms-2" style="display:none;">0</span>
                        </span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    <!-- TÌM KIẾM THEO TÊN - luôn hiển thị -->
                    <div class="filter-group" style="margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid var(--border-color);">
                        <div class="filter-title">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </div>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-transparent border-secondary text-white" 
                                   placeholder="Tên nhạc cụ..." 
                                   value="<?= htmlspecialchars($currentKeyword ?? '') ?>">
                        </div>
                    </div>

                    <!-- Các bộ lọc thu gọn -->
                    <div class="filter-collapsible" id="filter-collapsible">

                    <!-- ========================================================= -->
                    <!-- NHÓM 3: KHOẢNG GIÁ -->
                    <!-- ========================================================= -->
                    <div class="filter-group">
                        <div class="filter-title">
                            <i class="fas fa-tag"></i> Khoảng giá
                        </div>
                        <div class="price-range-container">
                            <div class="price-inputs">
                                <div class="price-input-wrapper">
                                    <span class="currency-symbol">₫</span>
                                    <label>Từ</label>
                                    <input type="number" name="price_min" class="price-input" 
                                           placeholder="0" 
                                           value="<?= $currentPriceMin ?? '' ?>">
                                </div>
                                <div class="price-input-wrapper">
                                    <span class="currency-symbol">₫</span>
                                    <label>Đến</label>
                                    <input type="number" name="price_max" class="price-input" 
                                           placeholder="100,000,000" 
                                           value="<?= $currentPriceMax ?? '' ?>">
                                </div>
                            </div>
                            <div class="price-slider">
                                <div class="price-slider-fill" id="price-slider-fill"></div>
                                <input type="range" id="price-range-max" min="0" max="100000000" step="1000000" value="<?= $currentPriceMax ?? 100000000 ?>">
                            </div>
                            <div class="price-display" id="price-display">
                                <?php
                                // Hiển thị khoảng giá đã chọn
                                $min = isset($currentPriceMin) ? number_format((float)$currentPriceMin, 0, ',', '.') : '0';
                                $max = isset($currentPriceMax) ? number_format((float)$currentPriceMax, 0, ',', '.') : '100M+';
                                echo $min . ' ₫ - ' . $max . ' ₫';
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================= -->
                    <!-- NHÓM 4: THƯƠNG HIỆU -->
                    <!-- ========================================================= -->
                    <div class="filter-group">
                        <div class="filter-title">
                            <i class="fas fa-star"></i> Thương hiệu
                        </div>
                        <?php
                        // Lặp qua danh sách thương hiệu để render checkbox
                        if (isset($brands) && is_array($brands)) {
                            foreach ($brands as $b) {
                                $isChecked = ($currentBrand ?? '') === $b ? 'checked' : '';
                                echo '<label class="filter-checkbox">';
                                echo '<input type="checkbox" name="brand" value="' . $b . '" ' . $isChecked . '>';
                                echo '<span>' . $b . '</span>';
                                echo '</label>';
                            }
                        }
                        ?>
                    </div>

                    <!-- ========================================================= -->
                    <!-- NHÓM 5: TÌNH TRẠNG KHO -->
                    <!-- ========================================================= -->
                    <div class="filter-group">
                        <div class="filter-title">
                            <i class="fas fa-boxes"></i> Tình trạng
                        </div>
                        <label class="filter-checkbox">
                            <input type="checkbox" name="in_stock" value="1" <?= ($currentInStock ?? null) == 1 ? 'checked' : '' ?>>
                            <span>Chỉ còn hàng (<?php echo isset($totalProducts) ? $totalProducts : 0; ?>)</span>
                        </label>
                    </div>

                    <!-- ========================================================= -->
                    <!-- NHÓM 6: CHO THUÊ -->
                    <!-- ========================================================= -->
                    <div class="filter-group">
                        <div class="filter-title">
                            <i class="fas fa-clock"></i> Loại
                        </div>
                        <label class="filter-checkbox">
                            <input type="checkbox" name="is_rentable" value="1" <?= ($currentIsRentable ?? null) == 1 ? 'checked' : '' ?>>
                            <span>Có cho thuê</span>
                        </label>
                    </div>

                    <!-- Nút xóa tất cả lọc -->
                    <a href="#" class="btn-clear-filter w-100 mb-3 text-center" id="clear-all-filters" style="display: none;">
                        <i class="fas fa-times me-2"></i>Xóa tất cả
                    </a>

                    <!-- Nút hành động -->
                    <div class="filter-actions">
                        <button type="submit" class="btn-apply-filter">
                            <i class="fas fa-check"></i> Áp dụng
                        </button>
                    </div>

                    </div><!-- end filter-collapsible -->
                </div>
            </form>
        </div>

        <!-- ========================================================= -->
        <!-- CỘT PHẢI: KHUNG SẢN PHẨM VỚI INFINITE SCROLL -->
        <!-- ========================================================= -->
        <div class="col-lg-9">
            <!-- ========================================================= -->
            <!-- KHUNG CHỨA SẢN PHẨM - SCROLL TRONG KHUNG RIÊNG -->
            <!-- ========================================================= -->
            <div class="products-frame" id="products-frame">
                <div class="products-scroll-container" id="products-scroll">
                    <div class="products-grid" id="products-grid">
                        <?php
                        // =================================================================
                        // BƯỚC 1: KIỂM TRA CÓ SẢN PHẨM NÀO KHÔNG
                        // =================================================================
                        if (isset($products) && is_array($products) && count($products) > 0) {
                            // =================================================================
                            // BƯỚC 2: LẶP QUA TỪNG SẢN PHẨM ĐỂ HIỂN THỊ CARD
                            // =================================================================
                            foreach ($products as $index => $p) {
                                // Xác định badge tồn kho
                                $stockClass = $p['stock'] <= 3 ? 'low' : '';
                                $stockText = $p['stock'] > 0 ? 'Còn ' . $p['stock'] : 'Hết hàng';

                                // Lấy dữ liệu biến thể thật từ Database
                                $variants = $p['variants'] ?? ['colors' => [], 'versions' => []];
                                $colors = $variants['colors'];
                                $versions = $variants['versions'];
                        ?>
                                <!-- MỖI SẢN PHẨM LÀ 1 ITEM TRONG GRID -->
                                <div class="product-item" data-index="<?= $index ?>">
                                    <div class="product-wrapper">
                                        <!-- Card chính -->
                                        <div class="product-card">
                                            <!-- Hình ảnh sản phẩm - Click để vào trang chi tiết -->
                                            <a href="index.php?controller=product&action=detail&id=<?= (int)$p['id'] ?>"
                                               style="display:block; text-decoration:none;">
                                            <div class="product-image-container">
                                                <img src="<?= $p['image'] ?>" 
                                                     class="product-image" 
                                                     alt="<?= htmlspecialchars($p['name']) ?>"
                                                     data-default-image="<?= $p['image'] ?>">
                                                
                                                <!-- Badges -->
                                                <div class="product-badges">
                                                    <?php if($p['is_rentable']): ?>
                                                        <span class="badge-rent">
                                                            <i class="fas fa-clock"></i> Cho thuê
                                                        </span>
                                                    <?php endif; ?>
                                                    <span class="badge-stock <?= $stockClass ?>">
                                                        <?= $stockText ?>
                                                    </span>
                                                </div>
                                            </div>
                                            </a><!-- /link ảnh chi tiết -->

                                            <!-- Thông tin sản phẩm -->
                                            <div class="product-info">
                                                <span class="product-brand"><?= htmlspecialchars($p['brand']) ?></span>
                                                <!-- Tên SP dạng link – click vào tên cũng vào trang chi tiết -->
                                                <a href="index.php?controller=product&action=detail&id=<?= (int)$p['id'] ?>"
                                                   style="text-decoration:none; color:inherit;">
                                                    <h6 class="product-name"><?= htmlspecialchars($p['name']) ?></h6>
                                                </a>

                                                <!-- Panel chọn màu - hiện luôn, chỉ màu sắc -->
                                                <?php if(!empty($colors)): ?>
                                                <div class="variant-panel">
                                                    <div class="variant-label">
                                                        <i class="fas fa-palette"></i> Màu sắc
                                                    </div>
                                                    <div class="variant-options">
                                                        <?php foreach($colors as $c): ?>
                                                            <button class="variant-btn color-btn"
                                                                    data-color="<?= $c['name'] ?>"
                                                                    data-image="<?= $c['image_url'] ?? $p['image'] ?>">
                                                                <span class="color-dot" style="background: <?= $c['value'] ?>"></span>
                                                                <?= $c['name'] ?>
                                                            </button>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <?php endif; ?>

                                                <div class="product-pricing">
                                                    <div class="product-price">
                                                        <?= number_format($p['price'], 0, ',', '.') ?> <span class="currency">₫</span>
                                                    </div>
                                                    <?php if($p['is_rentable'] && $p['rent_price_day']): ?>
                                                        <div class="product-rent-price">
                                                            <i class="fas fa-calendar-alt"></i>
                                                            Thuê <?= number_format($p['rent_price_day'], 0, ',', '.') ?>₫/ngày
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <button class="btn-add-cart">
                                                    <i class='bx bx-cart-add'></i> Thêm vào giỏ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            } // Kết thúc vòng lặp foreach
                        } else {
                            // =================================================================
                            // BƯỚC 3: KHÔNG CÓ SẢN PHẨM NÀO PHÙ HỢP
                            // =================================================================
                            echo '<div class="col-12 text-center py-5">';
                            echo '<i class="fas fa-box-open fa-4x mb-4" style="opacity: 0.3;"></i>';
                            echo '<h5 class="text-muted">Không tìm thấy nhạc cụ nào phù hợp!</h5>';
                            echo '<p class="text-muted small">Thử thay đổi bộ lọc hoặc tìm kiếm từ khóa khác.</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <!-- Loading indicator khi load thêm sản phẩm -->
                    <div class="loading-indicator" id="loading-indicator">
                        <div class="spinner"></div>
                        <span class="loading-text">Đang tải thêm sản phẩm...</span>
                    </div>

                    <!-- Nút Xem thêm (nếu còn sản phẩm) -->
                    <?php
                    // Chỉ hiện nút xem thêm nếu chưa load hết
                    $hasMore = ($currentPage ?? 1) < ($totalPages ?? 1);
                    if ($hasMore && isset($products) && count($products) > 0):
                    ?>
                    <div class="btn-load-more active" id="load-more-section">
                        <button class="btn-load-more-inner" id="btn-load-more">
                            <i class="fas fa-plus"></i> Xem thêm sản phẩm
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * ================================================================================
 * PHẦN 1: JAVASCRIPT CHO BỘ LỌC & INFINITE SCROLL
 * ================================================================================
 */

// Biến toàn cục lưu trạng thái
let currentPage = <?= $currentPage ?? 1 ?>;
let totalPages = <?= $totalPages ?? 1 ?>;
let isLoading = false;
let currentFilters = {
    search: '<?= addslashes($currentKeyword ?? '') ?>',
    category: '<?= $currentCategory ?? '' ?>',
    price_min: '<?= $currentPriceMin ?? '' ?>',
    price_max: '<?= $currentPriceMax ?? '' ?>',
    brand: '<?= addslashes($currentBrand ?? '') ?>',
    in_stock: '<?= $currentInStock ?? '' ?>',
    is_rentable: '<?= $currentIsRentable ?? '' ?>'
};

// =================================================================
// HÀM: Build URL từ các filter hiện tại
// =================================================================
function buildFilterUrl(page = 1) {
    const params = new URLSearchParams();
    
    if (currentFilters.search) params.append('search', currentFilters.search);
    if (currentFilters.category) params.append('category', currentFilters.category);
    if (currentFilters.price_min) params.append('price_min', currentFilters.price_min);
    if (currentFilters.price_max) params.append('price_max', currentFilters.price_max);
    if (currentFilters.brand) params.append('brand', currentFilters.brand);
    if (currentFilters.in_stock) params.append('in_stock', currentFilters.in_stock);
    if (currentFilters.is_rentable) params.append('is_rentable', currentFilters.is_rentable);
    
    params.append('controller', 'product');
    params.append('action', 'index');
    params.append('page', page);
    
    return 'index.php?' + params.toString();
}

// =================================================================
// HÀM: Load sản phẩm bằng AJAX (gọi API để lấy HTML fragment)
// =================================================================
async function loadProducts(url, append = false) {
    if (isLoading) return;
    isLoading = true;
    
    const loadingIndicator = document.getElementById('loading-indicator');
    const loadMoreSection = document.getElementById('load-more-section');
    const productsGrid = document.getElementById('products-grid');
    
    if (!append) {
        // Trường hợp filter mới -> Hiển thị loading overlay
        productsGrid.style.opacity = '0.5';
    }
    
    loadingIndicator.classList.add('active');
    if (loadMoreSection) loadMoreSection.style.display = 'none';
    
    try {
        const response = await fetch(url);
        const htmlString = await response.text();
        
        // Parse HTML trả về để lấy phần products-grid
        const parser = new DOMParser();
        const doc = parser.parseFromString(htmlString, 'text/html');
        const newProductsHtml = doc.getElementById('products-grid').innerHTML;
        const newTotalPages = doc.getElementById('products-grid').dataset.totalPages;
        
        if (append) {
            // Thêm sản phẩm mới vào cuối grid ( Infinite Scroll )
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newProductsHtml;
            const newItems = tempDiv.querySelectorAll('.product-item');
            
            newItems.forEach((item, idx) => {
                item.classList.add('product-item-new');
                item.style.animationDelay = (idx * 0.1) + 's';
                productsGrid.appendChild(item);
            });
            
            // Cập nhật số trang hiện tại
            currentPage++;
        } else {
            // Thay thế toàn bộ grid (Filter mới)
            productsGrid.innerHTML = newProductsHtml;
            productsGrid.scrollTop = 0;
        }
        
        // Cập nhật totalPages
        if (newTotalPages) {
            totalPages = parseInt(newTotalPages);
        }
        
        // Ẩn/Hiện nút Xem thêm
        if (currentPage >= totalPages && loadMoreSection) {
            loadMoreSection.style.display = 'none';
        } else if (loadMoreSection) {
            loadMoreSection.style.display = 'block';
        }
        
        // Gắn lại sự kiện hover cho card sản phẩm
        attachCardEvents();
        
        // Cập nhật URL mà không reload trang
        window.history.pushState({path: url}, '', url);
        
    } catch (error) {
        console.error('Lỗi khi tải sản phẩm:', error);
    } finally {
        isLoading = false;
        productsGrid.style.opacity = '1';
        loadingIndicator.classList.remove('active');
    }
}

// =================================================================
// HÀM: Xử lý sự kiện hover cho card (đổi hình khi chọn màu/loại)
// =================================================================
function attachCardEvents() {
    // Lấy tất cả các card sản phẩm
    const productItems = document.querySelectorAll('.product-item');
    
    productItems.forEach(item => {
        const colorBtns = item.querySelectorAll('.color-btn');
        const typeBtns = item.querySelectorAll('.type-btn');
        const productImage = item.querySelector('.product-image');
        const defaultImage = productImage?.dataset.defaultImage;
        
        // =================================================================
        // SỰ KIỆN: Click vào nút màu sắc -> Đổi hình ảnh sản phẩm
        // =================================================================
        colorBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Xóa class selected khỏi tất cả nút màu
                colorBtns.forEach(b => b.classList.remove('selected'));
                // Thêm class selected vào nút được click
                this.classList.add('selected');
                
                // Đổi hình ảnh sản phẩm
                const newImage = this.dataset.image;
                if (newImage && productImage) {
                    productImage.style.opacity = '0';
                    setTimeout(() => {
                        productImage.src = newImage;
                        productImage.style.opacity = '1';
                    }, 200);
                }
            });
        });
        
        // =================================================================
        // SỰ KIỆN: Click vào nút loại -> Highlight loại đã chọn
        // =================================================================
        typeBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Toggle class selected
                if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                } else {
                    // Xóa selected từ tất cả loại khác
                    typeBtns.forEach(b => b.classList.remove('selected'));
                    // Thêm selected vào nút này
                    this.classList.add('selected');
                }
            });
        });
    });
}

// =================================================================
// HÀM: Xử lý form filter - Submit bằng AJAX
// =================================================================
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const productsFrame = document.getElementById('products-frame');
    const productsScroll = document.getElementById('products-scroll');

    // =================================================================
    // TOGGLE BỘ LỌC
    // =================================================================
    const filterToggleBtn = document.getElementById('filter-toggle-btn');
    const filterCollapsible = document.getElementById('filter-collapsible');
    if (filterToggleBtn && filterCollapsible) {
        // Mở sẵn nếu đang có filter active
        const hasActiveFilter = currentFilters.price_min || currentFilters.price_max ||
            currentFilters.brand || currentFilters.in_stock || currentFilters.is_rentable;
        if (hasActiveFilter) {
            filterCollapsible.classList.add('open');
            filterToggleBtn.classList.add('open');
        }
        filterToggleBtn.addEventListener('click', function() {
            this.classList.toggle('open');
            filterCollapsible.classList.toggle('open');
        });
    }

    // =================================================================
    // DANH MỤC AJAX - không reload trang
    // =================================================================
    document.querySelectorAll('.category-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const catId = this.dataset.category;

            // Cập nhật active class
            document.querySelectorAll('.category-link').forEach(l => {
                l.classList.remove('text-primary', 'fw-bold');
                l.classList.add('text-white-50');
            });
            this.classList.remove('text-white-50');
            this.classList.add('text-primary', 'fw-bold');

            // Cập nhật filter category
            currentFilters.category = catId;
            currentPage = 1;

            // Sync hidden input
            const catInput = document.getElementById('filter-category');
            if (catInput) catInput.value = catId;

            loadProducts(buildFilterUrl(1), false);
        });
    });
    
    // =================================================================
    // SỰ KIỆN: Scroll trong khung sản phẩm -> Hiệu ứng fade
    // =================================================================
    if (productsScroll) {
        productsScroll.addEventListener('scroll', function() {
            const scrollTop = this.scrollTop;
            const scrollHeight = this.scrollHeight - this.clientHeight;
            
            // Thêm class is-scrolling khi đang cuộn (để hiện fade effect)
            if (scrollTop > 20) {
                productsFrame.classList.add('is-scrolling');
            } else {
                productsFrame.classList.remove('is-scrolling');
            }
            
            // =================================================================
            // INFINITE SCROLL: Khi cuộn gần đến cuối -> Tự động load thêm
            // =================================================================
            if (scrollTop >= scrollHeight - 200) {
                if (!isLoading && currentPage < totalPages) {
                    loadProducts(buildFilterUrl(currentPage + 1), true);
                }
            }
        });
    }
    
    // =================================================================
    // SỰ KIỆN: Submit form filter -> Load sản phẩm mới bằng AJAX
    // =================================================================
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Cập nhật currentFilters từ form data
            const formData = new FormData(this);
            
            currentFilters.search = formData.get('search') || '';
            currentFilters.category = formData.get('category') || '';
            currentFilters.price_min = formData.get('price_min') || '';
            currentFilters.price_max = formData.get('price_max') || '';
            currentFilters.brand = formData.get('brand') || '';
            currentFilters.in_stock = formData.get('in_stock') || '';
            currentFilters.is_rentable = formData.get('is_rentable') || '';
            
            currentPage = 1;
            
            // Load sản phẩm mới (không append)
            loadProducts(buildFilterUrl(1), false);
        });
    }
    
    // =================================================================
    // SỰ KIỆN: Nút Xem thêm -> Load thêm sản phẩm
    // =================================================================
    const btnLoadMore = document.getElementById('btn-load-more');
    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', function() {
            if (!isLoading && currentPage < totalPages) {
                loadProducts(buildFilterUrl(currentPage + 1), true);
            }
        });
    }
    
    // =================================================================
    // SỰ KIỆN: Xóa tất cả filter
    // =================================================================
    const clearAllBtn = document.getElementById('clear-all-filters');
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Reset currentFilters
            currentFilters = {
                search: '', category: '', price_min: '',
                price_max: '', brand: '', in_stock: '', is_rentable: ''
            };
            currentPage = 1;
            
            // Navigate về trang filter mặc định
            window.location.href = 'index.php?controller=product&action=index';
        });
    }
    
    // Khởi tạo sự kiện hover cho card
    attachCardEvents();
});

/**
 * ================================================================================
 * PHẦN 2: ANIMATION NỀN CHO TRANG SẢN PHẨM (KHÁC TRANG CHỦ)
 * - Hiệu ứng: Các nốt nhạc bay lượn từ dưới lên
 * - Tương tác: Rê chuột đẩy các hạt ra xa (repel effect)
 * ================================================================================
 */
class ProductCanvasAnimation {
    constructor() {
        this.canvas = document.getElementById('product-canvas');
        if (!this.canvas) return;
        
        this.ctx = this.canvas.getContext('2d');
        this.particles = [];
        this.mouse = { x: null, y: null, radius: 150 };
        this.animationId = null;
        
        this.resize();
        this.init();
        this.animate();
        
        window.addEventListener('resize', () => this.resize());
        window.addEventListener('mousemove', (e) => {
            this.mouse.x = e.clientX;
            this.mouse.y = e.clientY;
        });
    }
    
    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }
    
    // Các icon âm nhạc để random
    musicIcons = ['♪', '♫', '♬', '♩', '🎵', '🎶', '🎼'];
    
    init() {
        // Tạo 40 particles (ít hơn trang chủ để không đ distracting)
        for (let i = 0; i < 40; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: this.canvas.height + Math.random() * 200,
                size: Math.random() * 20 + 15,
                speedY: Math.random() * 0.5 + 0.2,
                speedX: (Math.random() - 0.5) * 0.3,
                rotation: Math.random() * 360,
                rotationSpeed: (Math.random() - 0.5) * 0.5,
                icon: this.musicIcons[Math.floor(Math.random() * this.musicIcons.length)],
                opacity: Math.random() * 0.15 + 0.05,
                color: this.getRandomColor()
            });
        }
    }
    
    getRandomColor() {
        // Màu xanh dương nhạt - phù hợp với theme sản phẩm
        const colors = [
            '59, 130, 246',   // Blue
            '139, 92, 246',  // Purple
            '99, 102, 241',  // Indigo
            '6, 182, 212',   // Cyan
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }
    
    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        this.particles.forEach((p, index) => {
            // Di chuyển lên trên
            p.y -= p.speedY;
            p.x += p.speedX;
            p.rotation += p.rotationSpeed;
            
            // Reset khi đi ra khỏi màn hình
            if (p.y < -50) {
                p.y = this.canvas.height + 50;
                p.x = Math.random() * this.canvas.width;
            }
            if (p.x < -50) p.x = this.canvas.width + 50;
            if (p.x > this.canvas.width + 50) p.x = -50;
            
            // =================================================================
            // TƯƠNG TÁC: Đẩy particles ra xa khi rê chuột
            // =================================================================
            if (this.mouse.x !== null && this.mouse.y !== null) {
                const dx = p.x - this.mouse.x;
                const dy = p.y - this.mouse.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < this.mouse.radius) {
                    const force = (this.mouse.radius - distance) / this.mouse.radius;
                    const angle = Math.atan2(dy, dx);
                    p.x += Math.cos(angle) * force * 3;
                    p.y += Math.sin(angle) * force * 3;
                    p.opacity = Math.min(0.3, p.opacity + force * 0.1);
                }
            }
            
            // Vẽ icon nốt nhạc
            this.ctx.save();
            this.ctx.translate(p.x, p.y);
            this.ctx.rotate(p.rotation * Math.PI / 180);
            this.ctx.font = `${p.size}px Arial`;
            this.ctx.fillStyle = `rgba(${p.color}, ${p.opacity})`;
            this.ctx.textAlign = 'center';
            this.ctx.textBaseline = 'middle';
            this.ctx.fillText(p.icon, 0, 0);
            this.ctx.restore();
        });
        
        this.animationId = requestAnimationFrame(() => this.animate());
    }
}

// Khởi tạo animation khi DOM ready
document.addEventListener('DOMContentLoaded', () => {
    new ProductCanvasAnimation();
});
</script>

<?php
// Gọi thẻ Footer vào cuối trang
include __DIR__ . '/partials/footer.php';
?>