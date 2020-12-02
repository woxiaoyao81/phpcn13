<?php
namespace JSPDO;
// 引入pdo对象
require_once 'connect.php';
// 构造SQL语句
// $sql='select * from baidu_cat where true limit 0,10;';
// // 执行select操作，返回是PDOStatement对象，它保存结果集
// $res=$pdo->query($sql);
// // PDOStatement是资源对象，若不成功则为false
// if(!$res){
//    die('数据表打开不成功，原因:'.print_r($pdo->errorInfo(),true)); 
// }
// var_dump($res->fetch());
// var_dump($res->fetchAll());

// 构造增、改、删除SQL
// 全部增加时，也不能省略列名
// $sql="insert into baidu_cat (name) values('woxiaoyao');";
// $row=$pdo->exec($sql);
// echo "已经成功增加{$row}行",'<br>';
// // 修改
// $sql="update baidu_cat set name='xiaoyao' where id=2;";
// $row=$pdo->exec($sql);
// echo "已经成功修改{$row}行",'<br>';
// // 删除
// $sql="delete from baidu_cat where id=3;";
// $row=$pdo->exec($sql);
// echo "已经成功删除{$row}行",'<br>';

// quote防注入：符串添加单引号并对特殊符号进行转义
$name="' or 1=1 #";
// $sql="select * from baidu_cat where name='{$name}';";
// quote防注入
$name=$pdo->quote($name);
// 此时SQL中字符串变量一定不要再加单引号，quote已经帮我们加上了，并转义特殊字符
$sql="select * from baidu_cat where name={$name};";
$res=$pdo->query($sql);
if(!$res){
   die('数据表打开不成功，原因:'.print_r($pdo->errorInfo(),true)); 
}
var_dump($res->fetchAll());
