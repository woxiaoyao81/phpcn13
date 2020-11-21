<?php
// 函数是代码块复用的手段,变量是数据复用的手段

// 一、系统函数
echo mt_rand() % 101, '<br>';
echo mt_rand(10, 99), '<br>';
echo strtolower('COMPONENTS'), '<br>';
echo date('Y:m:d h:m:s', time()), '<br>';
print_r(range(1, 10, 2));
echo '<br>';

// 大段字符串的简洁语法：非常适合大段的html与php代码混编的场景
// 1、使用 <<< 做为引导符, 使用一对字符串做为标识符,结束标识符。字符串内容随意
// 2、开始标识符加双引号则类似双引号功能，但内部引用双号号不需要转义,可以解析变量和特殊字符
// 3、开始标识符加单引号则类似单引号功能，适合不需要转义特殊字符和变量解板的大段文本,如html代码
// 4、单双引号只能在开始标识符加，如果不加则默认为双引号
$str = 'Hello World';
echo <<< "HERODOC"
<h3 style="color:red">"PHP\t中文网":{$str}</p>
<h3 style="color:red">"PHP\t中文网":{$str}</p>
HERODOC;
echo <<< HELP
<h3 style="color:green">"PHP\t中文网":{$str}</p>
<h3 style="color:green">"PHP\t中文网":{$str}</p>
HELP;
echo <<< 'NOWDOC'
<h3 style="color:red">"PHP\t中文网":{$str}</p>
<h3 style="color:red">"PHP\t中文网":{$str}</p>
NOWDOC;
$content = <<< "CONTENT"
<h3>欢迎来到PHP世界<h3>
<p>{$str}</p>
<p><span>PHP是一门后端语言，占有率一直遥遥领先</span></p>
CONTENT;
echo $content;

// 二、函数返回值
/*
* 1. 函数没有返回值时,返回null
* 2. 函数只能返回单一的值,返回值的数据类型可以是任意类型()
* 3. 函数碰到return语句,立即结束程序执行,return后面的代码不会被执行
*/

function demo1()
{
    return fopen('log.txt', 'w');
    return new stdClass;
    return range(1, 10, 2);
    return true;
    return 'woxiaoyao';
    return 12;
}
var_dump(demo1());

// 4.间接返回多个值:数组、json和序列化serialize
function demo2()
{
    $a = 12;
    $str = 'woxiaoyao';
    // 数组返回多个参数
    // return array($a,$str);
    // json返回多个参数,转换json是json_encode()，还原是json_decode(),若是还原数组，第二个参数为true
    // return json_encode(array($a,$str));
    // 序列化返回多个参数,序列化是serialize()，反序列化unserialize()。其中a表示数组，s表示字符串,i为整数，a和s后面是长度+内容。
    return serialize(array($a, $str));
}
var_dump(demo2());

// 三、函数的形参和实参
// 形参是函数定义时可接受的参数，可设置默认值，此时函数只是代表某功能的代码块。若用户传递参数超过定义的参数个数时，可使用三个点开始的剩余参数来收集多余的参数为数组。剩余参数在JS和C++都有同样概念
// 实参就是用户调用函数时传递的参数，此时函数就完成某项功能。同剩余参数一样，在实参中传递数组参数时，可使用三个点开头的展开功能，将数组一次性传给函数。

function calc(string $opt, ...$args)
{
    $opts = ['+', '-', '*', '/', '%'];
    // 判断运算符是否合法
    if (!in_array($opt, $opts)) {
        return '操作运算符只能是+、-、*、/和%';
    }
    // 将数组第一个值给结果
    $res = array_shift($args);
    // 按运算符循环处理
    foreach ($args as $arg) :
        $res = eval("return {$res} {$opt} {$arg};");
    endforeach;
    return $res;
}
$vals = range(1, 5);
// 实参展开运算符一次性赋值
echo calc('*', ...$vals), '<br>';

// 四、函数的重载：在C++和Java中有都函数重载的，那PHP也有吗?直接是没有的，可以使用func_get_args()和func_num_args()
// 注意点:重载的函数要用return返回，记得真实函数一定要return返回，否则无结果，不知道返回到什么地方去了。
function f1($a)
{
    return "重载函数有一个参数:a={$a}";
}
function f2($a, $b)
{
    return  "重载函数有两个参数:a={$a}和b={$b}";
}
function rewrite()
{
    $args = func_get_args();
    $num = func_num_args();
    switch ($num):
        case 1:
            return f1($args[0]);
            break;
        case 2:
            return f2($args[0], $args[1]);
            break;
        default:
            return '未定义函数';
    endswitch;
}
echo rewrite(1, 2),'<br>';

// 五、回调函数
// 作为参数传递给父函数~,匿名函数,闭包
// 作用1:调用者对数据处理的需求未知，所以提供回调函数由调用者决定如何处理数据，父函数只实现共同功能，如遍历。类似如filte过滤器中回调函数允许定义自己的过滤规则，uniapp开发中组件的插槽slot允许用户自定义布局
// 作用2:为完成时间不定的任务提供异步实现，通过完成时触发的事件来提醒父函数，从而父函数获取结果。如远程获取数据、侦听用户行为等。

// 作用1:
$arr = range(1, 10);
// 函数通过回调允许用户定义数据处理方式,它本身只提供遍历功能
$newArr=array_map(function ($item) {
    return $item * 2 + 1;
}, $arr);
print_r($newArr);
print_r($arr);
echo '<br>';
$arr1=array_filter($arr,function($item){
    return $item%2==0;
});
print_r(array_values($arr1));
print_r(array_keys($arr1));
echo '<br>';


// 六、call_user_func和call_user_func_array

// function nowamagic($a,$b)   
// {   
//     echo $a;   
//     echo $b;   
// }   
// call_user_func('nowamagic', "111","222"); 
// class a {   
//     function b($c)   
//     {   
//         echo $c;   
//     }   
// }   
// call_user_func(array("a", "b"),"111");  
// function a($b, $c)   
// {   
//     echo $b;   
//     echo $c;   
// }   
// call_user_func_array('a', array("111", "222"));  