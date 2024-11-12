<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Thông Tin Khách Hàng - A Plus BookStore</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
    .container-main {
        margin-bottom: 20px; 
        
    }
    .tnb{
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .menu {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
<?php
include('header.php')
?>
<div class="container container-main mt-5">
    <div class="row">
        <!-- Menu bên trái -->
        <div class="col-md-3">
            <div class="menu">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="#">Lịch Sử Mua Hàng</a></li>
                    <li><a href="change_password.php">Đổi Mật khẩu </a></li>
                    <li><a href="#">Đăng Xuất</a></li>
                    
                </ul>
            </div>
        </div>

        <!-- Form cập nhật thông tin -->
        <div class="col-md-9">
            <div class="tnb">
                <h2 class="mb-4">Cập Nhật Thông Tin </h2>
                <form method="POST" action="process_update_profile.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Phạm Quang Trường">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" required placeholder="57/Lê Lợi/ Phường 5/ Gò Vấp/Hcm">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required placeholder="012343243243">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="trjkas@gmail.com">
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Cập Nhật Thông Tin</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php')
?>
</body>
</html>
