<?php
require_once "../header.php";
?>
<style>
    .inputsklad{
        display:none;
    }
</style>
    <nav  aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" ><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Склад</li>
        </ol>
    </nav>
<div class="navbar"><button onclick="location.reload();return(false);" class="btn btn-info" id="obnovit" title="Обновить">Обновить</button></div>
<table class="table table-hover table-sm" style="font-size: 12px">
<tr class="zagolovok"> 
<th>Продукт</th><th>ед.</th><th>Кол-во</th><th>Цена</th><th>Сумма</th><th>Коррект-<br>ировка</th><th>Спис-<br>ание</th><th>Удалить</th>
</tr>
<?php
require_once("../connect.php");
$Q=mysqli_query($dbm,'select * FROM SKLAD ORDER BY PRODUKT');
while ($Row=mysqli_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>";
echo $Row['PRODUKT'];	
echo "</td>";
echo "<td>";
echo $Row['ED_IZ'];	
echo "</td>";
echo "<td>";
echo "<span id='num".$Row['ID']."' class='spannum'>".number_format($Row['KOLVO'],3,"."," ")."</span>
<div id='".$Row['ID']."' class='inputsklad'>
<form class='form-inline'>
<input type='text' value='' class='form-control form-control-sm' id='inputsk".$Row['ID']."' ></input>
<button class='btn btn-link' onclick='javascript:savesklad(\"".$Row['ID']."\",\"".$Row['KOLVO']."\"); return false;'>Сохранить</button>
</form>
</div>";
echo "</td>";
echo "<td>";
echo number_format($Row['CENA'],3,"."," ")."р.";
echo "</td>";
/*require_once("connect.php");
$tp=mysqli_query($dbm,"SELECT FIRST 1 CENA AS CENABRUTTO, PRODUKT FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."' AND OSTATOK > 0 ORDER BY DATA_POS");
while ($Rowtp=mysqli_fetch_assoc($tp))
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

<div  class="modal fade" id="modal_spisanie">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="spis_title"></div>
            </div>
            <div class="modal-body" id="spisaniediv">
                <input type='text' class='form-control' id='spisanieinput'>кг.

            </div>
            <div class="modal-footer" id="footer_spis">

            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
function spisanie($idprodukt,$naimenprodukt,$ediz)
{
    $("#spis_title").html("Списание продукции: " + $naimenprodukt);
    $("#footer_spis").html("<a href='#' onclick='spisatsklad(\""+$idprodukt+"\",\""+$naimenprodukt+"\",\""+$ediz+"\");' class='btn btn-success'>Списать</a> <a href='#' data-dismiss='modal'  class='btn btn-secondary'>Закрыть</a>");
    $
  $("#modal_spisanie").modal('show');
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
	  location.reload();
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
	location.reload();
	return false;
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
  location.reload();
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
<?php
require_once "../footer.php";
?>