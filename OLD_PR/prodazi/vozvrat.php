<?php
require_once("../connect.php");
$idprodukt=$_POST['idprodukt'];
$Qz=mysqli_query($dbm,"select * FROM SOSTAV WHERE ID_PRODUKCIYA='".$idprodukt."'");
/*while ($Rowz=mysqli_fetch_assoc($Qz)) {
require_once("../connect.php");
$Qd=mysqli_query($dbm,"UPDATE SKLAD SET KOLVO=KOLVO+".$Rowz['KOLVO']." 
		WHERE (PRODUKT='".$Rowz['PRODUKT']."') 
		AND (CENA=(
					SELECT CENA 
					FROM RASHOD_PRODUKT 
					WHERE (PRODUKT='".$Rowz['PRODUKT']."') AND (ID_CEK=".$_POST['idprod'].")
					)
			)");
mysqli_query($dbm,"UPDATE RASHOD_PRODUKT SET KOLVO=KOLVO-".$Rowz['KOLVO']." WHERE (ID_CEK=".$_POST['idprod'].") AND (ID_PRODUKCIYA='".$idprodukt."') AND (PRODUKT='".$Rowz['PRODUKT']."')");
}*/
if ($_POST['kolvoprod'] > 1)
{
 require_once("../connect.php");
$Qb=mysqli_query($dbm,"UPDATE PRODAZI SET ITOGO=(ITOGO-(ITOGO/COLVO)) WHERE (ID=".$_POST['idprod'].") AND (PRODUKT='".$idprodukt."') ");
$Qa=mysqli_query($dbm,"UPDATE PRODAZI SET COLVO=COLVO-1 WHERE (ID=".$_POST['idprod'].") AND (PRODUKT='".$idprodukt."') ");

}else{
require_once("../connect.php");
$Qa=mysqli_query($dbm,"DELETE FROM PRODAZI WHERE (ID=".$_POST['idprod'].") AND (PRODUKT='".$idprodukt."') ");
$Qx=mysqli_query($dbm,"DELETE FROM RASHOD_PRODUKT WHERE (ID_CEK=".$_POST['idprod'].") AND (ID_PRODUKCIYA='".$idprodukt."')");
}
$Qc=mysqli_query($dbm,"SELECT * FROM PRODAZI WHERE ID='".$_POST['idprod']."' ");
require_once("../connect.php");
if (mysqli_fetch_assoc($Qc)==0)
{
$Qu=mysqli_query($dbm,"DELETE FROM CEKI WHERE NUMCEK='".$_POST['idprod']."'");
}

?>