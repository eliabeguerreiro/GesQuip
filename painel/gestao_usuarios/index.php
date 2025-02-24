<?php
session_start();
ob_start();
//var_dump($_SESSION);

include_once"classes/conteudo.painel-user.class.php";
include_once"classes/gest-user.class.php";
include_once"classes/db.class.php";

if(Painel::validarToken()){

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
}
if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}

if(isset($_GET['sair'])){Painel::logOut();}

$usuarios = Painel::getUsuarios(null);
$pagina = new ContentPainel;

if($_POST){  if($cad_item = Painel::setUsuario($_POST)){ header('location:');
}} 

echo $pagina->renderHeader();
echo $pagina->renderBody($usuarios['dados']);


?>

