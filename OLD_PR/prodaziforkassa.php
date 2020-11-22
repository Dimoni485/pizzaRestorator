<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Последняя компиляция и сжатый CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/css/material-design-iconic-font.min.css" >

    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" media="all">
    <!--<script src="/js/jquery-1.12.4.min.js"></script>-->
    <!--<script type="text/javascript" src="/js/jquery-ui.js"></script>-->
    <script
            src="js/jquery-1.12.4.min.js"
    </script>

    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/messages/messages.ru-ru.js" type="text/javascript"></script>
    <!--<script type="text/javascript" src="/js/chosen.jquery.js"></script>
    <script type="text/javascript" src="/js/jquery.floatThead.js"></script>
    <script type="text/javascript" src="/js/jquery.floatThead-slim.js"></script>
    <script type="text/javascript" src="/js/fixheader.js"></script>-->
    <script type="text/javascript" src="/js/pizzerria.js"></script >
    <!--<link rel="stylesheet" type="text/css" href="/css/style.css" media="all">

    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.theme.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.structure.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/chosen.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/print.css" media="print">-->


    <title>
        Pizzeria WEB 3.0
    </title>
</head>
<body>
<?php
//require_once ("header.php");
require_once("connect.php");
ob_start();
?>

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



?>
<div class="navbar">

<?php

$Qz=mysqli_query($dbm,"select SUM(ITOGO) AS SUMMAITOGO FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");
while ($Rowz=mysqli_fetch_assoc($Qz)) {
echo "<h1>Итого: ".number_format($Rowz['SUMMAITOGO'],3,"."," ").'р.</h1>';
}

?>

</div>
<script type="text/javascript">
    $('#set_per').click(function ()
    {
        $fs=$("#datepicker").val();
        $fss=$("#datepicker2").val();
        $(location).attr('href','/prodazi/index.php?datastart=' +  $fs + '&datastop=' + $fss);
    });
function setdateweek()
{
var datenow = new Date();
var daynow = datenow.getDate()-7;
if (daynow <=0)
{
 daynow=1; 
}
$fd=datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-'+(daynow);

    $(location).attr('href','/prodazi/index.php?datastart=' +  $fd);

}
function setdatemon()
{
var datenow = new Date();
$fd=datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-01';
    $(location).attr('href','/prodazi/index.php?datastart=' +  $fd);

}
function setdateday()
{
var datenow = new Date();
$fd=datenow.getFullYear()+'-'+(datenow.getMonth()+1)+'-'+(datenow.getDate());
    $(location).attr('href','/prodazi/index.php?datastart=' +  $fd);

}



function setdateyear()
{
var datenow = new Date();
$fd=(datenow.getFullYear()-1)+'-01-'+'01';
    $(location).attr('href','/prodazi/index.php?datastart=' +  $fd);

}
function vozvrat($idprodukt,$kolvoprod,$idprod)
{
if (confirm("Сделать возврат одной еденицы проданного товара "+$idprodukt+" ? ")){
  $.ajax({
	type: 'POST',
	url:'/prodazi/vozvrat.php',
	data:'idprodukt='+$idprodukt+'&kolvoprod='+$kolvoprod+'&idprod='+$idprod,
	success: function (data){
		location.reload();
		return false;
	}
	});
}
}

</script>


<div class="prodazicont">
<table  class="table table-hover table-sm" style="font-size: 14px;" id="example1" >
<thead>
<tr class="zagolovok"> 
<th>№ Чека</th><th>Номенклатура</th><th>Цена</th><th>Кол-во</th><th>Итого</th><th>Дата</th><th>Время</th>
</tr>
</thead>
<tbody>
<?php
require_once("connect.php");
$Q=mysqli_query($dbm,"select * FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."') ORDER BY ID, DATE_POK");
$collsum=0;
$idrow=0;
while ($Row=mysqli_fetch_assoc($Q)) {

if ($Row['ID']==$idrow)
{
  $collsum=$collsum+1;
}else
{
$collsum=1;
echo "<tr>";
echo "<td colspan=8 style='background:#DEE0C8;font-size:1.3em;'>";
echo "Чек № ".$Row['ID'].", Сумма по чеку: ";
require_once("connect.php");
$sch=mysqli_query($dbm,"SELECT SUM(ITOGO) AS ITOGSUM FROM PRODAZI WHERE ID='".$Row['ID']."'");
while ($Rowsch=mysqli_fetch_assoc($sch)){
echo number_format($Rowsch['ITOGSUM'],3,'.',' ')."р.";
$dostavka_query=mysqli_query($dbm,"SELECT SUMMA FROM DOSTAVKA WHERE ID_CEK='".$Row['ID']."'");
$dostavka=mysqli_fetch_row($dostavka_query);
if ($dostavka[0] > 0){
	echo "+ доставка ".$dostavka[0]."р. <a class='dos_but' title='Убрать доставку' href='#' onclick='javascript:deldostavka(\"".$Row['ID']."\");return false;'><img src='/images/rem_dos.png'></a>";
}else{
	echo "<a class='dos_but' href='#' title='Добавить доставку' onclick='javascript:addostavka(\"".$Row['ID']."\",\"".$Row['DATE_POK']."\");return false;'><img src='/images/add_dos.png'></a>";
}
}
echo "</td>";
echo "</tr>";
}
$idrow=$Row['ID'];
echo "<tr>";
echo "<td>";
echo $Row['ID'];	
echo "</td>";
echo "<td>";
echo $Row['PRODUKT'];	
echo "</td>";
echo "<td>";
echo number_format($Row['CENA'],3,'.',' ').'р.';	
echo "</td>";
echo "<td>";
echo $Row['COLVO'];	
echo "</td>";
echo "<td>";
echo number_format($Row['ITOGO'],3,'.',' ').'р.';	
echo "</td>";
echo "<td>";
echo $Row['DATE_POK'];	
echo "</td>";
echo "<td>";
echo $Row['TIME_POK'];	
echo "</td>";

echo "</tr>";

}
?>
</tbody>
</table>
</div>
<script>
function addostavka($iddostavka, $datedostavka){
	$.ajax({
		type: 'POST',
		url:'/prodazi/addostavka.php',
		data:'iddostavka='+$iddostavka+'&datedostavka='+$datedostavka,
		cache: false,
		success: function (data){
			location.reload();
			return false;
		}
		});
	return false;
}
function deldostavka($iddostavka){
	$.ajax({
		type: 'POST',
		url:'/prodazi/deldostavka.php',
		data:'iddostavka='+$iddostavka,
		success: function (data){
            location.reload();
		}
		});
	return false;
}
</script>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="/js/bootstrap.min.js"> </script>
<script src="/js/bootstrap.bundle.min.js"> </script>

</html>