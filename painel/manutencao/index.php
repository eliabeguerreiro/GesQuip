<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-manutencao.class.php";
include_once"classes/gest-manutencao.class.php";
include_once"classes/db.class.php";

$mantencs = Manutencao::getManutencao();
$mantencs_encerradas = Manutencao::getManutencaoEncerrada();

$itens = Item::getItens();
$pagina = new ContentPainelManutencao;


if(Paineel::validarToken()){

    echo $pagina->renderHeader();

    if(isset($_GET['pagina'])){
        echo $pagina->renderBody($_GET['pagina'], $mantencs['dados'], $mantencs_encerradas['dados']);
    }else{
        echo $pagina->renderBody(null, $mantencs['dados'], $mantencs_encerradas['dados']);
    }

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
}

if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}

if($_POST){

    if($manutec = Manutencao::manutencaoDireta($_POST)){
        header('Location: ');
    }
}


?>

