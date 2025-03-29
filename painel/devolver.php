<?php
session_start();
include_once "classes/db.class.php";


    $id_item = $_POST['id'];



        $dt = date('Y-m-d H:i:s');
        $db = DB::connect();
        
        // primeiro eu indentifico o id_item_movimentacao que está associado ao item e a movimentação
        
        $rs = $db->prepare("SELECT * FROM item_movimentacao WHERE id_item = $id_item ORDER BY id_item_movimentacao DESC LIMIT 1");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_item_mov = $resultado[0]['id_item_movimentacao'];
        $id_mov = $resultado[0]['id_movimentacao'];
        

        // depois eu atualizo a data de devolução do item_movimentacao
        $rs = $db->prepare("UPDATE item_movimentacao SET dt_devolucao = '$dt' WHERE id_item_movimentacao = $id_item_mov");
        $rs->execute();
        $rows = $rs->rowCount();

        if($rows > 0){ 
                       
            // depois eu atualizo a disponibilidade do item

            $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 1 WHERE id_item = $id_item");
            $rs->execute();
            $rows = $rs->rowCount();

            if($rows > 0){  

                $rs = $db->prepare("SELECT * FROM item_movimentacao WHERE id_movimentacao = $id_mov and dt_devolucao is null");
                $rs->execute();
                $rows = $rs->rowCount();

                if($rows == 0){ 

                    // depois eu atualizo a data de devolução da movimentação
                    $rs = $db->prepare("UPDATE movimentacao SET dt_finalizacao = '$dt' WHERE id_movimentacao = $id_mov");
                    $rs->execute();
                    $rows = $rs->rowCount();

                    echo json_encode([
                        'success' => true,
                        'message' => 'Devolução realizada com sucesso - A movimentação foi Encerrada!'
                    ]);

                return true;
            }else{

                echo json_encode([
                    'success' => true,
                    'message' => 'Devolução realizada com sucesso - A movimentação foi Encerrada!'
                ]);

            }
        }
    }