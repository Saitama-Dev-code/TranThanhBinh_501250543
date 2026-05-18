<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/sanpham.php
 * MÔ TẢ: Trang hiển thị danh sách sản phẩm. Sử dụng header.php và footer.php.
 * XỬ LÝ LỖI: Tất cả các biến từ Controller truyền sang đều được bọc bởi ?? ''
 * để ngăn chặn hoàn toàn lỗi Undefined Variable.
 * =========================================================================
 */
include __DIR__ . '/partials/header.php';
?>

<style>
    .sidebar-category { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; }
    .category-link { position: relative; color: var(--text-color); text-decoration: none; padding: 12px 15px; display: block; border-bottom: 1px solid var(--border-color); transition: background 0.3s ease, color 0.3s ease; overflow: hidden; }
    .category-link::before { content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 4px; background: #3b82f6; transform: translateX(-100%); transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); }
    .category-link:hover, .category-link.active { background: rgba(59, 130, 246, 0.05); color: #3b82f6; }
    .category-link:hover::before, .category-link.active::before { transform: translateX(0); }
    .category-link i { transition: transform 0.3s ease; display: inline-block; }
    .category-link:hover i, .category-link.active i { transform: translateX(5px) scale(1.1); }
    
    /* Sửa màu Placeholder để dễ đọc trên nền tối */
    .form-control::placeholder { color: rgba(255, 255, 255, 0.5) !important; font-style: italic; }
    
    /* Hiệu ứng 3D Pop-out thanh lịch (Đã bỏ nghiêng ngả lộn xộn) */
    .product-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.4s ease, border-color 0.4s ease; overflow: hidden; height: 100%; position: relative; z-index: 1; }
    .product-wrapper:hover .product-card { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); border-color: #3b82f6; z-index: 10; }
    
    /* Ảnh sản phẩm bật ra tinh tế khi hover */
    .product-img { height: 200px; width: 100%; object-fit: contain; padding: 15px; transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); }
    .product-wrapper:hover .product-img { transform: scale(1.1); filter: drop-shadow(0 8px 8px rgba(0,0,0,0.15)); }
</style>

<div class="container my-5 pt-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <form action="index.php" method="GET" class="mb-4">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="index">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-transparent text-light border-secondary" placeholder="Tên nhạc cụ..." value="<?= htmlspecialchars($currentKeyword ?? '') ?>">
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
                // Kiểm tra xem danh sách thể loại có tồn tại không trước khi lặp
                if(isset($categories) && is_array($categories)) {
                    foreach ($categories as $cat) {
                        // Xác định xem danh mục này có trùng với danh mục trên URL không (active)
                        $catId = $currentCategory ?? null;
                        $isActive = ($catId == $cat['id']) ? 'active' : '';
                        echo '<a href="index.php?controller=product&action=index&category='.$cat['id'].'" class="category-link '.$isActive.'">';
                        echo '<i class="'.$cat['icon'].' me-2"></i> ' . $cat['name'];
                        echo '</a>';
                    }
                }
                ?>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3" style="border-color: var(--border-color) !important;">
                <h4 class="fw-bold mb-0">Cửa hàng nhạc cụ</h4>
                <span class="text-muted">Trang <?= $currentPage ?? 1 ?> / <?= $totalPages ?? 1 ?></span>
            </div>

            <div class="row g-4">
                <?php
                // Kiểm tra xem có sản phẩm nào được trả về từ DB không
                if (isset($products) && is_array($products) && count($products) > 0) {
                    // Lặp qua từng sản phẩm để hiển thị Card
                    foreach ($products as $p) {
                ?>
                        <div class="col-md-4 col-sm-6 product-wrapper">
                            <!-- Hiệu ứng Tilt và Pop-out do CSS điều khiển qua product-wrapper -->
                            <div class="product-card d-flex flex-column">
                                <a href="index.php?controller=product&action=detail&id=<?= $p['id'] ?>">
                                    <img src="<?= $p['image'] ?>" class="product-img" alt="<?= $p['name'] ?>">
                                </a>
                                
                                <div class="p-3 d-flex flex-column flex-grow-1 text-center">
                                    <?php if($p['is_rentable']) echo '<span class="badge bg-warning text-dark mx-auto mb-2">Có cho thuê</span>'; ?>
                                    <h6 class="fw-bold text-truncate"><?= $p['name'] ?></h6>
                                    <p class="text-primary fw-bolder fs-5 mt-auto"><?= number_format($p['price'], 0, ',', '.') ?> ₫</p>
                                    
                                    <button class="btn btn-outline-primary w-100 rounded-pill mt-2">
                                        <i class='bx bx-cart-add fs-5 align-middle me-2'></i>Thêm giỏ hàng
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

            <?php 
            // XỬ LÝ PHÂN TRANG (PAGINATION)
            $totPages = $totalPages ?? 1;
            $curPage = $currentPage ?? 1;
            // Chỉ hiển thị thanh phân trang nếu có nhiều hơn 1 trang
            if ($totPages > 1): 
            ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php 
                    for ($i = 1; $i <= $totPages; $i++) { 
                        $activeClass = ($i == $curPage) ? 'active' : '';
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

<?php
// Gọi thẻ Footer vào cuối trang
include __DIR__ . '/partials/footer.php';
?>