<?php
require_once("connect.php");
$adostavka=ibase_query("INSERT INTO DOSTAVKA(SUMMA, DATA_DOS, ID_CEK) VALUES('80','".$_POST['datedostavka']."','".$_POST['iddostavka']."')");
ibase_commit();
?>