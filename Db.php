<?php
class Db{
    public static function getDataBaseConnection(){

        //Параметры соединения
        $params = array(
            'host' => 'localhost',
            'dbname' => 'ip_db',
            'user' => 'root',
            'password' => '',
        );

        $con = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($con, $params['user'], $params['password']);
        $db->exec("set names utf8");
        return $db;
    }


}
