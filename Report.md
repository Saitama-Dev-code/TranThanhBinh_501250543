# Nhật ký Cập nhật Dự án (Changelog)

**Ngày cập nhật:** 29/05/2026

## 🚀 Cập Nhật Lần 17 (Khắc Phục Lỗi Bảo Mật CSRF/XSS, Tích Hợp CSDL Transaction, Kiểm Tra Trùng Lịch Thuê & Ẩn OTP)

### 1. Bảo mật Token CSRF & Chống XSS
- **Tích hợp Token CSRF:** Di chuyển logic kiểm tra Token CSRF lên `BaseController` làm phương thức dùng chung. Thêm input ẩn `csrf_token` vào biểu mẫu đặt hàng trong `checkout.php` và xác thực nghiêm ngặt tại `CheckoutController`.
- **Lọc XSS:** Áp dụng `htmlspecialchars()` để làm sạch Họ tên, Số điện thoại và Mã đơn hàng khi in ra tại màn hình thông báo đặt hàng thành công.

### 2. Ẩn OTP Quên Mật Khẩu (Bảo Mật Vận Hành)
- **Log file kiểm thử:** Ẩn mã OTP khôi phục mật khẩu khỏi phản hồi AJAX gửi về Client. Thay vào đó, OTP được ghi vào file log kiểm thử `scratch/otp_log.txt` trên server để đảm bảo an toàn bảo mật thực tế.

### 3. Ràng buộc Tồn Kho & PDO Transactions trong Đặt Hàng
- **CSDL Transaction:** Đóng gói toàn bộ quá trình tạo đơn hàng (`orders`), lưu chi tiết đơn hàng (`order_details`), và giảm tồn kho (`products.stock` qua phương thức `deductStock()`) vào trong một Database Transaction duy nhất nhằm đảm bảo tính nhất quán dữ liệu.
- **Kiểm tra tồn kho:** Chặn thanh toán và báo lỗi ngay lập tức tại Controller nếu số lượng trong giỏ hàng vượt quá số lượng hàng còn lại trong kho.

### 4. Ràng buộc Tồn Kho & Trùng Lịch Thuê Nhạc Cụ
- **Tránh cho thuê quá stock:** Chặn thuê nhạc cụ nếu số lượng tồn kho `stock <= 0`.
- **Thuật toán check trùng lịch:** Viết hàm `checkOverlapRental()` trong `Rental` model để đếm số lượng nhạc cụ đó đã được thuê trong khoảng thời gian trùng lặp. Chặn và báo lỗi cụ thể cho người dùng nếu tổng số lượng đã cho thuê cộng thêm yêu cầu mới vượt quá số lượng tồn kho thực tế.

---

**Ngày cập nhật:** 25/05/2026

## 🚀 Cập Nhật Lần 16 (Nâng cấp Trang Cá Nhân Overlay Sheet & Sửa Lỗi Authentication)

### 1. Nâng cấp Trang Cá Nhân (Profile Overlay Sheet)
- **Profile Slide-up Overlay:** Chuyển đổi trang cá nhân `#page-profile` từ trang tĩnh SPA thông thường thành Slide-up Overlay Sheet trượt mượt mà từ dưới lên toàn màn hình (tương tự Detail Sheet và Auth Sheet).
- **Canvas Bong Bóng Hào Quang (Glowing Ripple Bubbles):** Thiết lập Canvas nền riêng biệt vẽ các bong bóng hào quang phát sáng đổi màu chậm rãi, nảy ra xa và phóng to khi rê chuột qua, tạo cảm giác huyền ảo cao cấp.
- **Nút Quay Lại Nổi Bật:** Thêm nút "Quay lại trang trước" bo tròn tinh tế ở góc dưới card để đóng sheet mượt mà và khôi phục URL nền.
- **Tải ngầm trang nền Home:** Tự động tải ngầm trang chủ làm nền khi người dùng F5 tải trực tiếp trang Profile để tránh trống trải giao diện nền.

### 2. Cập nhật thông tin cá nhân qua AJAX
- **Form Chỉnh Sửa Thông Tin:** Bổ sung tab "Cập nhật thông tin" cho phép chỉnh sửa Họ tên, Số điện thoại và Địa chỉ nhận hàng.
- **AJAX lưu thông tin:** Xử lý gửi AJAX FormData, cập nhật tức thì dữ liệu hiển thị trên trang Profile và morph đổi tên người dùng trên Navbar mà không cần reload trang.

### 3. Sửa lỗi Nhớ mật khẩu & Quên mật khẩu
- **Cookie Remember Me:** Thiết lập Cookie `remember_me` được mã hóa và ký bảo mật bằng thuật toán MD5 khi tick "Nhớ mật khẩu". Tự động đăng nhập người dùng khi mở lại trình duyệt.
- **Quên mật khẩu OTP AJAX:** Tích hợp form quên mật khẩu trực tiếp trong Auth Sheet. Người dùng nhận mã OTP kiểm thử trực quan trên màn hình, nhập OTP và mật khẩu mới để đặt lại mật khẩu 100% bằng AJAX không reload trang.

---

**Ngày cập nhật:** 25/05/2026

## 🚀 Cập Nhật Lần 15 (Nâng cấp Auth Sheet Trượt & Sửa Lỗi Tương Phản Dark Theme)

### 1. Nâng cấp Auth Sheet Trượt mượt mà từ dưới lên
- **Auth Sheet Overlay:** Thay thế hoàn toàn Bootstrap Modal đăng nhập cũ bằng `#page-auth-overlay` trượt lên toàn màn hình (tương tự Detail Sheet) với hiệu ứng transition trượt cao cấp.
- **Canvas Sóng Nhạc Neon:** Tích hợp Canvas vẽ 3 đường sóng âm thanh phát sáng (Audio Waveform) chuyển động lệch pha sinh động làm nền phía sau.
- **Nút Quay Lại Tiện Dụng:** Thiết kế nút "Quay lại trang trước" nổi bật ở dưới cùng của thẻ đăng nhập giúp đóng sheet nhanh chóng.
- **Tab Đăng nhập / Đăng ký Trượt Ngang:** Sử dụng cấu trúc flex và `transform: translateX` để chuyển đổi mượt mà giữa hai form trên cùng một thẻ.

### 2. AJAX hóa 100% Xác thực & Morph Navbar
- **AJAX Đăng ký:** AJAX hóa hoàn toàn cả hai form Đăng ký (`registerSubmit`) và Đăng nhập (`loginSubmit`) để phản hồi tức thì mà không reload trang.
- **Navbar Morph Transition:** Đồng bộ container `#navbar-user-control` với hiệu ứng morph transition (`fade-scale`) mượt mà khi chuyển từ Đăng nhập sang tài khoản khách hàng hoặc ngược lại khi Đăng xuất.
- **Đổi mới màu sắc Navbar:** Nút Đăng nhập trên navbar đổi thành màu xanh dương gradient có bóng đổ phát sáng; Dropdown tài khoản khách đổi sang Glassmorphism tím-xanh ngọc có viền neon.

### 3. Sửa lỗi hiển thị chữ tối (Contrast Dark Theme)
- **CSS Tương phản:** Thêm thuộc tính CSS cho `:root[data-theme="dark"] .text-muted` để tăng độ tương phản của chữ xám trong Dark Theme của Cửa hàng, đảm bảo đọc rõ nội dung.

---

**Ngày cập nhật:** 21/05/2026

## 🚀 Cập Nhật Lần 13 (Hoàn Thiện Flow Thanh toán, Xác thực & Quản lý Đơn hàng)

### 1. Hệ thống Xác thực (Authentication)
- Bật kết nối Cơ sở dữ liệu thật cho quá trình Đăng nhập, Đăng ký.
- Tạo Model `User.php` kết nối bảng `users`.
- Cập nhật `AuthController.php` để lưu thông tin và băm mật khẩu (Bcrypt) khi đăng ký, cũng như xác thực thông tin khi đăng nhập.
- Bổ sung tính năng Đăng xuất (`logout`).

### 2. Hệ thống Đặt hàng & Thanh toán (Checkout)
- Tạo Model `Order.php` và `OrderDetail.php` để lưu trữ dữ liệu mua hàng.
- Xây dựng `CheckoutController.php`: tự động nhận diện tài khoản hoặc tạo nhanh tài khoản cho khách vãng lai dựa trên số điện thoại.
- Hoàn thiện giao diện Thanh toán (`checkout.php`) theo phong cách Glassmorphism 2 cột hiện đại, hiển thị tóm tắt giỏ hàng.

### 3. Hệ thống Quản lý Tài khoản (Profile)
- Tạo `ProfileController.php` yêu cầu đăng nhập.
- Giao diện `profile.php` dạng Dashboard cá nhân hiện thông tin User và liệt kê chi tiết Lịch sử đơn hàng (Mã đơn, tổng tiền, trạng thái).

---

**Ngày cập nhật:** 20/05/2026

## 🚀 Cập Nhật Lần 10 (Hoàn Thiện Tuyệt Đối & Trải Nghiệm Người Dùng)

### 1. Nâng Cấp Hero Banner (Homepage)
- **Watermark Logo Sáng Hơn:** Tăng độ sáng cho Logo Watermark "TTB MUSIC" (Opacity 25%) giúp nổi bật trên nền video nhưng vẫn giữ được nét tinh tế.
- **Ripple Effect Theo Chuột:** Tích hợp hiệu ứng gợn sóng nước (Warp) bằng `backdrop-filter` chạy theo vị trí con trỏ chuột trên video Hero.
- **Dọn dẹp Giao diện:** Loại bỏ nút "Khám phá ngay" và các Slogan dư thừa để tập trung hoàn toàn vào nhận diện thương hiệu.

### 2. Khắc Phục Lỗi Hiển Thị (Homepage)
- **Sửa lỗi Overlap Clipping:** Khắc phục triệt để lỗi hình ảnh bị cắt mất trong phần "Không gian của bạn" bằng cách tối ưu hóa thuộc tính `overflow` và `will-change`.
- **Ổn định Grand Piano Showcase:** Loại bỏ hiệu ứng Parallax "kéo theo" gây mất ổn định hình ảnh, thay bằng hiệu ứng phóng nhẹ mượt mà.

### 3. Cải Thiện Tính Năng Cửa Hàng (Store Page)
- **Tìm kiếm Thông minh:** 
    - Thêm nút **X** xóa nhanh nội dung trong ô tìm kiếm.
    - Hiển thị thông báo **"Kết quả tìm kiếm cho..."** rõ ràng phía trên danh sách sản phẩm.
    - Tự động xóa content ô search sau khi kết quả đã được tải thành công (theo yêu cầu UX).
- **Bộ lọc Nâng cao:** Ẩn hoàn toàn các nút tăng giảm (spin buttons) thô sơ trong ô nhập khoảng giá trên tất cả các trình duyệt.
- **Mã nguồn chi tiết:** Bổ sung hệ thống comment PHP/JS đầy đủ để lập trình viên dễ dàng nắm bắt logic hoạt động.

### 4. Hệ Thống Git & Quản lý
- **Commit Git:** Thực hiện commit các thay đổi với tin nhắn rõ ràng, phân loại theo từng thành phần giao diện.

---

**Ngày cập nhật:** 20/05/2026

## 🚀 Cập Nhật Lần 9 (Nâng Cấp Thương Hiệu & Tương Tác Đỉnh Cao)

### 1. Nhận Diện Thương Hiệu Mới (TTB -> 7IB)
- **Logo Morphing:** Thiết kế lại Logo TTB trên Navbar với hiệu ứng chuyển đổi mượt mà sang "7IB" khi di chuột, sử dụng font `Outfit Black` phong cách Italic hiện đại.
- **Ẩn thanh cuộn:** Ẩn hoàn toàn thanh cuộn mặc định của trình duyệt để tạo trải nghiệm tràn viền (Edge-to-edge) chuyên nghiệp.

### 2. Trang Chủ (Hero & Showcase Redesign)
- **3D Card Tilt:** Áp dụng hiệu ứng nghiêng 3D cho Slogan chính, phản hồi theo vị trí con trỏ chuột của người dùng.
- **Video Displacement Warp:** Tích hợp SVG Filter và Javascript để tạo hiệu ứng gợn sóng nước (Warp) cục bộ trên video nền khi di chuột qua.
- **Parallax Overlap:** Tinh chỉnh công thức tính toán tọa độ cuộn cho các khối hình ảnh xếp lớp, tạo chiều sâu không gian chân thực.
- **Grand Piano Showcase:** Tái cấu trúc thành dạng Glassmorphic Banner với ảnh nền Parallax Zoom và khối nội dung trượt ngang từ trái sang.

### 3. Trang Cửa Hàng (Tái Cấu Trúc Layout)
- **Sticky Sidebar (280px):** Chuyển toàn bộ bộ lọc và danh mục vào một cột Sidebar cố định bên trái. Khắc phục triệt để lỗi bộ lọc đè lên sản phẩm khi cuộn trang.
- **Natural Scrolling:** Khung sản phẩm bên phải cuộn tự nhiên theo cửa sổ trình duyệt, loại bỏ các khung scroll phụ gây khó chịu.
- **Click-to-Load:** Gỡ bỏ Infinite Scroll tự động, chuyển sang cơ chế "Xem thêm sản phẩm" bằng nút bấm để người dùng chủ động kiểm soát nội dung.
- **Price Filter Fix:** Sửa lỗi nhập số âm và ẩn nút spin button trong ô lọc giá.

### 4. Trang Chi Tiết (Glowing Melody Constellation)
- **Nền mạng tinh thể:** Thiết lập Canvas nền riêng biệt với các nốt nhạc phát sáng bay lơ lửng, tự động kết nối với nhau bằng các đường link mờ ảo khi ở gần (Constellation effect).
- **Tương tác vật lý:** Thêm hiệu ứng đẩy hạt (Repel) khi di chuyển chuột, tạo sự sinh động khác biệt hoàn toàn với trang chủ.

---

## 🚀 Cập Nhật Lần 11 (Cập nhật UI/UX, Hiệu Ứng Cuộn Tương Tác & Giỏ hàng)
**Ngày:** 20-05-2026

**1. Sửa lỗi & Nâng cấp Giao diện (UI/UX Polish):**
- **Dải thương hiệu Marquee Chạy Ngang Vô Hạn (`home.php`):**
  - Chuyển dải thương hiệu tĩnh thành dạng chạy ngang vô tận (Infinite Marquee) sử dụng kỹ thuật sao nhân đôi nhóm và dịch chuyển `-100%` kết hợp khoảng hở (gap) để không bị đứt quãng hay mất chữ ở cuối chu kỳ.
  - Loại bỏ hoàn toàn hiệu ứng sóng nhấp nhô tự động (Auto-Wave) gây giật lag. Chỉ nâng nhẹ lên (translateY & scale) khi người dùng di chuột vào (`:hover`). Khi di chuột ra ngoài, phần tử sẽ hạ dần xuống vị trí ban đầu cực kỳ mượt mà nhờ cấu trúc `transition` mượt mà thay vì giật cục.
- **Hiệu ứng Cuộn Tương Tác (Scroll-Driven Progress Parallax - `home.php`):**
  - Triển khai thuật toán cuộn bằng JavaScript đo tọa độ các khối chứa `.scroll-track` theo thời gian thực (real-time) và tính toán tỉ lệ xuất hiện/biến mất (Progress từ `0` đến `1`).
  - Gán giá trị tiến trình này vào biến CSS `--scroll-progress`.
  - Thiết kế CSS tịnh tiến tỉ lệ thuận: hình ảnh bên trái nghiêng và dịch chuyển theo scroll, hình ảnh bên phải dịch chuyển đè lên, đốm nền mờ dần/rõ dần theo thao tác cuộn của chuột.
  - Hỗ trợ đầy đủ hiệu ứng biến mất khi cuộn qua đầu trang (Exit phase) và hiện lại khi cuộn ngược lại.
  - Áp dụng kỹ thuật `requestAnimationFrame` để xử lý mượt mà ở mức 60/120 FPS trên mọi trình duyệt.
  - Đồng bộ hóa hiệu ứng này cho cả phần **Grand Piano Premium** và phần **Khơi nguồn cảm hứng (Overlap Showcase)**.
- **Trang Cửa hàng (`sanpham.php`):**
  - Gỡ bỏ giới hạn chiều cao (`max-height`), cho phép danh sách sản phẩm dài ra tự nhiên theo màn hình.
  - Cột Danh mục, Thanh tìm kiếm và Bảng Lọc nâng cao được thiết lập `position: sticky` để tự động trượt theo màn hình khi cuộn chuột xuống.
  - Tối ưu kích thước Bảng Lọc nâng cao, giới hạn chiều cao tối đa để vừa vặn màn hình.
  - Sửa lỗi thanh trượt khoảng giá (Price Slider) không hoạt động bằng cách bổ sung Javascript đồng bộ giữa slider và input.
- **Trang Chi tiết sản phẩm (`product_detail.php`):**
  - Căn giữa số lượng ở ô chọn số lượng, ẩn nút tăng giảm mũi tên mặc định của trình duyệt (`spin button`) để giao diện gọn gàng hơn.
  - Gỡ bỏ `position: sticky` ở phần hình ảnh sản phẩm để tránh lỗi sê dịch hình ảnh khi cuộn chuột.
- **Footer (`footer.php`):** Cập nhật đúng các đường dẫn liên kết danh mục sản phẩm (Guitar, Piano, Trống) để chuyển hướng chính xác đến trang danh mục tương ứng.
- **Hiệu ứng toàn cục (`header.php` / `footer.php`):** Kích hoạt chế độ `mirror: true` cho thư viện AOS.

**2. Tính năng Giỏ hàng (Cart):**
- Đã khởi tạo cấu trúc logic cho giỏ hàng trong bộ nhớ đệm (Session).
- Thêm `CartController.php` để xử lý các tác vụ thêm, cập nhật, xóa sản phẩm bằng AJAX.
- Tạo giao diện `cart.php`.
- Cập nhật badge (huy hiệu số lượng) trên Navbar.

**Trạng thái kế tiếp:**
- Tiếp tục hoàn thiện Flow Thanh Toán (Checkout) và Quản lý đơn hàng.

## 🚀 Cập Nhật Lần 10 (Redesign Layout Cửa Hàng + Fix Chữ Nền Sáng)

**Commit:** `a4196de` – 20/05/2026

### 1. Redesign Layout 2 Tầng (`sanpham.php`)
Thay toàn bộ layout Bootstrap `row/col-lg-3/col-lg-9` bằng **Flexbox 2 tầng dọc**:

| Tầng | Bố cục | Mô tả |
|------|--------|-------|
| **Tầng 1** (luôn hiện) | `[category-box 260px]` &#124; `[search-filter-box flex:1]` | Danh mục + thanh tìm kiếm luôn visible |
| **Tầng 2** (ẩn/hiện) | `[filter-panel 260px]` &#124; `[products-wrapper flex:1]` | Panel lọc nâng cao mở ra bên dưới |

**Lợi ích:**
- Hai cột trái (260px) thẳng dọc nhau → gọn đẹp, không lệch
- Panel lọc nâng cao không che/đẩy khung sản phẩm (khung SP vẫn giữ chiều rộng)
- Mở/đóng panel bằng animation `max-height` CSS mượt mà (0.45s cubic-bezier)

### 2. Thêm Nút Tìm Kiếm Riêng + Nút Toggle Bộ Lọc
- **`btn-search`** (xanh gradient): submit form GET tìm kiếm nhanh
- **`btn-filter-toggle`**: toggle panel lọc nâng cao, xoay mũi tên chevron khi mở
- Badge hiển thị số bộ lọc đang áp dụng

### 3. Tách Form Lọc Khỏi Form Tìm Kiếm
- `#top-search-form` – tìm kiếm nhanh (search + category)
- `#advanced-filter-form` – lọc nâng cao (price_min, price_max, brand, in_stock, is_rentable)
- Lý do: HTML không cho phép lồng `<form>` trong `<form>`, nếu lồng sẽ bị trình duyệt bỏ qua
- JS đồng bộ search + category giữa 2 form trước khi submit

### 4. Fix Toàn Bộ Màu Cứng → CSS Variables (Light Mode)
| Class / Element | Trước | Sau |
|-----------------|-------|-----|
| `.price-input-wrapper label` | `rgba(255,255,255,0.6)` | `var(--text-muted)` |
| `.price-input-wrapper .currency-symbol` | `rgba(255,255,255,0.5)` | `var(--text-muted)` |
| `.cat-link` (danh mục) | `text-white-50` Bootstrap | `color:var(--text-muted)` CSS |
| `.variant-btn` | màu cứng | `var(--variant-btn-bg)` + `var(--text-color)` |
| `.product-desc`, `.loading-text` | không có | `var(--text-muted)` |

### 5. Class Danh Mục Mới (`.cat-link`)
Thay `category-link list-group-item text-white-50` bằng `.cat-link` tùy chỉnh:
- Padding/hover/active theo thiết kế project
- `color: var(--text-muted)` tự động đổi theo `data-theme="light"` / `data-theme="dark"`
- Không phụ thuộc vào Bootstrap `.text-white-50`

---

## 🚀 Cập Nhật Lần 9 (Trang Chi Tiết Sản Phẩm + Giao Diện Nền Ripple Sóng Âm)

### 1. Tạo Trang Chi Tiết Sản Phẩm (`product_detail.php`)
- **Nền Canvas Ripple Sóng Âm**: Vòng tròn màu tím/indigo lan rộng từ các điểm ngẫu nhiên trên màn hình (khác biệt hoàn toàn với home và sanpham).
  - `home.php` → Nốt nhạc rơi từ trên xuống (particle-canvas, màu trắng/xanh)
  - `sanpham.php` → Nốt nhạc bay từ dưới lên (product-canvas, màu xanh dương)
  - `product_detail.php` → Ripple sóng âm lan rộng (detail-canvas, màu tím/indigo)
- **Gallery ảnh**: Ảnh chính lớn + dãy thumbnail theo từng màu sắc biến thể, click chuyển ảnh có hiệu ứng fade.
- **Chọn biến thể**: Nút chọn màu sắc và phiên bản, highlight tím khi được chọn, cập nhật ảnh theo màu.
- **Khu vực giá**: Giá bán + giá thuê/ngày + tiền cọc (nếu có).
- **Điều khiển số lượng**: Nút +/− với giới hạn theo tồn kho thực tế.
- **Nút hành động**: "Thêm vào giỏ" (AJAX) + "Thuê ngay" (chỉ hiện khi is_rentable=1).
- **Tính trả góp**: Chọn 3/6/12/24 tháng, tự tính tiền/tháng real-time bằng JS (chỉ hiện với SP ≥ 5 triệu).
- **Tab mô tả / thông số kỹ thuật**: Chuyển tab mượt mà với fade animation.
- **Breadcrumb**: Điều hướng Trang chủ → Cửa hàng → Tên sản phẩm.
- **Comment PHP đầy đủ**: Mỗi khối logic, điều kiện, vòng lặp đều có comment giải thích.

### 2. Cập Nhật `ProductController.php` – Action `detail()`
- Thêm kiểm tra ID hợp lệ (`> 0`) trước khi truy vấn DB.
- Gọi `getByIdWithCategory()` thay vì `getById()` để lấy tên danh mục.
- Lấy biến thể (colors/versions) và truyền vào view riêng biệt.
- Trả về trang lỗi thân thiện (HTTP 404) khi SP không tồn tại.
- Comment theo chuẩn 4 BƯỚC rõ ràng.

### 3. Cập Nhật `Product.php` – Thêm Hàm `getByIdWithCategory()`
- Dùng `LEFT JOIN categories` để lấy kèm `category_name`.
- Comment giải thích câu SQL JOIN, lý do dùng LEFT JOIN, kiểu dữ liệu trả về.

### 4. Cập Nhật `sanpham.php` – Link Vào Trang Chi Tiết
- Click vào **ảnh sản phẩm** hoặc **tên sản phẩm** sẽ điều hướng sang trang chi tiết.
- Áp dụng `htmlspecialchars()` cho tên và brand trong card (bảo mật XSS).

---



## 🚀 Cập Nhật Lần 8 (Tối Ưu Giao Diện & Dữ Liệu Thực Tế Toàn Diện)

### 1. Phân Tách Giao Diện (UI Separation)
- **Tách biệt Danh mục & Bộ lọc:** "Danh mục" (Categories) được đưa ra một block riêng biệt phía trên "Bộ lọc" (Filters), giúp giao diện gọn gàng và giữ nguyên trải nghiệm như phiên bản gốc.
- **Glassmorphism Sidebar:** Cả hai block Danh mục và Bộ lọc đều sử dụng hiệu ứng kính mờ (backdrop-filter: blur(10px)), đồng bộ với phong cách thiết kế hiện đại của toàn dự án.
- **Tương tác mượt mà:** Thêm hiệu ứng hover và active cho danh mục (trượt nhẹ sang phải và đổi màu xanh dương).

### 2. Mở Rộng Dữ Liệu Thực Tế (Data Expansion)
- **Tăng số lượng sản phẩm:** Seed thêm **23 sản phẩm mẫu chất lượng cao** từ nhiều thương hiệu nổi tiếng (Nord, Korg, Martin, Ibanez, Focusrite, KRK...).
- **Sửa lỗi link ảnh:** Toàn bộ sản phẩm được cập nhật link ảnh độ phân giải cao từ Unsplash, khắc phục triệt để các lỗi ảnh bị hỏng hoặc mờ.
- **Đồng bộ Biến thể:** Mỗi sản phẩm mới đều được gán sẵn các biến thể (Màu sắc/Phiên bản) tương ứng trong database để người dùng preview ngay lập tức.

### 3. Nâng Cấp Hệ Thống CSDL
- **Thay đổi kiểu dữ liệu:** Cập nhật cột `price`, `rent_price_day`, `deposit_price` từ `DECIMAL(10,2)` lên `DECIMAL(15,2)` để hỗ trợ các nhạc cụ cao cấp có giá trị lớn (trên 100 triệu VNĐ).
- **Làm sạch Database:** Thực hiện dọn dẹp và reset dữ liệu rác để đảm bảo tính nhất quán giữa bảng sản phẩm và bảng biến thể.

### 4. Logic Lọc Thông Minh
- **Preserve Category:** Khi người dùng đang ở một danh mục cụ thể và sử dụng bộ lọc (giá, thương hiệu...), hệ thống tự động giữ lại ID danh mục đó để kết quả lọc luôn chính xác trong phạm vi mong muốn.

---

**Ngày cập nhật:** 19/05/2026

## 🚀 Cập Nhật Lần 7 (Dữ Liệu Biến Thể Thật Từ Database)

### 1. Quản Lý Biến Thể (Product Variants)
- **Bảng mới `product_variants`:** Lưu trữ chi tiết màu sắc và phiên bản cho từng nhạc cụ.
  - Hỗ trợ mã màu HEX cho icon.
  - Hỗ trợ ảnh riêng (`image_url`) cho từng màu sắc.
- **Xóa bỏ dữ liệu giả lập:** Thay thế toàn bộ logic `rand()` và mảng cứng bằng dữ liệu truy vấn từ SQL.

### 2. Tối Ưu Hóa Model & Controller
- **`ProductModel`:** Thêm hàm `getVariantsByProductId($id)` để lấy và phân loại biến thể (colors vs versions).
- **`ProductController`:** Tự động gắn kèm dữ liệu biến thể vào từng sản phẩm khi load trang Cửa hàng.

### 3. Cải Tiến UI/UX
- **`sanpham.php`:** Chỉ hiển thị các nhóm biến thể (Màu sắc/Phiên bản) nếu sản phẩm đó thực sự có dữ liệu biến thể trong database.
- **Preview mượt mà:** Chuyển đổi ảnh chính xác theo từng màu sắc được định nghĩa trong DB.

---

**Ngày cập nhật:** 19/05/2026

## 🚀 Cập Nhật Lần 6 (Nâng Cấp Trang Sản Phẩm Toàn Diện)

### 1. Bộ Lọc Nâng Cao (Advanced Filter Sidebar)
- **6 nhóm lọc mới:**
  - `Tìm kiếm` theo tên sản phẩm
  - `Danh mục` (Guitar & Bass, Piano & Keyboard, Trống & Bộ gõ, Âm thanh Studio)
  - `Khoảng giá` với 2 input + range slider trực quan
  - `Thương hiệu` (Yamaha, Fender, Roland, Pearl, Gibson, Kawai, Casio, Shure, Marshall, Audio-Technica, Taylor)
  - `Tình trạng kho` (Chỉ còn hàng / Tất cả)
  - `Loại` (Có cho thuê / Tất cả)
- Sidebar có scroll riêng, sticky position, hiệu ứng glassmorphism

### 2. Layout Infinite Scroll Trong Khung Riêng
- **Khung sản phẩm độc lập:** `max-height: calc(100vh - 140px)` - scroll riêng không ảnh hưởng toàn trang
- **Fade effect viền dưới:** Gradient mờ dần khi scroll để báo hiệu còn nội dung
- **Auto-load:** Khi scroll gần cuối (200px) tự động load thêm sản phẩm
- **Nút "Xem thêm":** Alternative cách load thêm thủ công
- **12 sản phẩm/lần load** thay vì 6 như trước
- **Animation fadeInUp** cho sản phẩm mới load thêm

### 3. Card Sản Phẩm Tương Tác (Interactive Product Card)
- **Panel màu sắc & phiên bản** - Mặc định ẩn, chỉ hiện khi hover
- **Trượt lên từ dưới** với `transform: translateY(100%)` → `translateY(0)`
- **Chọn màu:** Click để đổi hình ảnh sản phẩm (fade transition 200ms)
- **Chọn phiên bản:** Highlight selected với gradient blue
- **Badge trạng thái:** "Còn hàng" (xanh), "Hết hàng" (đỏ pulse nếu stock ≤ 3)

### 4. Animation Nền Riêng Cho Trang Sản Phẩm
- **Khác với trang chủ** (mưa nhạc rơi từ trên xuống)
- **Nốt nhạc bay lên từ dưới** với tốc độ chậm (0.2-0.7 px/frame)
- **Ít particles hơn** (40 thay vì 60) để không gây náo loạn
- **Repel effect khi rê chuột:** Đẩy particles ra xa, tăng opacity
- **Màu sắc khác:** Blue, Purple, Indigo, Cyan thay vì trắng

### 5. Database Mở Rộng
- Thêm cột `brand` vào bảng `products` để lọc theo thương hiệu
- Bổ sung **9 sản phẩm mẫu mới** (Fender Stratocaster, Gibson Les Paul, Taylor 214ce, Marshall Stack...)

### 6. Code Documentation Đầy Đủ
- **ProductModel:** Comment chi tiết từng điều kiện lọc (WHERE clause), giải thích SQL động
- **ProductController:** Comment theo 7 BƯỚC rõ ràng, giải thích công thức phân trang
- **sanpham.php:** Section 1-6 CSS, Section 1-2 JavaScript với tiêu đề rõ ràng

---

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

## 🚀 Đợt 14: Tối ưu Xác thực & Hiệu ứng Giỏ hàng
- **Sửa lỗi đăng nhập cho tài khoản cũ:** Bổ sung cơ chế tự động nâng cấp hash mật khẩu bằng bcrypt khi đăng nhập thành công với mật khẩu chưa mã hóa (fallback cho dữ liệu cũ).
- **Cải tiến luồng Đăng ký:** Chuyển đổi thông báo lỗi sang dạng flash message hiển thị đẹp mắt trên UI thay vì gọi hàm `die()`. Hỗ trợ tự động điền lại giá trị cũ khi có lỗi.
- **Tự động Đăng nhập:** Đăng nhập và chuyển hướng thẳng về trang chủ ngay sau khi đăng ký thành công.
- **Tối ưu hóa Giỏ hàng (Cart UX):** Sử dụng AJAX và CSS transition để cập nhật số lượng và ẩn/hiện giỏ trống mượt mà không tải lại trang. Thêm modal xác nhận xóa glassmorphism khi click xóa hoặc giảm số lượng về 0.
- **Hiệu ứng Bay Giỏ hàng (AJAX Add To Cart):** Thiết kế hiệu ứng bay bằng hình ảnh sản phẩm thu nhỏ di chuyển mượt mà tới vị trí giỏ hàng bằng GPU transform tăng hiệu năng.