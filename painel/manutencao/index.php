<?php
session_start();
ob_start();
include_once"classes/conteudo.manutencao-itens.class.php";
include_once"classes/gest-manutencao.class.php";
include_once"classes/db.class.php";


$mantencs = Manutencao::getManutencao();
$mantencs_encerradas = Manutencao::getManutencaoEncerrada();

$itens = Item::getItens();
$pagina = new ContentPainelManutencao;


if(Paineel::validarToken()){

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
}
if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}
if($_POST){

    var_dump($_POST);
    if($manutec = Manutencao::manutencaoDireta($_POST)){
        header('Location: ');
    }
    
}


//var_dump($itens);

echo $pagina->renderHeader();

if(isset($_GET['pagina'])){
    echo $pagina->renderBody($_GET['pagina'], $mantencs['dados'], $mantencs_encerradas['dados']);
}else{
    echo $pagina->renderBody(null, $mantencs['dados'], $mantencs_encerradas['dados']);
}

?>

