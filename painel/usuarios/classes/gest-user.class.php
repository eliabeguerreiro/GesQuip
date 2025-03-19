<?php
include_once"../../classes/painel.class.php";

class User
{

    public static function getFuncionarioNome($id_func)
{
    if ($id_func) {
        $id_func = (int)$id_func;
        $db = DB::connect();
        $rs = $db->prepare("SELECT nm_usuario FROM usuarios WHERE id_usuario = :id_usuario");
        $rs->bindParam(':id_usuario', $id_func, PDO::PARAM_INT);
        $rs->execute();
        $resultado = $rs->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado['nm_usuario']; // Retorna o nome da família
        }
    }

    return null; 
}
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


    public static function updateUsuario($id, $metadata, $data)
    {
        // Validação inicial
        if (!in_array($metadata, ['nm_usuario', 'nr_contato', 'nv_permissao'])) {
            throw new InvalidArgumentException("Campo metadata inválido.");
        }
    
        // Conexão com o banco de dados
        $db = DB::connect();
    
        try {
            // Define o tipo de dado para nv_permissao
            if ($metadata === 'nv_permissao') {
                $data = intval($data); // Converte para inteiro
            } else {
                $data = trim($data); // Remove espaços em branco
            }
    
            // Prepara a consulta SQL
            $sql = "UPDATE usuarios SET $metadata = :data WHERE id_usuario = :id";
            $stmt = $db->prepare($sql);
    
            // Bind dos parâmetros
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Executa a consulta
            $result = $stmt->execute();
    
            return $result; // Retorna true se a atualização foi bem-sucedida
        } catch (PDOException $e) {
            // Registra o erro e relança a exceção
            error_log("Erro ao executar consulta SQL: " . $e->getMessage());
            throw $e;
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