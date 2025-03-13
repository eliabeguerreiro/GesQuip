<?php
session_start();
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";
var_dump($_SESSION);
if ($reserva = Item::reservaItem($_POST['id'], $_POST['moviment'])) {
    echo "Reserva realizada com sucesso!";
} else {
    echo "Falha ao realizar a reserva.";
}
?>