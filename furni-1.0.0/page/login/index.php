<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">
<?php
if (!isset($_GET['login'])) {
    $login = 1;
} else {
    $login = $_GET['login'];
}
?>
<?php
session_start(); 
error_reporting(0);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin đăng nhập
    $email = $_POST['CustomerEmail'];
    $password = $_POST['CustomerPassword'];

    // Kiểm tra xem email và mật khẩu có bị bỏ trống không
    if (empty($email) || empty($password)) {
        echo "<script>alert('Email và mật khẩu không được để trống!');</script>";
    } else {
        // Kết nối cơ sở dữ liệu
        $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");

        if ($conn) {
            $query = "SELECT * FROM taikhoan WHERE email = '$email'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (md5($password) === $row['Password']) {
                    $_SESSION['user'] = $row['email'];  
                    echo "<script>
                        alert('Đăng nhập thành công!');
                        window.location.href = 'index.php?home';
                        </script>";
                    exit();
                } else {
                    // Mật khẩu không đúng, hiển thị thông báo lỗi
                    echo "<script>alert('Mật khẩu không đúng!');</script>";
                }
            } else {
                // Email không tồn tại
                echo "<script>alert('Email không tồn tại!');</script>";
            }
        } else {
            // Kết nối cơ sở dữ liệu thất bại
            echo "<script>alert('Kết nối cơ sở dữ liệu thất bại!');</script>";
        }
    }
}
?>


<!-- Start Login -->
<div class="login-form-container">
    <div class="form-login">
        <form method="post" action="index.php?login" id="customer_login" accept-charset="UTF-8"
            data-login-with-shop-sign-in="true" novalidate="novalidate">
            <h1 class="title-login"> Đăng nhập </h1>
            <div class="field">
                <input type="email" name="CustomerEmail" class="form-control" id="CustomerEmail" autocomplete="email"
                    autocorrect="off" autocapitalize="off" placeholder="Email" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="field">
                <input type="password" value="" name="CustomerPassword" class="form-control" id="CustomerPassword"
                    autocomplete="current-password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="checkbox">
                <label><input type="checkbox">Ghi nhớ tôi</label>
                <a href="#recover"> Quên mật khẩu? </a>
            </div>
            <button type="submit" class="btn"> Đăng nhập </button>
            <div class="register-link">
                <p>Chưa có tài khoản?<a href="index.php?register"> Đăng ký </a></p>
            </div>
        </form>
    </div>
</div>
<!-- End Login -->





<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>
</body>

</html>