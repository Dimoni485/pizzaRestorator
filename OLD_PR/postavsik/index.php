<?php require_once "../header.php";?>
<div class="navbar">
    <div class="navbar-header"><?php if(isset($_GET['fprod'])){echo $_GET['fprod'];}; ?></div>

    <form class="form-inline">

<select class="custom-select custom-select-sm" id="produkt-sklad-postavsik">
    <option value="...">Показать все</option>
<?php
require_once("../connect.php");
$Qv=mysqli_query($dbm,'select DISTINCT PRODUKT FROM SKLAD ORDER BY PRODUKT');
while ($Rowv=mysqli_fetch_assoc($Qv)) {
echo "<option>".$Rowv['PRODUKT']."</option>";
}
?>
</select>
        <button type="button" id="filter_b" class="btn btn-success btn-sm">Фильтр</button>

</form>
</div>
<table class="table table-hover table-sm" style="font-size: 12px;">
    <thead>
<tr>
<th rowspan="2">№ счета</th><th rowspan="2">Товар</th><!--<th rowspan="2">ед. из</th>--><th colspan="2" style="background:#DEE0C8;">БРУТТО</th><th colspan="2" style="background:#E1D4D4;">НЕТТО</th><th rowspan="2">Итого</th><th rowspan="2">Поставщик</th><th rowspan="2">Дата поставки</th><th rowspan="2">Удалить</th>
</tr>
<tr>
<th style="background:#DEE0C8;">Вес</th><th style="background:#DEE0C8;">Цена</th><!--<th style="background:#DEE0C8;">Итого</th>--><th style="background:#E1D4D4;">Вес</th><th style="background:#E1D4D4;">Цена</th>
</tr>
    </thead>
<?php
if (isset($_GET['fprod'])){
    $produkt_filter=$_GET['fprod'];
}else {
    $produkt_filter ='';
}
require_once("../connect.php");
$produkt_data=mysqli_query($dbm,"select DATA_POS, NUM_SCET, SUM(ITOGO) AS ITOGO FROM TOVAR_POSTAVSIK WHERE PRODUKT LIKE '%".$produkt_filter."%' GROUP BY NUM_SCET, DATA_POS ORDER BY DATA_POS DESC");
while ($Row_produkt_date=mysqli_fetch_assoc($produkt_data)){
echo "<tr>";
echo "<td colspan=10 style='background:#DEE0EF;font-weight: bold';>";
echo "Номер счета: ".$Row_produkt_date['NUM_SCET']." Дата поставки: ".date('d.m.Y', strtotime($Row_produkt_date['DATA_POS']))." г. Итого: ".$Row_produkt_date['ITOGO']." р.";
echo "</td>";
echo "</tr>";

$Q=mysqli_query($dbm,"select * FROM TOVAR_POSTAVSIK WHERE DATA_POS='".$Row_produkt_date['DATA_POS']."' AND NUM_SCET='".$Row_produkt_date['NUM_SCET']."' AND PRODUKT LIKE '%".$produkt_filter."%' ORDER BY PRODUKT ");
$alfo=0;
$prodrow=0;
while ($Row=mysqli_fetch_assoc($Q)) {
if ($Row['PRODUKT']{0}==$prodrow)
{
  $alfo=$alfo+1;
}else
{
$alfo=1;
/*echo "<tr class='alfavit'>";
echo "<td colspan=10 align='left'>";
echo $Row['PRODUKT']{0};
echo "</td>";
echo "</tr>";*/
}
$prodrow=$Row['PRODUKT']{0};

echo "<tr class='rowstab'>";
echo "<td>";

echo  $Row['NUM_SCET'];
echo "</td>";
echo "<td>";
echo  $Row['PRODUKT'];
echo "</td>";
//echo "<td>";
//echo  $Row['ED_IZ'];
//echo "</td>";
echo "<td style='background:#DEE0C8;'>";
if ($Row['KOLVO_BRUTTO'] <> 0 ) {
    echo Round($Row['KOLVO_BRUTTO'], 3) . $Row['ED_IZ'];
}
echo "</td>";
echo "<td style='background:#DEE0C8;'>";
    if ($Row['CENA_BRUTTO'] <> 0 ) {
        echo Round($Row['CENA_BRUTTO'], 3) . "р.";
    }
echo "</td>";
/*echo "<td style='background:#DEE0C8;'>";
echo  $itogo=Round($Row['CENA_BRUTTO'] * $Row['KOLVO_BRUTTO'],2)."р.";
echo "</td>";*/
echo "<td style='background:#E1D4D4;'>";
    if ($Row['KOLVO'] <> 0 ) {
        echo Round($Row['KOLVO'], 3) . $Row['ED_IZ'];
    }
echo "</td>";
echo "<td style='background:#E1D4D4;'>";
if (($Row['KOLVO']!==null) and ($Row['KOLVO_BRUTTO'] <> 0) and ($Row['CENA_BRUTTO'] <> 0))
{
$cena=($Row['KOLVO_BRUTTO']*$Row['CENA_BRUTTO'])/$Row['KOLVO'];
echo  Round($cena,3)."р.";
}
echo "</td>";
echo "<td>";
if ($Row['KOLVO'] !==null) {
    if ($cena > 0) {
        $itogonetto = $Row['KOLVO'] * $cena;
        echo  Round($itogonetto,3)."р.";
    }
}
echo "</td>";
echo "<td>";
echo  $Row['POSTAVSIK_NAME'];
echo "</td>";
echo "<td>";

echo date('d.m.Y', strtotime($Row['DATA_POS']));
echo "</td>";
echo "<td>";
echo "<a onclick='javascript:deltovarp(".$Row['ID'].");return(false);' href='#'><img src='/images/error.png' width='25px' height='25px' alt='Удалить'></a>";
echo "</td>";
echo "</tr>";
}
}

?>
</table>
<script>
/*$("#produkt-sklad-postavsik").chosen();*/
$("#filter_b").click(function ()
{

    $prod_set=$("#produkt-sklad-postavsik").val();
    if ($prod_set=='...'){
        $(location).attr('href','/postavsik/'  );
    }else {
        $(location).attr('href', '/postavsik/index.php?fprod=' + $prod_set);
    }

}
);
function deltovarp($tovarname){
if (confirm("Удалить запись ?")){
  $.ajax({
	type:'POST',
	url:'/postavsik/deltovarp.php',
	data: 'tovarname='+$tovarname,
	success:function ()
	{
	 location.reload();
	}
});
}
}
</script>
<?php require_once "../footer.php";?>