# Nhật ký Cập nhật Dự án (Changelog)

**Ngày cập nhật:** 18/05/2026

## 🎨 UI/UX & Hiệu ứng
1. **Preloader:** Đã loại bỏ hoàn toàn màn hình chờ (Preloader) khi người dùng thao tác trong phạm vi các trang danh mục / sản phẩm (`controller=product`). Tránh hiện tượng gián đoạn khi ấn "Tất cả nhạc cụ".
2. **Hiệu ứng Gợn Sóng (Wave Animation):**
   - Áp dụng trên dải logo thương hiệu (`app/Views/home.php`).
   - Xóa bỏ kiểu nhảy ngẫu nhiên cũ, thay bằng `@keyframes subtlePulse` chạy mượt mà từ trái sang phải bằng cách sử dụng các chỉ số `animation-delay` nối tiếp nhau.
3. **Thư viện bên thứ ba:**
   - Đã nhúng thành công **Boxicons**, **Animate.css**, **Hover.css** và **Lordicon** vào `<head>` (`header.php`).
   - Áp dụng lớp `hvr-float` từ Hover.css cho các Card Sản Phẩm (`sanpham.php`, `home.php`), giúp hiệu ứng nhấc nổi ổn định và mượt mà hơn.
   - Chuyển đổi icon "Thêm giỏ hàng" sang sử dụng icon siêu mỏng của Boxicons (`bx-cart-add`).

## 📚 Tài liệu hóa & Comment (Documentation)
1. **`app/Views/partials/header.php`**: Comment rõ cơ chế hoạt động của logic kiểm tra URL (lấy `$currentController`) và điều kiện chạy Preloader.
2. **`app/Views/home.php`**: Cấu trúc lại phần Header và Footer import, giải thích logic mảng delay của hiệu ứng gợn sóng.
3. **`app/Views/sanpham.php`**: Thêm comment giải thích các câu lệnh điều kiện `if`, vòng lặp `foreach` cho danh mục và phân trang sản phẩm.
4. **`app/Controllers/AuthController.php`**: Phủ toàn bộ comment hướng dẫn cấu trúc một Controller mẫu (bảo mật form bằng `verifyCSRF`, hứng dữ liệu POST, xử lý mã hóa mật khẩu `password_hash`).

## ⚙️ Quản lý Mã nguồn (Git)
- Hệ thống đã sẵn sàng trạng thái để ghi đè (Add) và tạo điểm khôi phục (Commit).
- `git add .` và `git commit -m "Cập nhật UI/UX, thêm hiệu ứng gợn sóng và comment code"` đã được chuẩn bị.
