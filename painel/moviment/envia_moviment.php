<?php
session_start();
ob_start();
include_once "classes/conteudo.painel-moviment.class.php";
include_once "classes/gest-moviment.class.php";
include_once "classes/db.class.php";

$reservados = Item::getItensReservados($_POST['id']);

//var_dump($reservados);
$db = DB::connect();
$response = ['status' => 'error', 'message' => 'Erro ao finalizar a movimentação'];

foreach ($reservados as $item) {
    $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 0 WHERE id_item = :id_item");
    $rs->bindParam(':id_item', $item['id_item'], PDO::PARAM_INT);
    $rs->execute();
    $rows = $rs->rowCount();

    if ($rows > 0) {
        $rs = $db->prepare("INSERT INTO item_movimentacao (id_movimentacao, id_item, id_autor) VALUES (:id_movimentacao, :id_item, :id_autor)");
        $rs->bindParam(':id_movimentacao', $_POST['id'], PDO::PARAM_INT);
        $rs->bindParam(':id_item', $item['id_item'], PDO::PARAM_INT);
        $rs->bindParam(':id_autor', $_SESSION['data_user']['id_usuario'], PDO::PARAM_INT);
        $rs->execute();
        $rows = $rs->rowCount();

        if ($rows > 0) {
            $_SESSION['msg'] = 'Movimentação realizada com sucesso!';
            $_SESSION['id_moviment'] = null;
            $response = ['status' => 'success', 'message' => 'Movimentação realizada com sucesso!'];
        }
    }
}

echo json_encode($response);