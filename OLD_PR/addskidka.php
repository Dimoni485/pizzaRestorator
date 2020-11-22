<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$nameskidka=iconv('UTF-8', 'windows-1251',$_POST['nameskidka']);
$Q=ibase_query("INSERT INTO PROGRAMMALOYAL(MAXPROCENT,USLOVNAKOP,PROCENT,NAIMEN) VALUES('".$_POST['yesskidka']."','".$_POST['sumskidka']."','".$_POST['procentskidka']."','".$nameskidka."')");
ibase_close ($dbh);
exit;
?>