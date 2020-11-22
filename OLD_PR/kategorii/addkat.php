<?php
require_once("../connect.php");
$kat=$_POST['kat'];
$Q=mysqli_query($dbm,"INSERT INTO KATEGORII(KAT) VALUES('".$kat."')");

exit;
?>