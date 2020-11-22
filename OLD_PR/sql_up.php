<form method="POST" action="sql_up.php" >
<textarea name="SQLZ" rows="20" cols="50"></textarea>
<input type="submit" value="Ok">
</form>
<?php
require_once("connect.php");
if (isset($_POST["SQLZ"])){
$query_fb=mysqli_query($dbm,$_POST["SQLZ"]);

echo $query_fb;
}
?>