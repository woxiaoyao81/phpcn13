<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: woxiaoyao
 * @Date: 2020-11-19 18:21:57
 * @LastEditTime: 2020-11-19 18:58:45
 */

// $filters=filter_list();
// foreach($filters as $filter){
// echo $filter.':'.filter_id($filter).'<br>';
// }

// 一、过滤变量
var_dump(filter_var('bob@example.com', FILTER_VALIDATE_EMAIL));
echo '<hr>';
var_dump(filter_var('http://example.com', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED));
echo '<hr>';
$age = '15';
$min = 18;
$max = 35;
// 使用过滤参数
$options = array("options" => array("min_range" => $min, "max_range" => $max));
var_dump(filter_var($age, 257, $options));
echo '<hr>';
$arr=[123.12,45.21,'woxiaoyao'];
var_dump(filter_var_array($arr,FILTER_VALIDATE_FLOAT));
echo '<hr>';


// 二、过滤输入
$options = ["options"=>["min_range"=>1]];
var_dump(filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT,$options));
echo '<hr>';
// 多个值过滤
$args = [
    "username" => FILTER_SANITIZE_STRING,
    "age" =>FILTER_VALIDATE_INT,
    "blog_url" =>FILTER_VALIDATE_URL,
    "ip"=>FILTER_VALIDATE_IP
];
var_dump(filter_input_array(INPUT_GET,$args));
echo '<hr>';


// 三、过滤回调
// 自定义的函数把所有 "_" 转换为空格
function convertSpace($string)
{
return str_replace("_", " ", $string);
}
$string = "Peter_is_a_great_guy!";
echo filter_var($string, FILTER_CALLBACK, array("options"=>"convertSpace"));