<div class="razdelitel"><a href="#" onclick="loadsklad();return(false);" class="reload_button" id="obnovit" title="Обновить"></a></div>
<table class="tableall">
<tr class="zagolovok"> 
<th>Продукт</th><th>ед.</th><th>Кол-во</th><th>Цена</th><th>Сумма</th><th>Коррект-<br>ировка</th><th>Спис-<br>ание</th><th>Удалить</th>
</tr>
<?php
//header('Content-type: text/html; charset=windows-1251');
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("../connect.php");
$Q=ibase_query('select * FROM SKLAD ORDER BY PRODUKT');
while ($Row=ibase_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>";
echo $Row['PRODUKT'];	
echo "</td>";
echo "<td>";
echo $Row['ED_IZ'];	
echo "</td>";
echo "<td>";
echo "<span id='num".$Row['ID']."' class='spannum'>".number_format($Row['KOLVO'],3,"."," ")."</span><div id='".$Row['ID']."' class='inputsklad'><input type='text' value='' class='inputsk' id='inputsk".$Row['ID']."' ></input><br><a class='savesklad' onclick='javascript:savesklad(\"".$Row['ID']."\",\"".$Row['KOLVO']."\"); return false;' href='#'>Сохранить</a></div>";	
echo "</td>";
echo "<td>";
echo number_format($Row['CENA'],3,"."," ")."р.";
echo "</td>";
/*require_once("connect.php");
$tp=ibase_query("SELECT FIRST 1 CENA AS CENABRUTTO, PRODUKT FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."' AND OSTATOK > 0 ORDER BY DATA_POS");
while ($Rowtp=ibase_fetch_assoc($tp))
{
  echo number_format($Rowtp['CENABRUTTO'],3,"."," ")."р.";
  echo "</td>";
  echo "<td>";
  echo number_format($Row['KOLVO']*$Rowtp['CENABRUTTO'],3,"."," ")."р.";
}*/
echo "<td>";
echo number_format($Row['SUMMA'],3,"."," ")."р.";
echo "</td>";
echo "<td>";
echo "<a onclick='javascript:korrektsklad(\"".$Row['ID']."\",\"".$Row['KOLVO']."\");return(false);' href='#'><img src='/images/pen.png' width='25px' height='25px' alt='Удалить'></a>";	
echo "</td>";
echo "<td>";
echo "<a onclick='javascript:spisanie(\"".$Row['ID']."\",\"".$Row['PRODUKT']."\",\"".$Row['ED_IZ']."\");return false;' href='#'><img src='/images/garbage.png' width='25px' height='25px' alt='Списание'></a>";	
echo "</td>";
echo "<td>";
echo "<a href='#' onclick='javascript:delsklad(\"".$Row['ID']."\");return(false);' ><img src='/images/error.png' width='25px' height='25px' alt='Удалить'></a>";	
echo "</td>";

echo "</tr>";
}
?>
</table>
<div id="wrap">
<div class="spisaniediv">

</div>
</div>
<script type="text/javascript">
function spisanie($idprodukt,$naimenprodukt,$ediz)
{
$(".spisaniediv").html("<div class='razdelitel'>Списание со склада продукции: "+$naimenprodukt+"</div><br><input type='text' id='spisanieinput'>кг.<br><a href='#' onclick='spisatsklad(\""+$idprodukt+"\",\""+$naimenprodukt+"\",\""+$ediz+"\");return(false);' class='green'>Списать</a><a href='#' onclick='$(\".spisaniediv\").hide();$(\"#wrap\").hide();return(false);' class='green'>Закрыть</a>");
  $(".spisaniediv").show();
$("#wrap").show();
}
function spisatsklad($idprodukt,$naimenprodukt,$ediz)
{
$spisanieinput=$("#spisanieinput").val();
$spisanieinput=$spisanieinput.replace(",",".");
  $.ajax({
	type: 'POST',
	url: '/sklad/spisaniesklad.php',
	data: 'idsklad='+$idprodukt+'&kolvospisan='+$spisanieinput+'&naimenprodukt='+$naimenprodukt+'&ediz='+$ediz,
	success: function ()
	{
	  loadsklad();
	}
});
}
function korrektsklad($idskladprodukt,$produktkolvo)
{
//alert($idskladprodukt);
$(".spannum").css('display','inline');
$("#num"+$idskladprodukt).css('display','none');
$(".inputsklad").css('display','none');
  $("#"+$idskladprodukt).css('display','inline');
$("#inputsk"+$idskladprodukt).val($produktkolvo);
}
function savesklad($idsklad_produkt,$produkt_kolvo)
{
$(".spannum").css('display','inline');
$(".inputsklad").css('display','none');
$kolvosklad=$("#inputsk"+$idsklad_produkt).val();
$kolvosklad=$kolvosklad.replace(",",".");
$.ajax({
	type:'POST',
	url:'/sklad/updatesklad.php',
	data:'idsklad='+$idsklad_produkt+'&kolvosklad='+$kolvosklad,
	success:function(){
	//$("#num"+$idsklad_produkt).html(data);
	loadsklad();
}
	});
}
function delsklad($idpr)
{
  if (confirm("Удалить запись ?")){
$.ajax({
type:'POST',
url:'/sklad/delsklad.php',
data:"idpr="+$idpr,
success:function(html)
{
  loadsklad();
}
});
}
}
$(function(){
$('.spannum').each(function(){
var x=$(this).text();
if (x <= 0.5){$(this).css('color','red');};
if (x > 0.5 && x<=1.5){$(this).css('color','#EF6515');};
})
});
</script>