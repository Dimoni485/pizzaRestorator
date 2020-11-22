<?php


include_once("auth/config.php");
checkLoggedIn("yes");
date_default_timezone_set('Europe/Moscow');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Последняя компиляция и сжатый CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/css/material-design-iconic-font.min.css" >
    <link href="/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" media="all">
    <script
        src="http://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/messages/messages.ru-ru.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/pizzerria.js"></script >
    <link rel="stylesheet" type="text/css" href="/css/print.css" media="print">-->


    <title>
        Pizzeria WEB 3.0
    </title>
</head>
<body>
<div class="contant">
<div id="preloaderbg" class="centerbg1">

    <div class="centerbg2">
        <div id="preloader"></div>
    </div>
</div>




    <nav class="navbar fixed-top navbar-dark bg-dark">
        <button class="navbar-toggler col-auto font-weight-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand font-weight-bold" href="/">Pizzeria 3.0.0</a>


        <form class="form-inline font-weight-light" style="color: white;">
            <span> <?php print("Пользователь : ".$_SESSION["login"]); ?></span>
            <a href="/auth/logout.php" class="btn btn-link">Выход</a>
        </form>
        <div class="collapse navbar-collapse col-auto font-weight-light" id="navbarSupportedContent">
            <ul class="nav navbar-nav">
                <li class="nav-item">

                        <a class="nav-link"  href='/produkciya'><i class="zmdi zmdi-cutlery"></i> Номенклатура</a>

                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/prihod_sklad'><i class="zmdi zmdi-case"></i> Приход товара</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/sklad'><i class="zmdi zmdi-flower-alt"></i> Склад</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/spisanie'><i class="zmdi zmdi-block"></i>Списание</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/postavsik'><i class="zmdi zmdi-boat"></i> Товар от поставщиков</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/skidki/skidka.php'><i class="zmdi zmdi-long-arrow-down"></i> Скидки</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/skidki/skidka_user.php'><i class="zmdi zmdi-account"></i> Индивидуальные скидки</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/analitika'><i class="zmdi zmdi-chart"></i> Аналитика</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/otcety'><i class="zmdi zmdi-collection-text"></i> Отчеты</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/prodazi'><i class="zmdi zmdi-balance-wallet"></i> Продажи</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/postavsik/postavsik.php'><i class="zmdi zmdi-car"></i> Поставщики</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='#'><i class="zmdi zmdi-accounts"></i> Пользователи</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/kategorii'><i class="zmdi zmdi-view-toc"></i> Категории</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link"  href='/setting'><i class="zmdi zmdi-settings"></i> Настройка</a>

                </li>
            </ul>

        </div>

    </nav>
    <style>
        .btn{
            font-size: 14px;
        }
    </style>
    <div class="container" style="margin-top: 60px;">
    <div class="row align-items-center">
        <div class="col">
<!--            <div class="panel panel-default">
                <div class="panel-body">-->

                   <!--<div class="contenttab">
                    </div>-->
