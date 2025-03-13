<?php
include_once"../../classes/painel.class.php";

// if(Usuarios::verificar($conn, $headers)){  }  
class Item
{

    public static function getFamiliaNome($id_familia)
{
    if ($id_familia) {
        $id_familia = (int)$id_familia;
        $db = DB::connect();
        $rs = $db->prepare("SELECT ds_familia FROM familia WHERE id_familia = :id_familia");
        $rs->bindParam(':id_familia', $id_familia, PDO::PARAM_INT);
        $rs->execute();
        $resultado = $rs->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado['ds_familia']; // Retorna o nome da família
        }
    }

    return null; 
}

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

    public static function getItensReservados($id = null){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = $id");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        return ["dados" => $resultado];

    }

    public static function getItensDevolvidos($id ){
        
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


    public static function getItens($id = null, $nm_filtro = null, $filtro = null){

        if($id){


            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE id_item = $id order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }elseif($nm_filtro){
            //echo("SELECT * FROM item WHERE $nm_filtro = '$filtro'");
            $db = DB::connect(); 
            $rs = $db->prepare("SELECT * FROM item WHERE $nm_filtro = '$filtro' order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        
        
        }else{


            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }
    }

    public static function getItensDisponiveis($nm_filtro = null, $filtro = null){
        
        if($nm_filtro){
            //echo("SELECT * FROM item WHERE $nm_filtro = '$filtro'");
            $db = DB::connect(); 
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = 1 and $nm_filtro = '$filtro' order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }  else{            
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = 1 order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }

    }
    public static function getItensQuebrados($nm_filtro = null, $filtro = null){


        if($nm_filtro){
            //echo("SELECT * FROM item WHERE $nm_filtro = '$filtro'");
            $db = DB::connect(); 
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = 999999999 and $nm_filtro = '$filtro' order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }  else{            
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = 999999999 order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }
      

    }


    public static function getItensLocados($nm_filtro = null, $filtro = null){
        
        if($nm_filtro){
            //echo("SELECT * FROM item WHERE $nm_filtro = '$filtro'");
            $db = DB::connect(); 
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = 0 and $nm_filtro = '$filtro' order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }  else{            
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = 0 order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }
      

    }

    public static function setItem($data)
{
    // Validação básica dos dados recebidos
    if (
        !isset($data['familia']) || empty($data['familia']) ||
        !isset($data['nome']) || empty($data['nome']) ||
        !isset($data['natureza']) || empty($data['natureza']) ||
        !isset($data['nv_permissao']) || empty($data['nv_permissao'])
    ) {
        $_SESSION['error'] = 'Todos os campos são obrigatórios!';
        return false;
    }

    // Conexão com o banco de dados
    $db = DB::connect();

    // Geração do código de patrimônio (aleatório e único)
    $cod_patrimonio = bin2hex(random_bytes(3));

    // Preparação da query SQL
    $sql = "INSERT INTO item (id_familia, ds_item, natureza, nv_permissao, cod_patrimonio) 
            VALUES (:familia, :nome, :natureza, :nv_permissao, :cod_patrimonio)";

    $stmt = $db->prepare($sql);

    // Associação dos parâmetros para evitar injeção SQL
    $stmt->bindParam(':familia', $data['familia'], PDO::PARAM_INT);
    $stmt->bindParam(':nome', $data['nome'], PDO::PARAM_STR);
    $stmt->bindParam(':natureza', $data['natureza'], PDO::PARAM_STR);
    $stmt->bindParam(':nv_permissao', $data['nv_permissao'], PDO::PARAM_INT);
    $stmt->bindParam(':cod_patrimonio', $cod_patrimonio, PDO::PARAM_STR);

    // Execução da query
    if ($stmt->execute()) {
        $_SESSION['msg'] = 'Item cadastrado com sucesso!';
        return true;
    } else {
        $_SESSION['error'] = 'Erro ao cadastrar o item!';
        return false;
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
    public static function getFamilia($id = null)
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