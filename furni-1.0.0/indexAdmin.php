<?php
session_start();
ob_start();

// Kiểm tra nếu đăng xuất
if (isset($_GET['logoutAdmin'])) {
    session_unset();
    session_destroy();
    header('Location: loginAdmin.php');
    exit();

}
// Kiểm tra nếu chưa đăng nhập
if (!isset($_SESSION['admin_id'])) {
    header('Location: loginAdmin.php');
    exit();
}

include("class/classdatabase.php");
include("layout/sidebar.php");
if (isset($_GET['quanlydanhmuc'])) {
    $pagead = 'quanlydanhmuc';
} else if (isset($_GET['quanlynhanvien'])) {
    $pagead = 'quanlynhanvien';
} else if (isset($_GET['quanlysanpham'])) {
    $pagead = 'quanlysanpham';
} else if (isset($_GET['quanlythetv'])) {
    $pagead = 'quanlythetv';
} else if (isset($_GET['quanlythuetra'])) {
    $pagead = 'quanlythuetra';
} else if (isset($_GET['baocao'])) {
    $pagead = 'baocao';
} else if (isset($_GET['chitietdonthue'])) {
    $pagead = 'chitietdonthue';
} else if (isset($_GET['quanlydausach'])) {
    $pagead = 'quanlydausach';
} else if (isset($_GET['quanlydonhang'])) {
    $pagead = 'quanlydonhang';
} else if (isset($_GET['baocaotheodoitonkho'])) {
    $pagead = 'baocaotheodoitonkho';
} else if (isset($_GET['kiemtrahuhong'])) {
    $pagead = 'kiemtrahuhong';
} else if (isset($_GET['quanlykhuyenmai'])) {
    $pagead = 'quanlykhuyenmai';
} else if (isset($_GET['baocao'])) {
    $pagead = 'baocao';
} else if (isset($_GET['quanlychinhsach'])) {
    $pagead = 'quanlychinhsach';
} else if (isset($_GET['quanlykhachhang'])) {
    $pagead = 'quanlykhachhang';
} else if (isset($_GET['chitietkhachhang'])) {
    $pagead = 'chitietkhachhang';
} else {
    $pagead = 'home';
}
include("page/admin/" . $pagead . "/index.php");
include("layout/footerAd.php");
