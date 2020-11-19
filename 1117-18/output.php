<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: woxiaoyao
 * @Date: 2020-11-19 13:06:38
 * @LastEditTime: 2020-11-19 17:28:30
 */
$i=12;
$float=10.12;
$str='Hello';
$gender=true;
// 索引数组
$arr=[1,2,3,4,5,6];
// 关联数组
$arr2=['name'=>'woxiaoyao','age'=>28,'salary'=>5249.01];
// PHP内置类原型，是空类
$obj = new stdClass;
class Person{
    public $name='woxiaoyao';
    public $age;
    public function getName(){
        // 类中使用内部成员时，要使用$this
        return $this->name;
    }
}
$obj2=new Person;
$fo=fopen('log.txt','w');
// echo $float;
// $res=var_export($a);
// var_dump($res);

// 传值赋值
$in=$i;
$in=5;
// 下面输出12,5  两者因传值赋值，互不影响
// echo $i.'<br>',$in;   
// 引用赋值
$in2=&$i;
$in2=10;
// 下面输出10,10  两者因引用赋值，互相影响
echo $i.'<br>',$in2;

// 类型强制转换
// 第一种：使用三个函数intval()、floatval()、strval()
$float = 1.23;
$result = intval($float);
//看看结果是不是变了？
var_dump($result);
//鸭脖子为整型的5
$yabozi = 5;
$re = floatval($yabozi);
var_dump($re);
//定义整型的变量
$yabozi = 23;
$bian = strval($yabozi);
//强制变成字符串试试
var_dump($bian);
// 第二种：变量前加上()里面写上类型，将它转换后赋值给其他变量
$transfer = 12.8;
//把浮点变为整型
$jieguo = (int)$transfer;
var_dump($jieguo);
//把浮点变为布尔
$jieguo = (bool) $transfer;
var_dump($jieguo);
//把布尔变整型
$bool = true;
$jieguo = (int)$bool;
var_dump($jieguo);
//把浮点变数组
$fo = 250;
$jieguo = (array)$fo;
var_dump($jieguo);
// 第三种:settype(变量，类型) 直接改变量本身
//定义浮点变为整型
$fo = 250.18;
//settype第二个参数是int，你实验的时候要记得第二个参数要为字符串类型
settype($fo,'int');
//输出看看结果
var_dump($fo);

// 全局变量和局部变量
$age=29;
function getAge(){
    // 通过global关键字引用全局变量
    // global $age;
    // return $age;
    // 通过$GLOBALS全局变量数组访问
    return $GLOBALS['age'];
}
echo getAge();