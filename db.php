<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "quan_ly_sinh_vien"; // Tên database của bạn

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}
?>
//Cập nhập dữ liệu