<?php
require_once("../connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM SKLAD WHERE ID='".$_POST['idpr']."'");
?>