<?php
include_once"classes/gest-manutencao.class.php";
include_once"classes/db.class.php";

//var_dump($_POST);

if ($reserva = Painel::encerraManutencao($_POST['id'], $_POST['texto'], $_POST['status'])) {
    echo "Devolução realizada com sucesso!";
} else {
    echo "Falha ao realizar a devolução.";
}
