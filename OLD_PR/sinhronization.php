<?php
require_once('connect.php');
$sinh=ibase_query('SELECT * FROM PRODAZI_TEMP ORDER BY ID_ROWS');
while ($rows_sinh=ibase_fetch_assoc($sinh)){
$inrow=ibase_query("INSERT INTO PRODAZI(ID,PRODUKT,CENA,DATE_POK,TIME_POK,COLVO,ITOGO,KASSIR,KLIENT,SKIDKA) VALUES('".$rows_sinh['ID_CEK']."','".$rows_sinh['PRODUKT']."','".$rows_sinh['CENA']."','".$rows_sinh['DATE_POK']."','".$rows_sinh['TIME_POK']."','".$rows_sinh['COLVO']."','".$rows_sinh['ITOGO']."','".$rows_sinh['KASSIR']."','".$rows_sinh['KLIENT']."','".$rows_sinh['SKIDKA']."')");
$delrow=ibase_query("DELETE FROM PRODAZI_TEMP WHERE ID_ROWS=".$rows_sinh['ID_ROWS']."");
}
ibase_commit();

?>