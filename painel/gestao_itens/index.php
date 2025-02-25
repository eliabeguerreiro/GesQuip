<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-itens.class.php";
include_once"classes/gest-item.class.php";
include_once"classes/db.class.php";




$familia = Painel::getFamilia(null);
$itens = Painel::getItens(null, null, null);
$itens_disponiveis = Painel::getItensDisponiveis();
$itens_locados = Painel::getItensLocados();


if(User::validarToken()){

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
    exit;
}


if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
    exit;
}

if(isset($_GET['sair'])){User::logOut();}




if($_POST){  if($cad_item = Painel::setItem($_POST)){ header('location:');}} 



//var_dump($itens);
$pagina = new ContentPainel;
echo $pagina->renderHeader();

if(isset($_GET['pagina'])){
    echo $pagina->renderBody($_GET['pagina'], $familia['dados'], $itens['dados'], $itens_disponiveis['dados'], $itens_locados['dados']);
}else{
    echo $pagina->renderBody(null, $familia['dados'], $itens['dados'], $itens_disponiveis['dados'], $itens_locados['dados']);
}

?>

