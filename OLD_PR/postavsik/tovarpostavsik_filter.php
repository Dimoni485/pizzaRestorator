<style type="text/css">
.razdelitel{
height:100px;
}
</style>
<div class="razdelitel">
<select id="produkt-sklad-postavsik">
<?php
require_once("../connect.php");
$Qv=mysqli_query($dbm,'select DISTINCT PRODUKT FROM SKLAD ORDER BY PRODUKT');
while ($Rowv=mysqli_fetch_assoc($Qv)) {
echo "<option>".$Rowv['PRODUKT']."</option>";
}

?>
</select>
 <a href="#" id="filter_b" class="">������</a>
<a href="#" class="green" onclick="javascript:alltovar()">�������� ���</a>
</div>
<table class="tableall">
<tr class="zagolovok"> 
<th rowspan="2">� �����</th><th rowspan="2">�����</th><!--<th rowspan="2">��. ��</th>--><th colspan="2" style="background:#DEE0C8;">������</th><th colspan="2" style="background:#E1D4D4;">�����</th><th rowspan="2">�����</th><th rowspan="2">���������</th><th rowspan="2">���� ��������</th><th rowspan="2">�������</th>
</tr>
<tr class="zagolovok"> 
<th style="background:#DEE0C8;">���</th><th style="background:#DEE0C8;">����</th><!--<th style="background:#DEE0C8;">�����</th>--><th style="background:#E1D4D4;">���</th><th style="background:#E1D4D4;">����</th>
</tr>
<?php

require_once("../connect.php");
$produktnaimen=$_POST['naimentovar'];

$Q=mysqli_query($dbm,"select * FROM TOVAR_POSTAVSIK WHERE PRODUKT='".$produktnaimen."' ORDER BY DATA_POS DESC");
$alfo=0;
$prodrow=0;
while ($Row=mysqli_fetch_assoc($Q)) {

if ($Row['PRODUKT']{0}==$prodrow)
{
  $alfo=$alfo+1;
}else
{
$alfo=1;
echo "<tr class='alfavit'>";
echo "<td colspan=10 align='left'>";
echo $Row['PRODUKT']{0};
echo "</td>";
echo "</tr>";
}
$prodrow=$Row['PRODUKT']{0};

echo "<tr class='rowstab'>";
echo "<td>";

echo  $Row['NUM_SCET'];
echo "</td>";
echo "<td>";
echo  $Row['PRODUKT'];
echo "</td>";
//echo "<td>";
//echo  $Row['ED_IZ'];
//echo "</td>";
echo "<td style='background:#DEE0C8;'>";
echo  Round($Row['KOLVO_BRUTTO'],3).$Row['ED_IZ'];
echo "</td>";
echo "<td style='background:#DEE0C8;'>";
echo  Round($Row['CENA_BRUTTO'],3)."�.";
echo "</td>";
/*echo "<td style='background:#DEE0C8;'>";
echo  $itogo=Round($Row['CENA_BRUTTO'] * $Row['KOLVO_BRUTTO'],2)."�.";
echo "</td>";*/
echo "<td style='background:#E1D4D4;'>";
echo  Round($Row['KOLVO'],3).$Row['ED_IZ'];
echo "</td>";
echo "<td style='background:#E1D4D4;'>";
if ($Row['KOLVO']!=null)
{
$cena=Round(($Row['KOLVO_BRUTTO']*$Row['CENA_BRUTTO'])/$Row['KOLVO'],3)."�.";
echo  $cena; 
}
echo "</td>";
echo "<td>";
echo  $itogonetto=Round($Row['KOLVO']*$cena,3)."�.";
echo "</td>";
echo "<td>";
echo  $Row['POSTAVSIK_NAME'];
echo "</td>";
echo "<td>";
echo  date('Y.m.d', strtotime($Row['DATA_POS']));
echo "</td>";
echo "<td>";
echo "<a onclick='javascript:deltovarp(".$Row['ID'].");return(false);' href='#'><img src='/images/erase.png' width='20px' height='20px' alt='�������'></a>";
echo "</td>";
echo "</tr>";
}

?>
</table>
<script>
function alltovar()
{
  $.ajax({
type:'POST',
url:'/postavsik/tovarpostavsik.php',
success: function (data){
	  $('.contenttab').html(data);
}
});
}
$("#produkt-sklad-postavsik").chosen();
$("#filter_b").click(function ()
{
$.ajax({
type:'POST',
url:'/postavsik/tovarpostavsik_filter.php',
data: 'naimentovar='+$("#produkt-sklad-postavsik").val(),
success: function (data){
	  $('.contenttab').html(data);
}
});
});
function deltovarp($tovarname){
if (confirm("������� ������ ?")){
  $.ajax({
	type:'POST',
	url:'/postavsik/deltovarp.php',
	data: 'tovarname='+$tovarname,
	success:function ()
	{
	 loadtovarpostavsik(); 
	}
});
}
}
</script>