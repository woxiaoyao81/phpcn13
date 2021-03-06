# php 程序

## 1. php 是什么

- PHP: (PHP: Hypertext Preprocessor), 超文本预处理器的缩写,服务端的语言。
- PHP 是开源的,免费的,可以嵌入html中的语言。
- 脚本语言,是指不需要编译,直接由解释器/虚拟机执行的编程语言

---

## 2. php 程序执行流程

- php 程序是用 php 指令编写并由 php 解析器执行的代码
- php 程序必须使用`.php`做为扩展名
- php 程序可以使用标签方式嵌入到 html 文档中

![php1](1.jpg)

执行流程哪下:

1. 客户端请求服务器端的 php 程序
2. 服务器端将 php 程序转发给 php 解释器执行
3. php 解释器执行完毕将生成的 html 或其它内容返回到服务器
4. 服务器将最终生成的 html 代码做为响应内容返回客户端

---

## 3. php 集成运行环境

> 初学者推荐使用集成环境,省去手工逐一安装配置麻烦

| 序号 | 集成环境 | 操作系统        | 描述                    |
| ---- | -------- | --------------- | ----------------------- |
| 1    | phpStudy | Windows / Linux | 中文,免费,功能全, 推荐  |
| 2    | MAMP     | MacOS           | 英文,收费, 功能全, 推荐 |

---

## 4. php 程序文档

| 序号 | 组成           | 描述                            |
| ---- | -------------- | ------------------------------- |
| 1    | `<?php ... ?>` | PHP 代码标记                    |
| 2    | `;` 分号       | 语句分隔符,代码块使用大括号   |
| 3    | 空白符         | 合理使用空白符可增强代码可读性  |
| 4    | 注释           | `// 单行注释`, `/* 多行注释 */` |

> php 标记之外的内容会原样返回客户端,如 html 代码

示例代码: `demo1.php`

```php
<?php
/*
1. 功能: 求和
2. 参数: 整数
3. 返回: 整数
*/
function sum(int $a, int $b): int
{
    // 返回结果
    return $a + $b;
}

// 函数调用
echo sum(10, 20);
?>
```

---

## 5. 打印结果

| 序号 | 指令           | 描述                                           |
| ---- | -------------- | ---------------------------------------------- |
| 1    | `echo`         | 语言结构, 可查看多个变量                       |
| 2    | `print`        | 语言结构,功能与`echo`类似,区别是有返回值       |
| 3    | `print_r()`    | 函数,以更容易理解的格式打印变量信息,常用于数组 |
| 4    | `var_dump()`   | 函数,可查看一个变量更多信息,如类型             |
| 5    | `var_export()` | 函数,输出或返回一个变量的字符串表示(源代码)    |

> 实际工作中, `echo`和`var_dump()`基本可以满足大多数需求

示例代码: `demo2.php`

```php
<?php
# php打印结果

$email = 'admin@php.cn';

echo $email, '<br>';
echo print $email;
echo '<br>';
var_dump($email);
echo '<br>';
var_export($email);

/* 运行结果
admin@php.cn
admin@php.cn1
string(12) "admin@php.cn"
'admin@php.cn'
*/
```
