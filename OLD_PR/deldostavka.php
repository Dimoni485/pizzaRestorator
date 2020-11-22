<?php
require_once("connect.php");
$Qi=ibase_query("DELETE FROM DOSTAVKA WHERE ID_CEK='".$_POST['iddostavka']."'");
ibase_commit();
?>