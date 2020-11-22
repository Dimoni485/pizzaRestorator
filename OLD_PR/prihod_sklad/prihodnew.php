<?php
require_once("../connect.php");
//$dbequery=ibase_query("DELETE FROM TOVAR_POSTAVSIK_TMP");
?>
<style type="text/css">
#window{
height:360px;
}
#selecttovar{
}
</style>
<div class="razdelitel">
<div style="font-size:22px;" class="panelzag">Приход товара</div>

<a class='green' onclick="javascript:show('block')" href="#">Добавить</a>
<a class='green' onclick="javascript:add_sklad('block');return(false);" href="#" >Выгрузить на склад</a><br><br>
</div><br>
<input type="text" id='datepickeradd1' onchange="javascript:update_date_tov();return(false);" value=<?php echo date("d.m.Y"); ?>>
<table class="tableall" id="table_prod">
<thead>
<tr class="zagolovok" id="zaga"> 
<th>Наименование</th><th>% утрат </th><th>Вес продукта</th><th>Цена закупки</th><th>Чистый вес продукта</th><th>Цена с учетом утрат</th><th>Остаток товара на складе</th><th>Поставщик</th>
</tr>
</thead>
<?php
//header('Content-type: text/html; charset=windows-1251');
//require_once("../connect.php");
$Q=ibase_query('select MIN(ID) AS ID, PRODUKT, SUM(KOLVO) AS KOLVO, ED_IZ FROM SKLAD GROUP BY PRODUKT, ED_IZ ORDER BY PRODUKT');
while ($Row=ibase_fetch_assoc($Q)) {
	$postav_tmp=ibase_query("SELECT KOLVO, KOLVO_BRUTTO, CENA FROM TOVAR_POSTAVSIK_TMP WHERE PRODUKT='".$Row['PRODUKT']."'");
	$ves_tmp=0;
	$ves_netto=0;
	$cene_brutto_tmp=0;
	while ($row_postav_tmp=ibase_fetch_assoc($postav_tmp)){
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
$postav=ibase_query("select CENA_BRUTTO, POSTAVSIK_NAME FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."' AND CENA_BRUTTO=(SELECT MAX(CENA_BRUTTO) FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."')");
while ($Rowp=ibase_fetch_assoc($postav))
{
if ($Rowp['CENA_BRUTTO']!==null){
 $cena_=$Rowp['CENA_BRUTTO'];
}
 $postavsik_name=$Rowp['POSTAVSIK_NAME'];
}
echo "<td id='utrata".$Row['ID']."'>";
$utr=ibase_query("select KOLVO, KOLVO_BRUTTO, ED_IZ FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."' AND CENA_BRUTTO=(SELECT MAX(CENA_BRUTTO) FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$Row['PRODUKT']."') ORDER BY ID DESC ROWS 1");
while ($Rowu=ibase_fetch_assoc($utr))
{
if (($Rowu['KOLVO'] > 0) and ($Rowu['KOLVO']!==null)){
$procent_utrat=100-($Rowu['KOLVO']/($Rowu['KOLVO_BRUTTO']/100));
}
}
if (isset($procent_utrat)>0){
echo "<input type='text' id='procent_utrat".$Row['ID']."' onclick='javascript:selectinp('".$Row['ID']."');return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' value='".Round($procent_utrat,0)."' style='width:40px;border:none;'>%";
}else
{
echo "<input type='text' value='' id='procent_utrat".$Row['ID']."' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' style='width:40px;'>";
}
echo "</td>";
echo "<td>";
if ($ves_tmp > 0){
echo "<input type='text' id='ves".$Row['ID']."' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' value='".$ves_tmp."' style='width:40px; background-color:yellow;'> <input type='text' id='edi_iz".$Row['ID']."' style='width:25px;border:0;'value='".$Row["ED_IZ"]."'>";
}else{
	echo "<input type='text' id='ves".$Row['ID']."' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' value='".$ves_tmp."' style='width:40px;'> <input type='text' id='edi_iz".$Row['ID']."' style='width:25px;border:0;'value='".$Row["ED_IZ"]."'>";
}
echo "</td>";
echo "<td>";
if (isset($cena_)){
echo "<input type='text' id='cena".$Row['ID']."' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' value='".$cena_."' style='width:40px;'>р.";
}
else{
echo "<input type='text' id='cena".$Row['ID']."' value='' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' onkeyup='javascript:viceslitves(\"".$Row['ID']."\");return(false);' style='width:55px;'>р.";
}
echo "</td>";
echo "<td>";
echo "<input type='text' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' id='ves_cisto".$Row['ID']."' value='".Round($ves_netto,3)."' onkeyup='javascript:viceslit_proc(\"".$Row['ID']."\");return(false);' style='width:40px;'>кг.";
echo "</td>";
echo "<td>";
echo "<input type='text' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);' id='cena_s_utrata".$Row['ID']."' value='".Round($cene_brutto_tmp,3)."' style='width:55px;'>р.";
echo "</td>";
echo "<td>";
echo number_format($Row['KOLVO'],3,'.','');
echo $Row['ED_IZ']."</td>";
echo "<td>";



echo "<select id='postavka".$Row['ID']."' style='width:100px;' onchange='javascript:savetovar(\"".$Row['ID']."\");return(false);'>";
if (isset($postavsik_name)){
echo "<option>".$postavsik_name."</option>";
}else{
echo "<option></option>";
}
$postavsik_name=ibase_query("SELECT NAME FROM POSTAVSIK ORDER BY NAME");
while ($Rowpo=ibase_fetch_assoc($postavsik_name))
{
  echo "<option>".$Rowpo['NAME']."</option>";
}

echo "</select>";
echo "</td>";

echo "</tr>"; 

}
//ibase_free_result ($Q);
ibase_close ($dbh);
?>
</table>
<div onclick="show('none')" id="wrap"></div>
<!-- Само окно-->
<div id="window" align='right'>
		
 <!-- Картинка крестика-->
<img class="close" onclick="show('none')" src="erase.png">
			
<!-- Картинка ipad'a--><br>
<label for="checkspisok">Выбрать из списка</label>
<select id="checkspisok" onchange="javascript:spisokch()">
<?php 
$Qv=ibase_query('SELECT DISTINCT A.PRODUKT AS PR FROM TOVAR_POSTAVSIK A WHERE NOT EXISTS(SELECT B.PRODUKT FROM SKLAD B WHERE B.PRODUKT=A.PRODUKT) ORDER BY A.PRODUKT');
while ($Rowv=ibase_fetch_assoc($Qv)) {
echo "<option>".$Rowv['PR']."</option>";
}
?>
</select>
<br>
<label for="selecttovar" >Наименование товара:</label>
<input id="produkt" class="autopost" name="qpr" >
<br>
Ед.измерения:
<select id="ediz">
<option>кг.</option>
<option>шт.</option>
<option>л.</option>
</select>
<br>
<br>	
<a class="green" href="#" onclick="javascript:addtovar()">Добавить</a> <a class="green" href="#" onclick="show('none')"> Отмена</a>
</div>
<div onclick="add_sklad('none')" id="wrap_v"></div>
<!-- Само окно-->
<div id="window_v">

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
$( "#datepickeradd" ).datepicker({dateFormat: "dd.mm.yy"});
$( "#datepickeradd1" ).datepicker({dateFormat: "dd.mm.yy"});
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
	 loadprihod(); 
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
	 loadprihod(); 
	}
}); 
}
function viceslitves($idprodukt)
{
$("#row"+$idprodukt).find("input").css("background-color","aqua");
$ves=$("#ves"+$idprodukt).val();
$cena=$("#cena"+$idprodukt).val();
$ves=$ves.replace(",",".");
$cena=$cena.replace(",",".");
$("#ves"+$idprodukt).val($ves);
$("#cena"+$idprodukt).val($cena);
$cisto_ves=$ves-(($ves/100)*$("#procent_utrat"+$idprodukt).val());
if ($cisto_ves==0){
$cisto_ves=$("#ves"+$idprodukt).val();
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
$ves=$("#ves"+$idprodukt).val();
$cena=$("#cena"+$idprodukt).val();
$ves_netto=$("#ves_cisto"+$idprodukt).val();
$ves=$ves.replace(",",".");
$cena=$cena.replace(",",".");
$ves_netto=$ves_netto.replace(",",".");
$("#ves"+$idprodukt).val($ves);
$("#cena"+$idprodukt).val($cena);
$("#ves_cisto"+$idprodukt).val($ves_netto);
$cisto_ves=$("#ves_cisto"+$idprodukt).val();
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
$numscet=1;
$data_pos=$("#datepickeradd1").val();
  $.ajax({
type:'POST',
url:'/prihod_sklad/savetovartmp.php',
data:"produkt="+$('#produkt'+$idprodukt).text()+"&postavsik="+$('#postavka'+$idprodukt).val()+"&kolvo="+$("#ves_cisto"+$idprodukt).val()+"&cena="+$("#cena_s_utrata"+$idprodukt).val()+"&data_pos="+$data_pos+"&num_scet="+$numscet+"&itogo="+$itogo+"&ed_iz="+$("#edi_iz"+$idprodukt).val()+"&kolvo_brutto="+$("#ves"+$idprodukt).val()+"&cena_brutto="+$("#cena"+$idprodukt).val(),
success:function ()
{
  $("#row"+$idprodukt).find("input").css("background-color","yellow");
}
});
}
function add_sklad(state)
{
document.getElementById('window_v').style.display = state;			
document.getElementById('wrap_v').style.display = state; 

$.ajax({
type:'POST',
url:'/prihod_sklad/show_prihod.php',
success:function (html)
{
  $("#window_v").html(html);
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
<script type="text/javascript">
/*<![CDATA[*/
fix_header.fix('table_prod');
/*]]>*/
</script>
<div id="addsklad" onclick="javascript:add_sklad('block');return(false);"><img alt="Выгрузить на склад" src="/images/list-1.png" width='50' height='50'></div>
<div id="plussklad" onclick="javascript:show('block');return(false);"><img alt="Добавить" src="/images/plus.png" width='50' height='50'></div>