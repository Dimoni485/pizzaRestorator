<?php
$produkt=$_POST['produkt'];
$postavsik=$_POST['postavsik'];
$ediz=$_POST['ed_iz'];
$kolvo=$_POST['kolvo'];
$cena=$_POST['cena'];
$data_pos=$_POST['data_pos'];
$num_scet=$_POST['num_scet'];
$itogo=$_POST['itogo'];
$kolvo_brutto=$_POST['kolvo_brutto'];
$cena_brutto=$_POST['cena_brutto'];

require_once("../connect.php");
//$Q=mysqli_query($dbm,"UPDATE PRODUKCIYA SET CENA='".$_POST['cena']."',PRODUKT='".$canaconv."',ID_SOSTAV='".$canaconv."',KATEGORIYA='".$kat."' WHERE ID='".$_POST['idprodukt']."'");
$prov=mysqli_query($dbm,"SELECT * FROM TOVAR_POSTAVSIK_TMP WHERE PRODUKT='$produkt'");
if (mysqli_fetch_row($prov)==0){
$Q=mysqli_query($dbm,"INSERT INTO TOVAR_POSTAVSIK_TMP(PRODUKT, POSTAVSIK_NAME, KOLVO, CENA, DATA_POS, NUM_SCET, ITOGO, ED_IZ, KOLVO_BRUTTO, CENA_BRUTTO) VALUES('$produkt','$postavsik',$kolvo,$cena,'$data_pos', $num_scet, $itogo, '$ediz', $kolvo_brutto, $cena_brutto)");
}else{
$Qup=mysqli_query($dbm,"UPDATE TOVAR_POSTAVSIK_TMP SET PRODUKT='".$produkt."', POSTAVSIK_NAME='".$postavsik."', KOLVO='".$_POST['kolvo']."', CENA='".$_POST['cena']."', DATA_POS='".$_POST['data_pos']."', NUM_SCET='".$_POST['num_scet']."', ITOGO='".$_POST['itogo']."', ED_IZ='".$ediz."', KOLVO_BRUTTO='".$_POST['kolvo_brutto']."', CENA_BRUTTO='".$_POST['cena_brutto']."' WHERE PRODUKT='".$produkt."'");
}
?>