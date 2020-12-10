<?php

namespace Base;
class Magic
{
     // const class=__CLASS__;//PHP从 5.5后内置定义的类常量,不能再定义，否则报错
    const name = '当前完全类名:'.__CLASS__;

    public $age = 18;
    public static $lib='test'; 
    private $desc = 20;
    protected $salary = 3000;
    static function getName(){
        return self::name;
    }
    function getSalary()
    {
        return (new self())->salary;
    }
    private function getAge()
    {
        $this->age += 5;
    }
    function __call($name,$args){
        echo "{$name}是不可访问方法";
    }
}
// 理解ClassName::class
echo Magic::name,'<br><br>';

// 2、获取对象或类相关信息的全局函数
echo '---------获取对象的成员和方法------','<br>';
echo 'get_class() => '.get_class(new Magic),'<br>';
echo 'get_object_vars() =>'.print_r(get_object_vars(new Magic),true),'<br>';
echo 'get_class_methods() =>'.print_r(get_class_methods(new Magic),true),'<br><br>';
echo '---------获取类的成员和方法------','<br>';
// 使用Magic::class获取完整类名，包括命名空间
echo 'get_class_vars() => '.print_r(get_class_vars(Magic::class),true),'<br>';
echo 'get_class_methods() =>'.print_r(get_class_methods(Magic::class),true),'<br><br>';

// 3、判断是否存在的全局函数
echo '-------判断是否存在的全局函数--------','<br>';
// function_exists();
echo 'function_exists() => '.var_export(function_exists('call_user_func'),true),'<br>';
// file_exists()和is_file();
$file=__DIR__.DIRECTORY_SEPARATOR.'test.php';//不存在文件，后面二者都返回false
$file=__DIR__.DIRECTORY_SEPARATOR.'magic.php';//存在文件,后面二者都返回true
echo 'file => '.$file,'<br>';
echo 'is_file() => '.var_export(is_file($file),true),'<br>';
echo 'file_exists() => '.var_export(file_exists($file),true),'<br>';
// method_exists();
// 使用Magic::class获取完整类名，包括命名空间
echo Magic::getName(),'<br>';
echo 'method_exists() => '.var_export(method_exists(Magic::class,'getName'),true),'<br>';
echo 'method_exists() => '.var_export(method_exists(Magic::class,'getSalary'),true),'<br>';
echo 'method_exists() => '.var_export(method_exists(new Magic,'getSalary'),true),'<br>';
echo 'method_exists() => '.var_export(method_exists(new Magic,'getAge'),true),'<br>';
// property_exists();
// 使用Magic::class获取完整类名，包括命名空间
echo 'property_exists() => '.var_export(property_exists(new Magic,'age'),true),'<br>';
echo 'property_exists() => '.var_export(property_exists(new Magic,'lib'),true),'<br>';
echo 'property_exists() => '.var_export(property_exists(new Magic,'desc'),true),'<br>';
echo 'property_exists() => '.var_export(property_exists(new Magic,'name'),true),'<br>';
echo 'property_exists() => '.var_export(property_exists(Magic::class,'age'),true),'<br>';
echo 'property_exists() => '.var_export(property_exists(Magic::class,'lib'),true),'<br>';
echo 'property_exists() => '.var_export(property_exists(Magic::class,'name'),true),'<br><br>';

// 4、全局调用的全局函数call_user_func和call_user_func_array
echo '-------判断是否存在的全局函数--------','<br>';
function increment($var)
{
    return ++$var;
}
$a = 0;
// 调用全局函数，若有命名空间则要加命名空间
echo call_user_func('Base\increment', $a),'<br>';
echo call_user_func_array('Base\increment', array($a)),'<br>';
// 调用类中方法
echo call_user_func(array(Magic::class,'getName')),'<br>';
echo call_user_func_array(array(Magic::class,'getName'),[]),'<br>';
// 不能调用未定义或不可访问的方法
echo call_user_func(array(new Magic,'getAge')),'<br>';
echo call_user_func_array(array(new Magic,'getAge'),[]),'<br>';
