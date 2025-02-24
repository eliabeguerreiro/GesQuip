<?php
// if(Usuarios::verificar($conn, $headers)){  }  
class Painel
{


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

    public static function getItensDisponiveis(){
        
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM item WHERE nr_disponibilidade = 1 order by id_item desc");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
    
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


    public static function validarToken()
    {
        $chave = 'TESTEDEUMASENHA123';
        $token = $_COOKIE['token'];
        $token_array = explode('.', $token);
        $header = $token_array[0];
        $payload = $token_array[1];
        $signature = $token_array[2];

        $validar_assinatura = hash_hmac('sha256', "$header.$payload", $chave, true);
        $validar_assinatura = base64_encode($validar_assinatura);

        if($signature == $validar_assinatura){

            $dados_token = base64_decode($payload);
            $dados_token = json_decode($dados_token);


            if($dados_token->exp > time()){
                
                return true;

            }else{
                return false;
            }

        }else{

            return false;

        }

       
    }


    public static function logOut()
    {
        $_COOKIE['token'] = null;
        $_SESSION['msg'] = 'Usuário deslogado.';
        header('Location: ../');

    }

  
}