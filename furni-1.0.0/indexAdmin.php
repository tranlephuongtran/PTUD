<?php

session_start();
ob_start();
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
} else if (isset($_GET['baocaotheodoitonkho'])) {
    $pagead = 'baocaotheodoitonkho';
} else if (isset($_GET['kiemtrahuhong'])) {
    $pagead = 'kiemtrahuhong';
} else {
    $pagead = 'quanlysanpham';
}

include("page/admin/" . $pagead . "/index.php");
include("layout/footerAd.php");
?>