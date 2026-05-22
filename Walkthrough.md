# Đợt 14: Tối ưu Trải nghiệm Xác thực và Giỏ hàng

## Các thay đổi đã thực hiện

### 1. Hệ thống Xác thực (Authentication)
* **Khắc phục lỗi mật khẩu tài khoản Admin cũ:** Sửa `loginSubmit` trong `AuthController`. Bổ sung điều kiện kiểm tra mật khẩu bằng chữ thường (plaintext) ở DB cũ. Nếu khớp, tự động đăng nhập và băm lại mật khẩu bằng Bcrypt cập nhật vào DB.
* **Cải thiện trải nghiệm Đăng ký:** Chuyển từ cơ chế báo lỗi bằng `die()` sang session flash message hiển thị đẹp mắt ngay trong thẻ div. Tự động lưu giá trị input (Họ tên, Email) khi đăng ký sai mật khẩu.
* **Tự động Đăng nhập:** Sau khi đăng ký thành công, tự động lưu thông tin vào `$_SESSION['user']` và chuyển thẳng về trang chủ mà không bắt đăng nhập lại.
* **Hiển thị lỗi Modal Đăng nhập:** Hiển thị thông báo sai email/mật khẩu ngay trong modal ở trang chủ, thay vì thông báo bằng text xấu xí.
* **Bảo mật và Validations đầy đủ:** Thêm các kiểm tra email định dạng hợp lệ, độ dài mật khẩu >= 6, và so sánh khớp mật khẩu xác nhận trong `registerSubmit`.

### 2. Trải nghiệm Giỏ hàng (Cart UX)
* **Cải tiến logic xóa sản phẩm trong `cart.php`:** Trước đây, khi xóa sản phẩm cuối cùng, trang web sẽ tải lại (reload) toàn bộ để chuyển sang giao diện "Giỏ trống". Hiện tại, giao diện giỏ trống được hiển thị mượt mà bằng Javascript và CSS transition (Opacity & Translation) mà không cần tải lại trang.
* **Khung câu hỏi xóa sản phẩm (Delete Confirmation Modal):** Thêm một modal xác nhận thiết kế chuẩn Glassmorphism trong `cart.php`. Khi người dùng click nút "Xóa" hoặc giảm số lượng về 0, modal sẽ hiển thị để xác nhận hành vi trước khi xóa.
* **Cập nhật dòng chữ phụ đề giỏ hàng:** Đồng bộ hóa số lượng sản phẩm trong giỏ hàng real-time qua JavaScript và hiển thị thông tin ở phụ đề mà không cần tải lại trang.

### 3. Hiệu ứng Bay Giỏ hàng (Flying to Cart Animation)
* **Viết thư viện JS dùng chung:** Bổ sung hàm `flyToCart()` và `addToCartAJAX()` vào `partials/footer.php` để dùng chung.
* **Tối ưu hóa GPU-Accelerated Animation:** Sử dụng thuộc tính `transform: translate(dx, dy) scale(0.15)` thay vì thay đổi thuộc tính `left` và `top` để giảm thiểu hiện tượng Reflow của trình duyệt, giúp animation hoạt động cực kỳ mượt mà ở mức 60/120 FPS.
* **Bắt đầu bay từ ảnh sản phẩm:** Cải tiến hàm `flyToCart` tự động tìm kiếm hình ảnh sản phẩm trong card hoặc ảnh chi tiết để làm điểm bắt đầu bay thay vì bay từ nút bấm, tạo cảm giác hình ảnh sản phẩm thu nhỏ và bay vào giỏ hàng.
* **Bảo vệ sự kiện:** Thêm điều kiện kiểm tra sự kiện `event` trước khi gọi `event.preventDefault()` trong `addToCartAJAX`.

### 4. Sửa lỗi tương thích trình duyệt (Browser Compatibility)
* **Fix Canvas Mouse Events trên Firefox:** Thay đổi thuộc tính `e.x`/`e.y` thành `e.clientX`/`e.clientY` trong script của `header.php` để tương thích hoàn toàn với trình duyệt Firefox.
* **Dọn dẹp Badge phụ:** Xóa bỏ hoàn toàn badge đỏ phụ (`.cart-badge` / `#cart-badge`) ở góc trên phải nút giỏ hàng, chỉ giữ lại số lượng ở giữa nút để tránh trùng lặp thông tin.
* **Khôi phục hiển thị Footer:** Loại bỏ thuộc tính `data-aos` khỏi các cột footer trong `footer.php` để tránh hiện tượng footer bị ẩn vĩnh viễn trên trang chủ nếu scroll tracker tính toán sai lệch.

## Kết quả Kiểm tra
* **[Thành công]** Đăng ký tài khoản lỗi (thiếu trường, sai trường). Báo lỗi mượt mà trên UI.
* **[Thành công]** Đăng ký đúng, đăng nhập ngay, thẻ navbar hiển thị "Tài Khoản".
* **[Thành công]** Click mua sản phẩm ở Trang chủ, Sản phẩm, Chi tiết: Sản phẩm tạo avatar nhỏ, bay thẳng vào Icon Giỏ ở góc trên bên phải màn hình.
* **[Thành công]** Vào trang Giỏ Hàng, xóa sản phẩm hoặc giảm về 0: Hiển thị modal glassmorphism xác nhận xóa.
* **[Thành công]** Đồng ý xóa sản phẩm duy nhất: Form 2 cột ẩn đi, khung Giỏ Hàng Trống hiện lên mượt mà và cập nhật phụ đề số lượng sản phẩm.
