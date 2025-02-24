<?php
session_start();
include_once"classes/user.class.php";
include_once"classes/db.class.php";
//var_dump($_SESSION);
//echo(password_hash('hants12', PASSWORD_DEFAULT));
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach ($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time() - 3600, '/');
        setcookie($name, '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
              integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
            
    <title>Página de Login</title>
    <style>
      
    </style>
</head>
<?php 
              //coleta e limpeza de valores inseridos no formulário
    if($_POST){
        
        $dados_login = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if($login = User::login($dados_login)){
           $_SESSION['msg'] =  "Usuário ".$obj['nm_usuario']." logado!";  
          header('Location:painel/');
        
        }
    } 

?>
<body>
    <div id='login_place'>
        <?php 
            if (isset($_SESSION['msg'])) {
                echo '<div class="msg ' . (strpos($_SESSION['msg'], 'logado') ? '' : 'error') . '">' . $_SESSION['msg'] . '</div>';
                unset($_SESSION['msg']);
            }
        ?>
        <form action="" method="POST">
            <label for="username" class="center-label">Login:</label>
            <input type="text" id="username" name="login" required>
            <label for="password" class="center-label">Senha:</label>
            <input type="password" id="password" name="senha" required>
            <button type="submit">Logar</button>
        </form>
    </div>
</body>
</html>