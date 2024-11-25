<?php
require_once 'connect.php';

class Product
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new myDatabase();
        $this->conn = $this->db->conn;
    }

    public function getHighlightedBooks()
    {
        $sql = "SELECT ds.tenDauSach, ds.tacGia, ds.hinhAnh, MIN(s.giaThue) AS giaThue, dm.ten
                FROM sach s JOIN dausach ds ON s.maDauSach = ds.maDauSach JOIN danhmuc dm ON ds.maDM = dm.maDM 
                WHERE dm.ten IN ('Lịch sử', 'Tiểu thuyết', 'Trinh thám', 'Khoa học viễn tưởng')
                GROUP BY ds.maDauSach, dm.maDM
                Limit 8";
        // Thay 'Tên danh mục sách nổi bật' bằng tên thực tế của danh mục sách nổi bật
        $result = $this->db->query($sql);
        return $result;
    }

    public function getUniqueBookImages($limit = 6)
    {
        $sql = "SELECT DISTINCT hinhAnh FROM dausach LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Lấy dữ liệu hình ảnh 
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['hinhAnh'];
        }

        $stmt->close();
        return $images;
    }

    public function getBooksForCarousel($limit = 9)
    {
        $sql = "SELECT ds.tenDauSach, ds.hinhAnh, MIN(s.giaThue) AS giaThue 
                FROM sach s JOIN dausach ds ON s.maDauSach = ds.maDauSach 
                GROUP BY ds.maDauSach 
                ORDER BY RAND() 
                LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $books = [];
        while ($row = $result->fetch_assoc()) {
            $row['giaThue'] = number_format($row['giaThue'], 0, ',', '.') . ' VND';
            $books[] = $row;
        }

        $stmt->close();
        return $books;
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
