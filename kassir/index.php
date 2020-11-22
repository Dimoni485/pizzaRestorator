<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
       
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Последняя компиляция и сжатый CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" >
    <link href="../open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/material-design-iconic-font.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-datepicker.min.css" media="all">
    <script type="text/javascript" src="../jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"> </script>
        <title></title>
    </head>
    <body>
        <?php
        function __autoload($filename){
            include 'classes/'.$filename.'.php';
        }
        $kassirPOS = new KassirClass();
        $kat = $kassirPOS->getKAT();
        ?>
        
        <nav class="navbar navbar-dark bg-dark">
                    <div class="navbar-brand">Кассир POS</div>
                </nav>
           
        <div class="container-fluid">
            
                
            <div class="row mt-1">
                <div class="col-3">
                    <div class="list-group small">
                        <?php foreach ($kat as $rowKat) {?>
                        <a href="#" class="list-group-item list-group-item-action pl-1"><?=$rowKat[1]?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col" >
                    <div class="card" style="width: 10rem;height:10rem;">
                        <h5 class="card-header">Продукт</h5>
                        <div class="card-body">
                          <h6 class="card-title">Состав:</h6>
                          <p class="card-text"></p>
                          <a href="#" class="btn btn-primary">100 р.</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div style="height:75%;">
                        <ul class="list-group">
                            <li class="list-group-item">Наименование Цена * Кольво = 100 р.</li>
                        </ul>
                    </div>
                    <div class="align-bottom">
                    
                    </div>
                </div>
            </div>
            <div class="row fixed-bottom">
                <div class="col">
                    <nav class="navbar navbar-dark bg-dark">
                    <div class="navbar-brand">Кассир POS</div>
                    <form class="form-inline"><h5 class="text-light mr-1">Итого: 100 р.</h5><a href="#" class="btn btn-success">Оплата</a></form>
                    </nav>
                </div>
            </div>
        </div>
        
    </body>
</html>
