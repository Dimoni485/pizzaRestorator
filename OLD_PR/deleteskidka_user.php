<?php
require_once("connect.php");
$Qi=ibase_query("DELETE FROM KLIENT WHERE ID='".$_POST['idskidka']."'");
ibase_commit();
ibase_close ($dbh);
?>