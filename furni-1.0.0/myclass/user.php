<?php
require_once 'connect.php';

class User {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->conn;
    }

    public function register($hoTen, $tenDangNhap, $email, $password, $confirmPassword, $sdt, $diachi, $agree) {
        // Kiểm tra các trường bắt buộc
        if (!$agree) {
            echo '<script lang="javascript">
                                alert("Bạn phải đồng ý với các chính sách và điều khoản.");
                            </script>';
            exit;
        }

        if ($password !== $confirmPassword) {
            echo '<script lang="javascript">
                                alert("Mật khẩu và xác nhận mật khẩu không khớp.");
                            </script>';
            exit;
        }

        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra email đã tồn tại chưa
        $email_check_query = "SELECT * FROM taikhoan WHERE email='$email' LIMIT 1";
        $result = $this->conn->query($email_check_query);
        $user = $result->fetch_assoc();

        if ($user) { // Nếu email đã tồn tại
            echo '<script lang="javascript">
                                alert("Email đã được sử dụng. Vui lòng sử dụng email khác.");
                            </script>';
            exit;
        } else {
            // Lưu thông tin vào bảng nguoidung
            $nguoidung_query = "INSERT INTO nguoidung (ten, email, SDT, diaChi) VALUES ('$hoTen', '$email', '$sdt', '$diachi')";
            if ($this->conn->query($nguoidung_query) === TRUE) {
                $maNguoiDung = $this->conn->insert_id;
                
                // Lưu thông tin vào bảng taikhoan
                $taikhoan_query = "INSERT INTO taikhoan (email, Password, nguoiDungID) VALUES ('$email', '$hashed_password', '$maNguoiDung')";
                if ($this->conn->query($taikhoan_query) === TRUE) {
                    echo '<script lang="javascript">
                                alert("Đăng ký thành công!");
                            </script>';
                    exit;
                } else {
                    // return "Lỗi: " . $taikhoan_query . "<br>" . $this->conn->error;
                    echo '<script lang="javascript">
                                alert("Lỗi: " . $taikhoan_query . "<br>" . $this->conn->error);
                            </script>';
                    exit;
                }
            } else {
                // return "Lỗi: " . $nguoidung_query . "<br>" . $this->conn->error;
                echo '<script lang="javascript">
                                alert("Lỗi: " . $nguoidung_query . "<br>" . $this->conn->error);
                            </script>';
                exit;
            }
        }
    }

    public function __destruct() {
        $this->db->close();
    }
}
?>
