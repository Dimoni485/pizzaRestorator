<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
$prdi=iconv('UTF-8', 'Windows-1251',$_POST['idprodukciya']);
$prdsost=iconv('UTF-8', 'Windows-1251',$_POST['prodsostav']);
require_once("connect.php");
$Qi=ibase_query("DELETE FROM SOSTAV WHERE (ID_PRODUKCIYA='".$prdi."' AND PRODUKT='".$prdsost."')");
ibase_close ($dbh);
?>