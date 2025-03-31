<?php
session_start();
ob_start();
include_once"../../classes/painel.class.php";
include_once"classes/conteudo.lobby.class.php";
include_once"classes/gest-lobby.class.php";
include_once"classes/db.class.php";
//var_dump($_SESSION);


$pagina = new ContentPainelLobby();

if (Paineel::validarToken()) {
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

if(isset($_GET['sair'])){Paineel::logOut();}


echo $pagina->renderHeader();

if($_POST){
    echo $pagina->renderBody($_POST['id_empresa']);
}else{
    echo $pagina->renderBody();
}