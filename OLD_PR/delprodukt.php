<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$Qi=ibase_query("DELETE FROM PRODUKCIYA WHERE ID='".$_POST['idprodukt']."'");
ibase_close ($dbh);
?>