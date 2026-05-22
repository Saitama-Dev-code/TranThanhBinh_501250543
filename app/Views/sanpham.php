<?php
/**
 * VIEW: TRANG DANH SÁCH SẢN PHẨM (CỬA HÀNG)
 * - Hiển thị danh sách sản phẩm với các tính năng lọc nâng cao.
 * - Sử dụng kiến trúc Sidebar (Sticky) và Main Content (Natural Scroll).
 * - Tích hợp AJAX để tải sản phẩm không cần load lại trang.
 */

// Lấy các tham số lọc từ URL hoặc Controller truyền xuống
$currentCategory   = $_GET['category'] ?? '';
$currentKeyword    = $_GET['search'] ?? '';
$currentPriceMin   = $_GET['price_min'] ?? '';
$currentPriceMax   = $_GET['price_max'] ?? '';
$currentBrand      = $_GET['brand'] ?? '';
$currentInStock    = $_GET['in_stock'] ?? '';
$currentIsRentable = $_GET['is_rentable'] ?? '';
$currentPage       = $_GET['page'] ?? 1;

// Gọi Header
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
   PHẦN 1: CSS CHO BỐ CỤC MỚI (SIDEBAR 280PX + MAIN)
   Khắc phục triệt để lỗi đè và lệch bộ lọc khi người dùng cuộn trang.
   ================================================================================ */

.shop-layout {
    display: flex;
    gap: 30px;
    align-items: flex-start;
    max-width: 1400px; /* Tăng độ rộng tối đa */
    margin: 0 auto;
}

.shop-sidebar {
    width: 300px; /* Tăng nhẹ sidebar để bớt chật */
    flex-shrink: 0;
    position: sticky;
    top: 90px;
    max-height: calc(100vh - 110px);
    overflow-y: auto;
    padding-right: 15px;
    z-index: 100;
}

/* Ẩn thanh cuộn của sidebar nhưng vẫn cuộn được mượt */
.shop-sidebar::-webkit-scrollbar {
    width: 5px;
}
.shop-sidebar::-webkit-scrollbar-thumb {
    background: rgba(59, 130, 246, 0.3);
    border-radius: 10px;
}

.sidebar-box {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 20px;
    backdrop-filter: blur(25px); /* Tăng blur cho sang */
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
}

/* Hiệu ứng viền sáng cho sidebar box */
.sidebar-box::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.4), transparent);
}

.filter-group {
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(59, 130, 246, 0.1);
}
.filter-group:last-child { border-bottom: none; }

.filter-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #3b82f6;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.filter-checkbox-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.filter-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: 0.88rem;
    color: var(--text-color);
    opacity: 0.7;
    transition: all 0.3s;
    padding: 4px;
    border-radius: 6px;
}
.filter-checkbox:hover { 
    opacity: 1; 
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}
.filter-checkbox input {
    width: 18px;
    height: 18px;
    accent-color: #3b82f6;
    border-radius: 4px;
}

.price-inputs {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 20px;
}

.price-input-wrapper label {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--text-muted);
    margin-bottom: 6px;
    display: block;
}

.price-input {
    background: rgba(15, 23, 42, 0.3);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 12px;
    color: #fff;
    font-weight: 600;
    transition: all 0.3s;
    /* Ẩn hoàn toàn nút tăng giảm thô sơ (spin button) */
    -moz-appearance: textfield;
}

.price-input::-webkit-outer-spin-button,
.price-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.price-slider {
    position: relative;
    width: 100%;
    height: 6px;
    background: rgba(59, 130, 246, 0.15);
    border-radius: 3px;
    margin-bottom: 15px;
    margin-top: 15px;
}

.price-slider-fill {
    position: absolute;
    top: 0; left: 0;
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #60a5fa);
    border-radius: 3px;
    pointer-events: none;
}

.price-slider input[type="range"] {
    position: absolute;
    top: -6px; left: 0;
    width: 100%;
    height: 18px;
    -webkit-appearance: none;
    background: transparent;
    cursor: pointer;
    margin: 0;
}

.price-slider input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #3b82f6;
    border: 3px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    cursor: pointer;
}

.price-slider input[type="range"]::-moz-range-thumb {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #3b82f6;
    border: 3px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    cursor: pointer;
}

.price-display {
    text-align: center;
    font-size: 0.85rem;
    font-weight: 700;
    color: #3b82f6;
    padding: 8px 0;
}

.btn-apply-filter {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    transition: all 0.3s;
}
.btn-apply-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
}

.btn-clear-filter {
    width: 100%;
    padding: 12px;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 12px;
    color: #ef4444;
    font-weight: 600;
    margin-top: 10px;
    transition: all 0.3s;
}
.btn-clear-filter:hover {
    background: #ef4444;
    color: #fff;
}

.search-row-sidebar {
    display: flex;
    gap: 8px;
    align-items: center;
}

.search-input-sidebar {
    flex: 1;
    width: 100%;
    box-sizing: border-box;
    padding: 10px 14px;
    background: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    color: var(--text-color);
    font-size: 0.88rem;
    transition: border-color 0.25s;
}
.search-input-sidebar:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}
.search-input-sidebar::placeholder {
    color: var(--text-muted);
}

.btn-search-sidebar {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    border: none;
    border-radius: 10px;
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s;
    flex-shrink: 0;
}
.btn-search-sidebar:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59,130,246,0.3);
}

/* Nút bật bộ lọc nâng cao */
.btn-filter-toggle-sidebar {
    padding: 12px 16px;
    background: var(--variant-btn-bg);
    border: 1px solid var(--variant-btn-border);
    border-radius: 12px;
    color: var(--text-color);
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.25s;
    width: 100%;
}
.btn-filter-toggle-sidebar:hover,
.btn-filter-toggle-sidebar.open {
    background: linear-gradient(135deg, rgba(59,130,246,0.1), rgba(139,92,246,0.1));
    border-color: rgba(59,130,246,0.4);
    color: #3b82f6;
}
.btn-filter-toggle-sidebar .chevron {
    transition: transform 0.3s;
    font-size: 0.8rem;
    color: #60a5fa;
}
.btn-filter-toggle-sidebar.open .chevron {
    transform: rotate(180deg);
}

/* Panel bộ lọc nâng cao trong sidebar */
.filter-panel-sidebar {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    padding: 0 18px;
    border-width: 0;
    margin-bottom: 0;
    transition: max-height 0.45s cubic-bezier(0.4, 0, 0.2, 1),
                opacity 0.35s ease,
                padding 0.35s ease,
                border-width 0.1s ease,
                margin-bottom 0.3s ease;
}
.filter-panel-sidebar.open {
    max-height: 1200px;
    opacity: 1;
    padding: 18px;
    border-width: 1px;
    margin-bottom: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Link danh mục theo theme */
.cat-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--text-muted);
    transition: all 0.25s ease;
    margin-bottom: 2px;
    cursor: pointer;
}
.cat-link:hover { background:rgba(59,130,246,0.1); color:#3b82f6; padding-left:16px; }
.cat-link.active { background:rgba(59,130,246,0.12); color:#3b82f6; font-weight:700; }
.cat-link i { font-size:0.85rem; width:16px; text-align:center; flex-shrink:0; }

/* Grid hiển thị sản phẩm - 3 cột */
.shop-products-main {
    flex: 1;
    min-width: 0;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    padding-bottom: 40px;
}

/* Responsive */
@media (max-width: 1200px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 992px) {
    .shop-layout { flex-direction: column; }
    .shop-sidebar { width: 100%; position: static; max-height: none; }
}
@media (max-width: 576px) {
    .products-grid { grid-template-columns: 1fr; }
}

/* ================================================================================
   PHẦN 2: CSS CHO CARD SẢN PHẨM - HOVER HIỆN MÀU/LOẠI ĐỔI HÌNH
   ================================================================================ */

/* Card sản phẩm chính */
.product-item {
    height: 100%;
}

.product-wrapper {
    height: 100%;
}

.product-card {
    background: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden !important; 
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.4s ease;
    position: relative;
    transform-style: flat; /* Ngăn chặn các hiệu ứng sticky lạ nếu có */
}

.product-wrapper:hover .product-card {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(59, 130, 246, 0.5);
}

.product-image-container {
    position: relative;
    height: 200px;
    overflow: hidden !important;
    border-radius: 16px 16px 0 0;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(139, 92, 246, 0.05));
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.product-wrapper:hover .product-image {
    transform: scale(1.08);
}

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

.variant-panel {
    margin: 0;
    padding: 10px 0;
    background: transparent;
    border: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.variant-label {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.variant-options {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.variant-btn {
    padding: 6px 14px;
    background: var(--variant-btn-bg);
    border: 1px solid var(--variant-btn-border);
    border-radius: 8px;
    color: var(--text-color);
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

.variant-btn .color-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 1px solid var(--text-faint);
}

.product-info {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-brand {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #60a5fa;
    margin-bottom: 6px;
}

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

.product-pricing {
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid var(--border-color);
}

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

/* ================================================================================
   PHẦN 3: LOADING & LOAD MORE
   ================================================================================ */

.loading-indicator {
    display: none;
    text-align: center;
    padding: 30px;
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

.btn-load-more {
    display: none;
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

/* Canvas background */
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

    <!-- TIÊU ĐỀ TRANG -->
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="font-size:2rem; background:linear-gradient(135deg,#3b82f6,#60a5fa); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
            <i class="fas fa-music me-2"></i> SHOP NHẠC CỤ TTB
        </h2>
        <p class="text-muted">Khám phá những giai điệu tuyệt vời nhất</p>
    </div>
    <div class="shop-layout">
        <!-- CỘT SIDEBAR TRÁI (Sticky) -->
        <div class="shop-sidebar">
            
            <!-- Hộp Tìm kiếm nhanh -->
            <div class="sidebar-box">
                <div class="filter-title mb-2"><i class="fas fa-search"></i> Tìm kiếm</div>
                <form id="top-search-form" method="GET" action="index.php">
                    <?php /* Các hidden input để giữ context controller/action/category khi submit */ ?>
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action"     value="index">
                    <input type="hidden" name="category"   id="top-category"
                           value="<?= htmlspecialchars($currentCategory ?? '') ?>">

                    <div class="search-row-sidebar" style="position: relative;">
                        <input type="text" name="search" id="main-search-input"
                               class="search-input-sidebar"
                               placeholder="Tìm tên, thương hiệu..."
                               value="<?= htmlspecialchars($currentKeyword ?? '') ?>">
                        
                        <!-- NÚT X XÓA NHANH CONTENT Ô SEARCH -->
                        <i class="fas fa-times-circle" id="clear-search-input" 
                           style="position: absolute; right: 55px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-faint); display: <?= !empty($currentKeyword) ? 'inline-block' : 'none' ?>; z-index: 10;"></i>
                        
                        <button type="submit" class="btn-search-sidebar">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Nút Toggle Bộ lọc nâng cao -->
            <div class="mb-3">
                <button type="button" class="btn-filter-toggle-sidebar" id="btn-filter-toggle">
                    <i class="fas fa-sliders-h"></i>
                    Bộ lọc nâng cao
                    <span id="active-filter-count" class="badge bg-primary rounded-pill"
                          style="display:none; font-size:0.7rem;">0</span>
                    <i class="fas fa-chevron-down chevron ms-auto"></i>
                </button>
            </div>

            <!-- Panel Bộ lọc nâng cao (Trượt xuống/lên) -->
            <div class="filter-panel-sidebar" id="filter-panel">
                <form id="advanced-filter-form" method="GET" action="index.php">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action"     value="index">
                    <input type="hidden" name="search"   id="adv-search"
                           value="<?= htmlspecialchars($currentKeyword ?? '') ?>">
                    <input type="hidden" name="category" id="adv-category"
                           value="<?= htmlspecialchars($currentCategory ?? '') ?>">

                    <!-- NHÓM: KHOẢNG GIÁ -->
                    <div class="filter-group">
                        <div class="filter-title"><i class="fas fa-tag"></i> Khoảng giá</div>
                        <div class="price-inputs">
                            <div class="price-input-wrapper">
                                <label>Từ (₫)</label>
                                <input type="number" min="0" name="price_min" id="price_min_input" class="price-input"
                                       placeholder="0"
                                       value="<?= htmlspecialchars($currentPriceMin ?? '') ?>">
                            </div>
                            <div class="price-input-wrapper">
                                <label>Đến (₫)</label>
                                <input type="number" min="0" name="price_max" id="price_max_input" class="price-input"
                                       placeholder="100,000,000"
                                       value="<?= htmlspecialchars($currentPriceMax ?? '') ?>">
                            </div>
                        </div>
                        <div class="price-slider">
                            <div class="price-slider-fill" id="price-slider-fill"></div>
                            <input type="range" id="price-range-max"
                                   min="0" max="100000000" step="500000"
                                   value="<?= htmlspecialchars((isset($currentPriceMax) && $currentPriceMax !== '') ? $currentPriceMax : '100000000') ?>">
                        </div>
                        <div class="price-display" id="price-display">
                            <?php
                            $pMin = (isset($currentPriceMin) && $currentPriceMin !== '')
                                ? number_format((float)$currentPriceMin, 0, ',', '.') . ' ₫'
                                : '0 ₫';
                            $pMax = (isset($currentPriceMax) && $currentPriceMax !== '')
                                ? number_format((float)$currentPriceMax, 0, ',', '.') . ' ₫'
                                : '100.000.000 ₫';
                            echo $pMin . ' — ' . $pMax;
                            ?>
                        </div>
                    </div>

                    <!-- NHÓM: THƯƠNG HIỆU -->
                    <div class="filter-group">
                        <div class="filter-title"><i class="fas fa-star"></i> Thương hiệu</div>
                        <div class="filter-checkbox-grid">
                            <?php
                            if (isset($brands) && is_array($brands)):
                                foreach ($brands as $b):
                                    $isChecked = ($currentBrand ?? '') === $b ? 'checked' : '';
                            ?>
                                <label class="filter-checkbox">
                                    <input type="checkbox" name="brand"
                                           value="<?= htmlspecialchars($b) ?>" <?= $isChecked ?>>
                                    <span><?= htmlspecialchars($b) ?></span>
                                </label>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>

                    <!-- NHÓM: TÌNH TRẠNG KHO -->
                    <div class="filter-group">
                        <div class="filter-title"><i class="fas fa-boxes"></i> Tình trạng</div>
                        <label class="filter-checkbox">
                            <input type="checkbox" name="in_stock" value="1"
                                   <?= ($currentInStock ?? null) == 1 ? 'checked' : '' ?>>
                            <span>Chỉ còn hàng (<?= $totalProducts ?? 0 ?>)</span>
                        </label>
                    </div>

                    <!-- NHÓM: CHO THUÊ -->
                    <div class="filter-group">
                        <div class="filter-title"><i class="fas fa-clock"></i> Loại</div>
                        <label class="filter-checkbox">
                            <input type="checkbox" name="is_rentable" value="1"
                                   <?= ($currentIsRentable ?? null) == 1 ? 'checked' : '' ?>>
                            <span>Có cho thuê</span>
                        </label>
                    </div>

                    <!-- NÚT ÁP DỤNG / XÓA LỌC -->
                    <div class="filter-actions">
                        <button type="submit" class="btn-apply-filter">
                            <i class="fas fa-check"></i> Lọc
                        </button>
                        <a href="index.php?controller=product&action=index"
                           class="btn-clear-filter"
                           style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:4px;">
                            <i class="fas fa-times"></i> Xóa lọc
                        </a>
                    </div>
                </form>
            </div>

            <!-- Hộp Danh mục sản phẩm -->
            <div class="sidebar-box">
                <div class="filter-title mb-2"><i class="fas fa-th-large"></i> Danh mục</div>
                <a href="#" data-category=""
                   class="cat-link <?= empty($currentCategory) ? 'active' : '' ?>">
                    <i class="fas fa-border-all"></i> Tất cả nhạc cụ
                </a>
                <?php
                if (isset($categories) && is_array($categories)):
                    foreach ($categories as $cat):
                        $isActive = ($currentCategory ?? null) == $cat['id'];
                ?>
                    <a href="#" data-category="<?= (int)$cat['id'] ?>"
                       class="cat-link <?= $isActive ? 'active' : '' ?>">
                        <i class="<?= htmlspecialchars($cat['icon']) ?>"></i>
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                <?php
                    endforeach;
                endif;
                ?>
            </div>

        </div><!-- /.shop-sidebar -->

        <!-- CỘT KHUNG SẢN PHẨM PHẢI -->
        <div class="shop-products-main">
            <!-- THÔNG BÁO KẾT QUẢ TÌM KIẾM (Chỉ hiện khi có từ khóa) -->
            <?php if (!empty($currentKeyword)): ?>
            <div id="search-result-msg" class="mb-4 p-3 rounded-4" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2);">
                <i class="fas fa-search me-2 text-primary"></i>
                <span class="text-muted">Kết quả tìm kiếm cho: </span>
                <span class="fw-bold text-primary">"<?= htmlspecialchars($currentKeyword) ?>"</span>
                <a href="index.php?controller=product&action=index" class="ms-3 small text-decoration-none text-muted hover-primary">
                    <i class="fas fa-times me-1"></i> Xóa tìm kiếm
                </a>
            </div>
            <?php endif; ?>

            <!-- Tags bộ lọc đang hoạt động -->
            <div class="active-filter-tags mb-3" id="active-filters"></div>

            <div class="products-wrapper">
                <div class="products-grid" id="products-grid" data-total-pages="<?= $totalPages ?? 1 ?>">
                    <?php
                    /**
                     * VÒNG LẶP HIỂN THỊ DANH SÁCH SẢN PHẨM
                     * $products được truyền từ ProductController->index()
                     */
                    if (isset($products) && is_array($products) && count($products) > 0) {
                        foreach ($products as $index => $p) {
                            $stockClass = $p['stock'] <= 3 ? 'low' : '';
                            $stockText = $p['stock'] > 0 ? 'Còn ' . $p['stock'] : 'Hết hàng';

                            // Lấy danh sách biến thể (màu sắc, phiên bản) đã được đính kèm trong Controller
                            $variants = $p['variants'] ?? ['colors' => [], 'versions' => []];
                            $colors = $variants['colors'] ?? [];
                            $versions = $variants['versions'] ?? [];
                    ?>
                            <div class="product-item" data-index="<?= $index ?>">
                                <div class="product-wrapper">
                                    <div class="product-card">
                                        <!-- Link chi tiết bao bọc toàn bộ phần ảnh -->
                                        <a href="index.php?controller=product&action=detail&id=<?= (int)$p['id'] ?>"
                                           style="display:block; text-decoration:none;">
                                            <div class="product-image-container">
                                                <img src="<?= $p['image'] ?>" 
                                                     class="product-image" 
                                                     alt="<?= htmlspecialchars($p['name']) ?>"
                                                     data-default-image="<?= $p['image'] ?>">
                                                
                                                <!-- Badge nhãn dán trạng thái -->
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
                                        </a>

                                        <div class="product-info">
                                            <!-- Thương hiệu & Tên sản phẩm -->
                                            <span class="product-brand"><?= htmlspecialchars($p['brand']) ?></span>
                                            <a href="index.php?controller=product&action=detail&id=<?= (int)$p['id'] ?>"
                                               style="text-decoration:none; color:inherit;">
                                                <h6 class="product-name"><?= htmlspecialchars($p['name']) ?></h6>
                                            </a>

                                            <!-- Hiển thị các biến thể màu sắc (nếu có) -->
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

                                            <!-- Phần giá cả & Nút thêm giỏ hàng -->
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

                                            <button class="btn-add-cart"
                                                    data-product-id="<?= (int)$p['id'] ?>"
                                                    onclick="addToCartAJAX(event, <?= (int)$p['id'] ?>)">
                                                <i class='bx bx-cart-add'></i> Thêm vào giỏ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
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

                <!-- Nút Xem thêm sản phẩm -->
                <?php
                $hasMore = ($currentPage ?? 1) < ($totalPages ?? 1);
                $showLoadMore = $hasMore && isset($products) && count($products) > 0;
                ?>
                <div class="btn-load-more <?= $showLoadMore ? 'active' : '' ?>" id="load-more-section" style="<?= $showLoadMore ? '' : 'display: none;' ?>">
                    <button class="btn-load-more-inner" id="btn-load-more">
                        <i class="fas fa-plus"></i> Xem thêm sản phẩm
                    </button>
                </div>

            </div><!-- /.products-wrapper -->
        </div><!-- /.shop-products-main -->
    </div><!-- /.shop-layout -->
</div><!-- /.container -->

<script>
/**
 * ================================================================================
 * JAVASCRIPT CHO TRANG CỬA HÀNG
 * - Toggle bộ lọc, Click danh mục, AJAX Load sản phẩm, Animation nền
 * ================================================================================
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. KHỞI TẠO BIẾN TOÀN CỤC
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

    const btnToggle = document.getElementById('btn-filter-toggle');
    const filterPanel = document.getElementById('filter-panel');
    const filterForm = document.getElementById('advanced-filter-form');
    const topForm = document.getElementById('top-search-form');
    const productsGrid = document.getElementById('products-grid');
    const btnLoadMore = document.getElementById('btn-load-more');
    const loadMoreSection = document.getElementById('load-more-section');
    const loadingIndicator = document.getElementById('loading-indicator');
    const mainSearchInput = document.getElementById('main-search-input');
    const clearSearchBtn = document.getElementById('clear-search-input');
    const searchResultMsg = document.getElementById('search-result-msg');

    // 1.1 XỬ LÝ NÚT X XÓA NHANH Ô SEARCH
    if (mainSearchInput && clearSearchBtn) {
        // Hiện/Ẩn nút X khi nhập liệu
        mainSearchInput.addEventListener('input', function() {
            clearSearchBtn.style.display = this.value.length > 0 ? 'inline-block' : 'none';
        });
        
        // Khi nhấn X: Xóa trắng ô input và focus lại
        clearSearchBtn.addEventListener('click', function() {
            mainSearchInput.value = '';
            this.style.display = 'none';
            mainSearchInput.focus();
        });
    }

    // 2. TOGGLE BỘ LỌC NÂNG CAO
    if (btnToggle && filterPanel) {
        btnToggle.addEventListener('click', () => {
            const isOpen = filterPanel.classList.toggle('open');
            btnToggle.classList.toggle('open', isOpen);
        });
        
        // Mở sẵn nếu có filter active
        const hasActiveFilter = currentFilters.price_min || currentFilters.price_max || 
                               currentFilters.brand || currentFilters.in_stock || currentFilters.is_rentable;
        if (hasActiveFilter) {
            filterPanel.classList.add('open');
            btnToggle.classList.add('open');
        }
    }

    // 3. XỬ LÝ CLICK DANH MỤC
    document.querySelectorAll('.cat-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const catId = this.dataset.category;
            
            const topCatInput = document.getElementById('top-category');
            const advCatInput = document.getElementById('adv-category');
            if (topCatInput) topCatInput.value = catId;
            if (advCatInput) advCatInput.value = catId;

            document.querySelectorAll('.cat-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            if (topForm) topForm.submit();
        });
    });

    // 4. AJAX LOAD SẢN PHẨM
    function buildFilterUrl(page = 1) {
        const params = new URLSearchParams(currentFilters);
        params.set('controller', 'product');
        params.set('action', 'index');
        params.set('page', page);
        return 'index.php?' + params.toString();
    }

    async function loadProducts(url, append = false) {
        if (isLoading) return;
        isLoading = true;
        
        if (!append) productsGrid.style.opacity = '0.5';
        loadingIndicator.classList.add('active');
        if (loadMoreSection) loadMoreSection.style.display = 'none';
        
        try {
            const response = await fetch(url);
            const htmlString = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(htmlString, 'text/html');
            const newGrid = doc.getElementById('products-grid');
            
            if (newGrid) {
                if (append) {
                    const newItems = newGrid.querySelectorAll('.product-item');
                    newItems.forEach((item, idx) => {
                        item.classList.add('product-item-new');
                        item.style.animationDelay = (idx * 0.1) + 's';
                        productsGrid.appendChild(item);
                    });
                    currentPage++;
                } else {
                    productsGrid.innerHTML = newGrid.innerHTML;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
                
                totalPages = parseInt(newGrid.dataset.totalPages || 1);
            }

            if (currentPage < totalPages && loadMoreSection) {
                loadMoreSection.style.display = 'block';
            }
            
            attachCardEvents();
            window.history.pushState({}, '', url);
        } catch (error) {
            console.error('Lỗi load sản phẩm:', error);
        } finally {
            isLoading = false;
            productsGrid.style.opacity = '1';
            loadingIndicator.classList.remove('active');
        }
    }

    // 5. EVENT HANDLERS
    // Xử lý submit form Tìm kiếm nhanh ở Sidebar
    if (topForm) {
        topForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const keyword = mainSearchInput.value.trim();
            currentFilters.search = keyword;
            currentPage = 1;
            
            // Thực hiện load sản phẩm qua AJAX
            loadProducts(buildFilterUrl(1), false);
            
            // Xóa content trong ô tìm kiếm sau khi submit theo yêu cầu
            mainSearchInput.value = '';
            if (clearSearchBtn) clearSearchBtn.style.display = 'none';
            
            // Cập nhật thông báo kết quả tìm kiếm (nếu có keyword)
            updateSearchResultMessage(keyword);
        });
    }

    // Xử lý submit form Bộ lọc nâng cao
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                currentFilters[key] = value;
            }
            currentPage = 1;
            loadProducts(buildFilterUrl(1), false);
        });
    }

    // Hàm cập nhật UI thông báo kết quả tìm kiếm
    function updateSearchResultMessage(keyword) {
        let msgContainer = document.getElementById('search-result-msg');
        if (keyword) {
            if (!msgContainer) {
                // Nếu chưa có div thông báo thì tạo mới
                const html = `
                    <div id="search-result-msg" class="mb-4 p-3 rounded-4" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2);">
                        <i class="fas fa-search me-2 text-primary"></i>
                        <span class="text-muted">Kết quả tìm kiếm cho: </span>
                        <span class="fw-bold text-primary">"${keyword}"</span>
                        <a href="index.php?controller=product&action=index" class="ms-3 small text-decoration-none text-muted hover-primary">
                            <i class="fas fa-times me-1"></i> Xóa tìm kiếm
                        </a>
                    </div>`;
                document.querySelector('.shop-products-main').insertAdjacentHTML('afterbegin', html);
            } else {
                // Nếu đã có thì chỉ cập nhật text
                msgContainer.style.display = 'block';
                msgContainer.querySelector('.fw-bold').textContent = `"${keyword}"`;
            }
        } else if (msgContainer) {
            msgContainer.style.display = 'none';
        }
    }

    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', () => {
            if (!isLoading && currentPage < totalPages) {
                loadProducts(buildFilterUrl(currentPage + 1), true);
            }
        });
    }

    // 6. CARD INTERACTIONS (Chọn màu đổi hình)
    function attachCardEvents() {
        document.querySelectorAll('.product-item').forEach(item => {
            const colorBtns = item.querySelectorAll('.color-btn');
            const productImage = item.querySelector('.product-image');
            
            colorBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    colorBtns.forEach(b => b.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    const newImg = this.dataset.image;
                    if (newImg && productImage) {
                        productImage.style.opacity = '0.3';
                        setTimeout(() => {
                            productImage.src = newImg;
                            productImage.style.opacity = '1';
                        }, 150);
                    }
                });
            });
        });
    }

    // 7. PRICE SLIDER
    const priceSlider = document.getElementById('price-range-max');
    const priceInputMax = document.querySelector('input[name="price_max"]');
    const priceDisplay = document.getElementById('price-display');
    const priceSliderFill = document.getElementById('price-slider-fill');
    
    if (priceSlider && priceInputMax && priceDisplay) {
        const updateSlider = (val) => {
            const min = parseInt(priceSlider.min) || 0;
            const max = parseInt(priceSlider.max) || 100000000;
            const percent = ((val - min) / (max - min)) * 100;
            if (priceSliderFill) priceSliderFill.style.width = percent + '%';
            
            const format = (n) => new Intl.NumberFormat('vi-VN').format(n) + ' ₫';
            const minVal = parseInt(document.getElementById('price_min_input')?.value) || 0;
            priceDisplay.textContent = `${format(minVal)} — ${format(val)}`;
        };

        priceSlider.addEventListener('input', function() {
            priceInputMax.value = this.value;
            updateSlider(this.value);
        });

        priceInputMax.addEventListener('input', function() {
            let val = Math.min(Math.max(parseInt(this.value) || 0, 0), 100000000);
            priceSlider.value = val;
            updateSlider(val);
        });

        updateSlider(priceSlider.value);
    }

    attachCardEvents();
    
    // Khỏi tạo animation nền riêng nếu chưa có
    if (!window.productAnimation) {
        window.productAnimation = new ProductCanvasAnimation();
    }
});

/**
 * ANIMATION NỀN HOÀN TOÀN MỚI CHO TRANG CỬA HÀNG
 * Hiệu ứng: Những vòng tròn sóng âm (Sound Waves) lan tỏa
 */
class ProductCanvasAnimation {
    constructor() {
        this.canvas = document.getElementById('product-canvas');
        if (!this.canvas) return;
        this.ctx = this.canvas.getContext('2d');
        this.notes = [];
        this.mouse = { x: null, y: null, radius: 150 };
        this.symbols = ['♫', '♪', '♬', '♩', '𝄞', '𝄢'];
        this.resize();
        this.initNotes();
        this.animate();
        
        window.addEventListener('resize', () => this.resize());
        window.addEventListener('mousemove', (e) => { 
            this.mouse.x = e.clientX; 
            this.mouse.y = e.clientY;
        });
        window.addEventListener('mouseleave', () => { 
            this.mouse.x = null; 
            this.mouse.y = null;
        });
    }
    
    resize() { 
        this.canvas.width = window.innerWidth; 
        this.canvas.height = window.innerHeight; 
        this.initNotes();
    }
    
    initNotes() {
        this.notes = [];
        const density = Math.floor((this.canvas.width * this.canvas.height) / 18000);
        const count = Math.min(Math.max(density, 40), 90);
        
        for (let i = 0; i < count; i++) {
            this.notes.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * 0.8,
                vy: (Math.random() - 0.5) * 0.8,
                size: Math.random() * 12 + 12,
                opacity: Math.random() * 0.3 + 0.15,
                symbol: this.symbols[Math.floor(Math.random() * this.symbols.length)],
                color: Math.random() > 0.5 ? '56, 189, 248' : '139, 92, 246'
            });
        }
    }
    
    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        const count = this.notes.length;
        
        for (let i = 0; i < count; i++) {
            const n = this.notes[i];
            
            n.x += n.vx;
            n.y += n.vy;
            
            if (n.x < 0 || n.x > this.canvas.width) n.vx *= -1;
            if (n.y < 0 || n.y > this.canvas.height) n.vy *= -1;
            
            if (this.mouse.x !== null && this.mouse.y !== null) {
                const dx = n.x - this.mouse.x;
                const dy = n.y - this.mouse.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < this.mouse.radius) {
                    const force = (this.mouse.radius - dist) / this.mouse.radius;
                    const angle = Math.atan2(dy, dx);
                    n.x += Math.cos(angle) * force * 3;
                    n.y += Math.sin(angle) * force * 3;
                }
            }
            
            this.ctx.save();
            this.ctx.font = `${n.size}px Outfit, sans-serif`;
            this.ctx.fillStyle = `rgba(${n.color}, ${n.opacity})`;
            this.ctx.shadowBlur = 10;
            this.ctx.shadowColor = `rgba(${n.color}, 0.8)`;
            this.ctx.fillText(n.symbol, n.x, n.y);
            this.ctx.restore();
            
            for (let j = i + 1; j < count; j++) {
                const n2 = this.notes[j];
                const dx = n.x - n2.x;
                const dy = n.y - n2.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                
                if (dist < 130) {
                    const alpha = (1 - dist / 130) * 0.15;
                    this.ctx.beginPath();
                    this.ctx.moveTo(n.x, n.y - 5);
                    this.ctx.lineTo(n2.x, n2.y - 5);
                    
                    const grad = this.ctx.createLinearGradient(n.x, n.y, n2.x, n2.y);
                    grad.addColorStop(0, `rgba(${n.color}, ${alpha})`);
                    grad.addColorStop(1, `rgba(${n2.color}, ${alpha})`);
                    
                    this.ctx.strokeStyle = grad;
                    this.ctx.lineWidth = 1;
                    this.ctx.stroke();
                }
            }
        }
        
        requestAnimationFrame(() => this.animate());
    }
}
</script>

<?php
// Gọi thẻ Footer vào cuối trang
include __DIR__ . '/partials/footer.php';
?>