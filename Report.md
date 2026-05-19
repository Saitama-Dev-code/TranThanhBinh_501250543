# Nhật ký Cập nhật Dự án (Changelog)

**Ngày cập nhật:** 19/05/2026

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
