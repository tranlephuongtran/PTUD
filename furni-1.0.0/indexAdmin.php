<?php
session_start();
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
}
else if (isset($_GET['quanlydausach'])) {
    $pagead = 'quanlydausach';
} 
else {
    $pagead = 'quanlysanpham';
}

include("page/admin/" . $pagead . "/index.php");
include("layout/footerAd.php");
?>