<?php
include_once"../../classes/painel.class.php";

class User
{

    public static function getFuncionarios($id = null)
    {
        if($id){
            
            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM usuarios where id_usuario = $id");
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
         VALUES('".$data['login']."','".$password."','".$data['nm_usuario']."','".$data['nr_contato']."', 1, 'user', ".$data['nv_permissao'].")");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $_SESSION['mag'] = 'Item cadastrado com Sucesso!';
            return true;
        }
    
        
       
    }

  
}