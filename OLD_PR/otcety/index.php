<?php require_once '../header.php';?>
<div class="otchetistr">
<ul>
<li><a href="#" onclick="javascript:loadotchet();">Отчеты по продуктам на складе</a><br>
<li><a href="#" onclick="javascript:prodaza_produkciya();">Отчет по продажам продукции</a><br>
<li><a href="#" onclick="javascript:otchet_pr();">Отчет</a>
</ul>
</div>
<img id="preload" src="../images/preloader.gif" style="display: none">
    <div class="contenttab"></div>
<div class='no_cena' hidden>Загрузка продуктов с неизвестными ценами .... Подождите...</div>

    <script>
function loadotchet()
{
    $("#preload").css("display","block");
$.ajax({
	url:'otchet.php',
	success: function (data){
	  $('.contenttab').html(data);
        $("#preload").css("display","none");
	}
});
};
function otchet_pr()
{
    $("#preload").css("display","block");
$.ajax({
	url:'otchet_pr.php',
	success: function (data){
	  $('.contenttab').html(data);
        $("#preload").css("display","none");
	}
});
};
function prodaza_produkciya()
{
    $("#preload").css("display","block");
$.ajax({
	url:'prodaza_produkciya.php',
	success: function (data){
	  $('.contenttab').html(data);
        $("#preload").css("display","none");
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
<?php require_once '../footer.php';?>