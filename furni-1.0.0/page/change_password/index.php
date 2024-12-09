<?php
session_start();
error_reporting(0);
$email = $_SESSION['user'];
$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
// Kiểm tra nếu form gửi thì xử lý
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_new_password = mysqli_real_escape_string($conn, $_POST['confirm_new_password']);
    $query = "SELECT Password FROM taikhoan WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);    
        // Kiểm tra mật khẩu cũ
        if ($current_password === $row['Password']) {
            // Kiểm tra mật khẩu mới và mật khẩu xác nhận 
            if ($new_password === $confirm_new_password) {
                $update_query = "UPDATE taikhoan SET Password = '$new_password' WHERE email = '$email'";
                if (mysqli_query($conn, $update_query)) {
                    echo "<script>alert('Mật khẩu đã được thay đổi thành công!'); window.location.href = 'index.php';</script>";
                } else {
                    echo "<script>alert('Có lỗi xảy ra khi cập nhật mật khẩu. Vui lòng thử lại!');</script>";
                }
            } else {
                echo "<script>alert('Mật khẩu mới và xác nhận mật khẩu không khớp.');</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu cũ không chính xác.');</script>";
        }
    } else {
        echo "<script>alert('Không tìm thấy tài khoản.');</script>";
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu - A Plus BookStore</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
    .container-main {
        margin-top: 15px;
        margin-bottom: 20px;
    }
    .tnb {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .menu {
        /* background-color: #f8f9fa; */
        padding: 20px;
        /* border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
    }
    .menu ul {
        list-style-type: none;
        padding: 0;
    }
    .menu ul li {
        margin-bottom: 10px;
    }
    .menu ul li a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
    }
    .menu ul li a:hover {
        color: #007bff;
    }
</style>
<body>
    <div class="container container-main">
        <div class="row">
            <!-- Menu bên trái -->
            <div class="col-md-2">
                <div class="menu">
                    <ul>
                        <li><a href="index.php?profile">Tài khoản của tôi</a></li>
                        <li><a href="index.php?updateProfile">Cập nhật thông tin</a></li>
                        <li><a href="index.php?history&maNguoiDung=<?php echo $_SESSION['maNguoiDung']; ?>">Lịch sử thuê sách</a></li>
                        <li><a href="index.php?logout">Đăng Xuất</a></li>
                    </ul>
                </div>
            </div>
            <!-- Form đổi mật khẩu -->
            <div class="col-md-10">
                <div class="tnb">
                    <h2 class="mb-4">Đổi Mật Khẩu</h2>
                    <form method="POST" action="index.php?change_password">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu cũ</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required placeholder="Nhập mật khẩu cũ">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required
                                placeholder="Nhập mật khẩu mới">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_new_password" class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirm_new_password"
                                name="confirm_new_password" required placeholder="Nhập lại mật khẩu mới">
                        </div>
                        <button type="submit" class="btn btn-primary">Đổi Mật Khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
