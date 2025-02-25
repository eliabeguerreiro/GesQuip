<?php
  
class ContentPainel
{

  public function renderHeader(){
 
    $html = <<<HTML
      <!DOCTYPE html>
      <html lang="pt-br">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>GesQuip - Equipamentos</title>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
          <link rel="stylesheet" href="src/style.css">
      </head>

    HTML;   

    return($html);
}

    public function renderBody($pagina, $familia, $itens, $itens_disponiveis, $itens_locados){

      //var_dump($itens);
      $nome = $_SESSION['data_user']['nm_usuario'];
      
      // Verifica se os parâmetros GET estão definidos
      $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : null;
      $v = isset($_GET['v']) ? $_GET['v'] : null;
      
      function buildUrl($newParams = []) {
        $queryParams = $_GET;
        foreach ($newParams as $key => $value) {
            if ($value === null) {
                unset($queryParams[$key]);
            } else {
                $queryParams[$key] = $value;
            }
        }
        return '?' . http_build_query($queryParams);
    }

      
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

      HTML;                              
                                    
                          $html.="<li><a class='dropdown-item' href='" . buildUrl(['pagina' => 'itens']) . "'>Todos os Itens</a></li>";
                          $html.="<li><a class='dropdown-item' href='" . buildUrl(['pagina' => 'disponiveis']) . "'>Itens Disponíveis</a></li>";
                          $html.="<li><a class='dropdown-item' href='" . buildUrl(['pagina' => 'emuso']) . "'>Itens em Uso</a></li>";
                          $html.="<li><a class='dropdown-item' href='" . buildUrl(['pagina' => 'novo']) . "'>Novo Item</a></li>";

      $html.= <<<HTML
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
            <main>
      HTML;
              



      if (isset($pagina)) {
        switch ($pagina) {
           case 'novo':
            
              $html.= <<<HTML
              <div class="main-content" id="mainContent">
              <div class="container mt-4" id="novoItem" style="display: block;">
                <div class="row">
                  <div class="col-md-12">                    
                      <h3><b><p class="text-primary">Novo Item</p></b></h3>
                      <form id="formNovoItem">
                        <div class="mb-3">
                          <label for="familia" class="form-label">Família</label>
                          <select id="familia" name="familia" class="form-select" required>
                            <option value="">Escolha a família</option>
          HTML;
            $fam = $familia;
                  foreach ($fam as $familia) {
                    $html.="<option value=".$familia['id_familia'].">".$familia['ds_familia']."</option>";  
                  }
          $html.= <<<HTML
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="modelo" class="form-label">Modelo</label>
                          <input type="text" class="form-control" id="modelo" name="modelo">
                        </div>
                        <div class="mb-3">
                          <label for="natureza" class="form-label">Natureza de posse</label>
                          <select class="form-select" id="item_natureza" name="item_natureza">
                            <option value="1">Próprio</option>
                            <option value="2">Locado</option>
                          </select>
                        </div>
                          <button type="submit" class="btn btn-primary">Cadastrar</button>
                      </form>
                  </div>
                </div>
              </div>    
            </div>

          HTML;


            break;
            case 'itens':



              $html.= <<<HTML
        <!-- TABELA -->
        <div class="container mt-4" id="containerFerramentas" style="display: block;">
            <div class="row mt-4">
                <div class="col-md-12">
                    <!-- Header com filtro -->
                    <div class="header-with-filter">
                        <h3><b><p class="text-primary">Todos os Equipamentos</p></b></h3>
                        <div class="filter-container">
                            <label for="filtro_principal" class="form-label visually-hidden">Filtro Principal</label>
                            <select id="filtro_principal" class="form-select form-select-sm filter-select" required>
                                <option value="">Escolha um filtro</option>
                                <option value="familia">Família</option>
                                <option value="natureza">Natureza</option>
                            </select>
        
                            <!-- Div para Natureza -->
                            <div id="filtro_natureza" style="display: none; margin-left: 10px;">
                                <select id="filtro_natureza" class="form-select form-select-sm">
                                    <option value="proprio">Próprio</option>
                                    <option value="locado">Locado</option>
                                </select>
                            </div>
        
                            <!-- Div para Família -->
                            <div id="filtro_familia" style="display: none; margin-left: 10px;">
                                <select id="filtro_familia" class="form-select form-select-sm">
                                    <option value="">Escolha uma família</option>
      HTML;
                          $filtro_familia = $familia;
                          foreach ($filtro_familia as $familia) { 
                            $html.="<option value=".$familia['id_familia'].">".$familia['ds_familia']."</option>";
                          }
      $html.= <<<HTML

                                </select>
                            </div>
                        </div>
                    </div>
        
                    <!-- Tabela de Equipamentos -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Família</th>
                                <th>Modelo</th>
                                <th>Natureza</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="itens">
                            <tr>

      HTML;
                          $equipamento = $itens;
                            $fam2 = $familia;
                             foreach ($itens['dados'] as $item):
                               
                               $id_fami = $item['id_familia'];
                              
                               foreach ($fam2 as $familiaa) {
                                 
                                 if($familiaa['id_familia'] == $id_fami){
                                   $nm_familia = $familiaa['ds_familia'];
                                 }
                               }
                 
                 
                                   $html .="<td>".$item['cod_patrimonio']."</td>";
                                   $html .="<td>".$nm_familia."</td>";
                                   $html .="<td>".$item['ds_item']."</td>";
                 
                                   $html .="<td>".$item['natureza']."</td>";
                                   $html .="<td><button class='btn btn-success btn-sm' id ='".$item['id_item']."' >Editar</button>";
                                   $html .="<a href='apagar.php?id=".$item['id_item']."' class='btn btn-danger btn-sm' >Apagar</a></td>";
                                   $html .="</tr>";
                                   
                             endforeach;     
                 
      $html.= <<<HTML

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      HTML;
              
                break;
            case 'disponiveis':
                
                break;
            case 'emuso':
                
                break;
            default:
                // Caso nenhum dos casos acima seja correspondido, você pode definir um comportamento padrão aqui.
                // Por exemplo, você pode lançar um erro ou definir uma variável vazia.
                break;
        }
    }
      



      $html.= <<<HTML

       
        </main>

        HTML;
        if(isset($_SESSION['msg'])){
        $html.= "<script>alert('".$_SESSION['msg']."');</script>";
        unset($_SESSION['msg']);
        }
      $html.= <<<HTML

        </body>
        <script src="src/script.js"></script>
        </html>
      HTML;   

        return($html);
  }

}
?>