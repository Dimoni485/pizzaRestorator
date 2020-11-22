<?php
    include 'header.php';
    $provider = new ProviderClass;
    $getProvider= $provider->getProvider();
    if (isset($_POST['save'])){
        $provider->addProvider($_POST['providername']);
    }
    if (isset($_POST['delete'])){
        $provider->deleteProvider($_POST['delete']);
    }
?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" ><a href="/">Главная</a></li>
                    <li class="breadcrumb-item">Поставщики</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col">
            <button class="btn btn-success btn-sm" id="buttonAddProvider" onclick="javascript:addRowsProvider();return false;" >Добавить</button>
        </div>
        </div>
        <div class="row">
        <div class="col">
            <table class="table table-hover table-sm" style="font-size:14px;" id="tableProvider">
                <thead class="thead-light">
                    <tr>
                        <th>Поставщик</th><th>Контакты</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($getProvider as $rowsProvider){ ?>
                    <tr id="rowsProvider<?=$rowsProvider[0]?>">
                        <td><?=$rowsProvider[1]?></td>
                        <td><?=$rowsProvider[2]?></td>
                        <td><a href="#" class="btn btn-info btn-sm" onclick="javascript:deleteProvider(<?=$rowsProvider[0]?>);">Удалить</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
   
</div>

<?php include 'footer.php'; ?>