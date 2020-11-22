<?php
header('Content-type: text/html; charset=windows-1251');
?>
<style type="text/css">
.razdelitel{
height:80px;

}
</style>
<style type="text/css">
#window{
height:400px;
}
</style>

<div class="razdelitel">
<a href="#" class="green" onclick="show('block')" id="">Добавить</a>
</div>

<table class="tableall">
<tr class="zagolovok"> 
<th>Наименование</th><th>Сумма наступления скидки</th><th>Процент скидки</th><th>Разрешение</th><th>Удалить</th>
</tr>

<?php
require_once('connect.php');
$Q=ibase_query('select * FROM PROGRAMMALOYAL ORDER BY USLOVNAKOP');
$maxprocent=0;
while ($Row=ibase_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>".$Row['NAIMEN']."</td>";
echo "<td>".$Row['USLOVNAKOP']."р.</td>";
echo "<td>".$Row['PROCENT']."%</td>";
if ($Row['MAXPROCENT']==1){
echo "<td>Разрешено</td>";
}else{
echo "<td>Отключена</td>";
}
echo "<td>
		<a href='#' onclick='javascript:deleteskidka(\"".$Row['ID']."\");'>
		<img src='error.png' width='25px' height='25px' alt='Удалить'>
		</a>
	</td>";
echo "</tr>";
}
?>
</table>

<div onclick="show('none')" id="wrap"></div>

<!-- Само окно-->
<div id="window" align='right'>		
 <!-- Картинка крестика-->
<img class="close" onclick="show('none')" src="erase.png">
<br><br>
Добавить скидку
<hr>
<label for="nameskidka">Наименование:<input type="text" value="" id="nameskidka"></label><br>

<label for="sumskidka">Сумма наступления скидки:<input type="text" value="" id="sumskidka"></label><br>
<label for="procentskidka">Процент скидки:<input type="text" value="" id="procentskidka"></label><br>
<label for="yesskidka">Разрешение<select id="yesskidka">
<option value='1'>Разрешено</option>
<option value='2'>Отключить</option>
</select>
</label><br>
<a href="#" class="green" onclick="javascript:addskidka()">Добавить</a>
<a href="#" class="green" onclick="show('none')">Отмена</a>

</div>

<script type="text/javascript">
function addskidka()
{
 $.ajax({
type:'POST',
url:'addskidka.php',
data:"nameskidka="+$('#nameskidka').val()+"&sumskidka="+$('#sumskidka').val()+"&procentskidka="+$('#procentskidka').val()+"&yesskidka="+$('#yesskidka').val(),
success:function ()
{
  loadskidka();
}
});
}
function deleteskidka($idskidka)
{
  $.ajax({
type:'POST',
url:'deleteskidka.php',
data:"idskidka="+$idskidka,
success:function ()
{
  loadskidka();
}
});
}
</script>