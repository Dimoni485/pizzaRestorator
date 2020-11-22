<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Последняя компиляция и сжатый CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/css/material-design-iconic-font.min.css" >

    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" media="all">
    <!--<script src="/js/jquery-1.12.4.min.js"></script>-->
    <!--<script type="text/javascript" src="/js/jquery-ui.js"></script>-->
    <script
        src="http://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/messages/messages.ru-ru.js" type="text/javascript"></script>
    <!--<script type="text/javascript" src="/js/chosen.jquery.js"></script>
    <script type="text/javascript" src="/js/jquery.floatThead.js"></script>
    <script type="text/javascript" src="/js/jquery.floatThead-slim.js"></script>
    <script type="text/javascript" src="/js/fixheader.js"></script>-->
    <script type="text/javascript" src="/js/pizzerria.js"></script >
    <!--<link rel="stylesheet" type="text/css" href="/css/style.css" media="all">

    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.theme.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.structure.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/chosen.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/print.css" media="print">-->


    <title>
        Pizzeria WEB 2.0
    </title>
</head>
<body>
<?php
//require_once "../header.php";
include_once "config.php";
checkLoggedIn("no");
if(isset($_POST["submit"])) {
    field_validator("login name", $_POST["login"], "alphanumeric", 4, 15);
    field_validator("password", $_POST["password"], "string", 4, 15);
    if($messages){
        doIndex();
        exit;
    }

    if( !($row = checkPass($_POST["login"], $_POST["password"])) ) {
        $messages[]="Incorrect login/password, try again";
    }

    if($messages){
        doIndex();
        exit;
    }

    cleanMemberSession($row[0], $row[1]);
    header("Location: /index.php");
} else {
    doIndex();
}

function doIndex() {
global $messages;
?>

<div class="card" style="width: 20em;margin: 0 auto;margin-top: 15%; " align="top">
    <div class="card-body">
        <h5 class="card-title text-center">Авторизация</h5>
        <?php
        if($messages) { displayErrors($messages); }
        ?>
<form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST">
<div class="form-group">
    <label for="exampleInputEmail1">Логин</label>
    <input type="text" name="login" class="form-control" id="exampleInputEmail1" placeholder="Ваш логин">
    <small id="emailHelp" class="form-text text-muted"></small>
</div>
<div class="form-group">
    <label for="exampleInputPassword1">Пароль</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль">
</div>
<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
</div>
<button name="submit" type="submit" class="btn btn-primary">Вход</button>
</form>
    </div>
</div>
    <?php
}
?>

<?php require_once ("../footer.php"); ?>
