<?php
include_once"../../classes/painel.class.php";
include_once"../itens/classes/gest-item.class.php";
include_once"../usuarios/classes/gest-user.class.php";

class Moviment
{
 

  
    public static function verificaMovimentIncompleto() 
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT nr_disponibilidade FROM item WHERE nr_disponibilidade > 2 AND nr_disponibilidade < 999999999");
        //echo("SELECT * FROM item WHERE nr_disponibilidade > 2 AND nr_disponibilidade < 999999999");
        $rs->execute();
        $rows = $rs->rowCount();
        if($rows > 0){
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }else{
            return null;
        }
   
    }
 
 
    public static function finalizaMoviment($id = null){
       
        var_dump($id);
        
        $dt = date('Y-m-d H:i:s');
        $db = DB::connect();
        $rs = $db->prepare("UPDATE movimentacao SET dt_finalizacao = '$dt' WHERE id_movimentacao = $id");
        $rs->execute();
        $rows = $rs->rowCount();
        if($rows > 0){
            $_SESSION['id_moviment'] = null;
            return true;
        }
    }
        
    public static function manutencaoItem($id = null){

        
        $dt = date('Y-m-d H:i:s');
        $db = DB::connect();
        $id_item = $id;
        $id_mov = $_SESSION['id_moviment'];
        $user = $_SESSION['data_user'];
       
        $rs = $db->prepare("SELECT id_item_movimentacao FROM item_movimentacao WHERE id_item = $id_item and id_movimentacao = $id_mov");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_it_mov = $resultado[0]['id_item_movimentacao'];

     
        $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 2 WHERE id_item = $id_item");
        $rs->execute();
        $rows = $rs->rowCount();

        if($rows > 0){ 
            echo '<script>';
            echo 'console.log("Disponibilidade atualizada");';
            echo '</script>';
            
            $rs = $db->prepare("UPDATE item_movimentacao SET dt_devolucao = '$dt' WHERE id_item_movimentacao = $id_it_mov");
            $rs->execute();
            $rows = $rs->rowCount();

            if($rows > 0){  

                echo '<script>';
                echo 'console.log("Tabela item-movimento atualizada");';
                echo '</script>';

                $rs = $db->prepare("INSERT INTO manutencao (id_item, id_item_movimentacao, id_autor, obs_in)
                VALUES(".$id_item.",".$id_it_mov.",'".$user['id_usuario']."','".$_POST['texto']."')");
                $rs->execute();
                $rows = $rs->rowCount();
                
                if ($rows > 0){

                    echo '<script>';
                    echo 'console.log("Manutenção iniciada");';
                    echo '</script>';
                    return true;
                }
            }
        }
            
    }


    public static function getItensMoviment($id = null){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM item_movimentacao WHERE id_movimentacao = $id and dt_devolucao IS NULL ");
        $rs->execute();
        $rows = $rs->rowCount();

        if($rows > 0){ 
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }else{
            return ["dados" => null];

        }
                
    }



    public static function getMoviment($id = null, $nm_filtro = null, $filtro = null) {
        $db = DB::connect();
        if ($id) {
            $rs = $db->prepare("SELECT * FROM movimentacao WHERE id_movimentacao = $id AND dt_finalizacao IS NULL");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        } elseif ($nm_filtro) {
            if ($nm_filtro == 'dt_movimentacao') {
                if (strpos($filtro, '...') !== false) {
                    list($start, $end) = explode('...', $filtro);
                    $rs = $db->prepare("SELECT * FROM movimentacao WHERE dt_movimentacao BETWEEN '$start' AND '$end' AND dt_finalizacao IS NULL ORDER BY id_movimentacao DESC");
                }
            } else {
                $rs = $db->prepare("SELECT * FROM movimentacao WHERE $nm_filtro = '$filtro' AND dt_finalizacao IS NULL ORDER BY id_movimentacao DESC");
            }
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        } else {
            $rs = $db->prepare("SELECT * FROM movimentacao WHERE dt_finalizacao IS NULL ORDER BY id_movimentacao DESC");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }
    }



    public static function getMovimentEncerrado($nm_filtro = null, $filtro = null) {
        $db = DB::connect();
        if ($nm_filtro) {
            if ($nm_filtro == 'dt_movimentacao') {
                if (strpos($filtro, '...') !== false) {
                    list($start, $end) = explode('...', $filtro);
                    $rs = $db->prepare("SELECT * FROM movimentacao WHERE dt_movimentacao BETWEEN '$start' AND '$end' AND dt_finalizacao IS NOT NULL ORDER BY id_movimentacao DESC");
                }
            } else {
                $rs = $db->prepare("SELECT * FROM movimentacao WHERE $nm_filtro = '$filtro' AND dt_finalizacao IS NOT NULL ORDER BY id_movimentacao DESC");
            }
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        } else {
            $rs = $db->prepare("SELECT * FROM movimentacao WHERE dt_finalizacao IS NOT NULL ORDER BY id_movimentacao DESC");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }
    }

    public static function setMoviment($data){
        $user = $_SESSION['data_user'];
        
        $db = DB::connect();
        $rs = $db->prepare("INSERT INTO movimentacao (id_responsavel, id_autor, ds_movimentacao)
        VALUES(".$data['id_responsavel'].",'".$user['id_usuario']."','".$data['ds_movimentacao']."')");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $lastId = $db->lastInsertId(); 
            $_SESSION['msg'] = 'Retirada cadastrado com Sucesso!';
            return $lastId;
        }
        
    }
    

}