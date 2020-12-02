<?php

include_once 'connect.php';

// PDO预处理语句防注入
$sql="select * from baidu_cat where name=?;";
$res=$pdo->prepare($sql);
// 第一种方式:bindParam,第一个参数表示第几个?,从1开始,后面就是绑定变量
// $res->bindParam(1,$name);
// $name="' or 1=1 #";
// $res->execute();
// 第二种方式1:将要传的值先组成数组,一次性传给execute
// $name="' or 1=1 #";
// $arr=array($name);
// $res->execute($arr);
// 第二种方式2:直接在execute中用数组接受每个值
$res->execute(array("' or 1=1 #"));
if(!$res){
   die('数据表打开不成功，原因:'.print_r($res->errorInfo(),true)); 
}
var_dump($res->fetchAll());
