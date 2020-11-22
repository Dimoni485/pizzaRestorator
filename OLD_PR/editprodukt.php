<?php
header('Content-Type: text/html; charset=Windows-1251', true);
echo '<div class=editprod align=right>';
$naimprod=iconv('UTF-8','Windows-1251',$_POST['naimenprod']);
$kat=iconv('UTF-8','Windows-1251',$_POST['kat']);
$idsostav=iconv('UTF-8','Windows-1251',$_POST['idsostav']);
echo "<input type='hidden' id='idprodukt' value='".$_POST['idprodukt']."'>";
echo "<input type='hidden' id='idsostav' value='".$idsostav."'>";
echo "Наименование: <input type='text' size='40' id='naimen' value='".$naimprod."'><br>";
echo 'Цена: <input type="text" size="40" id="cena" value='.$_POST['cena'].'><br>';
echo 'Категория: <select size=1 id="kat">';
echo '<option >'.$kat.'</option>';
require_once("connect.php");
$qkat=ibase_query("SELECT * FROM KATEGORII ORDER BY KAT");
while ($Rowd=ibase_fetch_assoc($qkat)){
  echo "<option>".$Rowd['KAT']."</option>";
}
echo '</select><br><br><br>';
echo '<a class="green" href="javascript:soob()">Сохранить</a>';
echo '<a class="green" href="#" onclick="javascript:loadprodukt();return(false);">Отмена</a><br><br>';
echo '</div>';
?>
<script type="text/javascript">
function soob()
{
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
pbPos = 0;
pbInt = setInterval(function() {
document.getElementById('preloader').style.backgroundPosition = ++pbPos + 'px 0';
}, 25);
$cenaval=$("#cena").val();
$cenaval=$cenaval.replace(",",".");
  $.ajax({
	type: "POST",
	url: "saveprodukt.php",
	data: "cena="+$cenaval+"&naimen="+$("#naimen").val()+"&kat="+$("#kat").val()+"&idprodukt="+$("#idprodukt").val()+"&idsostav="+$("#idsostav").val(),
	success: function(html){  
        loadprodukt(); 
	}
});
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
}
</script>
