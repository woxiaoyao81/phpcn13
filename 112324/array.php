<?php
// 二、PHP数组相关的操作
// 1、游标访问数组：key()、current()、next()、prev()、reset()和end()
$people = array("Bill", "Steve", "Mark", "David");
reset($people);
while (current($people)) {
  echo 'key=' . key($people) . ',value=' . current($people) . '<br>';
  next($people);
}

// 2、数组和变量转换
// 关联数组
$config = ['type' => 'mysql', 'host' => 'localhost', 'dbname' => 'phpedu', 'charset' => 'utf=8'];
extract($config);
echo $type, ",{$host}", ",{$dbname}", ",{$charset}", '<br>';
// compact的参数是变量名加引号，不是变量喔
print_r(compact('type', 'host', 'dbname', 'charset'));
// $arr=array('type'=>$type,'host'=>$host,'dbname'=>$dbname,'charset'=>$charset);
echo '<hr>';
// 索引数组
// 要注意array和compact的
$arr = array($type, $host, $dbname, $charset);
print_r($arr);
echo '<hr>';
list($a, $b) = $arr;
echo $a, ",{$b}", '<br>';

// 3、array_splice实现增改删
// $arr=array('type'=>$type,'host'=>$host,'dbname'=>$dbname,'charset'=>$charset);
print_r(array_splice($arr, 2, 1, 'woxiaoyao'));
echo '<hr>';
print_r($arr);
echo '<hr>';

// 4、栈与队列
$arr = [];
array_push($arr, 10);
array_push($arr, 20, 30, 40, 50, 60);
array_pop($arr);
array_unshift($arr, 9);
array_unshift($arr, 1, 2, 3, 4, 5, 6, 7);
array_shift($arr);
print_r($arr);
echo '<hr>';

// 5、搜索键值或键名
var_dump(array_key_exists(60, $arr));
var_dump(in_array(60, $arr));
var_dump(array_search(50, $arr));
print_r(array_keys($arr));
echo '<br>';
print_r(array_values($arr));
echo '<br>';

// 6、数组合并和提取
$fname = array("Bill", "Steve", "Mark");
$age = array("60", "56", "31");
print_r(array_combine($fname, $age));
echo '<br>';
$a1 = array("a" => "red", "b" => "green");
$a2 = array("c" => "blue", "b" => "yellow");
print_r(array_merge($a1, $a2));
echo '<br>';
print_r(array_merge_recursive($a1, $a2));
echo '<br>';

$a = array(
  array(
    'id' => 5698,
    'first_name' => 'Bill',
    'last_name' => 'Gates',
  ),
  array(
    'id' => 4767,
    'first_name' => 'Steve',
    'last_name' => 'Jobs',
  ),
  array(
    'id' => 3809,
    'first_name' => 'Mark',
    'last_name' => 'Zuckerberg',
  )
);
$last_names = array_column($a, 'last_name', 'id');
print_r($last_names);
echo '<br>';

//   7、数组的遍历(迭代)操作
$a = array(10, 15, 20, 30);
echo array_reduce($a, function ($prev, $next) {
  return $prev + $next;
}, 5);
function myfunction($v1, $v2)
{
  return intval($v1) + intval($v2);
}
echo array_reduce($a, "myfunction", 5);
// 箭头闭包只能是有一个表达式，使用关键字fn,而且PHP7.4以后再支持
// echo array_reduce($a,fn($prev,$next)=>$prev+$next,5);
echo '<br>';

// 遍历
function myfunction1($value, $key, $p)
{
  echo "$key $p $value<br>";
}
$a = array("a" => "red", "b" => "green", "c" => "blue");
array_walk($a, "myfunction1", "has the value");
// 
function myfunction2(&$value, $key)
{
  $value = "yellow";
}
$a = array("a" => "red", "b" => "green", "c" => "blue");
array_walk($a, "myfunction2");
print_r($a);
echo '<br>';

// 8、排序
$arr = array('1', '10', '2', '32', '22');
sort($arr);
// 按字符串排序
sort($arr, SORT_STRING);
print_r($arr);
echo '<br>';
function my_sort($a, $b)
{
  if ($a == $b) return 0;
  return ($a < $b) ? -1 : 1;
}
$a = array(4, 2, 8, 6);
usort($a, "my_sort");
print_r($a);
echo '<br>';

$a1=array("Dog","Dog","Cat");
$a2=array("Pluto","Fido","Missy");
array_multisort($a1,$a2);
print_r($a1);
print_r($a2);

array_multisort($a1,SORT_ASC,$a2,SORT_DESC);
print_r($a1);
print_r($a2);

$a1=array(1,30,15,7,25);
$a2=array(4,30,20,41,66);
$num=array_merge($a1,$a2);
array_multisort($num,SORT_DESC,SORT_NUMERIC);
print_r($num);
