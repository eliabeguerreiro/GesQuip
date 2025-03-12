<?php
  
class ContentPainelMoviment
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

  
 
    public function renderBody($pagina, $funciona, $moviment, $moviment_encerrado){
      $nome = $_SESSION['data_user']['nm_usuario'];
      $func = $funciona;
      


      // Verifica se os parâmetros GET estão definidos
      $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : null;
      $valor = isset($_GET['valor']) ? $_GET['valor'] : null;
    
  
      function buildUrlItens($newParams = []) {
          $queryParams = $_GET;
          foreach ($newParams as $key => $value) {
              if ($value === null) {
                  unset($queryParams[$key]);
              } else {
                  $queryParams[$key] = $value;
              }
          }
          // Remove os parâmetros 'filtro' e 'v' se a página for alterada
          if (isset($newParams['pagina'])) {
              unset($queryParams['filtro']);
              unset($queryParams['valor']);
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
                                    <li><a class="dropdown-item" href="../itens/?pagina=itens" id="CadastroItemLink">Todos os Itens</a></li>
                                    <li><a class="dropdown-item" href="../itens/?pagina=disponiveis" id="CadastroItemLink">Itens Disponíveis</a></li>
                                    <li><a class="dropdown-item" href="../itens/?pagina=emuso" id="CadastroItemLink">Items em uso</a></li>
                                    <li><a class="dropdown-item" href="../itens/?pagina=quebrados" id="CadastroItemLink">Itens Quebrados</a></li>
                                    <li><a class="dropdown-item" href="../itens/?pagina=novo" id="CadastroItemLink">Novo Item</a></li>
                                </ul>
                            </li>
                            <!--GESTÃO MOVIMENTACAO-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="moviment">Movimentação</a>
                                <ul class="dropdown-menu">
      HTML;                              
                          $html.="<li><a class='dropdown-item' href='" . buildUrlItens(['pagina' => 'ativas']) . "'>Movimentações Ativas</a></li>";
                          $html.="<li><a class='dropdown-item' href='" . buildUrlItens(['pagina' => 'encerradas']) . "'>Movimentações Encerradas</a></li>";
                          $html.="<li><a class='dropdown-item' href='" . buildUrlItens(['pagina' => 'nova']) . "'>Novo Movimentação</a></li>";
      $html.= <<<HTML
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
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="usuarios" id="usuario">Usuários</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../usuarios?pagina=cadastro" id="NovosUsuarios">Cadastro Usuário</a></li>
                                    <li><a class="dropdown-item" href="../usuarios?pagina=usuarios" id="NovosUsuarios">Todos os Usuários</a></li>
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
           case 'nova':


            $html.= <<<HTML
            <div class="main-content" id="mainContent">
                <div class="container mt-4" id="novoItem" style="display: block;">
                    <div class="row">
                        <div class="col-md-12">                    
                            <h3><b><p class="text-primary">Nova Movimentação</p></b></h3>
                            <form method='POST' action='' id="formNovaMov">
                                <div class="mb-3">
                                    <label for="id_usuario" class="form-label">Funcionário</label>
                                    <select id="id_usuario" name="id_usuario" class="form-select" required>
                                        <option value="">Escolha um funcionário</option>
            HTML;
            foreach ($funciona as $funcionario) {
                $html.= "<option value='" . $funcionario['id_usuario'] . "'>" . $funcionario['nm_usuario'] . "</option>";
            }
            $html.= <<<HTML
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="ds_movimentacao" class="form-label">Descriçao da Retirada</label>
                                    <input type="text" class="form-control" id="ds_movimentacao" name="ds_movimentacao" placeholder="Descriçao" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                </div>    
            </div>
            HTML;


            break;
            case 'ativas':

                if ($filtro && $valor) {

                    $moviments_filtrados = Moviment::getMoviment(null, $filtro, $valor);
            
                    $moviment = $moviments_filtrados['dados'];
                }




              $html.= <<<HTML
        <!-- TABELA -->
        <div class="container mt-4" id="containerFerramentas" style="display: block;">
            <div class="row mt-4">
                <div class="col-md-12">
                    <!-- Header com filtro -->
                    <div class="header-with-filter">
                        <h3><b><p class="text-primary">Movimentações Ativas</p></b></h3>
                        <div class="filter-container">
                            <label for="filtro_principal" class="form-label visually-hidden">Filtro Principal</label>
                            <select id="filtro_principal" class="form-select form-select-sm filter-select" required>
                                <option value="">Escolha um filtro</option>
                                <option value="funcionario">Funcionário</option>
                                <option value="data">Data</option>
                            </select>
        
                            <!-- Div para Data -->
                            <div id="filtro_data" style="display: none; margin-left: 10px;">
                                <select id="filtro_data_tipo" class="form-select form-select-sm">
                                    <option value="">Escolha o tipo</option>
                                    <option value="mes">Mês Único</option>
                                    <option value="intervalo">Intervalo</option>
                                </select>
                            </div>

                            <!-- Div para Seleção de Mês -->
                            <div id="filtro_data_mes" style="display: none; margin-left: 10px;">
                                <select id="filtro_mes_select" class="form-select form-select-sm">
                                    <option value="">Escolha o mês</option>
                                    <option value="01">Janeiro</option>
                                    <option value="02">Fevereiro</option>
                                    <option value="03">Março</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Maio</option>
                                    <option value="06">Junho</option>
                                    <option value="07">Julho</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>

                            <!-- Div para Seleção de Intervalo -->
                            <div id="filtro_data_intervalo" style="display: none; margin-left: 10px;">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control datepicker" id="data_inicio" name="start" placeholder="Data de Início" readonly />
                                    <span class="input-group-addon">até</span>
                                    <input type="text" class="input-sm form-control datepicker" id="data_fim" name="end" placeholder="Data de Fim" readonly />
                                </div>
                            </div>

                            <!-- Div para Funcionário -->
                            <div id="filtro_funcionario" style="display: none; margin-left: 10px;">
                                <input type="text" id="filtro_funcionario_input" class="form-control form-control-sm" placeholder="Digite o nome do Funcionario">
                                <div id="filtro_funcionario_suggestions" class="list-group mt-1" style="max-width:11.5%; max-height: 200px; overflow-y: auto; display: none;">
                                    <!-- As sugestões serão inseridas aqui pelo JavaScript -->
                                </div>
                            </div>
                        </div>
                        </div>
HTML;

                if ($filtro && $valor) {
                    $html .= <<<HTML
                    <!-- Identificador de Filtro -->
                    <div id="filtro_alert" class="alert alert-info">
                        <strong>Filtro aplicado:</strong> <span id="filtro_texto">
HTML;
                    if ($filtro === 'id_responsavel') {
                        $funcionaNome = array_filter($funciona, function($f) use ($valor) {
                            return $f['id_usuario'] == $valor;
                        });
                        $funcionaNome = reset($funcionaNome);
                        $html .= "Funcionário: " . $funcionaNome['nm_usuario'];
                    } else {
                        $html .= ucfirst($filtro) . ": " . $valor;
                    }
                    $html .= <<<HTML
                        </span>
                    </div>
HTML;
                }

                $html .= <<<HTML
                            <!-- Tabela de Movimentações -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Funcionário</th>
                                <th>ADM</th>
                                <th>Retirada</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="itens">
                            <tr>

      HTML;

      
      foreach ($moviment as $mov):
        $nm_responsa = User::getFuncionarioNome($mov['id_responsavel']);
        $nm_autor = User::getFuncionarioNome($mov['id_autor']);
          $html .="<td>".$mov['id_movimentacao']."</td>";
          $html .="<td>".$nm_responsa."</td>";
          $html .="<td>".$nm_autor."</td>";
          $html .="<td>".$mov['dt_movimentacao']."</td>";
          //$html .= "<td><button class='btn btn-success btn-sm atualiza-button' data-bs-toggle='modal' data-bs-target='#atualizaModal' data-id='".$item['id_item']."'>Editar</button>   ";
          $html .="<td><a href='moviment.php.php?id=".$mov['id_movimentacao']."' class='btn btn-success btn-sm btn-sm' >Acessar</a></td>";
          $html .="</tr>";
      endforeach;
                 
      $html.= <<<HTML

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal de Atualização >
        <div-- class="modal fade" id="atualizaModal" tabindex="-1" aria-labelledby="atualizaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="atualizaModalLabel">Atualizar Modelo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="novoNome" class="form-control" placeholder="digite o novo nome" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="atualizaSubmit">Salvar</button>
                    </div>
                </div>
            </div>
        </div-->


      HTML;
              
                break;
            case 'encerradas':
              
                if ($filtro && $valor) {

                    $moviments_filtrados = Moviment::getMovimentEncerrado( $filtro, $valor);
            
                    $moviment_encerrado = $moviments_filtrados['dados'];
                }



              $html.= <<<HTML
        <!-- TABELA -->
        <div class="container mt-4" id="containerFerramentas" style="display: block;">
            <div class="row mt-4">
                <div class="col-md-12">
                      <!-- Header com filtro -->
                      <div class="header-with-filter">
                        <h3><b><p class="text-primary">Movimentações Encerradas</p></b></h3>
                        <div class="filter-container">
                            <label for="filtro_principal" class="form-label visually-hidden">Filtro Principal</label>
                            <select id="filtro_principal" class="form-select form-select-sm filter-select" required>
                                <option value="">Escolha um filtro</option>
                                <option value="funcionario">Funcionário</option>
                                 <option value="data">Data</option>
                            </select>
        
                             <!-- Div para Data -->
                             <div id="filtro_data" style="display: none; margin-left: 10px;">
                                <select id="filtro_data_tipo" class="form-select form-select-sm">
                                    <option value="">Escolha o tipo</option>
                                    <option value="mes">Mês Único</option>
                                    <option value="intervalo">Intervalo</option>
                                </select>
                            </div>

                            <!-- Div para Seleção de Mês -->
                            <div id="filtro_data_mes" style="display: none; margin-left: 10px;">
                                <select id="filtro_mes_select" class="form-select form-select-sm">
                                    <option value="">Escolha o mês</option>
                                    <option value="01">Janeiro</option>
                                    <option value="02">Fevereiro</option>
                                    <option value="03">Março</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Maio</option>
                                    <option value="06">Junho</option>
                                    <option value="07">Julho</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>

                            <!-- Div para Seleção de Intervalo -->
                            <div id="filtro_data_intervalo" style="display: none; margin-left: 10px;">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control datepicker" id="data_inicio" name="start" placeholder="Data de Início" readonly />
                                    <span class="input-group-text">até</span>
                                    <input type="text" class="input-sm form-control datepicker" id="data_fim" name="end" placeholder="Data de Fim" readonly />
                                </div>
                            </div>

                            <!-- Div para Funcionário -->
                            <div id="filtro_funcionario" style="display: none; margin-left: 10px;">
                                <input type="text" id="filtro_funcionario_input" class="form-control form-control-sm" placeholder="Digite o nome do Funcionario">
                                <div id="filtro_funcionario_suggestions" class="list-group mt-1" style="max-width:11.5%; max-height: 200px; overflow-y: auto; display: none;">
                                    <!-- As sugestões serão inseridas aqui pelo JavaScript -->
                                </div>
                            </div>
                        </div>
                        </div>
HTML;

                if ($filtro && $valor) {
                    $html .= <<<HTML
                    <!-- Identificador de Filtro -->
                    <div id="filtro_alert" class="alert alert-info">
                        <strong>Filtro aplicado:</strong> <span id="filtro_texto">
HTML;
                    if ($filtro === 'id_responsavel') {
                        $funcionaNome = array_filter($funciona, function($f) use ($valor) {
                            return $f['id_usuario'] == $valor;
                        });
                        $funcionaNome = reset($funcionaNome);
                        $html .= "Funcionário: " . $funcionaNome['nm_usuario'];
                    } else {
                        $html .= ucfirst($filtro) . ": " . $valor;
                    }
                    $html .= <<<HTML
                        </span>
                    </div>
HTML;
                }

                $html .= <<<HTML
                            <!-- Tabela de Movimentações -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Funcionário</th>
                                <th>ADM</th>
                                <th>Retirada</th>
                            </tr>
                        </thead>
                        <tbody id="itens">
                            <tr>

      HTML;

      
      foreach ($moviment_encerrado as $mov):
        $nm_responsa = User::getFuncionarioNome($mov['id_responsavel']);
        $nm_autor = User::getFuncionarioNome($mov['id_autor']);
          $html .="<td>".$mov['id_movimentacao']."</td>";
          $html .="<td>".$nm_responsa."</td>";
          $html .="<td>".$nm_autor."</td>";
          $html .="<td>".$mov['dt_movimentacao']."</td>";
          $html .="</tr>";
      endforeach;
                 
      $html.= <<<HTML

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal de Atualização >
        <div-- class="modal fade" id="atualizaModal" tabindex="-1" aria-labelledby="atualizaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="atualizaModalLabel">Atualizar Modelo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="novoNome" class="form-control" placeholder="digite o novo nome" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="atualizaSubmit">Salvar</button>
                    </div>
                </div>
            </div>
        </div-->


      HTML;
                
                break;
            default:
                header('Location: ?pagina=nova');
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
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filtroPrincipal = document.getElementById('filtro_principal');
                const filtroData = document.getElementById('filtro_data');
                const filtroDataTipo = document.getElementById('filtro_data_tipo');
                const filtroDataMes = document.getElementById('filtro_data_mes');
                const filtroDataIntervalo = document.getElementById('filtro_data_intervalo');
                const filtroFuncionario = document.getElementById('filtro_funcionario');

                const filtroMesSelect = document.getElementById('filtro_mes_select');
                const filtroFuncionarioInput = document.getElementById('filtro_funcionario_input');
                const filtroFuncionarioSuggestions = document.getElementById('filtro_funcionario_suggestions');
        HTML;
        $html .= "const funcionarios = " . json_encode($funciona) . ";";
        $html.= <<<HTML

                filtroPrincipal.addEventListener('change', function() {
                    const filtro = filtroPrincipal.value;
                    filtroData.style.display = 'none';
                    filtroDataTipo.value = ''; // Resetar o tipo de data
                    filtroDataMes.style.display = 'none';
                    filtroDataIntervalo.style.display = 'none';
                    filtroFuncionario.style.display = 'none';

                    if (filtro === 'data') {
                        filtroData.style.display = 'inline-block';
                    } else if (filtro === 'funcionario') {
                        filtroFuncionario.style.display = 'inline-block';
                    }
                });

                filtroDataTipo.addEventListener('change', function() {
                    const tipo = filtroDataTipo.value;
                    filtroDataMes.style.display = 'none';
                    filtroDataIntervalo.style.display = 'none';

                    if (tipo === 'mes') {
                        filtroDataMes.style.display = 'inline-block';
                    } else if (tipo === 'intervalo') {
                        filtroDataIntervalo.style.display = 'inline-block';
                    }
                });

                filtroMesSelect.addEventListener('change', function() {
                    const mes = filtroMesSelect.value;
                    atualizarURL('dt_movimentacao', mes);
                });

                $(function(){
                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        language: 'pt-BR',
                        startDate: '2024-01-01',
                        endDate: '2026-12-31',
                        todayHighlight: true,
                        autoclose: true
                    });

                    $('#data_inicio').on('changeDate', function() {
                        const dataInicio = $(this).datepicker('getFormattedDate');
                        $('#data_fim').datepicker('setStartDate', dataInicio);
                    });

                    $('#data_fim').on('changeDate', function() {
                        const dataInicio = $('#data_inicio').datepicker('getFormattedDate');
                        const dataFim = $(this).datepicker('getFormattedDate');
                        if (dataInicio && dataFim) {
                            atualizarURL('dt_movimentacao', dataInicio + '...' + dataFim);
                        }
                    });
                });

                filtroFuncionarioInput.addEventListener('input', function() {
                    const query = filtroFuncionarioInput.value.toLowerCase();
                    filtroFuncionarioSuggestions.innerHTML = ''; // Limpa as sugestões anteriores

                    if (query.length > 0) {
                        const filteredFuncionarios = funcionarios.filter(funcionarios => funcionarios.nm_usuario.toLowerCase().includes(query));
                        filteredFuncionarios.forEach(funcionario => {
                            const suggestionItem = document.createElement('a');
                            suggestionItem.href = '#';
                            suggestionItem.className = 'list-group-item list-group-item-action';
                            suggestionItem.textContent = funcionario.nm_usuario;
                            suggestionItem.dataset.id = funcionario.id_usuario;

                            suggestionItem.addEventListener('click', function(e) {
                                e.preventDefault();
                                filtroFuncionarioInput.value = funcionario.nm_usuario;
                                filtroFuncionarioSuggestions.style.display = 'none';
                                atualizarURL('id_responsavel', funcionario.id_usuario);
                            });

                            filtroFuncionarioSuggestions.appendChild(suggestionItem);
                        });

                        filtroFuncionarioSuggestions.style.display = 'block';
                    } else {
                        filtroFuncionarioSuggestions.style.display = 'none';
                    }
                });

                // Fecha a lista de sugestões se o usuário clicar fora dela
                document.addEventListener('click', function(e) {
                    if (!filtroFuncionarioInput.contains(e.target) && !filtroFuncionarioSuggestions.contains(e.target)) {
                        filtroFuncionarioSuggestions.style.display = 'none';
                    }
                });

                function atualizarURL(filtro, valor) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('filtro', filtro);
                    url.searchParams.set('valor', valor);
                    window.location.href = url.toString();
                }
            });
        </script>
        </html>
      HTML;



        return($html);
  }

}
?>