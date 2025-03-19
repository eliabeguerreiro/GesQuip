<?php
session_start();
ob_start();
include_once "classes/conteudo.painel-moviment.class.php";
include_once "classes/gest-moviment.class.php";
include_once "classes/db.class.php";

$pagina = new ContentPainelMoviment;
$itens = Item::getItens();
$fami = Item::getFamilia();

if (Paineel::validarToken()) {
    // Token válido
} else {
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../');
}

if (!isset($_SESSION['data_user'])) {
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../');
}

if (isset($_GET['id'])) {
    $_SESSION['id_moviment'] = $_GET['id'];
    header('location:moviment.php');
}

if ($_SESSION['id_moviment']) {
    $id = $_SESSION['id_moviment'];
    $moviment = Moviment::getMoviment($id);
    $item_mov = Moviment::getItensMoviment($id);
    $item_devolv = Item::getItensDevolvidos($id);

    if ($item_mov['dados'] == null) {
        if (Moviment::finalizaMoviment($id)) {
            header('location:index.php?pagina=ativas');
        }
    }

    $id_responsavel = $moviment['dados'][0]['id_responsavel'];
    $funcionario = User::getFuncionarios($id_responsavel);
    $responsavel = $funcionario['dados'][0]['nm_usuario'];
    $nome = $_SESSION['data_user']['nm_usuario'];

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

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
            <a class="navbar-brand" href="../"><b>GesQuip</b></a>
            <div class="navbar-collapse justify-content-center" id="collapsibleNavbar">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <h2 class="navbar-brand mb-0">Detalhes da Movimentação</h2>
                    </li>
                </ul>
            </div>
            <div class="d-flex ms-auto">
                <button id="cancelarMovimentacao" class="btn btn-danger btn-sm">Voltar</button>
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

                        <h3 class="mt-4">Itens em Uso</h3>
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

    foreach ($item_mov['dados'] as $item) {
        $dados_item = Item::getItens($item['id_item'], null, null);
        $dados_item = $dados_item['dados'];
        $nm_item = Item::getItemNome($dados_item[0]['id_item']);
        $nm_familia = Item::getFamiliaNome($dados_item[0]['id_familia']);
        $cod = $dados_item[0]['cod_patrimonio'];

        $html .= "<tr>";
        $html .= "<td>" . $cod . "</td>";
        $html .= "<td>" . $nm_familia . "</td>";
        $html .= "<td>" . $nm_item . "</td>";
        $html .= "<td><button class='btn btn-warning manutencao-button' id='" . $item['id_item'] . "'>Manutenção</button></td>";
        $html .= "<td><button class='btn btn-success devolver-button' id='" . $item['id_item'] . "'>Devolver</button></td>";
        $html .= "</tr>";
    }

    $html .= <<<HTML
                            </tbody>
                        </table>
                    </div>

                    <div class="box2 mt-4 p-4 rounded shadow-sm" style="background-color: #fff;">
                        <h3 class="text-primary">Itens Devolvidos</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Família</th>
                                    <th>Nome</th>
                                    <th>Data da Devolução</th>
                                </tr>
                            </thead>
                            <tbody>
HTML;

    if ($item_devolv['dados'] == null) {
        $html .= "<tr><td colspan='4'>Nenhum item devolvido</td></tr>";
    } else {
        foreach ($item_devolv['dados'] as $item) {
            $nm_item = Item::getItemNome($item['id_item']);
            $item_data = Item::getItens($item['id_item'], null, null);
            $nm_familia = Item::getFamiliaNome($item_data['dados'][0]['id_familia']);
            $html .= "<tr>";
            $html .= "<td>" . $cod . "</td>";
            $html .= "<td>" . $nm_familia . "</td>";
            $html .= "<td>" . $nm_item . "</td>";
            $html .= "<td>" . $item['dt_devolucao'] . "</td>";
            $html .= "</tr>";
        }
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
        document.addEventListener('DOMContentLoaded', () => {
            const manutencaoButtons = document.querySelectorAll('.manutencao-button');
            const devolverButtons = document.querySelectorAll('.devolver-button');

            manutencaoButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const itemId = button.id;
                    fetch('inicia_manutencao.php', {
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

            devolverButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const itemId = button.id;
                    fetch('devolver.php', {
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
        });


        const cancelarMovimentacaoButton = document.getElementById('cancelarMovimentacao');

        cancelarMovimentacaoButton.addEventListener('click', () => {
           
            window.location.href = 'index.php?pagina=ativas'; // Redireciona para a página de movimentações
   
        });

    </script>
</body>
</html>
HTML;

    echo $html;
}