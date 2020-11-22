<?php
require_once("../connect.php");
$adostavka=mysqli_query($dbm,"INSERT INTO DOSTAVKA(SUMMA, DATA_DOS, ID_CEK) VALUES((SELECT DOSTAVKA_SUMM FROM SETTING_PR),'".$_POST['datedostavka']."','".$_POST['iddostavka']."')");

?>