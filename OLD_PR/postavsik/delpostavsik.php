<?php
require ('../connect.php');
mysqli_query($dbm,"DELETE FROM POSTAVSIK WHERE ID=".$_POST['idpostavsik']."");
?>