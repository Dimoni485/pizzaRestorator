<?php
require_once ("../header.php");
require_once("../connect.php");
//$dbequery=mysqli_query($dbm,"DELETE FROM TOVAR_POSTAVSIK_TMP");
ob_start();
?>
<style type="text/css">
.form-control{
    font-size: 12px;
}
    .input-group-text{
        font-size: 12px;
    }
    .custom-select{
        font-size: 10px;
        height: 32px;
    }
</style>
<script>
    $(function() {
    $( "#datepickeradd1" ).datepicker({
    locale:'ru-ru',
    format: "yyyy-mm-dd",
    uiLibrary:'bootstrap4'
    });
    });
    </script>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" ><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Приход товара</li>
        </ol>
    </nav>
<nav class="navbar fixed-bottom bg-light bg-dark" >
    <?php $scetn=mysqli_query($dbm,"SELECT MAX(NUM_SCET) AS NUM_SCET FROM TOVAR_POSTAVSIK");
    $scetnresult=mysqli_fetch_assoc($scetn);
    ?>
    <form class="form-inline" style="margin-left: 60px">
        <input type="number" class="form-control mr-sm-2" placeholder="Номер счета" id="scet_num" value="<?php echo $scetnresult['NUM_SCET']+1; ?>">
        <button class='btn btn-success mr-sm-2' onclick="javascript:$('#windows_add').modal('show');return(false);" >Добавить</button>
        <button class='btn btn-info mr-sm-2' onclick="javascript:add_sklad('block');return(false);" >Выгрузить на склад</button>
        <input id='datepickeradd1' onchange="javascript:update_date_tov();return(false);" value="<?php echo date("Y-m-d"); ?>">
    </form>
</nav>
<table class="table table-striped table-sm" id="table_prod" style="font-size: 14px;margin-bottom: 55px;">
<thead>
<tr  id="zaga">
<th>Наименование</th><th>% утрат </th><th>Вес </th><th>Цена закупки</th><th>Чистый вес</th><th>Цена с учетом утрат</th><th>Остаток товара на складе</th><th>Поставщик</th>
</tr>
</thead>
<?php
//require_once("../connect.php");
$Q=mysqli_query($dbm,'select MIN(ID) AS ID, PRODUKT, SUM(KOLVO) AS KOLVO, ED_IZ FROM SKLAD GROUP BY PRODUKT, ED_IZ ORDER BY PRODUKT');
while ($Row=mysqli_fetch_assoc($Q)) {
	$postav_tmp=mysqli_query($dbm,"SELECT KOLVO, KOLVO_BRUTTO, CENA FROM TOVAR_POSTAVSIK_TMP WHERE PRODUKT='".$Row['PRODUKT']."'");
	$ves_tmp=0;
	$ves_netto=0;
	$cene_brutto_tmp=0;
	while ($row_postav_tmp=mysqli_fetch_assoc($postav_tmp)){
		if (isset($row_postav_tmp['KOLVO_BRUTTO'])){
		$ves_tmp=$row_postav_tmp['KOLVO_BRUTTO'];
		}
		if (isset($row_postav_tmp['KOLVO'])){
		$ves_netto=$row_postav_tmp['KOLVO'];
		}
		if (isset($row_postav_tmp['CENA'])){
			$cene_brutto_tmp=$row_postav_tmp['CENA'];
		}
	}
echo "<tr class='rowstab' id='row".$Row['ID']."'>";
echo "<td id='produkt".$Row['ID']."' class='produkt_name'>";
echo  $Row['PRODUKT'];
echo "</td>";
$postav=mysqli_query($dbm,"select CENA_BRUTTO, POSTAVSIK_NAME FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."' AND CENA_BRUTTO=(SELECT MAX(CENA_BRUTTO) FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."')");
while ($Rowp=mysqli_fetch_assoc($postav))
{
if ($Rowp['CENA_BRUTTO']!==null){
 $cena_=$Rowp['CENA_BRUTTO'];
}
 $postavsik_name=$Rowp['POSTAVSIK_NAME'];
}
echo "<td id='utrata".$Row['ID']."'>";
$utr=mysqli_query($dbm,"select KOLVO, KOLVO_BRUTTO, ED_IZ FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."' AND CENA_BRUTTO=(SELECT MAX(CENA_BRUTTO) FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."') ORDER BY ID DESC LIMIT 1");
while ($Rowu=mysqli_fetch_assoc($utr))
{
if (($Rowu['KOLVO'] > 0) and ($Rowu['KOLVO']!==null) and ($Rowu['KOLVO_BRUTTO']>0)){
$procent_utrat=100-($Rowu['KOLVO']/($Rowu['KOLVO_BRUTTO']/100));
}
}
if (isset($procent_utrat)>0){
    echo '<div class="input-group"  >';
echo "<input type='number' class='form-control' id='procent_utrat".$Row['ID']."' onclick=\"javascript:selectinp('".$Row['ID']."');return(false);\" onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' value='".Round($procent_utrat,0)."' readonly><div class=\"input-group-append\"><span class=\"input-group-text\">%</span></div>";
    echo '</div>';
}else
{
    echo '<div class="input-group">';
echo "<input type='number' class='form-control' value='' id='procent_utrat".$Row['ID']."' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' >";
    echo '</div>';
}
echo "</td>";
echo "<td>";
if ($ves_tmp > 0){
    echo '<div class="input-group">';
echo "<input type='number' class='form-control' id='ves".$Row['ID']."' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' value='".$ves_tmp."' style='background-color:yellow;'>";
   echo'<div class="input-group-append">';
echo "<span class=\"input-group-text\" id='edi_iz".$Row['ID']."' value='".$Row["ED_IZ"]."'>".$Row["ED_IZ"]."</span>";
echo "</div>";
    echo '</div>';
}else{
    echo '<div class="input-group">';
	echo "<input type='number' class='form-control' id='ves".$Row['ID']."' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' value='".$ves_tmp."' > ";
    echo'<div class="input-group-append">';
    echo "<span class=\"input-group-text\" id='edi_iz".$Row['ID']."' value='".$Row["ED_IZ"]."'>".$Row["ED_IZ"]."</span>";
    echo "</div>";
	echo '</div>';
}
echo "</td>";
echo "<td>";
if (isset($cena_)){
    echo '<div class="input-group">';
echo "<input type='number' class='form-control' id='cena".$Row['ID']."' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' value='".$cena_."' >
<div class=\"input-group-append\">
<span class=\"input-group-text\">р.</span></div>";
    echo '</div>';
}
else{
    echo '<div class="input-group">';
echo "<input type='number' class='form-control' id='cena".$Row['ID']."' value='' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' >р.";
    echo '</div>';
}
echo "</td>";
echo "<td>";
    echo '<div class="input-group">';
echo "<input type='number' class='form-control' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' id='ves_cisto".$Row['ID']."' value='".Round($ves_netto,3)."' onkeyup='javascript:viceslit_proc(\"".$Row['ID']."\");return(false);' >";
    echo'<div class="input-group-append"><span class="input-group-text">кг.</span>';

    echo '</div>';
echo '</div>';
echo "</td>";
echo "<td>";
    echo '<div class="input-group">';
echo "<input type='number' class='form-control' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' id='cena_s_utrata".$Row['ID']."' value='".Round($cene_brutto_tmp,3)."'  readonly><div class=\"input-group-append\"><span class=\"input-group-text\">р.</span></div>";
    echo '</div>';
echo "</td>";
echo "<td>";
    echo '<div class="input-group">';
echo '<input  type="number" class="form-control" value="'.number_format($Row['KOLVO'],3,'.','').'" readonly>';
    echo'<div class="input-group-append"><span class="input-group-text">'.$Row['ED_IZ'].'</span>';
    echo '</div>';
    echo '</div>';
echo "</td>";
    
echo "<td>";



echo "<select class='custom-select' id='postavka".$Row['ID']."' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);'>";
if (isset($postavsik_name) and is_string($postavsik_name)==True){
echo "<option>".$postavsik_name."</option>";
}else{
echo "<option></option>";
}
$postavsik_name=mysqli_query($dbm,"SELECT NAME FROM POSTAVSIK ORDER BY NAME");
while ($Rowpo=mysqli_fetch_assoc($postavsik_name))
{
  echo "<option>".$Rowpo['NAME']."</option>";
}

echo "</select>";
echo "</td>";

echo "</tr>"; 

}

?>
</table>
<!-- Само окно-->
<div id="windows_add" class="modal fade" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Добавление номенклатуры</h5>
            </div>
 <!-- Картинка крестика-->
			
<!-- Картинка ipad'a-->
            <div class="modal-body">
<label for="checkspisok">Выбрать из списка</label>
<select class="custom-select" id="checkspisok" onchange="javascript:spisokch()">
<?php 
$Qv=mysqli_query($dbm,'SELECT DISTINCT A.PRODUKT AS PR FROM TOVAR_POSTAVSIK A WHERE NOT EXISTS(SELECT B.PRODUKT FROM SKLAD B WHERE B.PRODUKT=A.PRODUKT) ORDER BY A.PRODUKT');
while ($Rowv=mysqli_fetch_assoc($Qv)) {
echo "<option>".$Rowv['PR']."</option>";
}
?>
</select>
<br>
<label for="selecttovar" >Наименование товара:</label>
<input id="produkt" class="form-control" name="qpr" >
<br>
Ед.измерения:
<select id="ediz" class="custom-select">
<option>кг.</option>
<option>шт.</option>
<option>л.</option>
</select>
            </div>
            <div class="modal-footer">
<button class="btn btn-success" onclick="javascript:addtovar()">Добавить</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<div onclick="add_sklad('none')" id="wrap_v"></div>
<!-- Само окно-->
<div id="window_v" class="modal fade">

</div>
<script type="text/javascript">
function spisokch(){
	$("#produkt").val($("#checkspisok").val());
}
/*$(function(){
  var $inputs = $("#window").find('input').add('focus');
  $inputs.each(function(i){
    $(this).keypress(function(ev){
      //alert([i,$inputs.length,ev.which])
      if(ev.which == 13 && i == $inputs.length -1){return true;}
      if(ev.which == 13){$inputs.eq(i+1).focus();
      $(this).select();
      return false;}
    });
  });
})*/
$(function(){
  var $inputs = $(".tableall").find('input').add('focus');
  $inputs.each(function(i){
    $(this).keypress(function(ev){
      //alert([i,$inputs.length,ev.which])
      if(ev.which == 13 && i == $inputs.length -1){return true;}
      if(ev.which == 13){
      $inputs.eq(i+1).select();
      return false;
      }
      
    });
  });

})

$(function() {
$( "#datepickeradd" ).datepicker({format: "yyyy-mm-dd", locale: "ru-ru"});
$( "#datepickeradd1" ).datepicker({format: "yyyy-mm-dd", locale:"ru-ru"});
$("input").click(function(){
	$(this).select();
})
});

$(window).scroll(function (){
var top_pos=document.body.scrollTop;
window.status = "X : " + top_pos;
zaga.style.top=top_pos;
});

function selecttovar()
{
//alert($("#selecttovar").val());
  $("#produkt").val($("#selecttovar").val());
}

function addtovar()
{
 $.ajax({
	type:'POST',
	url:'/prihod_sklad/addtovarnew.php',
	data: "produkt="+$("#produkt").val()+ "&ediz="+$("#ediz").val(),
	//success:function(data) {$('.contenttab').html(data);}
	success:function ()
	{
	 location.reload();
	}
}); 
//alert("produkt="+$("#produkt").val()+ "&ediz="+$(".ediz").val()+"&vesbrutto="+$(".vesbrutto").val()+"&cenabrutto="+$(".cenabrutto").val()+"&cenabrutto="+$(".cenabrutto").val()+"&postavsik="+$(".postavsik").val()+"$numscet="+$(".numscet").val());
//location.reload('prihod.php');
show('none');

};
function deltovar($tovarname){
  $.ajax({
	type:'POST',
	url:'/prihod_sklad/deltovar.php',
	data: 'tovarname='+$tovarname,
	success:function ()
	{
	 loadprihod(); 
	}
});
}
function addsklad()
{
$('#vig_na_sklad').css('display','none');
$('#izm_data').css('display','none');
$('#info_text').text('Подождите идет выгрузка не закрывайте страницу...');
 $.ajax({
	type:'POST',
	url:'/prihod_sklad/vigruzkanasklad.php',
	success:function ()
	{
	 $('#windows_add').modal('hide');
	 location.reload();
	}
}); 
}
function viceslitves($idprodukt)
{
$("#row"+$idprodukt).find("input").css("background-color","aqua");
$ves=$("#ves"+$idprodukt).val()*1;
$cena=$("#cena"+$idprodukt).val()*1;
//$("#ves"+$idprodukt).val($ves*1);
//$("#cena"+$idprodukt).val($cena*1);
$cisto_ves=$ves-(($ves/100)*$("#procent_utrat"+$idprodukt).val());
if ($cisto_ves==0){
$cisto_ves=$("#ves"+$idprodukt).val()*1;
}
  $("#ves_cisto"+$idprodukt).val($cisto_ves.toFixed(3));
 
$cena_s_utrata=($("#cena"+$idprodukt).val()*$("#ves"+$idprodukt).val())/$("#ves_cisto"+$idprodukt).val();
$("#cena_s_utrata"+$idprodukt).val($cena_s_utrata.toFixed(3));
savetovar($idprodukt);
if ($cisto_ves > $("#ves"+$idprodukt).val()){
$("#ves_cisto"+$idprodukt).css("background-color","red");
alert('ВНИМАНИЕ !!!! Чистый вес не может быть бельше основного, проверьте введенные данные !!!!');
}
}
function viceslit_proc($idprodukt)
{
$("#row"+$idprodukt).find("input").css("background-color","white");
$ves=$("#ves"+$idprodukt).val()*1;
$cena=$("#cena"+$idprodukt).val()*1;
$ves_netto=$("#ves_cisto"+$idprodukt).val()*1;
$cisto_ves=$("#ves_cisto"+$idprodukt).val()*1;
$cena_s_utrata=($("#cena"+$idprodukt).val()*$("#ves"+$idprodukt).val())/$("#ves_cisto"+$idprodukt).val();
$("#cena_s_utrata"+$idprodukt).val($cena_s_utrata.toFixed(3));
$proc_utrat=100-($cisto_ves/($ves/100));
$("#procent_utrat"+$idprodukt).val($proc_utrat.toFixed(0));
if ($cisto_ves > parseFloat($("#ves"+$idprodukt).val())){
$("#ves_cisto"+$idprodukt).css("background-color","red");
alert('ВНИМАНИЕ !!!! Чистый вес не может быть бельше основного, проверьте введенные данные !!!!');
}
	
savetovar($idprodukt);
}
function parseTable(){
/*var $tabl_par=$("table").find("tr");
for (var i=1; i < $tabl_par.length; i++){
var $parserrowtableall=$tabl_par[i].innerHTML;
html=$.parseHTML($parserrowtableall);
nodeNames=[];
var $arrapars="";
var $inputval="";
var $selectval="";
var $nametovar="";

$.each(html, function(z,el){
$inputval=$inputval+$('input',this).val()+",";
$selectval=$('select',this).val();
alert($(this,".produkt_name").find('input').val());
})

}*/

  }
function savetovar($idprodukt)
{
$itogo=$("#cena"+$idprodukt).val()*$("#ves"+$idprodukt).val();
$numscet=$('#scet_num').val();
if ($numscet == ''){
    $numscet =0;
}
$data_pos=$("#datepickeradd1").val();
  $.ajax({
type:'POST',
url:'/prihod_sklad/savetovartmp.php',
data:"produkt="+$('#produkt'+$idprodukt).text()+"&postavsik="+$('#postavka'+$idprodukt).val()+"&kolvo="+$("#ves_cisto"+$idprodukt).val()+"&cena="+$("#cena_s_utrata"+$idprodukt).val()+"&data_pos="+$data_pos+"&num_scet="+$numscet+"&itogo="+$itogo+"&ed_iz="+$("#edi_iz"+$idprodukt).text()+"&kolvo_brutto="+$("#ves"+$idprodukt).val()+"&cena_brutto="+$("#cena"+$idprodukt).val(),
success:function ()
{
  $("#row"+$idprodukt).find("input").css("background-color","yellow");
}
});
}
function add_sklad(state)
{

$.ajax({
type:'POST',
url:'/prihod_sklad/show_prihod.php',
success:function (html)
{
  $("#window_v").html(html);
    $("#window_v").modal('show');
}
});
}
function update_date_tov()
{
  $.ajax({
type:'POST',
url:'/prihod_sklad/update_date_tov.php',
data:"update_data_tov="+$( "#datepickeradd1" ).val(),
});
}
</script>
<!--<div id="addsklad" onclick="javascript:add_sklad('block');return(false);"><img alt="Выгрузить на склад" src="/images/list-1.png" width='50' height='50'></div>
<div id="plussklad" onclick="javascript:show('block');return(false);"><img alt="Добавить" src="/images/plus.png" width='50' height='50'></div>-->
<?php require_once ("../footer.php"); ?>