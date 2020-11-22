<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$kat=iconv('UTF-8', 'windows-1251',$_POST['kat']);
$Q=ibase_query("INSERT INTO KATEGORII(KAT) VALUES('".$kat."')");
ibase_close ($dbh);
exit;
?>