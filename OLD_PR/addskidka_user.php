<?php
require_once("connect.php");
$fio=iconv('UTF-8', 'windows-1251',$_POST['fio']);
$adress=iconv('UTF-8', 'windows-1251',$_POST['adress']);
$Q=ibase_query("INSERT INTO KLIENT(FIO,SKIDKA,TELEPHONE,ADRES,GRUPPA) VALUES('".$fio."','".$_POST['skidka']."','".$_POST['telefon']."','".$adress."','1')");
ibase_commit();
ibase_close ($dbh);
?>