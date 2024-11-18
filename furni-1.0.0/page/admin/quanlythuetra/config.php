<?php
$servername = "localhost";
$username = "nhomptud";
$password = "123456";
$dbname = "ptud";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>