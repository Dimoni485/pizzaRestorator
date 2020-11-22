<?php
require_once("connect.php");
$Qi=ibase_query("DELETE FROM PROGRAMMALOYAL WHERE ID='".$_POST['idskidka']."'");
ibase_commit();
ibase_close ($dbh);
?>