<style type="text/css">
.razdelitel{
height:50px;
}
</style>
<div class="razdelitel">
<a href="#" onclick="addkat();" class="green">Добавить</a>
</div>
<table class="tableall">
<tr class="zagolovok"> 
<th>Категории</th><th>Удалить</th>
</tr>
<?php
header('Content-type: text/html; charset=windows-1251');
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("connect.php");
$Q=ibase_query('select * FROM KATEGORII ORDER BY KAT');
while ($Row=ibase_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>";
echo $Row['KAT'];	
echo "</td>";
echo "<td>";
echo "<a href='#'><img src='error.png' width='25px' height='25px' alt='Удалить'></a>";	
echo "</td>";
echo "</tr>";
}
?>
</table>
<div id="wrap">
<div class="addkat">
<div class="razdelitel">Добавление категории</div>
<br>
<input type="text" id=addkattext>
<br>
<a href="#" onclick="savekat();" class='green'>Добавить</a><a href="#" class='green' onclick="$('.addkat').hide();$('#wrap').hide();">Закрыть</a>
</div>
</div>
<script type="text/javascript">
function addkat()
{
$(".addkat").show();
$("#wrap").show();
  /*$.ajax({
type:'POST',
url:'addkat.php',
data:'kat='+;

});*/
}
function savekat()
{
  $.ajax({
type:'POST',
url:'addkat.php',
data:'kat='+$("#addkattext").val(),
success:function(){
loadkat();
}
});
}
</script>