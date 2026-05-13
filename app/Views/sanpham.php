<!DOCTYPE html>
<html lang="vi" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* [COPY TOÀN BỘ PHẦN <style> BIẾN MÀU VÀ NỀN TỪ TRANG home.php SANG ĐÂY] */
        :root[data-theme="light"] { --bg-color: #f8fafc; --text-color: #0f172a; --card-bg: #ffffff; --border-color: #e2e8f0; --nav-bg: rgba(255, 255, 255, 0.85); }
        :root[data-theme="dark"] { --bg-color: #0f172a; --text-color: #f8fafc; --card-bg: #1e293b; --border-color: #334155; --nav-bg: rgba(15, 23, 42, 0.85); }
        body { background-color: var(--bg-color); color: var(--text-color); padding-top: 76px; transition: 0.4s; }
        
        /* Style riêng cho trang sản phẩm */
        .sidebar-category { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; }
        .category-link { color: var(--text-color); text-decoration: none; padding: 10px 15px; display: block; border-bottom: 1px solid var(--border-color); transition: 0.3s; }
        .category-link:hover, .category-link.active { background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-weight: bold; border-left: 4px solid #3b82f6; }
        
        .product-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; transition: 0.3s; overflow: hidden; height: 100%; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); border-color: #3b82f6; }
        .product-img { height: 200px; width: 100%; object-fit: contain; padding: 15px; }
    </style>
</head>
<body>
    
    <div class="container my-5 pt-4">
        <div class="row">
            <div class="col-lg-3 mb-4">
                
                <form action="index.php" method="GET" class="mb-4">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="index">
                    
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-transparent text-light border-secondary" placeholder="Tên nhạc cụ..." value="<?= htmlspecialchars($currentKeyword) ?>">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>

                <div class="sidebar-category overflow-hidden">
                    <h5 class="p-3 mb-0 fw-bold border-bottom" style="border-color: var(--border-color) !important;">
                        <i class="fas fa-list me-2"></i>Danh mục
                    </h5>
                    <a href="index.php?controller=product&action=index" class="category-link <?= empty($currentCategory) ? 'active' : '' ?>">
                        <i class="fas fa-music me-2"></i> Tất cả nhạc cụ
                    </a>
                    
                    <?php
                    /**
                     * VÒNG LẶP FOREACH: Đổ dữ liệu danh mục lấy từ CSDL ra HTML.
                     * Dùng cấu trúc <?= ?> (viết tắt của <?php echo ?>) để in dữ liệu mảng.
                     */
                    foreach ($categories as $cat) {
                        // Kiểm tra xem danh mục này có đang được chọn không để tô đậm (active)
                        $isActive = ($currentCategory == $cat['id']) ? 'active' : '';
                        echo '<a href="index.php?controller=product&action=index&category='.$cat['id'].'" class="category-link '.$isActive.'">';
                        echo '<i class="'.$cat['icon'].' me-2"></i> ' . $cat['name'];
                        echo '</a>';
                    }
                    ?>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3" style="border-color: var(--border-color) !important;">
                    <h4 class="fw-bold mb-0">Cửa hàng nhạc cụ</h4>
                    <span class="text-muted">Trang <?= $currentPage ?> / <?= $totalPages ?></span>
                </div>

                <div class="row g-4">
                    <?php
                    // Lặp qua mảng sản phẩm. Nếu mảng trống (không tìm thấy), báo lỗi.
                    if (count($products) > 0) {
                        foreach ($products as $p) {
                    ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="product-card d-flex flex-column">
                                    <a href="index.php?controller=product&action=detail&id=<?= $p['id'] ?>">
                                        <img src="<?= $p['image'] ?>" class="product-img" alt="<?= $p['name'] ?>">
                                    </a>
                                    
                                    <div class="p-3 d-flex flex-column flex-grow-1 text-center">
                                        <?php if($p['is_rentable']) echo '<span class="badge bg-warning text-dark mx-auto mb-2">Có cho thuê</span>'; ?>
                                        <h6 class="fw-bold text-truncate"><?= $p['name'] ?></h6>
                                        <p class="text-primary fw-bolder fs-5 mt-auto"><?= number_format($p['price'], 0, ',', '.') ?> ₫</p>
                                        
                                        <button class="btn btn-outline-primary w-100 rounded-pill mt-2">
                                            <i class="fas fa-cart-plus me-2"></i>Thêm giỏ hàng
                                        </button>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="col-12 text-center py-5"><h5 class="text-muted"><i class="fas fa-box-open fa-3x mb-3 d-block"></i>Không tìm thấy nhạc cụ nào phù hợp.</h5></div>';
                    }
                    ?>
                </div>

                <?php if ($totalPages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php 
                        // Dùng vòng lặp for để in ra số thứ tự trang từ 1 đến tổng số trang
                        for ($i = 1; $i <= $totalPages; $i++) { 
                            $activeClass = ($i == $currentPage) ? 'active' : '';
                            
                            // Phải nối thêm keyword và category vào link phân trang để khi bấm sang trang 2, nó không mất bộ lọc
                            $link = "index.php?controller=product&action=index&page={$i}";
                            if (!empty($currentKeyword)) $link .= "&search={$currentKeyword}";
                            if (!empty($currentCategory)) $link .= "&category={$currentCategory}";
                        ?>
                            <li class="page-item <?= $activeClass ?>">
                                <a class="page-link" href="<?= $link ?>"><?= $i ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php include __DIR__ . '/partials/chat_and_scroll.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>