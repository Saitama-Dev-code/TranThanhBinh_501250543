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
/* Thanh Drag Handle ở trên cùng của trang chi tiết */
.detail-sheet-header {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 14px 0;
    position: -webkit-sticky;
    position: sticky;
    top: 0; /* Ghim sát đỉnh của container #page-detail (tức là sát đáy Navbar) */
    background: var(--bg-color);
    border-bottom: 1px solid var(--border-color);
    z-index: 100;
}
.detail-drag-handle {
    width: 90px;
    height: 18px;
    background: rgba(139, 92, 246, 0.12);
    border: 1px solid rgba(139, 92, 246, 0.2);
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.3s, border-color 0.3s, box-shadow 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.detail-drag-handle::after {
    content: '\f078'; /* FontAwesome chevron-down */
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    color: #a78bfa;
    font-size: 0.75rem;
    opacity: 0.6;
    transition: transform 0.3s ease, opacity 0.3s ease;
    display: inline-block;
}
.detail-drag-handle:hover {
    background: rgba(139, 92, 246, 0.25);
    border-color: rgba(139, 92, 246, 0.6);
    box-shadow: 0 0 12px rgba(139, 92, 246, 0.5);
}
.detail-drag-handle:hover::after {
    opacity: 1;
    color: #ffffff;
    animation: chevronSlideDown 1.2s infinite;
}
@keyframes chevronSlideDown {
    0% { transform: translateY(-4px); opacity: 0; }
    50% { transform: translateY(1px); opacity: 1; }
    100% { transform: translateY(5px); opacity: 0; }
}

/* ================================================================================
   BIẾN MÀU THEO THEME - sửa lỗi chữ tắt ở nền sáng
   ================================================================================ */
[data-theme="dark"]  { --text-muted: rgba(255,255,255,0.55); --text-faint: rgba(255,255,255,0.35); }
[data-theme="light"] { --text-muted: rgba(15,23,42,0.55);   --text-faint: rgba(15,23,42,0.35); }
[data-theme="dark"]  { --variant-btn-bg: rgba(255,255,255,0.06); --variant-btn-border: rgba(255,255,255,0.15); }
[data-theme="light"] { --variant-btn-bg: #ffffff; --variant-btn-border: #e2e8f0; }

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

/* ================================================================================
   PHẦN NÂNG CẤP: HOVER ZOOM, 360 VIEWER, REVIEWS, CAROUSEL
   ================================================================================ */

/* 1. Lightbox phóng to ảnh sản phẩm */
.main-image-frame {
    position: relative;
    overflow: hidden;
    cursor: zoom-in;
}
.product-lightbox-modal {
    display: none;
    position: fixed;
    z-index: 1200; /* Cao nhất để đè lên tất cả */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(10, 10, 15, 0.95);
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: zoom-out;
}
.product-lightbox-modal.active {
    display: flex;
    opacity: 1;
}
.lightbox-image-content {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8);
    transform: scale(0.9);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.product-lightbox-modal.active .lightbox-image-content {
    transform: scale(1);
}
.lightbox-close-btn {
    position: absolute;
    top: 25px;
    right: 35px;
    color: #f1f5f9;
    font-size: 40px;
    font-weight: 300;
    transition: all 0.3s;
    cursor: pointer;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    z-index: 10;
}
.lightbox-close-btn:hover {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
    border-color: rgba(239, 68, 68, 0.2);
    transform: rotate(90deg);
}

/* 2. Custom Select Trả Góp */
.installment-select-wrapper {
    position: relative;
    width: 100%;
}
.installment-select-wrapper::after {
    content: '\f107'; /* FontAwesome chevron-down */
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #a78bfa;
    text-shadow: 0 0 5px rgba(167, 139, 250, 0.5);
    transition: transform 0.3s ease;
}
.installment-select-wrapper:hover::after {
    transform: translateY(-50%) translateY(2px);
    color: #8b5cf6;
}
.installment-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: rgba(13, 12, 24, 0.6) !important;
    border: 1px solid rgba(139, 92, 246, 0.4) !important;
    border-radius: 12px !important;
    color: var(--text-color) !important;
    padding: 12px 40px 12px 18px !important;
    font-size: 0.9rem !important;
    width: 100%;
    cursor: pointer;
    outline: none;
    box-shadow: 0 0 10px rgba(139, 92, 246, 0.1) !important;
    transition: all 0.3s ease;
}
.installment-select:focus {
    border-color: #8b5cf6 !important;
    box-shadow: 0 0 15px rgba(139, 92, 246, 0.45) !important;
}

/* 3. Section Đánh giá sản phẩm */
.reviews-section {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 24px;
    padding: 30px;
    margin-top: 40px;
    backdrop-filter: blur(10px);
}
.rating-summary-box {
    text-align: center;
    padding: 24px;
    background: rgba(139, 92, 246, 0.03);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.rating-big-number {
    font-size: 3.5rem;
    font-weight: 900;
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1;
}
.stars-outer {
    position: relative;
    display: inline-block;
    color: #e2e8f0;
    font-size: 1.2rem;
}
.stars-inner {
    position: absolute;
    top: 0; left: 0;
    white-space: nowrap;
    overflow: hidden;
    width: 92%; /* 4.6 stars as placeholder */
    color: #f59e0b;
}
.rating-bar-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    font-size: 0.85rem;
    color: var(--text-color);
    width: 100%;
}
.rating-bar-label {
    width: 50px;
    font-weight: 600;
    white-space: nowrap;
}
.rating-bar-progress-container {
    flex: 1;
    height: 8px;
    background: rgba(128,128,128,0.1);
    border-radius: 4px;
    overflow: hidden;
}
.rating-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #8b5cf6, #ec4899);
    border-radius: 4px;
}
.rating-bar-count {
    width: 35px;
    text-align: right;
    color: var(--text-muted);
}
.interactive-stars {
    display: flex;
    gap: 6px;
    font-size: 1.5rem;
    color: #e2e8f0;
    cursor: pointer;
}
.interactive-stars i {
    transition: color 0.2s, transform 0.2s;
}
.interactive-stars i.active, .interactive-stars i:hover {
    color: #f59e0b;
    transform: scale(1.15);
}
.review-item {
    padding: 20px 0;
    border-bottom: 1px solid var(--border-color);
}
.review-item:last-child {
    border-bottom: none;
}
.review-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    flex-wrap: wrap;
    gap: 8px;
}
.reviewer-name {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--text-color);
}
.reviewer-badge {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    font-size: 0.75rem;
    padding: 2px 8px;
    border-radius: 12px;
    font-weight: 600;
    margin-left: 8px;
}
.review-date {
    color: var(--text-muted);
    font-size: 0.8rem;
}
.review-text {
    color: var(--text-color);
    opacity: 0.85;
    font-size: 0.9rem;
    line-height: 1.6;
}

/* 4. Carousel Sản Phẩm Nổi Bật */
.carousel-container-outer {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}
.carousel-track-wrapper {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scroll-behavior: smooth;
    scrollbar-width: none; /* Hide scrollbar for Firefox */
    width: 100%;
    padding: 10px 0;
}
.carousel-track-wrapper::-webkit-scrollbar {
    display: none; /* Hide scrollbar for Chrome/Safari */
}
.carousel-card-item {
    flex: 0 0 calc(25% - 15px); /* 4 items per row on large screen */
    min-width: 250px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
}
.carousel-card-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    border-color: rgba(139, 92, 246, 0.3);
}
.carousel-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}
.carousel-card-img-wrap {
    width: 100%;
    height: 180px;
    overflow: hidden;
    position: relative;
    background: rgba(128,128,128,0.03);
}
.carousel-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.carousel-card-item:hover .carousel-card-img {
    transform: scale(1.1);
}
.carousel-card-info {
    padding: 16px;
}
.carousel-card-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.carousel-card-price {
    font-size: 0.95rem;
    font-weight: 800;
    color: #8b5cf6;
}
.carousel-nav-btn {
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid var(--border-color);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    position: absolute;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}
.carousel-nav-btn:hover {
    background: #8b5cf6;
    border-color: #8b5cf6;
    transform: scale(1.1);
}
.carousel-nav-btn.prev-btn {
    left: -15px;
}
.carousel-nav-btn.next-btn {
    right: -15px;
}
@media (max-width: 992px) {
    .carousel-card-item {
        flex: 0 0 calc(33.333% - 14px); /* 3 items */
    }
}
@media (max-width: 768px) {
    .carousel-card-item {
        flex: 0 0 calc(50% - 10px); /* 2 items */
    }
    .carousel-nav-btn {
        display: none; /* Hide buttons on mobile, rely on swipe */
    }
}

/* Sửa màu sắc cho các thành phần ở Light Theme để trông cao cấp hơn */
[data-theme="light"] .installment-select {
    background: #ffffff !important;
    border: 1px solid rgba(139, 92, 246, 0.25) !important;
    color: #1e293b !important;
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.05) !important;
}
[data-theme="light"] .detail-variant-btn:hover {
    background: rgba(139, 92, 246, 0.05) !important;
    border-color: #8b5cf6 !important;
    color: #8b5cf6 !important;
}
</style>

<!-- Canvas nền Ripple Sóng Âm - RIÊNG của trang chi tiết -->
<canvas id="detail-canvas"></canvas>

<!-- ============================================================
     NỘI DUNG CHÍNH TRANG CHI TIẾT
     ============================================================ -->
<div class="detail-sheet-header">
    <div class="detail-drag-handle" onclick="if(history.length > 1) { history.back(); } else { window.navigateToSPA('index.php?controller=product&action=index'); }" title="Nhấp để quay lại"></div>
</div>

<div class="container my-4">

    <!-- Hàng trên: Breadcrumb điều hướng -->
    <div class="d-flex align-items-center justify-content-end mb-4">
        <nav class="detail-breadcrumb m-0 p-0" style="margin-bottom: 0;">
            <!-- Link về trang chủ -->
            <a href="index.php?controller=home">
                <i class="fas fa-home"></i> Trang chủ
            </a>
            <span class="separator">/</span>

            <!-- Link về cửa hàng -->
            <a href="index.php?controller=product&action=index">Cửa hàng</a>
            <span class="separator">/</span>

            <!-- Tên sản phẩm hiện tại (không phải link) -->
            <span class="current"><?= htmlspecialchars($product['name']) ?></span>
        </nav>
    </div>

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
                        onclick="window.openLightbox()"
                        title="Click để phóng to ảnh sản phẩm"
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
                <div class="installment-card" style="background: rgba(139, 92, 246, 0.05); border: 1px solid rgba(139, 92, 246, 0.15); border-radius: 16px; padding: 20px; margin-top: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                    <div class="installment-title" style="font-size: 0.9rem; font-weight: 700; color: #a78bfa; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-credit-card" style="color: #8b5cf6;"></i>
                        <span>Tính trả góp 0% lãi suất</span>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3 justify-content-between">
                        <div style="flex: 1; min-width: 150px;">
                            <div class="installment-select-wrapper">
                                <select class="installment-select" id="installment-months" onchange="calcInstallment()">
                                    <option value="3">3 tháng</option>
                                    <option value="6" selected>6 tháng</option>
                                    <option value="12">12 tháng</option>
                                    <option value="24">24 tháng</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2" style="white-space: nowrap;">
                            <span style="color: var(--text-muted); font-size: 0.9rem; font-weight: 600; line-height: 1;">Mỗi tháng:</span>
                            <span class="installment-monthly" id="installment-price" style="font-size: 1.4rem; font-weight: 800; color: #8b5cf6; text-shadow: 0 0 10px rgba(139, 92, 246, 0.2); line-height: 1;">
                                <?= number_format($product['price'] / 6, 0, ',', '.') ?>₫
                            </span>
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
                echo nl2br(htmlspecialchars($product['description'] ?? 'Chưa có mô tả cho sản phẩm này.'));
                ?>
                
                <!-- BỔ SUNG CONTENT CHI TIẾT SANG TRỌNG ĐỂ LẤP KHOẢNG TRỐNG -->
                <div class="mt-5 pt-4 border-top" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                    <h5 class="text-primary mb-3 fw-bold" style="background: linear-gradient(135deg, #a78bfa, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <i class="fas fa-gem me-2" style="-webkit-text-fill-color: #8b5cf6;"></i>Đặc điểm nổi bật & Thiết kế cao cấp
                    </h5>
                    <p style="color: var(--text-muted); line-height: 1.7; font-size: 0.95rem;">
                        Sản phẩm nhạc cụ phân phối bởi <strong>TTB Music</strong> được tuyển chọn khắt khe và chế tác tinh xảo từ những xưởng chế tạo danh tiếng. Thiết kế công thái học vượt trội không chỉ tạo cảm giác cầm nắm thoải mái mà còn tối ưu hóa hiệu suất biểu diễn cho nghệ sĩ ở mọi cấp độ.
                    </p>
                    
                    <div class="row g-4 mt-2 mb-4">
                        <div class="col-md-4">
                            <div class="p-4 rounded-4 h-100" style="background: rgba(139, 92, 246, 0.04); border: 1px solid rgba(139, 92, 246, 0.15); backdrop-filter: blur(5px);">
                                <h6 class="fw-bold mb-2 text-info" style="font-size: 1rem;"><i class="fas fa-music me-2"></i>Âm thanh trung thực</h6>
                                <p class="small text-muted mb-0" style="line-height: 1.6;">Cơ chế phản hồi âm học độc quyền mang đến âm sắc trầm ấm, ngọt ngào ở dải bass và trong trẻo, réo rắt ở dải treble, tái hiện chân thực mọi cảm xúc âm nhạc.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 rounded-4 h-100" style="background: rgba(139, 92, 246, 0.04); border: 1px solid rgba(139, 92, 246, 0.15); backdrop-filter: blur(5px);">
                                <h6 class="fw-bold mb-2 text-info" style="font-size: 1rem;"><i class="fas fa-tree me-2"></i>Gỗ tuyển chọn kỹ lưỡng</h6>
                                <p class="small text-muted mb-0" style="line-height: 1.6;">Được cấu thành từ các dòng gỗ sấy tự nhiên lâu năm như Vân Sam (Spruce), Gỗ Gụ (Mahogany) hoặc Gỗ Mun (Ebony), giúp hạn chế tối đa cong vênh dưới tác động thời tiết.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 rounded-4 h-100" style="background: rgba(139, 92, 246, 0.04); border: 1px solid rgba(139, 92, 246, 0.15); backdrop-filter: blur(5px);">
                                <h6 class="fw-bold mb-2 text-info" style="font-size: 1rem;"><i class="fas fa-drafting-compass me-2"></i>Gia công thủ công tỉ mỉ</h6>
                                <p class="small text-muted mb-0" style="line-height: 1.6;">Từng đường chỉ viền, phím đàn đến các khớp nối cơ học đều được mài giũa tỉ mỉ bởi nghệ nhân lành nghề, đạt tiêu chuẩn hoàn thiện thẩm mỹ cao nhất.</p>
                            </div>
                        </div>
                    </div>

                    <p style="color: var(--text-muted); line-height: 1.7; font-size: 0.95rem;">
                        Với lớp phủ hoàn thiện bảo vệ chống trầy xước cao cấp kết hợp các chi tiết phần cứng mạ chrome/neon chống oxy hóa, nhạc cụ giữ được vẻ sáng bóng bóng bẩy qua hàng thập kỷ. Đây chính là người bạn đồng hành hoàn hảo cùng bạn thăng hoa trong từng nốt nhạc trên sân khấu lẫn những buổi tập luyện chuyên sâu tại gia.
                    </p>
                </div>
            </div>
        </div>

        <!-- Tab Thông số kỹ thuật -->
        <div class="tab-content-panel" id="tab-specs">
            <table class="specs-table">
                <tbody>
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
                            <?php if ($product['stock'] <= 0): ?>
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
                    <?php
                    $catId = (int)($product['category_id'] ?? 0);
                    switch ($catId) {
                        case 1: // Guitar & Bass
                            ?>
                            <tr>
                                <td>Kiểu dáng (Body Shape)</td>
                                <td>Dreadnought (D-shape) / Cutaway sang trọng</td>
                            </tr>
                            <tr>
                                <td>Mặt trước (Top Wood)</td>
                                <td>Gỗ thông Spruce nguyên tấm (Solid Sitka Spruce)</td>
                            </tr>
                            <tr>
                                <td>Lưng & Hông (Back & Sides)</td>
                                <td>Gỗ Mahogany nhập khẩu cao cấp</td>
                            </tr>
                            <tr>
                                <td>Cần đàn (Neck Wood)</td>
                                <td>Gỗ Nato chắc chắn, chống cong vênh</td>
                            </tr>
                            <tr>
                                <td>Mặt phím (Fretboard)</td>
                                <td>Gỗ Rosewood (Cẩm lai) mịn màng, phản xạ âm tốt</td>
                            </tr>
                            <tr>
                                <td>Số phím đàn (Frets)</td>
                                <td>20 phím hợp kim chống gỉ</td>
                            </tr>
                            <tr>
                                <td>Hệ thống Pickup (Electronics)</td>
                                <td>Tích hợp Preamp TTB-301 với tuner chỉnh dây chuyên nghiệp</td>
                            </tr>
                            <tr>
                                <td>Dây đàn (Strings)</td>
                                <td>D'Addario EXP16 Phosphor Bronze cao cấp (Size 0.12)</td>
                            </tr>
                            <?php
                            break;
                        case 2: // Piano & Organ
                            ?>
                            <tr>
                                <td>Số phím đàn (Keys)</td>
                                <td>88 phím tiêu chuẩn quốc tế</td>
                            </tr>
                            <tr>
                                <td>Loại bàn phím (Keyboard Type)</td>
                                <td>Graded Hammer Action (GHA) giả lập cảm giác phím đại dương cầm</td>
                            </tr>
                            <tr>
                                <td>Đa âm tối đa (Polyphony)</td>
                                <td>256 nốt (Tha hồ chơi các bản nhạc phức tạp)</td>
                            </tr>
                            <tr>
                                <td>Số tiếng nhạc cụ (Voices/Tones)</td>
                                <td>500 tiếng chất lượng cao (Grand Piano, Harpsichord, Strings...)</td>
                            </tr>
                            <tr>
                                <td>Kết nối thông minh (Connectivity)</td>
                                <td>USB to Host (MIDI), Headphones x 2, AUX In/Out, Sustain Pedal</td>
                            </tr>
                            <tr>
                                <td>Hệ thống âm thanh (Speakers)</td>
                                <td>Loa vòm 2 chiều công suất lớn 15W x 2 cho âm thanh sống động</td>
                            </tr>
                            <tr>
                                <td>Nguồn điện (Power Supply)</td>
                                <td>AC Adapter PA-150 hoặc tương đương</td>
                            </tr>
                            <tr>
                                <td>Trọng lượng (Weight)</td>
                                <td>11.5 kg (Gọn nhẹ, dễ dàng di chuyển lưu diễn)</td>
                            </tr>
                            <?php
                            break;
                        case 3: // Trống & Bộ gõ
                            ?>
                            <tr>
                                <td>Loại trống (Drum Type)</td>
                                <td>Trống điện tử thông minh thế hệ mới (Electronic Drum Kit)</td>
                            </tr>
                            <tr>
                                <td>Số mặt gõ (Pads/Cymbals)</td>
                                <td>5 Mặt trống (Snare, 3 Toms, Kick) & 3 Mặt Cymbal (Hi-hat, Crash, Ride)</td>
                            </tr>
                            <tr>
                                <td>Chất liệu mặt gõ (Pad Surface)</td>
                                <td>Mặt lưới cao cấp (Mesh Head) cho độ đàn hồi chân thực, chống ồn</td>
                            </tr>
                            <tr>
                                <td>Hộp mô-đun âm thanh (Sound Module)</td>
                                <td>TTB-Drum Processor thế hệ mới, hỗ trợ ghi âm trực tiếp</td>
                            </tr>
                            <tr>
                                <td>Số điệu trống tích hợp (Kits)</td>
                                <td>30 bộ trống preset + 10 bộ trống tự tạo (User Kits)</td>
                            </tr>
                            <tr>
                                <td>Cổng kết nối (Ports)</td>
                                <td>Trigger Input, Line Out (L/Mono, R), Phones, Aux In, USB MIDI</td>
                            </tr>
                            <tr>
                                <td>Phụ kiện tặng kèm (Accessories)</td>
                                <td>Cặp dùi trống Maple, Khóa chỉnh trống, Ghế ngồi cao cấp, Pedal Kick</td>
                            </tr>
                            <?php
                            break;
                        default: // Mặc định khác
                            ?>
                            <tr>
                                <td>Xuất xứ</td>
                                <td>Chính hãng (Đầy đủ hóa đơn VAT & chứng từ CO/CQ)</td>
                            </tr>
                            <tr>
                                <td>Chất liệu</td>
                                <td>Hợp kim & gỗ sấy xử lý chống ẩm tiêu chuẩn xuất khẩu</td>
                            </tr>
                            <tr>
                                <td>Chế độ bảo hành</td>
                                <td>12 tháng chính hãng tại hệ thống nhạc cụ TTB</td>
                            </tr>
                            <tr>
                                <td>Trọn bộ sản phẩm</td>
                                <td>Sách HDSD, Thẻ bảo hành, Phụ kiện tiêu chuẩn đi kèm từ nhà sản xuất</td>
                            </tr>
                            <?php
                            break;
                    }
                    ?>
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
                            <?= htmlspecialchars(implode(', ', array_column($colors, 'name'))) ?>
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

    <!-- ============================================================
         PHẦN ĐÁNH GIÁ SẢN PHẨM (CUSTOMER REVIEWS)
         ============================================================ -->
    <div class="reviews-section mt-5 pt-4">
        <h3 class="fw-bold mb-4" style="font-size: 1.6rem; color: var(--text-color); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-star" style="color: #f59e0b;"></i> Đánh giá từ khách hàng
        </h3>
        
        <div class="row g-4">
            <!-- Cột trái: Tóm tắt điểm đánh giá -->
            <div class="col-lg-4">
                <div class="review-summary-card" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; text-align: center; height: 100%; backdrop-filter: blur(10px);">
                    <div style="font-size: 3.5rem; font-weight: 800; color: var(--text-color); line-height: 1;">4.8</div>
                    <div class="my-2" style="font-size: 1.2rem; color: #f59e0b;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="text-muted small mb-4">Dựa trên 32 đánh giá thực tế</div>
                    
                    <!-- Progress bars -->
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-muted" style="width: 35px; text-align: right;">5 sao</span>
                            <div class="progress flex-grow-1" style="height: 6px; background: rgba(255,255,255,0.05); border-radius: 3px;">
                                <div class="progress-bar" style="width: 85%; background: linear-gradient(90deg, #8b5cf6, #a78bfa); border-radius: 3px;"></div>
                            </div>
                            <span class="small text-muted" style="width: 25px; text-align: left;">85%</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-muted" style="width: 35px; text-align: right;">4 sao</span>
                            <div class="progress flex-grow-1" style="height: 6px; background: rgba(255,255,255,0.05); border-radius: 3px;">
                                <div class="progress-bar" style="width: 10%; background: linear-gradient(90deg, #8b5cf6, #a78bfa); border-radius: 3px;"></div>
                            </div>
                            <span class="small text-muted" style="width: 25px; text-align: left;">10%</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-muted" style="width: 35px; text-align: right;">3 sao</span>
                            <div class="progress flex-grow-1" style="height: 6px; background: rgba(255,255,255,0.05); border-radius: 3px;">
                                <div class="progress-bar" style="width: 5%; background: linear-gradient(90deg, #8b5cf6, #a78bfa); border-radius: 3px;"></div>
                            </div>
                            <span class="small text-muted" style="width: 25px; text-align: left;">5%</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-muted" style="width: 35px; text-align: right;">2 sao</span>
                            <div class="progress flex-grow-1" style="height: 6px; background: rgba(255,255,255,0.05); border-radius: 3px;">
                                <div class="progress-bar" style="width: 0%; background: linear-gradient(90deg, #8b5cf6, #a78bfa); border-radius: 3px;"></div>
                            </div>
                            <span class="small text-muted" style="width: 25px; text-align: left;">0%</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-muted" style="width: 35px; text-align: right;">1 sao</span>
                            <div class="progress flex-grow-1" style="height: 6px; background: rgba(255,255,255,0.05); border-radius: 3px;">
                                <div class="progress-bar" style="width: 0%; background: linear-gradient(90deg, #8b5cf6, #a78bfa); border-radius: 3px;"></div>
                            </div>
                            <span class="small text-muted" style="width: 25px; text-align: left;">0%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cột giữa: Form Viết Đánh Giá -->
            <div class="col-lg-8">
                <div class="review-form-card" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; backdrop-filter: blur(10px);">
                    <h5 class="fw-bold mb-3" style="color: var(--text-color);">Chia sẻ trải nghiệm của bạn</h5>
                    <form id="review-submit-form" onsubmit="submitReview(event)">
                        <div class="mb-3 d-flex align-items-center gap-3">
                            <span style="color: var(--text-color); font-size: 0.95rem; font-weight: 500;">Đánh giá của bạn:</span>
                            <div class="star-rating-input d-flex gap-1" style="font-size: 1.4rem; color: rgba(255,255,255,0.15); cursor: pointer;">
                                <i class="fas fa-star" data-value="1" onclick="setRatingValue(1)" onmouseover="highlightStars(1)" onmouseout="resetStars()"></i>
                                <i class="fas fa-star" data-value="2" onclick="setRatingValue(2)" onmouseover="highlightStars(2)" onmouseout="resetStars()"></i>
                                <i class="fas fa-star" data-value="3" onclick="setRatingValue(3)" onmouseover="highlightStars(3)" onmouseout="resetStars()"></i>
                                <i class="fas fa-star" data-value="4" onclick="setRatingValue(4)" onmouseover="highlightStars(4)" onmouseout="resetStars()"></i>
                                <i class="fas fa-star" data-value="5" onclick="setRatingValue(5)" onmouseover="highlightStars(5)" onmouseout="resetStars()"></i>
                            </div>
                            <input type="hidden" id="rating-input-val" value="5" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="review-name" placeholder="Họ và tên" style="background: rgba(15,23,42,0.3); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px;" required>
                                    <label for="review-name" style="color: var(--text-muted);">Họ và tên của bạn</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="review-email" placeholder="Email" style="background: rgba(15,23,42,0.3); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px;" required>
                                    <label for="review-email" style="color: var(--text-muted);">Địa chỉ Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="review-content" placeholder="Nhận xét" style="height: 100px; background: rgba(15,23,42,0.3); border: 1px solid var(--border-color); color: var(--text-color); border-radius: 10px;" required></textarea>
                                    <label for="review-content" style="color: var(--text-muted);">Nội dung nhận xét chi tiết về sản phẩm...</label>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-glow rounded-pill px-4 py-2" style="font-weight: 600;">
                                    Gửi đánh giá <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danh sách đánh giá mẫu -->
        <div class="review-list mt-4" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; backdrop-filter: blur(10px);">
            <h5 class="fw-bold mb-3 pb-2" style="color: var(--text-color); border-bottom: 1px solid var(--border-color);">
                Nhận xét gần đây
            </h5>
            
            <div id="reviews-container">
                <!-- Nhận xét 1 -->
                <div class="review-item">
                    <div class="review-header">
                        <div>
                            <span class="reviewer-name">Nguyễn Tuấn Kiệt</span>
                            <span class="reviewer-badge"><i class="fas fa-check-circle"></i> Đã mua tại TTB</span>
                        </div>
                        <span class="review-date">12 ngày trước</span>
                    </div>
                    <div class="my-2" style="color: #f59e0b; font-size: 0.85rem;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text mb-0">
                        Đàn thật sự rất đẹp, lớp sơn hoàn thiện mượt mà không tì vết. Âm thanh ấm và ngân vang lâu. Bạn tư vấn viên nhiệt tình giao hàng siêu tốc chỉ 2h trong nội thành. Cảm ơn shop rất nhiều!
                    </p>
                </div>

                <!-- Nhận xét 2 -->
                <div class="review-item">
                    <div class="review-header">
                        <div>
                            <span class="reviewer-name">Phạm Minh Thư</span>
                            <span class="reviewer-badge"><i class="fas fa-check-circle"></i> Đã mua tại TTB</span>
                        </div>
                        <span class="review-date">3 tuần trước</span>
                    </div>
                    <div class="my-2" style="color: #f59e0b; font-size: 0.85rem;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <p class="review-text mb-0">
                        Chất âm sáng, phím bấm êm tay thích hợp cho cả người mới tập và chuyên nghiệp. Mức giá quá hời so với chất lượng mang lại. Đóng gói rất kỹ, lồng 2 hộp các-tông và xốp hơi dày cộp.
                    </p>
                </div>

                <!-- Nhận xét 3 -->
                <div class="review-item">
                    <div class="review-header">
                        <div>
                            <span class="reviewer-name">Trần Hoàng Long</span>
                            <span class="reviewer-badge"><i class="fas fa-check-circle"></i> Đã mua tại TTB</span>
                        </div>
                        <span class="review-date">1 tháng trước</span>
                    </div>
                    <div class="my-2" style="color: #f59e0b; font-size: 0.85rem;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text mb-0">
                        Mình mua chiếc này để biểu diễn trên sân khấu phòng trà. Phải nói là hệ thống EQ hoạt động cực kì xuất sắc, tiếng ra loa trung thực không bị méo tiếng. Thiết kế viền neon tinh tế làm nổi bật hẳn khi ánh đèn sân khấu chiếu vào. Rất đáng đồng tiền bát gạo!
                    </p>
                </div>

                <!-- Nhận xét 4 -->
                <div class="review-item">
                    <div class="review-header">
                        <div>
                            <span class="reviewer-name">Lê Thị Khánh Vy</span>
                            <span class="reviewer-badge"><i class="fas fa-check-circle"></i> Đã mua tại TTB</span>
                        </div>
                        <span class="review-date">1 tháng trước</span>
                    </div>
                    <div class="my-2" style="color: #f59e0b; font-size: 0.85rem;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text mb-0">
                        Sản phẩm xịn xò, màu sắc sang trọng phù hợp với góc phòng khách của mình. Tiếng nhạc vang vọng rất dễ chịu giúp mình giải tỏa căng thẳng sau những giờ làm việc mệt mỏi. Shop hỗ trợ bảo hành lên tới 24 tháng nên cực kì yên tâm khi mua sắm tại đây.
                    </p>
                </div>

                <!-- Nhận xét 5 -->
                <div class="review-item">
                    <div class="review-header">
                        <div>
                            <span class="reviewer-name">Bùi Anh Tuấn</span>
                            <span class="reviewer-badge"><i class="fas fa-check-circle"></i> Đã mua tại TTB</span>
                        </div>
                        <span class="review-date">2 tháng trước</span>
                    </div>
                    <div class="my-2" style="color: #f59e0b; font-size: 0.85rem;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <p class="review-text mb-0">
                        Giao hàng trễ mất 1 ngày do mưa bão nhưng bù lại đóng gói cực kì cẩn thận. Nhạc cụ hoàn thiện tốt, cầm rất chắc tay và đầm. Âm bass dày dặn, các nốt cao tròn trịa không hề rè phím hay lệch âm. Sẽ ủng hộ shop thêm các sản phẩm phụ kiện khác trong tương lai.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================
         SẢN PHẨM NỔI BẬT KHÁC (RELATED CAROUSEL)
         ============================================================ -->
    <?php if (!empty($randomProducts)): ?>
    <div class="related-products-section mt-5 pt-4 mb-5">
        <h3 class="fw-bold mb-4" style="font-size: 1.6rem; color: var(--text-color); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-fire" style="color: #ef4444;"></i> Nhạc cụ nổi bật dành cho bạn
        </h3>
        
        <div class="carousel-container-outer">
            <!-- Nav buttons -->
            <button class="carousel-nav-btn prev-btn" id="carousel-prev-trigger" onclick="scrollCarousel('prev')">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="carousel-track-wrapper" id="related-carousel-track">
                <?php foreach ($randomProducts as $randProd): ?>
                    <div class="carousel-card-item">
                        <a href="index.php?controller=product&action=detail&id=<?= $randProd['id'] ?>" class="carousel-card-link">
                            <div class="carousel-card-img-wrap">
                                <img src="<?= htmlspecialchars($randProd['image']) ?>" alt="<?= htmlspecialchars($randProd['name']) ?>" class="carousel-card-img" loading="lazy">
                            </div>
                            <div class="carousel-card-info">
                                <div class="carousel-card-title"><?= htmlspecialchars($randProd['name']) ?></div>
                                <div class="carousel-card-price"><?= number_format($randProd['price'], 0, ',', '.') ?>₫</div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button class="carousel-nav-btn next-btn" id="carousel-next-trigger" onclick="scrollCarousel('next')">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>

</div><!-- /.container -->

<!-- Footer cho trang chi tiết sản phẩm (Bottom Sheet) -->
<footer class="mt-5 pt-5" style="background-color: var(--card-bg); border-top: 1px solid var(--border-color); padding: 60px 0 20px 0; position: relative; z-index: 10;">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <h4 class="fw-bold mb-3"><i class="fas fa-music text-primary me-2"></i>TTB MUSIC</h4>
                <p class="mb-4" style="color: var(--text-color); opacity: 0.8;">
                    Hệ thống cung cấp nhạc cụ hàng đầu, nơi khơi nguồn những giai điệu bất hủ và trải nghiệm âm nhạc đỉnh cao.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="social-circle-icon fb" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-circle-icon zl" title="Zalo"><i class="fas fa-comment-dots"></i></a>
                    <a href="#" class="social-circle-icon yt" title="Youtube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-circle-icon ins" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-2 offset-lg-1 col-md-4">
                <h5 class="fw-bold mb-3" style="color: var(--text-color);">Cửa hàng</h5>
                <ul class="list-unstyled footer-link-list">
                    <li><a href="index.php?controller=product&action=index&category=1">Guitar & Bass</a></li>
                    <li><a href="index.php?controller=product&action=index&category=2">Piano & Organ</a></li>
                    <li><a href="index.php?controller=product&action=index&category=3">Trống & Bộ gõ</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-4">
                <h5 class="fw-bold mb-3" style="color: var(--text-color);">Dịch vụ</h5>
                <ul class="list-unstyled footer-link-list">
                    <li><a href="#" class="text-warning fw-bold">Cho Thuê Nhạc Cụ</a></li>
                    <li><a href="#">Bảo hành tận nơi</a></li>
                    <li><a href="#">Học viện TTB</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h5 class="fw-bold mb-3" style="color: var(--text-color);">Liên hệ</h5>
                <ul class="list-unstyled" style="color: var(--text-color); opacity: 0.8;">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Quận 1, TP.HCM</li>
                    <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i> 1900 1000</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> contact@ttb.music</li>
                </ul>
            </div>
        </div>

        <hr class="mt-5 mb-4" style="border-color: var(--border-color); opacity: 0.2;">
        <div class="text-center small pb-3" style="color: var(--text-color); opacity: 0.6;">
            &copy; 2024 <strong>TTB MUSIC</strong>. Dự án PHP MVC chuẩn hướng đối tượng.
        </div>
    </div>
</footer>

<!-- Lightbox phóng to ảnh sản phẩm cao cấp -->
<div id="product-lightbox" class="product-lightbox-modal" onclick="window.closeLightbox()">
    <span class="lightbox-close-btn">&times;</span>
    <img class="lightbox-image-content" id="lightbox-img" alt="Ảnh sản phẩm phóng to">
</div>

<!-- ============================================================
     JAVASCRIPT TRANG CHI TIẾT SẢN PHẨM
     ============================================================ -->
<script>

/* ================================================================================
   PHẦN 1: CANVAS GLOWING MELODY CONSTELLATION - NỀN RIÊNG TRANG CHI TIẾT
   ================================================================================ */
window.initDetailCanvas = function() {
    const canvas = document.getElementById('detail-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height;
    const mouse = { x: null, y: null, radius: 150 };
    const musicSymbols = ['♪', '♫', '♬', '♩', '🎵', '🎶', '🎼'];
    let particles = [];
    const LINK_DISTANCE = 150;
    const PARTICLE_COUNT = 50;

    // Hủy các listener cũ của Detail Canvas nếu có để tránh rò rỉ bộ nhớ
    if (window.detailCanvasCleanup) {
        window.detailCanvasCleanup();
    }

    function resizeCanvas() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }
    function onCanvasMouseMove(e) {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    }
    function onCanvasMouseOut() {
        mouse.x = null;
        mouse.y = null;
    }

    window.addEventListener('resize', resizeCanvas);
    window.addEventListener('mousemove', onCanvasMouseMove);
    window.addEventListener('mouseout', onCanvasMouseOut);

    window.detailCanvasCleanup = function() {
        window.removeEventListener('resize', resizeCanvas);
        window.removeEventListener('mousemove', onCanvasMouseMove);
        window.removeEventListener('mouseout', onCanvasMouseOut);
        if (typeof carouselInterval !== 'undefined' && carouselInterval) {
            clearInterval(carouselInterval);
            carouselInterval = null;
        }
    };

    resizeCanvas();

    class MusicNode {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.baseX = this.x;
            this.baseY = this.y;
            this.vx = (Math.random() - 0.5) * 0.6;
            this.vy = (Math.random() - 0.5) * 0.6;
            this.size = Math.random() * 10 + 12;
            this.symbol = musicSymbols[Math.floor(Math.random() * musicSymbols.length)];
            this.hue = Math.floor(Math.random() * 40) + 250;
            this.glowRadius = Math.random() * 20 + 15;
            this.pulsePhase = Math.random() * Math.PI * 2;
            this.baseOpacity = Math.random() * 0.3 + 0.4;
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;

            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;

            this.x = Math.max(0, Math.min(width, this.x));
            this.y = Math.max(0, Math.min(height, this.y));

            if (mouse.x !== null && mouse.y !== null) {
                const dx = this.x - mouse.x;
                const dy = this.y - mouse.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < mouse.radius) {
                    const force = (mouse.radius - dist) / mouse.radius;
                    const angle = Math.atan2(dy, dx);
                    this.x += Math.cos(angle) * force * 5;
                    this.y += Math.sin(angle) * force * 5;
                }
            }
            this.pulsePhase += 0.02;
        }

        draw() {
            const pulse = Math.sin(this.pulsePhase) * 0.15 + this.baseOpacity;
            ctx.save();

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

            ctx.font = `${this.size}px serif`;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = `hsla(${this.hue}, 75%, 75%, ${pulse})`;
            ctx.fillText(this.symbol, this.x, this.y);

            ctx.restore();
        }
    }

    particles = [];
    for (let i = 0; i < PARTICLE_COUNT; i++) {
        particles.push(new MusicNode());
    }

    function drawConstellationLinks() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const a = particles[i];
                const b = particles[j];
                const dx = a.x - b.x;
                const dy = a.y - b.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < LINK_DISTANCE) {
                    const opacity = (1 - dist / LINK_DISTANCE) * 0.25;
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

    let animFrameId = null;
    function animate() {
        if (!canvas || !document.body.contains(canvas)) {
            if (animFrameId) cancelAnimationFrame(animFrameId);
            if (window.detailCanvasCleanup) {
                window.detailCanvasCleanup();
                window.detailCanvasCleanup = null;
            }
            return; // Dừng vòng lặp nếu canvas đã bị gỡ khỏi DOM (khi chuyển trang SPA)
        }
        ctx.clearRect(0, 0, width, height);
        drawConstellationLinks();
        particles.forEach(p => {
            p.update();
            p.draw();
        });
        animFrameId = requestAnimationFrame(animate);
    }
    animate();
};

/* ================================================================================
   PHẦN 2: CHUYỂN ẢNH CHỦ KHI CLICK THUMBNAIL
   ================================================================================ */
function switchImage(src, thumbEl) {
    const mainImg = document.getElementById('main-product-image');
    if (mainImg && src) {
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 200);
    }
    document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
    if (thumbEl) thumbEl.classList.add('active');
    
    // Reset rotation if switching image

    if (mainImg) {
        mainImg.style.transform = 'none';
    }
}

/* ================================================================================
   PHẦN 3: CHỌN MÀU SẮC & PHIÊN BẢN
   ================================================================================ */
function selectColor(btn) {
    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');

    const nameEl = document.getElementById('selected-color-name');
    if (nameEl) nameEl.textContent = '– ' + btn.dataset.color;

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

        document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
        const matchThumb = document.getElementById('thumb-' + btn.dataset.color);
        if (matchThumb) matchThumb.classList.add('active');
        
        // Reset rotation
    
        if (mainImg) {
            mainImg.style.transform = 'none';
        }
    }
}

function selectVersion(btn) {
    document.querySelectorAll('.version-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');

    const nameEl = document.getElementById('selected-version-name');
    if (nameEl) nameEl.textContent = '– ' + btn.dataset.version;
}

/* ================================================================================
   PHẦN 4: ĐIỀU KHIỂN SỐ LƯỢNG
   ================================================================================ */
function changeQty(delta) {
    const input = document.getElementById('qty-input');
    if (!input) return;

    const current = parseInt(input.value) || 1;
    const max = parseInt(input.max) || 999;
    const newVal = Math.min(max, Math.max(1, current + delta));
    input.value = newVal;

    calcInstallment();
}

/* ================================================================================
   PHẦN 5: TÍNH TRẢ GÓP
   ================================================================================ */
function calcInstallment() {
    const select = document.getElementById('installment-months');
    const resultEl = document.getElementById('installment-price');
    if (!select || !resultEl) return;

    const price = <?= (float)$product['price'] ?>;
    const months = parseInt(select.value) || 6;
    const qty = parseInt(document.getElementById('qty-input')?.value) || 1;

    const monthly = Math.ceil((price * qty) / months / 1000) * 1000;
    resultEl.textContent = new Intl.NumberFormat('vi-VN').format(monthly) + '₫';
}

/* ================================================================================
   PHẦN 6: CHUYỂN TAB MÔ TẢ / THÔNG SỐ
   ================================================================================ */
function switchTab(tabId, btnEl) {
    document.querySelectorAll('.tab-content-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.detail-tab-btn').forEach(b => b.classList.remove('active'));

    const panel = document.getElementById('tab-' + tabId);
    if (panel) panel.classList.add('active');
    if (btnEl) btnEl.classList.add('active');
}

/* ================================================================================
   PHẦN 7: THÊM VÀO GIỎ HÀNG (AJAX)
   ================================================================================ */
function addToCart(productId) {
    const qty = parseInt(document.getElementById('qty-input')?.value) || 1;
    const selectedColor = document.querySelector('.color-btn.selected')?.dataset.color || '';
    const selectedVersion = document.querySelector('.version-btn.selected')?.dataset.version || '';
    const btn = document.getElementById('btn-add-to-cart');

    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
    }

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
            const cartCounts = document.querySelectorAll('.cart-count');
            cartCounts.forEach(c => {
                c.textContent = data.cart_count;
                c.style.display = 'inline-block';
                c.style.transition = 'transform 0.15s ease-out';
                c.style.transform = 'scale(1.4)';
                setTimeout(() => c.style.transform = 'scale(1)', 150);
            });

            if (typeof flyToCart === 'function') {
                const imgUrl = document.getElementById('main-product-image').src;
                flyToCart(btn, imgUrl);
            }

            if (btn) {
                btn.innerHTML = '<i class="fas fa-check"></i> Đã thêm vào giỏ!';
                btn.style.background = 'linear-gradient(135deg, #10b981, #34d399)';
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
        alert('Không thể kết nối. Vui lòng thử lại.');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-cart-add" style="font-size:1.3rem"></i> Thêm vào giỏ hàng';
        }
    });
}

function openRentModal(productId) {
    alert('Tính năng thuê nhạc cụ đang được phát triển. Vui lòng liên hệ 1900 1000 để được hỗ trợ!');
}

/* ================================================================================
   PHẦN 8: LIGHTBOX PHÓNG TO ẢNH SẢN PHẨM CAO CẤP
   ================================================================================ */
window.openLightbox = function() {
    const mainImg = document.getElementById('main-product-image');
    const lightbox = document.getElementById('product-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    if (mainImg && lightbox && lightboxImg) {
        lightboxImg.src = mainImg.src;
        lightbox.style.display = 'flex';
        lightbox.offsetWidth; // Reflow
        lightbox.classList.add('active');
    }
};

window.closeLightbox = function() {
    const lightbox = document.getElementById('product-lightbox');
    if (lightbox) {
        lightbox.classList.remove('active');
        setTimeout(() => {
            lightbox.style.display = 'none';
        }, 300);
    }
};

/* ================================================================================
   PHẦN 9: ĐÁNH GIÁ SẢN PHẨM (REVIEWS)
   ================================================================================ */
function highlightStars(val) {
    const stars = document.querySelectorAll('.star-rating-input i');
    stars.forEach((star, index) => {
        if (index < val) {
            star.style.color = '#f59e0b';
        } else {
            star.style.color = 'rgba(255,255,255,0.15)';
        }
    });
}

function resetStars() {
    const currentVal = parseInt(document.getElementById('rating-input-val')?.value) || 5;
    highlightStars(currentVal);
}

function setRatingValue(val) {
    const input = document.getElementById('rating-input-val');
    if (input) input.value = val;
    highlightStars(val);
}

function submitReview(e) {
    e.preventDefault();
    const name = document.getElementById('review-name').value;
    const email = document.getElementById('review-email').value;
    const content = document.getElementById('review-content').value;
    const rating = parseInt(document.getElementById('rating-input-val').value) || 5;
    
    const btn = e.target.querySelector('button[type="submit"]');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
    }
    
    setTimeout(() => {
        const container = document.getElementById('reviews-container');
        if (container) {
            const newItem = document.createElement('div');
            newItem.className = 'review-item';
            newItem.style.opacity = '0';
            newItem.style.transform = 'translateY(20px)';
            newItem.style.transition = 'all 0.5s ease';
            
            let starsHTML = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    starsHTML += '<i class="fas fa-star" style="color: #f59e0b;"></i>';
                } else {
                    starsHTML += '<i class="far fa-star" style="color: #f59e0b;"></i>';
                }
            }
            
            newItem.innerHTML = `
                <div class="review-header">
                    <div>
                        <span class="reviewer-name">${escapeHTML(name)}</span>
                        <span class="reviewer-badge"><i class="fas fa-check-circle"></i> Đã mua tại TTB</span>
                    </div>
                    <span class="review-date">Vừa xong</span>
                </div>
                <div class="my-2" style="font-size: 0.85rem;">
                    ${starsHTML}
                </div>
                <p class="review-text mb-0">
                    ${escapeHTML(content)}
                </p>
            `;
            
            container.insertBefore(newItem, container.firstChild);
            
            setTimeout(() => {
                newItem.style.opacity = '1';
                newItem.style.transform = 'translateY(0)';
            }, 50);
        }
        
        document.getElementById('review-submit-form').reset();
        setRatingValue(5);
        
        alert('Cảm ơn bạn đã gửi đánh giá! Nhận xét của bạn đã được hiển thị bên dưới.');
        
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = 'Gửi đánh giá <i class="fas fa-paper-plane ms-2"></i>';
        }
    }, 1000);
}

function escapeHTML(str) {
    return str.replace(/[&<>'"]/g, 
        tag => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            "'": '&#39;',
            '"': '&quot;'
        }[tag] || tag)
    );
}

/* ================================================================================
   PHẦN 10: CAROUSEL SẢN PHẨM NỔI BẬT
   ================================================================================ */
var carouselInterval = null;

function initRelatedCarousel() {
    const track = document.getElementById('related-carousel-track');
    if (!track) return;
    
    if (carouselInterval) clearInterval(carouselInterval);
    
    carouselInterval = setInterval(() => {
        scrollCarousel('next');
    }, 3500);
    
    track.removeEventListener('mouseover', onCarouselMouseOver);
    track.addEventListener('mouseover', onCarouselMouseOver);
    function onCarouselMouseOver() {
        if (carouselInterval) clearInterval(carouselInterval);
    }
    
    track.removeEventListener('mouseout', onCarouselMouseOut);
    track.addEventListener('mouseout', onCarouselMouseOut);
    function onCarouselMouseOut() {
        if (carouselInterval) clearInterval(carouselInterval);
        carouselInterval = setInterval(() => {
            scrollCarousel('next');
        }, 3500);
    }
}

function scrollCarousel(direction) {
    const track = document.getElementById('related-carousel-track');
    if (!track) return;
    
    const card = track.querySelector('.carousel-card-item');
    if (!card) return;
    
    const scrollAmount = card.offsetWidth + 20;
    
    if (direction === 'next') {
        if (track.scrollLeft + track.offsetWidth >= track.scrollWidth - 5) {
            track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    } else {
        if (track.scrollLeft <= 0) {
            track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
        } else {
            track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        }
    }
}

/* ================================================================================
   PHẦN 11: LIFECYCLE VÀ KHỞI TẠO CHI TIẾT
   ================================================================================ */
window.initDetailPage = function() {
    const mainImg = document.getElementById('main-product-image');
    if (!mainImg) return;
    if (mainImg.dataset.initialized) return;
    mainImg.dataset.initialized = 'true';

    // Khởi động các module
    window.initDetailCanvas();
    
    initRelatedCarousel();
    calcInstallment();
    resetStars();
};

// Khởi chạy ngay lập tức khi load trang bình thường
if (document.readyState !== 'loading') {
    window.initDetailPage();
} else {
    document.addEventListener('DOMContentLoaded', window.initDetailPage);
}
</script>

<?php
// Gọi footer (chứa </body>, </html>, Bootstrap JS, Modal đăng nhập)
include __DIR__ . '/partials/footer.php';
?>
