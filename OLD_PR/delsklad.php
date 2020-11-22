<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$Qi=ibase_query("DELETE FROM SKLAD WHERE ID='".$_POST['idpr']."'");
ibase_close ($dbh);
?>