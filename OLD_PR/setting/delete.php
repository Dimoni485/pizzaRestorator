<?php
require_once("../connect.php");
$data_pok=$_POST['data_pok'];
mysqli_query($dbm,"DELETE FROM PRODAZI WHERE DATE_POK='".$data_pok."'");
mysqli_query($dbm,"DELETE FROM RASHOD_PRODUKT WHERE DATA_PROD='".$data_pok."'");
mysqli_query($dbm,"DELETE FROM TOVAR_POSTAVSIK WHERE DATA_POS='".$data_pok."'");
?>