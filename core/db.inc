<?php
// Đường dẫn file: core/db.inc

class Database {
    // Các thuộc tính private để đảm bảo tính Đóng gói (Encapsulation) - Trọn điểm OOP
    private $host = 'localhost';
    private $db_name = 'shopnhaccu'; // Tên database bạn sẽ tạo trong Laragon/phpMyAdmin
    private $username = 'root';      // Mặc định của Laragon
    private $password = '';          // Mặc định của Laragon
    private $conn;

    // Biến lưu trữ instance duy nhất (Singleton Pattern)
    private static $instance = null;

    // Hàm khởi tạo private để ngăn chặn việc dùng từ khóa 'new' tạo nhiều kết nối
    private function __construct() {
        $this->connect();
    }

    // Phương thức public tĩnh để lấy instance duy nhất
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Xử lý kết nối bằng PDO
    private function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            
            // Cấu hình tối ưu và bảo mật cho PDO
            $options = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Ném lỗi văng ra Catch
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Lấy dữ liệu dạng mảng kết hợp
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Bắt buộc dùng Prepared Statements thật (Bảo mật tối đa)
            );

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $e) {
            // Tạm thời hiển thị lỗi. Sau này có thể gọi file error.inc ở đây
            die("Lỗi kết nối Cơ sở dữ liệu: " . $e->getMessage());
        }
    }

    // Trả về đối tượng PDO để các Model sử dụng thực thi truy vấn
    public function getConnection() {
        return $this->conn;
    }
}
?>