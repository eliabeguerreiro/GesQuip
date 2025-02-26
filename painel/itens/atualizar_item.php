<?php
session_start();
include_once"classes/gest-item.class.php";
include_once"classes/db.class.php";

if ($atualiza = Item::updateItem($_POST['id'], $_POST['texto'])) {
    echo "Atualização realizada com sucesso!";
} else {
    echo "Falha ao atualizar a reserva.";
}
?>