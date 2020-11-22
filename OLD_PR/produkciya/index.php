
<?php

require_once "../header.php";
require_once("../connect.php");

if (isset($_GET['katset'])){
    $kateg_set=$_GET['katset'];
}else {
    $kateg_set='';
}
?>
<div class="contenttab">

    <nav  aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" ><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Блюда</li>
        </ol>
    </nav>


    <div class="navbar navbar-expand-lg navbar-light bg-light">
<!--<input type="text" value="Найти..." id="" class="searchinput"><br>-->
<a href="#" class="btn btn-success" id="addprodbut" title="Добавить">Добавить</a>
        <a href="#" onclick="location.reload();return(false);" class="btn btn-default" id="obnovit" title="Обновить">Обновить</a>



    <form class="form-inline my-2 my-lg-0">
            <select class="custom-select custom-select-sm" id="select_categoriya" >
                <option value="">Все</option>
                <?php
                $qq=mysqli_query($dbm,"SELECT * FROM KATEGORII ORDER BY KAT");
                while ($Rowd=mysqli_fetch_assoc($qq)){
                    echo "<option>".$Rowd['KAT']."</option>";
                }
                ?>
            </select>

        <button class="btn btn-outline-success btn-sm my-sm-0" type="button" onclick="javascript:select_categor();">Выбрать категорию </button>
    </form>
        <h3><span class="badge badge-info ml-4">
Средняя наценка:
                <?php
                if (!isset($sr_nacenka)){
                    $sr_nacenka=0;
                    echo $sr_nacenka;
                }else{
                    echo $sr_nacenka;
                }
                $x=0;
                ?>
    </span></h3>
</div>
<script>
    function select_categor() {
        $katset_o = $("#select_categoriya").val();
        /*$.ajax({
            type: 'GET',
            url: '/produkciya/index.php',
            data: 'katset=' + $("#select_categoriya").val(),
            success: function (html) {
                $('body').html(html);
            }
        });*/
        $(location).attr('href','/produkciya/index.php?katset=' +  $katset_o );

    }
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>

<table class="table table-hover table-sm" id="tableall" style="font-size: 14px;">
<thead>
<tr class="zagolovok"> 
<th>Наименование</th><th>Категория</th><th>Себест.</th><th>Цена</th><th>Наценка</th><th>Тех. карта</th><th>Ред-ть</th><th>Удалить</th>
</tr></thead>
<?php

if (isset($_GET['str'])){
    $skipping=$_GET['str'];
}else {
    $skipping = 0;
}

$Q=mysqli_query($dbm,'select * FROM PRODUKCIYA WHERE KATEGORIYA LIKE "%'.$kateg_set.'%" ORDER BY KATEGORIYA,PRODUKT LIMIT 15 OFFSET '.$skipping );
$idrow="";
while ($Row=mysqli_fetch_assoc($Q)) {

    if ($Row['KATEGORIYA']==$idrow)
    {
  
        }else
    {

        echo "<tr>";
        echo "<td colspan=8 style='background:#DEE0C8;font-size:1.3em;'>";
        echo $Row['KATEGORIYA'];
        echo "</td>";
        echo "</tr>";
    }
    $idrow=$Row['KATEGORIYA'];

echo "<tr class='rowstab'>";
echo "<td>";
    $geter=mysqli_query($dbm,"SELECT error_sostav('".$Row['ID_SOSTAV']."') AS nresult");
    while ($getstrerror = mysqli_fetch_assoc($geter)) {
        // echo $getstrerror['nresult'];

        if ($getstrerror['nresult'] == 0) {
            echo "<button type='button' class='btn btn-outline-danger btn-sm' data-toggle=\"popover\" title=\"ВНИМАНИЕ !!!\" data-content=\"Проверте состав, возможно он пуст или продуктов нет на складе.\" >" . $Row['PRODUKT'] . "</button>";

        } else {

            echo $Row['PRODUKT'];
        }
    }
echo "</td>";
echo "<td>";
echo  $Row['KATEGORIYA'];
echo "</td>";
echo "<td align=right>";
//require_once("connect.php");
$Qi=mysqli_query($dbm,"SELECT SUM(SUMMA) AS SUMMA FROM SOSTAV WHERE ID_PRODUKCIYA='".$Row['ID_SOSTAV']."'");

    while ($Rowi=mysqli_fetch_assoc($Qi)) {
    if ($Rowi['SUMMA'] <> 0){
        echo number_format($Rowi['SUMMA'],3,'.',' ').'р.';
        }else
            {
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
    if (($nacenka > 0) and ($sr_nacenka > 0)){
            $sr_nacenka = $sr_nacenka + $nacenka;
        }
++$x;
echo "<script>$('.sr_nacenka').text('Средняя наценка: ".number_format($sr_nacenka/$x,3,'.',' ')."%');</script>";
    }
echo "</td>";
echo "<td class='text-center'>";
echo  '<a href="getsostav.php?naimenprodukt='.$Row['ID_SOSTAV'].'&nacenka='.$nacenka.'&sebest='.$Row['CENA'].'"><span class="oi oi-list"></span></a>';
echo "</td>";
echo "<td>";
echo '<a href="javascript:editprodukt(\''.htmlspecialchars($Row['PRODUKT']).'\',\''.htmlspecialchars($Row['KATEGORIYA']).'\',\''.$Row['CENA'].'\',\''.$Row['ID'].'\',\''.htmlspecialchars($Row['ID_SOSTAV']).'\');" ><span class="oi oi-pencil"></span></a>';
echo "</td>";
echo "<td>";
echo '<a href=# onclick="javascript:del_tovar(\''.$Row['ID'].'\');return(false);"> <span class="oi oi-delete"></span> </a>';
echo "</td>";
echo "</tr>";


}
//echo '</table>';
$produ=$Row['PRODUKT'];


?>
</table>


<div class="modal fade" tabindex="-1" role="dialog" id="addprod"  >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">
Добавить
            </div>
        </div>

            <div class="modal-body">
<form>
Наименование:<input class="form-control" type="text" value="" id="addproduktname">
Категория:<select class="custom-select" id="addproduktkat">
<?php
require_once("../connect.php");
$qq=mysqli_query($dbm,"SELECT * FROM KATEGORII ORDER BY KAT");
while ($Rowd=mysqli_fetch_assoc($qq)){
  echo "<option>".$Rowd['KAT']."</option>";
}
?>
</select>
Цена:<input type="number" class="form-control" value="" id="addproduktcena">
</form>
        </div>
        <div class="modal-footer">
<a onclick="javascript:addprodukt()" href="#" class="btn btn-success">Добавить</a><a href="#" class="btn btn-secondary" data-dismiss="modal">Отмена</a>
        </div>
        </div>
    </div>
</div>


<div class="row" id="getsost">

</div>
<div class="modal fade" id="editprodu" tabindex="-1" role="dialog">

</div>

<script type="text/javascript">
$('#addprodbut').click(function ()
{
  $("#addprod").modal('show');
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
  $("#addprod").modal('hide');
  location.reload();
}
});
}

function editprodukt($naimenprod, $kat, $cena, $idprodukt,$idsostav){
$cena=$cena.replace(",",".");
$.ajax({
	type:'POST',
	url:'/produkciya/editprodukt.php',
	data: "naimenprod="+$naimenprod+"&kat="+$kat+"&cena="+$cena+"&idprodukt="+$idprodukt+"&idsostav="+$idsostav,
	success: function(html){  
        $("#editprodu").html(html);
        $("#editprodu").modal('show');
	}

});
}
function del_tovar($id_produkt)
{
if (confirm("Удалить запись ?")){
  $.ajax({
type:'POST',
url:'/produkciya/delprodukt.php',
data: "idprodukt="+$id_produkt,
success:function()
{
  location.reload();
  return false;
}

});
}
}

</script>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php
        if (isset($_GET['str'])) {
            $nazad = $_GET['str'] - 15;

        if ($_GET['str'] ==0){
            echo '<li class="page-item disabled">';
            echo '<a class="page-link" >Назад</a>';
            echo '</li>';
        }else {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="?str=' . $nazad . '">Назад</a>';
            echo '</li>';
        }
        }
        ?>
        <?php $CountTable=mysqli_query($dbm,"SELECT COUNT(*) AS COUNT FROM PRODUKCIYA WHERE KATEGORIYA LIKE '%".$kateg_set."%'"); ?>
        <?php
        $ResultCount=mysqli_fetch_assoc($CountTable);
        $PageNum = ceil($ResultCount['COUNT'] / 15);
        $z=0;
        if (isset($_GET['str'])) {
            $page_yes = $_GET['str'];
        }else{
            $page_yes = 0;
        }
        for ($i=1; $i <= $PageNum; $i++){
            if ($z==$page_yes){
                echo '<li class="page-item active"><a class="page-link" href="?str=' . $z . '&katset=' . $kateg_set . '">' . $i . '</a></li>';
            }else {
                echo '<li class="page-item"><a class="page-link" href="?str=' . $z . '&katset=' . $kateg_set . '">' . $i . '</a></li>';
            }
            $z=$i*15;
        }
        ?>


            <?php
        if (isset($_GET['str'])) {
            $vpered = $_GET['str'] + 15;
        }else{
            $vpered= 15;
        }
            if ($vpered >=$z){
                echo '<li class="page-item disabled">';
                echo '<a class="page-link" >Вперед</a>';
                 echo '</li>';
            }else {
                echo '<li class="page-item">';
                echo '<a class="page-link" href="?str=' . $vpered . '">Вперед</a>';
                echo '</li>';
            }
            ?>

    </ul>
</nav>
</div>
<?php require_once "../footer.php"; ?>

