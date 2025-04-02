<?php
// if(Usuarios::verificar($conn, $headers)){  }  

include_once"../itens/classes/gest-item.class.php";
include_once"../usuarios/classes/gest-user.class.php";
include_once"../moviment/classes/gest-moviment.class.php";

class Manutencao
{




    public static function encerraManutencao($id_manutencao, $obs, $diponibilidade, $custo, $user){
        $dt = date('Y-m-d H:i:s');
        $db = DB::connect();
        
        $rs = $db->prepare("SELECT id_item FROM manutencao WHERE id_manutencao = $id_manutencao");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_item = $resultado[0]['id_item'];
      
        // primeiro eu atualizo a disponibilidade do item
        $rs = $db->prepare("UPDATE item SET nr_disponibilidade = $diponibilidade WHERE id_item = $id_item");
        $rs->execute();
        $rows = $rs->rowCount();
        if($rows > 0){ 
                           
        // depois eu atualizo a observação e a data de devolução da manutencao
        $rs = $db->prepare("UPDATE manutencao SET dt_fim_manutencao = '$dt', obs_out = '$obs', custo_manutencao = $custo, id_autor_final = $user WHERE id_manutencao = $id_manutencao");
        $rs->execute();
        $rows = $rs->rowCount();
            
            if($rows > 0){ 
                $_SESSION['msg'] = "<div  class='container mt-4'><div class='msg success'><i class='fas fa-check-circle'></i>Manutenção Finalizada!</div></div>"; 
                return true;
            }
        }
        
    }



    public static function getManutencao($id = null, $nm_filtro = null, $filtro = null){
        $obra = $_SESSION['obra_atual'];
        $db = DB::connect();

        if ($id) {
            $rs = $db->prepare("SELECT * FROM manutencao WHERE id_manutencao = $id");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        } else {

            if ($nm_filtro) {
                if ($nm_filtro == 'dt_movimentacao') {
                    if (strpos($filtro, '...') !== false) {
                        list($start, $end) = explode('...', $filtro);
                        $rs = $db->prepare("SELECT * FROM manutencao WHERE dt_inicio_manutencao BETWEEN '$start' AND '$end' AND dt_fim_manutencao IS NULL AND id_obra = $obra ORDER BY id_manutencao DESC");
                    }
                } else {
                    $rs = $db->prepare("SELECT * FROM manutencao WHERE $nm_filtro = '$filtro' AND dt_fim_manutencao IS NULL AND id_obra = $obra ORDER BY id_manutencao DESC");
                }
                $rs->execute();
                $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
                return ["dados" => $resultado];

            }else{
                
                $rs = $db->prepare("SELECT * FROM manutencao WHERE dt_fim_manutencao IS NULL AND id_obra = $obra ORDER BY id_manutencao DESC");
                $rs->execute();
                $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
                return ["dados" => $resultado];

            }
           
        }
    }

    public static function getManutencaoEncerrada( $nm_filtro = null, $filtro = null){
        $obra = $_SESSION['obra_atual'];
        $db = DB::connect();

        if ($nm_filtro) {
            if ($nm_filtro == 'dt_movimentacao') {
                if (strpos($filtro, '...') !== false) {
                    list($start, $end) = explode('...', $filtro);
                    $rs = $db->prepare("SELECT * FROM manutencao WHERE dt_inicio_manutencao BETWEEN '$start' AND '$end' AND dt_fim_manutencao IS NOT NULL AND id_obra = $obra ORDER BY id_manutencao DESC");
                }
            } else {
                $rs = $db->prepare("SELECT * FROM manutencao WHERE $nm_filtro = '$filtro' AND dt_fim_manutencao IS NOT NULL AND id_obra = $obra ORDER BY id_manutencao DESC");
            }
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        } else {
            $rs = $db->prepare("SELECT * FROM manutencao WHERE dt_fim_manutencao IS NOT NULL AND id_obra = $obra ORDER BY id_manutencao DESC");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];
        }

    }

    public static function manutencaoItem($id = null){
        $obra = $_SESSION['obra_atual'];
        $dt = date('Y-m-d H:i:s');
        $db = DB::connect();
        $id_item = $id;
        $id_mov = $_SESSION['id_moviment'];
        $user = $_SESSION['data_user'];
       
        $rs = $db->prepare("SELECT * FROM item_movimentacao WHERE id_item = $id_item and id_movimentacao = $id_mov");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_it_mov = $resultado[0]['id_item_movimentacao'];
        $id_mov = $resultado[0]['id_movimentacao'];
     
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

                $rs = $db->prepare("INSERT INTO manutencao (id_item, id_item_movimentacao, id_autor, obs_in, id_obra)
                VALUES(".$id_item.",".$id_mov.",'".$user['id_usuario']."','".$_POST['descricao']."',".$obra.")");
                $rs->execute();
                $rows = $rs->rowCount();
                
                if ($rows > 0){

                    $_SESSION['msg'] = "<div  class='container mt-4'><div class='msg success'><i class='fas fa-check-circle'></i>Manutenção Iniciada!</div></div>";
                    return true;
                }
            }
        }
            
    }
  
    public static function manutencaoDireta($dados){
        $obra = $_SESSION['obra_atual'];
        $id = $dados['id_item'];
        $texto = $dados['obs_in'];

       
        $db = DB::connect();
        $id_item = $id;
        $user = $_SESSION['data_user'];

        //echo("SELECT id_item_movimentacao FROM item_movimentacao WHERE id_item = $id_item");
       
        $rs = $db->prepare("SELECT * FROM item_movimentacao WHERE id_item = $id_item ORDER BY id_item_movimentacao DESC LIMIT 1");
        $rs->execute();
        $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
        $id_mov = $resultado[0]['id_movimentacao'];


        //echo("UPDATE item_movimentacao SET dt_devolucao = '$dt' WHERE id_item_movimentacao = $id_it_mov");
        $rs = $db->prepare("UPDATE item SET nr_disponibilidade = 2 WHERE id_item = $id_item");
        $rs->execute();
        $rows = $rs->rowCount();

        if($rows > 0){ 

                $rs = $db->prepare("INSERT INTO manutencao (id_item, id_item_movimentacao, id_autor, obs_in, id_obra)
                VALUES(".$id_item.",".$id_mov.",'".$user['id_usuario']."','$texto',".$obra.")");
                $rs->execute();
                $rows = $rs->rowCount();
                
                if ($rows > 0){
                    $_SESSION['msg'] = "<div  class='container mt-4'><div class='msg success'><i class='fas fa-check-circle'></i>Manutenção Direta Iniciada!</div></div>";
                    return true;              
                }
            }
        
            
    }


}