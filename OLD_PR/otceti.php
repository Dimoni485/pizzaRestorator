<div class="otchetistr">
<ul>
<li><a href="#" onclick="javascript:loadotchet();">������ �� ��������� �� ������</a><br>
<li><a href="#" onclick="javascript:prodaza_produkciya();">����� �� �������� ���������</a><br>
<li><a href="#" onclick="javascript:otchet_pr();">�����</a>
</ul>
</div>
<div class='no_cena'>�������� ��������� � ������������ ������ .... ���������...</div>
<script>
function loadotchet()
{
$('a').css('background-color','');
$('a:contains(������)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
	url:'otchet.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function otchet_pr()
{
$('a').css('background-color','');
$('a:contains(������)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
	url:'otchet_pr.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
function prodaza_produkciya()
{
$('a').css('background-color','');
$('a:contains(������)').css('background-color','#A2C2CE');
document.getElementById('preloaderbg').style.display = 'block';
    document.body.style.overflow = 'hidden';
$.ajax({
	url:'prodaza_produkciya.php',
	success: function (data){
	  $('.contenttab').html(data);
document.getElementById('preloaderbg').style.display = 'none';
document.body.style.overflow = 'visible';
	}
});
};
</script>
<script type="text/javascript">
    $(function(){
        $.ajax({
            url:'no_cena.php',
            success:function (data){
                $('.no_cena').html(data);

            }
        });
        return false;
    });
</script>