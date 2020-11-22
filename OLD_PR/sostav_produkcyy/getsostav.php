
    <style type="text/css">

.panelzag{
height:80px;
}
        .inputsklad{
            display:none;
        }
        .form-control{
            font-size: 14px;
            width: 100px;
        }
        .btn{
            font-size: 14px;
        }

</style>
<?php
/*error_reporting(0);*/
$prd=$_POST['naimenprodukt'];
require_once("../connect.php");
$sos=mysqli_query($dbm,"select * FROM SOSTAV where ID_PRODUKCIYA='".$prd."' ORDER BY PRODUKT");

echo '<h2>Состав продукции: <span class="badge badge-info">'.strtoupper($prd).'</span></h2>';
echo '<h5 class="mr-sm-2">Цена продукции:<span class="badge badge-info">'.number_format($_POST['sebest'],3,'.',' ')."р.</span></h5>";
echo "<script>";
echo '$nacenka="'.$_POST['nacenka'].'";';
echo '$sebest="'.$_POST['sebest'].'";';
echo "</script>";
echo "<div class='navbar navbar-expand-lg navbar-light bg-light' role='navigation'>
<button type='button' class='btn btn-success mr-sm-2'  data-toggle=\"modal\" data-target=\"#addsostav_windows\">Добавить</button>
<button type='button' class='btn btn-default my-2 my-sm-0' onclick='javascript:zakrit();return(false);'>Закрыть</button>
</div>";

echo '<table class="table table-sm" style="font-weight: lighter; font-size: 14px;">';
echo '<tr>';
echo '<th>Наименование</th><th>Ед.</th><th>Кол-во</th><th>Сумма</th><th>Редактировать</th><th>Удалить</th>';
echo '</tr>';
while ($Row=mysqli_fetch_assoc($sos))
{



echo '<tr>';
echo '<td>';
 echo $Row['PRODUKT'];

echo '</td>';
echo '<td>';
//require_once("connect.php");
$sosis=mysqli_query($dbm,"select ED_IZ FROM SKLAD where PRODUKT='".$Row['PRODUKT']."' LIMIT 1");
while ($Rowi=mysqli_fetch_assoc($sosis)){
 echo $Rowi['ED_IZ']; 
}
echo '</td>';
echo '<td>';
echo "<span id='num".$Row['ID']."' class='spannum'>".number_format($Row['KOLVO'],3,'.',' ')."</span>
<div id='".$Row['ID']."' class='inputsklad'>
<form class='form-inline'>
<input type='text' value='' class='form-control' size='5' id='inputsk".$Row['ID']."' >
<button class='btn btn-link' onclick='javascript:savesostav(\"".$prd."\",\"".$Row['ID']."\",\"".$Row['KOLVO']."\");return(false);'>Сохранить</button>
</form>
</div>";
echo '</td>';
echo '<td>';
/*$sosi=mysqli_query($dbm,"SELECT MAX(CENA) AS CENA, ID FROM sklad WHERE PRODUKT='".$Row['PRODUKT']."' GROUP BY ID");
while ($Rowl=mysqli_fetch_assoc($sosi))
{
 echo number_format($Row['KOLVO']*$Rowl['CENA'],3,'.',' ').'p.'; 
}*/
    echo number_format($Row['SUMMA'],3,'.',' ').'p.';
    echo '</td>';
echo '<td>';
echo '<a href="#" onclick=\'javascript:editsostkolvo("'.$Row['ID'].'","'.$Row['KOLVO'].'");return(false);\'><img src="/images/pen.png" width="25px" height="25px" alt=""></a>';
echo '</td>';
echo '<td>';
 echo "<a href=# onclick=\"javascript:delsostav('".$prd."','".$Row['PRODUKT']."');return(false);\"> <img src='/images/error.png' width='25px' height='25px' alt='Удалить'> </a>"; 
echo '</td>';
echo '</tr>';

}
echo '</table>';
$Qseb=mysqli_query($dbm,"SELECT SUM(SUMMA) AS SUMMA FROM SOSTAV WHERE ID_PRODUKCIYA='".$prd."'");
while ($sebestoimost=mysqli_fetch_assoc($Qseb)){
	echo '<hr><span style="padding-left:50px;"> <b>ИТОГО: '.number_format($sebestoimost['SUMMA'],2,' р. ',' ').' коп. </b></span>';
	if (isset($sebestoimost['SUMMA'])){
	$nacenka_pr=number_format((($_POST['sebest']-$sebestoimost['SUMMA'])/$sebestoimost['SUMMA'])*100,1,'.',' ');
	}
	if (isset($nacenka_pr)){
	echo '<br><span style="padding-left:50px;"> <b>Наценка: '.$nacenka_pr.' % </b></span>';
	}else {
		echo '<br><span style="padding-left:50px;"> <b>Наценка: 0 % </b></span>';
	}
}

?>
        <div class="sostav"></div></div>
<script type="text/javascript">
/*function getsostav($idprod){
 // $.ajax({
//	type: "POST",
//	url: "getsostav.php",
//	data: "naimenprodukt="+$idprod,
//	success: function(html){
  //      $(".contenttab").html(html);
//	}
//});
}*/

function editsostkolvo($idskladprodukt,$produktkolvo)
{
$(".spannum").css('display','inline');

    $(".inputsklad").css('display','block');
$("#num"+$idskladprodukt).css('display','none');
$(".inputsklad").css('display','none');
  $("#"+$idskladprodukt).css('display','inline');
$("#inputsk"+$idskladprodukt).val($produktkolvo);
/*
  */
}
function savesostav($prd,$idsklad_produkt,$produkt_kolvo)
{
$(".spannum").css('display','inline');
$(".inputsklad").css('display','none');
$kolvosklad=$("#inputsk"+$idsklad_produkt).val();
$kolvosklad=$kolvosklad.replace(",",".");
  $.ajax({
	type: "POST",
	url: "/sostav_produkcyy/updatesostav.php",
	data: 'idsklad='+$idsklad_produkt+'&kolvosklad='+$kolvosklad,
	success: function(html){
	getsostav($prd,$nacenka,$sebest);	
	}
});

}
function zakrit()
{
location.reload();

}
function delsostav($prd,$prodsostav)
{
if (confirm("Удалить запись ?")){
 $.ajax({
	type: "POST",
	url: "/sostav_produkcyy/delsostav.php",
	data: "idprodukciya="+$prd+"&prodsostav="+$prodsostav,
	success: function(html){  
         getsostav($prd,$nacenka,$sebest);
	}
});
}
}
</script>

<!-- Само окно-->
<div class="modal fade" tabindex="-1" id="addsostav_windows" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Выбрать продукт</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
<?php
require_once("../connect.php");
$Q=mysqli_query($dbm,"SELECT PRODUKT,ED_IZ FROM SKLAD ORDER BY PRODUKT");
echo "<form><select class='custom-select' id='selectsostav'>";
while ($Row=mysqli_fetch_assoc($Q)){
echo "<option value='".htmlspecialchars($Row['PRODUKT'])."'>".htmlspecialchars($Row['PRODUKT'])."</option>";
$ediz=$Row['ED_IZ'];
}
echo "</select><br>";
echo "Коичество:";
echo "<input type='text' class='form-control' size='10' id='kolprod' value='0'>";
echo "<div class='modal-footer'><button onclick=\"javascript:addvsostav('".$prd."','".$ediz."');\" class='btn btn-success' data-dismiss=\"modal\"> Добавить</button><button onclick=\"$('#addsostav_windows').modal('hide');return(false);\" class='btn btn-danger' > Отмена</button></div><form>";
?>
            </div>
        </div>

        </div>
</div>
   <!-- <a class='btn btn-danger' href='#'  onclick='javascript:zakrit();return(false);'>Закрыть</a>-->
<script type="text/javascript">
    function show_add_sostav() {
        $('#addsostav_windows').modal();
    }

function setediz($ediza)
{ 
alert($ediza);
}
function addvsostav($idprodukt,$ediz)
{
$kolprod=$("#kolprod").val();
$kolprod=$kolprod.replace(",",".");
  $.ajax({
	type:'POST',
	url:'/sostav_produkcyy/addsostav.php',
	data:"idprodukt="+$idprodukt+"&selectsostav="+$("#selectsostav").val()+"&kolprod="+$kolprod+"&ediz="+$ediz,
	success: function(html){
        getsostav($idprodukt,$nacenka,$sebest);
        $('#addsostav_windows').modal('hide');
	}
});
}
</script>
