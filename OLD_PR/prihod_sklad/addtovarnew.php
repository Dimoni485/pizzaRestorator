<?php
$produkt=$_POST['produkt'];
$ediz=$_POST['ediz'];
require_once("../connect.php");
$Qi=mysqli_query($dbm,"INSERT INTO SKLAD(PRODUKT,ED_IZ,KOLVO,SUMMA) VALUES('".$produkt."','".$ediz."',null, null)");
exit;
?>