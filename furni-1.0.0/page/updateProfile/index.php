<?php
session_start();
error_reporting(0);
$errMsg = ''; 

if (!isset($_SESSION['user'])) {
    $errMsg = 'Vui lòng đăng nhập trước!';
    header("Location: ../index.php?login");
    exit();
}

$email = $_SESSION['user'];
$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
if (!$conn) {
    $errMsg = "Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error();
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
    $errMsg = 'Không tìm thấy thông tin người dùng!';
    header("Location: ../index.php?login");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email_new = mysqli_real_escape_string($conn, $_POST['email']);

    // Kiểm tra dd email
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\\.com$/', $email_new)) {
        $errMsg = 'Vui lòng nhập đúng định dạng email, ví dụ: ten@gmail.com';
    }
    // Kiểm tra sdt
    elseif (!preg_match('/^(03|07|09)\d{7,9}$/', $phone)) {
        $errMsg = 'Vui lòng nhập đúng số điện thoại từ 9 đến 11 số (2 số đầu phải là 03, 07 hoặc 09)';
    }
    // Kiểm tra email tồn tại
    elseif ($email_new != $email) {
        $check_email_query = "SELECT * FROM taikhoan WHERE email = '$email_new'";
        $check_email_result = mysqli_query($conn, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            $errMsg = 'Email đã tồn tại. Vui lòng chọn email khác!';
        }
    }

    if ($errMsg == '') {
        // Cập nhật tt bảng nguoidung
        $update_user_query = "
            UPDATE nguoidung 
            SET ten = '$name', diaChi = '$address', SDT = '$phone' 
            WHERE maNguoiDung = '{$user['maNguoiDung']}'
        ";
        $update_user_result = mysqli_query($conn, $update_user_query);

        // Cập nhật email trong cả hai bảng taikhoan và nguoidung nếu email thay đổi
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
                $_SESSION['user'] = $email_new;
            } else {
                $errMsg = 'Cập nhật email thất bại!';
            }
        }

        if ($update_user_result) {
            echo "<script>
                alert('Cập nhật thông tin thành công!');
                window.location.href = 'index.php?profile';
            </script>";
        } else {
            $errMsg = 'Cập nhật thông tin thất bại. Vui lòng thử lại!';
        }
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
            padding: 20px;
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
                    <!-- Hiển thị tb lỗi-->
                    <?php if ($errMsg): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errMsg; ?>
                        </div>
                    <?php endif; ?>

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
