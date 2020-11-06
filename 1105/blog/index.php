<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: woxiaoyao
 * @Date: 2020-11-06 08:25:44
 * @LastEditTime: 2020-11-06 18:00:13
 */
// // 跨域请求
// header('Content-Type: text/html;charset=utf-8');
// // 代表允许任何网址请求
// header('Access-Control-Allow-Origin:*');
// // 允许请求的类型
// header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE');
// // 设置是否允许发送 cookies
// header('Access-Control-Allow-Credentials: true');
// // 设置允许自定义请求头的字段
// header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');

$users = [
    ['id' => 1, 'name' => 'admin', 'email' => 'admin@php.cn'],
    ['id' => 2, 'name' => 'peter', 'email' => 'peter@php.cn'],
    ['id' => 3, 'name' => 'jack', 'email' => 'jack@php.cn'],
];

// 查询条件
$name = $_GET['name'];

// js回调
$callback = $_GET['jsonp'];

foreach ($users as $user) {
    if ($user['name'] == $name) {
        $result = $user;
        break;
    }
}

$data = json_encode($result);

// 创建一条js函数的调用语句返回
// echo "函数名(参数)";
echo "{$callback}({$data})";

