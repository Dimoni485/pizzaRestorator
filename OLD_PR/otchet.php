<style type="text/css">
.razdelitel{
height:50px;
}
</style>
<script type="text/javascript">
  $(function() {
$( "#datepicker" ).datepicker({dateFormat: "dd.mm.yy"});
$( "#datepicker2" ).datepicker({dateFormat: "dd.mm.yy"});
  });
</script>
<div class="razdelitel">
<?php
date_default_timezone_set("Europe/Moscow");
if (!isset($_POST['datastart'])){
	$datestart=date("d.m.Y");
}else{
	$datestart=$_POST['datastart'];
}

if (!isset($_POST['datastop'])){
	$datestop=date("d.m.Y");
}else{
	$datestop=$_POST['datastop'];
}

echo "<hr>";
echo "Период: с ";
echo "<input type='text' id='datepicker' value=".$datestart.">";
echo " по ";
echo "<input type='text' id='datepicker2' onchange='javascript:setperiod()' value=".$datestop.">";
?>
<a href="javascript:(print());">Распечатать</a> 
</div>
<table class="tableall" id="tableall">
<thead>
    <tr>
        <th rowspan="2"><b>Наименование товара</b></th>
        <th colspan="2"><b>ОСТАТОК  на начало периода</b></th>
        <th colspan="2"><b>ПРИХОД</b></th>
        <th colspan="2"><b>РАСХОД</b></th>
        <th colspan="2"><b>ОСТАТОК на конец периода</b></th>
    </tr>
    
    <tr>
        <th><b>ВЕС</b></th>
        <th><b>СУММА</b></th>
        <th><b>ВЕС</b></th>
        <th><b>СУММА</b></th>
        <th><b>ВЕС</b></th>
        <th><b>СУММА</b></th>
        <th><b>ВЕС</b></th>
        <th><b>СУММА</b></th>
    </tr>
    </thead>
    <tbody>
    <?php 
    set_time_limit(1000);
    $itogo_ostato_konec_period=0;
    $itogo_prihod=0;
    $summa_itigo_rashod_ves=0;
    $itogo_ostatok_na_cena=0;
    require_once("connect.php");
    $fbquery=ibase_query('SELECT PRODUKT,KOLVO FROM SKLAD ORDER BY PRODUKT');
    while ($fbrows=ibase_fetch_assoc($fbquery)) {
    	
    	$tp=ibase_query("SELECT CENA AS CENABRUTTO, PRODUKT FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$fbrows['PRODUKT']."'");
    	while ($Rowtp=ibase_fetch_assoc($tp))
    	{
    		$cena_produkta=$Rowtp['CENABRUTTO'];
    		$itogo_kolvo_period=$fbrows['KOLVO']*$Rowtp['CENABRUTTO'];
    		$itogo_ostato_konec_period=$itogo_ostato_konec_period+($fbrows['KOLVO']*$Rowtp['CENABRUTTO']);
    	}
    	$e_produkt=$fbrows['PRODUKT'];
    	$prihod_ves=ibase_query("SELECT SUM(KOLVO) AS SUMKOLVO FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$fbrows['PRODUKT']."' AND DATA_POS >= '".$datestart."' AND DATA_POS <= '".$datestop."'");
    	while ($row_prihod=ibase_fetch_assoc($prihod_ves)){
    	$e_row_prihod=number_format($row_prihod['SUMKOLVO'],2,",","");
    	$e_cena_produkta=number_format($cena_produkta*$row_prihod['SUMKOLVO'],2,"-","")."р.";
    	$itogo_prihod=$itogo_prihod+($cena_produkta*$row_prihod['SUMKOLVO']);
    	$dannie=$fbrows['PRODUKT'];
    	}
    	$prodazi=ibase_query("SELECT PRODUKT FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");
    	$itigo_kolvo_rashod=0;
    	while ($row_prodazi=ibase_fetch_assoc($prodazi)){
    	$sostav_produkta=ibase_query("SELECT KOLVO FROM SOSTAV WHERE ID_PRODUKCIYA='".$row_prodazi['PRODUKT']."' AND PRODUKT='".$fbrows['PRODUKT']."'");
    	while ($row_sostav_produkt=ibase_fetch_assoc($sostav_produkta)){
    	$itigo_kolvo_rashod=$itigo_kolvo_rashod+$row_sostav_produkt['KOLVO']; 
    	}
    	 
    	}
    	$summa_itigo_rashod_ves=$summa_itigo_rashod_ves+($itigo_kolvo_rashod*$cena_produkta);
    	$ostatok_na_nacalo=$fbrows['KOLVO']-$e_row_prihod+$itigo_kolvo_rashod;
    	$ostatok_na_nacalo_cena=$ostatok_na_nacalo*$cena_produkta;
    	$itogo_ostatok_na_cena=$itogo_ostatok_na_cena+$ostatok_na_nacalo_cena;
    	echo "<tr>";
    	echo "<td><b>".$e_produkt."</b></td>";
    	if ($ostatok_na_nacalo != 0){
    	echo "<td>".number_format($ostatok_na_nacalo,2,",","")."</td>";
    	}else{
    		echo "<td><span style='color:red;'>".number_format($ostatok_na_nacalo,2,",","")."</span></td>";
    	}
    	if ($ostatok_na_nacalo_cena != 0){
    	echo "<td>".number_format($ostatok_na_nacalo_cena,2,"-","")."р."."</td>"; //СУММА
    	}else
    	{
    		echo "<td><span style='color:red;'>".number_format($ostatok_na_nacalo_cena,2,"-","")."р."."</span></td>"; //СУММА
    	}
    	if ($e_row_prihod != 0){
    	echo "<td>".$e_row_prihod."</td>"; //приход ВЕС
    	}else{
    		echo "<td><span style='color:red;'>".$e_row_prihod."</span></td>"; //приход ВЕС
    	}
    	if ($e_cena_produkta != 0){
    	echo "<td>".$e_cena_produkta."</td>"; //приход ВЕС
    	}else{
    		echo "<td><span style='color:red;'>".$e_cena_produkta."</span></td>"; //приход ВЕС
    	}
    	if ($itigo_kolvo_rashod != 0){
    	echo "<td>".number_format($itigo_kolvo_rashod,2,",","")."</td>";//расход ВЕС
    	}else{
    		echo "<td><span style='color:red;'>".number_format($itigo_kolvo_rashod,2,",","")."</span></td>";//расход ВЕС
    	}
    	if ($itigo_kolvo_rashod*$cena_produkta != 0){
    	echo "<td>".number_format($itigo_kolvo_rashod*$cena_produkta,2,"-","")."р."."</td>";//СУММА
    	}else {
    		echo "<td><span style='color:red;'>".number_format($itigo_kolvo_rashod*$cena_produkta,2,"-","")."р."."</span></td>";//СУММА
    	}
    	if ($fbrows['KOLVO'] != 0){
    	echo "<td>".number_format($fbrows['KOLVO'],2,",","")."</td>";
    	}else{
    		echo "<td><span style='color:red;'>".number_format($fbrows['KOLVO'],2,",","")."</span></td>";
    	}
    	if ($itogo_kolvo_period != 0){
    	echo "<td>".number_format($itogo_kolvo_period,2,"-","")."р."."</td>";
    	}else{
    		echo "<td><span style='color:red;'>".number_format($itogo_kolvo_period,2,"-","")."р."."</span></td>";
    	}
    	
    	
    	echo "</tr>";
    	
    }
    ?>
    </tbody>
    
    <tfoot>
    <tr>
        <th><b>ИТОГО:</b></th>
        <th></th>
        <th><b><?php echo number_format($itogo_ostatok_na_cena,2,"-","")."р.";?></b></th>
        <th></th>
        <th><b><?php echo number_format($itogo_prihod,2,"-","")."р.";?></b></th>
        <th></th>
        <th><b><?php echo number_format($summa_itigo_rashod_ves,2,"-","")."р.";?></b></th>
        <th></th>
        <th><b><?php echo number_format($itogo_ostato_konec_period,2,"-","")."р.";?></b></th>
    </tr>
    </tfoot>
</table>
<script>
function setperiod()
{
fd=$("#datepicker").val();
fdd=$("#datepicker2").val();
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
pbPos = 0;
pbInt = setInterval(function() {
document.getElementById('preloader').style.backgroundPosition = ++pbPos + 'px 0';
}, 25);
$.ajax({
	type:'POST',
	url:'otchet.php',
	data:'datastart='+fd+'&datastop='+fdd,
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

}
</script>