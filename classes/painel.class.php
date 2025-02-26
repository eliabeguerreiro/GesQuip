<?php
// if(Usuarios::verificar($conn, $headers)){  }  
class Paineel
{


    public static function validarToken($token = null)
    {
        if ($token === null) {
            $token = $_COOKIE['token'] ?? '';
        }

        // Verifica se o token existe e está no formato correto
        if (empty($token) || count(explode('.', $token)) !== 3) {
            return false;
        }

        $chave = 'TESTEDEUMASENHA123';
        list($headerB64, $payloadB64, $signatureB64) = explode('.', $token);

        // Decodifica o header e o payload
        $header = json_decode(base64_decode($headerB64), true);
        $payload = json_decode(base64_decode($payloadB64), true);

        // Verifica se houve erros na decodificação do JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        // Verifica se o token expirou
        if (isset($payload['exp']) && time() > $payload['exp']) {
            return false; // Token expirado
        }

        // Calcula a assinatura esperada
        $calculatedSignature = hash_hmac('sha256', "$headerB64.$payloadB64", $chave, true);
        $calculatedSignatureB64 = base64_encode($calculatedSignature);

        // Compara as assinaturas
        if (!hash_equals($signatureB64, $calculatedSignatureB64)) {
            return false; // Assinatura inválida
        }

        return true;
    }


    public static function logOut()
    {
        // Remove o token do cookie
        if (isset($_COOKIE['token'])) {
            setcookie('token', '', time() - 3600, '/');
        }
    
        // Destrói a sessão
        session_unset();
        session_destroy();
    
        // Define uma mensagem de sucesso
        $_SESSION['msg'] = 'Usuário deslogado com sucesso.';
    
        // Redireciona para a página de login
        header('Location: ../');
        exit;
    }
    
    public static function login($data)
    {

        if(isset($data)){

            //limpeza dos valores coletados
            $login = addslashes(htmlspecialchars($data['login'])) ?? '';
            $senha = addslashes(htmlspecialchars($data['senha'])) ?? '';

            $db = DB::connect();
            $rs = $db->prepare("SELECT * FROM usuarios WHERE login = '{$login}' LIMIT 1");
            $rs->execute();
            $obj = $rs->fetchObject();
            $rows = $rs->rowCount();


            if ($rows > 0) {
                $passDB        = $obj->senha;
                $validPassword = password_verify($senha, $passDB) ? true : false;
            }else{
                $validPassword = false;
            }

            if($validPassword){
                $obj = (array)$obj;
                $_SESSION['data_user'] = $obj;
               
                
                //o JWT é dividido em 3 partes separadas por '.': header, payload e signature

                //header indicao o tipo de token "JWT" e o algoritimo utilizado "HS256"

                $header = [ 
                    'alg' => 'HS256',
                    'type' => 'JWT',
                ];

                //converter
                $header = json_encode($header);
                //codificar em base64
                $header = base64_encode($header);
               
                //O payload é o corpo do JWT, recebe as informações que precisa armazenar
                //iss O dominio da aplicação que gera o token
                //aud Define o domínio que pode usar o token
                //exp Data de vencimento do token
                //7 days; 24 hours; 60 mins; 60secs


                $duracao = time() + (30 * 60);
                //30 minutos
                $payload = [
                    /*'iss' => 'localhost',
                    'aud' => 'localhost',*/
                    'exp' => $duracao,
                    'id' =>  $obj['id_usuario'],
                    'nome' =>  $obj['nm_usuario'],
                    'email' => $obj['email']

                ];
                
                $payload = json_encode($payload);
                
                $payload = base64_encode($payload);

                $chave = 'TESTEDEUMASENHA123';

                $signature = hash_hmac('sha256',"$header.$payload", $chave, true);
                $signature = base64_encode($signature);
                //var_dump($signature);
                //echo "<br>token: $header.$payload.$signature<br>";
                setcookie('token', "$header.$payload.$signature", time() + (60 * 60));

                return true;
                
            }else{$_SESSION['msg'] =  "<p id='aviso'>login ou senha incorreto</p>";}


        }else{
            $_SESSION['msg'] =  "faltam informações";
            exit;
        }
    }
   
}