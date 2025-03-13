<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-moviment.class.php";
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";
$reservados = Item::getItensReservados($_SESSION['id_moviment']);

$db = DB::connect();


$rs = $db->prepare("DELETE FROM movimentacao WHERE id_movimentacao = ".$_SESSION['id_moviment']);
$rs->execute();
$rows = $rs->rowCount();
if($rows > 0){

    if($reservados){
        foreach ($reservados['dados'] as $item){
        
            $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 1 WHERE id_item = ".$item['id_item']);
            $rs->execute();
            $rows = $rs->rowCount();
        
            if($rows > 0){
                $_SESSION['msg'] = 'Movimentação Cancelada!';
                $_SESSION['id_moviment'] = null;
                
            }
        }
    
    }else{
        $_SESSION['msg'] = 'Movimentação Cancelada!';
        $_SESSION['id_moviment'] = null;
    }
}


