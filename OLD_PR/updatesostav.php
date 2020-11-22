<?php
$kolvo=$_POST['kolvosklad'];
require_once("connect.php");
ibase_query("UPDATE SOSTAV SET KOLVO='".$_POST['kolvosklad']."' WHERE ID='".$_POST['idsklad']."'");
ibase_close ($dbh);
echo $kolvo;
?>