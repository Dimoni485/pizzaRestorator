<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("../connect.php");
$postavsik=$_POST['postavsik'];
$kontakt=$_POST['kontakt'];
$Q=mysqli_query($dbm,"INSERT INTO POSTAVSIK(NAME,CONTAKT) VALUES('".$postavsik."','".$kontakt."')");

exit;
?>