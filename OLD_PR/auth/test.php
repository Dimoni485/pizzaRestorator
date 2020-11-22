<?php
require_once "../connect.php";
$login='admin';
$password='admin';
$query="SELECT login, password FROM users WHERE login='$login' and password='$password'";
$result=mysqli_query($dbm,$query);
$row=mysqli_fetch_row($result);
if($row[1]!==null) {
    echo $row[0];
}