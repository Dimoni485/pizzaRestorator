<?php 
header('Content-type: text/html; charset=windows-1251');
require_once('connect.php');
$setting_p=ibase_query("SELECT * FROM SETTING_PR");
while ($rowsetting_p=ibase_fetch_assoc($setting_p)){
	$summ_dostavka=$rowsetting_p['DOSTAVKA_SUMM'];
	$naimen=$rowsetting_p['NAME'];
	$inn_pr=$rowsetting_p['INN'];
	$adress=$rowsetting_p['ADRES'];
	$text_cek=$rowsetting_p['CEK_TEXT'];
	$telephone=$rowsetting_p['TELEPHONE'];
}
?>
<div class="rekvizitka">
<label for="naimen_rek" >Наименование предприятия: </label><input id="naimen_rek" type="text" disabled value="
<?php
if (isset($naimen)){
echo $naimen;
}
?>
"><br><br>
<label for="inn_rek">ИНН: </label><input id="inn_rek" pattern="^[ 0-9]+$" type="text" disabled value="
<?php
if (isset($naimen)){
echo $inn_pr;
}
?>"><br><br>
<label for="adres_rek">Адрес: </label><input id="adres_rek" type="text" disabled value="<?php if (isset($naimen)){echo $adress;} ?>"><br><br>
<label for="adres_rek">Телефон: </label><input id="telephone" type="text" disabled value="
<?php
if (isset($naimen)){
echo $telephone;
}
?>"><br><br>
<label for="adres_rek">Печатать в конце чека:</label><textarea class="reklama" rows="10" cols="35" disabled><?php if (isset($naimen)){echo $text_cek;} ?></textarea><br><br>
<label for="adres_rek">Сумма доставки: </label><input id="summa_dost" pattern="^[ 0-9]+$" type="text" disabled value="
<?php
if (isset($naimen)){
echo $summ_dostavka;
}
?>"><br><br>
<a href="#" class="green" onclick="javascript:saveedit();">Сохранить</a><a href="#" class="green" onclick="javascript:setedit();">Редактировать</a>
</div>
<label>Пример чека.</label><img alt="" width="25px" src="refresh.png">
<div class='cek_primer'>

<textarea rows="35" cols="35" disabled>
</textarea><br>
</div>
<a href="#" class="green" id="singh" onclick="javascript:sinhronization();">Принудительная синхронизация</a>
<div class='singinfo'></div>
<script type="text/javascript">
function setedit(){
	$('input').removeAttr("disabled");
	$('.reklama').removeAttr("disabled");
}
function saveedit(){
	/*$('input').attr("disabled","disabled");
	$('.reklama').attr("disabled","disabled");*/
	$.ajax({
		type:'POST',
		url:'savesetting.php',
		data:'naimen='+$('#naimen_rek').val()+'&inn='+$('#inn_rek').val()+'&adress='+$('#adres_rek').val()+'&reklama='+$('.reklama').val()+'&summa_dost='+$('#summa_dost').val()+'&telephone='+$('#telephone').val(),
		success:function(data) {
			loadrekvizit();
			}
	});
}
function sinhronization(){
	$('#singh').css('display','none');
	$('.singinfo').text('Идет синхронизация записей... Ждите...');
	$.ajax({
		url:'sinhronization.php',
		success:function(){
			$('#singh').css('display','block');
			$('.singinfo').text('Cинхронизация завершена');	
		}
		});
}
</script>
<?php

?>