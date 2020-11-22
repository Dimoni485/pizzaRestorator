<?php
require_once("../connect.php");
$iduser=$_POST['iduser'];
$Q=mysqli_query($dbm,"DELETE FROM USERS WHERE ID='".$iduser."'");
?>