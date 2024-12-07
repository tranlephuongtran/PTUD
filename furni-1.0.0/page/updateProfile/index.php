<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Vui lòng đăng nhập trước!');</script>";
    header("Location: ../index.php?login");
    exit();
}
$email = $_SESSION['user'];
$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}
$query = "
    SELECT taikhoan.email, nguoidung.ten, nguoidung.diaChi, nguoidung.SDT, nguoidung.maNguoiDung
    FROM taikhoan
    INNER JOIN nguoidung ON taikhoan.maNguoiDung = nguoidung.maNguoiDung
    WHERE taikhoan.email = '$email'
";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Không tìm thấy thông tin người dùng!');</script>";
    header("Location: ../index.php?login");
    exit();
}

// Xử lý cập nhật thông tin khi form được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email_new = mysqli_real_escape_string($conn, $_POST['email']);
    // Kiểm tra email mới đã tồn tại chưa
    if ($email_new != $email) {
        $check_email_query = "SELECT * FROM taikhoan WHERE email = '$email_new'";
        $check_email_result = mysqli_query($conn, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            echo "<script>
                alert('Email đã tồn tại. Vui lòng chọn email khác!');
                window.location.href = 'index.php?updateProfile';
            </script>";
            exit();
        }
    }

    // Cập nhật thông tin trong bảng nguoidung
    $update_user_query = "
        UPDATE nguoidung 
        SET ten = '$name', diaChi = '$address', SDT = '$phone' 
        WHERE maNguoiDung = '{$user['maNguoiDung']}'
    ";
    $update_user_result = mysqli_query($conn, $update_user_query);

    // Cập nhật email trong cả hai bảng tailhoan và nguoidung nếu email thay đổi
    if ($email_new != $email) {
        $update_email_taikhoan_query = "
            UPDATE taikhoan 
            SET email = '$email_new' 
            WHERE email = '$email'
        ";
        $update_email_nguoidung_query = "
            UPDATE nguoidung 
            SET email = '$email_new' 
            WHERE maNguoiDung = '{$user['maNguoiDung']}'
        ";
        $update_email_taikhoan_result = mysqli_query($conn, $update_email_taikhoan_query);
        $update_email_nguoidung_result = mysqli_query($conn, $update_email_nguoidung_query);

        if ($update_email_taikhoan_result && $update_email_nguoidung_result) {
            // Cập nhật session
            $_SESSION['user'] = $email_new;
        } else {
            echo "<script>
                alert('Cập nhật email thất bại!');
                window.location.href = 'index.php?updateProfile';
            </script>";
            exit();
        }
    }

    // Kiểm tra kết quả cập nhật
    if ($update_user_result) {
        echo "<script>
            alert('Cập nhật thông tin thành công!');
            window.location.href = 'index.php?profile';
        </script>";
    } else {
        echo "<script>
            alert('Cập nhật thông tin thất bại. Vui lòng thử lại!');
        </script>";
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Thông Tin Khách Hàng - A Plus BookStore</title>
    <link href="../layout/css/bootstrap.min.css" rel="stylesheet">
    <link href="../layout/css/style.css" rel="stylesheet">
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
</head>

<body>
    <div class="container container-main">
        <div class="row">
            <!-- Menu bên trái -->
            <div class="col-md-2">
                <div class="menu">
                    <ul>
                        <li><a href="index.php?profile">Tài khoản của tôi</a></li>

                        <li><a href="index.php?change_password">Đổi mật khẩu</a></li>
                        <li><a href="index.php?history&maNguoiDung=<?php echo $_SESSION['maNguoiDung']; ?>">Lịch sử thuê sách</a></li>
                        <li><a href="index.php?logout">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>

            <!-- Form cập nhật thông tin -->
            <div class="col-md-10">
                <div class="tnb">
                    <h2 class="mb-4">Cập Nhật Thông Tin</h2>
                    <form method="POST" action="index.php?updateProfile">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="<?php echo htmlspecialchars($user['ten'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" required
                                value="<?php echo htmlspecialchars($user['diaChi'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required
                                value="<?php echo htmlspecialchars($user['SDT'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Cập Nhật Thông Tin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>