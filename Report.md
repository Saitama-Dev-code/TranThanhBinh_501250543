# Nhật ký Cập nhật Dự án (Changelog)

**Ngày cập nhật:** 18/05/2026

## 🚀 Cập Nhật Lần 3 (Mới nhất)
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
   - Chỉnh lại `@keyframes smoothWave` để dải lụa chỉ lượn sóng lên xuống mượt mà. Loại bỏ hiệu ứng phát sáng tự động (Chỉ phát sáng khi rê chuột vào) để tránh rối mắt.

---

## 🎨 UI/UX & Hiệu ứng (Các đợt trước)
1. **Preloader (Cập nhật cũ):** 
   - Đã nhúng thành công hệ thống **Lordicon (Lottie animation)** vào màn hình tải trang để xoay mượt mà, đẳng cấp như các website quốc tế.
   - Chữ Loading được gắn hiệu ứng fadeIn từ thư viện **Animate.css**.
2. **Hiệu ứng Dải Logo (Wave Animation):**
   - Loại bỏ cơ chế vòng lặp (Marquee) bị lỗi mất chữ. Chuyển sang dạng dải tĩnh với lượng thương hiệu dàn trải.
   - Khôi phục lại hiệu ứng gợn sóng `@keyframes subtlePulse` chạy mượt mà từ trái sang phải bằng cách sử dụng các chỉ số `animation-delay` nối tiếp nhau.
3. **Thư viện bên thứ ba:**
   - Đã nhúng thành công **Boxicons**, **Animate.css**, **Hover.css** và **Lordicon** vào `<head>` (`header.php`).
   - Chuyển đổi icon "Thêm giỏ hàng" sang sử dụng icon siêu mỏng của Boxicons (`bx-cart-add`).
4. **Hiệu ứng BicCamera (3D Parallax & Pop-out):**
   - Đã khôi phục hoàn toàn JavaScript tính toán tọa độ chuột trong `header.php`. Đồng thời thay icon tĩnh thành các icon nét mảnh của **Boxicons** và cấy thêm tính năng tự đập nhịp tim bằng **Animate.css**. Kết quả là nền vừa trôi theo chuột, vừa nhấp nháy sống động.
   - Đã nâng cấp các Card sản phẩm ở trang Cửa Hàng: Khi Hover, thẻ nổi lên, đồng thời hình ảnh đàn bên trong sẽ trượt lên và phóng to (3D Pop-out) cực kỳ ấn tượng giống hệt BicCamera. Chặn hiện tượng văng ảnh ra ngoài bằng `overflow: hidden`.
   - Sửa lỗi màu ô Tìm kiếm (Placeholder) bị chìm vào nền Dark Mode.

## 📚 Tài liệu hóa & Comment (Documentation)
1. **`app/Views/partials/header.php`**: Comment rõ cơ chế hoạt động của logic kiểm tra URL (lấy `$currentController`) và điều kiện chạy Preloader.
2. **`app/Views/home.php`**: Cấu trúc lại phần Header và Footer import, giải thích logic mảng delay của hiệu ứng gợn sóng.
3. **`app/Views/sanpham.php`**: Thêm comment giải thích các câu lệnh điều kiện `if`, vòng lặp `foreach` cho danh mục và phân trang sản phẩm.
4. **`app/Controllers/AuthController.php`**: Phủ toàn bộ comment hướng dẫn cấu trúc một Controller mẫu (bảo mật form bằng `verifyCSRF`, hứng dữ liệu POST, xử lý mã hóa mật khẩu `password_hash`).

## ⚙️ Quản lý Mã nguồn (Git)
- Đã thực hiện `git add .` và `git commit` cho tất cả các bản chỉnh sửa.
