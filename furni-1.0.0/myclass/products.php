<?php
require_once 'connect.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getHighlightedBooks() {
        $sql = "SELECT ds.tenDauSach, ds.tacGia, ds.hinhAnh, MIN(s.giaThue) AS giaThue, dm.ten
                FROM sach s JOIN dausach ds ON s.maDauSach = ds.maDauSach JOIN danhmuc dm ON ds.maDM = dm.maDM 
                WHERE dm.ten IN ('Lịch sử', 'Tiểu thuyết', 'Trinh thám', 'Khoa học viễn tưởng')
                GROUP BY ds.maDauSach, dm.maDM
                Limit 8";  
                // Thay 'Tên danh mục sách nổi bật' bằng tên thực tế của danh mục sách nổi bật
        $result = $this->db->query($sql);
        return $result;
    }
    public function getViralBooks() {
        $sql = "SELECT ds.tenDauSach, ds.tacGia, ds.hinhAnh, MIN(s.giaThue) AS giaThue, dm.ten
                FROM sach s JOIN dausach ds ON s.maDauSach = ds.maDauSach JOIN danhmuc dm ON ds.maDM = dm.maDM 
                WHERE dm.ten IN ('Lịch sử', 'Tiểu thuyết', 'Trinh thám', 'Khoa học viễn tưởng')
                GROUP BY ds.maDauSach, dm.maDM
                Limit 6";  
                // Thay 'Tên danh mục sách nổi bật' bằng tên thực tế của danh mục sách nổi bật
        $result = $this->db->query($sql);
        return $result;
    }
    public function getDemoBooks() {
        $sql = "SELECT ds.tenDauSach, ds.tacGia, ds.hinhAnh, MIN(s.giaThue) AS giaThue, dm.ten
                FROM sach s JOIN dausach ds ON s.maDauSach = ds.maDauSach JOIN danhmuc dm ON ds.maDM = dm.maDM 
                WHERE dm.ten IN ('Lịch sử', 'Tiểu thuyết', 'Trinh thám', 'Khoa học viễn tưởng')
                GROUP BY ds.maDauSach, dm.maDM, ds.hinhAnh
                Limit 6";  
                // Thay 'Tên danh mục sách nổi bật' bằng tên thực tế của danh mục sách nổi bật
        $result = $this->db->query($sql);
        return $result;
    }

    public function __destruct() {
        $this->db->close();
    }
}
?>
