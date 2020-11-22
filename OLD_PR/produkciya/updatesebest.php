<?php
require_once("../connect.php");
mysqli_query($dbm,"UPDATE PRODUKCIYA SET SEBEST=(SELECT SUM(SUMMA))");
?>