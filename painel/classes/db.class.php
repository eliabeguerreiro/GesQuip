<?php
class DB
{
    public static function connect()
    {

        $host = 'gesquip.vpshost11463.mysql.dbaas.com.br:3306';
        $user = 'gesquip';
        $pass = '';
        $base = 'gesquip';

        return new PDO("mysql:host={$host};dbname={$base};charset=UTF8;", $user, $pass);
    }
}
