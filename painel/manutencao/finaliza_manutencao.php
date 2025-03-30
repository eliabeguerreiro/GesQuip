<?php
session_start();
include_once"classes/gest-manutencao.class.php";
include_once"classes/db.class.php";

//var_dump($_POST);
$custoManutencao = $_POST['custo'];
$custo = floatval($custoManutencao);
$user_final = $_SESSION['data_user']['id_usuario'];
        

if ($reserva = Manutencao::encerraManutencao($_POST['id'], $_POST['texto'], $_POST['status'], $custo, $user_final)) {
    echo "Devolução realizada com sucesso!";
} else {
    echo "Falha ao realizar a devolução.";
}
