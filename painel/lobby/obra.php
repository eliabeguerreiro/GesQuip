<?php
session_start();
ob_start();

if (isset($_GET['obra'])) {
    $_SESSION['obra_atual'] = $_GET['obra'];
    header('Location: ../../painel/');
    exit;
} else {
    echo "Erro: Nenhuma obra foi selecionada.";
}