# 常量

## 1. 特征

| 序号 | 特征                         |
| ---- | ---------------------------- |
| 1    | 常量前面没有美元符号`$`      |
| 2    | 常量创建时必须初始化         |
| 3    | 常量禁止更新和删除           |
| 4    | 常量不受作用域限制           |
| 5    | 推荐使用大写字母加下划线命名 |

---

## 2. 函数/关键字

| 序号 | 定义方式                  | 描述             |
| ---- | ------------------------- | ---------------- |
| 1    | `get_defined_constants()` | 查看系统所有常量 |
| 2    | `defined()`               | 检测常量是否存在 |
| 3    | `define()`                | 创建常量         |
| 4    | `const` 关键字            | 创建常量         |
| 5    | `constant()`              | 获取常量值       |

- `get_defined_constants(true)`: 常量分组打印,自定义常量在`user`分组
- `defined()`: 返回布尔值

```php
// 获取系统定义的所有常量
print_r(get_defined_constants(true));
// 仅查看用户自定义的常量
print_r(get_defined_constants(true)['user']);
```

---

## 3. 创建常量

| 序号 | 定义方式       | 区别                                                 |
| ---- | -------------- | ---------------------------------------------------- |
| 1    | `define()`     | 除了不能创建类常量, 可以在程序的任何地方定义         |
| 2    | `const` 关键字 | 必须全局定义,不能用在函数和流程控制中,允许创建类常量 |

- 常量值: `int`, `float`, `string`, `boolean`,`null`, `array`(php7+)
- `define($name, true)`: 允许忽略常量名大小写
- `const`在编译阶段处理, `define()`在运行阶段处理,所以`const`必须定义在全局才有效
- `class`类声明在编译时处理,且并不会创建作用域,当然也是全局中, 所以`const`可以用

---

## 4. 获取常量

| 序号 | 函数/关键字  | 区别                   |
| ---- | ------------ | ---------------------- |
| 1    | `echo`       | 通常使用已知的常量名   |
| 2    | `constant()` | 常量名不确定或在变量中 |

示例代码: `demo12.php`

```php

# 常量

// define():函数定义常量
define('LECTURE', '朱老师');
// const关键字: 定义常量
const COURSE = 'PHP';

// 常量不受作用域限制
function test1()
{
    echo LECTURE . '教: ' . COURSE . '<br>';
    // define()可以用在函数中,流程控制中,const不可以
    define('SEX', '男');
    echo SEX, '<br>';
    // const不能用在函数中
    // const AGE = 30;
    // echo AGE;
}

test1();
echo  '<hr>';


if (true) {
    // define()允许用在流程控制中
    define('EMAIL', 'admin@php.cn');
    echo EMAIL;
    // const 不能用在流程控制中
    // const B = 'hello world';
    // echo B;
}

echo '<hr>';

// const可以创建类常量,define()不行
class Demo
{
    const HELLO = 'php.cn';
    // define('HI', 'Peter Zhu');
}

echo Demo::HELLO, '<br>';

// 检测常量是否存在?
var_dump(defined('EMAIL'));

echo '<hr>';

// 获取系统定义的所有常量
// echo '<pre>' . print_r(get_defined_constants(), true) . '</pre>';
// 根据键名分组查看
// echo '<pre>' . print_r(get_defined_constants(true), true) . '</pre>';
// 仅查看用户自定义的常量
echo '<pre>' . print_r(get_defined_constants(true)['user'], true) . '</pre>';

// 常量的值允许是标量(单值)和数组
// 标量: 整数,浮点数, 字符串, 布尔,前面已有介绍
// 从php7.0+开始, 常量也支持数组类型了
const DB_LINKS = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
];

echo '<pre>' . print_r(DB_LINKS, true) . '</pre>';

echo '<hr>';

// 除了用echo 打印常量外, 还可以用constant()函数
// constant参数是字符串,字符串的内容是变量名,并且只返回的值,必须用echo / print_r等打印
echo constant('LECTURE') . '<br>';
// 你可能会认为这样做多此一举,因为完全可以直接用echo, 事实也的确如此
echo LECTURE . '<br>';

// 但是,当我们不知道常量名, 或者常量名在变量中时, 这个函数就非常有用了
// 常量名在变量中
$constName = 'EMAIL';
// 只能输出常量名,不能获取到常量值
echo $constName, '<br>';
// constant(): 可以将常量名从变量中解析来正确读到
echo constant($constName), '<br>';
// 空字符串也能做常量名, 尽管没啥意义,但却是合法的(我想应该没人会这样做)
define('', "其实我也是常量");
// 空字符串不是一个有效的php标识符,所以不能使用const来定义这个常量
// 下面指令肯定获取不到常量值
echo '', '<br>';
// 而constant()函数仍然可以读到常量, 不知道这是不是一个Bug?
echo constant('');
```

---

## 5. 预定义常量

预定义常量非常多,有许多与具体扩展相关,如 `PDO`, 这里仅列出系统级常用的:

| 序号 | 预定义常量             | 描述                                      |
| ---- | ---------------------- | ----------------------------------------- |
| 1    | `PHP_VERSION`          | PHP 版本                                  |
| 2    | `PHP_MAXPATHLEN`       | PHP 路径最大长度:1024                     |
| 3    | `PHP_OS_FAMILY`        | 操作系统:Windows/Darwin/Linux             |
| 4    | `PHP_SAPI`             | web 服务器与 php 之间接口: apache2handler |
| 5    | `PHP_EOL`              | 行尾结束符                                |
| 6    | `PHP_INT_MAX`          | 最大整数: `9223372036854775807`           |
| 7    | `PHP_INT_MIN`          | 最小整数: `-9223372036854775808`          |
| 8    | `PHP_INT_SIZE`         | 整数宽度: `8`                             |
| 9    | `PHP_FLOAT_MAX`        | 最大浮点数:`1.7976931348623E+308`         |
| 10   | `PHP_FLOAT_MIN`        | 整小浮点数: `2.2250738585072E-308`        |
| 11   | `DEFAULT_INCLUDE_PATH` | 默认 PHP 命令路径                         |
| 12   | `PHP_EXTENSION_DIR`    | 默认 PHP 扩展路径                         |
| 13   | `E_ERROR`              | 运行时错误: 致命中断                      |
| 14   | `E_PARSE`              | 语法解析错误: 致命中断                    |
| 15   | `E_NOTICE`             | 运行时提示: 不中断                        |
| 16   | `E_WARNING`            | 运行时警告: 不中断                        |
| 17   | `E_ALL`                | 所有级别错误(除`E_STRICT`)                |
| 18   | `E_STRICT`             | 更加严格的错误处理机制,高于`E_ALL`        |
| 19   | `TRUE`                 | 布尔真                                    |
| 20   | `FALSE`                | 布尔假                                    |
| 21   | `NULL`                 | 空                                        |
| 22   | `DIRECTORY_SEPARATOR`  | 目录分隔符                                |

更多预定义常量:<https://www.php.net/manual/zh/reserved.constants.php>

---

## 6. 魔术常量

- 魔术常量也属于"预定义常量", 比较特殊所有单独列出
- 所谓"魔术", 是指常量的值, 会随它们在代码中的位置改变而改变
- 魔术常量不区分大小写, 但是推荐全部大写

| 序号 | 魔术常量        | 描述                   |
| ---- | --------------- | ---------------------- |
| 1    | `__LINE__`      | 文件中的当前行号       |
| 2    | `__FILE__`      | 文件的完整路径和文件名 |
| 3    | `__DIR__`       | 文件所在目录           |
| 4    | `__FUNCTION__`  | 当前的函数名称         |
| 5    | `__CLASS__`     | 当前类名称             |
| 6    | `__TRAIT__`     | 当前`Trait`名称        |
| 7    | `__METHOD__`    | 当前类方法名称         |
| 8    | `__NAMESPACE__` | 当前命名空间名称       |

示例代码: `demo13.php`

```php

# 预定义常量

echo '版本号: ' . PHP_VERSION . '<br>';
echo '操作系统: ' . PHP_OS_FAMILY . '<br>';
echo '最大整数: ' . PHP_INT_MAX . '<br>';
echo '最大浮点数: ' . PHP_FLOAT_MAX . '<br>';
echo '目录分隔符: ' . DIRECTORY_SEPARATOR . '<hr>';

// 魔术常量

echo '当前行号: ' . __LINE__ . '<br>';
echo '当前文件: ' . __FILE__ . '<br>';
echo '当前目录: ' . __DIR__ . '<br>';
// 更多魔术常量在类与对象中再详细介绍
```

---

## 7. 常量命名空间

- 当使用的第三方组件(类库)中存在也当前脚本命名冲突的常量名时,可以用命名空间解决
- 命名空间允许将同名的标识符,定义在不同的空间中,类似同名文件可存放在不同目录下
- 命名空间使用关键字`namespace`声明, 必须放在脚本的首行,且前面不允许有任何输出

```php
# 常量的命名空间

// 报重复声明错误
// const APP_PATH = __DIR__ . '/public/';
// const APP_PATH = __DIR__ . '/home/';

// 将同名常量定义在不同的空间中, 则不会报错
namespace ns1 {
    const APP_PATH = __DIR__ . '/public/';
}

namespace ns2 {
    const APP_PATH = __DIR__ . '/home/';
}

// 全局空间,不需要空间名
namespace {
    // 访问命名空间中的常量, 必须带上空间名称
    echo \ns1\APP_PATH . '<br>';
    echo \ns2\APP_PATH . '<br>';
}
```
