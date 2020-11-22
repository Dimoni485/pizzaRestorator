<?php require_once "../header.php";?>

<table class="table table-hover table-sm" style="font-size: 12px;font-weight: lighter;">
<tr class="zagolovok"> 
<th>Номенклатура</th><th>Продукт</th><th>ед.</th><th>Кол-во</th><th>Сумма</th><th>Дата</th><th>Удалить</th>
</tr>
<?php
require_once("../connect.php");
$Spis_compact=mysqli_query($dbm,'select DISTINCT DATE_SPIS FROM SPISANIE WHERE DATE_SPIS is not null ORDER BY DATE_SPIS');
while ($Row_spis_compact=mysqli_fetch_assoc($Spis_compact)){
echo "<tr >";
echo "<td style='background:silver;' colspan=7>";
echo 'Дата списания: '.$Row_spis_compact['DATE_SPIS'];
echo "</td>";
echo "</tr>";
$scet=0;
$Q=mysqli_query($dbm,"select * FROM SPISANIE WHERE DATE_SPIS='".$Row_spis_compact['DATE_SPIS']."' and date_spis is not null");
while ($Row=mysqli_fetch_assoc($Q)) {
$piace=explode("[",$Row['PRODUKT']);


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
	$cena_tovar=mysqli_query($dbm,"SELECT MAX(CENA) AS CENA_TOVAR FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$piace[0]."'");
while ($Row_cena_tovar=mysqli_fetch_assoc($cena_tovar)) {
echo number_format($Row_cena_tovar['CENA_TOVAR']*$Row['KOLVO'],3);
}
echo "</td>";
echo "<td>";
echo $Row['DATE_SPIS'];	
echo "</td>";
echo "<td>";
echo '<a href="#" onclick="javascript:deletespis('.$Row['ID'].');return(false);"><img src="/images/error.png" width="25px" height="25px" alt="Удалить"></a>';
echo "</td>";
echo "</tr>";
}
}
echo "<tr>";
echo "<td style='background:silver;' colspan=7>";
echo 'Без даты';
echo "</td>";
echo "</tr>";
$spis_null=mysqli_query($dbm,"select * FROM SPISANIE WHERE DATE_SPIS is null");
while ($Row_null=mysqli_fetch_assoc($spis_null)) {
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
$cena_tovar_null=mysqli_query($dbm,"SELECT MAX(CENA) AS CENA_TOVAR FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row_null['PRODUKT']."'");
while ($Row_cena_tovar_null=mysqli_fetch_assoc($cena_tovar_null)) {
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
  $.ajax({type:'POST',
      url:'deletespisanie.php',
      data:'idspis='+$idspis,
      success:function(html){
      location.reload();
          return false;
  }

  });
}
</script>
<?php require_once "../footer.php";?>