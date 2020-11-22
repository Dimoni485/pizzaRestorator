<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$selectsostav=iconv('UTF-8', 'windows-1251',$_POST['selectsostav']);
$idprodukt=iconv('UTF-8', 'windows-1251',$_POST['idprodukt']);
$ediz=iconv('UTF-8', 'windows-1251',$_POST['ediz']);
require_once("connect.php");

$s=ibase_query("select FIRST 1 CENA FROM TOVAR_POSTAVSIK where PRODUKT='".$selectsostav."' AND OSTATOK > 0 ORDER BY DATA_POS");
while ($Rowi=ibase_fetch_assoc($s))
{
 $cenaprodukt=$Rowi['CENA']; 
}
$summacena=$_POST['kolprod'] * $cenaprodukt;
$Q=ibase_query("INSERT INTO SOSTAV(PRODUKT, ID_PRODUKCIYA, KOLVO, ED_IZ, SUMMA) VALUES('".$selectsostav."','".$idprodukt."','".$_POST['kolprod']."','".$ediz."','".$summacena."')");
ibase_commit();
ibase_close ($dbh);
exit;
?>