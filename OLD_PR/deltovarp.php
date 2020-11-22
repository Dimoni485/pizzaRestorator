<?php
require_once("connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM TOVAR_POSTAVSIK WHERE ID='".$_POST['tovarname']."'");

?>