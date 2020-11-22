<?php
header('Content-type: text/html; charset=windows-1251');
require_once("connect.php");
$Qi=ibase_query("SELECT * FROM TOVAR_POSTAVSIK_TMP");
while ($Row=ibase_fetch_assoc($Qi)) {
$Qc=ibase_query("SELECT COUNT(*) FROM SKLAD WHERE PRODUKT='".$Row['PRODUKT']."' AND CENA='".$Row['CENA_BRUTTO']."'");
$numrow=ibase_fetch_row($Qc);
//echo $numrow[0];
if ($numrow[0] > 0){
ibase_query("UPDATE SKLAD SET KOLVO=0 WHERE KOLVO IS NULL");
$Qd=ibase_query("UPDATE SKLAD SET KOLVO=KOLVO+".$Row['KOLVO'].", ED_IZ='".$Row['ED_IZ']."', CENA=".$Row['CENA_BRUTTO']." WHERE PRODUKT='".$Row['PRODUKT']."' AND CENA='".$Row['CENA_BRUTTO']."' ");

}else
{	
$Qq=ibase_query("INSERT INTO SKLAD(PRODUKT,KOLVO,ED_IZ,CENA) VALUES('".$Row['PRODUKT']."','".$Row['KOLVO']."','".$Row['ED_IZ']."','".$Row['CENA_BRUTTO']."')");
}
$xun=0;
$Qk= ibase_query("INSERT INTO TOVAR_POSTAVSIK(PRODUKT,POSTAVSIK_NAME,KOLVO,CENA,DATA_POS,NUM_SCET,ED_IZ,KOLVO_BRUTTO,CENA_BRUTTO,OSTATOK) VALUES('".$Row['PRODUKT']."','".$Row['POSTAVSIK_NAME']."','".$Row['KOLVO']."','".$Row['CENA']."','".$Row['DATA_POS']."','".$Row['NUM_SCET']."','".$Row['ED_IZ']."','".$Row['KOLVO_BRUTTO']."','".$Row['CENA_BRUTTO']."','".$Row['KOLVO']."')");
$checkrashod=ibase_query("SELECT * FROM RASHOD_PRODUKT WHERE PRODUKT='".$Row['PRODUKT']."' AND CENA=0 OR CENA IS NULL");
while ($rowcheckrashod=ibase_fetch_assoc($checkrashod)){
	if ($xun < $Row['KOLVO']){
		ibase_query("UPDATE RASHOD_PRODUKT SET CENA=".$Row['CENA_BRUTTO'].", ITOGO=KOLVO*".$Row['CENA_BRUTTO']." WHERE (PRODUKT='".$Row['PRODUKT']."') AND (CENA=0 OR CENA IS NULL)");
	$xun=$xun+$rowcheckrashod['KOLVO'];
	}
}
}
$dbe=ibase_query("DELETE FROM TOVAR_POSTAVSIK_TMP");
ibase_commit();
ibase_close();

?>