<style type="text/css">
.razdelitel{
	height:110px;
}
</style>
<script type="text/javascript">
$(function() {
	$( "#datepicker" ).datepicker({dateFormat: "Y-mm-dd"});
	$( "#datepicker2" ).datepicker({dateFormat: "Y-mm-dd"});
});
	</script>
	<div class="razdelitel">
	<?php
	
	date_default_timezone_set("Europe/Moscow");
	if (!isset($_POST['datastart'])){
		$datestart=date("Y-m-d");
	}else{
		$datestart=$_POST['datastart'];
	}

	if (!isset($_POST['datastop'])){
		$datestop=date("Y-m-d");
	}else{
		$datestop=$_POST['datastop'];
	}
	if (!isset($_POST['produktname'])){
		$produktname='';
	}else{
	$produktname=$_POST['produktname'];
	}
	$produktname=$produktname;
	echo $produktname;
	echo "<hr>";
	echo "Период: с ";
	echo "<input type='text' id='datepicker' value=".$datestart.">";
	echo " по ";
	echo "<input type='text' id='datepicker2'  value=".$datestop.">";
	
	echo "<br><br>Номенклатура:<select id='selprodukt'>";
	require_once '../connect.php';
	echo "<option>".$produktname."</option>";
	$select_produkt=mysqli_query($dbm,'SELECT PRODUKT FROM PRODUKCIYA ORDER BY PRODUKT');
	while ($Row_pr_sel=mysqli_fetch_assoc($select_produkt)){
	echo "<option >".$Row_pr_sel['PRODUKT']."</option>";
	}
	echo "</select>";
	?>
<a href="javascript:setperiod_prod();">Применить</a> 
</div>
<table class="tableall" id="tableall">
<thead>
<tr>
<th>Номенклатура</th>
<th>Кол-во</th>
<th>Дата продажи</th>
</tr>
</thead>
<tbody>
<?php 

$tablica_body=mysqli_query($dbm,"select PRODUKT,DATE_POK FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."') AND (PRODUKT='".$produktname."') GROUP BY DATE_POK, PRODUKT ORDER BY DATE_POK");
while ($Row_tab_body=mysqli_fetch_assoc($tablica_body)) {
	echo "<tr>";
		echo "<td>".$Row_tab_body['PRODUKT']."</td>";
$tablica_data_produkt=mysqli_query($dbm,"select SUM(COLVO) AS KOLVO FROM PRODAZI WHERE (DATE_POK = '".$Row_tab_body['DATE_POK']."') AND (PRODUKT='".$Row_tab_body['PRODUKT']."') GROUP BY PRODUKT");
while ($Row_tab_data_produkt=mysqli_fetch_assoc($tablica_data_produkt)) {
	echo "<td>".$Row_tab_data_produkt['KOLVO']."</td>";
	echo "<td>".$Row_tab_body['DATE_POK']."</td>";
	echo "</tr>";
}

}

?>
</tbody>
</table>
<script type="text/javascript">
function setperiod_prod()
{
fd=$("#datepicker").val();
fdd=$("#datepicker2").val();
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	type:'POST',
	url:'/prodazi/prodaza_produkciya.php',
	data:'datastart='+fd+'&datastop='+fdd+'&produktname='+$('#selprodukt').val(),
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

}
</script>
