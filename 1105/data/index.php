<?php

$users = [
    ['id' => 1, 'name' => 'admin', 'email' => 'admin@php.cn'],
    ['id' => 2, 'name' => 'peter', 'email' => 'peter@php.cn'],
    ['id' => 3, 'name' => 'jack', 'email' => 'jack@php.cn'],
];

// 查询条件
$name = $_GET['name'];
foreach ($users as $user) {
    if ($user['name'] == $name) {
        $result = $user;
        break;
    }
}

// echo $result;
echo json_encode($result);