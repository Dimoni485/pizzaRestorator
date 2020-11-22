<?php
require_once('../connect.php');
$summ_dostavka=$_POST['summa_dost'];
$naimen= $_POST['naimen'];
$inn_pr=$_POST['inn'];
$adress=$_POST['adress'];
$text_cek=$_POST['reklama'];
$telephone=$_POST['telephone'];
$settin=mysqli_query($dbm,"UPDATE SETTING_PR SET DOSTAVKA_SUMM=".$summ_dostavka.", NAME='".htmlentities($naimen)."', INN=".$inn_pr.", ADRES='".htmlentities($adress)."', CEK_TEXT='".htmlentities($text_cek)."', TELEPHONE='".$telephone."' ");
?>