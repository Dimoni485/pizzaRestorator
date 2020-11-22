<?php
//error_reporting(0);
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
$( "#datepicker" ).datepicker({dateFormat: "dd.mm.yy"});
$( "#datepicker2" ).datepicker({dateFormat: "dd.mm.yy"});
  });
</script>

<div class="razdelitel_anal">
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

echo "<br>";
echo "Период: с ";
echo "<input type='text' id='datepicker' value=".$datestart.">";
echo " по ";
echo "<input type='text' id='datepicker2' onchange='javascript:setperiod()' value=".$datestop.">";
?>
&nbsp;&nbsp;<a href="javascript:setperiod();"><img width="25px" src="/images/tool.png"></a> 
&nbsp;<a href="javascript:(print());"><img width="25px" src="/images/technology-1.png"></a><br> 
<a href="#" id="singh" onclick="javascript:sinhronization();">Обновить</a>
<div class='singinfo'></div>
</div>

<table class="tab_analitik" style="margin: 0 auto;">
<tr>
<?php
$sebestoimost_produkta=0;
$stoimost_produkta=0;
$dohod_tab=0;
$spisano_produktov=0;
$skidka_summa=0;
//require_once("connect.php");

$Qz=ibase_query("select SUM(ITOGO) AS SUMMAITOGO FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");
while ($Rowz=ibase_fetch_assoc($Qz)) {
	$viruc=$Rowz['SUMMAITOGO'];
}



$produkt_prodaza=ibase_query("select SUM(ITOGO) AS SUMMA FROM RASHOD_PRODUKT WHERE (DATA_PROD >= '".$datestart."')AND(DATA_PROD <='".$datestop."')");
while ($Row_prodaza_produkt=ibase_fetch_assoc($produkt_prodaza)) {
				$sebestoimost_produkta=$Row_prodaza_produkt['SUMMA'];
}

$spisanie_produkta=ibase_query("select SPISANIE.PRODUKT, SPISANIE.KOLVO AS KOLVO ,MAX(TOVAR_POSTAVSIK.CENA) AS CENA 
		FROM SPISANIE, TOVAR_POSTAVSIK 
		WHERE (SPISANIE.PRODUKT=TOVAR_POSTAVSIK.PRODUKT) 
		AND (SPISANIE.DATE_SPIS >= '".$datestart."')
		AND(SPISANIE.DATE_SPIS <='".$datestop."') GROUP BY SPISANIE.PRODUKT, SPISANIE.KOLVO");
While ($row_spisanie=ibase_fetch_assoc($spisanie_produkta)){
$spisano_produktov=$spisano_produktov+($row_spisanie['KOLVO']*$row_spisanie['CENA']);
}

$dostavka=ibase_query("select SUM(SUMMA) AS SUMDOSTAVKA FROM DOSTAVKA WHERE (DATA_DOS >= '".$datestart."')AND(DATA_DOS <='".$datestop."')");

while ($row_dostavka=ibase_fetch_assoc($dostavka)){
	$dostavka_summa=$row_dostavka['SUMDOSTAVKA'];
}

$skidka_query=ibase_query("select SUM(SKIDKA) AS SKIDKA FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");

while ($row_skidka=ibase_fetch_assoc($skidka_query)){
	$skidka_summa=$row_skidka['SKIDKA'];
}
?>
	<th><a href="#" onclick='javascript:loadprodazi();'><img src="/images/coins.png" width="35px"><b>ВЫРУЧКА</b></a></th>
	<td>
	<?php 
	if (isset($viruc)){
	echo number_format($viruc,2,',','')."р.";
	}
	?>
	</td>
	<th ><a href="#" title="(((1500*12)/365)+ВЫРУЧКА * 0.02)*2"><img src="/images/girl.png" width="35px"><b>ФЗП АДМИНИСТРАТОРА</b></a></th>
	<td><a href="#" title="(((1500*12)/365)+ВЫРУЧКА * 0.02)*2">
	<?php 
	if (isset($viruc)){
	echo number_format((((1500*12)/365)+$viruc * 0.02)*2,2,',','')."р.";
	}
	?>
	</a></td>
</tr>

<tr>
	<th ><a href="#" onclick='javascript:loadprodukt();'><img src="/images/apple.png" width="35px"><b>СЕБЕСТОИМОСТЬ<br>реализованного товара</b></a></th>
	<td>
	<?php 
	if (isset($sebestoimost_produkta)){
	echo number_format($sebestoimost_produkta,2,',','').'р.';
	}
	?>
	</td>
	<th><a href="#" title="ВЫРУЧКА*0.20"><img src="/images/food.png" width="35px"><b>ФЗП  ПОВАРОВ</b></a></th>
	<td><a href="#" title="ВЫРУЧКА*0.20">
	<?php 
	if (isset($viruc)){
	echo number_format($viruc*0.20,2,',','')."р.";
	}
	?>
	</a></td>
</tr>
<tr>
	<th><a href="#" title="ДОСТАВКА=80р." onclick='javascript:loadrekvizit();'><img src="/images/people.png" width="35px"><b>ДОСТАВКА</b></a></th>
	<td><a href="#" title="ДОСТАВКА=80р.">
	<?php 
	if (isset($dostavka_summa)){
	echo number_format($dostavka_summa,2,',','')."р.";
	}
	?>
	</a></td>
	<th><a href="#" onclick='javascript:loadspisanie();'><img src="/images/garbage.png" width="35px"><b>СПИСАНИЕ</b></a></th>
	<td>
	<?php 
	if (isset($spisano_produktov)){
	echo number_format($spisano_produktov,2,',','')."р.";
	}
	?>
	</td>
</tr>
<tr>
	<th ><a href="#" onclick='javascript:loadskidka();'><img src="/images/signs.png" width="35px"><b>СКИДКИ</b></a></th>
	<td>
	<?php 
	if (isset($skidka_summa)){
	echo number_format($skidka_summa,2,',','')."р.";
	}
	?>
	</td>
	<th><a href="#"><img src="/images/money-1.png" width="35px"><b>ДОХОД</b></a></th>
	<td>
	<?php 
	$dohod_tab=$viruc-((((1500*12)/365)+$viruc * 0.02)*2)-($viruc*0.20)-$sebestoimost_produkta-$spisano_produktov-$dostavka_summa-$skidka_summa; 
	if (isset($dohod_tab)){
	echo number_format($dohod_tab,2,',','')."р.";
	}
	?>
	</td>
</tr>
</table>
   

<table class="tableall" style="margin: 5px auto;">
<thead>
  <tr>
    <th><b>НАИМЕНОВАНИЕ продукта</b></th>
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
  $tablica_tovara=ibase_query("select DISTINCT PRODUKT,CENA, SUM(COLVO) AS COLVO, SUM(ITOGO) AS ITOGO FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."') GROUP BY PRODUKT, CENA");
while ($Row_tab_tovara=ibase_fetch_assoc($tablica_tovara)) {
  
	echo "<tr>";
    echo "<td>".$Row_tab_tovara['PRODUKT']."</td>";
    
    echo "<td>".number_format($Row_tab_tovara['CENA'],2,',','')."р."."</td>";
    $itog_cena_tovara=$itog_cena_tovara+$Row_tab_tovara['CENA'];
    
    echo "<td>".$Row_tab_tovara['COLVO']."</td>";
    $itog_colvo_tovara=$itog_colvo_tovara+$Row_tab_tovara['COLVO'];
    
    echo "<td>".number_format($Row_tab_tovara['ITOGO'],2,',','')."р."."</td>";
    $itog_itogo_tovara=$itog_itogo_tovara+$Row_tab_tovara['ITOGO'];
    
    $sebest_produkt_tab=ibase_query("SELECT SUM(ITOGO) AS SUMMA FROM RASHOD_PRODUKT WHERE ID_PRODUKCIYA='".$Row_tab_tovara['PRODUKT']."' AND (DATA_PROD >= '".$datestart."')AND(DATA_PROD <='".$datestop."')");	
		while ($sebect_produkt=ibase_fetch_assoc($sebest_produkt_tab)) {
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
fd=$("#datepicker").val();
fdd=$("#datepicker2").val();
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	type:'POST',
	url:'/analitika/analitika.php',
	data:'datastart='+fd+'&datastop='+fdd,
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

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


