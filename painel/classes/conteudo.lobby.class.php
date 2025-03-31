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

    public function renderBody($tipo_user, $opcoes)
    {

        $tipo_user = $_SESSION['data_user']['tp_usuario']
        switch ($tipo_user) {
            case 'super_admin':
            
                $empresas = GestLobby::getEmpresa();




                //ambiente de escolha de empresa para gerenciar




                break;

            case 'admin':
                $empresa = GestLobby::getEmpresa($_SESSION['data_user']['id_empresa']);



                    
                //ambiente de escolha de obra para gerenciar


                break;
            
            case 'operador':

               //ambiente para verificar quais obras ele tem acesso para gerencias

                break;

            default;
                $empresa = null; 
                break;
        }







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
                                    <li><a class="dropdown-item" href="?pagina=cadastro" id="NovosUsuarios">Cadastrar Funcionários</a></li>
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
      $html .= <<<HTML

            <!-- INÍCIO DO CONTEÚDO CENTRAL -->
            <div class="main-content" id="mainContent">
                <div class="container mt-4" id="novoItem" style="display: block;">
                   
                </div>
            </div>

            <script src="src/script.js"></script>
            </body>
            </html>
        HTML;

        return $html;
    }
}
?>