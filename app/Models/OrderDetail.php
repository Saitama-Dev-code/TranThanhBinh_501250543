<?php
// Đường dẫn file: app/Models/OrderDetail.php

require_once ROOT_PATH . '/core/BaseModel.php';

class OrderDetail extends BaseModel {
    protected $table = 'order_details';

    /**
     * Lưu hàng loạt các sản phẩm trong giỏ hàng vào bảng chi tiết đơn
     * 
     * @param int $orderId Mã đơn hàng vừa tạo
     * @param array $cartItems Mảng giỏ hàng từ Session
     * @return bool True nếu thành công toàn bộ
     */
    public function insertDetails($orderId, $cartItems) {
        $sql = "INSERT INTO {$this->table} (order_id, product_id, quantity, price) 
                VALUES (:order_id, :product_id, :quantity, :price)";
        
        $stmt = $this->db->prepare($sql);
        
        // Bắt đầu transaction để đảm bảo an toàn toàn vẹn dữ liệu
        $this->db->beginTransaction();
        
        try {
            foreach ($cartItems as $item) {
                $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
                $stmt->bindValue(':product_id', $item['id'], PDO::PARAM_INT);
                $stmt->bindValue(':quantity', $item['quantity'], PDO::PARAM_INT);
                $stmt->bindValue(':price', $item['price'], PDO::PARAM_STR);
                
                $stmt->execute();
            }
            // Nếu không có lỗi, lưu thay đổi
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Nếu có 1 lỗi xảy ra, lùi lại (rollback) toàn bộ để không bị rác dữ liệu
            $this->db->rollBack();
            return false;
        }
    }
}
?>
