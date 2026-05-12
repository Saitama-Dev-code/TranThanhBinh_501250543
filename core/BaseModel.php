<?php
// Đường dẫn file: core/BaseModel.php

// Gọi file kết nối CSDL
require_once __DIR__ . '/db.inc';

class BaseModel {
    // Thuộc tính protected để các class con (như Product, User) có thể sử dụng được
    protected $db;
    protected $table;

    // Hàm khởi tạo: Tự động lấy kết nối PDO từ class Database (Singleton)
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Lấy toàn bộ dữ liệu từ bảng
     */
    public function getAll() {
        // Sử dụng $this->table để lấy tên bảng từ class con
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Lấy 1 bản ghi theo ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        // Bind param (Prepared Statement) để chống SQL Injection
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Thêm mới một bản ghi
     * @param array $data Mảng dữ liệu ['cột' => 'giá trị']
     */
    public function insert($data) {
        $columns = implode(', ', array_keys($data));
        // Tạo các placeholder dạng :column_name
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        // Bind tự động các giá trị
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        return $stmt->execute();
    }

    /**
     * Cập nhật bản ghi theo ID
     * @param int $id
     * @param array $data Mảng dữ liệu ['cột' => 'giá trị_mới']
     */
    public function update($id, $data) {
        $setStr = "";
        foreach ($data as $key => $value) {
            $setStr .= "{$key} = :{$key}, ";
        }
        $setStr = rtrim($setStr, ", "); // Xóa dấu phẩy thừa ở cuối

        $sql = "UPDATE {$this->table} SET {$setStr} WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Bind tự động các giá trị cần cập nhật
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Xóa bản ghi theo ID
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>