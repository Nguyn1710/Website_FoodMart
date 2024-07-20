<?php
class Database{
    public static function getConnect(){
        $host = "localhost";
        $db = "foodmart";
        $username = "db_admin";
        $password = "Xvn[-f2O.aq8IqoL";

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $pdo = new PDO($dsn, $username, $password);

            if ($pdo) {
                return $pdo;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit;
        }
    }
}