<?php
require_once("../connect.php");
mysqli_query($dbm,"UPDATE TOVAR_POSTAVSIK_TMP SET DATA_POS='".$_POST['update_data_tov']."'");

?>