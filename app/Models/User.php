<?php
// Đường dẫn file: app/Models/User.php

require_once ROOT_PATH . '/core/BaseModel.php';

class User extends BaseModel {
    // Chỉ định tên bảng trong cơ sở dữ liệu
    protected $table = 'users';

    /**
     * Lấy thông tin người dùng dựa vào email
     * Hàm này rất quan trọng cho việc Đăng nhập và kiểm tra trùng lặp khi Đăng ký
     * 
     * @param string $email
     * @return array|false Trả về mảng dữ liệu user nếu tìm thấy, ngược lại trả về false
     */
    public function getByEmail($email) {
        // Viết câu truy vấn SQL (Sử dụng tham số :email để chống SQL Injection)
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        
        // Chuẩn bị câu lệnh (Prepare statement)
        $stmt = $this->db->prepare($sql);
        
        // Gán giá trị thực tế vào tham số
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
        // Thực thi câu lệnh
        $stmt->execute();
        
        // Trả về dòng dữ liệu tìm được (fetch)
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật mật khẩu cho user (Dùng để nâng cấp hash mật khẩu cũ)
     */
    public function updatePassword($userId, $newPasswordHash) {
        $sql = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password', $newPasswordHash, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
