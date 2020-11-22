<?php
header('Content-Type: text/html; charset=Windows-1251', true);
$canaconv=iconv("UTF-8", "Windows-1251",$_POST['naimen']);
$idsostav=iconv("UTF-8", "Windows-1251",$_POST['idsostav']);
$kat=iconv("UTF-8", "Windows-1251",$_POST['kat']);
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
ibase_trans();
$Q=ibase_query("UPDATE PRODUKCIYA SET CENA='".$_POST['cena']."',PRODUKT='".$canaconv."',ID_SOSTAV='".$canaconv."',KATEGORIYA='".$kat."' WHERE ID='".$_POST['idprodukt']."'");
ibase_commit();
ibase_close ($dbh);
?>