<?php
require_once("connect.php");
ibase_query("UPDATE TOVAR_POSTAVSIK_TMP SET DATA_POS='".$_POST['update_data_tov']."'");
ibase_close ($dbh);
?>