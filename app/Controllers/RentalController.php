<?php
// Đường dẫn file: app/Controllers/RentalController.php

require_once ROOT_PATH . '/core/BaseController.php';
require_once ROOT_PATH . '/app/Models/Rental.php';
require_once ROOT_PATH . '/app/Models/Product.php';

class RentalController extends BaseController {

    /**
     * Tạo yêu cầu thuê nhạc cụ mới (AJAX POST)
     */
    public function create() {
        // Thiết lập header trả về dữ liệu dạng JSON
        header('Content-Type: application/json');

        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện thuê nhạc cụ!',
                'require_login' => true
            ]);
            exit;
        }

        $user = $_SESSION['user'];

        // 2. Nhận dữ liệu POST (hỗ trợ cả JSON body gửi từ fetch API)
        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true);

        $productId = isset($jsonData['product_id']) ? (int)$jsonData['product_id'] : (isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0);
        $startDate = isset($jsonData['start_date']) ? trim($jsonData['start_date']) : (isset($_POST['start_date']) ? trim($_POST['start_date']) : '');
        $endDate   = isset($jsonData['end_date']) ? trim($jsonData['end_date']) : (isset($_POST['end_date']) ? trim($_POST['end_date']) : '');

        // 3. Kiểm tra dữ liệu bắt buộc
        if ($productId <= 0 || empty($startDate) || empty($endDate)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng điền đầy đủ thông tin ngày thuê!'
            ]);
            exit;
        }

        // 4. Validate ngày thuê
        $todayStr = date('Y-m-d');
        $timeToday = strtotime($todayStr);
        $timeStart = strtotime($startDate);
        $timeEnd   = strtotime($endDate);

        if (!$timeStart || !$timeEnd) {
            echo json_encode([
                'success' => false,
                'message' => 'Định dạng ngày thuê không hợp lệ!'
            ]);
            exit;
        }

        if ($timeStart < $timeToday) {
            echo json_encode([
                'success' => false,
                'message' => 'Ngày bắt đầu thuê phải từ hôm nay trở đi!'
            ]);
            exit;
        }

        if ($timeEnd <= $timeStart) {
            echo json_encode([
                'success' => false,
                'message' => 'Ngày kết thúc thuê phải sau ngày bắt đầu thuê ít nhất 1 ngày!'
            ]);
            exit;
        }

        // 5. Kiểm tra sự tồn tại của sản phẩm nhạc cụ trong DB và lấy giá chuẩn
        $productModel = new Product();
        $product = $productModel->getById($productId);

        if (!$product) {
            echo json_encode([
                'success' => false,
                'message' => 'Sản phẩm nhạc cụ không tồn tại!'
            ]);
            exit;
        }

        if ($product['is_rentable'] == 0 || empty($product['rent_price_day'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Sản phẩm này hiện tại không hỗ trợ cho thuê!'
            ]);
            exit;
        }

        // Kiểm tra hàng tồn kho còn để thuê hay không
        if ($product['stock'] <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Xin lỗi, sản phẩm nhạc cụ này hiện đã hết hàng trong kho!'
            ]);
            exit;
        }

        // Kiểm tra trùng lịch thuê trong khoảng thời gian khách chọn
        $rentalModel = new Rental();
        $overlapRented = $rentalModel->checkOverlapRental($productId, $startDate, $endDate);
        if ($overlapRented + 1 > $product['stock']) {
            echo json_encode([
                'success' => false,
                'message' => 'Sản phẩm này đã được đặt thuê hết trong khoảng thời gian từ ngày ' . date('d/m/Y', $timeStart) . ' đến ' . date('d/m/Y', $timeEnd) . '! Vui lòng chọn khoảng thời gian khác.'
            ]);
            exit;
        }

        // 6. Tính toán chi phí bảo mật tại Server-side
        $days = (int)ceil(($timeEnd - $timeStart) / 86400);
        if ($days < 1) {
            $days = 1;
        }

        $rentPriceDay = (float)$product['rent_price_day'];
        $depositPrice = (float)($product['deposit_price'] ?? 0);

        $totalRentFee = $days * $rentPriceDay;
        $depositAmount = $depositPrice;

        // 7. Gọi Model lưu dữ liệu an toàn
        $rentalId = $rentalModel->saveRental(
            $user['id'],
            $productId,
            $startDate,
            $endDate,
            $totalRentFee,
            $depositAmount,
            $rentPriceDay
        );

        if ($rentalId) {
            echo json_encode([
                'success' => true,
                'message' => 'Đăng ký thuê nhạc cụ thành công! Hợp đồng đang chờ duyệt.',
                'rental_id' => $rentalId
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Đã xảy ra lỗi hệ thống khi lưu yêu cầu thuê. Vui lòng thử lại sau.'
            ]);
        }
        exit;
    }
}
?>
