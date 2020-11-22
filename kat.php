<?php
    include 'header.php';
    $kat = new KatClass;
    $getKAt= $kat->getKat();
    if (isset($_POST['save'])){
        $kat->addKat($_POST['katname']);
    }
    if (isset($_POST['delete'])){
        $kat->deleteKat($_POST['delete']);
    }
?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" ><a href="/">Главная</a></li>
                    <li class="breadcrumb-item">Категории</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col">
            <button class="btn btn-success btn-sm" id="buttonAddKat" onclick="javascript:addRowsKat();return false;" >Добавить</button>
        </div>
        </div>
        <div class="row">
        <div class="col">
            <table class="table table-hover table-sm" style="font-size:14px;" id="tableKat">
                <thead class="thead-light">
                    <tr>
                        <th>Категория</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($getKAt as $rowsKat){ ?>
                    <tr id="rowsKat<?=$rowsKat[0]?>">
                        <td><?=$rowsKat[1]?></td>
                        <?php if ($rowsKat[2]==0){ ?>
                        <td><a href="#" class="btn btn-info btn-sm" onclick="javascript:deleteKat(<?=$rowsKat[0]?>);">Удалить</a></td>
                        <?php }else{?>
                            <td><span class="badge badge-info"><?=$rowsKat[2]?></span></td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
   
</div>

<?php include 'footer.php'; ?>