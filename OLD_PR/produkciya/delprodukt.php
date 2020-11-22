<?php
require_once("../connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM PRODUKCIYA WHERE ID='".$_POST['idprodukt']."'");
?>