<?php
require_once("../connect.php");
$Qi=mysqli_query($dbm,"DELETE FROM SPISANIE WHERE ID='".$_POST['idspis']."'");

?>