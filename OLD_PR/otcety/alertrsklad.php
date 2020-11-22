<?php
require_once("../connect.php");
$produkt=$_POST['idcena'];
mysqli_query($dbm,"UPDATE RASHOD_PRODUKT SET CENA=".$_POST['cenaprodukta']." WHERE PRODUKT='".$produkt."'");
//mysqli_query($dbm,"UPDATE RASHOD_PRODUKT SET ITOGO=KOLVO * ".$_POST['cenaprodukta']." WHERE PRODUKT='".$produkt."'");
?>