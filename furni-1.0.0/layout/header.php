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
            right: -65px;
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
                        <a class="nav-link" href="index.php?shop" id="sanPham">Sản phẩm</a>
                        <div id="userMenuSP" class="dropdown-menusp">
                            <?php
                            $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
                            if ($conn) {
                                $str = "SELECT *FROM danhmuc";
                                $result = $conn->query($str);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<a href='index.php?danhmuc={$row['maDM']}' class='dropdown-itemsp'>";
                                        echo "{$row['ten']}";
                                        echo "</a>";
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
                    <li class="nav-item"><a class="nav-link" href="index.php?register">Đăng ký</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?login">Đăng nhập</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#">
                            <img src="layout/images/user.svg" id="avatarIcon" alt="User Icon">
                        </a>
                        <!-- Dropdown Menu -->
                        <div id="userMenu" class="dropdown-menu">
                            <a class="dropdown-item" href="index.php?updateProfile">Cập nhật thông tin</a>
                            <a class="dropdown-item" href="index.php?change_password">Đổi mật khẩu</a>
                            <a class="dropdown-item" href="index.php?history">Xem lịch sử thuê sách</a>
                            <a class="dropdown-item" href="index.php?history">Thanh toán</a>
                            <a class="dropdown-item" href="#">Đăng xuất</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="index.php?cart"><img
                                src="layout/images/cart.svg"></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Header/Navigation -->
</body>