<?php
require_once('connect.php');
$summ_dostavka=$_POST['summa_dost'];
$naimen=iconv('UTF-8', 'windows-1251', $_POST['naimen']);
$inn_pr=$_POST['inn'];
$adress=iconv('UTF-8', 'windows-1251', $_POST['adress']);
$text_cek=iconv('UTF-8', 'windows-1251', $_POST['reklama']);
$telephone=iconv('UTF-8', 'windows-1251', $_POST['telephone']);
$settin=ibase_query("UPDATE SETTING_PR SET DOSTAVKA_SUMM=".$summ_dostavka.", NAME='".$naimen."', INN=".$inn_pr.", ADRES='".$adress."', CEK_TEXT='".$text_cek."', TELEPHONE='".$telephone."' ");
?>