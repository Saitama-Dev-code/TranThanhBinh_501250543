<?php
// Đường dẫn file: app/Models/Order.php

require_once ROOT_PATH . '/core/BaseModel.php';

class Order extends BaseModel {
    protected $table = 'orders';

    /**
     * Tạo đơn hàng mới và trả về ID của đơn hàng vừa tạo
     * 
     * @param int $userId ID của khách hàng
     * @param float $totalPrice Tổng tiền đơn hàng
     * @param string $shippingAddress Địa chỉ giao hàng
     * @param string $receiverPhone Số điện thoại người nhận
     * @return int|false ID đơn hàng nếu thành công, false nếu thất bại
     */
    public function createOrder($userId, $totalPrice, $shippingAddress, $receiverPhone) {
        $sql = "INSERT INTO {$this->table} (user_id, total_price, shipping_address, receiver_phone, status) 
                VALUES (:user_id, :total_price, :shipping_address, :receiver_phone, 'pending')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':total_price', $totalPrice, PDO::PARAM_STR);
        $stmt->bindParam(':shipping_address', $shippingAddress, PDO::PARAM_STR);
        $stmt->bindParam(':receiver_phone', $receiverPhone, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId(); // Trả về ID tự tăng vừa tạo
        }
        return false;
    }

    /**
     * Lấy danh sách đơn hàng của một User (dùng cho trang Profile)
     * 
     * @param int $userId
     * @return array Danh sách đơn hàng
     */
    public function getOrdersByUser($userId) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
