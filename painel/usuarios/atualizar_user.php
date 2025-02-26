<?php
session_start();
include_once"classes/gest-user.class.php";
include_once"classes/db.class.php";

//var_dump($_POST);

if ($atualiza = User::updateUsuario($_POST['id'], $_POST['metadata'], $_POST['data'])) {
    echo "Atualização realizada com sucesso!";
} else {
    echo "Falha ao atualizar a reserva.";
}
    
?>