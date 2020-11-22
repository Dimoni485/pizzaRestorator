
<style type="text/css">
.razdelitel{
height:130px;
}
</style>
<script type="text/javascript">
  $(function() {
$( "#datepicker" ).datepicker({dateFormat: "dd.mm.yy"});
$( "#datepicker2" ).datepicker({dateFormat: "dd.mm.yy"});
  });
</script>
<?php 
date_default_timezone_set("Europe/Moscow");
$datestart=$_POST['datastart'];
if (!isset($_POST['datastop'])){
	$datestop=date("d.m.Y");
}else{
	$datestop=$_POST['datastop'];
}
require_once("../connect.php");
function link_bar($page, $pages_count)
{
	for ($j = 1; $j <= $pages_count; $j++)
	{
		// ����� ������
		if ($j == $page) {
			echo ' <a><b>'.$j.'</b></a> ';
		} else {
			echo ' <a href="javascript:alert(\'\');">'.$j.'</a> ';
		}
		// ������� ����������� ����� ������, ����� ���������
		// ��������, �������� "|" ����� ��������
		if ($j != $pages_count) echo ' ';
	}
	return true;
}
//****************
if (empty(@$_GET['page']) || ($_GET['page'] <= 0)) {
	$page = 1;
} else {
	$page = (int) $_GET['page']; // ���������� ������� ��������
}
//***********
$perpage = 10;
if (empty(@$_GET['page']) || ($_GET['page'] <= 0)) {
	$page = 1;
} else {
	$page = (int) $_GET['page']; // ���������� ������� ��������
}
// ����� ���������� ����������
$fbcount = ibase_query("select * from PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");
$count=1;
while (ibase_fetch_row($fbcount)){
$count++;
}
if (isset($count)){
$pages_count = ceil($count / $perpage); // ���������� �������
}else{
	$pages_count =0;
}
// ���� ����� �������� �������� ������ ���������� �������
if ($page > $pages_count) $page = $pages_count;
$start_pos = ($page - 1) * $perpage; // ��������� �������, ��� ������� � ��

// ����� �������, ��� ������ ������ �� �����
//link_bar($page, $pages_count);
?>
<div class="razdelitel">
<?php

$Qz=ibase_query("select SUM(ITOGO) AS SUMMAITOGO FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."')");
while ($Rowz=ibase_fetch_assoc($Qz)) {
echo "�����: ".number_format($Rowz['SUMMAITOGO'],3,"."," ").'�.';
}
echo "<hr>";
echo "������: � ";
echo "<input type='text' id='datepicker' value=".$datestart.">";
echo " �� ";
echo "<input type='text' id='datepicker2' onchange='javascript:setperiod()' value=".$datestop.">";
?>
<hr>
<a href="#" onclick="javascript:setdateday()" class="green">�������</a>
<a href="#" onclick="javascript:setdateweek()" class="green">������</a>
<a href="#" onclick="javascript:setdatemon()" class="green">�����</a>
<a href="#" onclick="javascript:setdateyear()" class="green">���</a>
<script type="text/javascript">
function setdateweek()
{
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
var datenow = new Date();
var daynow = datenow.getDate()-7;
if (daynow <=0)
{
 daynow=1; 
}
fd=(daynow)+'.'+(datenow.getMonth()+1)+'.'+datenow.getFullYear();

$.ajax({
	type:'POST',
	url:'/prodazi/prodazi.php',
	data:'datastart='+fd,
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

}
function setdatemon()
{
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
var datenow = new Date();
fd='01.'+(datenow.getMonth()+1)+'.'+datenow.getFullYear();
$.ajax({
	type:'POST',
	url:'/prodazi/prodazi.php',
	data:'datastart='+fd,
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

}
function setdateday()
{
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
var datenow = new Date();
fd=(datenow.getDate())+'.'+(datenow.getMonth()+1)+'.'+datenow.getFullYear();
$.ajax({
	type:'POST',
	url:'/prodazi/prodazi.php',
	data:'datastart='+fd,
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

}
function setperiod()
{
fd=$("#datepicker").val();
fdd=$("#datepicker2").val();
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$.ajax({
	type:'POST',
	url:'/prodazi/prodazi.php',
	data:'datastart='+fd+'&datastop='+fdd,
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

}
function setdateyear()
{
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
var datenow = new Date();
fd='01.'+'01.'+(datenow.getFullYear()-1);
$.ajax({
	type:'POST',
	url:'/prodazi/prodazi.php',
	data:'datastart='+fd,
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
	
});

}
function vozvrat($idprodukt,$kolvoprod,$idprod)
{
if (confirm("������� ������� ����� ������� ���������� ������ "+$idprodukt+" ? ")){
  $.ajax({
	type: 'POST',
	url:'/prodazi/vozvrat.php',
	data:'idprodukt='+$idprodukt+'&kolvoprod='+$kolvoprod+'&idprod='+$idprod,
	success: function (data){
		$.ajax({
			type: 'POST',
			url: '/prodazi/prodazi.php',
			data: 'datastart='+$('#datepicker').val()+'&datastop='+$('#datepicker2').val(),
			success: function (data){
				$('.contenttab').html(data);
			}	
	
	});
	}
	});
}
}

</script>

</div>
<div class="prodazicont">
<table  class="tableall" id="example1" >
<thead>
<tr class="zagolovok"> 
<th>� ����</th><th>���������</th><th>����</th><th>���-��</th><th>�����</th><th>����</th><th>�����</th><th>�������</th>
</tr>
</thead>
<tbody>
<?php
//header('Content-type: text/html; charset=windows-1251');
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("../connect.php");
$Q=ibase_query("select * FROM PRODAZI WHERE (DATE_POK >= '".$datestart."')AND(DATE_POK <='".$datestop."') ORDER BY ID, DATE_POK");
$collsum=0;
$idrow=0;
while ($Row=ibase_fetch_assoc($Q)) {

if ($Row['ID']==$idrow)
{
  $collsum=$collsum+1;
}else
{
$collsum=1;
echo "<tr>";
echo "<td colspan=8 style='background:#DEE0C8;font-size:1.5em;'>";
echo "��� � ".$Row['ID'].", ����� �� ����: ";
require_once("../connect.php");
$sch=ibase_query("SELECT SUM(ITOGO) AS ITOGSUM FROM PRODAZI WHERE ID='".$Row['ID']."'");
while ($Rowsch=ibase_fetch_assoc($sch)){
echo number_format($Rowsch['ITOGSUM'],3,'.',' ')."�.";
$dostavka_query=ibase_query("SELECT SUMMA FROM DOSTAVKA WHERE ID_CEK='".$Row['ID']."'");
$dostavka=ibase_fetch_row($dostavka_query);
if ($dostavka[0] > 0){
	echo "+ �������� ".$dostavka[0]."�. <a class='dos_but' title='������ ��������' href='#' onclick='javascript:deldostavka(\"".$Row['ID']."\");return false;'><img src='/images/rem_dos.png'></a>";
}else{
	echo "<a class='dos_but' href='#' title='�������� ��������' onclick='javascript:addostavka(\"".$Row['ID']."\",\"".$Row['DATE_POK']."\");return false;'><img src='/images/add_dos.png'></a>";
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
echo number_format($Row['CENA'],3,'.',' ').'�.';	
echo "</td>";
echo "<td>";
echo $Row['COLVO'];	
echo "</td>";
echo "<td>";
echo number_format($Row['ITOGO'],3,'.',' ').'�.';	
echo "</td>";
echo "<td>";
echo $Row['DATE_POK'];	
echo "</td>";
echo "<td>";
echo $Row['TIME_POK'];	
echo "</td>";
echo "<td>";
echo "<a href='#' onclick='vozvrat(\"".$Row['PRODUKT']."\",\"".$Row['COLVO']."\",\"".$Row['ID']."\");return(false);'><img src='/images/vozvrat.png' white='20px' height=20px></a>";	
echo "</td>";
echo "</tr>";

}
?>
</tboby>
</table>
</div>
<script>
function addostavka($iddostavka, $datedostavka){
	document.getElementById('preloaderbg').style.display = 'block';
	document.body.style.overflow = 'hidden';
	$.ajax({
		type: 'POST',
		url:'/prodazi/addostavka.php',
		data:'iddostavka='+$iddostavka+'&datedostavka='+$datedostavka,
		cache: false,
		success: function (data){
			$.ajax({
				type: 'POST',
				url: '/prodazi/prodazi.php',
				data: 'datastart='+$('#datepicker').val()+'&datastop='+$('#datepicker2').val(),
				success: function (data){
					$('.contenttab').html(data);
				}	
		
		});
		}
		});
	document.getElementById('preloaderbg').style.display = 'none';
	document.body.style.overflow = 'visible';
	return false;
}
function deldostavka($iddostavka){
	document.getElementById('preloaderbg').style.display = 'block';
	document.body.style.overflow = 'hidden';
	$.ajax({
		type: 'POST',
		url:'/prodazi/deldostavka.php',
		data:'iddostavka='+$iddostavka,
		success: function (data){
			$.ajax({
				type: 'POST',
				url: '/prodazi/prodazi.php',
				data: 'datastart='+$('#datepicker').val()+'&datastop='+$('#datepicker2').val(),
				success: function (data){
					$('.contenttab').html(data);
				}	
		
		});
		}
		});
	document.getElementById('preloaderbg').style.display = 'none';
	document.body.style.overflow = 'visible';
	return false;
}
</script>
