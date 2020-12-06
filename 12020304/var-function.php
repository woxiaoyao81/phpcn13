<?php
// 一、变量variable
// PHP变量:局部变量、全局变量和超全局变量,相比于JS只有局部变量和外部变量(全局变量)，C++则是内部变量，外部变量(全局变量)
// PHP局部变量：函数体{}、流程控制体{}中定义的变量都是局部变量，出了{}就释放
// PHP外部变量:函数体{}外，流程控制体{}外都是全局变量，出了这个页面就释放
// 流程控制条件中定义变量是全局变量，为什么能被内部识别是因为它内置了global转换
// 在超全局变量中$GLOBALS保存有全局变量，不过它们是以RECURSION(递归)区别PHP内置定义的变量，另一个它表示PHP是递归遍历得到的，尤其是有include或require时
// 超全局变量只能是由PHP内置定义，我们无法定义PHP的超全局变量，$GLOBALS是包括所有超全局变量，另外$_GET、$_POST也独立成超变量变量，因为它们经常要使用
// $b = 12;
// $GLOBALS['b'] = 34;
// $GLOBALS['c'] = 'hello world';
// for ($i = 0; $i < 10; $i++) {
//     global $a;
//     $a += $i;
// }
// echo $i,'<br>';
// echo $a,'<br>';
// print_r($GLOBALS);

// 二、函数function
// 函数名是全局，在当前页面有效，包括include和require的页面,判断某页面是否定义某函数可通过function_exists()来判断，调用call_user_func()
// 函数有三种形式:
// 1.普通函数即有关键字function，函数名，形参和函数体；
// 2.匿名函数(闭包Closure)只有关键字function，形参和函数体；
// 3.最后一种是抽象函数，关键字是两个abstract function，有函数名和形参，没有函数体，它只能在接口Interface或抽象类中

function sum($a, $b)
{
    return $a + $b;
}

$a=$b=3;
$sum=function() use ($a,$b){
    return $a+$b;
};//不要忘记分号结尾，否则报错，此时$sum就不是普通变量，而是闭包Closure对象
var_dump(function_exists('sum'));
var_dump($sum);

// 类和变量与函数的关系:变量是实现数据的复用, 函数是实现代码的复用,类是将变量和函数作为其成员实现数据和代码的复用。
