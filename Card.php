<?php
include 'views/CardView.php';
$cardView = new CardView();
$date_today = date('Y-m-d');
?>
<div class="row">
    <div class="col">
    <div class="mb-1">
        <button class="btn btn-info btn-sm" onclick="location.reload();">Обновить</button>
        <a href="sales.php" class="btn btn-info btn-sm">Продажи</a>
        <a href="/analitika" class="btn btn-info btn-sm">Аналитика</a>
    </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
            <button class="btn btn-success btn-sm" data-toggle="collapse" data-target="#prodazcollapse" aria-expanded="true" aria-controls="collapseOne">
                Продажи сегодня <span class="oi oi-chevron-bottom" title="icon name" aria-hidden="true"></span>
            </button>
            </div>
            <div class="card-body collapse" id="prodazcollapse">
                <?php $cardView->getSalesNow(date('Y-m-d')); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card-group">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Итого сегодня:</h5>
                        <span class="badge badge-info">
                        Чеков: <?php  echo $cardView->getCheckColvoView($date_today, $date_today); ?>
                        </span>
                    <h6 class="text-muted">
                        <?php echo date('d.m.Y'); ?> 
                    г.</h6>
                    <p class="card-text">
                        <div>Приход: <?php echo number_format($cardView->getSummaItogoView($date_today, $date_today),2,',',' '); ?> р.</div>
                        <div>Расход: <?php echo number_format($cardView->getRashodProduct($date_today, $date_today),2,',',' '); ?> р.</div>
                        <div>&nbsp;&nbsp;Итого: <?php echo number_format($cardView->getSummaItogoView($date_today, $date_today)-$cardView->getRashodProduct($date_today, $date_today), 2,","," ");?> р.</div>
                    </p>
                </div>
            </div>
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Итого за месяц:</h5>
                        <span class="badge badge-info">
                            Чеков: <?php  echo $cardView->getCheckColvoView(date('Y-m-01'), $date_today);  ?>
                        </span>
                    <h6 class="text-muted"><?php echo date('m.Y'); ?>г.</h6>
                    <p class="card-text" style="font-size: 1.5em;">
                        <div>Приход: <?php echo number_format($cardView->getSummaItogoView(date('Y-m-01'), $date_today),2,',',' '); ?> р.</div>
                        <div>Расход: <?php echo number_format($cardView->getRashodProduct(date('Y-m-01'), $date_today),2,',',' '); ?> р.</div>
                        <div>&nbsp;&nbsp;Итого: <?php echo number_format($cardView->getSummaItogoView(date('Y-m-01'), $date_today)-$cardView->getRashodProduct(date('Y-m-01'), $date_today), 2,","," ");?> р.</div>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card-group">
            <div class="card bg-light">
                <div class="card-header bg-warning">
                    Критический запас на складе
                </div>
                <div class="card-body">
                    <?php 
                        $cardView->getCritikalSkladListProdukt();
                    ?>
                    <a href="storage.php" class="card-link">Подробнее...</a>
                </div>
            </div>
        
            <div class="card bg-light">
                <div class="card-header bg-info">
                    Топ 10 продаж за месяц
                </div>
                <div class="card-body">
                        <?php echo $cardView->getTopSalesDateView(date('Y-m-01'), $date_today);?>
                    <a href="sales.php" class="card-link">Подробнее...</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        /*setInterval('location.reload()',10000);*/
    });

</script>