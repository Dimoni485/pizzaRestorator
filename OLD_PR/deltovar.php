<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$Qi=ibase_query("DELETE FROM TOVAR_POSTAVSIK_TMP WHERE ID='".$_POST['tovarname']."'");
ibase_close ($dbh);
?>