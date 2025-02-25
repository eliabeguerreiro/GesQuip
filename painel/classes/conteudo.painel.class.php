<?php

class ContentPainel
{
    public function renderHeader()
    {
        $html = <<<HTML
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>GesQuip</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                <link rel="stylesheet" href="src/style.css">
            </head>
        HTML;

        return $html;
    }

    public function renderBody()
    {
        //var_dump($_SESSION['data_user']);
        $nome = $_SESSION['data_user']['nm_usuario'];

        $html = <<<HTML
            <body>

            <!--INICIO BARRA DE NAVEAGAÇÃO-->
            <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><b>GesQuip</b></a>
                    <div class="navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <!--GESTÃO DE ITENS-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Itens</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="gestao_itens/?pagina=itens" id="CadastroItemLink">Todos os Itens</a></li>
                                    <li><a class="dropdown-item" href="gestao_itens/?pagina=disponiveis" id="CadastroItemLink">Itens Disponíveis</a></li>
                                    <li><a class="dropdown-item" href="gestao_itens/?pagina=emuso" id="CadastroItemLink">Items em uso</a></li>
                                    <li><a class="dropdown-item" href="gestao_itens/?pagina=quebrados" id="CadastroItemLink">Itens Quebrados</a></li>
                                    <li><a class="dropdown-item" href="gestao_itens/?pagina=novo" id="CadastroItemLink">Novo Item</a></li>
                                </ul>
                            </li>
                            <!--GESTÃO MOVIMENTACAO-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="moviment">Movimentação</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="moviment" id="NovaMoviment">Nova Movimentação</a></li>
                                    <li><a class="dropdown-item" href=" " id="MovimentAtiva">Movimentações Ativas</a></li>
                                    <li><a class="dropdown-item" href=" " id="MovimentEncer">Movimentações Encerradas</a></li>
                                </ul>
                            </li>
                            <!--GESTÃO MANUTENÇÃO-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="Manutencao">Manutenções</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="Manutencao" id="NovaManutencao">Nova Manutenção</a></li>
                                    <li><a class="dropdown-item" href="Manutencao " id="ManutencaoAtiva">Manutenções Ativa</a></li>
                                    <li><a class="dropdown-item" href="Manutencao " id="ManutencaoAtiva">Manutenções Encerradas</a></li>
                                </ul>
                            </li>
                            <!--GESTÃO DE USUARIOS-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="gestao_usuarios" id="usuario">Usuários</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="gestao_usuarios" id="NovosUsuarios">Cadastro Usuário</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex ms-auto">
                        <a href="?sair=1" class="btn btn-danger btn-sm">Sair</a>
                    </div>
                </div>
            </nav>
            <!--FIM BARRA DE NAVEAGAÇÃO-->



            <!--INICIO DO CONTEUDO CENTRAL-->
            <div class="main-content" id="mainContent">

                <div class="container mt-4" id="novoItem" style="display: block;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="header-with-filter">
                                <h3><b><p class="text-primary">Buscar Item</p></b></h3>
                                <div class="filter-container">
                                    <label for="filtro" class="form-label visually-hidden">Filtro</label>
                                    <select id="filtro" name="filtro" class="form-select form-select-sm filter-select" required>
                                        <option value="">Escolha uma chave de identificação</option>
                                        <option value="ds_item">NOME</option>
                                        <option value="cod_patrimonio">PATRIMONIO</option>
                                    </select>
                                </div>
                            </div>
                            <form id="formNovoItem">
                                <div class="mb-3">
                                    <label for="valor" class="form-label">Digite o Valor</label>
                                    <input type="text" id="valor" name="valor" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="container mt-4" id="containerFerramentas" style="display: block;">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h3><b><p class="text-primary">Itens Encontrados</p></b></h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Cod</th>
                                        <th>Nome</th>
                                        <th>Familia</th>
                                        <th>Movimentação</th>
                                        <th>Usuário</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="itens">
                                    <tr>
                                        <td>bs67a0</td>
                                        <td>Sextavada Viluz 1200</td>
                                        <td>ALAVANCA</td>
                                        <td>226</td>
                                        <td>Fulano</td>
                                        <td>
                                            <a href="devolver.php?id=1" class="btn btn-success btn-sm">Devolver</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Adiciona um evento de clique ao link "Novo Item"
                document.getElementById("CadastroItemLink").addEventListener("click", function(event) {
                    event.preventDefault(); // Impede o comportamento padrão do link
                    // Exibe ambos os contêineres
                    document.getElementById("novoItem").style.display = "block";
                    document.getElementById("containerFerramentas").style.display = "block";
                });
            </script>
            </body>
            </html>
        HTML;

        return $html;
    }
}
?>