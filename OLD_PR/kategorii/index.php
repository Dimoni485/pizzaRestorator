<?php require_once "../header.php"; ?>
<style type="text/css">
.razdelitel{
height:50px;
}
</style>
<div class="razdelitel">
<a href="#" onclick="addkat();" class="btn btn-success">Добавить</a>
</div>
<table class="table table-hover table-sm">
    <thead>
<tr class="zagolovok"> 
<th>Категории</th><th>Удалить</th>
</tr>
    </thead>
<?php
require_once("../connect.php");
$Q=mysqli_query($dbm,'select * FROM KATEGORII ORDER BY KAT');
while ($Row=mysqli_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>";
echo $Row['KAT'];	
echo "</td>";
echo "<td>";
echo "<a href='#'><img src='/images/error.png' width='25px' height='25px' alt='Удалить'></a>";	
echo "</td>";
echo "</tr>";
}
?>
</table>

<div class="modal fade" id="addkat">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<div class="modal-title">Добавление категории</div>
            </div>
<div class="modal-body">
<input type="text" class="form-control" id=addkattext>
<div class="modal-footer">
    <a href="#" onclick="savekat();" class='btn btn-success'>Добавить</a><a href="#" class='btn btn-default' onclick="$('#addkat').modal('hide');">Закрыть</a>
</div>
</div>
        </div>
    </div>
</div>
<script type="text/javascript">
function addkat()
{
$("#addkat").modal('show');
}
function savekat()
{
  $.ajax({
type:'POST',
url:'/kategorii/addkat.php',
data:'kat='+$("#addkattext").val(),
success:function(){
location.reload();
}
});
}
</script>
<?php require_once "../footer.php"; ?>