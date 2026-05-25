<?php
// Đường dẫn file: app/Models/Rental.php

require_once ROOT_PATH . '/core/BaseModel.php';

class Rental extends BaseModel {
    protected $table = 'rentals';

    /**
     * Tạo hợp đồng thuê mới
     * 
     * @param int $userId ID khách hàng
     * @param string $startDate Ngày bắt đầu thuê (YYYY-MM-DD)
     * @param string $endDate Ngày dự kiến trả (YYYY-MM-DD)
     * @param float $totalRentFee Tổng phí thuê
     * @param float $depositAmount Tiền đặt cọc
     * @return int|false ID hợp đồng thuê vừa tạo hoặc false nếu lỗi
     */
    public function createRental($userId, $startDate, $endDate, $totalRentFee, $depositAmount) {
        $sql = "INSERT INTO {$this->table} (user_id, start_date, end_date, total_rent_fee, deposit_amount, status) 
                VALUES (:user_id, :start_date, :end_date, :total_rent_fee, :deposit_amount, 'pending')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':total_rent_fee', $totalRentFee, PDO::PARAM_STR);
        $stmt->bindParam(':deposit_amount', $depositAmount, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Tạo chi tiết hợp đồng thuê
     * 
     * @param int $rentalId ID hợp đồng thuê
     * @param int $productId ID sản phẩm nhạc cụ
     * @param int $quantity Số lượng
     * @param float $pricePerDay Giá thuê trên 1 ngày tại thời điểm làm hợp đồng
     * @return bool
     */
    public function createRentalDetail($rentalId, $productId, $quantity, $pricePerDay) {
        $sql = "INSERT INTO rental_details (rental_id, product_id, quantity, price_per_day) 
                VALUES (:rental_id, :product_id, :quantity, :price_per_day)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rental_id', $rentalId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':price_per_day', $pricePerDay, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    /**
     * Lấy danh sách hợp đồng thuê của một người dùng (kèm thông tin chi tiết sản phẩm)
     * 
     * @param int $userId
     * @return array Danh sách hợp đồng thuê
     */
    public function getRentalsByUser($userId) {
        $sql = "SELECT r.*, rd.product_id, rd.quantity, rd.price_per_day, p.name AS product_name, p.image AS product_image
                FROM {$this->table} r
                LEFT JOIN rental_details rd ON r.id = rd.rental_id
                LEFT JOIN products p ON rd.product_id = p.id
                WHERE r.user_id = :user_id 
                ORDER BY r.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lưu hợp đồng thuê kèm chi tiết thuê trong một transaction để đảm bảo toàn vẹn dữ liệu
     * 
     * @param int $userId ID khách hàng
     * @param int $productId ID sản phẩm nhạc cụ
     * @param string $startDate Ngày bắt đầu
     * @param string $endDate Ngày kết thúc
     * @param float $totalRentFee Tổng phí thuê
     * @param float $depositAmount Tiền cọc
     * @param float $pricePerDay Giá thuê/ngày
     * @return int|false ID hợp đồng thuê nếu thành công, false nếu thất bại
     */
    public function saveRental($userId, $productId, $startDate, $endDate, $totalRentFee, $depositAmount, $pricePerDay) {
        $this->db->beginTransaction();
        try {
            $rentalId = $this->createRental($userId, $startDate, $endDate, $totalRentFee, $depositAmount);
            if (!$rentalId) {
                throw new Exception("Không thể tạo hợp đồng thuê.");
            }
            
            $detailSaved = $this->createRentalDetail($rentalId, $productId, 1, $pricePerDay);
            if (!$detailSaved) {
                throw new Exception("Không thể tạo chi tiết hợp đồng thuê.");
            }
            
            $this->db->commit();
            return $rentalId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
?>
