<?php
session_start();
error_reporting(0);
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="./images/favicon.png">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <!-- Bootstrap CSS -->
    <link href="layout/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="layout/css/tiny-slider.css" rel="stylesheet">
    <link href="layout/css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>A Plus BookStore</title>
    <!-- CSS Dropdown Menu -->
    <style>
        /* CSS for Hover Dropdown */
        #avatarIcon {
            cursor: pointer;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 10px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            min-width: 150px;
            z-index: 1000;
        }

        .dropdown-item {
            padding: 10px;
            color: brown;
            text-decoration: none;
            display: block;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        #sanPham {
            cursor: pointer;
        }

        .nav-item.dropdown:hover .dropdown-menusp {
            display: block;
        }

        .dropdown-menusp {
            display: none;
            position: absolute;
            right: -75px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            min-width: 250px;
            z-index: 1000;
            color: brown !important;
        }

        .dropdown-itemsp {
            padding: 10px;
            color: brown !important;
            text-decoration: none;
            display: block;
        }

        .dropdown-itemsp:hover {
            background-color: #f1f1f1;
        }



        /* Style cho menu thông báo */
        #notificationMenu {

            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            min-width: 350px;

        }

        /* Hiển thị menu khi hover */
        .nav-item.dropdown:hover #notificationMenu {
            display: block;
        }

        /* Tiêu đề thông báo */
        #notificationMenu b {
            font-size: 16px;
            color: #333;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            display: block;
            font-weight: 600;
        }

        /* Mục thông báo */
        #notificationMenu .dropdown-item {
            padding: 15px;
            color: #555;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        /* Biểu tượng đơn hàng */
        #notificationMenu .dropdown-item::before {
            content: '\f291';
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 18px;
            color: #ff6347;
            /* Màu cam nhấn */
        }

        /* Hover cho mục thông báo */
        #notificationMenu .dropdown-item:hover {
            background-color: #f9f9f9;
            color: #000;
        }

        /* Thông báo trống */
        #notificationMenu p {
            padding: 15px;
            color: #888;
            font-style: italic;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand" href="index.php" style="font-size: 40px;">A Plus<span>.</span></a>
            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?home">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="index.php?shop=1" id="sanPham">Sản phẩm</a>
                        <div id="userMenuSP" class="dropdown-menusp">
                            <?php
                            $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
                            if ($conn) {
                                $str = "SELECT *FROM danhmuc";
                                $result = $conn->query($str);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<a href='index.php?cate={$row['maDM']}' class='dropdown-itemsp'>"
                                            . "{$row['ten']}"
                                            . "</a>";
                                    }
                                }
                            }
                            ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?about">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?services">Chính sách</a>
                    </li>
                </ul>
                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-2"
                    style="font-weight: 500 !important; font-size: large">
                    <?php
                    if (!isset($_SESSION['btnLogin']) || $_SESSION['btnLogin'] !== 1) {
                        echo "
                        <li class='nav-item'><a class='nav-link' href='index.php?register'>Đăng ký</a></li>
                        <li class='nav-item'><a class='nav-link' href='index.php?login'>Đăng nhập</a></li>
                        ";
                    } elseif (isset($_SESSION['btnLogin']) || $_SESSION['btnLogin'] == 1) {
                        echo "
                            <li class='nav-item dropdown'>
                                <a class='nav-link' href='index.php?profile'>
                                    <img src='layout/images/user.svg' id='avatarIcon' alt='User Icon'>
                                </a>
                                <!-- Dropdown Menu -->
                                <div id='userMenu' class='dropdown-menu'>
                                    <a class='dropdown-item' href='index.php?updateProfile'>Cập nhật thông tin</a>
                                    <a class='dropdown-item' href='index.php?change_password'>Đổi mật khẩu</a>";

                        // Kiểm tra nếu mã khách hàng (maKH) tồn tại trong session
                        if (isset($_SESSION['maNguoiDung'])) {
                            echo "
                                    <a class='dropdown-item' href='index.php?history&maNguoiDung=" . $_SESSION['maNguoiDung'] . "'>Xem lịch sử thuê sách</a>";
                        } else {
                            echo "
                                    <a class='dropdown-item' href='#' onclick='alert(\"Hãy đăng nhập tài khoản khách hàng để xem lịch sử mua hàng của bạn\")'>Xem lịch sử thuê sách</a>";
                        }

                        echo "
                                    <a class='dropdown-item' href='index.php?paymentlate'>Thanh toán</a>
                                    <a class='dropdown-item' href='index.php?logout'>Đăng xuất</a>
                                </div>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link' href='index.php?cart'>
                                    <img src='layout/images/cart.svg' alt='Cart Icon'>
                                </a>
                            </li>
                            <li class='nav-item dropdown'>
                                <a class='nav-link' href='#'>
                                    <i class='fa-regular fa-bell' style='font-size: 24px;'></i>
                                </a>
                                <div id='notificationMenu' class='dropdown-menu'>
                                ";
                        if ($conn) {
                            $maNguoiDung = $_SESSION['maNguoiDung']; // Lấy mã người dùng từ session
                    
                            // Truy vấn lấy mã khách hàng từ bảng khachhang
                            $queryKH = "SELECT maKH FROM khachhang WHERE maNguoiDung = '$maNguoiDung'";
                            $resultKH = mysqli_query($conn, $queryKH);

                            if (mysqli_num_rows($resultKH) == 1) {
                                $khachhang = mysqli_fetch_assoc($resultKH);
                                $maKH = $khachhang['maKH']; // Lấy mã khách hàng
                                $query = "
                                SELECT ds.maDon, ds.ngayThue, ctdh.tinhTrangThue
                                FROM donthuesach ds
                                JOIN chitiethoadon ctdh ON ds.maDon = ctdh.maDon
                                WHERE DATEDIFF(CURDATE(), ds.ngayThue) >= 12
                                AND ctdh.tinhTrangThue = 'Đang thuê'
                                AND ds.maKH = '$maKH'";
                                $result = $conn->query($query);

                                if (mysqli_num_rows($result) > 0) {

                                    echo "<b>CÁC ĐƠN HÀNG SẮP HẾT HẠN THUÊ</b>";

                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo "<a href='index.php?invoice_details&maDon={$row['maDon']}' class='dropdown-item'>Mã Đơn: " . "{$row['maDon']}" . " Sắp đến hạn trả !</a>";
                                    }
                                } else {
                                    echo "<p>Không có thông báo mới</p>";
                                }
                            }
                        }

                        echo "
                            </div>
                        </li>";
                    }
                    ?>

                </ul>
            </div>
        </div>
    </nav>
    <!-- End Header/Navigation -->

    <!-- JS to show notification on hover -->

</body>