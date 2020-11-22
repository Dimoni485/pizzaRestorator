<style type="text/css">
.razdelitel{
height:50px;
}
</style>
<div class="razdelitel">
<a href="#" class="green" onclick="javascript:show('block')">Добавить</a>
</div>

<table class="tableall">
<tr class="zagolovok"> 
<th>Наименование</th><th>Контакты</th>
</tr>
<?php
header('Content-type: text/html; charset=windows-1251');
require_once("connect.php");
$Q=ibase_query('select * FROM POSTAVSIK');
while ($Row=ibase_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>";
echo $Row['NAME'];	
echo "</td>";
echo "<td>";
echo $Row['CONTAKT'];	
echo "</td>";
echo "</tr>";
}
?>
</table>
<style type="text/css">
#window{
height:200px;
}
</style>

<div onclick="show('none')" id="wrap"></div>

<!-- Само окно-->
<div id="window" align='right'>		
 <!-- Картинка крестика-->
<img class="close" onclick="show('none')" src="erase.png">
<br><br>
Добавить поставщика
<hr>
<label for="postavsik">Поставщик:<input type="text" value="" id="postavsik"></label><br>

<label for="kontakt">Контакты:<input type="text" value="" id="kontakt"></label><br>
<a href="#" class="green" onclick="javascript:addpostavsik()">Добавить</a>
<a href="#" class="green" onclick="show('none')">Отмена</a>

</div>

<script type="text/javascript">
function addpostavsik()
{
  $.ajax({
type:'POST',
url:'addpostavsik.php',
data:"postavsik="+$('#postavsik').val()+"&kontakt="+$('#kontakt').val(),
success:function ()
{
  loadpostavsik();
}
});
}
</script>