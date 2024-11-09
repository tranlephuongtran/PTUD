<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu - A Plus BookStore</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f8fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            font-weight: bold;
            color: #333;
        }

        label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
            border-color: #ced4da;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            background-color: #6c757d;
            border: none;
            margin-top: 10px;
        }

    </style>
</head>
<body>
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
</body>
</html>
