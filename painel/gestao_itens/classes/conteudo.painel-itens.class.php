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
          <link rel="stylesheet" href="style.css">
      </head>

    HTML;   

    return($html);
}

    public function renderBody($fami, $itens, $itens_disponiveis, $itens_locados){
      $nome = $_SESSION['data_user']['nm_usuario'];
      
      // Verifica se os parâmetros GET estão definidos
      $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : null;
      $v = isset($_GET['v']) ? $_GET['v'] : null;


      $html = <<<HTML
        <body>


            <nav>
                
                <div class="logo">Gestão de itens</div>
                <a href='../'><button><i class="fa fa-arrow-left"></i> Voltar</button></a>
            </nav>

            <div class="sidebar">
              <p><i class="fa fa-user"></i> $nome</p>
              <a href="" class="active">Itens</a>
              <a href="../moviment">Movimentações</a>
              <a href="../manutencao">Manutenções</a>
              <a href="../gestao_usuarios">Usuários</a>
            </div>

            
            <main>
      
            <div class="box">
                <h2>Cadastro de Item</h2>
                <form method='POST' action = ''>                   
                    <label for="familia">Familia:</label>
                    <select name="familia">
                    <option value="">Escolha uma familia</option>"
        HTML;

      foreach ($fami as $familia) {
        $html.="<option value=".$familia['id_familia'].">".$familia['ds_familia']."</option>";  
      }

      $filtro_familia = $fami;

      $html.= <<<HTML
                    </select><br><br>
                    <label for="nome">Modelo do item (descrição + marca):</label>
                    <input type="text" id="nome" name="nome" required><br><br>

                    <label for="natureza">Qual a natureza de posse do item:</label>
                    <select name="natureza">
                      <option value="proprio">próprio</option>
                      <option value="locado">locado</option>
                    </select>
                    <br><br>
                    <label for="nv_permissao">Qual o nivel de permissão do item:</label>
                    <select name="nv_permissao">
                      <option value="1">1</option>
                      <option value="2">2</option>
                    </select>
                    <br><br>
                    <button type="submit">Cadastrar</button>
                </form>
            </div>  
          </main>
          <br><br>

      HTML;
        
        if ($filtro && $v) {

            $itens = Painel::getItens(null, $filtro, $v);




            $html.= <<<HTML
            <main>
              <div class="box2">
                <div class="box-title">
                  <h1>Todos os Itens</h1>
                  
                  <div>
                    <select name="tp_filtro" id="tp_filtro">
                      <option value="0">filtro</option>
                      <option value="id_familia">familia</option>
                      <option value="natureza">natureza</option>
                    </select>
                  </div>

                  <div id="id_familia" style="display: none;">
                    <select id="filtro_familia">
                      <option>escolha a familia</option>
          HTML;  

          foreach ($filtro_familia as $familia) { 
            $html.="<option value=".$familia['id_familia'].">".$familia['ds_familia']."</option>";
          }

          $html.= <<<HTML
                    </select>
                  </div>

                  <div id="natureza" style="display: none;">
                    <select id="filtro_natureza">
                      <option value="propio">propio</option>
                      <option value="locado">locado</option>
                    </select>
                  </div>
              
                </div>
                <div id="table1" class="hidden">
                      <table>
                          <thead>
                              <tr>
                                <th>Cod        </th>
                                <th>Familia </th>
                                <th>Nome      </th>
                                <th>Natureza  </th>
                                <th> </th>
                              </tr>
                          </thead>
                          <tbody id="produtos">
                            <tr>
            HTML;
            
            foreach ($itens['dados'] as $item):
              
              $id_fami = $item['id_familia'];

              foreach ($fami as $familiaa) {
                
                if($familiaa['id_familia'] == $id_fami){
                  $nm_familia = $familiaa['ds_familia'];
                }
              }


                  $html .="<td>".$item['cod_patrimonio']."</td>";
                  $html .="<td>".$nm_familia."</td>";
                  $html .="<td>".$item['ds_item']."</td>";

                  $html .="<td>".$item['natureza']."</td>";
                  $html .="<td><button class='atualiza-button' id ='".$item['id_item']."' >Editar</button>";
                  $html .="<a href='apagar.php?id=".$item['id_item']."'><button class='delete-button' >Apagar</button></a></td>";
                  $html .="</tr>";
                  
            endforeach;     


        }else{

        





          $html.= <<<HTML
              <main>
                <div class="box2">
                  <div class="box-title">
                    <h1>Todos os Itens</h1>
                    
                    <div>
                      <select name="tp_filtro" id="tp_filtro">
                        <option value="0">filtro</option>
                        <option value="id_familia">familia</option>
                        <option value="natureza">natureza</option>
                      </select>
                    </div>

                    <div id="id_familia" style="display: none;">
                      <select id="filtro_familia">
                        <option>escolha a familia</option>
            HTML;  

            foreach ($filtro_familia as $familia) { 
              $html.="<option value=".$familia['id_familia'].">".$familia['ds_familia']."</option>";
            }

            $html.= <<<HTML
                      </select>
                    </div>

                    <div id="natureza" style="display: none;">
                      <select id="filtro_natureza">
                        <option value="propio">propio</option>
                        <option value="locado">locado</option>
                      </select>
                    </div>
                
                  </div>
                  <div id="table1" class="hidden">
                        <table>
                            <thead>
                                <tr>
                                  <th>Cod        </th>
                                  <th>Familia </th>
                                  <th>Nome      </th>
                                  <th>Natureza  </th>
                                  <th> </th>
                                </tr>
                            </thead>
                            <tbody id="produtos">
                              <tr>
              HTML;
              
              foreach ($itens as $item):
                
                $id_fami = $item['id_familia'];

                foreach ($fami as $familiaa) {
                  
                  if($familiaa['id_familia'] == $id_fami){
                    $nm_familia = $familiaa['ds_familia'];
                  }
                }


                    $html .="<td>".$item['cod_patrimonio']."</td>";
                    $html .="<td>".$nm_familia."</td>";
                    $html .="<td>".$item['ds_item']."</td>";

                    $html .="<td>".$item['natureza']."</td>";
                    $html .="<td><button class='atualiza-button' id ='".$item['id_item']."' >Editar</button>";
                    $html .="<a href='apagar.php?id=".$item['id_item']."'><button class='delete-button' >Apagar</button></a></td>";
                    $html .="</tr>";
                    
              endforeach;     


        }

        $html.= <<<HTML

                            </tbody>
                          </table>
                  </div>
                  </div>            
                  <br><br><br><br><br>          
         
          <!-- Modal HTML -->
           <div id="atualizaModal" class="modal" style="display:none;">
            <div class="modal-content">
              <span class="close">&times;</span>
              <h2>Atualizar descrição</h2>
            <input type="text" id="novoNome" placeholder="Nova descrição" required>
           
            <button id="atualizaSubmit">Enviar</button>
            </div>
          </div>





                  
          </main>
          <main>
            <div class="box2">
            <h1>Todos os Itens Disponiveis</h1>
                    <table>
                        <thead>
                            <tr>
                              <th>Cod        </th>
                              <th>Familia </th>
                              <th>Nome      </th>     
                            </tr>
                        </thead>
                        <tbody id="produtos">
                          <tr>
    HTML;
    
    foreach ($itens_disponiveis as $item):
      
      $id_fami = $item['id_familia'];

      foreach ($fami as $familiaa) {
        
        if($familiaa['id_familia'] == $id_fami){
          $nm_familia = $familiaa['ds_familia'];
        }
      }

          
          $html .="<td>".$item['cod_patrimonio']."</td>";
          $html .="<td>".$nm_familia."</td>";
          $html .="<td>".$item['ds_item']."</td>";
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
            <h1>Todos os Itens em uso</h1>
                    <table>
                        <thead>
                            <tr>
                              <th>Cod        </th>
                              <th>Familia </th>
                              <th>Nome      </th>

                            </tr>
                        </thead>
                        <tbody id="produtos">
                          <tr>
    HTML;
    
    foreach ($itens_locados as $item):
      
      $id_fami = $item['id_familia'];

      foreach ($fami as $familiaa) {
        
        if($familiaa['id_familia'] == $id_fami){
          $nm_familia = $familiaa['ds_familia'];
        }
      }

          $html .="<td>".$item['cod_patrimonio']."</td>";
          $html .="<td>".$nm_familia."</td>";
          $html .="<td>".$item['ds_item']."</td>";
          $html .="</tr>";
          
    endforeach;     

  $html.= <<<HTML

                      </tbody>
                    </table>
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
              const filtroNatureza = document.getElementById("filtro_natureza");

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
                    atualizarURL("id_familia", valorSelecionado);
                  }
                });
              }

              // Adiciona um ouvinte de evento para o <select> de natureza
              if (filtroNatureza) {
                filtroNatureza.addEventListener("change", function () {
                  const valorSelecionado = filtroNatureza.value;
                  if (valorSelecionado) {
                    atualizarURL("natureza", valorSelecionado);
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
                document.getElementById("id_familia").style.display = "none";
                document.getElementById("natureza").style.display = "none";

                // Verifica o valor selecionado e exibe a div correspondente
                const selectedValue = selectElement.value;
                if (selectedValue === "id_familia") {
                  document.getElementById("id_familia").style.display = "block";
                } else if (selectedValue === "natureza") {
                  document.getElementById("natureza").style.display = "block";
                }
              });
            });  


            const finalizaButtons = document.querySelectorAll('.atualiza-button');
            const modal = document.getElementById('atualizaModal');
            const closeModal = document.querySelector('.modal .close');
            const finalizaSubmit = document.getElementById('atualizaSubmit');
            let currentItemId;

            finalizaButtons.forEach(button => {
              button.addEventListener('click', () => {
                currentItemId = button.id;
                modal.style.display = 'block';
              });
            });

            closeModal.addEventListener('click', () => {
              modal.style.display = 'none';
            });

            // Fechar a modal ao clicar fora dela
            window.onclick = function(event) {
              if (event.target == modal) {
                modal.style.display = 'none';
              }
            }

            finalizaSubmit.addEventListener('click', () => {
              const texto = document.getElementById('novoNome').value;
              

              fetch('atualizar_item.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(currentItemId) + '&texto=' + encodeURIComponent(texto)
                })
              .then(response => response.text())
              .then(data => {
                console.log(data);
                modal.style.display = 'none';
                window.location.reload();
              })
              .catch(error => console.error('Error:', error));
            });
        </script>
        </body>
        </html>
      HTML;   

        return($html);
  }

}
?>