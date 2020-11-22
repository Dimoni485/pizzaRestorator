<?php
session_start();
# Служит для отладки, показывает все ошибки, предупреждения и т.д.
error_reporting(E_ALL);
# Подключение файлов с функциями
require_once ($_SERVER['DOCUMENT_ROOT']."/connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/auth/functions.php");
# В этом массиве далее мы будем хранить сообщения системы, т.е. ошибки.
$messages=array();


?>