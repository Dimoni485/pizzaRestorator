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
require_once("connect.php");
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

if (isset($_POST['naimentovar'])){
	$nametovar=iconv('UTF-8', 'windows-1251',$_POST['naimentovar']);
}else{
	$nametovar='';
}

echo "<hr>";
echo '<select id="produkt-sklad-postavsik" value="'.$nametovar.'">';
$Qv=ibase_query('select DISTINCT PRODUKT FROM SKLAD ORDER BY PRODUKT');
while ($Rowv=ibase_fetch_assoc($Qv)) {
	if ($Rowv['PRODUKT']==$nametovar){
	echo "<option selected>".$Rowv['PRODUKT']."</option>";
	}else{
		echo "<option>".$Rowv['PRODUKT']."</option>";
	}
}
echo '</select>';
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
        <th ><b>Наименование товара</b></th>
        <th ><b>НА СКЛАДЕ</b></th>
        <th ><b>ПРИХОД</b></th>
        <th ><b>РАСХОД</b></th>
    </tr>
    
    </thead>
    <tbody>
    <?php 
    set_time_limit(1000);
    $itogo_ostato_konec_period=0;
    $itogo_prihod=0;
    $summa_itigo_rashod_ves=0;
    $itogo_ostatok_na_cena=0;
    
    $fbquery=ibase_query("SELECT DISTINCT PRODUKT FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$nametovar."'  GROUP BY PRODUKT");
    while ($fbrows=ibase_fetch_assoc($fbquery)) {
    	echo "<tr>";
    	echo "<td>".$fbrows['PRODUKT']."</td>";
    $sklad=ibase_query("SELECT SUM(KOLVO) AS KOLVO FROM SKLAD WHERE PRODUKT='".$fbrows['PRODUKT']."'");
    $sklad_row=ibase_fetch_assoc($sklad);
    echo "<td>".number_format($sklad_row['KOLVO'],2,",","")."</td>";
    $sklad_kolvo=ibase_query("SELECT SUM(KOLVO) AS KOLVO FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$nametovar."' AND DATA_POS >= '".$datestart."' AND DATA_POS <= '".$datestop."'");
    $sklad_kolvo_row=ibase_fetch_assoc($sklad_kolvo);	
    echo "<td>".number_format($sklad_kolvo_row['KOLVO'],2,",","")."</td>";
    	
    $colvo_rashod=ibase_query("SELECT SUM(KOLVO) AS KOLVO FROM RASHOD_PRODUKT WHERE PRODUKT='".$fbrows['PRODUKT']."' AND DATA_PROD >= '".$datestart."' AND DATA_PROD <= '".$datestop."'");
    $colwo_rashod_rows=ibase_fetch_assoc($colvo_rashod);
    if ($colwo_rashod_rows != False){
    	echo "<td align='left'><font color='blue'>Итого: ".number_format($colwo_rashod_rows['KOLVO'],2,",","")."</font>";
    	$produkciya=ibase_query("SELECT DISTINCT ID_PRODUKCIYA, SUM(KOLVO) AS KOLVO FROM RASHOD_PRODUKT WHERE PRODUKT='".$fbrows['PRODUKT']."' AND DATA_PROD >= '".$datestart."' AND DATA_PROD <= '".$datestop."' GROUP BY ID_PRODUKCIYA");
    	while ($produkciya_row=ibase_fetch_assoc($produkciya)) {
    		$kolvo_sostav=ibase_query("SELECT KOLVO FROM SOSTAV WHERE ID_PRODUKCIYA='".$produkciya_row['ID_PRODUKCIYA']."' AND PRODUKT='".$fbrows['PRODUKT']."'");
    		$kolvo_sostav_row=ibase_fetch_assoc($kolvo_sostav);
    		$prodazi=ibase_query("SELECT SUM(COLVO) AS KOLVO FROM PRODAZI WHERE PRODUKT='".$produkciya_row['ID_PRODUKCIYA']."' AND DATE_POK >= '".$datestart."' AND DATE_POK <= '".$datestop."'");
    		$prodazi_row=ibase_fetch_assoc($prodazi);
    		echo "<li>".$produkciya_row['ID_PRODUKCIYA']."- ".number_format($kolvo_sostav_row['KOLVO'],2,",","")." * ".$prodazi_row['KOLVO']." =".number_format($produkciya_row['KOLVO'],2,",","")."</li><hr>";
    	}
    	echo "</td>";
    }else{
    	echo "<td>0</td>";
    }
    echo "</tr>";
    	}
    	
    ?>
    </tbody>
    
    <tfoot>
    </tfoot>
</table>
<script>
function setperiod()
{
fd=$("#datepicker").val();
fdd=$("#datepicker2").val();
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	type:'POST',
	url:'otchet_pr.php',
	data:'datastart='+fd+'&datastop='+fdd+'&naimentovar='+$("#produkt-sklad-postavsik").val(),
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

}
</script>