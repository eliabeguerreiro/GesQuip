<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-moviment.class.php";
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";

$funcionarios = User::getFuncionarios(null);
$moviment = Painel::getMoviment(null);
$moviment_encerrado = Painel::getMovimentEncerrado();



$pagina = new ContentPainel;
$movimentacao_incompleta = Painel::verificaMovimentIncompleto();


if(Paineel::validarToken()){

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
    exit;
}


if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}

//Verefica se existe movimentação incompleta e redireciona para a página de escolha de itens
if($movimentacao_incompleta){
    $mov_incomplete = ($movimentacao_incompleta['dados'][0]['nr_disponibilidade']);
    header('location:escolher_itens.php?id='.$mov_incomplete);
}



if(isset($_GET['sair'])){Paineel::logOut();}

if($_POST){  

    if($cad_mov = Painel::setMoviment($_POST)){ header('location:escolher_itens.php?id='.$cad_mov);}
} 


echo $pagina->renderHeader();
echo $pagina->renderBody($funcionarios['dados'], $moviment['dados'], $moviment_encerrado['dados']);


?>

