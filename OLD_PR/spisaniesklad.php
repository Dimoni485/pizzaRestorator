<?php
$naimenprodukt=iconv("UTF-8", "Windows-1251",$_POST['naimenprodukt']);
$ediz=iconv("UTF-8", "Windows-1251",$_POST['ediz']);
require_once("connect.php");
ibase_query("UPDATE SKLAD SET KOLVO=KOLVO-".$_POST['kolvospisan']." WHERE ID='".$_POST['idsklad']."'");
ibase_close ($dbh);
require_once("connect.php");
ibase_query("INSERT INTO SPISANIE(PRODUKT,KOLVO,ED_IZ,DATE_SPIS) VALUES('".$naimenprodukt."','".$_POST['kolvospisan']."','".$ediz."','".date("d.m.Y")."')");
?>