<?php
$produkt=$_POST['produkt'];
$postavsik=$_POST['postavsik'];
$ediz=$_POST['ediz'];

require_once("../connect.php");
$Qi=mysqli_query($dbm,"INSERT INTO TOVAR_POSTAVSIK_TMP(PRODUKT,POSTAVSIK_NAME,KOLVO,DATA_POS,NUM_SCET,ED_IZ,KOLVO_BRUTTO,CENA_BRUTTO) VALUES('".$produkt."','".$postavsik."','".$_POST['vesnetto']."','".$_POST['dates']."','".$_POST['numscet']."','".$ediz."','".$_POST['vesbrutto']."','".$_POST['cenabrutto']."')");

exit;
?>