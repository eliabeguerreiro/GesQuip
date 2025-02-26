<?php
include_once"../../classes/painel.class.php";
include_once"../../itens/classes/gest-item.class.php";


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
 
 
    public static function finalizaMoviment($id){
       
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
        
    public static function manutencaoItem($id){

        
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


    public static function getItensMoviment($id){
        
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


    public static function getItensDevolvidos($id){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM item_movimentacao WHERE id_movimentacao = $id and dt_devolucao IS NOT NULL ");
        $rs->execute();
        $rows = $rs->rowCount();

        if($rows > 0){ 
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }else{
            return ["dados" => null];

        }
        
    }


    public static function getItensReservados($id){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = $id");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        return ["dados" => $resultado];

    }


    public static function devolverItem($id_item, $id_movimentacao){
        $dt = date('Y-m-d H:i:s');
        $db = DB::connect();
        
        // primeiro eu indentifico o id_item_movimentacao que está associado ao item e a movimentação
        
        $rs = $db->prepare("SELECT id_item_movimentacao FROM item_movimentacao WHERE id_item = $id_item and id_movimentacao = $id_movimentacao");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_item_mov = $resultado[0]['id_item_movimentacao'];
        

        // depois eu atualizo a data de devolução do item_movimentacao
        $rs = $db->prepare("UPDATE item_movimentacao SET dt_devolucao = '$dt' WHERE id_item_movimentacao = $id_item_mov");
        $rs->execute();
        $rows = $rs->rowCount();

        if($rows > 0){ 
            echo '<script>';
            echo 'console.log("Tabela item-movimento atualizada");';
            echo '</script>';
                       
            // depois eu atualizo a disponibilidade do item

            $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 1 WHERE id_item = $id_item");
            $rs->execute();
            $rows = $rs->rowCount();

            if($rows > 0){  

                echo '<script>';
                echo 'console.log("Disponibilidade atualizada");';
                echo '</script>';
                return true;
            }
        }

    }

    
    public static function getItensDisponiveis($id){
        
        if($id){

            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = $id order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }else{            
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = 1 order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }

    }


    public static function getMoviment($id){
        
        if($id){
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM movimentacao WHERE id_movimentacao = $id and dt_finalizacao IS NULL ");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }else{
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM movimentacao WHERE dt_finalizacao IS NULL order by id_movimentacao desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }
    
    }


    public static function getMovimentEncerrado()
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM movimentacao WHERE dt_finalizacao IS NOT NULL order by id_movimentacao desc");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        return ["dados" => $resultado];

    }    


    //ver a necessidade de passar a função abaixo para a clase gest-item
    public static function reservaItem($id, $mov){    
        $db = DB::connect();

        $rs = $db->prepare("SELECT id_responsavel FROM movimentacao WHERE id_movimentacao = $mov");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_responsavel = ($resultado[0]['id_responsavel']);

        $rs = $db->prepare("SELECT nv_permissao FROM usuarios WHERE id_usuario = $id_responsavel");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $nv_perm_user = ($resultado[0]['nv_permissao']);

        $rs = $db->prepare("SELECT nv_permissao FROM item WHERE id_item = $id");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $nv_perm_item = ($resultado[0]['nv_permissao']);

        if($nv_perm_item > $nv_perm_user){
            $_SESSION['msg'] = 'AVISO: NÍVEL DO ITEM É MAIOR QUE O DO FUNCIONÁRIO!';
        }

        $rs = $db->prepare("UPDATE item SET nr_disponibilidade = $mov WHERE id_item = $id");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            return true;
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