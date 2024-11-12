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
    .container{
        margin-top: 15px;
        margin-bottom: 20px; 
    }
</style>
<body>
<?php
include('header.php')
?>
    <div class="container">
        <h2 class="mb-4">Đổi Mật Khẩu</h2>
        <form method="POST" action="process_change_password.php">
            <div class="mb-3">
                <label for="current_password" class="form-label">Mật khẩu cũ</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required placeholder="Nhập mật khẩu cũ">
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="Nhập mật khẩu mới">
            </div>
            <div class="mb-3">
                <label for="confirm_new_password" class="form-label">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required placeholder="Nhập lại mật khẩu mới">
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Đổi Mật Khẩu</button>
            <a href="index.php" class="btn btn-secondary"> Quay về trang chủ</a>
        </form>
    </div>
<?php
include('footer.php')
?>
</body>
</html>
