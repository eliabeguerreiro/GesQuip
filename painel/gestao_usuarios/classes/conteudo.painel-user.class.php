
<?php
  
class ContentPainel
{
  public function renderHeader(){
   
    $html = <<<HTML
      <!DOCTYPE html>
      <html>
        <head>
            <title>Gestão de usuários</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
              integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
            
            <link rel="stylesheet" href="src/style.css">
        </head>

    HTML;   

    return($html);
}

 
    public function renderBody($usuarios){
      $nome = $_SESSION['data_user']['nm_usuario'];
     
      $html = <<<HTML
        <body>
            <nav>
               
                <div class="logo">Gestão de Usuariós</div>
                <a href='../'><button><i class="fa fa-arrow-left"></i> Voltar</button></a>
            </nav>
            <main>


            <div class="sidebar">
              <p><i class="fa fa-user"></i> $nome</p>
              <a href="../gestao_itens">Itens</a>
              <a href="../moviment">Movimentações</a>
              <a href="../manutencao">Manutenções</a>
              <a href=""  class="active">Usuários</a>
            </div>


            <div class="box">
                <h2>Cadastro de Usuário</h2>
                <form method='POST' action = ''>
                    <label for="nm_usuario">Nome:</label>
                    <input type="text" id="nm_usuario" name="nm_usuario" required><br><br>

                    <label for="login">login:</label>
                    <input type="text" id="login" name="login" required><br><br>

                    <label for="contato">Contato:</label>
                    <input type="fone" id="contato" name="contato" required><br><br>

                   
                    <label for="nv_permissao">Qual o nivel de permissão do usuário:</label>
                    <select name="nv_permissao">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <br><br>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required><br><br>

                    <button type="submit">Cadastrar</button>
                </form>
            </div>  

             <main>
            <div class="box2">
            <h1>Todos os Itens</h1>
                    <table>
                        <thead>
                            <tr>
                              <th>Login        </th>
                              <th>Nome </th>
                              <th>Contato      </th>
                              <th>Nivel  </th>
                              <th> </th>
                            </tr>
                        </thead>
                        <tbody id="produtos">
                          <tr>
      HTML;
          
          foreach ($usuarios as $user):
            
                $html .="<td>".$user['login']."</td>";
                $html .="<td>".$user['nm_usuario']."</td>";
                $html .="<td>".$user['nr_contato']."</td>";
                $html .="<td>".$user['nv_permissao']."</td>";

                $html .="<td><button class='atualiza-button' id ='".$user['id_usuario']."' >Editar</button>";
                $html .="<a href='apagar.php?id=".$user['id_usuario']."'><button class='delete-button' >Apagar</button></a></td>";
                $html .="</tr>";
                
          endforeach;     

        $html.= <<<HTML

                            </tbody>
                          </table>
                  </div>            
                  <br><br><br><br><br>          
         
          <!-- Modal HTML -->
           <div id="atualizaModal" class="modal" style="display:none;">
            <div class="modal-content">
              <span class="close">&times;</span>
              <h2>Atualizar dados do Usuário</h2>

              <select id="statusSelect" required> 
                <option value="nm_usuario">nome</option>
                <option value="nr_contato">numero de contato</option>
                <option value="tp_usuario">tipo do usuário</option>
                <option value="nv_permissao">nivel de permissão</option>
              </select>

            <input type="text" id="novoNome" placeholder="digite o novo dado" required>
            <small>para atualizar o nivel de permissão use apenas números</small>
            <button id="atualizaSubmit">Enviar</button>
            </div>
          </div>


          </main>



        HTML;
        if(isset($_SESSION['msg'])){
         $html.= "<script>alert('".$_SESSION['msg']."');</script>";
         unset($_SESSION['msg']);
        }
       $html.= <<<HTML
          <script>

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
              const status = document.getElementById('statusSelect').value;

              fetch('atualizar_user.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(currentItemId) + '&data=' + encodeURIComponent(texto) + '&metadata=' + encodeURIComponent(status)
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