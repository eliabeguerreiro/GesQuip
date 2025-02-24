<?php
// if(Usuarios::verificar($conn, $headers)){  }  
class Painel
{





    public static function updateUsuario($id, $metadata, $data){

        if($metadata == 'nv_permissao'){
            $data = intval($data);

            $sql = "UPDATE usuarios SET $metadata = $data WHERE id_usuario = $id";

        }else{
            
            $sql = "UPDATE usuarios SET $metadata = '$data' WHERE id_usuario = $id";
        }




        //echo($sql);

        $db = DB::connect();
        $rs = $db->prepare($sql);
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $_SESSION['mag'] = 'Item cadastrado com Sucesso!';
            return true;
        }   

    }

    public static function deleteUsuario($id){

        $db = DB::connect();
        $rs = $db->prepare("DELETE FROM usuarios WHERE id_usuario = $id");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $_SESSION['mag'] = 'Item cadastrado com Sucesso!';
            return true;
        }   
      
    }


    public static function getUsuarios($id){

        if($id){

            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM usuarios WHERE id_usuario = $id");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }else{

            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM usuarios ");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }
    }

    public static function setUsuario($data)
    {

        $password = password_hash($data['senha'], PASSWORD_DEFAULT);
        //echo("INSERT INTO usuarios (login , senha, nm_usuario, nr_contato, id_empresa, tp_usuario, nv_permissao)  VALUES('".$data['login']."','".$password."','".$data['nm_usuario']."','".$data['contato']."', 1, 'user', ".$data['nv_permissao'].")");
        
        $db = DB::connect();
        $rs = $db->prepare("INSERT INTO usuarios (login , senha, nm_usuario, nr_contato, id_empresa, tp_usuario, nv_permissao)
         VALUES('".$data['login']."','".$password."','".$data['nm_usuario']."','".$data['contato']."', 1, 'user', ".$data['nv_permissao'].")");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $_SESSION['mag'] = 'Item cadastrado com Sucesso!';
            return true;
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