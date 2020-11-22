<?php
$kolvo=$_POST['kolvosklad'];
require_once("connect.php");
ibase_query("UPDATE SKLAD SET KOLVO='".$_POST['kolvosklad']."' WHERE ID='".$_POST['idsklad']."'");
ibase_commit();
ibase_query("UPDATE SKLAD SET SUMMA=KOLVO*CENA WHERE ID='".$_POST['idsklad']."'");
ibase_commit();
ibase_close ($dbh);
echo $kolvo;
?>