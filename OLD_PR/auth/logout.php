<?php
include_once($_SERVER['DOCUMENT_ROOT']."/auth/config.php");
checkLoggedIn("yes");
flushMemberSession();
header("Location: /auth/login.php");
?>