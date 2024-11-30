<?php
session_start();
error_reporting(0);

// Kiểm tra nếu đã đăng nhập
if (isset($_SESSION['admin_id'])) {
    header('Location: indexAdmin.php'); // Chuyển hướng đến trang quản trị nếu đã đăng nhập
    exit();
}

// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'nhomptud', '123456', 'ptud');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý khi nhấn Đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Tìm tài khoản người dùng
    $sql = "SELECT tk.*, ur.roleId, r.roleName 
            FROM taikhoan tk
            JOIN userroles ur ON tk.nguoiDungID = ur.userId
            JOIN roles r ON ur.roleId = r.roleId
            WHERE tk.email = ? AND tk.Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra vai trò 
        if (in_array($user['roleId'], [1, 2, 3])) {
            $_SESSION['admin_id'] = $user['maTK'];
            $_SESSION['role'] = $user['roleName'];
            $_SESSION['name'] = $user['email'];
            echo "<script>
                    alert('Đăng nhập thành công!');
                    window.location.href = 'indexAdmin.php'; 
                  </script>";
            exit();
        } else {
            $error = "Bạn không có quyền truy cập!";
        }
    } else {
        $error = "Email hoặc mật khẩu không chính xác!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4); /* Gradient mới */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
            font-weight: 500;
        }
        .login-container input {
            width: 93%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .login-container input:focus {
            border-color: #507bf0; /* Đổi màu border khi focus */
            outline: none;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background: #507bf0;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background: #4058e2; /* Đổi màu nút khi hover */
        }
        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .login-container input,
        .login-container button {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container button:hover {
        background: linear-gradient(90deg, #4058e2, #7099f1); /* Gradient nút khi hover */
        transform: translateY(-2px); /* Nổi nhẹ */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Shadow mạnh hơn */
        }
        .login-container button:active {
            transform: translateY(1px); /* Nhấn nhẹ */
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2); /* Shadow giảm */
        }
        .login-container input:focus {
            border-color: #ff9a9e;
            box-shadow: 0 0 8px rgba(255, 154, 158, 0.6); /* Hiệu ứng ánh sáng */
            outline: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Đăng nhập Admin</h1>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng nhập</button>
        </form>
    </div>
</body>
</html>
