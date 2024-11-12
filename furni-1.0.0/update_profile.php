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
    .container{
        margin-bottom: 20px; 
    }
</style>
<body>
<?php
include('header.php')
?>
    <div class="container mt-5">
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
            <a href="index.php" class="btn btn-secondary"> Quay về trang chủ</a>
        </form>
    </div>
<?php
include('footer.php')
?>
</body>
</html>