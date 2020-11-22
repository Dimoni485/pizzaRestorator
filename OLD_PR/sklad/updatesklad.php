<?php
$kolvo=$_POST['kolvosklad'];
require_once("../connect.php");
mysqli_query($dbm,"UPDATE SKLAD SET KOLVO='".$_POST['kolvosklad']."' WHERE ID='".$_POST['idsklad']."'");

mysqli_query($dbm,"UPDATE SKLAD SET SUMMA=KOLVO*CENA WHERE ID='".$_POST['idsklad']."'");

echo $kolvo;
?>