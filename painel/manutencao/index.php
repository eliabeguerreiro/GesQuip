<?php
session_start();
ob_start();
include_once"classes/conteudo.manutencao-itens.class.php";
include_once"classes/gest-manutencao.class.php";
include_once"classes/db.class.php";


$mantencs = Manutencao::getItensManutencao();
$itens = Item::getItens();
$pagina = new ContentPainel;
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
echo $pagina->renderBody($mantencs['dados'], $itens['dados']);


?>

