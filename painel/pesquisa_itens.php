<?php
include_once"classes/db.class.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chave = $_POST['chave'];
    $busca = $_POST['busca'];

    // Conectar ao banco de dados
    $db = DB::connect();


    if ($chave == 'ds_item') {
        
        $stmt = $db->prepare("SELECT * FROM item WHERE $chave LIKE '%$busca%'");
   
    } else if ($chave == 'cod_patrimonio') {

        $stmt = $db->prepare("SELECT * FROM item WHERE $chave = '$busca'");


    }
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultados as $key => $value) {

        $stmt = $db->prepare("SELECT * FROM familia WHERE id_familia = '$value[id_familia]'");
        $stmt->execute();
        $resultados[$key]['familia'] = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['ds_familia'];
    
    
        //var_dump($value);

        if ($value['nr_disponibilidade'] != 1) {

            $query = $db->prepare("SELECT * FROM item_movimentacao WHERE id_item = $value[id_item] ORDER BY id_item_movimentacao DESC LIMIT 1");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $moviment = $result['0']['id_movimentacao'];
            
            $resultados[$key]['movimentacao'] = $moviment;

            $query = $db->prepare("SELECT id_responsavel FROM movimentacao WHERE id_movimentacao = $moviment");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $id_user = $result['0']['id_responsavel'];

            $query = $db->prepare("SELECT nm_usuario FROM usuarios WHERE id_usuario = $id_user");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $user = $result['0']['nm_usuario'];

            $resultados[$key]['usuario'] = $user;

            //var_dump($result);

        }
    


    }

    echo json_encode($resultados);

}

