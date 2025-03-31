<?php
include_once"../../classes/painel.class.php";

class Lobby
{

    public static function getObra($id){
        $db = DB::connect();

        if($id){
            $rs = $db->prepare("SELECT * FROM obra WHERE id_empresa = $id");
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }else{
            return false;
        }
    }

    public static function getEmpresa($id = null){
        $db = DB::connect();
        if($id){

            if($id == 1){
                $id = $_SESSION['data_user']['id_empresa'];
                $rs = $db->prepare("SELECT * FROM empresa ");
            }else{
                $rs = $db->prepare("SELECT * FROM empresa WHERE id_empresa = $id");
            }           
            $rs->execute();
            $resultado = $rs->fetchAll(PDO::FETCH_ASSOC);
            return ["dados" => $resultado];

        }
    }

    public static function setObra($data)
    {
        $db = DB::connect();
        $rs = $db->prepare("INSERT INTO obra (ds_obra, endereco, CNPJ, resp_tec, id_empresa, id_crea)
         VALUES('".$data['ds_obra']."','".$data['endereco']."','".$data['CNPJ']."', '".$data['resp_tec']."', '".$data['id_crea']."')");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0){
            $_SESSION['msg'] = "<div  class='container mt-4'><div class='msg success'><i class='fas fa-check-circle'></i>Obra criada com sucesso!</div></div>";
            return true;
        } else {
            $_SESSION['msg'] = "<div  class='container mt-4'><div class='msg error' ><i class='fas fa-exclamation-circle'></i> Erro ao criar Obra.</div></div>";
        }   
    }
}