<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="./images/favicon.png">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>A Plus BookStore</title>
    <style>
        /* Ẩn dropdown mặc định */
        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: -25px;
            background-color: #a76d49;
            box-shadow: 0 4px 8px #f9bf29;
            padding: 10px;
            z-index: 1000;
        }

        /* Hiển thị dropdown khi hover vào li chứa nó */
        .nav-item:hover .dropdown-content {
            display: flex;
            flex-direction: column;
            color: #964B00;
        }

        .nav-item {
            position: relative;
        }

        /* Đặt lại màu nền khi hover vào dropdown item */
        .dropdown-content a.dropdown-item:hover {
            color: #ffffff !important;
            /* Giữ màu nâu khi hover */
            background-color: transparent !important;
            /* Loại bỏ màu nền xám */
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
                        <a class="nav-link" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Sản phẩm</a>
                        <div class="dropdown-content">
                            <a href="#" class="dropdown-item">Danh mục A</a>
                            <a href="#" class="dropdown-item">Danh mục B</a>
                            <a href="#" class="dropdown-item">Danh mục C</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Chính sách</a>
                    </li>
                </ul>
                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-2"
                    style="font-weight: 500 !important; font-size: large">
                    <li class="nav-item"><a class="nav-link" href="#">Đăng ký</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Đăng nhập</a></li>
                    <li class="nav-item dropdown">
                    <a class="nav-link" href="#" onclick="toggleMenu()">
                        <img src="images/user.svg" id="avatarIcon" alt="User Icon">
                    </a>
                    <!-- Dropdown Menu -->
                    <div id="userMenu" class="dropdown-menu">
                        <a class="dropdown-item" href="update_profile.php">Cập nhật thông tin</a>
                        <a class="dropdown-item" href="change_password.php">Đổi mật khẩu</a>
                        <a class="dropdown-item" href="logout.php">Đăng xuất</a>
                    </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="cart.php"><img src="images/cart.svg"></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Header/Navigation -->
</body>
<!-- javascript menu thông tin khách hàng  -->
<script>
    function toggleMenu() {
        const menu = document.getElementById('userMenu');
        menu.classList.toggle('show');
    }

    // Close the dropdown menu if clicked outside
    window.onclick = function(event) {
        if (!event.target.matches('#avatarIcon')) {
            const dropdowns = document.getElementsByClassName("dropdown-menu");
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

<!-- CSS Dropdown Menu -->
<style>
    #avatarIcon {
        cursor: pointer;
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
    .dropdown-menu.show {
        display: block;
    }
    .dropdown-item {
        padding: 10px;
        color: #333;
        text-decoration: none;
        display: block;
    }
    .dropdown-item:hover {
        background-color: #f1f1f1;
    }
</style>