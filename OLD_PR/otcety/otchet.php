
<script type="text/javascript">
    $(function() {
        $( "#datepicker" ).datepicker({
            locale:'ru-ru',
            format: "yyyy-mm-dd",
            uiLibrary:'bootstrap4'
        });
        $( "#datepicker2" ).datepicker({
            locale:'ru-ru',
            format: "yyyy-mm-dd",
            uiLibrary:'bootstrap4'
        });
    });
</script>

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
?>
<nav class="navbar">
    <form class="form-inline">
    <?php
echo "<span class='mr-2'>Период: с</span> <input class='form-control' type='text' id='datepicker' value=".$datestart."> <span class='mr-2 ml-2'>по</span> <input class='form-control' type='text' id='datepicker2' value=".$datestop.">";
?>
        <button class="btn btn-succes m-3" onclick='javascript:setperiod();return(false);'>Выбрать</button>
<a class="m-4" href="javascript:(print());"><span class="oi oi-print"></span></a>
    </form>
</nav>
<table class="table table-bordered" id="tableall">
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
    require_once("../connect.php");
    $fbquery=mysqli_query($dbm,'SELECT PRODUKT,KOLVO FROM SKLAD ORDER BY PRODUKT');
    while ($fbrows=mysqli_fetch_assoc($fbquery)) {
    	
    	$tp=mysqli_query($dbm,"SELECT CENA AS CENABRUTTO, PRODUKT FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$fbrows['PRODUKT']."'");
    	while ($Rowtp=mysqli_fetch_assoc($tp))
    	{
    		$cena_produkta=$Rowtp['CENABRUTTO'];
    		$itogo_kolvo_period=$fbrows['KOLVO']*$Rowtp['CENABRUTTO'];
    		$itogo_ostato_konec_period=$itogo_ostato_konec_period+($fbrows['KOLVO']*$Rowtp['CENABRUTTO']);
    	}
    	$e_produkt=$fbrows['PRODUKT'];
    	$prihod_ves=mysqli_query($dbm,"SELECT SUM(KOLVO) AS SUMKOLVO FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$fbrows['PRODUKT']."' AND DATA_POS >= '".$datestart."' AND DATA_POS <= '".$datestop."'");
    	while ($row_prihod=mysqli_fetch_assoc($prihod_ves)){
    	$e_row_prihod=$row_prihod['SUMKOLVO'];
    	$e_cena_produkta=number_format($cena_produkta*$row_prihod['SUMKOLVO'],2,"-","")."р.";
    	$itogo_prihod=$itogo_prihod+($cena_produkta*$row_prihod['SUMKOLVO']);
    	$dannie=$fbrows['PRODUKT'];
    	}
    	$prodazi=mysqli_query($dbm,"SELECT PRODUKT FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");
    	$itigo_kolvo_rashod=0;
    	while ($row_prodazi=mysqli_fetch_assoc($prodazi)){
    	$sostav_produkta=mysqli_query($dbm,"SELECT KOLVO FROM SOSTAV WHERE ID_PRODUKCIYA='".$row_prodazi['PRODUKT']."' AND PRODUKT='".$fbrows['PRODUKT']."'");
    	while ($row_sostav_produkt=mysqli_fetch_assoc($sostav_produkta)){
    	$itigo_kolvo_rashod=$itigo_kolvo_rashod+$row_sostav_produkt['KOLVO']; 
    	}
    	 
    	}
    	$summa_itigo_rashod_ves=$summa_itigo_rashod_ves+($itigo_kolvo_rashod*$cena_produkta);
    	if ($e_row_prihod <> 0){
    	   $e_row_prihod=$e_row_prihod;
        }else{
    	    $e_row_prihod=0;
        }
        if ($itigo_kolvo_rashod <> 0){
            $itigo_kolvo_rashod=$itigo_kolvo_rashod;
        }else{
            $itigo_kolvo_rashod=0;
        }
        if ($fbrows['KOLVO'] <> 0){
           $kolvo= $fbrows['KOLVO'];
        }else{
            $kolvo=0;
        }

        $ostatok_na_nacalo=$kolvo-($e_row_prihod+$itigo_kolvo_rashod);
        if ($ostatok_na_nacalo<>0){

        }else {
            $ostatok_na_nacalo = 0;
        }
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
    $("#preload").css("display","block");
$.ajax({
	type:'POST',
	url:'otchet.php',
	data:'datastart='+fd+'&datastop='+fdd,
	success: function (data){
	  $('.contenttab').html(data);
        $("#preload").css("display","none");

	}
	
});

}
</script>