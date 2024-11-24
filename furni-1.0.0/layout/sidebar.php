<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="layout/images/apple-icon.png">
    <link rel="icon" type="image/png" href="layout/images/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Admin A Plus</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="layout/css/bootstrapAD.min.css" rel="stylesheet" />
    <link href="layout/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="layout/css/demo.css" rel="stylesheet" />
    <style>
        .sidebar .nav-item.dropdown {
            position: relative;
        }

        .sidebar .nav-link {
            color: #fff;
            padding: 15px 20px;
            transition: background-color 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);

        }

        .sidebar .dropdown-menu {
            display: none;

            position: absolute;
            left: 100%;
            top: 0;
            background-color: #2c2c2c;

            padding: 0;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .sidebar .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        .sidebar .dropdown-item {
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
        }

        .sidebar .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.2)
        }
    </style>
</head>


<body>

    <div class="wrapper">
        <div class="sidebar" data-image="layout/images/sidebar-4.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="javascript:;" class="simple-text">
                        A Plus Admin
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-home"></i>
                            <p>Kho</p>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Theo dõi tồn kho</a>
                            <a class="dropdown-item" href="#">Báo cáo tồn kho</a>
                            <a class="dropdown-item" href="#">Kiểm tra hư hỏng</a>
                            <a class="dropdown-item" href="#">Xử lý hư hỏng</a>
                            <a class="dropdown-item" href="#">Thanh lý</a>
                            <a class="dropdown-item" href="#">Báo cáo</a>
                        </div>

                    </li>
                    <li>
                        <a class="nav-link" href="indexAdmin.php?thongtincanhan">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Thông tin cá nhân</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="indexAdmin.php?quanlythuetra">
                            <i class="fa fa-refresh"></i>
                            <p>Quản lý thuê trả</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="indexAdmin.php?quanlysanpham">
                            <i class="nc-icon nc-notes"></i>
                            <p>Quản lý sản phẩm</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="indexAdmin.php?quanlydanhmuc">
                            <i class="nc-icon nc-notes"></i>
                            <p>Quản lý danh mục</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="indexAdmin.php?quanlydausach">
                            <i class="nc-icon nc-notes"></i>
                            <p>Quản lý đầu sách</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="indexAdmin.php?quanlythetv">
                            <i class="fa fa-id-card-o"></i>
                            <p>Quản lý thẻ TV</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="indexAdmin.php?quanlynhanvien">
                            <i class="fa fa-id-badge"></i>
                            <p>Quản lý nhân viên</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="indexAdmin.php?quanlykhuyenmai">
                            <i class="nc-icon nc-notes"></i>
                            <p>Quản lý khuyến mãi</p>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">

                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nc-icon nc-zoom-split"></i>
                                    <span class="d-lg-block">&nbsp;Search</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">Account</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">Log out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <!-- <div class="content">
                <div class="container-fluid">
                    <div class="section">
                    </div>
                </div>
            </div> -->