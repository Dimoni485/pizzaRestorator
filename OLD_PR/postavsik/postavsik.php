<?php require_once "../header.php"; ?>
<style type="text/css">
.razdelitel{
height:50px;
}
</style>
<div class="navbar navbar-default">
<a href="#" class="btn btn-success" onclick="javascript:$('#window').modal('show');">Добавить</a>
</div>

<table class="table table-hover table-sm" style="font-size: 12px;">
    <thead>
<tr class="zagolovok"> 
<th>Наименование</th><th>Контакты</th><th>Удалить</th>
</tr>
    </thead>
<?php
require_once("../connect.php");
$Q=mysqli_query($dbm,'select * FROM POSTAVSIK');
while ($Row=mysqli_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>";
echo $Row['NAME'];	
echo "</td>";
echo "<td>";
echo $Row['CONTAKT'];	
echo "</td>";
echo "<td>";
echo '<a href="#" onclick="javascript:delpostavsik('.$Row['ID'].');return(false);"><img height="25px" src="/images/error.png"></a>';
echo "</td>";
echo "</tr>";
}
?>
</table>


<!-- Само окно-->
<div class="modal fade" id="window">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
    <div class="modal-header">
        <div class="modal-title">
    Добавить поставщика
        </div>
    </div>
<div class="modal-body">
<form>
    <label for="postavsik">Поставщик:</label><input type="text" class="form-control" value="" id="postavsik">
    <label for="kontakt">Контакты:</label><input type="text" value="" class="form-control" id="kontakt">
</form>
</div>
             <div class="modal-footer">
<a href="#" class="btn btn-success" onclick="javascript:addpostavsik();">Добавить</a>
<a href="#" class="btn btn-default" onclick="javascript:$('#window').modal('hide');">Отмена</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function delpostavsik($idpostavsik){
	
	$.ajax({
		type:'POST',
		url:'/postavsik/delpostavsik.php',
		data:"idpostavsik="+$idpostavsik,
		success:function ()
		{
			
		  location.reload();
		}
	});
}
function addpostavsik()
{
  $.ajax({
type:'POST',
url:'/postavsik/addpostavsik.php',
data:"postavsik="+$('#postavsik').val()+"&kontakt="+$('#kontakt').val(),
success:function ()
{
  location.reload();
}
});
}
</script>
<?php require_once "../footer.php"; ?>