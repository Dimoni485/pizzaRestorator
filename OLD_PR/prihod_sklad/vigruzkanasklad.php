<?php
require_once("../connect.php");

mysqli_query($dbm,"UPDATE SKLAD SET KOLVO=0 WHERE KOLVO IS NULL");
$Qi=mysqli_query($dbm,"SELECT * FROM TOVAR_POSTAVSIK_TMP");
while ($Row=mysqli_fetch_assoc($Qi)) {
	$Qd=mysqli_query($dbm,"UPDATE SKLAD SET KOLVO=KOLVO+".$Row['KOLVO'].", ED_IZ='".$Row['ED_IZ']."', CENA=".$Row['CENA_BRUTTO']." WHERE PRODUKT='".$Row['PRODUKT']."'");
	$Qsum=mysqli_query($dbm,"UPDATE SKLAD SET SUMMA=KOLVO*CENA WHERE PRODUKT='".$Row['PRODUKT']."'");
	$Qsost=mysqli_query($dbm,"UPDATE SOSTAV SET CENA=".$Row['CENA_BRUTTO'].", SUMMA=KOLVO*".$Row['CENA_BRUTTO']." WHERE PRODUKT='".$Row['PRODUKT']."'");
	$itogo = $Row['KOLVO']*(($Row['KOLVO_BRUTTO']*$Row['CENA_BRUTTO'])/$Row['KOLVO']);
	$Qk= mysqli_query($dbm,"INSERT INTO TOVAR_POSTAVSIK(PRODUKT,POSTAVSIK_NAME,KOLVO,CENA,DATA_POS,NUM_SCET,ITOGO,ED_IZ,KOLVO_BRUTTO,CENA_BRUTTO,OSTATOK) VALUES('".$Row['PRODUKT']."','".$Row['POSTAVSIK_NAME']."','".$Row['KOLVO']."','".$Row['CENA']."','".$Row['DATA_POS']."','".$Row['NUM_SCET']."','".$itogo."','".$Row['ED_IZ']."','".$Row['KOLVO_BRUTTO']."','".$Row['CENA_BRUTTO']."','".$Row['KOLVO']."')");
}
$dbe=mysqli_query($dbm,"DELETE FROM TOVAR_POSTAVSIK_TMP");

?>