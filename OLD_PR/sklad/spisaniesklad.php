<?php
$naimenprodukt=$_POST['naimenprodukt'];
$ediz=$_POST['ediz'];
require_once("../connect.php");
mysqli_query($dbm,"UPDATE SKLAD SET KOLVO=KOLVO-".$_POST['kolvospisan']." WHERE ID='".$_POST['idsklad']."'");
require_once("../connect.php");
mysqli_query($dbm,"INSERT INTO SPISANIE(PRODUKT,KOLVO,ED_IZ,DATE_SPIS) VALUES('".$naimenprodukt."','".$_POST['kolvospisan']."','".$ediz."','".date("Y-m-d")."')");
?>