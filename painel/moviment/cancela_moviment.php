<?php
session_start();
ob_start();
include_once "classes/conteudo.painel-moviment.class.php";
include_once "classes/gest-moviment.class.php";
include_once "classes/db.class.php";

$reservados = Item::getItensReservados($_POST['id']);
$db = DB::connect();
$response = ['status' => 'error', 'message' => 'Erro ao cancelar a movimentação'];

$rs = $db->prepare("DELETE FROM movimentacao WHERE id_movimentacao = :id_movimentacao");
$rs->bindParam(':id_movimentacao', $_POST['id'], PDO::PARAM_INT);
$rs->execute();
$rows = $rs->rowCount();

if ($rows > 0) {
    if ($reservados) {
        foreach ($reservados as $item) {
            $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 1 WHERE id_item = :id_item");
            $rs->bindParam(':id_item', $item['id_item'], PDO::PARAM_INT);
            $rs->execute();
            $rows = $rs->rowCount();

            if ($rows > 0) {
                $_SESSION['msg'] = 'Movimentação Cancelada!';
                $_SESSION['id_moviment'] = null;
                $response = ['status' => 'success', 'message' => 'Movimentação cancelada com sucesso!'];
            }
        }
    } else {
        $_SESSION['msg'] = 'Movimentação Cancelada!';
        $_SESSION['id_moviment'] = null;
        $response = ['status' => 'success', 'message' => 'Movimentação cancelada com sucesso!'];
    }
}

echo json_encode($response);