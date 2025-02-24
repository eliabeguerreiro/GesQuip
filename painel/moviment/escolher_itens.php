<?php
session_start();
ob_start();
include_once"classes/conteudo.painel-moviment.class.php";
include_once"classes/gest-moviment.class.php";
include_once"classes/db.class.php";


$itens = Painel::getItensDisponiveis(null);
$pagina = new ContentPainel;
$fami = Painel::getFamilia();


//como remover itens da disponibilidade caso hajam mais de um adm para gerir 

//salvo o ID da movimentação em um cookie para ser usado na escolha de itens

if(isset($_GET['id'])){
    $_SESSION['id_moviment'] = $_GET['id'];
    header('location:escolher_itens.php');
}


if(Painel::validarToken()){

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
    $moviment = Painel::getMoviment($id);
    $id_resp = $moviment['dados'][0]['id_responsavel'];
    $funcionario = Painel::getFuncionarios($id_resp);
    $responsavel = $funcionario['dados'][0]['nm_usuario'];
    $nome = $_SESSION['data_user']['nm_usuario'];

    $html = <<<HTML
            <!DOCTYPE html>
                <html>
                    <head>
                        <title>Movimentação N:$id</title>
                        <link rel="stylesheet" href="src/style.css">
                        
                    </head>
            <body>
                <nav>
                    <i class="fa fa-user"></i><p>$nome</p>
                    <div class="logo">Escolha de itens</div>
                    <a href='../'><button><i class="fa fa-arrow-left"></i>Voltar</button></a>
                </nav>
                <main>
        
            
                <div class="box2">
                    <h2>Movimentação N:$id</h2>
                    <small>Funcionário responsável: $responsavel</small>
                    <form method='POST' action ='envia_moviment.php'>  
    HTML;
    
    if($reservado = Painel::getItensDisponiveis($id)){
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