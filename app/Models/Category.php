<?php
/**
 * =========================================================================
 * CLASS: Category (Kế thừa từ BaseModel)
 * - MỤC ĐÍCH: Tương tác với bảng `categories` trong CSDL.
 * - CÁCH SỬ DỤNG: Khởi tạo $category = new Category(); sau đó gọi hàm $category->getAll() 
 * để lấy danh sách các loại đàn (Guitar, Piano...) kèm icon in ra menu bên trái.
 * =========================================================================
 */
require_once ROOT_PATH . '/core/BaseModel.php';

class Category extends BaseModel {
    public function __construct() {
        // Gọi hàm khởi tạo của lớp cha (BaseModel) để kết nối CSDL
        parent::__construct();
        // Gán tên bảng tương ứng trong Database
        $this->table = 'categories';
    }
    // Không cần viết thêm hàm getAll() vì đã được kế thừa sẵn từ BaseModel
}
?>