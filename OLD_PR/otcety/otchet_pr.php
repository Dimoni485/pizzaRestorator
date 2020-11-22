
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
<nav class="navbar">
<?php

date_default_timezone_set("Europe/Moscow");
require_once("../connect.php");
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

if (isset($_POST['naimentovar'])){
	$nametovar=$_POST['naimentovar'];
}else{
	$nametovar='';
}
echo "<form class='form-inline'>";
echo '<select class="form-control" id="produkt-sklad-postavsik" value="'.$nametovar.'">';
$Qv=mysqli_query($dbm,'select DISTINCT PRODUKT FROM SKLAD ORDER BY PRODUKT');
while ($Rowv=mysqli_fetch_assoc($Qv)) {
	if ($Rowv['PRODUKT']==$nametovar){
	echo "<option selected>".$Rowv['PRODUKT']."</option>";
	}else{
		echo "<option>".$Rowv['PRODUKT']."</option>";
	}
}
echo '</select>';
echo "<span class='mr-2 ml-2'>Период: с </span>";
echo "<input type='text' id='datepicker' value=".$datestart.">";
echo "<span class='mr-2 ml-2'> по</span> ";
echo "<input type='text' id='datepicker2' value=".$datestop.">";
echo  "</form>";
?>
    <button class="btn btn-success" onclick='javascript:setperiod();return(false);'>Выбрать</button>
<span onclick="javascript:(print());" class="oi oi-print ml-2"></span>

</nav>
<table class="table table-bordered table-sm" id="tableall">
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
    
    $fbquery=mysqli_query($dbm,"SELECT DISTINCT PRODUKT FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$nametovar."'  GROUP BY PRODUKT");
    while ($fbrows=mysqli_fetch_assoc($fbquery)) {
    	echo "<tr>";
    	echo "<td>".$fbrows['PRODUKT']."</td>";
    $sklad=mysqli_query($dbm,"SELECT SUM(KOLVO) AS KOLVO FROM SKLAD WHERE PRODUKT='".$fbrows['PRODUKT']."'");
    $sklad_row=mysqli_fetch_assoc($sklad);
    echo "<td>".number_format($sklad_row['KOLVO'],2,",","")."</td>";
    $sklad_kolvo=mysqli_query($dbm,"SELECT SUM(KOLVO) AS KOLVO FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$nametovar."' AND DATA_POS >= '".$datestart."' AND DATA_POS <= '".$datestop."'");
    $sklad_kolvo_row=mysqli_fetch_assoc($sklad_kolvo);
    echo "<td>".number_format($sklad_kolvo_row['KOLVO'],2,",","")."</td>";
    	
    $colvo_rashod=mysqli_query($dbm,"SELECT SUM(KOLVO) AS KOLVO FROM RASHOD_PRODUKT WHERE PRODUKT='".$fbrows['PRODUKT']."' AND DATA_PROD >= '".$datestart."' AND DATA_PROD <= '".$datestop."'");
    $colwo_rashod_rows=mysqli_fetch_assoc($colvo_rashod);
    if ($colwo_rashod_rows != False){
    	echo "<td align='left'><span class='badge badge-info'>Итого: ".number_format($colwo_rashod_rows['KOLVO'],2,",","")."</span><ul class='list-group'>";
    	$produkciya=mysqli_query($dbm,"SELECT DISTINCT ID_PRODUKCIYA, SUM(KOLVO) AS KOLVO FROM RASHOD_PRODUKT WHERE PRODUKT='".$fbrows['PRODUKT']."' AND DATA_PROD >= '".$datestart."' AND DATA_PROD <= '".$datestop."' GROUP BY ID_PRODUKCIYA");
    	while ($produkciya_row=mysqli_fetch_assoc($produkciya)) {
    		$kolvo_sostav=mysqli_query($dbm,"SELECT KOLVO FROM SOSTAV WHERE ID_PRODUKCIYA='".$produkciya_row['ID_PRODUKCIYA']."' AND PRODUKT='".$fbrows['PRODUKT']."'");
    		$kolvo_sostav_row=mysqli_fetch_assoc($kolvo_sostav);
    		$prodazi=mysqli_query($dbm,"SELECT SUM(COLVO) AS KOLVO FROM PRODAZI WHERE PRODUKT='".$produkciya_row['ID_PRODUKCIYA']."' AND DATE_POK >= '".$datestart."' AND DATE_POK <= '".$datestop."'");
    		$prodazi_row=mysqli_fetch_assoc($prodazi);
    		echo "<li class='list-group-item>".$produkciya_row['ID_PRODUKCIYA']."- ".number_format($kolvo_sostav_row['KOLVO'],2,",","")." * ".$prodazi_row['KOLVO']." =".number_format($produkciya_row['KOLVO'],2,",","")."</li>";
    	}
    	echo "</ul></td>";
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
    $("#preload").css("display","block");
$.ajax({
	type:'POST',
	url:'otchet_pr.php',
	data:'datastart='+fd+'&datastop='+fdd+'&naimentovar='+$("#produkt-sklad-postavsik").val(),
	success: function (data){
	  $('.contenttab').html(data);
        $("#preload").css("display","none");
	}
	
});

}
</script>