<div class="razdelitel"></div>
<table class="tableall">
<tr class="zagolovok"> 
<th>Продукция</th><th>Продукт</th><th>ед.</th><th>Кол-во</th><th>Сумма</th><th>Дата</th><th>Удалить</th>
</tr>
<?php
//header('Content-type: text/html; charset=windows-1251');
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("../connect.php");
$Spis_compact=ibase_query('select DISTINCT DATE_SPIS FROM SPISANIE WHERE DATE_SPIS is not null ORDER BY DATE_SPIS');
while ($Row_spis_compact=ibase_fetch_assoc($Spis_compact)){
echo "<tr >";
echo "<td style='background:silver;' colspan=7>";
echo 'Дата списания: '.$Row_spis_compact['DATE_SPIS'];
echo "</td>";
echo "</tr>";
$scet=0;
$Q=ibase_query("select * FROM SPISANIE WHERE DATE_SPIS='".$Row_spis_compact['DATE_SPIS']."' and date_spis is not null");
while ($Row=ibase_fetch_assoc($Q)) {
$piace=explode("[",$Row['PRODUKT']);

/*if ($scet==0){
if (isset($piace[1])){
echo $piace[1];
$piace_st=$piace[1];
}else{
echo $piace[0];
$piace_st='';
}
}
if ($piace_st==$piace[0]){
$scet=1;
}else{
$scet=0;
}*/

echo "<tr>";
echo "<td>";
 	if (isset($piace[1])){
echo $piace[1];
}
echo "</td>";
echo "<td>";
 	echo $piace[0];
echo "</td>";
echo "<td>";
echo $Row['ED_IZ'];	
echo "</td>";
echo "<td>";
echo Round($Row['KOLVO'],3);	
echo "</td>";
echo "<td>";
	$cena_tovar=ibase_query("SELECT MAX(CENA) AS CENA_TOVAR FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$piace[0]."'");
while ($Row_cena_tovar=ibase_fetch_assoc($cena_tovar)) {
echo number_format($Row_cena_tovar['CENA_TOVAR']*$Row['KOLVO'],3);
}
echo "</td>";
echo "<td>";
echo $Row['DATE_SPIS'];	
echo "</td>";
echo "<td>";
echo '<a href="#" onclick="javascript:deletespis('.$Row['ID'].');return(false);"><img src="error.png" width="25px" height="25px" alt="Удалить"></a>';
echo "</td>";
echo "</tr>";
}
}
echo "<tr>";
echo "<td style='background:silver;' colspan=7>";
echo 'Без даты';
echo "</td>";
echo "</tr>";
$spis_null=ibase_query("select * FROM SPISANIE WHERE DATE_SPIS is null");
while ($Row_null=ibase_fetch_assoc($spis_null)) {
echo "<tr>";
echo "<td>";
echo $Row_null['PRODUKT'];	
echo "</td>";
echo "<td>";
echo $Row_null['ED_IZ'];	
echo "</td>";
echo "<td>";
echo Round($Row_null['KOLVO'],3);	
echo "</td>";
echo "<td>";
$cena_tovar_null=ibase_query("SELECT MAX(CENA) AS CENA_TOVAR FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row_null['PRODUKT']."'");
while ($Row_cena_tovar_null=ibase_fetch_assoc($cena_tovar_null)) {
echo $Row_cena_tovar_null['CENA_TOVAR'];
}
echo "</td>";
echo "<td>";
echo $Row_null['DATE_SPIS'];	
echo "</td>";
echo "<td>";
echo '<a href="#" onclick="javascript:deletespis('.$Row_null['ID'].');return(false);"><img src="error.png" width="25px" height="25px" alt="Удалить"></a>';
echo "</td>";
echo "</tr>";
}
?>
</table>
<script type="text/javascript">
function deletespis($idspis)
{
  $.ajax({type:'POST',url:'deletespisanie.php',data:'idspis='+$idspis,success:function(html){loadspisanie();}});
}
</script>