# WEBSITE BÁN NHẠC CỤ - DỰ ÁN PHP2
## Tính năng chính

### Front-end (Khách hàng)
✅: Xem danh sách sản phẩm có phân trang (6 sản phẩm/trang, 3 sản phẩm/hàng)
✅: Hiển thị danh mục sản phẩm với icon
✅: Tìm kiếm sản phẩm theo tên
✅: Lọc sản phẩm theo danh mục
✅: Xem chi tiết sản phẩm
✅: Thêm sản phẩm vào giỏ hàng
✅: Cập nhật số lượng trong giỏ hàng
✅: Xoá sản phẩm vào giỏ hàng
✅: Đăng ký tài khoản
✅: Đăng nhập/Đăng xuất
✅: Quên mật khẩu (gửi email reset)
✅: Xem thông tin tài khoản
✅: Cập nhật thông tin cá nhân
✅: Đổi mật khẩu
✅: Xem đơn hàng của tôi
✅: Xem chi tiết từng đơn hàng
✅: Đặt hàng
✅: Nghe thử âm thanh (Audio Player) mẫu của nhạc cụ
✅: Xem sản phẩm 360 độ và thu phóng chi tiết
✅: Xem hình ảnh thực tế, số Serial và cân nặng của từng sản phẩm (Guitar Gallery)
✅: So sánh thông số kỹ thuật giữa nhiều sản phẩm
✅: Gợi ý mua kèm phụ kiện với giá ưu đãi (Combo/Bundle)
✅: Tính toán trả góp trực tiếp trên trang chi tiết sản phẩm
✅: Chat trực tiếp với chuyên gia tư vấn (Live Chat)
✅: Nhận thông báo qua email khi sản phẩm có hàng lại
✅: Hiển thị cảnh báo số lượng tồn kho khan hiếm (Stock Alerts)

### Admin Panel
✅: Dashboard thống kê (doanh thu, đơn hàng, khách hàng, sản phẩm)
✅: Quản lý sản phẩm (Thêm/Sửa/Xoá)
✅: Upload hình ảnh sản phẩm
✅: Quản lý loại sản phẩm (Thêm/Sửa/Xoá)
✅: Quản lý đơn hàng
✅: Cập nhật trạng thái đơn hàng (Chờ xác nhận, Đang giao, Hoàn thành, Đã huỷ)
✅: Xem chi tiết đơn hàng
✅: Quản lý khách hàng
✅: Thống kê sản phẩm bán chạy
✅: Thống kê doanh thu theo tháng

## 🔧 Công nghệ sử dụng
- **Backend**: PHP 5.6+ (Pure PHP, no famework)
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 5
- **Library JS**: jQuery
- **Icons**: Font Awesome 5
- **Email**: PHPMailer (SMTP)
- **Architecture**: MVC Pattern

# 🗄️ Thiết kế Cơ sở dữ liệu (Database Schema)

Dự án sử dụng cơ sở dữ liệu MySQL/MariaDB với 5 bảng chính, được thiết kế để tối ưu hóa việc quản lý người dùng, sản phẩm và luồng đặt hàng.

### 1. Bảng users (Khách hàng & Admin)
Quản lý thông tin tài khoản đăng nhập. Phân quyền được xử lý qua cột role.

-`id` (INT, PK, Auto Increment): Mã người dùng (Khóa chính)
-`full_name` (VARCHAR(100), Not Null): Họ và tên đầy đủ
-`email` (VARCHAR(100), Not Null, Unique): Email đăng nhập
-`password` (VARCHAR(255), Not Null): Mật khẩu (đã băm bảo mật)
-`phone` (VARCHAR(20), Nullable): Số điện thoại liên hệ
-`address` (TEXT, Nullable): Địa chỉ giao hàng mặc định
-`role` (TINYINT, Default 0): Phân quyền: 0 (Khách hàng), 1 (Admin)
-`reset_token` (VARCHAR(255), Nullable): Lưu token phục hồi mật khẩu
-`created_at` (TIMESTAMP, Default Current): Thời gian tạo tài khoản

### 2. Bảng categories (Danh mục nhạc cụ)
Lưu trữ các nhóm nhạc cụ (VD: Guitar, Piano, Trống,...).

-`id` (INT, PK, Auto Increment): Mã danh mục (Khóa chính)
-`name` (VARCHAR(100), Not Null): Tên danh mục nhạc cụ
-`icon` (VARCHAR(50), Nullable): Class icon hiển thị (VD: fas fa-guitar)
-`created_at` (TIMESTAMP, Default Current): Thời gian tạo

### 3. Bảng products (Sản phẩm)
Quản lý thông tin chi tiết của từng mặt hàng nhạc cụ.

-`id` (INT, PK, Auto Increment): Mã sản phẩm (Khóa chính)
-`category_id` (INT, FK): Liên kết tới bảng categories
-`name` (VARCHAR(255), Not Null): Tên sản phẩm
-`price` (DECIMAL(10,2), Not Null): Giá bán
-`image` (VARCHAR(255), Nullable): Đường dẫn hình ảnh sản phẩm
-`description` (TEXT, Nullable): Bài viết mô tả chi tiết
-`stock` (INT, Default 0): Số lượng còn lại trong kho
-`created_at` (TIMESTAMP, Default Current): Thời gian thêm sản phẩm

### 4. Bảng orders (Đơn hàng)
Lưu trữ thông tin tổng quan khi khách hàng thực hiện thanh toán.

-`id` (INT, PK, Auto Increment): Mã đơn hàng (Khóa chính)
-`user_id` (INT, FK): Người đặt (Liên kết bảng users)
-`total_price` (DECIMAL(10,2), Not Null): Tổng giá trị đơn hàng
-`status` (ENUM, Default 'pending'): Trạng thái: pending, shipping, completed, canceled
-`shipping_address` (TEXT, Not Null): Địa chỉ nhận hàng thực tế
-`receiver_phone` (VARCHAR(20), Not Null): Số điện thoại người nhận hàng
-`created_at` (TIMESTAMP, Default Current): Ngày giờ tạo đơn hàng

### 5. Bảng order_details (Chi tiết đơn hàng)
Quản lý danh sách các sản phẩm bên trong một đơn hàng cụ thể, lưu trữ giá tại thời điểm mua.

-`id` (INT, PK, Auto Increment): Mã chi tiết (Khóa chính)
-`order_id` (INT, FK): Thuộc đơn hàng nào (bảng orders)
-`product_id` (INT, FK): Sản phẩm được mua (bảng products)
-`quantity` (INT, Not Null): Số lượng mua của sản phẩm này
-`price` (DECIMAL(10,2), Not Null): Giá sản phẩm tại thời điểm đặt hàng