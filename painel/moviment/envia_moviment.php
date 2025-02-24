<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-moviment.class.php";
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";
$reservados = Painel::getItensReservados($_SESSION['id_moviment']);

$db = DB::connect();

foreach ($reservados['dados'] as $item){

    
    
    $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 0 WHERE id_item = ".$item['id_item']);
    $rs->execute();
    $rows = $rs->rowCount();

    if($rows > 0){
        $rs = $db->prepare("INSERT INTO item_movimentacao (id_movimentacao, id_item, id_autor) VALUES (".$_SESSION['id_moviment'].",'".$item['id_item']."','".$_SESSION['data_user']['id_usuario']."')");
        $rs->execute();
        $rows = $rs->rowCount();



        if($rows > 0){
            $_SESSION['msg'] = 'Locação realizada com sucesso!';
            setcookie('mov_item', null, time() + (30 * 60));
            header('Location: ./');
        }
    }

}
