
<?php

require_once "header.php";
$assortment = new AssortmentClass;
$katArray = $assortment->getKategoriiArray();
if (isset($_GET['katset'])){
    $kateg_set=$_GET['katset'];
    $productArray = $assortment->getAssortmentIfKat($kateg_set);
}else {
    $kateg_set='';
    $productArray = $assortment->getAssortmentIfKat();
}
if (isset($_POST['save'])){
    $newname = $_POST['newname'];
    $newkat = $_POST['newkat'];
    $newcena = $_POST['newcena'];
    $assortment->addProductTo($newname, $newkat, $newcena);
}
if (isset($_POST['rascetCen'])){
    $assortment->RascetCen();
}
if (isset($_POST['delete'])){
    $assortment->deleteProduct($_POST['delete']);
}
?>
<script>
    $x=1;
var kategoriyaList = '<option value="<?=$kateg_set?>"><?=$kateg_set?></option><?php foreach($katArray as $row){?><option><?=$row[0]?></option><?php } ?>';
</script>
<div class="container">
    <div class="row">
        <div class="col">
            <nav  aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" ><a href="/">Главная</a></li>
                    <li class="breadcrumb-item" ><a href="assortment.php">Продукция</a></li>
                    <?php if ($kateg_set!=''){?>
                        <li class="breadcrumb-item active" aria-current="page"><?=$kateg_set?></li>
                    <?php } ?>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col">
        <h4><span class="badge badge-info">
            Средняя наценка: <?=number_format($assortment->srNacenka()[0][0],2,',',' ')?> %
            </span></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <?php if ($kateg_set!=''){?>
            <a href="#" onclick ="javascript:addProductToTable($x);$x++;" class="btn btn-sm btn-success mr-1" id="addprodbut" title="Добавить">Добавить</a>
            <?php } ?>
            <a href="#" onclick="location.reload();return(false);" class="btn btn-sm btn-success mr-1" id="obnovit" title="Обновить">Обновить</a>
        </div>
        <div class="col-5">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text">Выбрать категорию:</span>
                </div>
                <select class="custom-select" id="select_categoriya" >
                <option value="">Все</option>
                <?php foreach($katArray as $row){?>
                    <option><?=$row[0]?></option>
                <?php } ?>
                </select>
                <div class="input-group-append">
                <button class="btn btn-success btn-sm my-sm-0" type="button" onclick="javascript:select_categor();">Фильтр</button>
                </div>
            </div>
        </div>
        <div class="col">
            <span id="rascetCen">
                <button class="btn btn-sm btn-success" onclick="javascript:rascet_cen();">Пересчитать цены</button>
            </span>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
        
            <script>
                function select_categor() {
                    $katset_o = $("#select_categoriya").val();
                    $(location).attr('href','assortment.php?katset=' +  $katset_o );
                }
                $(function () {
                    $('[data-toggle="popover"]').popover()
                })
            </script>

            <table class="table table-hover table-sm" id="tableProduct" style="font-size: 14px;">
                <thead>
                    <tr class="thead-light"> 
                        <th>Наименование</th><th>Категория</th><th>Себест.</th><th>Цена</th><th>Наценка</th><th>Ред-ть</th><th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($productArray as $productRows){?>
                    <tr class='rowstab'>
                        <td>
                            <?=$productRows[1] //наименование?>
                        </td>
                        <td>
                            <?=$productRows[4] //категирия?>
                        </td>
                        <td align="right" style="background-color: <?php if ($productRows[5]=='0'| $productRows[5]==''){?>#FA8072<?php } ?>;">
                            <?=number_format($productRows[5], 2,","," ") //себестоимость?> р.
                        </td>
                        <td align="right">
                            <?=number_format($productRows[2],2, ","," ") //цена?> р.
                        </td>
                        <td align="right" style="background-color: <?php if ($productRows[6]=='0' | $productRows[6]==''){?>#FA8072<?php }?>;">
                            <?=$productRows[6] //наценка?> %
                        </td>
                        <td>
                            <a href="productCard.php?id=<?=$productRows[0]?>" class="btn btn-sm btn-info">Редактировать</a>
                        </td>
                        <td>
                            <?php if ($productRows[5]=='0'| $productRows[5]==''){ ?>
                            <a href=#  class="btn btn-sm btn-info" onclick="javascript:del_tovar(<?=$productRows[0]?>);return false;"> Удалить</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>

