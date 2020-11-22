<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$postavsik=iconv('UTF-8', 'windows-1251',$_POST['postavsik']);
$kontakt=iconv('UTF-8', 'windows-1251',$_POST['kontakt']);
$Q=ibase_query("INSERT INTO POSTAVSIK(NAME,CONTAKT) VALUES('".$postavsik."','".$kontakt."')");
ibase_close ($dbh);
exit;
?>