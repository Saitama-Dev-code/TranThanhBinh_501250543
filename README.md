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
✅: Lọc nhạc cụ theo tiêu chí "Có sẵn để thuê"
✅: Chọn ngày bắt đầu và ngày kết thúc thuê (Date Picker)
✅: Tự động tính toán tổng phí thuê và tiền cọc
✅: Xem lịch sử các hợp đồng thuê đang hoạt động/đã trả

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
✅: Quản lý hợp đồng thuê (Duyệt, Bàn giao, Đã nhận lại)
✅: Xử lý hoàn tiền cọc cho khách khi trả nhạc cụ
✅: Tính toán và cập nhật phí phạt nếu trả trễ hạn

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

### 1. Bảng users (Khách hàng & Admin)(Cập nhật Đăng nhập MXH & Phân quyền)
Quản lý thông tin tài khoản đăng nhập, hỗ trợ đăng nhập truyền thống và qua mạng xã hội (Google, Facebook, Zalo). Phân quyền đa cấp độ được xử lý qua cột role.

-`id` (INT, PK, Auto Increment): Mã người dùng (Khóa chính)
-`full_name` (VARCHAR(100), Not Null): Họ và tên đầy đủ
-`email` (VARCHAR(100), Nullable, Unique): Email đăng nhập (Có thể Null nếu đăng nhập bằng Zalo/Facebook không cấp quyền email)
-`password` (VARCHAR(255), Nullable): Mật khẩu (Đã băm. Cho phép Null nếu đăng nhập bằng mạng xã hội)
-`phone` (VARCHAR(20), Nullable): Số điện thoại liên hệ
-`address` (TEXT, Nullable): Địa chỉ giao hàng mặc định
-`role` (TINYINT, Default 0): Phân quyền: 0 (Khách hàng), 1 (Super Admin - Toàn quyền), 2 (Quản lý sản phẩm), 3 (Quản lý đơn hàng)
-`provider` (VARCHAR(50), Nullable): Tên nền tảng đăng nhập (VD: 'google', 'facebook', 'zalo', hoặc để Null nếu đăng ký thường)
-`provider_id` (VARCHAR(255), Nullable): Mã ID định danh duy nhất được trả về từ Google/Facebook/Zalo
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
-`is_rentable` (TINYINT, Default 0): 1 = Cho thuê, 0 = Chỉ bán
-`rent_price_day` (DECIMAL(10,2), Nullable): Giá thuê trên 1 ngày
-`deposit_price` (DECIMAL(10,2), Nullable): Tiền cọc bắt buộc (thường bằng 70-100% giá trị đàn)

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

### 6. Bảng rentals (Hợp đồng thuê)
Lưu trữ thông tin lịch trình và tài chính của một đợt thuê nhạc cụ.

-`id` (INT, PK, Auto Increment): Mã hợp đồng thuê (Khóa chính)
-`user_id` (INT, FK): Người thuê (Liên kết bảng users)
-`start_date` (DATE, Not Null): Ngày bắt đầu tính phí thuê
-`end_date` (DATE, Not Null): Ngày dự kiến trả nhạc cụ
-`actual_return` (DATE, Nullable): Ngày trả thực tế (để tính phí trễ nếu có)
-`total_rent_fee` (DECIMAL(10,2), Not Null): Tổng tiền phí thuê (Số ngày * Giá thuê/ngày)
-`deposit_amount` (DECIMAL(10,2), Not Null): Tổng tiền cọc khách đã đóng
-`status` (ENUM, Default 'pending'): Trạng thái: pending (Chờ duyệt), active (Đang thuê), returned (Đã trả), canceled (Đã hủy)
-`created_at` (TIMESTAMP, Default Current): Ngày giờ tạo yêu cầu thuê

### 7. Bảng rental_details (Chi tiết nhạc cụ thuê)
Lưu lại danh sách các món đồ khách đem về trong một hợp đồng thuê.

-`id` (INT, PK, Auto Increment): Mã chi tiết thuê (Khóa chính)
-`rental_id` (INT, FK): Thuộc hợp đồng nào (Liên kết bảng rentals)
-`product_id` (INT, FK): Nhạc cụ nào được thuê (Liên kết bảng products)
-`quantity` (INT, Not Null): Số lượng thuê
-`price_per_day` (DECIMAL(10,2), Not Null): Chốt giá thuê/ngày tại thời điểm làm hợp đồng