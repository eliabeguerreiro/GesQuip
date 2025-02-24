<?php
session_start();
include_once "classes/painel.class.php";
include_once "classes/db.class.php";

if (isset($_POST['id'])) {
    $itemId = $_POST['id'];

    if ($reserva = Painel::devolverItemByPanel($itemId)) {
        echo json_encode([
            'success' => true,
            'message' => 'Devolução realizada com sucesso!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Falha ao realizar a devolução.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID do item não fornecido.'
    ]);
}