<?php
class DB
{
    public static function connect()
    {

        $host = 'localhost:3333';
        $user = 'root';
        $pass = 'hants12';
        $base = 'projeto_patrimonio';

        return new PDO("mysql:host={$host};dbname={$base};charset=UTF8;", $user, $pass);
    }
}
