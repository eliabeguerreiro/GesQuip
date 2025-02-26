<?php
  
class ContentPainel
{
  public function renderHeader(){
   
    $html = <<<HTML
      <!DOCTYPE html>
      <html>
        <head>
            <title>Gestão de Movimentações</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
              integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
            
            <link rel="stylesheet" href="src/style.css">
            
        </head>

    HTML;   

    return($html);
    
  } 

  
 
    public function renderBody($funciona, $moviment, $moviment_encerrado){
      $nome = $_SESSION['data_user']['nm_usuario'];

      $func = $funciona;
      
      $html = <<<HTML
        <body>
            <nav>
                
                <div class="logo">Gestão de locações</div>
                <a href='../'><button><i class="fa fa-arrow-left"></i>Voltar</button></a>
            </nav>

            <div class="sidebar">
              <p><i class="fa fa-user"></i> $nome</p>
              <a href="../gestao_itens">Itens</a>
              <a href="" class="active">Movimentações</a>
              <a href="../manutencao">Manutenções</a>
              <a href="../gestao_usuarios">Usuários</a>
            </div>



            <main>
       
            <div class="box">
                <h2>Iniciar nova movimentação de equipamentos</h2>
                <form method='POST' action = ''>                   
                    <label for="id_responsavel">Funcionário</label><br>
                    <select name="id_responsavel">
                      <option value="">escolha o funcionário</option>"
        HTML;

      foreach ($funciona as $funcionario) {
              $html.="<option value=".$funcionario['id_usuario'].">".$funcionario['nm_usuario']."</option>";  
      }

      $html.= <<<HTML
             "</select><br><br>
                    <label for="ds_movimentacao">Detalhes da Retirada</label><br>
                    <textarea name="ds_movimentacao" id="meuParagrafo" rows="4" cols="35"></textarea>
                    <button type="submit">proximo</button>
                </form>

                <div id="myModal" class="modal">
                    <span class="close">&times;</span>
                    <input type="text" id="pesquisa" placeholder="Pesquise um item">
                    <ul id="resultados"></ul>
                </div>
            </div>

            </main>
          <br><br>
          <main>
            <div class="box2">
            <h1>Movimentações ativas</h1>
                    <table>
                        <thead>
                            <tr>
                              <th>ID        </th>
                              <th>Funcionário</th>
                              <th>Administrador</th>
                              <th>Retirada</th>
                              <th>Ver itens</th>
                            </tr>
                        </thead>
                        <tbody id="produtos">
                          <tr>
    HTML;
    
    foreach ($moviment as $movimento):
      //tratar disponibilidade e categoria

            foreach ($funciona as $user) {
              if ($user["id_usuario"] == $movimento['id_responsavel']) {
                  $responsavel = $user;
                  break;
              }             
            }
            foreach ($funciona as $user) {
              if ($user["id_usuario"] == $movimento['id_autor']) {
                $autor = $user;
                break;
              }           
            }


          $html .="<td>".$movimento['id_movimentacao']."</td>";
          $html .="<td>".$responsavel['nm_usuario']."</td>";
          $html .="<td>".$autor['nm_usuario']."</td>";
          $html .="<td>".$movimento['dt_movimentacao']."</td>";
          $html .="<td><a href='moviment.php?id=".$movimento['id_movimentacao']."'>Acessar</a></td>";
          $html .="</tr>";
          
    endforeach;     

  $html.= <<<HTML

                      </tbody>
                    </table>
            </div>            
            <br><br><br><br><br>          

        </main>


        <main>
            <div class="box2">

            
            <div class="box-title">
            <h1>Movimentações Encerradas</h1>
                  
                  <div>
                    <select name="tp_filtro" id="tp_filtro">
                      <option value="0">filtro</option>
                      <option value="id_responsavel">Funcionário</option>
                      <option value="dt_movimentacao">Data de movimentação</option>
                      
                    </select>
                  </div>

                  <div id="id_responsavel" style="display: none;">
                    <select id="filtro_familia">
                      <option>escolha o funcionário</option>
  HTML;  

          foreach ($func as $funci) { 
            $html.="<option value=".$funci['id_usuario'].">".$funci['nm_usuario']."</option>";
          }

          $html.= <<<HTML
                    </select>
                  </div>
                  <div id="dt_movimentacao" style="display: none;">
                     <input type="date" id="filtro_dt_movimentacao" name="data"required>
                  </div>
                </div>
            <div id="table1" class="hidden">
            
                    <table>
                        <thead>
                            <tr>
                              <th>ID        </th>
                              <th>Funcionário</th>
                              <th>Administrador</th>
                              <th>Retirada</th>
                              <th>Devolução</th>
                            </tr>
                        </thead>
                        <tbody id="produtos">
                          <tr>
    HTML;
    
    foreach ($moviment_encerrado as $movimento):
      //tratar disponibilidade e categoria

            foreach ($funciona as $user) {
              if ($user["id_usuario"] == $movimento['id_responsavel']) {
                  $responsavel = $user;
                  break;
              }             
            }
            foreach ($funciona as $user) {
              if ($user["id_usuario"] == $movimento['id_autor']) {
                $autor = $user;
                break;
              }           
            }


          $html .="<td>".$movimento['id_movimentacao']."</td>";
          $html .="<td>".$responsavel['nm_usuario']."</td>";
          $html .="<td>".$autor['nm_usuario']."</td>";
          $html .="<td>".$movimento['dt_movimentacao']."</td>";
          $html .="<td>".$movimento['dt_finalizacao']."</td>";
          $html .="</tr>";
          
    endforeach;     

  $html.= <<<HTML

                      </tbody>
                    </table>
            </div>
            </div>            
            <br><br><br><br><br>          

        </main>
    HTML;
  if(isset($_SESSION['msg'])){
    $html.= "<script>alert('".$_SESSION['msg']."');</script>";
    unset($_SESSION['msg']);
  }
  $html.= <<<HTML

        <script>
            document.addEventListener("DOMContentLoaded", function () {
              // Captura os elementos <select> internos
              const filtroFamilia = document.getElementById("filtro_familia");
              const filtroDt_movimentacao = document.getElementById("filtro_dt_movimentacao");

              // Função para atualizar a URL com os parâmetros GET
              function atualizarURL(filtro, valor) {
                // Constrói a nova URL com os parâmetros GET
                const url = new URL(window.location.href);
                url.searchParams.set("filtro", filtro);
                url.searchParams.set("v", valor);

                // Redireciona para a nova URL
                window.location.href = url.toString();
              }

              // Adiciona um ouvinte de evento para o <select> de familia
              if (filtroFamilia) {
                filtroFamilia.addEventListener("change", function () {
                  const valorSelecionado = filtroFamilia.value;
                  if (valorSelecionado) {
                    atualizarURL("id_responsavel", valorSelecionado);
                  }
                });
              }

              // Adiciona um ouvinte de evento para o <select> de dt_movimentacao
              if (filtroDt_movimentacao) {
                filtroDt_movimentacao.addEventListener("change", function () {
                  const valorSelecionado = filtroDt_movimentacao.value;
                  if (valorSelecionado) {
                    atualizarURL("dt_movimentacao", valorSelecionado);
                  }
                });
              }
            });


            document.addEventListener("DOMContentLoaded", function () {
              // Seleciona o elemento <select>
              const selectElement = document.getElementById("tp_filtro");

              // Adiciona um ouvinte de evento para detectar mudanças no <select>
              selectElement.addEventListener("change", function () {
                // Oculta todas as divs relacionadas aos filtros
                document.getElementById("id_responsavel").style.display = "none";
                document.getElementById("dt_movimentacao").style.display = "none";

                // Verifica o valor selecionado e exibe a div correspondente
                const selectedValue = selectElement.value;
                if (selectedValue === "id_responsavel") {
                  document.getElementById("id_responsavel").style.display = "block";
                } else if (selectedValue === "dt_movimentacao") {
                  document.getElementById("dt_movimentacao").style.display = "block";
                }
              });
            });  

        </script>
        </body>
        </html>
      HTML;   

        return($html);
  }

}
?>