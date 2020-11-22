<?php
require_once("../connect.php");
$kolvosklad=$_POST['kolvosklad'];
$idsklad=$_POST['idsklad'];

mysqli_query($dbm,"UPDATE SOSTAV SET KOLVO=$kolvosklad WHERE ID=$idsklad");
mysqli_query($dbm,"UPDATE SOSTAV SET SUMMA=KOLVO*CENA WHERE ID=$idsklad");