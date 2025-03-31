<?php
session_start();
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";


if ($reserva = Item::devolverItem($_POST['id'], $_SESSION['id_moviment'], $_SESSION['data_user']['id_usuario'])) {
    echo "Devolução realizada com sucesso!";
} else {
    echo "Falha ao realizar a devolução.";
}
