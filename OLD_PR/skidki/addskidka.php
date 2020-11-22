<?php
require_once("../connect.php");
$nameskidka=$_POST['nameskidka'];
$Q=mysqli_query($dbm,"INSERT INTO PROGRAMMALOYAL(MAXPROCENT,USLOVNAKOP,PROCENT,NAIMEN) VALUES('".$_POST['yesskidka']."','".$_POST['sumskidka']."','".$_POST['procentskidka']."','".$nameskidka."')");

exit;
?>