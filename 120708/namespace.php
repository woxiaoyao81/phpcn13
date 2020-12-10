<?php

namespace Base\School;

class Demo
{
    function getName()
    {
        echo __CLASS__, '<br>';
    }
}
function getName()
{
    echo __FUNCTION__, '<br>';
}

namespace Base\Compony;

class Demo
{
    function getName()
    {
        echo __CLASS__, '<br>';
    }
}
function getName()
{
    echo __FUNCTION__, '<br>';
}
function var_dump($arg)
{
    echo '用户自定义的var_dump:' . var_export($arg, true), '<br>';
}
// 访问本命名空间的函数或方法时可省略命名空间
getName();
(new Demo)->getName();
// 访问其它命名空间函数或方法时必须要带上命名空间，必须从根命名空间开始，即反斜杠\
\Base\School\getName();
(new \Base\School\Demo)->getName();
// 访问全局空间或匿名空间要记得加上根命名空间反斜杠\，否则若当前命名空间有相同函数或类时，优先调用本命名空间的。
var_dump([1, 2, 3, 4]); //用户定义的var_dump
\var_dump([1, 2, 3, 4]); //有全局空间反斜杠\表示调用PHP内置的var_dump


// 引入其它空间类方法:先导入文件，后use引入命名空间相当于当类或函数复制一份到本命名空间下，再使用类名访问
echo '<br>';
include_once 'extend/lib/User.php';

use Exception;
use extend\lib\User;
// use extend\lib\User as LibUser;//若引入类和本命名空间冲突时要用as定义别名
echo User::$name;
(new Demo)->getName();

// 当有多个文件时，可使用spl_autoload_register自动导入，然后再use和使用类
spl_autoload_register(function ($classname) {
    $file = __DIR__ . DIRECTORY_SEPARATOR . $classname . '.php';
    echo '正在加类文件:'.$file,'<br>';
    if (is_file($file))
        include_once $file;
    else
        echo '类文件未找到', '<br>';
});

use extend\lib\Auth;

try {
    echo Auth::$name;
} catch (Exception $e) {
    echo $e->getMessage(), '<br>';
}
