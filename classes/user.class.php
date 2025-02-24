<?php
// if(Usuarios::verificar($conn, $headers)){  }  
class User
{

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


    public static function getPerfil($id){
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM perfil WHERE cd_user = $id");
        $rs->execute();
        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

        if ($obj) {
            return ["dados" => $obj];
        } else {
             $_SESSION['msg'] =  "Não existe dados para retornar";
        }
    }

    public static function updatePerfil($metadata, $data){
        
      
        $db = DB::connect();
        $rs = $db->prepare("UPDATE perfil SET ".$metadata." ='".$data."'");
        $rs->execute();
        $rows = $rs->rowCount();
        if ($rows > 0) {
            var_dump("produto cadastrado");
            return true;
        }else{
            $_SESSION['msg'] =  "erro na alteração";
            return false;

        }
   

    }


   
}