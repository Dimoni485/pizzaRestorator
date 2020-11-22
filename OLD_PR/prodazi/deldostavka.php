<?php
require_once("../connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM DOSTAVKA WHERE ID_CEK='".$_POST['iddostavka']."'");

?>