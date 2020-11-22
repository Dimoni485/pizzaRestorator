<?php
require_once("../connect.php");
$selectsostav=$_POST['selectsostav'];
$idprodukt=$_POST['idprodukt'];
$ediz=$_POST['ediz'];
$kolprod=$_POST['kolprod'];

/*$s=mysqli_query($dbm,"select FIRST 1 CENA FROM TOVAR_POSTAVSIK where PRODUKT='".$selectsostav."' AND OSTATOK > 0 ORDER BY DATA_POS");*/
$s=mysqli_query($dbm,"select CENA FROM SKLAD where PRODUKT='$selectsostav'");
while ($Rowi=mysqli_fetch_assoc($s))
{
 $cenaprodukt=$Rowi['CENA']; 
}
$summacena=$_POST['kolprod'] * $cenaprodukt;
$Q=mysqli_query($dbm,"INSERT INTO SOSTAV(PRODUKT, ID_PRODUKCIYA, KOLVO, ED_IZ, SUMMA) VALUES('$selectsostav','$idprodukt','$kolprod','$ediz','$summacena')");
?>