<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-moviment.class.php";
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";


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




$funcionarios = User::getFuncionarios(null);
$moviment = Moviment::getMoviment(null);
$moviment_encerrado = Moviment::getMovimentEncerrado();


if(isset($_GET['sair'])){Paineel::logOut();}

if($_POST){  
    if($cad_mov = Moviment::setMoviment($_POST)){ header('location:escolher_itens.php?id='.$cad_mov);}
} 



$pagina = new ContentPainelMoviment;
echo $pagina->renderHeader();
if(isset($_GET['pagina'])){
    echo $pagina->renderBody($_GET['pagina'], $funcionarios['dados'], $moviment['dados'], $moviment_encerrado['dados']);
}else{
    echo $pagina->renderBody(null, $funcionarios['dados'], $moviment['dados'], $moviment_encerrado['dados']);
}

?>

