<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
header('Content-type: text/html; charset=windows-1251');
$naimenprodukt=iconv('UTF-8', 'windows-1251',$_POST['nameprodukt']);
$katprodukt=iconv('UTF-8', 'windows-1251',$_POST['katprodukt']);
require_once("connect.php");
$Q=ibase_query("INSERT INTO PRODUKCIYA(PRODUKT, CENA, ID_SOSTAV, KATEGORIYA) VALUES('".$naimenprodukt."','".$_POST['cenaprodukt']."','".$naimenprodukt."','".$katprodukt."')");
ibase_close ($dbh);
exit;
?>