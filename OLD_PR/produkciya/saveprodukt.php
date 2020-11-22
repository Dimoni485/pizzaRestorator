<?php
$canaconv=$_POST['naimen'];
$idsostav=$_POST['idsostav'];
$kat=$_POST['kat'];
require_once("../connect.php");
$Q=mysqli_query($dbm,"UPDATE PRODUKCIYA SET CENA=".$_POST['cena'].",PRODUKT='".$canaconv."',ID_SOSTAV='".$idsostav."',KATEGORIYA='".$kat."' WHERE ID=".$_POST['idprodukt']);
?>