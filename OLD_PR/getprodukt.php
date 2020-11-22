<?php
header('Content-type: text/html; charset=windows-1251');
require_once("connect.php");
$dws=ibase_query("SELECT * FROM SKLAD");
while ($Rowdw=ibase_fetch_assoc($dws)){
if ($Rowdw['KOLVO'] > 0){
	ibase_query("UPDATE SOSTAV A SET 
			SUMMA=KOLVO*(SELECT FIRST 1 CENA 
			FROM SKLAD B 
			WHERE B.PRODUKT=A.PRODUKT ORDER BY ID) WHERE PRODUKT='".$Rowdw['PRODUKT']."'");
}else{
	ibase_query("UPDATE SOSTAV A 
			SET SUMMA=KOLVO*(SELECT FIRST 1 CENA 
			FROM SKLAD B 
			WHERE B.PRODUKT=A.PRODUKT ORDER BY ID DESC) WHERE PRODUKT='".$Rowdw['PRODUKT']."'");
}
}
ibase_commit();
/*$dws=ibase_query('SELECT A.PRODUKT, (SELECT FIRST 1 CENA FROM TOVAR_POSTAVSIK B WHERE B.PRODUKT=A.PRODUKT AND OSTATOK > 0) AS CENA FROM SKLAD A ORDER BY PRODUKT');
$cena_max=0;
while ($Rowdw=ibase_fetch_assoc($dws)){
require_once("connect.php");
$cena_max=$Rowdw['CENA'];
$cena_max=Round($cena_max,3);
$produkt_g=$Rowdw['PRODUKT'];
ibase_query("UPDATE SOSTAV SET SUMMA=KOLVO*".$cena_max." WHERE PRODUKT='".$produkt_g."'");
}
ibase_commit();*/
?>
<style type="text/css">
.razdelitel{
height:60px;
}
.sr_nacenka{
text-align:center;
}
</style>
<div class="razdelitel">
<div style="" class="sr_nacenka">
Средняя наценка:
<?php 
if (!isset($sr_nacenka)){
$sr_nacenka=0;
echo $sr_nacenka;
}else{
echo $sr_nacenka;
}
/*if (isset($nacenkasred)){
echo $nacenkasred; }*/
$x=0;
?>
</div>
<!--<input type="text" value="Найти..." id="" class="searchinput"><br>-->
<a href="#" class="add_button" id="addprodbut" title="Добавить"></a><a href="#" onclick="loadprodukt();return(false);" class="reload_button" id="obnovit" title="Обновить"></a>
</div>

<table class="tableall" id="tableall">
<thead>
<tr class="zagolovok"> 
<th>Наименование</th><th>Категория</th><th>Себест.</th><th>Цена</th><th>Наценка</th><th>Состав</th><th>Ред-ть</th><th>Удалить</th>
</tr></thead>
<?php
header('Content-type: text/html; charset=windows-1251');
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
//require_once("connect.php");
//запрос продукция
$Q=ibase_query('select * FROM PRODUKCIYA ORDER BY KATEGORIYA,PRODUKT');
$idrow="";
while ($Row=ibase_fetch_assoc($Q)) {

if ($Row['KATEGORIYA']==$idrow)
{
  
}else
{

echo "<tr>";
echo "<td colspan=8 style='background:#DEE0C8;font-size:1.5em;'>";
echo $Row['KATEGORIYA'];
echo "</td>";
echo "</tr>";
}
$idrow=$Row['KATEGORIYA'];

echo "<tr class='rowstab'>";
echo "<td>";
echo  $Row['PRODUKT'];
echo "</td>";
echo "<td>";
echo  $Row['KATEGORIYA'];
echo "</td>";
echo "<td align=right>";
//$dbc = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
//require_once("connect.php");
$Qi=ibase_query("SELECT SUM(SUMMA) AS SUMMA FROM SOSTAV WHERE ID_PRODUKCIYA='".$Row['ID_SOSTAV']."'");
//$kolvo_zap=ibase_fetch_row($Q);
while ($Rowi=ibase_fetch_assoc($Qi)) {
if ($Rowi['SUMMA'] <> 0){
echo number_format($Rowi['SUMMA'],3,'.',' ').'р.';
}else{
echo 0;
}

echo "</td>";
echo "<td align=right>";
echo  number_format($Row['CENA'],3,'.',' ').'р.' ;
echo "</td>";
echo "<td align=right>";
if ($Rowi['SUMMA']<>0){
$nacenka=number_format(((($Row['CENA']-$Rowi['SUMMA'])/$Rowi['SUMMA'])*100),3,'.',' ');
}else
{
$nacenka=0;

}
echo  $nacenka.'%';
$sr_nacenka=$sr_nacenka+$nacenka;
++$x;
echo "<script>$('.sr_nacenka').text('Средняя наценка: ".number_format($sr_nacenka/$x,3,'.',' ')."%');</script>";
}
echo "</td>";
echo "<td>";
//$prd=iconv('UTF-8', 'Windows-1251',$Row['PRODP']);
echo  '<a href="javascript:getsostav(\''.$Row['PRODUKT'].'\',\''.$nacenka.'\',\''.$Row['CENA'].'\');"><img src="list.png" width="25px" height="25px" alt="Состав"></a>';
echo "</td>";
echo "<td>";
echo '<a href="javascript:editprodukt(\''.$Row['PRODUKT'].'\',\''.$Row['KATEGORIYA'].'\',\''.$Row['CENA'].'\',\''.$Row['ID'].'\',\''.$Row['ID_SOSTAV'].'\');" ><img src="pen.png" width="25px" height="25px" alt=""></a>';
echo "</td>";
echo "<td>";
echo '<a href=# onclick="javascript:del_tovar(\''.$Row['ID'].'\');return(false);"> <img src="error.png" width="25px" height="25px" alt="Удалить"> </a>';
echo "</td>";
echo "</tr>";
}
//echo '</table>';
$produ=$Row['PRODUKT'];

ibase_free_result ($Q);
ibase_free_result ($Qi);
ibase_close ($dbh);
?>
</table>


<div class="addprod"  align="right">
Добавление продукции
<hr><br>
Продукт:<input type="text" value="" id="addproduktname"><br><br>
Категория:<select id="addproduktkat">
<?php
require_once("connect.php");
$qq=ibase_query("SELECT * FROM KATEGORII ORDER BY KAT");
while ($Rowd=ibase_fetch_assoc($qq)){
  echo "<option>".$Rowd['KAT']."</option>";
}
?>
</select><br><br>
Цена:<input type="text" value="" id="addproduktcena"><br><br>
<a onclick="javascript:addprodukt()" href="#" class="green">Добавить</a><a href="#" class="green" id="closeaddprodbut">Отмена</a>
</div>

<div id="wraps">
<div class="getsost">

</div>
</div>
<div class="editprodu">

</div>

  <style>
  .addprod{
    		width: 500px;
		height: 250px;
		margin: 50px auto;
		display: none;
		background: #fff;
		z-index: 200;
		position: fixed;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		padding: 16px;
		border-radius:4px 4px 4px 4px;
		font-family:arial;
		background-color:#F3EEEE;
		color:#3E3D3D;
box-shadow: 0.4em 0.4em 5px rgba(122,122,122,0.5);
  	}
  .getsost{
		overflow:auto;
width:800px;
		min-height: 50px;
		margin: 50px auto;
		display: none;
		background: #fff;
		z-index: 500;
		position: fixed;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		//padding: 16px;
		border-radius:4px 4px 4px 4px;
		font-family:arial;
		background-color:#F3EEEE;
		color:#3E3D3D;
  	}
.editprodu{
		overflow:auto;
width:450px;
		height: 250px;
		margin: 50px auto;
		display: none;
		background: #fff;
		z-index: 500;
		position: fixed;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		//padding: 16px;
		border-radius:4px 4px 4px 4px;
		font-family:arial;
		background-color:#F3EEEE;
		color:#3E3D3D;
  	}
  </style>
<script type="text/javascript">
$('#closeaddprodbut').click(function ()
{
  $(".addprod").hide();
  $("#wraps").hide();
}
);
$('#addprodbut').click(function ()
{
	$("#wraps").show();
  $(".addprod").show();
}
);
function addprodukt()
{
$addproduktcena=$("#addproduktcena").val();
$addproduktcena=$addproduktcena.replace(",",".");
  $.ajax({
type:'POST',
url:'addprodukt.php',
data:'nameprodukt='+$("#addproduktname").val()+'&katprodukt='+$("#addproduktkat").val()+'&cenaprodukt='+$addproduktcena,
success: function ()
{
  loadprodukt();
}
});
}
function getsostav($idprod,$nacenka,$sebest){
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
  $.ajax({
	type: "POST",
	url: "getsostav.php",
	data: "naimenprodukt="+$idprod+"&sebest="+$sebest+"&nacenka="+$nacenka,
	success: function(html){  
        $(".getsost").html(html);  
document.getElementById('preloaderbg').style.display = 'none';
//document.body.style.overflow = 'visible';
	}
});
//document.body.style.overflow = 'hidden';
$(".getsost").show();
$("#wraps").show();

}
function editprodukt($naimenprod, $kat, $cena, $idprodukt,$idsostav){
document.getElementById('preloaderbg').style.display = 'block';
document.body.style.overflow = 'hidden';
$cena=$cena.replace(",",".");
$.ajax({
	type:'POST',
	url:'editprodukt.php',
	data: "naimenprod="+$naimenprod+"&kat="+$kat+"&cena="+$cena+"&idprodukt="+$idprodukt+"&idsostav="+$idsostav,
	success: function(html){  
        $(".editprodu").html(html);  
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}

});
$(".editprodu").show();
$("#wraps").show();
}
function del_tovar($id_produkt)
{
if (confirm("Удалить запись ?")){
  $.ajax({
type:'POST',
url:'delprodukt.php',
data: "idprodukt="+$id_produkt,
success:function(html)
{
  loadprodukt();
}

});
}
}
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';

</script>
<script type="text/javascript">
/*<![CDATA[*/
fix_header.fix('tableall');
/*]]>*/
</script>