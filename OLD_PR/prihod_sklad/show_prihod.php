<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
Проверьте правильноcть выгружаемых данных.
            </h5>
        </div>
        <div class="modal-body">
<table class="table">
<thead>
<th>Наименование</th><th>Количество</th><th>Цена</th><th>Удалить</th>
</thead>
<?php
require_once("../connect.php");
$Qtmp=mysqli_query($dbm,'select * FROM TOVAR_POSTAVSIK_TMP ORDER BY PRODUKT');
while ($Rowtmp=mysqli_fetch_assoc($Qtmp)) {
echo "<tr>";
echo "<td>".$Rowtmp['PRODUKT']."</td>";
echo "<td>".$Rowtmp['KOLVO_BRUTTO']."</td>";
echo "<td>".$Rowtmp['CENA_BRUTTO']."</td>";
echo '<td> <a href="#" onclick="javascript:del_prihod(\''.$Rowtmp['ID'].'\')">Удалить</td>';
echo "</tr>";
}
?>
</table>
        </div>
        <div class="modal-footer">
<button class='btn btn-success' id='vig_na_sklad' onclick="javascript:addsklad();return(false);" >Выгрузить на склад</button>
<button class='btn btn-secondary' data-dismiss="modal" id='izm_data'>Изменить данные</button>
<div id='info_text'></div>
        </div>
    </div>
</div>
<script type="text/javascript">
function del_prihod($idprihod_tovar)
{
  $.ajax({
type:'POST',
url:'/prihod_sklad/deltovar.php',
data:"tovarname="+$idprihod_tovar,
success:function(html)
{
  add_sklad('block');
}
});
}
</script>