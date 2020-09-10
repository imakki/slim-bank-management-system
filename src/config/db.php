<?php
    class db{
        public function connect(){
            $host = "127.0.0.1";
            $user="root";
            $password="root";
            $db="bank";
            $port=8889;
            
            
            //connect database using php pdo wrapper 
            $pdo = new PDO("mysql:host=$host;dbname=$db;port=$port;charset=utf8", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    }
?>