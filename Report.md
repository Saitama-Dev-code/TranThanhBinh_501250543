# Nhật ký Cập nhật Dự án (Changelog)

**Ngày cập nhật:** 18/05/2026

## 🚀 Cập Nhật Lần 5 (Tinh chỉnh Tối Ưu Hiển Thị)
1. **Slogan Trang Chủ (Hero Section):**
   - Tăng độ phủ đen của lớp Overlay (từ 0.6 lên 0.75) và thêm lớp bóng (text-shadow) siêu đậm cho chữ. Giúp câu Slogan "Giai Điệu Của Riêng Bạn" nổi bật rõ ràng, không bao giờ bị chìm vào video nền phía sau.
2. **Preloader Animation:**
   - Đã thêm lại chuỗi hiệu ứng `fadeInUp` của Animate.css vào chữ TTB MUSIC. Chữ sẽ lướt nhẹ từ dưới lên trên vô cùng mượt mà đúng như thiết kế cũ.
3. **Độ Rõ Ràng của Canvas Particle:**
   - Hệ thống Mưa Âm Nhạc giờ đây đã thông minh hơn: Nó tự động bắt được "Theme" bạn đang dùng. Nếu nền tối, nốt nhạc sẽ có màu Trắng sáng. Nếu nền sáng, nốt nhạc sẽ tự chuyển thành Đen nhám.
   - Đồng thời tăng nhẹ độ đậm (opacity) cơ bản để nốt nhạc dễ nhìn hơn ở chế độ Sáng.
4. **Dải Sóng Thương Hiệu Từng Cụm 3 (Chuẩn Mực):**
   - Viết lại quy luật sóng bằng CSS Keyframes (`travelingWave`). Giờ đây gợn sóng sẽ lướt qua **3 hãng đàn một lúc**, tạo thành hình ngọn đồi (một cái đỉnh, hai cái thoai thoải hai bên).
   - Chu kỳ sóng kéo dài 10 giây (Nghỉ 8.5 giây, chạy 1.5 giây), đúng yêu cầu "chầm chậm 5-10s mới chạy một lần".

---

## 🚀 Cập Nhật Lần 4 (Canvas Tương Tác Thật)
1. **Nền Mưa Âm Nhạc Bằng Canvas (Tương Tác Thật):**
   - Xóa bỏ hệ thống DOM Particle cũ. Thay thế bằng một hệ thống hạt **Canvas 2D siêu mượt**.
   - Các nốt nhạc giờ đây có tọa độ rơi hoàn toàn ngẫu nhiên (không bao giờ lặp lại theo cột).
   - Tương tác vật lý: Khi rê chuột vào khu vực nốt nhạc đang rơi, nốt nhạc sẽ **bị đẩy lùi ra xa (repel)**, đồng thời phóng to, đổi màu xanh dương và tỏa sáng bóng đổ (glow) vô cùng sống động. 
2. **Tinh chỉnh Dải Thương Hiệu (Brand Wave):**
   - Đã điều chỉnh lại `@keyframes smoothWave` và `transition` để các hãng đàn thỉnh thoảng mới "gợn sóng" lên thật chậm rãi và êm ái thay vì nhấp nhô liên tục.
   - Khi hover vào, hiệu ứng chuyển động mượt mà hơn rất nhiều, khắc phục triệt để cảm giác "khựng" hay "nhảy" khó chịu.

---

## 🚀 Cập Nhật Lần 3
1. **Lọc Sản Phẩm AJAX (Không tải lại trang):**
   - Áp dụng Fetch API vào `sanpham.php` để tải dữ liệu khi Click danh mục, chuyển trang hoặc tìm kiếm.
   - Ưu điểm: Tốc độ phản hồi cực nhanh, không làm chớp trang và không làm gián đoạn hiệu ứng Particle nền.
2. **Particle System (Mưa Âm Nhạc):**
   - Loại bỏ Nền cố định cũ. Thay bằng hệ thống JavaScript sinh ra các icon rơi liên tục từ trên xuống vô hạn (`header.php`).
   - Tương tác: Khi đưa chuột chạm vào, hạt sẽ tự động phóng to, đổi màu sáng rực và xoay.
3. **Preloader Mới:**
   - Quay lại sử dụng cụm sóng nhạc CSS nhưng được nâng cấp bằng dải màu Gradient (Xanh dương -> Xanh ngọc) và hiệu ứng Glow cực kỳ đẹp mắt.
4. **Dải Thương Hiệu (Brand Wave):**
   - Giảm xuống còn đúng 8 hãng đàn với icon không trùng lặp, vừa khít một dòng.

---

## 🎨 UI/UX & Hiệu ứng (Các đợt trước)
*(Giữ nguyên các hiệu ứng Lordicon, BicCamera Hover, Boxicons, Marquee cũ)*
- Đã nâng cấp các Card sản phẩm ở trang Cửa Hàng: Khi Hover, thẻ nổi lên, đồng thời hình ảnh đàn bên trong sẽ trượt lên và phóng to (3D Pop-out) cực kỳ ấn tượng giống hệt BicCamera. Chặn hiện tượng văng ảnh ra ngoài bằng `overflow: hidden`.
- Sửa lỗi màu ô Tìm kiếm (Placeholder) bị chìm vào nền Dark Mode.

## 📚 Tài liệu hóa & Comment (Documentation)
1. **`app/Views/partials/header.php`**: Comment rõ cơ chế hoạt động của logic kiểm tra URL (lấy `$currentController`) và điều kiện chạy Preloader.
2. **`app/Views/home.php`**: Cấu trúc lại phần Header và Footer import, giải thích logic mảng delay của hiệu ứng gợn sóng.
3. **`app/Views/sanpham.php`**: Thêm comment giải thích các câu lệnh điều kiện `if`, vòng lặp `foreach` cho danh mục và phân trang sản phẩm.
4. **`app/Controllers/AuthController.php`**: Phủ toàn bộ comment hướng dẫn cấu trúc một Controller mẫu (bảo mật form bằng `verifyCSRF`, hứng dữ liệu POST, xử lý mã hóa mật khẩu `password_hash`).

## ⚙️ Quản lý Mã nguồn (Git)
- Đã thực hiện `git add .` và `git commit` cho tất cả các bản chỉnh sửa.
