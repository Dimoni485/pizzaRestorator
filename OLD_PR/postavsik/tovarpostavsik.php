<div class="razdelitel">
<select id="produkt-sklad-postavsik">
<?php
require_once("../connect.php");
$Qv=ibase_query('select DISTINCT PRODUKT FROM SKLAD ORDER BY PRODUKT');
while ($Rowv=ibase_fetch_assoc($Qv)) {
echo "<option>".$Rowv['PRODUKT']."</option>";
}
ibase_free_result ($Qv);
ibase_close ($dbh);
?>
</select> <a href="#" id="filter_b" class="">������</a>
</div>
<table class="tableall">
<tr class="zagolovok"> 
<th rowspan="2">� �����</th><th rowspan="2">�����</th><!--<th rowspan="2">��. ��</th>--><th colspan="2" style="background:#DEE0C8;">������</th><th colspan="2" style="background:#E1D4D4;">�����</th><th rowspan="2">�����</th><th rowspan="2">���������</th><th rowspan="2">���� ��������</th><th rowspan="2">�������</th>
</tr>
<tr class="zagolovok"> 
<th style="background:#DEE0C8;">���</th><th style="background:#DEE0C8;">����</th><!--<th style="background:#DEE0C8;">�����</th>--><th style="background:#E1D4D4;">���</th><th style="background:#E1D4D4;">����</th>
</tr>
<?php

//header('Content-type: text/html; charset=windows-1251');
//$dbh = ibase_connect ('81.20.106.127:/home/vmz/BASE.gdb', 'sysdba', 'masterkey');
//$dbh = ibase_connect ('localhost:C:\rest\BASE.gdb', 'sysdba', 'masterkey');
require_once("../connect.php");
//$Q = ibase_query ('select P.PRODUKT, P.KATEGORIYA, P.CENA, P.ID_SOSTAV from PRODUKCIYA P, SOSTAV S WHERE P.ID_SOSTAV=S.ID_PRODUKCIYA');
$produkt_data=ibase_query('select FIRST 7 DISTINCT DATA_POS FROM TOVAR_POSTAVSIK ORDER BY DATA_POS DESC');
while ($Row_produkt_date=ibase_fetch_assoc($produkt_data)){
echo "<tr>";
echo "<td colspan=10 style='background:#DEE0EF';>";
echo "���� ��������: ".date('d.m.Y', strtotime($Row_produkt_date['DATA_POS']));
echo "</td>";
echo "</tr>";
$Q=ibase_query("select * FROM TOVAR_POSTAVSIK WHERE DATA_POS='".$Row_produkt_date['DATA_POS']."' ORDER BY PRODUKT ");
$alfo=0;
$prodrow=0;
while ($Row=ibase_fetch_assoc($Q)) {
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

echo date('d.m.Y', strtotime($Row['DATA_POS']));
echo "</td>";
echo "<td>";
echo "<a onclick='javascript:deltovarp(".$Row['ID'].");return(false);' href='#'><img src='/images/error.png' width='25px' height='25px' alt='�������'></a>";
echo "</td>";
echo "</tr>";
}
}
ibase_close ($dbh);
?>
</table>
<script>
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