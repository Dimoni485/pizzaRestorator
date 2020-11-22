<?php
include 'header.php';
    $goodsProvederPay = new GoodsProviderClass;
    $CheckPay = $goodsProvederPay->getListPay();
    $maxNumScet = $goodsProvederPay->getMaxNumberScet()[0][0]+1;
    $postavsikList = $goodsProvederPay->getProviderName();
    $productList = $goodsProvederPay->getSkladProduct();
    if (isset($_POST['saveNewCheck'])){
        $newRowsCheckNum = $_POST['numNewCheck'];
        $newRowsDate = $_POST['dateNewCheck'];
        $newRowsName =$_POST['nameNewCheck'];
        $newRowsProvider=$_POST['providerNewCheck'];
        $newRowsEdIz = $_POST['edizNewCheck'];
        $newRowsColvo = $_POST['colvoNewCheck'];
        $newRowsCena=$_POST['cenaNewCheck'];
        $itogo = $_POST['itogoNewCheck'];
        $goodsProvederPay->addNewCheck($newRowsCheckNum,$newRowsName,$newRowsDate,$newRowsProvider,$newRowsEdIz,$newRowsColvo,$newRowsCena,$itogo);
    }
    if(isset($_POST['deleteCheck'])){
        $goodsProvederPay->deleteCheck($_POST['deleteCheck']);
    }
    if(isset($_POST['deleteRowsCheck'])){
        $goodsProvederPay->deleteRowsCheck($_POST['deleteRowsCheck']);
    }
?>
<script>
    ArraySkladProduct = new Map;
    $maxNumScet = <?=$maxNumScet?>;
    $postavsikList = '<?php foreach($postavsikList as $providerRows){ ?><option value="<?=$providerRows[0]?>"><?=$providerRows[0]?></option><?php } ?>';
    $productSkladList = '<?php foreach($productList as $productRows){ ?><option value="<?=$productRows[0]?>-><?=$productRows[2]?>"><?=$productRows[0]?> -> <?=$productRows[2]?>-><?=number_format($productRows[1], 2,',',' ')?></option><?php } ?>';
    <?php foreach($productList as $productRows){ ?>
        ArraySkladProduct.set('<?=$productRows[0]?>-><?=$productRows[2]?>','<?=number_format($productRows[1],2,".","")?>');
    <?php } ?>
</script>
<div class="container">
<div class="row">
    <div class="col">
        <a href="#" onclick="javascript:addNewCheck($maxNumScet);$maxNumScet++;" class="btn btn-success btn-sm">Добавить</a>
        <a href="#" onclick="javascript:location.reload();" class="btn btn-success btn-sm">Обновить</a>
    </div>
</div>
    <div class="row mt-2">
        <div class="col">
            <div class="accordion" id="accordionExample">
                <?php foreach($CheckPay as $checkPayRows){ ?>
                <div class="card">
                    <div class="card-header" id="heading<?=$checkPayRows[2]?>">
                    <h4 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$checkPayRows[2]?>" aria-expanded="true" aria-controls="collapseOne">
                        <span class="badge badge-info">№ <?=$checkPayRows[2]?></span> Дата: <?=date("d.m.Y",strtotime($checkPayRows[0]))?>  <span class="badge badge-info">Сумма: <?=$checkPayRows[1]?> р.</span>
                        <span class="badge badge-info"> <?=$checkPayRows[3]?></span>
                        </button>
                        <a href='#' class='btn btn-warning btn-sm my-0 mr-sm-2 float-right' onclick="javascript:deleteCheck(<?=$checkPayRows[2]?>);return false;">Удалить</a>
                    </h4>
                        
                    </div>

                    <div id="collapse<?=$checkPayRows[2]?>" class="collapse" aria-labelledby="heading<?=$checkPayRows[2]?>" data-parent="#accordionExample">
                    <div class="card-body">
                        <table class="table table-light table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Наименование</th><th>Поставщик</th><th>Ед. из.</th><th class='text-right'>Цена</th><th class='text-right'>Кол-во</th><th class='text-right'>Сумма</th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $productPay = $goodsProvederPay->getProductPlay($checkPayRows[0],$checkPayRows[2]);?>
                                <?php foreach($productPay as $rowsProductPay){ ?>
                                <tr id="rowsNum<?=$rowsProductPay[0]?>">
                                    <td><?=$rowsProductPay[1] //наименование?></td>
                                    <td><?=$rowsProductPay[2] //Поставщик?></td>
                                    <td><?=$rowsProductPay[8] //ед. из.?></td>
                                    <td class='text-right'><?=number_format($rowsProductPay[4],2,',',' ') //цена?></td>
                                    <td class='text-right'><?=number_format($rowsProductPay[3],2,',',' ') //кол-во?></td>
                                    <td class='text-right'><?=number_format($rowsProductPay[7],2,',',' ') //сумма?></td>
                                    <td><a href="#" class="btn btn-info btn-sm" onclick="javascript:deleteRowsCheck(<?=$rowsProductPay[0]?>); return false;">Удалить</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>