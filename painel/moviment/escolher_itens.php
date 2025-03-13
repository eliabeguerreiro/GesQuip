<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-moviment.class.php";
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";


$itens = Item::getItensDisponiveis(null);
$pagina = new ContentPainelMoviment;
$fami = Item::getFamilia();


//como remover itens da disponibilidade caso hajam mais de um adm para gerir 

//salvo o ID da movimentação em um cookie para ser usado na escolha de itens

if(isset($_GET['id'])){
    $_SESSION['id_moviment'] = $_GET['id'];
    header('location:escolher_itens.php');
}


if(Paineel::validarToken()){

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
}
if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}

if($_SESSION['id_moviment']){
    $id = $_SESSION['id_moviment'];
    $moviment = Moviment::getMoviment($id);
    $id_resp = $moviment['dados'][0]['id_responsavel'];
    $funcionario = User::getFuncionarios($id_resp);
    $responsavel = $funcionario['dados'][0]['nm_usuario'];
    $nome = $_SESSION['data_user']['nm_usuario'];

    $html = <<<HTML
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Movimentação N:$id</title>
                <link rel="stylesheet" href="src/style.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            </head>
            <body>
                <!-- INÍCIO BARRA DE NAVEGAÇÃO -->
                <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><b>GesQuip</b></a>
                        <div class="navbar-collapse justify-content-center" id="collapsibleNavbar">
                            <ul class="navbar-nav text-center">
                                <li class="nav-item">
                                    <h2 class="navbar-brand mb-0">Escolha de Equipamentos</h2>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex ms-auto">
                            <a href="?sair=1" class="btn btn-danger btn-sm">Cancelar</a>
                        </div>
                    </div>
                </nav>
                <!-- FIM BARRA DE NAVEGAÇÃO -->

                <main class="mt-5 pt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="box2 p-4 rounded shadow-sm" style="background-color: #fff;">
                                    <h2 class="text-primary">Movimentação N:$id</h2>
                                    <small class="text-muted">Funcionário responsável: $responsavel</small>
                                    <form method="POST" action="envia_moviment.php">

    HTML;
    if ($reservado = Item::getItensReservados($id)) {
        $html .= <<<HTML
                            <h3 class="mt-4">Itens Reservados</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Família</th>
                                        <th>Nome</th>
                                    </tr>
                                </thead>
                                <tbody>
        HTML;

        foreach ($reservado['dados'] as $res) {
            $id_fami = $res['id_familia'];
            foreach ($fami['dados'] as $familiaa) {
                if ($familiaa['id_familia'] == $id_fami) {
                    $nm_familia = $familiaa['ds_familia'];
                }
            }
            $html .= "<tr>";
            $html .= "<td>" . $res['id_item'] . "</td>";
            $html .= "<td>" . $nm_familia . "</td>";
            $html .= "<td>" . $res['ds_item'] . "</td>";
            $html .= "</tr>";
        }

        $html .= <<<HTML
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Finalizar Movimentação</button>
                        </form>
                    </div>
        HTML;
        }     
        $html .= <<<HTML
                    <div class="box2 mt-4 p-4 rounded shadow-sm" style="background-color: #fff;">
                        <h1 class="text-primary">Itens Disponíveis</h1>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Família</th>
                                    <th>Nome</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody id="produtos">
HTML;

        foreach ($itens['dados'] as $item) {
            $id_fami = $item['id_familia'];
            foreach ($fami['dados'] as $familiaa) {
                if ($familiaa['id_familia'] == $id_fami) {
                    $nm_familia = $familiaa['ds_familia'];
                }
            }
            $html .= "<tr>";
            $html .= "<td>" . $item['cod_patrimonio'] . "</td>";
            $html .= "<td>" . $nm_familia . "</td>";
            $html .= "<td>" . $item['ds_item'] . "</td>";
            $html .= "<td><button class='btn btn-success reservar-button' id='" . $item['id_item'] . "'>Reservar</button></td>";
            $html .= "</tr>";
        }

        $html .= <<<HTML
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const reservarButtons = document.querySelectorAll('.reservar-button');

        reservarButtons.forEach(button => {
            button.addEventListener('click', () => {
                const itemId = button.id;

                fetch('reservar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + encodeURIComponent(itemId)
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>
HTML;

    echo $html;
} else {
    $_SESSION['msg'] = 'Movimentação não encontrada';
    header('location:escolher_itens.php');
}
