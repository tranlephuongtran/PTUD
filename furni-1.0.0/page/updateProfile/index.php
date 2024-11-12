<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Thông Tin Khách Hàng - A Plus BookStore</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        /*  CSS trang cập nhật thông tin */
        body {
            background-color: #f7f8fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
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
            background-color: #003366;
            border: none;
        }

        .btn-primary:hover {
            background-color: #002244;
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

        .btn-secondary:hover {
            background-color: #565e64;
        }
    </style>
</head>

<body>
    <?php
    if (!isset($_GET['updateProfile'])) {
        $updateProfile = 1;
    } else {
        $updateProfile = $_GET['updateProfile'];
    }
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
                <input type="text" class="form-control" id="address" name="address" required
                    placeholder="57/Lê Lợi/ Phường 5/ Gò Vấp/Hcm">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="tel" class="form-control" id="phone" name="phone" required placeholder="012343243243">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required
                    placeholder="trjkas@gmail.com">
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Cập Nhật Thông Tin</button>
            <a href="index.php" class="btn btn-secondary"> Quay về trang chủ</a>
        </form>
    </div>

</body>

</html>