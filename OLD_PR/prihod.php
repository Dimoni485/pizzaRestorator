<?php
require_once("connect.php");
ibase_query("DELETE FROM TOVAR_POSTAVSIK_TMP");
require_once("connect.php");
$zalivka=ibase_query("SELECT * FROM SKLAD ORDER BY PRODUKT ");
while ($Rowzal=ibase_fetch_assoc($zalivka)) {
require_once("connect.php");
$ist=ibase_query("INSERT INTO TOVAR_POSTAVSIK_TMP(PRODUKT) VALUES('".$Rowzal['PRODUKT']."')");
}
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
<a class='green' onclick="javascript:addsklad()" href="#">Выгрузить на склад</a><br><br>
</div>
<table class="tableall">
<tr class="zagolovok"> 
<th rowspan="2">№ счета</th><th rowspan="2">Товар</th><!--<th rowspan="2">ед. из</th>--><th colspan="2" style="background:#DEE0C8;">БРУТТО</th><th colspan="2" style="background:#E1D4D4;">НЕТТО</th><th rowspan="2">Итого</th><th rowspan="2">Поставщик</th><th rowspan="2">Дата поставки</th><th rowspan="2">Удалить</th>
</tr>
<tr class="zagolovok"> 
<th style="background:#DEE0C8;">Вес</th><th style="background:#DEE0C8;">Цена</th><!--<th style="background:#DEE0C8;">Итого</th>--><th style="background:#E1D4D4;">Вес</th><th style="background:#E1D4D4;">Цена</th>
</tr>
<?php
header('Content-type: text/html; charset=windows-1251');
//$dbh = ibase_connect ('81.20.106.127:/home/vmz/BASE.gdb', 'sysdba', 'masterkey');
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
//$Q = ibase_query ('select P.PRODUKT, P.KATEGORIYA, P.CENA, P.ID_SOSTAV from PRODUKCIYA P, SOSTAV S WHERE P.ID_SOSTAV=S.ID_PRODUKCIYA');
$Q=ibase_query('select * FROM TOVAR_POSTAVSIK_TMP');
while ($Row=ibase_fetch_assoc($Q)) {
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
echo  "<input type='text' id='".$Row['ID']."' value='".Round($Row['KOLVO_BRUTTO'],3)."'></input>".$Row['ED_IZ'];
echo "</td>";
echo "<td style='background:#DEE0C8;'>";
echo  Round($Row['CENA_BRUTTO'],3)."р.";
echo "</td>";
/*echo "<td style='background:#DEE0C8;'>";
echo  $itogo=Round($Row['CENA_BRUTTO'] * $Row['KOLVO_BRUTTO'],2)."р.";
echo "</td>";*/
echo "<td style='background:#E1D4D4;'>";
echo  Round($Row['KOLVO'],3).$Row['ED_IZ'];
echo "</td>";
echo "<td style='background:#E1D4D4;'>";
if ($Row['KOLVO'] > 0) 
{
$cena=Round(($Row['KOLVO_BRUTTO']*$Row['CENA_BRUTTO'])/$Row['KOLVO'],3)."р.";
echo  $cena; 
}else
{
$cena=0;
echo $cena."р.";
}
echo "</td>";
echo "<td >";
echo  $itogonetto=Round($Row['KOLVO']*$cena,3)."р.";
echo "</td>";
echo "<td>";
echo  $Row['POSTAVSIK_NAME'];
echo "</td>";
echo "<td>";
echo  $Row['DATA_POS'];
echo "</td>";
echo "<td>";
echo "<a onclick='javascript:deltovar(".$Row['ID'].")' href='#'><img src='erase.png' width='20px' height='20px' alt='Удалить'></a>";
echo "</td>";
echo "</tr>";
$num_scet=$Row['NUM_SCET'];
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
			
<!-- Картинка ipad'a-->
<br>№ счета:
<input onclick="javascript:$('#numscet').select();" type="text" id="numscet" value="
<?php
if (isset($num_scet)){
echo $num_scet;
}
?>
"> 
<br>
Дата поставки:
<input type="text" id='datepickeradd' value=<?php echo date("d.m.Y"); ?>><br>
<br>	
<script>
$(function ()
{
 $("#produkt").autocomplete({
		source:["111","222"]
}); 
});

</script>
<label for="selecttovar" >Наименование товара:</label>
<select id="selecttovar" onchange="javascript:selecttovar()">
<option >Выбрать из списка...</option>
<?php
require_once("connect.php");
	$Qa=ibase_query('select PRODUKT FROM SKLAD ORDER BY PRODUKT');
	while ($Row=ibase_fetch_assoc($Qa)) {
	echo "<option>".$Row['PRODUKT']."</option>";
	}
?>
</select><br>

<input id="produkt" class="autopost" name="qpr" >
<br>
Ед.измерения:
<select id="ediz">
<option>кг.</option>
<option>шт.</option>
<option>л.</option>
</select><br>
Вес брутто:
<input onclick="javascript:$('#vesbrutto').select();" type="text" id="vesbrutto" value="0" style='background:#DEE0C8;'><br>
Цена брутто:
<input onclick="javascript:$('#cenabrutto').select();" type="text" id="cenabrutto" value="0" style='background:#DEE0C8;'><br>	
Вес нетто:
<input onclick="javascript:$('#vesnetto').select();" type="text" id="vesnetto" value="0" style='background:#E1D4D4;'><br>
<label for="postavsik">Поставщик:</label>
<select id="postavsik">
<?php
//$dba = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$Qa=ibase_query('select NAME FROM POSTAVSIK ORDER BY NAME');
while ($Row=ibase_fetch_assoc($Qa)) {
echo "<option  >".$Row['NAME']."</option>";
}
?>
</select>
<br>
<br>	
<a class="green" href="#" onclick="javascript:addtovar()">Добавить</a> <a class="green" href="#" onclick="show('none')"> Отмена</a>
</div>
<script type="text/javascript">

$(function(){
  var $inputs = $("#window").find('input').add('focus');
  $inputs.each(function(i){
    $(this).keypress(function(ev){
      //alert([i,$inputs.length,ev.which])
      if(ev.which == 13 && i == $inputs.length -1){return true;}
      if(ev.which == 13){$inputs.eq(i+1).focus();return false;}
    });
  });
})

$(function() {
$( "#datepickeradd" ).datepicker({dateFormat: "dd.mm.yy"});
});
function selecttovar()
{
//alert($("#selecttovar").val());
  $("#produkt").val($("#selecttovar").val());
}

function addtovar()
{
$stringcena=$("#cenabrutto").val();
$stringvesbrut=$("#vesbrutto").val();
$stringvesnet=$("#vesnetto").val();
$stringcena=$stringcena.replace(",",".");
$stringvesbrut=$stringvesbrut.replace(",",".");
$stringvesnet=$stringvesnet.replace(",",".");
 $.ajax({
	type:'POST',
	url:'addtovar.php',
	data: "produkt="+$("#produkt").val()+ "&ediz="+$("#ediz").val()+"&vesbrutto="+$stringvesbrut+"&cenabrutto="+$stringcena+"&postavsik="+$("#postavsik").val()+"&numscet="+$("#numscet").val()+"&vesnetto="+$stringvesnet+"&dates="+$("#datepickeradd").val(),
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
	url:'deltovar.php',
	data: 'tovarname='+$tovarname,
	success:function ()
	{
	 loadprihod(); 
	}
});
}
function addsklad()
{
 $.ajax({
	type:'POST',
	url:'vigruzkanasklad.php',
	success:function ()
	{
	 loadprihod(); 
	}
}); 
}
</script>