<?php
require_once("../connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM TOVAR_POSTAVSIK_TMP WHERE ID='".$_POST['tovarname']."'");

?>