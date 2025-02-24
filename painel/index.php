<?php
session_start();
ob_start();
//var_dump($_SESSION);

include_once"classes/conteudo.painel.class.php";
include_once"classes/painel.class.php";

if (User::validarToken()) {
    // O token é válido, permita acesso ao painel
} else {
    // O token é inválido, redirecione para a página de login
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../');
    exit;
}
if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}

if(isset($_GET['sair'])){User::logOut();}


$pagina = new ContentPainel;
echo $pagina->renderHeader();
echo $pagina->renderBody();



?>
