<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-moviment.class.php";
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";


$itens = Item::getItensDisponiveis(null);
$pagina = new ContentPainelMoviment;
$fami = Item::getFamilia();


//como remover itens da disponibilidade caso hajam mais de um adm para gerir 

//salvo o ID da movimentação em um cookie para ser usado na escolha de itens

if(isset($_GET['id'])){
    $_SESSION['id_moviment'] = $_GET['id'];
    header('location:escolher_itens.php');
}


if(Paineel::validarToken()){

}else{
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 
}
if(!isset($_SESSION['data_user'])){
  
    $_SESSION['msg'] = '<p>Você precisa logar para acessar o painel</p>';
    header('Location:../'); 

}

if($_SESSION['id_moviment']){
    $id = $_SESSION['id_moviment'];
    $moviment = Moviment::getMoviment($id);
    $id_resp = $moviment['dados'][0]['id_responsavel'];
    $funcionario = User::getFuncionarios($id_resp);
    $responsavel = $funcionario['dados'][0]['nm_usuario'];
    $nome = $_SESSION['data_user']['nm_usuario'];

    $html = <<<HTML
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Movimentação N:$id</title>
                <link rel="stylesheet" href="src/style.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            </head>
            <body>
                <!-- INÍCIO BARRA DE NAVEGAÇÃO -->
                <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><b>GesQuip</b></a>
                        <div class="navbar-collapse justify-content-center" id="collapsibleNavbar">
                            <ul class="navbar-nav text-center">
                                <li class="nav-item">
                                    <h2 class="navbar-brand mb-0">Movimentação N:  $id</h2>
                                </li>
                                <li class="nav-item">
                                    <small class="navbar-brand">Funcionário responsável: $responsavel</small>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex ms-auto">
                            <a href="?sair=1" class="btn btn-danger btn-sm">Sair</a>
                        </div>
                    </div>
                </nav>
                <!-- FIM BARRA DE NAVEGAÇÃO -->

            
                <div class="box2">
                    <form method='POST' action ='envia_moviment.php'>  
    HTML;
    
    if($reservado = Item::getItensDisponiveis($id)){
        $html .= <<<HTML
                <h3>Itens reservados</h3>
                    <table>
                    <thead>
                        
                        <tr>
                            <th>ID        </th>
                            <th>Familia        </th>
                            <th>Nome      </th>
                            
                        </tr>
                    </thead>

        HTML;    

        foreach ($reservado['dados'] as $res):


            $id_fami = $res['id_familia'];

            foreach ($fami['dados'] as $familiaa) {
              
              if($familiaa['id_familia'] == $id_fami){
                $nm_familia = $familiaa['ds_familia'];
              }
            }
            //tratar disponibilidade e categoria
                $html .="<tr>";
                $html .="<td>".$res['id_item']."</td>";
                $html .="<td>".$nm_familia."</td>";
                $html .="<td>".$res['ds_item']."</td>";
                $html .="</tr>";
                
        endforeach;     

        
    }
        $html .= <<<HTML
                    </table>
                    <br>
                    <button type="submit">Finalizar movimentação</button>
                    </form>
                </div>

                <div class="box2">
                    <h1>Itens Disponíveis</h1>
                        <table>
                            <thead>
                            <tr>
                                <th>Cod       </th>
                                <th>Familia        </th>
                                <th>Nome      </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="produtos">
                            <tr>
        HTML;
        
        foreach ($itens['dados'] as $item):

            
            $id_fami = $item['id_familia'];

            foreach ($fami['dados'] as $familiaa) {
              
              if($familiaa['id_familia'] == $id_fami){
                $nm_familia = $familiaa['ds_familia'];
              }
            }
        //tratar disponibilidade e categoria

            $html .="<td>".$item['cod_patrimonio']."</td>";
            $html .="<td>".$nm_familia."</td>";
            $html .="<td>".$item['ds_item']."</td>";
            $html .="<td><button class='reservar-button' id = '".$item['id_item']."' >reservar</button></td>";
            $html .="</tr>";
            
        endforeach;     

    $html.= <<<HTML

                        </tbody>
                        </table>
                </div>            
                </main>

        HTML;
        if(isset($_SESSION['msg'])){
          $html.= "<script>alert('".$_SESSION['msg']."');</script>";
          unset($_SESSION['msg']);
        }
        $html.= <<<HTML
                
                <script>
                const reservarButtons = document.querySelectorAll('.reservar-button');

                reservarButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const itemId = button.id;

                    fetch('reservar.php', {
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
                </script>
                </body>
                </html>

    HTML;

    echo $html;
}else{
    $_SESSION['msg'] = 'Movimentação não encontrada';
    header('location:escolher_itens.php');

}