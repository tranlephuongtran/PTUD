<?php
session_start();
include("layout/header.php");
if (isset($_GET['about'])) {
    $page = 'about';
} else if (isset($_GET['cart'])) {
    $page = 'cart';
} else if (isset($_GET['change_password'])) {
    $page = 'change_password';
} else if (isset($_GET['checkout'])) {
    $page = 'checkout';
} else if (isset($_GET['confirmpayment'])) {
    $page = 'confirmpayment';
} else if (isset($_GET['history'])) {
    $page = 'history';
} else if (isset($_GET['home'])) {
    $page = 'home';
} else if (isset($_GET['login'])) {
    $page = 'login';
} else if (isset($_GET['payment'])) {
    $page = 'payment';
} else if (isset($_GET['productdetails'])) {
    $page = 'productdetails';
} else if (isset($_GET['register'])) {
    $page = 'register';
} else if (isset($_GET['services'])) {
    $page = 'services';
} else if (isset($_GET['shop'])) {
    $page = 'shop';
} else if (isset($_GET['updateProfile'])) {
    $page = 'updateProfile';
} else if (isset($_GET['product'])) {
    $page = 'productdetails';
} else if (isset($_GET['cate'])) {
    $page = 'category';
} else {
    $page = 'home';
}
include("page/" . $page . "/index.php");
include("layout/footer.php");
?>