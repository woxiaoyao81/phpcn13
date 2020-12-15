<?php

class Model{
    function getData(){
        $dsn="mysql:host=localhost;dbname=test;charset=UTF8";
        try{
            $pdo=new PDO($dsn,'root','root');
            $sql="SELECT * from user";
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo '数据库连接错误:'.$e->getMessage();
            exit();
        }
    }
}
