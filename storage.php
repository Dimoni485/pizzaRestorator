<?php
require_once "header.php";
$storage = new StorageClass;
$storageListProduct = $storage->getStorageListProduct();
if (isset($_POST['saveColvo'])){
  $colvoInput=$_POST['saveColvo'];
  $idpr = $_POST['id'];
  $storage->updateColvoStorage($idpr, $colvoInput);
}
if (isset($_POST['delete'])){
  $storage->deleteStorageProduct($_POST['delete']);
}
if (isset($_POST['updatePriceStorage'])){
  $storage->updatePriceStorage();
}
?>
<div class="container">
  <div class="row">
    <div class="col">
      <nav  aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item" ><a href="/">Главная</a></li>
              <li class="breadcrumb-item active" aria-current="page">Склад</li>
          </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col mb-1">
    <button onclick="location.reload();return(false);" class="btn btn-success btn-sm" id="obnovit" title="Обновить">Обновить</button>
    <button class="btn btn-success btn-sm" id="obnovit" onclick="javascript:obnovitCenaStorage();" title="Обновить">Обновить цены</button>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-hover table-sm" style="font-size: 14px;">
        <thead class="thead-light text-center"> 
          <th>Продукт</th><th>ед.</th><th>Кол-во</th><th>Цена</th><th>Сумма</th><th colspan="2"></th>
        </thead>
        <tbody>
          <?php foreach($storageListProduct as $storageRows){?>
        <tr id="rowsTableStorage<?=$storageRows[0]?>">
          <td><?=$storageRows[1] //Наименование?></td>
          <td><?=$storageRows[4] //ед. измерения?></td>
          <td id="rowsColvo<?=$storageRows[0] //id?>" class="text-right"><?=number_format($storageRows[2],2,',',' ') //Количество?></td>
          <td id="rowsCena<?=$storageRows[0] //id?>" class="text-right"><?=number_format($storageRows[5],2,',',' ') //Цена?></td>
          <td id="rowsSumma<?=$storageRows[0] //id?>" class="text-right"><?=number_format($storageRows[3],2,',',' ') //Сумма?></td>
          <td id="buttonEditColvo<?=$storageRows[0] //id?>"><a href="#" onclick="javascript:editStorageColvo(<?=$storageRows[0]?>);return false;" class="btn btn-sm btn-info">Изменить кол-во</a></td>
          <td><?php $co=0;$textSpani=''; $ProductArray=$storage->checkDeleteButton($storageRows[1]); if ($ProductArray==0){?><a href="#" onclick="javascript:deleteStorageProduct(<?=$storageRows[0]?>);return(false);" class="btn btn-sm btn-info">Удалить</a><?php }else{ foreach($ProductArray as $rows){$co++; $textSpani.='<a class="dropdown-item small" href="#">'.$rows[0].'</a>';}?>
          <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm"><?=$co?></button>
            <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
            <?=$textSpani?>
            </div>
          </div>
          <?php } ?>
          </td>
        </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
require_once "footer.php";
?>