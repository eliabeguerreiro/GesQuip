<?php
include_once"../../classes/painel.class.php";

// if(Usuarios::verificar($conn, $headers)){  }  
class Item
{


    public static function reservaItem($id, $mov){    
        $db = DB::connect();

        $rs = $db->prepare("SELECT id_responsavel FROM movimentacao WHERE id_movimentacao = $mov");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_responsavel = ($resultado[0]['id_responsavel']);

        $rs = $db->prepare(query: "SELECT nv_permissao FROM usuarios WHERE id_usuario = $id_responsavel");
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


    public static function getItensReservados($id){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = $id");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        return ["dados" => $resultado];

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


    public static function devolverItemByPanel($id_item){
        $dt = date('Y-m-d H:i:s');
        $db = DB::connect();
        
        // primeiro eu indentifico o id_item_movimentacao que está associado ao item e a movimentação
        
        $rs = $db->prepare("SELECT id_item_movimentacao FROM item_movimentacao WHERE id_item = $id_item ORDER BY id_item_movimentacao DESC LIMIT 1");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_item_mov = $resultado[0]['id_item_movimentacao'];
        

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

                return true;
            }
        }

    }


    public static function getItens($id, $nm_filtro, $filtro){

        if($id){


            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE id_item = $id");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }elseif($nm_filtro){
            echo("SELECT * FROM item WHERE $nm_filtro = '$filtro'");
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE $nm_filtro = '$filtro'");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        
        
        }else{


            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item ");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }
    }

    public static function getItensDisponiveis($id = null){
        
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
    public static function getItensQuebrados(){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM item  WHERE nr_disponibilidade = 999999999 order by id_item desc");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        return ["dados" => $resultado];

    }


    public static function getItensLocados(){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM item  WHERE nr_disponibilidade = 0 order by id_item desc");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        return ["dados" => $resultado];

    }

    public static function setItem($data){


        $db = DB::connect();

        $cod_patrimonio = bin2hex(random_bytes(3));

        $rs = $db->prepare("INSERT INTO item (id_familia, ds_item, natureza, nv_permissao, cod_patrimonio)
         VALUES(".$data['familia'].",'".$data['nome']."','".$data['natureza']."',".$data['nv_permissao'].",'$cod_patrimonio')");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $_SESSION['mag'] = 'Item cadastrado com Sucesso!';
            return true;
        }
    

       
    }

    public static function deleteItem($id){

        $db = DB::connect();
        $rs = $db->prepare("DELETE FROM item WHERE id_item = $id");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $_SESSION['mag'] = 'Item cadastrado com Sucesso!';
            return true;
        }   
      
    }

    public static function updateItem($id, $data){

        $db = DB::connect();
        $rs = $db->prepare("UPDATE item SET ds_item = '$data' WHERE id_item = $id");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $_SESSION['mag'] = 'Item cadastrado com Sucesso!';
            return true;
        }   
      
    }
    public static function getFamilia($id)
    {

        if($id){

            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM familia WHERE id_familia = $id");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }else{
            
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM familia ");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }

    }
  
}