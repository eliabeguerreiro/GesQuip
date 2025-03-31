<?php

class ContentPainelLobby
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
                <link rel="icon" type="image/png" href="src/img/favicon.png">
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
                    <a class="navbar-brand" href="../"><b>GesQuip</b></a>
                    <div class="navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">

                            <!--GESTÃO DE USUARIOS-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="usuarios" id="usuario">Funcionários</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="usuarios/?pagina=cadastro" id="NovosUsuarios">Cadastrar Funcionários</a></li>
                                    <li><a class="dropdown-item" href="usuarios/?pagina=usuarios" id="NovosUsuarios">Todos os Funcionários</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="d-flex ms-auto">
                        <a href="?sair=1" class="btn btn-danger btn-sm">Sair</a>
                    </div>
                </div>
            </nav>
            <main>
                
      HTML;

      if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      } 

      switch ($_SESSION['data_user']['tp_usuario']) {
        case 'admin':

            $empresas = Lobby::getEmpresa($_SESSION['data_user']['id_empresa']);
            $empresas = $empresas['dados'];
            $obras = Lobby::getObra($_SESSION['data_user']['id_empresa']);
            $obras = $obras['dados'];

$html .= <<<HTML

            <!-- INÍCIO DO CONTEÚDO CENTRAL -->
            <div class="main-content" id="mainContent">
                <div class="container mt-4" id="novoItem" style="display: block;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                            <h3><b><p class="text-primary">Empresa</p></b></h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>CNPJ</th>
                                        <th>Limite de obras</th>
                                    </tr>
                                    </thead>
                                <tbody id="itens">
                                    <tr>

      HTML;


                            foreach ($empresas as $empresa):
                                $html .="<td>".$empresa['id_empresa']."</td>";
                                $html .="<td>".$empresa['nm_empresa']."</td>";
                                $html .="<td>".$empresa['nr_cnpj']."</td>";
                                $html .="<td>".$empresa['limite_obras']."</td>";
                                $html .="</tr>";
                            endforeach;
                 
                 
    $html.= <<<HTML

                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>

    HTML;                      



            $html .= <<<HTML
            <div class="container mt-4" id="novoItem" style="display: block;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                        <h3><b><p class="text-primary">Obras Cadastradas</p></b></h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>CREA</th>
                                    <th>Responsável</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                            <tbody id="itens">
                                <tr>

HTML;

  
                        foreach ($obras as $obra):
                            $html .="<td>".$obra['id_obra']."</td>";
                            $html .="<td>".$obra['ds_obra']."</td>";
                            $html .="<td>".$obra['id_crea']."</td>";
                            $html .="<td>".$obra['resp_tec']."</td>";
                            $html .="<td><a href='obra.php?obra=".$obra['id_obra']."' class='btn btn-success btn-sm btn-sm' >Acessar</a></td>";
                            $html .="</tr>";
                        endforeach;
             
             
$html.= <<<HTML

                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;




    $html .= <<<HTML
            <script src="src/script.js"></script>
            </body>
            </html>
        HTML;



            break;
        case 'operador':
            $obras = Lobby::getObra($_SESSION['data_user']['id_empresa']);
            break;

        default:
            echo("ERRO: ACESSO INDEVIDO!!");
            break;
        }

        return $html;
    }
}
