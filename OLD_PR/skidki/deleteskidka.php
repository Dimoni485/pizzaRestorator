<?php
require_once("../connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM PROGRAMMALOYAL WHERE ID='".$_POST['idskidka']."'");

?>