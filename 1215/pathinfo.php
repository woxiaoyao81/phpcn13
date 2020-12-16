<?php

// 1、先测试几个变量
// var_dump(pathinfo(__FILE__));
// var_dump($_SERVER);
/**
 * 假如现在URL是http://localhost/pathinfo.php/user/show
 * SERVER_NAME是域名，如localhost
 * SERVER_PORT是端口，如80
 * REQUEST_SCHEME是协议(http或https)，如http
 * REQUEST_METHOD请求方法，如GET
 * REQUEST_URI url路径中除掉协议和域名之外部分，如/pathinfo.php/user/show
 * SCRIPT_NAME 执行脚本，如pathinfo.php
 * PATH_INFO   url中参数部分，如/user/show
 * PHP_SELF 和REQUEST_URI相同 * 
 */

namespace mvc;

// 拦截不存在的控制器类
spl_autoload_register(function($classname){
    die("<h1>不存在该页面</h1>");
});

class UserController
{
    function index()
    {
        return "<h1>Welcome to My Blog</h1>";
    }
    function show($id, $name)
    {
        return "Hello {$name}，Your ID is {$id}";
    }
    // 拦截不存在的方法
    function __call($name, $args)
    {
        return sprintf("<h1>不存在该页面</h1><span>信息:%s,参数是:%s</span>",$name,print_r($args,true));
    }
}

$pathinfo = array_values(array_filter(explode("/", $_SERVER['PATH_INFO'])));
//  var_dump($pathinfo);
// 没有参数则默认
if (empty($pathinfo)) exit(call_user_func([(new UserController), 'index']));
//  获取控制器和方法
$controller = __NAMESPACE__ . '\\' . ucfirst(array_shift($pathinfo)) . 'Controller';
$action = array_shift($pathinfo);
// 获取参数
$args=[];
for ($i = 0; $i < count($pathinfo); $i += 2) {
    if (!empty($pathinfo[$i + 1])) $args[$pathinfo[$i]] = $pathinfo[$i + 1];
}
// var_dump($args);
echo call_user_func_array([(new $controller()), $action], $args);
