<?php 
include "header.php";
$productCard = new ProductCardClass; 
$produktSklad = $productCard->getSkladList();
$katArray = $productCard->getKategoriiArray();
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $productArray = $productCard->getProductIfId($id);
    $productName = $productArray[0][1];
    $productCena = $productArray[0][2];
    $productNacenka = $productArray[0][6];
    $productKat = $productArray[0][4];
    $productSebestoimost = $productArray[0][5];
    $productSostavArray = $productCard->getSostavProducta($productName);
    #$produktSklad = $productCard->getSkladList();
    
}
if (isset($_POST['save'])){
    $saveProduct = $_POST['nameProduct'];
    $saveSostavProduct = $_POST['nameSostavProduct'];
    $saveCenaProduct = $_POST['cenaSelectProduct'];
    $saveColvoProduct = $_POST['colvoProduct'];
    $productCard->insertSostavProduct($saveProduct, $saveSostavProduct,$saveCenaProduct,$saveColvoProduct);
}
if (isset($_POST['delete'])){
    $productCard->deleteProductSostav($_POST['delete'],$_POST['nameProduct']);
}
if (isset($_POST['updateCena'])){
    $productCard->updateCenaSostav($_POST['updateID'], $_POST['updateCena']);
}
if (isset($_POST['updateKat'])){
    $productCard->updateKat($_POST['saveID'], $_POST['updateKat']);
}
?>
<script>
    $x=1;
var productList = '<option></option><?php foreach($produktSklad as $row){?><option value="<?=$row[0]?>"><?=$row[0]?></option><?php } ?>';
var ArrayCenaProdukta = new Map();
<?php  foreach ($produktSklad as $rowcena){?>
    ArrayCenaProdukta.set('<?=$rowcena[0]?>','<?=$rowcena[1]?>');
<?php } ?>
console.log(ArrayCenaProdukta);
var kategoriyaList = '<?php foreach($katArray as $row){?><option><?=$row[0]?></option><?php } ?>';
</script>
<div class="container">
    <div class="row">
        <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item"><a href="assortment.php">Продукция</a></li>
                <li class="breadcrumb-item"><a href="assortment.php?katset=<?=$productKat?>"><?=$productKat?></a></li>
                <li class="breadcrumb-item active"><?=$productName?></li>
            </ol>
        </nav>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h4>
                <span class="badge badge-light" id="nameProductSpan"><?=$productName?></span> 
                <span class="badge badge-info">Себестоимость: <span><?=number_format($productSebestoimost,2,',',' ')?></span> р.</span>
                <span class="badge badge-info">Наценка: <span><?=$productNacenka?></span> %</span>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h4>
                <div class="input-group">
                    <span class="mr-1">Цена:</span> 
                    <span id="productCenaSpan"><?=$productCena?></span> 
                    <span class="ml-1">р.</span>
                    <a href="#" id="buttonEditCenaSpan" onclick ="javascript:editCenaSpan(<?=$id?>);" class="btn btn-success btn-sm">Изменить</a>
                </div>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h4>
                <div class="input-group">
                <span class="mr-1">Категория:</span>
                <span class="mr-1" id="productKatSpan"><?=$productKat?></span>
                <a href="#" id="buttonSelectKat" onclick="javascript:editSelectKat(<?=$id?>);" class="btn btn-success btn-sm">Изменить</a>
                </div>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col mr-2 mb-2">
            <a href="#" onclick="javascript:addProductToSostav($x);$x++;" class="btn btn-sm btn-success">Добавить в состав</a>
            <a href="#" class="btn btn-success btn-sm" onclick="javascript:location.reload();">Обновить</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover table-sm" style="font-size: 14px;" id='sostavTable'>
                <thead class="thead-light">
                    <tr>
                        <th>Наименование</th><th>Кол-во</th><th>Цена</th><th>Сумма</th><th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($productSostavArray){foreach($productSostavArray as $rowsSostav) {?>
                    <tr id="sostavTableRows<?=$rowsSostav[0]?>">
                        <td><?=$rowsSostav[1] //Наименование?></td>
                        <td id="colvoRows<?=$rowsSostav[0]?>"><?=number_format($rowsSostav[2],2, ", ", " ") //Количество?> <?=$rowsSostav[4]?></td>
                        <td><?=number_format($rowsSostav[6],2, ", ", " ") //Цена?> р.</td>
                        <td><?=number_format($rowsSostav[5],2, ", ", " ") //Сумма?> р.</td>
                        <td class="text-center" id="editSostavColvoButton<?=$rowsSostav[0]?>"> <!--<a href="#" onclick="javascript:editSostavProduct(<?=$rowsSostav[0]?>)" class="btn btn-sm btn-info">Редактировать</a>--></td>
                        <td><a href="#" onclick="javascript:deleteRowsSostav(<?=$rowsSostav[0]?>);return false;" class="btn btn-sm btn-info">Удалить</a></td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>