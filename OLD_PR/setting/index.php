
<?php
require_once ("../header.php");
require_once('../connect.php');
$setting_p=mysqli_query($dbm,"SELECT * FROM SETTING_PR");
while ($rowsetting_p=mysqli_fetch_assoc($setting_p)){
	$summ_dostavka=$rowsetting_p['DOSTAVKA_SUMM'];
	$naimen=$rowsetting_p['NAME'];
	$inn_pr=$rowsetting_p['INN'];
	$adress=$rowsetting_p['ADRES'];
	$text_cek=$rowsetting_p['CEK_TEXT'];
	$telephone=$rowsetting_p['TELEPHONE'];
}
?>
<div class="container">
    <div class="row">
        <div class="col-6">
    <form>

<label for="naimen_rek" >Наименование предприятия: </label><input class="form-control" id="naimen_rek" type="text" disabled value="
<?php
if (isset($naimen)){
echo $naimen;
}
?>
">
<label for="inn_rek">ИНН: </label><input id="inn_rek" class="form-control" pattern="^[ 0-9]+$" type="text" disabled value="
<?php
if (isset($naimen)){
echo $inn_pr;
}
?>">
<label for="adres_rek">Адрес: </label><input id="adres_rek" class="form-control" type="text" disabled value="<?php if (isset($naimen)){echo $adress;} ?>">
<label for="adres_rek">Телефон: </label><input id="telephone" class="form-control" type="tel" disabled value="
<?php
if (isset($naimen)){
echo $telephone;
}
            ?>">

    </form>
    </div>
        <div class="col-6">
    <form>

<label for="adres_rek">Печатать в конце чека:</label><textarea id="reklama" class="form-control" rows="10" cols="35" disabled><?php if (isset($naimen)){echo $text_cek;} ?></textarea>
<label for="adres_rek">Сумма доставки: </label><input id="summa_dost" class="form-control" pattern="^[ 0-9]+$" type="text" disabled value="
<?php
if (isset($naimen)){
echo $summ_dostavka;
}
?>">
    </form>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12 text-center">
<a href="#" class="btn btn-success" onclick="javascript:saveedit();">Сохранить</a>
    <a href="#" class="btn btn-secondary" onclick="javascript:setedit();">Редактировать</a>
</div>
</div>
<br>
<!--<div class='col-6'>
<label>Пример чека.</label>


<textarea class="form-control" rows="15" cols="35" disabled>
</textarea>
</div>-->
<!-- <a href="#" class="green" id="singh" onclick="javascript:sinhronization();">Принудительная синхронизация</a>-->
<!--<a href="#" class="btn btn-primary" id="singh" onclick="javascript:rascetvsego();">Перерасчет всего...</a>-->


<div class="input-group">
<a href="#" class="btn btn-primary" id="singh" onclick="javascript:deletvsego();return(true);">Удалить данные за </a>
<select id="data_pok" class="custom-select">
<?php 
$date_prod=mysqli_query($dbm,"SELECT DATE_POK FROM PRODAZI GROUP BY DATE_POK");
while ($rowdateprod=mysqli_fetch_assoc($date_prod)){
	echo "<option>".$rowdateprod['DATE_POK']."</option>";
}
?>
</select>
<span>Год.</span>
</div>
<br>
<div class='singinfo'></div>
<script type="text/javascript">
function setedit(){
	$('input').removeAttr("disabled");
	$('#reklama').removeAttr("disabled");
}
function saveedit(){
	/*$('input').attr("disabled","disabled");
	$('.reklama').attr("disabled","disabled");*/
    $('.singinfo').text('Сохранение данных... Ждите...');
	$.ajax({
		type:'POST',
		url:'/setting/savesetting.php',
		data:'naimen='+$('#naimen_rek').val()+'&inn='+$('#inn_rek').val()+'&adress='+$('#adres_rek').val()+'&reklama='+$('#reklama').val()+'&summa_dost='+$('#summa_dost').val()+'&telephone='+$('#telephone').val(),
		success:function(data) {
			location.reload();
			return false;
			}
	});
}
function sinhronization(){
	$('#singh').css('display','none');
	$('.singinfo').text('Идет синхронизация записей... Ждите...');
	$.ajax({
		url:'/analitika/sinhronization.php',
		success:function(){
			$('#singh').css('display','block');
			$('.singinfo').text('Cинхронизация завершена');	
		}
		});
}
function rascetvsego(){
	$('#singh').css('display','none');
	$('.singinfo').text('Идет расчет... Ждите...');
	$.ajax({
		url:'/setting/update.php',
		success:function(){
			$('#singh').css('display','block');
			$('.singinfo').text('Расчет завершен');	
		}
		});
}
function deletvsego(){
	$('#singh').css('display','none');
	$('.singinfo').text('Идет удаление... Ждите...');
	$.ajax({
	type:'POST',
		url:'/setting/delete.php',
		data: 'data_pok='+$('#data_pok').val(),
		success:function(){
			$('#singh').css('display','block');
			$('.singinfo').text('Удаление завершено');	
			location.reload();
			return false;
		}
		});
}
</script>
<?php
require_once ("../footer.php");
?>