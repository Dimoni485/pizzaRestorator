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
<button class="btn btn-success" onclick="$('#window_skidka').modal('show');" >Добавить</button>
</div>
<table class="table table-hover table-sm" style="font-size: 14px;">
<thead>
    <tr>
<th>ФИО</th><th>Скидка %</th><th>Телефон</th><th>Адрес</th><th></th>
</tr>
</thead>
<?php
require_once('../connect.php');
$Q=mysqli_query($dbm,'select * FROM KLIENT ORDER BY FIO');
$maxprocent=0;
while ($Row=mysqli_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>".$Row['FIO']."</td>";
echo "<td>".$Row['SKIDKA']."%</td>";
echo "<td>".$Row['TELEPHONE']."</td>";
echo "<td>".$Row['ADRES']."</td>";
echo "<td><a href='#' onclick='deleteskidka_user(\"".$Row['ID']."\")'><img src='/images/error.png' width='25px' height='25px' alt='Удалить'></a></td>";
echo "</tr>";
}
?>
</table>

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
ФИО:<input class="form-control" type="text" value="" id="fio">

Скидка %:<input type="number" class="form-control" value="" id="skidka">
Телефон:<input type="text" class="form-control" value="" id="telefon">
Адрес: <input type="text"class="form-control" value="" id="adress">
    </form>
</div>
         <div class="modal-footer">
<button class="btn btn-success" onclick="javascript:addskidka_user()">Добавить</button>
<button class="btn btn-default" onclick="$('#window_skidka').modal('hide');">Отмена</button>
         </div>
     </div>
 </div>
</div>

<script type="text/javascript">
function addskidka_user()
{
 $.ajax({
type:'POST',
url:'/skidki/addskidka_user.php',
data:"fio="+$('#fio').val()+"&skidka="+$('#skidka').val()+"&telefon="+$('#telefon').val()+"&adress="+$('#adress').val(),
success:function ()
{
  location.reload();
  return false;
}
});
}
function deleteskidka_user($idskidka)
{
  $.ajax({
type:'POST',
url:'/skidki/deleteskidka_user.php',
data:"idskidka="+$idskidka,
success:function ()
{
    location.reload();
    return false;
}
});
}
</script>
<?php
require_once "../footer.php";
?>