<?php
require_once "../header.php";
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
<button class="btn btn-success" onclick="$('#window_skidka').modal('show');" id="">Добавить</button>
</div>

<table class="table table-hover table-sm" style="font-size: 14px;">
<thead>
    <tr>
<th>Наименование</th><th>Сумма наступления скидки</th><th>Процент скидки</th><th>Разрешение</th><th>Удалить</th>
</tr>
</thead>
<?php
require_once('../connect.php');
$Q=mysqli_query($dbm,'select * FROM PROGRAMMALOYAL ORDER BY USLOVNAKOP');
$maxprocent=0;
while ($Row=mysqli_fetch_assoc($Q)) {
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
		<img src='../images/error.png' width='25px' height='25px' alt='Удалить'>
		</a>
	</td>";
echo "</tr>";
}
?>
</table>

<!-- Само окно-->
<div id="window_skidka" class="modal fade" >
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <div class="modal-title">
Добавить скидку
        </div>
    </div>
    <div class="modal-body">
<form>
    Наименование:<input type="text" class="form-control" value="" id="nameskidka">
Сумма наступления скидки:<input type="text" class="form-control" value="" id="sumskidka">
Процент скидки:<input type="text" class="form-control" value="" id="procentskidka">
Разрешение: <select class="custom-select" id="yesskidka">
<option value='1'>Разрешено</option>
<option value='2'>Отключить</option>
</select>
</form>
    </div>
    <div class="modal-footer">
<button class="btn btn-success" onclick="javascript:addskidka()">Добавить</button>
<button class="btn btn-default" onclick="$('#window_skidka').modal('hide');">Отмена</button>
    </div>
    </div>
    </div>
</div>

<script type="text/javascript">
function addskidka()
{
 $.ajax({
type:'POST',
url:'/skidki/addskidka.php',
data:"nameskidka="+$('#nameskidka').val()+"&sumskidka="+$('#sumskidka').val()+"&procentskidka="+$('#procentskidka').val()+"&yesskidka="+$('#yesskidka').val(),
success:function ()
{
    location.reload();
    return false;
}
});
}
function deleteskidka($idskidka)
{
  $.ajax({
type:'POST',
url:'/skidki/deleteskidka.php',
data:"idskidka="+$idskidka,
success:function ()
{
  location.reload();
  return false;
}
});
}
</script>
<?php require_once "../footer.php"; ?>