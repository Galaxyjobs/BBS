<?php
//connect.php
$server = 'localhost';
$username   = 'root';
$password   = '123456';
$database   = 'bbs';
$coon=null;
 $conn = new mysqli($server,$username,$password,$database);
 if($error=mysqli_connect_error())
 {
    die("连接失败".$error);
 }
?>