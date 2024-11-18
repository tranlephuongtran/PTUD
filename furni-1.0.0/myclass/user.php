<?php
require_once 'connect.php';

class User
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->conn;
    }

    public function register($hoTen, $tenDangNhap, $email, $password, $confirmPassword, $sdt, $diachi, $agree)
    {
        if (!empty($hoTen) && !empty($tenDangNhap) && !empty($email) && !empty($sdt) && !empty($password) && !empty($confirmPassword)) {


            // Kiểm tra các trường bắt buộc
            $email_check_query = "SELECT * FROM taikhoan WHERE email='$email' LIMIT 1";
            $result = $this->conn->query($email_check_query);
            $user = $result->fetch_assoc();
            // Kiểm tra email đã tồn tại chưa
            if ($user) { // Nếu email đã tồn tại
                echo '<script lang="javascript">
                                alert("Email đã được sử dụng. Vui lòng sử dụng email khác.");
                            </script>';
            } elseif ($password !== $confirmPassword) {
                echo '<script lang="javascript">
                                alert("Mật khẩu và xác nhận mật khẩu không khớp.");
                            </script>';
            } elseif (!$agree) {
                echo '<script lang="javascript">
                                alert("Bạn phải đồng ý với các chính sách và điều khoản.");
                            </script>';
            } else {
                // Lưu thông tin vào bảng nguoidung
                $nguoidung_query = "INSERT INTO nguoidung (ten, email, SDT, diaChi) VALUES ('$hoTen', '$email', '$sdt', '$diachi')";
                if ($this->conn->query($nguoidung_query) === TRUE) {
                    $maNguoiDung = $this->conn->insert_id;

                    // Lưu thông tin vào bảng taikhoan
                    $taikhoan_query = "INSERT INTO taikhoan (email, Password, nguoiDungID) VALUES ('$email', '$password', '$maNguoiDung')";
                    if ($this->conn->query($taikhoan_query) === TRUE) {
                        echo '<script lang="javascript">
                                alert("Đăng ký thành công!");
                                window.location.href = "index.php?login";
                            </script>';
                    } else {
                        // return "Lỗi: " . $taikhoan_query . "<br>" . $this->conn->error;
                        echo '<script lang="javascript">
                                alert("Lỗi: " . $taikhoan_query . "<br>" . $this->conn->error);
                            </script>';
                    }
                } else {
                    // return "Lỗi: " . $nguoidung_query . "<br>" . $this->conn->error;
                    echo '<script lang="javascript">
                                alert("Lỗi: " . $nguoidung_query . "<br>" . $this->conn->error);
                            </script>';
                }
            }
        } else {
            echo '<script lang="javascript">
                                alert("Vui lòng nhập đầy đủ thông tin");
                            </script>';
        }
        // Mã hóa mật khẩu
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
