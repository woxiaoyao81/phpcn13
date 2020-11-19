# php 变量

[toc]

## 1. 变量是什么

| 概念               | 描述                                                                |
| ------------------ | ------------------------------------------------------------------- |
| 临时存储数据的空间 | 并不所有数据都需要保存到文件中,对于只用于当前程序的数据用变量更合适 |
| 数据复用的手段     | 将程序需要反复调用的数据,保存到一个变量中, 可以实现数据复用         |

---

## 2. 命名规范

| 序号 | 规则       | 描述                                                                       |
| ---- | ---------- | -------------------------------------------------------------------------- |
| 1    | 语法       | `$ + 标识符` (必须以`$`做为变量标志)                                       |
| 2    | 标识符     | `[a-z][A-Z][0-9]_` 只允许使用大小写英文字母,数字或下划线, 且不能以数字开始 |
| 3    | 大小写敏感 | 严格区分大小写: `$name`和 `$Name`是完全不同的变量                          |

示例代码: `demo3.php`

```php
# 变量命名

$username = 'admin';
$userName = 'peter';

// 区分大小写
echo $username, '<br>', $userName, '<hr>';

// 无效变量名
// 没有使用$开头
// Hello = 'php';
// 标识符以数字开始
// $123aaa = 100;
// 标识符使用了特殊字符
// $user@id = 20;

// 有意义但不推荐, 如中文变量名
$我的邮箱 = 'peter@php.cn';
echo $我的邮箱;

// 无意义变量名
$aaa = 'php.cn';
$_ = 123;
$_123 = 888;
// 变量要做到望名生义, 一个有意义的变量名,可以极大提升代码的可读性和可维护性
```

> 推荐一个变量命名网站,告别命名恐惧症:<https://unbug.github.io/codelf/>

---

## 3. 创建方式

php 是动态语言,所以它的类型,值和变量名都是动态的

| 序号 | 名称       | 描述                                                  |
| ---- | ---------- | ----------------------------------------------------- |
| 1    | 弱类型     | 变量的类型,由它的当前值决定                           |
| 2    | 变量传递   | 变量的值来自另一个变量时,有"值传递与引用传递"二种方式 |
| 3    | 动态变量名 | 也叫"可变变量", 即变量标识符可以来自另一个变量的值    |

### 3.1 弱类型

- php 是**弱类型**语言, 它的变量类型,由赋给它的**值**决定
- 因此, php 变量也不需要使用前进行声明

示例代码: `demo4.php`

```php
# php变量是弱类型

$var = 100;
var_dump($var);
echo '<br>';
$var = 'Hello World';
var_dump($var);

/*
int(100)
string(11) "Hello World"
*/
```

### 3.2 值传递与引用传递

将变量赋值给另一个变量时,有**值传递与引用传递**二种方式

| 序号 | 传递方式 | 描述                                    |
| ---- | -------- | --------------------------------------- |
| 1    | 值传递   | 将原变量的副本(_变量值_)复制到新变量中  |
| 2    | 引用传递 | 将原变量内存访问地址`&引用`赋值给新变量 |

> 变量的值保存在"栈"中, 引用地址保存在"堆"中, 想深入了解请学习数据结构知识

示例代码: `demo5.php`

```php
# 值传递与引用传递

// 1. 值传递
$price1 = 99;
// 将price1的值,传递给变量price2
$price2 = $price1;

// 更新price2
$price2 = 199;

// 查看price1当前值:99
echo 'price1 = ' . $price1;

echo '<hr>';

// 2. 引用传递
$price1 = 99;
// 将price1的引用(可理解为地址),传递给变量price2
// 注意, 在变量price1前添加一个&:地址引用符
$price2 = &$price1;

// 更新price2
$price2 = 199;

// 查看price1当前值: 199
echo 'price1 = ' . $price1;

// 此时,price1已经随price2同步更新为199
```

### 3.3 可变变量

- 可变变量: 是指变量的标识符可以动态的改变,即变量标识符可以来自另一个变量的值
- 应用场景: 需要通过动态改变变量来处理不同需求的时候,例如图像处理,请求处理时

示例代码: `demo6.php`

```php
?php
# 可变变量

$var = 'email';
$$var = 'admin@php.cn';
// 等价于
// $email = 'admin@php.cn';

echo $email;
```

---

## 4. 检测与删除

| 序号 | 函数        | 描述                                   |
| ---- | ----------- | -------------------------------------- |
| 1    | `isset()`   | 检测变量是否存在且值非`null`           |
| 2    | `unset()`   | 删除变量,无返回值                      |
| 3    | `empty()`   | 是否为空(`""/0/'0'/null/false/[]/\$a`) |
| 4    | `is_null()` | `NULL`: 赋值为`null`/未赋值/`unset()`  |

```php
error_reporting(E_ALL);
// $username 未定义, 直接输出会报钷
echo $username;
// isset($var): 如果变量$username存在且不为null,则输出它,此时不再报错
if (isset($username)) echo $username . '<br>';

$username = 'peter zhu';
echo $username, '<br>';
// 销毁/删除变量$username, 无返回值
unset($username);
// 报错:变量未定义
echo $username;
// 如果定义变量而没有初始化/赋值
$email;
// NULL
var_dump($email);
var_dump(is_null($email));
// empty(): 判断变量是否是空值,null只是它的子集之一,应用范围更广泛
$var = '';
var_dump(empty($var));  // true
var_dump(is_null($var)); // false
// 所以,检测表单值是否为空, 应该用empty()
```

## 5. 数据类型

变量的访问方式,受以下条件的限制

| 序号 | 名称       | 描述                                         |
| ---- | ---------- | -------------------------------------------- |
| 1    | 数据类型   | 主要有基本类型, 复用类型,特殊类型            |
| 2    | 作用域     | 变量的有效范围,即可见性,查询变量的工具       |
| 3    | 生命周期\* | 变量从创建到注销的全过程(程序结束会自动注销) |

- 确定了数据类型, 才可以确定数据的 "取值范围" 与 "操作方式",所以非常重要
- 变量数据类型由值决定, 值的数据类型有三类:

### 5.1 基本类型

> 基本类型: 是构成复合类型的基本数据单元

| 序号 | 类型   | 标识符    | 检测函数      | 举例               |
| ---- | ------ | --------- | ------------- | ------------------ |
| 1    | 整数   | `integer` | `is_int()`    | `150`, `999`       |
| 2    | 浮点数 | `float`   | `is_float()`  | `3.14`, `.315`     |
| 2    | 字符   | `string`  | `is_string()` | `'php'`, `"email"` |
| 4    | 布尔   | `boolean` | `is_bool()`   | `true`, `false`    |

### 5.2 复合类型

| 序号 | 类型 | 标识符   | 检测函数      | 举例             |
| ---- | ---- | -------- | ------------- | ---------------- |
| 1    | 对象 | `object` | `is_object()` | `new stdClass()` |
| 2    | 数组 | `array`  | `is_array()`  | `$arr = [1,2,3]` |

### 5.3 特殊类型

| 序号 | 类型 | 标识符     | 检测函数        | 举例              |
| ---- | ---- | ---------- | --------------- | ----------------- |
| 1    | 空   | `null`     | `is_object()`   | `new stdClass()`  |
| 2    | 资源 | `resource` | `is_resource()` | `$f = fopen(...)` |

示例代码: `demo7.php`

```php
<?php
# 变量类型

// 基本类型
$name = '手机';
$price = 3890;
$is5G = true;
echo $name . '价格: ' . $price . ', 是否5G? ' . ($is5G ? '是' : '否') . '<br>';

// 复合类型
$obj = new stdClass;
$obj->email = 'admin@php.cn';
echo $obj->email, '<br>';

$arr = ['电脑', 8000, 'huawei'];
// print_r($arr);
echo '<pre>' . print_r($arr, true) . '</pre>';

// 特殊类型
$num = null;
var_dump($num);
$f = fopen('demo6.php', 'r');
var_dump($f);
// gettype(): 返回类型字符串
echo gettype($f);
```

### 5.4 类型查询

- 类型检测函数,如`is_int()`返回的都是一个布尔值
- `gettype()`: 返回类型的字符串表示

---

## 6 类型转换

### 6.1 自动转换

- 自动转换: 表达式根据**操作符**, 将操作数转为一致的数据类型后再进行运算
- 自动转换, 通常只发生在 **基本类型** 参与的**算术或字符串**运算中

| 序号 | 类型      | 转换规则                       |
| ---- | --------- | ------------------------------ |
| 1    | `null`    | `null => 0`                    |
| 2    | `boolean` | `true => 1`, `false => 0`      |
| 3    | `string`  | `123abc => 123`, `abc123 => 0` |
| 4    | `integer` | `int => float`                 |

### 6.2 强制转换

- 强制转换分为: **临时转换** 和 **永久转换** 二种
- 临时转换, 可使用**类型提示符**,或者**类型函数**实现

使用**类型提示符**:

| 序号 | 类型       | 转换规则   |
| ---- | ---------- | ---------- |
| 1    | `(int)`    | 转为整数   |
| 2    | `(float)`  | 转为浮点数 |
| 3    | `(string)` | 转为字符串 |
| 4    | `(array)`  | 转为数组   |
| 5    | `(object)` | 转为对象   |

使用**类型函数**:

| 序号 | 类型         | 转换规则   |
| ---- | ------------ | ---------- |
| 1    | `intval()`   | 转为整数   |
| 2    | `floatval()` | 转为浮点数 |
| 3    | `strval()`   | 转为字符串 |
| 4    | `boolval()`  | 转为布尔   |

- 永久转换: 使用函数`settype($var , $type)`

示例代码: `demo8.php`

```php
<?php
# 变量类型转换

// 自动转换

$a = null;
$b = true;
$c = false;
$d = '5g';
$e = 'php';
$f = 15;

echo $a + 10, '<br>';
echo $b + 10, '<br>';
// 字符串转数值型会有警告,但代码仍会执行, 推荐使用强制转换
echo $d + 10, '<br>';
echo $e + 10, '<br>';
// 整数15转为字符串'15'
echo $e . $f;

echo '<hr>';

// 强制转换

// 转换提示符: (int),(sgring)...
// (int)将$d强制转为整数,不再有警告信息
echo (int) $d + 10, '<br>';
// intval()转整数
echo intval($d) + 18, '<br>';
// strval($f)转字符串
echo strval($f) . ' hello', '<br>';

// 以上通过提示符和函数完成的强制转换,并不改变变量原始类型
// $f 依然是整数类型:integer
echo gettype($f), '<br>';

// settype()可将变量类型永久转换
settype($f, 'string');
// $f 永久的成为字符串类型
echo gettype($f), '<br>';
```

---

## 7. 作用域

- 变量作用域,也叫"变量范围", 即定义变量时的上下文环境
- 变量作用域,通俗的说,就是变量的生效范围
- 一个变量必定属于一个作用域, 这个作用域也包括了当前作用域中引入其它文件
- 也有不受作用域限制的变量,例如超全局变量, 在程序中任何地方都是有定义的
- 函数作用域: php 中只有函数可以创建作用域, 函数之外的代码全部在全局空间中

| 序号 | 作用域     | 描述                             |
| ---- | ---------- | -------------------------------- |
| 1    | 函数作用域 | 使用`function`关键字创建的作用域 |
| 2    | 全局作用域 | 函数之外的变量生效范围           |

- php 中没有**块作用域**的概念, 这与其它编程语言不同, 请留意
- 根据作用域不同, 变量可以分为三类:

| 序号 | 变量类型   | 描述                              |
| ---- | ---------- | --------------------------------- |
| 1    | 私有变量   | 函数中定义的变量                  |
| 2    | 全局变量   | 函数之外定义的变量                |
| 3    | 超全局变量 | 也叫预定义变量,访问不受作用域限制 |

- 超全局变量,也叫**超全局数组**,随系统加载,因此在所有脚本中均有定义,全局和函数中都可以访问

| 序号 | 变量名      | 描述                                                    |
| ---- | ----------- | ------------------------------------------------------- |
| 1    | `$GLOBALS`  | 引用全局作用域中可用的全部变量                          |
| 2    | `$_SERVER`  | 服务器和执行环境信息                                    |
| 3    | `$_GET`     | HTTP GET 请求:通过 URL 参数传递给当前脚本的变量的数组   |
| 4    | `$_POST`    | HTTP POST 请求: 将变量以关联数组形式传入当前脚本        |
| 5    | `$_FILES`   | HTTP 文件上传变量,保存着上传文件的全部信息              |
| 6    | `$_COOKIE`  | 通过 HTTP Cookies 方式传递给当前脚本的变量的数组        |
| 7    | `$_SESSION` | 当前脚本可用 SESSION 变量的数组                         |
| 8    | `$_REQUEST` | 默认情况下包含了 `$_GET`，`$_POST` 和 `$_COOKIE` 的数组 |
| 9    | `$_ENV`     | 通过环境方式传递给当前脚本的变量的数组                  |

示例代码: `demo9.php`

```php
# 变量作用域

// 全局作用域: 默认
$siteName = 'php中文网';

// 函数作用域
function getInfo(): string
{
    // 函数中不能直接访问全局变量
    // $private = $siteName;

    // 方法1: global 引入
    global $siteName;
    $local = $siteName;

    // 访问2: 使用超全局变量: $GLOBALS
    $local = $GLOBALS['siteName'];

    // 函数中访问超全局变量
    echo $_SERVER['SCRIPT_NAME'] . '<br>';

    return $local;
}

// 全局中访问函数私有变量: 未定义错误
echo getInfo(), '<br>';

// 全局中访问超全局变量
echo $_SERVER['SCRIPT_NAME'];

/*
/demo9.php
php中文网
/demo9.php
*/
```

---

## 8. 静态变量

### 8.1 基本常识

- 定义在函数中的静态变量使用`static`修饰,并且与函数作用域绑定
- 静态变量定义时必须初始化,且只能初始化一次,默认为`0`
- 当程序执行离开函数作用域后,静态变量的值不丢失
- 静态变量的值,可以在函数的多次调用中保持不变,即可带入下次调用中
- 函数中静态变量遵循私有变量约束, 全局不可访问

### 8.2 应用场景

- 当多次调用同一函数,且要求每次调用之间共享或保留某些变量的时候
- 尽管全局变量也可以办到,但没必要, 采用局部静态变量更合适

示例代码: `demo10.php`

```php

# 静态变量

namespace ns1;

function test1(): float
{
    // $sum: 局部动态变量,每次调用都会初始化,无法在多次调用中保持不变
    $sum = 0;
    $sum = $sum + 1;
    return  $sum;
}

echo test1(), '<br>';
echo test1(), '<br>';
echo test1(), '<br>';

echo '<hr>';

namespace ns2;

// 全局变量
$sum = 0;
function test1(): float
{
    // 通过全局变量,将每次的调用结果保存到全局中
    global $sum;
    $sum = $sum + 1;
    return  $sum;
}

echo test1(), '<br>';
echo test1(), '<br>';
echo test1(), '<br>';

echo '<hr>';

namespace ns3;


function test1(): float
{
    // 静态变量: 仅第一次调用时初始化,以后调用可保持原值
    // 静态变量: 可简单理解为仅在函数中使用的"伪全局变量"
    // 可以实现在函数的多次调用中的数据共享
    static $sum = 0;
    $sum = $sum + 1;
    return  $sum;
}

echo test1(), '<br>';
echo test1(), '<br>';
echo test1(), '<br>';
```

---

## 9. 变量过滤器

- PHP 过滤器用于验证和过滤来自非安全来源的外部数据
- 外部数据来源:

| 序号 | 数据来源       | 描述                   |
| ---- | -------------- | ---------------------- |
| 1    | 表单           | 来自表音的用户输入数据 |
| 2    | Cookies        | 来自浏览器中的 cookie  |
| 3    | 服务器变量     | 防止伪装的合法访问     |
| 4    | Web 服务数据   | Web 请求的数据         |
| 5    | 数据库查询结果 | 数据表中的数据并不可信 |

- 常用的过滤器函数

| 序号 | 函数                   | 描述                     |
| ---- | ---------------------- | ------------------------ |
| 1    | `filter_list()`        |                          |
| 2    | `filter_id()`          |                          |
| 3    | `filter_var()`         | 过滤单个变量             |
| 4    | `filter_var_array()`   | 过滤多个变量             |
| 5    | `filter_has_var()`     | 检测是否存在某个外部变量 |
| 6    | `filter_input()`       | 过滤单个外部变量         |
| 7    | `filter_input_array()` | 过滤多个外部变量         |

- 外部变量类型: `INPUT_GET`, `INPUT_POST`, `INPUT_COOKIE`, `INPUT_SERVER`, `INPUT_ENV`
- 过滤器主要分为二类: **验证过滤器**, **清理过滤器**

### 9.1 验证过滤器常量

- 验证过滤器: 又叫"验证器", 主要用于数据的类型和格式验证

| 序号 | 过滤器函数                | 描述          |
| ---- | ------------------------- | ------------- |
| 1    | `FILTER_VALIDATE_INT`     | 验证整数      |
| 2    | `FILTER_VALIDATE_FLOAT`   | 浮点点验证    |
| 3    | `FILTER_VALIDATE_BOOLEAN` | 验证布尔项    |
| 4    | `FILTER_VALIDATE_EMAIL`   | 验证邮箱      |
| 5    | `FILTER_VALIDATE_URL`     | 验证 URL 地址 |
| 6    | `FILTER_VALIDATE_IP`      | 验证 IP 地址  |
| 7    | `FILTER_VALIDATE_REGEXP`  | 正则验证      |

- `FILTER_VALIDATE_BOOLEAN`: 布尔选项的返回值类型

| 序号 | 返回值  | 描述                          |
| ---- | ------- | ----------------------------- |
| 1    | `true`  | "1", "true", "on" 和 "yes"    |
| 2    | `false` | "0", "false", "off", "no", "" |
| 3    | `null`  | 除以上情形外                  |

### 9.2 清理过滤器常量

- 清理过滤器: 去掉非法字符,仅保留指定内容

| 序号 | 过滤器函数                      | 描述                                         |
| ---- | ------------------------------- | -------------------------------------------- |
| 1    | `FILTER_UNSAFE_RAW`             | 保持原始数据                                 |
| 2    | `FILTER CALLBACK`               | 自定义函数过滤数据                           |
| 3    | `FILTER_SANITIZE_STRING`        | 去除标签以及特殊字符:`strip_tags()`          |
| 4    | `FILTER_SANITIZE_STRIPPED`      | "string" 过滤器别名                          |
| 5    | `FILTER_SANITIZE_ENCODED`       | URL-encode 字符串,去除或编码特殊字符         |
| 6    | `FILTER_SANITIZE_SPECIAL_CHARS` | HTML 转义字符, 等价于 `htmlspecialchars()`   |
| 7    | `FILTER_SANITIZE_EMAIL`         | 仅保留邮箱地址的合法字符                     |
| 8    | `FILTER_SANITIZE_URL`           | 仅保留合法的 URL, 必须从协议开始`http/https` |
| 9    | `FILTER_SANITIZE_NUMBER_INT`    | 仅保留合法的数字和正负号`+-`                 |
| 10   | `FILTER_SANITIZE_NUMBER_FLOAT`  | 仅保留合法的数字和正负号`+-` 以及指数 `.,eE` |
| 11   | `FILTER_SANITIZE_MAGIC_QUOTES`  | 等价于函数: `addslashes()`                   |

### 9.3 选项与标志

- 可以对过滤器设置选项和标志, 对数据进行更加精准的过滤处理
- 选项与标志使用数组键名表示: `'options'=>[...], 'flags'=>...`(复数)
- 举例:

```php
filter_var($int, FILTER_VALIDATE_INT, ['options'=>['min_range'=>10,'max_range'=>80]]);
// FILTER_REQUIRE_SCALAR: 必须是标量(即单值数据,如字符串,数值,布尔, 不能是数组或对象)
filter_var($data, FILTER_VALIDATE_EMAIL, ['flags'=>FILTER_REQUIRE_SCALAR]);
```

示例代码: `demo11.php`

```php
# 变量过滤器

// filter_list(): 查看支持的所有过滤器
// filter_id(): 返回过滤器常量对应的ID
foreach (filter_list() as $filter) {
    // echo $filter . ' => ' . filter_id($filter) . '<br>';
}
echo '<hr>';

// 1. filter_var(): 过滤单个变量
$age = 30;
var_dump(filter_var($age, FILTER_VALIDATE_INT));
// 验证时,会将变量值转为字符串类型, 所以这样写也对
$age = '30';
var_dump(filter_var($age, FILTER_VALIDATE_INT));
echo '<br>';
// 还可以添加第三个参数,对过滤器行为进行限定
// 被过滤的数据也支持字面量,但不推荐这样
var_dump(filter_var(10, FILTER_VALIDATE_INT, ['options' => ['min_range' => 18, 'max_range' => 60]]));
$age = 40;
var_dump(filter_var($age, FILTER_VALIDATE_INT, ['options' => ['min_range' => 18, 'max_range' => 60]]));

echo '<br>';

// 既可以使用过滤器常量,也可以使用过滤器ID
$email = 'admin@php.cn';
// 过滤器常量
var_dump(filter_var($email, FILTER_VALIDATE_EMAIL));
echo '<br>';
// 过滤器ID
var_dump(filter_var($email, 274));
echo '<br>';
var_dump(filter_var('peter@qq.com', 274));
echo '<br>';

// 2. filter_var_array():过滤多个变量
$a = 10;
$b = 'php';
// 返回值是数组, 验证失败返回false,成功返回原值
var_dump(filter_var_array([$a, $b], FILTER_VALIDATE_INT));
echo '<br>';
// 对于多变量验证最好将数组放在数组中统一处理
$data = [$a, $b, 'html', [6, 7, 8], 150, 200];
var_dump(filter_var_array($data, FILTER_VALIDATE_INT));
// 过滤掉验证未通过的元素
var_dump(array_filter(filter_var_array($data, FILTER_VALIDATE_INT)));

echo '<hr>';

// 3. filter_has_var(): 检测是否存在指定类型的外部变量
// 变量类型仅限:INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV
var_dump(filter_has_var(INPUT_GET, 'id'));
echo '<br>';

//4. filter_input(): 通过名称获取特定的外部变量，并且可以通过过滤器处理它
// 变量类型仅限:INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV
// false:验证失败, null: 变量不存在, 成功返回当前值
// $_GET['id'] 必须是大于1的整数
$res = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
var_dump($res);
echo '<hr>';

// 5. filter_input_array(): 同时验证多个外部变量
// 为一组数据应用统一过滤器
var_dump(filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING));

// 为每一个元素应用不同的过滤器
// 设置变量对应过滤器
$args = [
    'username' => FILTER_SANITIZE_STRING,
    'email' => FILTER_VALIDATE_EMAIL,
    'age' => ['filter' => FILTER_VALIDATE_INT, 'flags'=>FILTER_REQUIRE_SCALAR, 'options' => ['min_range' => 18]],
    'blog' => FILTER_VALIDATE_URL,
];

// 非法: demo11.php?username=<a>admin</a>&email=abc&age=15&blog=blog.php.cn
// 合法: demo11.php?username=admin&email=abc@qq.com&age=25&blog=http://blog.php.cn
var_dump(filter_input_array(INPUT_GET, $args));
```
