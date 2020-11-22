<?php
require_once("connect.php");
$produkt=$_POST['produkt'];
mysqli_query($dbm,"UPDATE RASHOD_PRODUKT SET CENA=".$_POST['cenaprodukta'].", ITOGO=KOLVO*".$_POST['cenaprodukta']." WHERE PRODUKT='".$produkt."'");

?>