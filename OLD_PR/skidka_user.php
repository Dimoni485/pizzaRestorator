<?php
header('Content-type: text/html; charset=windows-1251');
?>
<style type="text/css">
.razdelitel{
height:80px;

}
</style>
<style type="text/css">
#window{
height:400px;
}
</style>
<div class="razdelitel">
<a href="#" class="green" onclick="show('block')" id="">��������</a>
</div>
<table class="tableall">
<tr class="zagolovok"> 
<th>���</th><th>������ %</th><th>�������</th><th>�����</th><th></th>
</tr>

<?php
require_once('connect.php');
$Q=ibase_query('select * FROM KLIENT ORDER BY FIO');
$maxprocent=0;
while ($Row=ibase_fetch_assoc($Q)) {
echo "<tr>";
echo "<td>".$Row['FIO']."</td>";
echo "<td>".$Row['SKIDKA']."%</td>";
echo "<td>".$Row['TELEPHONE']."</td>";
echo "<td>".$Row['ADRES']."</td>";
echo "<td><a href='#' onclick='deleteskidka_user(\"".$Row['ID']."\")'><img src='error.png' width='25px' height='25px' alt='�������'></a></td>";
echo "</tr>";
}
?>
</table>
<div onclick="show('none')" id="wrap"></div>
<!-- ���� ����-->
<div id="window" align='right'>		
 <!-- �������� ��������-->
<img class="close" onclick="show('none')" src="erase.png">
<br><br>
�������� ������
<hr>
<label for="fio">���:<input type="text" value="" id="fio"></label><br>

<label for="skidka">������ %:<input type="text" value="" id="skidka"></label><br>
<label for="telefon">�������:<input type="text" value="" id="telefon"></label><br>
<label for="adress">�����<input type="text" value="" id="adress"></label><br>
<a href="#" class="green" onclick="javascript:addskidka_user()">��������</a>
<a href="#" class="green" onclick="show('none')">������</a>

</div>

<script type="text/javascript">
function addskidka_user()
{
 $.ajax({
type:'POST',
url:'addskidka_user.php',
data:"fio="+$('#fio').val()+"&skidka="+$('#skidka').val()+"&telefon="+$('#telefon').val()+"&adress="+$('#adress').val(),
success:function ()
{
  loadskidka_user();
}
});
}
function deleteskidka_user($idskidka)
{
  $.ajax({
type:'POST',
url:'deleteskidka_user.php',
data:"idskidka="+$idskidka,
success:function ()
{
  loadskidka_user();
}
});
}
</script>