<?php
session_start();
include_once "classes/gest-user.class.php";
include_once "classes/db.class.php";

// Verifica se os dados necessários foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT); // Valida o ID como inteiro
    $metadata = filter_input(INPUT_POST, 'metadata', FILTER_SANITIZE_STRING); // Remove caracteres inválidos
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING); // Remove caracteres inválidos

    // Verifica se os dados são válidos
    if ($id && $metadata && $data) {
        try {
            // Chama a função para atualizar o usuário
            if (User::updateUsuario($id, $metadata, $data)) {
                echo "Atualização realizada com sucesso!";
            } else {
                echo "Falha ao atualizar o usuário.";
            }
        } catch (Exception $e) {
            // Em caso de erro, exibe uma mensagem de falha e registra o erro
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            echo "Ocorreu um erro ao processar sua solicitação. Por favor, tente novamente mais tarde.";
        }
    } else {
        echo "Dados inválidos ou ausentes.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>