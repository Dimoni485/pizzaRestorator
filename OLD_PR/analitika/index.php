
<?php
ob_start();
require_once "../header.php";
require_once("../connect.php");
?>
<style type="text/css">
.razdelitel{
height:50px;
}
th{
text-align:left;
}
tfoot th{
text-align:center;
}
</style>
<script type="text/javascript">
  $(function() {
$( "#datepicker" ).datepicker({
    locale:'ru-ru',
    format: "yyyy-mm-dd",
    uiLibrary:'bootstrap4'
});
$( "#datepicker2" ).datepicker({locale:'ru-ru', format: "yyyy-mm-dd", uiLibrary:'bootstrap4',});
  });
</script>

<div class="navbar">
    <div class="nav nav-default">
<?php
date_default_timezone_set("Europe/Moscow");
if (!isset($_GET['datastart'])){
	$datestart=date("Y-m-d");
}else{
	$datestart=$_GET['datastart'];
}

if (!isset($_GET['datastop'])){
	$datestop=date("Y-m-d");
}else{
	$datestop=$_GET['datastop'];
}

echo "<div class='input-group'>";
echo "<div class='input-group-prepend'>";
echo "<span class=\"input-group-text\">Период:</span> ";
echo "<input id='datepicker' value=".$datestart.">";
echo "<input id='datepicker2' value=".$datestop.">";
?>
<a class="btn btn-success" id="btn-period" href="javascript:setperiod();">Задать период</a>
    </div>
</div>
<!--<a href="javascript:(print());"><img width="25px" src="/images/technology-1.png"></a>-->
<!--<button type="button" class="btn btn-default" id="singh" onclick="javascript:sinhronization();">Обновить</button>-->
<div class='singinfo'></div>
    </div>
</div>
<br>
<table class="table table-bordered table-sm" style="font-size: 14px;">
<tr>
<?php
$sebestoimost_produkta=0;
$stoimost_produkta=0;
$dohod_tab=0;
$spisano_produktov=0;
$skidka_summa=0;
//require_once("connect.php");

$Qz=mysqli_query($dbm,"select SUM(ITOGO) AS SUMMAITOGO FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");
while ($Rowz=mysqli_fetch_assoc($Qz)) {
	$viruc=$Rowz['SUMMAITOGO'];
}



$produkt_prodaza=mysqli_query($dbm,"select SUM(ITOGO) AS SUMMA FROM RASHOD_PRODUKT WHERE (DATA_PROD >= '".$datestart."')AND(DATA_PROD <='".$datestop."')");
while ($Row_prodaza_produkt=mysqli_fetch_assoc($produkt_prodaza)) {
				$sebestoimost_produkta=$Row_prodaza_produkt['SUMMA'];
}

$spisanie_produkta=mysqli_query($dbm,"select SPISANIE.PRODUKT, SPISANIE.KOLVO AS KOLVO ,MAX(TOVAR_POSTAVSIK.CENA) AS CENA 
		FROM SPISANIE, TOVAR_POSTAVSIK 
		WHERE (SPISANIE.PRODUKT=TOVAR_POSTAVSIK.PRODUKT) 
		AND (SPISANIE.DATE_SPIS >= '".$datestart."')
		AND(SPISANIE.DATE_SPIS <='".$datestop."') GROUP BY SPISANIE.PRODUKT, SPISANIE.KOLVO");
While ($row_spisanie=mysqli_fetch_assoc($spisanie_produkta)){
$spisano_produktov=$spisano_produktov+($row_spisanie['KOLVO']*$row_spisanie['CENA']);
}

$dostavka=mysqli_query($dbm,"select SUM(SUMMA) AS SUMDOSTAVKA FROM DOSTAVKA WHERE (DATA_DOS >= '".$datestart."')AND(DATA_DOS <='".$datestop."')");

while ($row_dostavka=mysqli_fetch_assoc($dostavka)){
	$dostavka_summa=$row_dostavka['SUMDOSTAVKA'];
}

$skidka_query=mysqli_query($dbm,"select SUM(SKIDKA) AS SKIDKA FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");

while ($row_skidka=mysqli_fetch_assoc($skidka_query)){
	$skidka_summa=$row_skidka['SKIDKA'];
}
?>
	<th ><a href="#" onclick='javascript:loadprodazi();'>ВЫРУЧКА</a></th>
	<td >
	<?php 
	if (isset($viruc)){
	echo number_format($viruc,2,',','')."р.";
	}else{
        echo "0,00р.";
    }
	?>
	</td>
	<th ><a href="#" title="(((1500*12)/365)+ВЫРУЧКА * 0.02)*2">ФЗП АДМИНИСТРАТОРА</a></th>
	<td><a href="#" title="(((1500*12)/365)+ВЫРУЧКА * 0.02)*2">
	<?php 
	if (isset($viruc)){
	echo number_format((((1500*12)/365)+$viruc * 0.02)*2,2,',','')."р.";
	}else{
	    echo "0,00р.";
    }
	?>
	</a></td>
</tr>

<tr>
	<th ><a href="#" onclick='javascript:loadprodukt();'>СЕБЕСТОИМОСТЬ реализованного товара</a></th>
	<td>
	<?php 
	if (isset($sebestoimost_produkta)){
	echo number_format($sebestoimost_produkta,2,',','').'р.';
	}else{
        echo "0,00р.";
    }
	?>
	</td>
	<th><a href="#" title="ВЫРУЧКА*0.20"><b>ФЗП  ПОВАРОВ</b></a></th>
	<td><a href="#" title="ВЫРУЧКА*0.20">
	<?php 
	if (isset($viruc)){
	echo number_format($viruc*0.20,2,',','')."р.";
	}else{
        echo "0,00р.";
    }
	?>
	</a></td>
</tr>
<tr>
	<th><a href="#" title="ДОСТАВКА=80р." onclick='javascript:loadrekvizit();'><b>ДОСТАВКА</b></a></th>
	<td><a href="#" title="ДОСТАВКА=80р.">
	<?php 
	if (isset($dostavka_summa)){
	echo number_format($dostavka_summa,2,',','')."р.";
	}else{
        echo "0,00р.";
    }
	?>
	</a></td>
	<th><a href="#" onclick='javascript:loadspisanie();'><b>СПИСАНИЕ</b></a></th>
	<td>
	<?php 
	if (isset($spisano_produktov)){
	echo number_format($spisano_produktov,2,',','')."р.";
	}else{
        echo "0,00р.";
    }
	?>
	</td>
</tr>
<tr>
	<th ><a href="#" onclick='javascript:loadskidka();'><b>СКИДКИ</b></a></th>
	<td>
	<?php 
	if (isset($skidka_summa)){
	echo number_format($skidka_summa,2,',','')."р.";
	}else{
        echo "0,00р.";
    }
	?>
	</td>
	<th><a href="#"><b>ДОХОД</b></a></th>
	<td>
	<?php 
	$dohod_tab=$viruc-((((1500*12)/365)+$viruc * 0.02)*2)-($viruc*0.20)-$sebestoimost_produkta-$spisano_produktov-$dostavka_summa-$skidka_summa; 
	if (isset($dohod_tab)){
	echo number_format($dohod_tab,2,',','')."р.";
	}else{
        echo "0,00р.";
    }
	?>
	</td>
</tr>
</table>
   

<table class="table table-hover table-sm" style="font-size: 14px;">
<thead>
  <tr>
    <th><b>НАИМЕНОВАНИЕ</b></th>
    <th><b>ЦЕНА</b></th>
    <th><b>КОЛЛИЧЕСТВО</b></th>
    <th><b>ВЫРУЧКА</b></th>
    <th><b>СЕБЕСТОИМОСТЬ</b></th>
    <th><b>ДОХОД</b></th>
  </tr>
  </thead>
  <tbody>
  <?php 
  $itog_cena_tovara=0;
  $itog_colvo_tovara=0;
  $itog_dohod=0;
  $itog_itogo_tovara=0;
  $itogo_sebest_produkt=0;
  $produkt_name_prod="";
  $tablica_tovara=mysqli_query($dbm,"select DISTINCT PRODUKT,CENA, SUM(COLVO) AS COLVO, SUM(ITOGO) AS ITOGO FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."') GROUP BY PRODUKT, CENA");
while ($Row_tab_tovara=mysqli_fetch_assoc($tablica_tovara)) {
  
	echo "<tr>";
    echo "<td>".$Row_tab_tovara['PRODUKT']."</td>";
    
    echo "<td>".number_format($Row_tab_tovara['CENA'],2,',','')."р."."</td>";
    $itog_cena_tovara=$itog_cena_tovara+$Row_tab_tovara['CENA'];
    
    echo "<td>".$Row_tab_tovara['COLVO']."</td>";
    $itog_colvo_tovara=$itog_colvo_tovara+$Row_tab_tovara['COLVO'];
    
    echo "<td>".number_format($Row_tab_tovara['ITOGO'],2,',','')."р."."</td>";
    $itog_itogo_tovara=$itog_itogo_tovara+$Row_tab_tovara['ITOGO'];
    
    $sebest_produkt_tab=mysqli_query($dbm,"SELECT SUM(ITOGO) AS SUMMA FROM RASHOD_PRODUKT WHERE ID_PRODUKCIYA='".$Row_tab_tovara['PRODUKT']."' AND (DATA_PROD >= '".$datestart."')AND(DATA_PROD <='".$datestop."')");
		while ($sebect_produkt=mysqli_fetch_assoc($sebest_produkt_tab)) {
    		echo "<td>".number_format($sebect_produkt['SUMMA'],2,',','')."р."."</td>";
    			$itogo_sebest_produkt=$itogo_sebest_produkt+$sebect_produkt['SUMMA'];
    		echo "<td>".number_format($Row_tab_tovara['ITOGO']-$sebect_produkt['SUMMA'],2,',','')."р."."</td>";
    			$dohod=($Row_tab_tovara['ITOGO']-$sebect_produkt['SUMMA']);
    			$itog_dohod=$itog_dohod+$dohod;
			}
    
  echo "</tr>";
}

  ?>
  </tbody>
  <tfoot>
  <tr>
    <th><b>ИТОГО:</b></th>
    <th>
    <b>
    <?php 
    if (isset($itog_cena_tovara)){
    echo number_format($itog_cena_tovara,2,',','')."р.";
    }
    ?>
    </b></th>
    <th><b>
    <?php  
    if (isset($itog_colvo_tovara)){
    echo $itog_colvo_tovara;
    }
    ?>
    </b></th>
    <th><b>
    <?php 
    if (isset($itog_itogo_tovara)){
    echo number_format($itog_itogo_tovara,2,',','')."р.";
    }
    ?>
    </b></th>
    <th><b>
    <?php 
    if (isset($itogo_sebest_produkt)){
    echo number_format($itogo_sebest_produkt,2,',','')."р.";
    }
    ?>
    </b></th>
    <th><b>
    <?php 
    if (isset($itog_dohod)){
    echo number_format($itog_dohod,2,',','')."р.";
    }
    ?>
    </b></th>
  </tr>
  </tfoot>
</table>


<script>
function setperiod()
{
$('#btn-period').text('Идет выборка...');
    $('#btn-period').addClass('disabled');
fd=$("#datepicker").val();
fdd=$("#datepicker2").val();
    $(location).attr('href','/analitika/index.php?datastart=' + fd +'&datastop=' + fdd );
    return false;
/*$.ajax({
	type:'POST',
	url:'/analitika/index.php',
	data:'datastart='+fd+'&datastop='+fdd,
	success: function (data){
	  //$('.contant').html(data);

	}
	
});
*/
}
function sinhronization(){
	$('#singh').css('display','none');
	$('.singinfo').text('Идет синхронизация записей... Ждите...');
	$.ajax({
		url:'/analitika/sinhronization.php',
		success:function(){
			$('#singh').css('display','block');
			$('.singinfo').text('Cинхронизация завершена');	
			loadanalitika();
		}
		});
	
}
</script>
<?php require_once "../footer.php"; ?>

