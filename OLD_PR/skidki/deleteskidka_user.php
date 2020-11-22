<?php
require_once("../connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM KLIENT WHERE ID='".$_POST['idskidka']."'");
?>