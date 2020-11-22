<?php
echo '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">Радактирование</div> <div class="modal-body">';
$naimprod=$_POST['naimenprod'];
$kat=$_POST['kat'];
$idsostav=$_POST['idsostav'];
echo "<form><div class=\"form-group\"><input type='hidden' id='idprodukt' value='".$_POST['idprodukt']."'>";
echo "<input class=\"form-control\" type='hidden' id='idsostav' value='".$idsostav."'>";
echo "Наименование: <input type='text' class=\"form-control\" id='naimen' value='".$naimprod."'>";
echo 'Цена: <input type="number" class="form-control" id="cena" value='.$_POST['cena'].'>';
echo 'Категория: <select id="kat" class="custom-select">';
echo '<option >'.$kat.'</option>';
require_once("../connect.php");
$qkat=mysqli_query($dbm,"SELECT * FROM KATEGORII ORDER BY KAT");
while ($Rowd=mysqli_fetch_assoc($qkat)){
  echo "<option>".$Rowd['KAT']."</option>";
}
echo '</select></div></form>';

echo '<div class="modal-footer"> <a class="btn btn-success" href="javascript:soob()">Сохранить</a>';
echo '<button type="button" class="btn btn-secondary"  data-dismiss="modal" aria-label="Close" >Отмена</button></div>';
echo '</div></div></div>';
?>
<script type="text/javascript">
function soob()
{
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$cenaval=$("#cena").val();
$cenaval=$cenaval.replace(",",".");
  $.ajax({
	type: "POST",
	url: "/produkciya/saveprodukt.php",
	data: "cena="+$cenaval+"&naimen="+$("#naimen").val()+"&kat="+$("#kat").val()+"&idprodukt="+$("#idprodukt").val()+"&idsostav="+$("#idsostav").val(),
	success: function(html){
        document.location.href = "/produkciya";
	}
});
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
}
</script>
