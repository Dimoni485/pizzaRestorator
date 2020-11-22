<?php
$prdi=$_POST['idprodukciya'];
$prdsost=$_POST['prodsostav'];
require_once("../connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM SOSTAV WHERE (ID_PRODUKCIYA='".$prdi."' AND PRODUKT='".$prdsost."')");
?>