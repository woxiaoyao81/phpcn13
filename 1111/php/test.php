<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: woxiaoyao
 * @Date: 2020-11-14 05:52:05
 * @LastEditTime: 2020-11-15 09:11:24
 */
header('content-type:text/html;charset=utf-8');

// 获取回调名称
$callback = $_GET['jsonp'];
$id = $_GET['id'];

// 模拟接口数据
$users = [
    0=>'{"name":"朱老师", "email":"peter@php.cn"}',
    1=>'{"name":"西门老妖", "email":"xm@php.cn"}',
    2=>'{"name":"灭绝师妹", "email":"pig@php.cn"}' 
];

if (array_key_exists(($id-1), $users)) {
    $user = $users[$id-1];
}

// echo $user;

// 动态生成handle()的调用
echo $callback . '(' . $user . ')';