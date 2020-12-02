<?php 
/*
 * @Descripttion: 
 * @version: 
 * @Author: woxiaoyao
 * @Date: 2020-12-01 20:01:56
 * @LastEditTime: 2020-12-01 20:16:39
 */
namespace JSPDO;

use PDO;

$config=require 'database.php';
extract($config);

$dsn=sprintf("{$type}:host={$host};dbname={$dbname}");

// 调整警告级别为ERRMODE_WARNING，可看到更多消息
// 调整输出结果为关联数组，默认是索引数组和关联数组同时输出
// 也可单独设置属性setAttribute，而getAttribute是获取属性。
try{
    $pdo=new PDO($dsn,$name,$pwd,[PDO::ATTR_ERRMODE=> PDO::ERRMODE_WARNING,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
    // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);单独设置属性
} catch (\PDOException $e){
 die('Connection Error:'.$e->getMessage());
}
