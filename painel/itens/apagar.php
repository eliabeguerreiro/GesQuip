<?php
session_start();
include_once"classes/gest-item.class.php";
include_once"classes/db.class.php";

//var_dump($_SESSION);
//var_dump($_GET);

$item = Painel::getItens($_GET['id']);

if(isset($_GET['apagar'])){
    if ($reserva = Painel::deleteItem($_GET['id'])) {
        $_SESSION['msg'] = "Item apagado com sucesso!";
        header('Location:index.php');
    } else {
        echo "Falha ao apagar o item.";
    }
}

$id = $_GET['id'];
$id_fam = $item['dados'][0]['id_familia'];
$fam = Painel::getFamilia($id_fam);


$fami = $fam['dados'];
$familia = $fami[0]['ds_familia'];



$cod = $item['dados'][0]['cod_patrimonio'];
$nome = $item['dados'][0]['ds_item'];

if(Painel::validarToken()){

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
}
if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}


$html = <<<HTML
<!DOCTYPE html>
    <html>
        <head>
            <title>Movimentação N:$id</title>
            <link rel="stylesheet" href="src/style.css">
            
        </head>
<body>
    <nav>
        <i class="fa fa-user"></i> Olá, Usuário!
        <div class="logo">Gerencia de movimentação</div>
        <a href='../'><button class="sair"><i class="fa fa-sign-out"></i>Voltar</button></a>
    </nav>
    <main>
        
    <div class="box2">
    <center>
        <h1>Tem certeza que quer apagar o item abaixo?</h1>
        <h2>Cod: $cod</h2>
        <h2>Familia: $familia</h2>
        <h2>Nome: $nome</h2>
HTML;

$html .="<a href='?apagar=apagar&id=$id'><button class='manutencao-button'>Apagar</button></a>";

$html.= <<<HTML

    </center>
    </div>     
    </main>
    <br><br>
    <script>

    </script>
</body>
</html>

HTML;

echo $html;
