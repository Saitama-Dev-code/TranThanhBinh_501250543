# Đợt 17: Sửa Lỗi Bảo Mật, Nghiệp Vụ & Dữ Liệu Thực Tế

Đợt cập nhật này tập trung khắc phục hoàn toàn các lỗ hổng bảo mật (CSRF, XSS), sửa đổi logic dữ liệu (trừ tồn kho khi mua, transaction toàn vẹn, kiểm tra trùng lịch thuê nhạc cụ), và nâng cao độ an toàn vận hành thực tế (mật khẩu guest ngẫu nhiên, ẩn mã OTP vào file log nội bộ).

---

## Các thay đổi đã thực hiện

### 1. Hệ thống Bảo mật (CSRF & XSS)
* **Verify CSRF dùng chung:** Di chuyển phương thức `verifyCSRF()` lên [BaseController.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/core/BaseController.php) và xóa bỏ khai báo trùng lặp ở [AuthController.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Controllers/AuthController.php).
* **Token CSRF trong Checkout:** Thêm input ẩn `csrf_token` trong form thanh toán [checkout.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Views/checkout.php) và gọi xác thực token ngay đầu action `process()` của [CheckoutController.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Controllers/CheckoutController.php).
* **Lọc XSS:** Áp dụng `htmlspecialchars()` để làm sạch Họ tên, SĐT, và Mã đơn hàng khi in ra ở trang đặt hàng thành công của [CheckoutController.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Controllers/CheckoutController.php).

### 2. An Toàn Vận Hành (OTP & Guest Password)
* **Ghi OTP vào File Log:** Sửa hàm `forgotSubmit()` để ghi mã OTP quên mật khẩu vào file log kiểm thử `scratch/otp_log.txt` trên server thay vì trả trực tiếp về giao diện cho client, giúp giả lập an toàn việc gửi mail thực tế.
* **Mật khẩu Guest ngẫu nhiên:** Tài khoản khách vãng lai tự tạo khi checkout sẽ được cấp một mật khẩu ngẫu nhiên dài 8 ký tự an toàn (thay vì lấy số điện thoại dễ bị đoán) và hiển thị cụ thể tại trang đặt hàng thành công để họ lưu lại.

### 3. Toàn Vẹn Dữ Liệu Đặt Hàng (Database Transaction)
* **Trừ tồn kho khi mua:** Viết hàm `deductStock()` trong [Product.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Models/Product.php) để giảm số lượng trong kho sản phẩm khi bán thành công.
* **Database Transaction:** Loại bỏ transaction nội bộ của [OrderDetail.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Models/OrderDetail.php). Thay vào đó bọc toàn bộ luồng tạo đơn hàng, lưu chi tiết đơn hàng, và trừ tồn kho vào một PDO Transaction duy nhất tại [CheckoutController.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Controllers/CheckoutController.php) để tránh rác dữ liệu nếu có lỗi xảy ra.
* **Kiểm tra tồn kho trước:** Chặn đặt hàng và báo lỗi tại Controller nếu số lượng mua vượt quá số lượng còn lại trong kho.

### 4. Logic Thuê Nhạc Cụ & Tránh Trùng Lịch
* **Check trùng lịch thuê:** Thêm hàm `checkOverlapRental()` trong [Rental.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Models/Rental.php) truy vấn DB đếm số lượng sản phẩm đó đã được thuê trong khoảng ngày chọn.
* **Ràng buộc tồn kho:** Chặn và báo lỗi cụ thể tại [RentalController.php](file:///c:/laragon/www/PHP2/TranThanhBinh_501250543/app/Controllers/RentalController.php) nếu nhạc cụ hết hàng hoặc tổng số lượng đang thuê trùng lịch cộng thêm yêu cầu mới vượt quá số lượng tồn kho của nhạc cụ đó.

---

## Hướng dẫn Kiểm tra (Manual Verification)

1. **Kiểm thử OTP Quên mật khẩu**:
   - Nhập email quên mật khẩu trên giao diện. Xác nhận không thấy OTP hiện ra ở client.
   - Mở file log `scratch/otp_log.txt` trên máy chủ, lấy OTP và điền vào form để đặt lại mật khẩu mới thành công.

2. **Kiểm thử CSRF**:
   - F12 sửa/xóa input ẩn `csrf_token` trong form checkout rồi bấm Đặt hàng.
   - Xác nhận: Hệ thống chặn đứng và báo lỗi bảo mật *"Token CSRF không hợp lệ"*.

3. **Kiểm thử Trừ Tồn Kho & Transaction**:
   - Đặt mua sản phẩm thành công -> Xác nhận số lượng tồn kho giảm tương ứng.
   - Thử gây lỗi lưu chi tiết -> Xác nhận đơn hàng lớn ở bảng `orders` tự động rollback sạch sẽ.

4. **Kiểm thử Trùng lịch thuê**:
   - Cho thuê 1 sản phẩm có stock = 1 trong khoảng ngày `01/06/2026 - 10/06/2026`.
   - Thuê tiếp chính sản phẩm đó từ `05/06/2026 - 12/06/2026` -> Xác nhận: Hệ thống báo lỗi trùng lịch chi tiết và chặn cho thuê.
