<?php
require_once("../connect.php");
$fio=$_POST['fio'];
$adress=$_POST['adress'];
$Q=mysqli_query($dbm,"INSERT INTO KLIENT(FIO,SKIDKA,TELEPHONE,ADRES,GRUPPA) VALUES('".$fio."','".$_POST['skidka']."','".$_POST['telefon']."','".$adress."','1')");

?>