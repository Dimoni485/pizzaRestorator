<?php
header('Content-Type: text/html; charset=Windows-1251', true);
$produkt=iconv("UTF-8", "Windows-1251",$_POST['produkt']);
$postavsik=iconv("UTF-8", "Windows-1251",$_POST['postavsik']);
$ediz=iconv("UTF-8", "Windows-1251",$_POST['ed_iz']);
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
ibase_trans();
//$Q=ibase_query("UPDATE PRODUKCIYA SET CENA='".$_POST['cena']."',PRODUKT='".$canaconv."',ID_SOSTAV='".$canaconv."',KATEGORIYA='".$kat."' WHERE ID='".$_POST['idprodukt']."'");
$prov=ibase_query("SELECT * FROM TOVAR_POSTAVSIK_TMP WHERE PRODUKT='".$produkt."'");
require_once("connect.php");
if (ibase_fetch_row($prov)==0){
$Q=ibase_query("INSERT INTO TOVAR_POSTAVSIK_TMP(PRODUKT, POSTAVSIK_NAME, KOLVO, CENA, DATA_POS, NUM_SCET, ITOGO, ED_IZ, KOLVO_BRUTTO, CENA_BRUTTO) VALUES('".$produkt."','".$postavsik."','".$_POST['kolvo']."','".$_POST['cena']."','".$_POST['data_pos']."','".$_POST['num_scet']."','".$_POST['itogo']."','".$ediz."','".$_POST['kolvo_brutto']."','".$_POST['cena_brutto']."')");
}else{
$Qup=ibase_query("UPDATE TOVAR_POSTAVSIK_TMP SET PRODUKT='".$produkt."', POSTAVSIK_NAME='".$postavsik."', KOLVO='".$_POST['kolvo']."', CENA='".$_POST['cena']."', DATA_POS='".$_POST['data_pos']."', NUM_SCET='".$_POST['num_scet']."', ITOGO='".$_POST['itogo']."', ED_IZ='".$ediz."', KOLVO_BRUTTO='".$_POST['kolvo_brutto']."', CENA_BRUTTO='".$_POST['cena_brutto']."' WHERE PRODUKT='".$produkt."'");
}
ibase_commit();
ibase_close ($dbh);
?>