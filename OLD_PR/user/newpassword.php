<?php
require_once("../connect.php");
$iduser=$_POST['iduser'];
$password = $_POST['password'];
$Q=mysqli_query($dbm,"UPDATE USERS SET PASSWORD='$password' WHERE ID='".$iduser."'");
?>