<?php
require_once("../connect.php");
$login=$_POST['login'];
$password=$_POST['password'];
$Q=mysqli_query($dbm,"INSERT INTO USERS(LOGIN, PASSWORD) VALUES('".$login."','".$password."')");
exit;
?>