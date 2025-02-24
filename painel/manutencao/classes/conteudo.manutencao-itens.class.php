<?php
  
class ContentPainel
{
  public function renderHeader(){
   
    $html = <<<HTML
      <!DOCTYPE html>
      <html>
        <head>
            <title>Gestão de Manutenções</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
              integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
            
            <link rel="stylesheet" href="src/style.css">
        </head>

    HTML;   

    return($html);
}

 
    public function renderBody($manutenc, $item){
      $nome = $_SESSION['data_user']['nm_usuario'];

      if($manutenc){
        $html = <<<HTML
        <body>
            <nav>
                
                <div class="logo">Gestão de Manutenções</div>
                <a href='../'><button><i class="fa fa-arrow-left"></i>voltar</button></a>
            </nav>
            <main>


            <div class="sidebar">
              <p><i class="fa fa-user"></i> $nome</p>
              <a href="../gestao_itens">Itens</a>
              <a href="../moviment">Movimentações</a>
              <a href=""class="active">Manutenções</a>
              <a href="../gestao_usuarios">Usuários</a>
            </div>


            <div class="box">
                <h2>Nova manutenção de equipamento</h2>
                <form method='POST' action = ''>                   
                    <label for="id_responsavel">Itens</label><br>
                    <select name="id_item">
                      <option value="">escolha o item</option>"
      HTML;

            foreach ($item as $itens) {
                    $html.="<option value=".$itens['id_item'].">".$itens['ds_item']."</option>";  
            }

            $html.= <<<HTML
             "</select><br><br>
                    <label for="obs_in">Detalhes da manutenção</label><br>
                    <textarea name="obs_in" id="meuParagrafo" rows="4" cols="35"></textarea>
                    <button type="submit">cadastrar</button>
                </form>
            </div>
            <div class="box2">
            <h1>Todos os Itens em manutenção</h1>
                    <table>
                        <thead>
                            <tr>
                              <th>ID da manutencao</th>
                              <th>Cod</th>
                              <th>Detalhes</th>
                              <th>Responsável</th>
                              <th>Data manutenção</th>
                              <th></th>
                            </tr>
                        </thead>
                        <tbody id="produtos">
                          <tr>
    HTML;

    
    foreach ($manutenc as $manutencao):

      foreach ($item as $itens) {
          if($itens['id_item'] == $manutencao['id_item']){
            $cod = $itens['cod_patrimonio'];
          }  
      }
            
          $funcionario = Painel::getFuncionarios($manutencao['id_autor']);
          $responsavel = $funcionario['dados'][0]['nm_usuario'];


      //tratar disponibilidade e categoria
          $html .="<td>".$manutencao['id_manutencao']."</td>";   
          $html .="<td>".$cod."</td>";
          $html .="<td>".$manutencao['obs_in']."</td>";
          $html .="<td>".$responsavel."</td>";
          $html .="<td>".$manutencao['dt_inicio_manutencao']."</td>";
          $html .="<td><button class='finaliza-button' id ='".$manutencao['id_manutencao']."' >Retornar item</button></td>";
          $html .="</tr>";
          
    endforeach;     

  $html.= <<<HTML

                      </tbody>
                    </table>
            </div>            
            <br><br><br><br><br>          

          <!-- Modal HTML -->
          <div id="finalizaModal" class="modal" style="display:none;">
            <div class="modal-content">
              <span class="close">&times;</span>
              <h2>Finalizar Manutenção</h2>
            <input type="text" id="finalizaTexto" placeholder="Resumo da manutenção" required>
            <select id="statusSelect" required> 
              <option value="1">Disponível</option>
              <option value="999999999">Quebrado</option>
              
            </select>
            <button id="finalizaSubmit">Enviar</button>
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
          document.addEventListener('DOMContentLoaded', () => {
            const finalizaButtons = document.querySelectorAll('.finaliza-button');
            const modal = document.getElementById('finalizaModal');
            const closeModal = document.querySelector('.modal .close');
            const finalizaSubmit = document.getElementById('finalizaSubmit');
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
              const texto = document.getElementById('finalizaTexto').value;
              const status = document.getElementById('statusSelect').value;

              fetch('finaliza_manutencao.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(currentItemId) + '&texto=' + encodeURIComponent(texto) + '&status=' + encodeURIComponent(status)
                })
              .then(response => response.text())
              .then(data => {
                console.log(data);
                modal.style.display = 'none';
                window.location.reload();
              })
              .catch(error => console.error('Error:', error));
            });
          });
        </script>
        </body>
        </html>
      HTML;   


      }else{
        
        //pagina sem manutenções cadastrada em banco


        $html = <<<HTML
        <body>

          <nav>    
                <div class="logo">Gestão de Manutenções</div>
                <a href='../'><button><i class="fa fa-arrow-left"></i>voltar</button></a>
            </nav>
            <main>


            <div class="sidebar">
              <p><i class="fa fa-user"></i> $nome</p>
              <a href="../gestao_itens">Itens</a>
              <a href="../moviment">Movimentações</a>
              <a href=""class="active">Manutenções</a>
              <a href="../gestao_usuarios">Usuários</a>
            </div>


            
            <main>

            <div class="box">
                <h2>Nova manutenção de equipamento</h2>
                <form method='POST' action = ''>                   
                    <label for="id_responsavel">Itens</label><br>
                    <select name="id_item">
                      <option value="">escolha o item</option>"
      HTML;

            foreach ($item as $itens) {
                    $html.="<option value=".$itens['id_item'].">".$itens['ds_item']."</option>";  
            }

            $html.= <<<HTML
             "</select><br><br>
                    <label for="obs_in">Detalhes da manutenção</label><br>
                    <textarea name="obs_in" id="meuParagrafo" rows="4" cols="35"></textarea>
                    <button type="submit">cadastrar</button>
                </form>
            </div>
            <div class="box2">
            <h1>Todos os Itens em manutenção</h1>
                    <table>
                        <thead>
                            <tr>
                              <th>Cod. manutencao</th>
                              <th>Cod</th>
                              <th>Detalhes</th>
                              <th>Responsável</th>
                              <th>Data manutenção</th>
                              <th></th>
                            </tr>
                        </thead>
                       
                    </table>
            </div>            
            <br>
        </main>

        
        </body>
        </html>
      HTML;   



      }


        return($html);
  }

}
?>