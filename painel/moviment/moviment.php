<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-moviment.class.php";
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";
$pagina = new ContentPainel;
$itens = Item::getItens();
$fami = Item::getFamilia();
//var_dump($itens['dados']);


if(Paineel::validarToken()){

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
}
if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}

//salvo o ID da movimentação em um cookie para ser usado na escolha de itens
   
if(isset($_GET['id'])){
    $_SESSION['id_moviment'] = $_GET['id'];
    header('location:moviment.php');
}





if($_SESSION['id_moviment']){
    $id = $_SESSION['id_moviment'];
    $moviment = Moviment::getMoviment($id);
    $item_mov = Item::getItensMoviment($id);
    $item_devolv = Item::getItensDevolvidos($id);

    if($item_mov['dados'] == null){ 
        //verfica se a movimentação não possui itens locados e finaliza a movimentação
        if(Painel::finalizaMoviment($id)){ 
            header('location:./');
        }
    }

    $id_responsavel = $moviment['dados'][0]['id_responsavel'];
    $funcionario = Painel::getFuncionarios($id_responsavel);
    $responsavel = $funcionario['dados'][0]['nm_usuario'];
    $nome = $_SESSION['data_user']['nm_usuario'];
    if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; unset($_SESSION['msg']);} 
    $html = <<<HTML
            <!DOCTYPE html>
                <html>
                    <head>
                        <title>Movimentação N:$id</title>
                        <link rel="stylesheet" href="src/style.css">
                        
                    </head>
            <body>
            <nav>  
                <div class="logo">Gestão de movimentação</div>
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
                    
                <div class="box2">
                    <h1>Itens em uso</h1>
                    <h2>Movimentação N:$id</h2>
                    <small>Funcionário responsável: $responsavel</small>
                        <table>
                            <thead>
                                <tr>
                                <th>Cod        </th>
                                <th>Familia  </th>
                                <th>Nome      </th>
                                <th>  </th>
                                <th>  </th>
                                </tr>
                            </thead>
                            <tbody id="produtos">
                            <tr>
        HTML;
        
        foreach ($item_mov['dados'] as $item):
            
            foreach ($itens['dados'] as $item_data) {
                $cod = $item_data['cod_patrimonio'];
                $id_fami = $item_data['id_familia'];
                if ($item_data["id_item"] == $item['id_item']) {
                    $nm_item = $item_data['ds_item'];
                    break;
                }             

                //var_dump($fami['dados']['id_familia']);
                foreach ($fami['dados'] as $familiaa) {
                
                    if($familiaa['id_familia'] == $id_fami){
                    $nm_familia = $familiaa['ds_familia'];
                    }
                }



            }
            


            $html .="<td>".$cod."</td>";
            $html .="<td>".$nm_familia."</td>";
            $html .="<td>".$nm_item."</td>";
            $html .="<td><button class='manutencao-button' id ='".$item['id_item']."' >Manutencao</button></td>";
            $html .="<td><button class='devolver-button' id = '".$item['id_item']."' >Devolver</button></td>";
            $html .="</tr>";
            
        endforeach;     

    $html.= <<<HTML

                        </tbody>
                        </table>
                </div>   
                 <!-- Modal HTML -->
                 <div id="finalizaModal" class="modal" style="display:none;">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Iniciar manutenção</h2>
                        <input type="text" id="finalizaTexto" placeholder="Descreva o caso para a manutenção" required>
                        <button id="finalizaSubmit">Enviar</button>
                    </div>
                </div>

                </main>

                <div class="box2">
                    <h1>Itens Devolvidos</h1>

                        <table>
                            <thead>
                                <tr>
                                <th>Cod        </th>
                                <th>Familia  </th>
                                <th>Nome      </th>
                                <th>Data da devolução</th>
                                </tr>
                            </thead>
                            <tbody id="produtos">
                            <tr>
        HTML;
        
    if($item_devolv['dados'] == null){
        $html .="<td colspan='4'>Nenhum item devolvido</td>";
    }else{
        foreach ($item_devolv['dados'] as $item):
        
            foreach ($itens['dados'] as $item_data) {
                $cod = $item_data['cod_patrimonio'];
                $id_fami = $item_data['id_familia'];
                if ($item_data["id_item"] == $item['id_item']) {
                    $nm_item = $item_data['ds_item'];
                    break;
                }             

                //var_dump($fami['dados']['id_familia']);
                foreach ($fami['dados'] as $familiaa) {
                
                    if($familiaa['id_familia'] == $id_fami){
                    $nm_familia = $familiaa['ds_familia'];
                    }
                }



            }
            


            $html .="<td>".$cod."</td>";
            $html .="<td>".$nm_familia."</td>";
            $html .="<td>".$nm_item."</td>";
            $html .="<td>".$item['dt_devolucao']."</td>";
            $html .="</tr>";
            
        endforeach;     



    }

        

    $html.= <<<HTML

                        </tbody>
                        </table>
                </div>   
                    
                </main>
                <br><br>
                <script>

                    document.addEventListener('DOMContentLoaded', () => {
                        const finalizaButtons = document.querySelectorAll('.manutencao-button');
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

                            fetch('inicia_manutencao.php', {
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

                        const reservarButtons = document.querySelectorAll('.devolver-button');

                        reservarButtons.forEach(button => {
                            button.addEventListener('click', () => {
                                const itemId = button.id;

                                fetch('devolver.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: 'id=' + encodeURIComponent(itemId)
                                })
                                .then(response => response.text())
                                .then(data => {
                                    console.log(data);
                                    window.location.reload();
                                })
                                .catch(error => console.error('Error:', error));
                            });
                        });
                    });
                </script>
            </body>
            </html>

    HTML;

    echo $html;
}