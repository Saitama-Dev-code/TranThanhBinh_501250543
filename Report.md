# Nhật ký Cập nhật Dự án (Changelog)

**Ngày cập nhật:** 18/05/2026

## 🎨 UI/UX & Hiệu ứng
1. **Preloader:** Đã loại bỏ hoàn toàn màn hình chờ (Preloader) khi người dùng thao tác trong phạm vi các trang danh mục / sản phẩm (`controller=product`). Tránh hiện tượng gián đoạn khi ấn "Tất cả nhạc cụ".
2. **Hiệu ứng Gợn Sóng (Wave Animation):**
   - Áp dụng trên dải logo thương hiệu (`app/Views/home.php`).
   - Xóa bỏ kiểu nhảy ngẫu nhiên cũ, thay bằng `@keyframes subtlePulse` chạy mượt mà từ trái sang phải bằng cách sử dụng các chỉ số `animation-delay` nối tiếp nhau.
3. **Thư viện bên thứ ba:**
   - Đã nhúng thành công **Boxicons**, **Animate.css**, **Hover.css** và **Lordicon** vào `<head>` (`header.php`).
   - Chuyển đổi icon "Thêm giỏ hàng" sang sử dụng icon siêu mỏng của Boxicons (`bx-cart-add`).
4. **Hiệu ứng BicCamera (3D Parallax & Pop-out):**
   - Đã khôi phục hoàn toàn JavaScript tính toán tọa độ chuột trong `header.php`, giúp các nốt nhạc ở nền trôi nổi ngược chiều chuột (Tạo không gian 3 chiều có chiều sâu).
   - Đã nâng cấp các Card sản phẩm ở trang Cửa Hàng: Thẻ tự động đứng nghiêng ngẫu nhiên $\pm1.5^\circ$. Khi Hover, thẻ thẳng lại, đồng thời hình ảnh đàn bên trong sẽ trượt lên và phóng to (3D Pop-out) cực kỳ ấn tượng giống hệt BicCamera.
   - Sửa lỗi màu ô Tìm kiếm (Placeholder) bị chìm vào nền Dark Mode.

## 📚 Tài liệu hóa & Comment (Documentation)
1. **`app/Views/partials/header.php`**: Comment rõ cơ chế hoạt động của logic kiểm tra URL (lấy `$currentController`) và điều kiện chạy Preloader.
2. **`app/Views/home.php`**: Cấu trúc lại phần Header và Footer import, giải thích logic mảng delay của hiệu ứng gợn sóng.
3. **`app/Views/sanpham.php`**: Thêm comment giải thích các câu lệnh điều kiện `if`, vòng lặp `foreach` cho danh mục và phân trang sản phẩm.
4. **`app/Controllers/AuthController.php`**: Phủ toàn bộ comment hướng dẫn cấu trúc một Controller mẫu (bảo mật form bằng `verifyCSRF`, hứng dữ liệu POST, xử lý mã hóa mật khẩu `password_hash`).

## ⚙️ Quản lý Mã nguồn (Git)
- Đã thực hiện `git add .` và `git commit` cho phiên bản hoàn chỉnh nhất.
