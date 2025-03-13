<?php
session_start();
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";


if ($reserva = Item::manutencaoItem($_POST['id'])) {
    echo "Manutenção iniciada com sucesso!";
} else {
    echo "Falha.";
}
