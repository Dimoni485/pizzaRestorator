<?php


require_once("../connect.php");
$naimenprodukt=$_POST['nameprodukt'];
$cenaprodukt=$_POST['cenaprodukt'];
$katprodukt=$_POST['katprodukt'];
$sql="INSERT INTO PRODUKCIYA(PRODUKT, CENA, ID_SOSTAV, KATEGORIYA) VALUES('$naimenprodukt','$cenaprodukt','$naimenprodukt','$katprodukt')";
$Q=mysqli_query($dbm,$sql);