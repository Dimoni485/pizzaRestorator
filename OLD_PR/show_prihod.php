<div class='razdelitel'>
��������� ���������c�� ����������� ������.
</div>
<table class="tableall">
<thead>
<th>������������</th><th>����������</th><th>����</th><th>�������</th>
</thead>
<?php
header('Content-type: text/html; charset=windows-1251');
require_once("connect.php");
$Qtmp=ibase_query('select * FROM TOVAR_POSTAVSIK_TMP ORDER BY PRODUKT');
while ($Rowtmp=ibase_fetch_assoc($Qtmp)) {
echo "<tr>";
echo "<td>".$Rowtmp['PRODUKT']."</td>";
echo "<td>".$Rowtmp['KOLVO_BRUTTO']."</td>";
echo "<td>".$Rowtmp['CENA_BRUTTO']."</td>";
echo '<td> <a href="#" onclick="javascript:del_prihod(\''.$Rowtmp['ID'].'\')">�������</td>';
echo "</tr>";
}
?>
</table>
<a class='green' id='vig_na_sklad' onclick="javascript:addsklad();return(false);" href="#" >��������� �� �����</a>
<a class='green' id='izm_data' onclick="javascript:add_sklad('none');return(false);" href="#" >�������� ������</a>
<div id='info_text'></div>
<script type="text/javascript">
function del_prihod($idprihod_tovar)
{
  $.ajax({
type:'POST',
url:'deltovar.php',
data:"tovarname="+$idprihod_tovar,
success:function(html)
{
  add_sklad('block');
}
});
}
</script>