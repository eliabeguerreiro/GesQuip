<?php
session_start();
ob_start();
include_once "classes/conteudo.painel-moviment.class.php";
include_once "classes/gest-moviment.class.php";
include_once "classes/db.class.php";

$itens = Item::getItensDisponiveis(null);
$pagina = new ContentPainelMoviment;
$fami = Item::getFamilia();



if (isset($_GET['id'])) {
    $_SESSION['id_moviment'] = $_GET['id']; 
        
    
}else{
    $_SESSION['msg'] = 'Movimentação não encontrada';
    header('location:?pagina=ativas');
}

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

if ($_SESSION['id_moviment']) {
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
                            <button id="cancelarMovimentacao" class="btn btn-danger btn-sm">Cancelar</button>
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
                                    <div id="itensReservados">
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

        foreach ($reservado as $res) {
            $nm_familia = Item::getFamiliaNome($res['id_familia']);
            $item_dados = Item::getItens($res['id_item'],null,null);
            $item_dados = $item_dados['dados'][0];
            $html .= "<tr>";
            $html .= "<td>" . $item_dados['cod_patrimonio'] . "</td>";
            $html .= "<td>" . $nm_familia . "</td>";
            $html .= "<td>" . $res['ds_item'] . "</td>";
            $html .= "</tr>";
        }

        $html .= <<<HTML
                                </tbody>
                            </table>
                            <button id="finalizarMovimentacao" class="btn btn-primary">Finalizar Movimentação</button>
                    </div>
        HTML;
        }     
        $html .= <<<HTML
                    <div class="box2 mt-4 p-4 rounded shadow-sm" style="background-color: #fff;">
                        <h1 class="text-primary">Itens Disponíveis</h1>
                        <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar itens...">
                        </div>
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
            $nm_familia = Item::getFamiliaNome($item['id_familia']);
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
        const cancelarMovimentacaoButton = document.getElementById('cancelarMovimentacao');
        const finalizarMovimentacaoButton = document.getElementById('finalizarMovimentacao');
        const searchInput = document.getElementById('searchInput');
        const produtos = document.getElementById('produtos');

        reservarButtons.forEach(button => {
            button.addEventListener('click', () => {
                const itemId = button.id;

                fetch('reservar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + encodeURIComponent(itemId) + '&moviment=' + encodeURIComponent($id)
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));
            });
        });

        cancelarMovimentacaoButton.addEventListener('click', () => {
            fetch('cancela_moviment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent($id)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status === 'success') {

    HTML;
    $_SESSION['id_moviment'] = null;               
    $html.= <<<HTML
                window.location.href = 'index.php?pagina=nova';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        finalizarMovimentacaoButton.addEventListener('click', () => {
            fetch('envia_moviment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent($id)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status === 'success') {
                    window.location.href = 'index.php?pagina=ativas';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.toLowerCase();
            const rows = produtos.querySelectorAll('tr');

            rows.forEach(row => {
                const codigo = row.cells[0].textContent.toLowerCase();
                const familia = row.cells[1].textContent.toLowerCase();
                const nome = row.cells[2].textContent.toLowerCase();

                if (codigo.includes(query) || familia.includes(query) || nome.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
HTML;

    echo $html;
}