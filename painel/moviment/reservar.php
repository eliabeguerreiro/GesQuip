<?php
session_start();
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";

if ($reserva = Item::reservaItem($_POST['id'], $_SESSION['id_moviment'])) {
    echo "Reserva realizada com sucesso!";
} else {
    echo "Falha ao realizar a reserva.";
}
?>