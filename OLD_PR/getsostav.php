<style type="text/css">
.razdelitelsost{

}
#window{
height:150px;
}
.panelzag{
height:80px;
}
</style>
<?php
error_reporting(0);
header('Content-Type: text/html; charset=Windows-1251', true);
$prd=iconv('UTF-8', 'Windows-1251',$_POST['naimenprodukt']);
require_once("connect.php");
$sos=ibase_query("select * FROM SOSTAV where ID_PRODUKCIYA='".$prd."' ORDER BY PRODUKT");
echo '<center><div class=razdelitelsost><div style="font-size:22px;" class="panelzag">Состав продукции: '.$prd;
echo '<hr>Цена продукции:'.number_format($_POST['sebest'],3,'.',' ')."р. | Наценка: ".number_format($_POST['nacenka'],3,'.',' ')."</div>";
echo "<script>";
echo '$nacenka="'.$_POST['nacenka'].'";';
echo '$sebest="'.$_POST['sebest'].'";';
echo "</script>";
echo "<a class='green'  href=\"javascript:showaddsostav('block');\">Добавить</a><a class='green' href='#'  onclick='javascript:zakrit();return(false);'>Закрыть</a></div></center>";
echo '<table class="tableall">';
echo '<tr class="sostavrow">'; 
echo '<th>Наименование</th><th>Ед.</th><th>Кол-во</th><th>Сумма</th><th>Редактировать</th><th>Удалить</th>';
echo '</tr>';
while ($Row=ibase_fetch_assoc($sos))
{
echo '<tr>';
echo '<td>';
//$prd=iconv('Windows-1251', 'UTF-8',$Row['PRODUKT']);
 echo $Row['PRODUKT']; 
echo '</td>';
echo '<td>';
//require_once("connect.php");
$sosis=ibase_query("select FIRST 1 ED_IZ FROM SKLAD where PRODUKT='".$Row['PRODUKT']."'");
while ($Rowi=ibase_fetch_assoc($sosis)){
 echo $Rowi['ED_IZ']; 
}
echo '</td>';
echo '<td>';
echo "<span id='num".$Row['ID']."' class='spannum'>".number_format($Row['KOLVO'],3,'.',' ')."</span><div id='".$Row['ID']."' class='inputsklad'><input type='text' value='' class='inputsk' id='inputsk".$Row['ID']."' ></input><br><a class='savesklad' onclick='javascript:savesostav(\"".$prd."\",\"".$Row['ID']."\",\"".$Row['KOLVO']."\");return(false);' href='#'>Сохранить</a></div>";
 //echo $Row['KOLVO']; 
echo '</td>';
echo '<td>';
//$dbc = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
//require_once("connect.php");
$sosi=ibase_query("SELECT FIRST 1 CENA, ID FROM SKLAD WHERE (PRODUKT='".$Row['PRODUKT']."') AND (KOLVO > 0) ORDER BY ID");
if ($sosi <= 0 ){
	$sosi=ibase_query("SELECT FIRST 1 CENA, ID FROM SKLAD WHERE PRODUKT='".$Row['PRODUKT']."' AND ORDER BY ID DESC");
}
while ($Rowl=ibase_fetch_assoc($sosi))
{
 echo number_format($Row['KOLVO']*$Rowl['CENA'],3,'.',' ').'p.'; 
}
echo '</td>';
echo '<td>';
echo '<a href="#" onclick=\'javascript:editsostkolvo("'.$Row['ID'].'","'.$Row['KOLVO'].'");return(false);\'><img src="pen.png" width="25px" height="25px" alt=""></a>';
echo '</td>';
echo '<td>';
 echo "<a href=# onclick=\"javascript:delsostav('".$prd."','".$Row['PRODUKT']."');return(false);\"> <img src='error.png' width='25px' height='25px' alt='Удалить'> </a>"; 
echo '</td>';
echo '</tr>';

}
echo '</table>';
?>
<div class="sostav"></div>
<script type="text/javascript">
/*function getsostav($idprod){
//$prd=iconv('Windows-1251', 'UTF-8',$idprod);
  $.ajax({
	type: "POST",
	url: "getsostav.php",
	data: "naimenprodukt="+$idprod,
	success: function(html){  
        $(".contenttab").html(html);  
	}
});
}*/
function editsostkolvo($idskladprodukt,$produktkolvo)
{
$(".spannum").css('display','inline');
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
	url: "updatesostav.php",
	data: 'idsklad='+$idsklad_produkt+'&kolvosklad='+$kolvosklad,
	success: function(html){
	getsostav($prd,$nacenka,$sebest);	
	}
});

}
function zakrit()
{
$('.green').css('display','none');
document.body.style.overflow = "visible";
$('a').css('background-color','');
$('a:contains(Продукция)').css('background-color','#A2C2CE');
$.ajax({
	url:'getprodukt.php',
	success: function (data){
	  $('.contenttab').html(data);
	}
  
});

}
function delsostav($prd,$prodsostav)
{
if (confirm("Удалить запись ?")){
 $.ajax({
	type: "POST",
	url: "delsostav.php",
	data: "idprodukciya="+$prd+"&prodsostav="+$prodsostav,
	success: function(html){  
         getsostav($prd,$nacenka,$sebest);
	}
});
}
}
</script>
<div onclick="showaddsostav('none')" id="wrap"></div>
<!-- Само окно-->
<div id="window" align=right >						
<?php
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$Q=ibase_query("SELECT DISTINCT PRODUKT,ED_IZ FROM SKLAD GROUP BY PRODUKT, ED_IZ ORDER BY PRODUKT");
echo "<select id='selectsostav'>";
while ($Row=ibase_fetch_assoc($Q)){
echo "<option value='".$Row['PRODUKT']."'>".$Row['PRODUKT']."</option>";
$ediz=$Row['ED_IZ'];
}
echo "<select><br>";
echo "Коичество:";
echo "<input type='text' size='10' id='kolprod' value='0'>";
echo "<br><br><a onclick=\"javascript:addvsostav('".$prd."','".$ediz."');return(false);\" class='green' href='#'> Добавить</a><a onclick=\"showaddsostav('none');return(false);\" class='green' href='#'> Отмена</a>";
?>
</div>
<script type="text/javascript">
function showaddsostav(state){
document.getElementById('window').style.display = state;			
document.getElementById('wrap').style.display = state; 			
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
	url:'addsostav.php',
	data:"idprodukt="+$idprodukt+"&selectsostav="+$("#selectsostav").val()+"&kolprod="+$kolprod+"&ediz="+$ediz,
	success: function(){  
        getsostav($idprodukt,$nacenka,$sebest);  
	}
});
}
</script>

