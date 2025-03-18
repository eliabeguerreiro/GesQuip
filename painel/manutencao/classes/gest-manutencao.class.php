<?php
// if(Usuarios::verificar($conn, $headers)){  }  

include_once"../itens/classes/gest-item.class.php";
include_once"../usuarios/classes/gest-user.class.php";
include_once"../moviment/classes/gest-moviment.class.php";

class Manutencao
{


    public static function manutencaoDireta($dados){
        $id = $dados['id_item'];
        $texto = $dados['obs_in'];

       
        $db = DB::connect();
        $id_item = $id;
        $user = $_SESSION['data_user'];

        //echo("SELECT id_item_movimentacao FROM item_movimentacao WHERE id_item = $id_item");
       
        $rs = $db->prepare("SELECT id_item_movimentacao FROM item_movimentacao WHERE id_item = $id_item ORDER BY id_item_movimentacao DESC LIMIT 1");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_it_mov = $resultado[0]['id_item_movimentacao'];


        //echo("UPDATE item_movimentacao SET dt_devolucao = '$dt' WHERE id_item_movimentacao = $id_it_mov");
        $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 2 WHERE id_item = $id_item");
        $rs->execute();
        $rows = $rs->rowCount();

        if($rows > 0){ 

                $rs = $db->prepare("INSERT INTO manutencao (id_item, id_item_movimentacao, id_autor, obs_in)
                VALUES(".$id_item.",".$id_it_mov.",'".$user['id_usuario']."','$texto')");
                $rs->execute();
                $rows = $rs->rowCount();
                
                if ($rows > 0){
                    return true;
                }
            }
        
            
    }


    public static function encerraManutencao($id_manutencao, $obs, $diponibilidade){
        $dt = date('Y-m-d H:i:s');
        $db = DB::connect();
        
        $rs = $db->prepare("SELECT * FROM manutencao WHERE id_manutencao = $id_manutencao");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $manutencao = $resultado[0]['id_item'];
      
        // primeiro eu atualizo a disponibilidade do item
        
        $rs = $db->prepare("UPDATE item SET nr_disponibilidade = $diponibilidade WHERE id_item = $manutencao");
        $rs->execute();
        $rows = $rs->rowCount();
        if($rows > 0){ 
                           
        // depois eu atualizo a observação e a data de devolução da manutencao
        $rs = $db->prepare("UPDATE manutencao SET dt_fim_manutencao = '$dt', obs_out = '$obs' WHERE id_manutencao = $id_manutencao");
        $rs->execute();
        $rows = $rs->rowCount();
            
            if($rows > 0){  
                return true;
            }
        }
        
    }



    public static function getManutencao($id = null, $filtro = null, $valor = null){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM manutencao WHERE dt_fim_manutencao IS NULL order by id_item desc");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        return ["dados" => $resultado];

    }

    public static function getManutencaoEncerrada($id = null, $nm_filtro = null, $filtro = null){
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM manutencao WHERE dt_fim_manutencao IS NOT NULL order by id_item desc");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        return ["dados" => $resultado];

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