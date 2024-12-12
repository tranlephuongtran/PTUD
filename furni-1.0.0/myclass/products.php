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
        $sql = "SELECT ds.maDauSach, ds.tenDauSach, ds.tacGia, ds.hinhAnh, MIN(s.giaThue) AS giaThue, dm.ten
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
        $sql = "SELECT DISTINCT hinhAnh, maDauSach FROM dausach LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Lấy dữ liệu hình ảnh và maDauSach
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = ['hinhAnh' => $row['hinhAnh'], 'maDauSach' => $row['maDauSach']];
        }

        $stmt->close();
        return $images;
    }

    public function getBooksForCarousel($limit = 9)
    {
        $sql = "SELECT ds.maDauSach, ds.tenDauSach, ds.hinhAnh, MIN(s.giaThue) AS giaThue 
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

    // Phương thức getProductDetails để lấy chi tiết sản phẩm theo maDauSach 
    public function getProductDetails($maDauSach)
    {
        $sql = "SELECT ds.tenDauSach, ds.tacGia, ds.hinhAnh, s.giaThue 
                FROM dausach ds 
                JOIN sach s ON ds.maDauSach = s.maDauSach 
                WHERE ds.maDauSach = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maDauSach);
        $stmt->execute();
        $result = $stmt->get_result();
        $details = $result->fetch_assoc();
        $stmt->close();
        return $details;
    }

    public function getThanhLyBooks()
    {
        $sql = "SELECT DISTINCT s.maSach, ds.tenDauSach, ds.tacGia 
                FROM sach s 
                JOIN dausach ds ON s.maDauSach = ds.maDauSach 
                LEFT JOIN ( SELECT maSach, MAX(ngayTra) as ngayTraCuoi, tinhTrangThue 
                            FROM chitiethoadon 
                            GROUP BY maSach, tinhTrangThue 
                ) cthd ON s.maSach = cthd.maSach 
                WHERE LOWER(s.tinhTrang) = LOWER('Thanh Ly') 
                AND (cthd.maSach IS NULL OR LOWER(cthd.tinhTrangThue) = LOWER('Đã trả')) 
                GROUP BY s.maSach, ds.tenDauSach, ds.tacGia";


        $result = $this->conn->query($sql);

        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        return $books;
    }

    public function updateBookStatus($maSach)
    {
        // Bắt đầu transaction 
        $this->conn->begin_transaction();

        try {
            // Cập nhật trạng thái của sách thành "Đã Thanh Lý" 
            $sql = "UPDATE sach SET tinhTrang = 'Đã Thanh Lý' WHERE maSach = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $maSach);
            $stmt->execute();

            // Lấy maDauSach của sách để cập nhật dausach 
            $sql = "SELECT maDauSach FROM sach WHERE maSach = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $maSach);
            $stmt->execute();
            $result = $stmt->get_result();
            $maDauSach = $result->fetch_assoc()['maDauSach'];

            // Cập nhật tongSoLuong và soLuongDangThue của dausach 
            $sql = "UPDATE dausach 
                    SET tongSoLuong = CASE WHEN tongSoLuong > 0 THEN tongSoLuong - 1 ELSE 0 END, 
                        soLuongDangThue = CASE WHEN soLuongDangThue > 0 THEN soLuongDangThue - 1 ELSE 0 END 
                    WHERE maDauSach = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $maDauSach);
            $stmt->execute();

            // Commit transaction 
            $this->conn->commit();
            $stmt->close();
        } catch (Exception $e) {
            // Rollback transaction nếu có lỗi 
            $this->conn->rollback();
            throw $e;
        }
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
