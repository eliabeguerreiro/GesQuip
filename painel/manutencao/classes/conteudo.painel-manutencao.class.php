<?php
  
class ContentPainelManutencao
{
  public function renderHeader(){
   
    $html = <<<HTML
      <!DOCTYPE html>
      <html lang="pt-br">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>GesQuip - Manutenção</title>
          <link rel="icon" type="image/png" href="src/img/favicon.png">
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
          <link rel="stylesheet" href="src/style.css">
      </head>

    HTML;   
    return($html);

  }

    public function renderBody($pagina, $manutenc, $mantencs_encerradas){
      $nome = $_SESSION['data_user']['nm_usuario'];
      $funciona = User::getFuncionarios();

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
                    <a class="navbar-brand" href="../"><b>GesQuip</b></a>
                    <div class="navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <!--GESTÃO DE ITENS-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Itens</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../itens/?pagina=gestao_itens" id="CadastroItemLink">Gestão de Itens</a></li>
                                    <li><a class="dropdown-item" href="../itens/?pagina=novo" id="CadastroItemLink">Novo Item</a></li>
                                </ul>
                            </li>
                            <!--GESTÃO MOVIMENTACAO-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="moviment">Movimentações</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../moviment?pagina=nova" id="NovaMoviment">Nova Movimentação</a></li>
                                    <li><a class="dropdown-item" href="../moviment?pagina=ativas" id="MovimentAtiva">Movimentações Ativas</a></li>
                                </ul>
                            </li>
                            <!--GESTÃO MANUTENÇÃO-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="Manutencao">Manutenções</a>
                                <ul class="dropdown-menu">
        HTML;
                                    $html.="<li><a class='dropdown-item' href='" . buildUrlItens(['pagina' => 'nova']) . "'>Nova Manutenção</a></li>";      
                                    $html.="<li><a class='dropdown-item' href='" . buildUrlItens(['pagina' => 'ativas']) . "'>Manutenções Ativas</a></li>";
        $html.= <<<HTML
                                </ul>
                            </li>
                            <!--GESTÃO DE USUARIOS-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="usuarios" id="usuario">Funcionários</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../usuarios?pagina=cadastro" id="NovosUsuarios">Cadastrar Funcionário</a></li>
                                    <li><a class="dropdown-item" href="../usuarios?pagina=usuarios" id="NovosUsuarios">Todos os Funcionários</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="usuarios" id="usuario">Relatórios</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../itens/?pagina=itens" id="CadastroItemLink">Todos os Itens</a></li>
                                    <li><a class="dropdown-item" href="../itens/?pagina=disponiveis" id="CadastroItemLink">Itens Disponíveis</a></li>
                                    <li><a class="dropdown-item" href="../itens/?pagina=emuso" id="CadastroItemLink">Itens em Uso</a></li>
                                    <li><a class="dropdown-item" href="../itens/?pagina=quebrados" id="CadastroItemLink">Itens Quebrados</a></li>
                                    <li><a class="dropdown-item" href="../moviment/?pagina=encerradas" id="MovimentEncer">Movimentações Encerradas</a></li>
            HTML;
                                    $html.="<li><a class='dropdown-item' href='" . buildUrlItens(['pagina' => 'encerradas']) . "'>Manutenções Encerradas</a></li>";
            $html.= <<<HTML
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

      if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      } 

      if (isset($pagina)) {
        switch ($pagina) {
            case 'nova':
                $html .= <<<HTML
                <div class="main-content" id="mainContent">
                    <div class="container mt-4" id="novoItem" style="display: block;">
                        <div class="row">
                            <div class="col-md-12">                    
                                <h3><b><p class="text-primary">Nova Manutenção</p></b></h3>
                                <form method='POST' action='' id="formNovaMov">
                                    <!-- Formulário de busca de itens -->
                                    <div class="mb-3">
                                        <label for="id_usuario" class="form-label">Itens não associados a movimentações</label>
                                        <div class="input-group">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar itens...">
                                            <button type="button" id="searchButton" class="btn btn-primary">Buscar</button>
                                        </div>
                                        <div id="searchResults" class="list-group mt-2"></div>
                                        <div id="selectedItem" class="mt-2"></div>
                                        <input type="hidden" id="selectedItemId" name="id_item">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="ds_movimentacao" class="form-label">Descriçao da Retirada</label>
                                        <input type="text" class="form-control" id="ds_movimentacao" name="obs_in" placeholder="Descriçao" required>
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

                    $mantencs_ativas_filtrados = Manutencao::getManutencao( null,$filtro, $valor);
            
                    $manutenc = $mantencs_ativas_filtrados['dados'];
                }



              $html.= <<<HTML

            <!-- Modal de Finalização -->
            <div id="finalizaModal" class="modal" style="display:none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="finalizaModalLabel">Finalizar Manutenção</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formFinalizaManutencao">
                                <div class="mb-3">
                                    <label for="finalizaTexto" class="form-label">Resumo da manutenção</label>
                                    <textarea class="form-control" id="finalizaTexto" name="finalizaTexto" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="custo_manutencao" class="form-label">Custo da Manutenção</label>
                                    <input type="number" step="0.01" class="form-control" id="custo_manutencao" name="custo_manutencao" placeholder="R$ 0.00" required>
                                </div>
                                <div class="mb-3">
                                    <label for="statusSelect" class="form-label">Status</label>
                                    <select class="form-select" id="statusSelect" name="statusSelect" required>
                                        <option value="1">Disponível</option>
                                        <option value="999999999">Quebrado</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="finalizaSubmit">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>

          
        <!-- TABELA -->
        <div class="container mt-4" id="containerFerramentas" style="display: block;">
            <div class="row mt-4">
                <div class="col-md-12">
                    <!-- Header com filtro -->
                    <div class="header-with-filter">
                        <h3><b><p class="text-primary">Manutenções Ativas</p></b></h3>
                        <div class="filter-container">
                            <label for="filtro_principal" class="form-label visually-hidden">Filtro Principal</label>
                            <select id="filtro_principal" class="form-select form-select-sm filter-select" required>
                                <option value="">Escolha um filtro</option>
                                <option value="funcionario">Funcionário</option>
                                <option value="data">Data de Inicio</option>
                            </select>
        
                            <!-- Div para Data -->
                            <div id="filtro_data_intervalo" style="display: none; margin-left: 10px;">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control datepicker" id="data_inicio" name="start" placeholder="Data de Início" readonly />
                                    <span class="input-group-text">até</span>
                                    <input type="text" class="input-sm form-control datepicker" id="data_fim" name="end" placeholder="Data de Fim" readonly />
                                </div>
                            </div>

                            <!-- Div para Funcionário -->
                            <div id="filtro_funcionario" style="display: none; margin-left: 10px;">
                            <input type="text" id="filtro_funcionario_input" class="form-control form-control-sm" placeholder="Digite a matrícula do Funcionário">
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
                        <div>
                            <strong>Filtro aplicado:</strong> <span id="filtro_texto">
                HTML;
                    if ($filtro === 'id_autor') {
                        $funcionaNome = array_filter($funciona['dados'], function($f) use ($valor) {
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
                        <button type="button" class="btn-close" aria-label="Close" onclick="removerFiltro()">×</button>
                    </div>
                HTML;

            }


            $html .= <<<HTML
            <!-- Tabela de Movimentações -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ADM</th>
                        <th>Item</th>
                        <th>Familia</th>
                        <th>Data</th>
                        <th>Duração</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="itens">
        HTML;
        
        foreach ($manutenc as $manutencao):
            $id_item = $manutencao['id_item'];        
            $item_data = Item::getItens($id_item); 
            $cod = $item_data['dados'][0]['cod_patrimonio'];
            $id_familia = $item_data['dados'][0]['id_familia'];
            $familia = Item::getFamiliaNome($id_familia);
        
            // Ajuste de formatação da data
            $dataBanco = $manutencao['dt_inicio_manutencao'];
            $dataAtual = new DateTime(); // Data e hora atual
            $dataRetornada = new DateTime($dataBanco);
            $diferenca = $dataAtual->diff($dataRetornada);
            $diasDiferenca = $diferenca->days;
            $dataFormatada = $dataRetornada->format("d/m/Y \à\s H:i");
        
            $nm_autor = User::getFuncionarioNome($manutencao['id_autor']);
            $html .= "<tr>";
            $html .= "<td>" . $manutencao['id_manutencao'] . "</td>";
            $html .= "<td>" . $nm_autor . "</td>";
            $html .= "<td>" . $cod . "</td>";
            $html .= "<td>" . $familia . "</td>";
            $html .= "<td>" . $dataFormatada . "</td>"; // Data formatada
            $html .= "<td>" . $diasDiferenca . " Dias</td>";
            $html .= "<td>" . $manutencao['obs_in'] . "</td>";
            $html .= "<td><button class='btn btn-danger btn-sm finaliza-button' data-bs-toggle='modal' data-bs-target='#finalizaModal' id='" . $manutencao['id_manutencao'] . "'>Retornar item</button></td>";
            $html .= "</tr>";
        endforeach;
        
        $html .= <<<HTML
                </tbody>
            </table>
                </div>
            </div>
        </div>

       


      HTML;
              
                break;
            case 'encerradas':
              
                if ($filtro && $valor) {

                    $mantencs_encerradas_filtrados = Manutencao::getManutencaoEncerrada( $filtro, $valor);
            
                    $mantencs_encerradas = $mantencs_encerradas_filtrados['dados'];
                }


              $html.= <<<HTML
        <!-- TABELA -->
        <div class="container mt-4" id="containerFerramentas" style="display: block;">
            <div class="row mt-4">
                <div class="col-md-12">
                      <!-- Header com filtro -->
                      <div class="header-with-filter">
                        <h3><b><p class="text-primary">Manutenções Encerradas</p></b></h3>
                        <!-- Select para escolher o formato de download -->
                        <div class="filter-container">
                            <div class="filter-container">
                                <label for="exportFormat" class="form-label visually-hidden">Formato de Exportação</label>
                                <select id="exportFormat" class="form-select form-select-sm filter-select" required>
                                    <option value="">Relátorio</option>
                                    <!--option value="pdf">PDF</option-->
                                    <option value="xlsx">XLSX</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                          <label for="filtro_principal" class="form-label visually-hidden">Filtro Principal</label>
                            <select id="filtro_principal" class="form-select form-select-sm filter-select" required>
                                <option value="">Escolha um filtro</option>
                                <option value="funcionario">Funcionário</option>
                                 <option value="data">Data de Inicio</option>
                            </select>
        
                            <!-- Div para Data -->
                            <div id="filtro_data_intervalo" style="display: none; margin-left: 10px;">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control datepicker" id="data_inicio" name="start" placeholder="Data de Início" readonly />
                                    <span class="input-group-text">até</span>
                                    <input type="text" class="input-sm form-control datepicker" id="data_fim" name="end" placeholder="Data de Fim" readonly />
                                </div>
                            </div>

                            <!-- Div para Funcionário -->
                            <div id="filtro_funcionario" style="display: none; margin-left: 10px;">
                                <input type="text" id="filtro_funcionario_input" class="form-control form-control-sm" placeholder="Digite a matricula do Funcionario">
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
                        <div>
                            <strong>Filtro aplicado:</strong> <span id="filtro_texto">
                HTML;
                    if ($filtro === 'id_autor') {
                        $funcionaNome = array_filter($funciona['dados'], function($f) use ($valor) {
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
                        <button type="button" class="btn-close" aria-label="Close" onclick="removerFiltro()">×</button>
                    </div>
                HTML;
                }

                $html .= <<<HTML
                            <!-- Tabela de Movimentações -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ADM</th>
                                <th>Item</th>
                                <th>Familia</th>
                                <th>Data Inicio</th>
                                <th>Data Encerramento</th>
                                <th>Autor do encerramento</th>
                                <th>Tempo total (dias)</th>
                                <th>Custo da Manutenção</th>
                                <th>Observações</th>
                            </tr>

                            </tr>
                        </thead>
                        <tbody id="itens">
                            <tr>

      HTML;

      
      foreach ($mantencs_encerradas as $manutencao):
        $id_item = $manutencao['id_item'];        
        $item_data = Item::getItens($id_item); 
        $cod = $item_data['dados'][0]['cod_patrimonio'];
        $id_familia = $item_data['dados'][0]['id_familia'];
        $familia = Item::getFamiliaNome($id_familia);
        $custoManutencao = $manutencao['custo_manutencao'];
        $custo = ($custoManutencao === null) ? 'Não informado' : number_format($custoManutencao, 2, ',', '.');
        $nm_autor = User::getFuncionarioNome($manutencao['id_autor']);
        $nm_autor_encerramento = User::getFuncionarioNome($manutencao['id_autor_final']);

        $dataBancoInicio  = new DateTime($manutencao['dt_inicio_manutencao']);
        $dataBancoFim = new DateTime($manutencao['dt_fim_manutencao']); // Data e hora atual
        $diferenca = $dataBancoInicio->diff($dataBancoFim);
        $diasDiferenca = $diferenca->days;
        $dataInicioFormatada = $dataBancoInicio->format("d/m/Y \à\s H:i");
        $dataFimFormatada = $dataBancoFim->format("d/m/Y \à\s H:i");

          $html .="<td>".$manutencao['id_manutencao']."</td>";
          $html .="<td>".$nm_autor."</td>";
          $html .="<td>".$cod."</td>";
          $html .="<td>".$familia."</td>";
          $html .="<td>".$dataInicioFormatada."</td>";
          $html .="<td>".$dataFimFormatada."</td>";
          $html .="<td>".$nm_autor_encerramento."</td>";
          $html .="<td>".$diasDiferenca."</td>";
          $html .="<td>".$custo."</td>";
          $html .="<td>".$manutencao['obs_out']."</td>";
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
        <script src = "src/script.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
        <script>

            document.addEventListener('DOMContentLoaded', function () {
                const exportFormat = document.getElementById('exportFormat');

                exportFormat.addEventListener('change', function () {
                    const format = exportFormat.value;
                    if (!format) return;

                    // Selecionar a tabela
                    const table = document.querySelector('.table.table-striped');
                    if (!table) {
                        alert('Tabela não encontrada!');
                        return;
                    }

                    // Extrair os dados da tabela
                    const rows = Array.from(table.querySelectorAll('tr'));
                    const data = rows.map(row => {
                        const cells = Array.from(row.querySelectorAll('th, td'));
                        return cells.map(cell => cell.innerText.trim());
                    });

                    // Gerar o arquivo com base no formato selecionado
                    switch (format) {
                        case 'pdf':
                            generatePDF(data);
                            break;
                        case 'xlsx':
                            generateXLSX(data);
                            break;
                        case 'csv':
                            generateCSV(data);
                            break;
                    }

                    // Resetar o select após a exportação
                    exportFormat.value = '';
                });

                function generatePDF(data) {
                    // Usar dompdf ou outra biblioteca para gerar o PDF
                    const element = document.createElement('div');
                    element.innerHTML = '<table>' + data.map(row => '<tr>' + row.map(cell => '<td>' + cell + '</td>').join('') + '</tr>').join('') + '</table>';
                    const htmlContent = element.outerHTML;

                    // Exemplo básico com dompdf (PHP)
                    fetch('generate_pdf.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ content: htmlContent })
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'manutencoes_encerradas.pdf';
                        a.click();
                    });
                }

                function generateXLSX(data) {
                    // Criar uma planilha usando SheetJS
                    const worksheet = XLSX.utils.aoa_to_sheet(data);
                    const workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(workbook, worksheet, 'Manutenções Encerradas');
                    XLSX.writeFile(workbook, 'manutencoes_encerradas.xlsx');
                }

                function generateCSV(data) {
                    // Criar um CSV usando SheetJS
                    const worksheet = XLSX.utils.aoa_to_sheet(data);
                    const workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(workbook, worksheet, 'Manutenções Encerradas');
                    XLSX.writeFile(workbook, 'manutencoes_encerradas.csv');
                }
            });


            function removerFiltro() {
                const url = new URL(window.location.href);
                url.searchParams.delete('filtro');
                url.searchParams.delete('valor');
                window.location.href = url.toString();
            }
            document.addEventListener('DOMContentLoaded', function() {
                const filtroPrincipal = document.getElementById('filtro_principal');
                const filtroDataIntervalo = document.getElementById('filtro_data_intervalo');
                const filtroFuncionario = document.getElementById('filtro_funcionario');
                const filtroFuncionarioInput = document.getElementById('filtro_funcionario_input');
                const filtroFuncionarioSuggestions = document.getElementById('filtro_funcionario_suggestions');

        HTML;
        $html .= "const funcionarios = " . json_encode($funciona['dados']) . ";";
        $html.= <<<HTML

                filtroPrincipal.addEventListener('change', function() {
                    const filtro = filtroPrincipal.value;
                    filtroDataIntervalo.style.display = 'none';
                    filtroFuncionario.style.display = 'none';

                    if (filtro === 'data') {
                        filtroDataIntervalo.style.display = 'inline-block';
                    } else if (filtro === 'funcionario') {
                        filtroFuncionario.style.display = 'inline-block';
                    }
                });

                $(function () {
                if ($('#data_inicio').length > 0 && $('#data_fim').length > 0) {
                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        language: 'pt-BR',
                        startDate: '2024-01-01',
                        endDate: '2026-12-31',
                        todayHighlight: true,
                        autoclose: true
                    });

                    $('#data_inicio').on('changeDate', function () {
                        const dataInicio = $(this).datepicker('getFormattedDate');
                        $('#data_fim').datepicker('setStartDate', dataInicio);
                    });

                    $('#data_fim').on('changeDate', function () {
                        const dataInicio = $('#data_inicio').datepicker('getFormattedDate');
                        const dataFim = $(this).datepicker('getFormattedDate');
                        if (dataInicio && dataFim) {
                            atualizarURL('dt_movimentacao', dataInicio + '...' + dataFim);
                        }
                    });
                } else {
                    console.error('Elementos #data_inicio ou #data_fim não encontrados.');
                }
            });

            filtroFuncionarioInput.addEventListener('input', function () {
                    const query = filtroFuncionarioInput.value.toLowerCase(); // Captura o valor digitado
                    filtroFuncionarioSuggestions.innerHTML = ''; // Limpa as sugestões anteriores

                    if (query.length > 0) {
                        // Filtra os funcionários com base na MATRÍCULA
                        const filteredFuncionarios = funcionarios.filter(funcionario =>
                            String(funcionario.matricula).toLowerCase().includes(query) // Busca apenas por matrícula
                        );

                        filteredFuncionarios.forEach(funcionario => {
                            const suggestionItem = document.createElement('a');
                            suggestionItem.href = '#';
                            suggestionItem.className = 'list-group-item list-group-item-action';

                            // Exibe "Matrícula - Nome" na sugestão
                            suggestionItem.textContent = funcionario.matricula + ' - ' + funcionario.nm_usuario;
                            suggestionItem.dataset.id = funcionario.id_usuario;

                            // Ao clicar na sugestão, preenche o campo de busca
                            suggestionItem.addEventListener('click', function (e) {
                                e.preventDefault();
                                filtroFuncionarioInput.value = funcionario.matricula; // Preenche com a matrícula
                                filtroFuncionarioSuggestions.style.display = 'none'; // Esconde as sugestões
                                atualizarURL('id_autor', funcionario.id_usuario); // Atualiza a URL com o ID do funcionário
                            });

                            filtroFuncionarioSuggestions.appendChild(suggestionItem);
                        });

                        filtroFuncionarioSuggestions.style.display = 'block'; // Mostra as sugestões
                    } else {
                        filtroFuncionarioSuggestions.style.display = 'none'; // Esconde as sugestões se não houver entrada
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