<?php
/*    Using "mysqli" instead of "mysql" that is obsolete.
* Change the value of parameter 3 if you have set a password on the root userid
* Add port number 3307 in parameter number 5 to use MariaDB instead of MySQL
*
*     Utilisation de "mysqli" а la place de "mysql" qui est obsolиte.
* Changer la valeur du 3e paramиtre si vous avez mis un mot de passe а root
* Ajouter le port 3307 en paramиtre 5 si vous voulez utiliser MariaDB
*/
$mysqli = new mysqli('127.0.0.1', 'root', '', '');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
echo '<p>Connection OK '. $mysqli->host_info.'</p>';
echo '<p>Server '.$mysqli->server_info.'</p>';
$mysqli->close();
?>
