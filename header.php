<?php
date_default_timezone_set('Europe/Moscow');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
function __autoload($filename){
        include 'controllers/'.$filename.'.php';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Последняя компиляция и сжатый CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
    <link href="open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/material-design-iconic-font.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" media="all">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.min.css" media="all">
    <script type="text/javascript" src="jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"> </script>
    <script type="text/javascript" src="js/script.js?v=1.2"></script>
    <title>
        Pizzeria WEB 3.0
    </title>
    <style>
            body{
                    font-size: 14px;
            }
    </style>
</head>
<body>
<div class="container-fluid mb-5">
        <div class="row">
                <div class="navbar navbar-dark fixed-top bg-dark">
                        <button class="navbar-toggler font-weight-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand font-weight-bold" href="/">Pizzeria 3.0.1</a>
                        <form class="form-inline font-weight-light" style="color: white;">
                                <span> <?php print("Пользователь : "); ?></span>
                                <a href="/auth/logout.php" class="btn btn-link">Выход</a>
                        </form>
                        <div class="collapse navbar-collapse font-weight-light" id="navbarSupportedContent">
                                <ul class="nav navbar-nav">
                                        <li class="nav-item">
                                                <a class="nav-link"  href='/'> Главная</a>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link"  href='assortment.php'><i class="zmdi zmdi-cutlery"></i> Меню</a>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link"  href='storage.php'><i class="zmdi zmdi-flower-alt"></i> Склад</a>
                                        </li>
                                        <!--<li class="nav-item">
                                                <a class="nav-link"  href='/spisanie'><i class="zmdi zmdi-block"></i>Списание</a>
                                        </li>-->
                                        <li class="nav-item">
                                                <a class="nav-link"  href='goodsProvider.php'><i class="zmdi zmdi-boat"></i> Приход на склад</a>
                                        </li>
                                        <!--<li class="nav-item">
                                                <a class="nav-link"  href='/skidki/skidka.php'><i class="zmdi zmdi-long-arrow-down"></i> Скидки</a>
                                        </li>-->
                                        <!--<li class="nav-item">
                                                <a class="nav-link"  href='/skidki/skidka_user.php'><i class="zmdi zmdi-account"></i> Индивидуальные скидки</a>
                                        </li>-->
                                        <!--<li class="nav-item">
                                                <a class="nav-link"  href='/analitika'><i class="zmdi zmdi-chart"></i> Аналитика</a>
                                        </li>-->
                                        <!--<li class="nav-item">
                                                <a class="nav-link"  href='/otcety'><i class="zmdi zmdi-collection-text"></i> Отчеты</a>
                                        </li>-->
                                        <li class="nav-item">
                                                <a class="nav-link"  href='sales.php'><i class="zmdi zmdi-balance-wallet"></i> Продажи</a>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link"  href='provider.php'><i class="zmdi zmdi-car"></i> Поставщики</a>
                                        </li>
                                        <!---<li class="nav-item">
                                                <a class="nav-link"  href='#'><i class="zmdi zmdi-accounts"></i> Пользователи</a>
                                        </li>-->
                                        <li class="nav-item">
                                                <a class="nav-link"  href='kat.php'><i class="zmdi zmdi-view-toc"></i> Категории</a>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link"  href='settings.php'><i class="zmdi zmdi-settings"></i> Настройка</a>

                                        </li>
                                </ul>

                        </div>

                </div>
        </div>
</div>
<div class="row m-4">
        
</div>