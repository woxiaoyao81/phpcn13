<?php
require_once 'autoload.php';

use WOXIAOYAO\Db;

$config = [
    'dsn' => 'mysql:host=localhost;dbname=test',
    'username' => 'root',
    'password' => 'root'
];
$obj = new Db($config);
// for($i=21;$i<80;$i++)
// echo "成功插入".$obj->table('user')->insert(['name'=>'xiaoyao'.($i+1),'pwd'=>md5('123456')])."条记录",'<br>';

//分页获取数据
$num = 10;
$res = $obj->table('user')->field('count(id) as total')->select();
$total = intval($res[0]['total']);
$pages = ceil($total / $num);
$page = $_GET['p'] ?? 1;
$offset = ($page - 1) * $num;
$users = $obj->table('user')->limit("{$offset},{$num}")->select();

// 改进的导航栏
$startPage = 1;
// 显示页码数最好为奇数
$showPage = 5;
if (($page - ceil(($showPage - 1) / 2)) > $startPage)
    $startPage = $page - ceil(($showPage - 1) / 2);
