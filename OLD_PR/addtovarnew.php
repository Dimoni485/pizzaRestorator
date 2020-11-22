<?php
header('Content-type: text/html; charset=windows-1251');
$produkt=iconv('UTF-8', 'windows-1251',$_POST['produkt']);
$ediz=iconv('UTF-8', 'windows-1251',$_POST['ediz']);
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$Qi=ibase_query("INSERT INTO SKLAD(PRODUKT,ED_IZ,KOLVO,SUMMA) VALUES('".$produkt."','".$ediz."','0','0')");
ibase_close ($dbh);
exit;
?>