
<?php
  
class ContentPainel
{
  public function renderHeader(){
   
    $html = <<<HTML
      <!DOCTYPE html>
      <html>
        <head>
            <title>Painel Inicial</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
              integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
            
            <link rel="stylesheet" href="src/style.css">
        </head>

    HTML;   
    
    return($html);
}

 
    public function renderBody(){
      //var_dump($_SESSION['data_user']);
      $nome = $_SESSION['data_user']['nm_usuario'];
     
      $html = <<<HTML
        <body>
            <nav>
                <div class="logo">Painel Principal</div>
                <a href='?sair=sair'><button class="sair"><i class="fa fa-power-off"></i> Sair</button></a>
            </nav>

            <div class="sidebar">
              <p><i class="fa fa-user"></i> $nome</p>
              <a href="" class="active">Painel Principal</a>
              <a href="gestao_itens/">Itens</a>
              <a href="moviment/">Movimentações</a>
              <a href="manutencao/">Manutenções</a>
              <a href="gestao_usuarios/">Usuários</a>
            </div>
            <main>
  
            <div class="modal-content">
                <h2>Buscar item:</h2>
                <label for="chaveSelect">Escolha a chave de identificação:</label>
                <select id="chaveSelect" required> 
                  <option value="ds_item">nome</option>
                  <option value="cod_patrimonio">patrimonio</option>
                </select>
                <br>
                <label for="busca"><small>Digite o nome/patrimonio</small></label>
                <input type="text" id="busca" required>
                <button id="finalizaSubmit">Buscar</button>
            </div>

            <div class="box2">
              <h1>Itens encontrados</h1>
              <div id="table1" class="hidden">
                    <table>
                        <thead>
                            <tr>
                              <th>Cod        </th>    
                              <th>Nome      </th>
                              <th>Familia      </th>
                              <th>Movimentação</th>
                              <th>Usuário</th>
                              <th>Devolver</th>
                            </tr>
                        </thead>
                         <tbody id="produtos">

                          </tbody>
                          </table>
                  </div>
                  </div>      
          </main>

      
     HTML;
     if(isset($_SESSION['msg'])){
      $html.= "<script>alert('".$_SESSION['msg']."');</script>";
      unset($_SESSION['msg']);
     }
    $html.= <<<HTML
        <script src="src/script.js"></script>
        </body>
        </html>
      HTML;   

        return($html);
   }



}
?>