# composer 极简教程

[toc]

## 1. 背景知识

### 1.1 组件

- 组件是一组打包的代码,是一系列相关的类/接口/trait
- 例如:http 请求组件,路由组件,日志,邮件等...
- 组件具有功能单一,通信简单,方便测试,文档完善的优点
- Laravel 就是典型的基于组件开发的 PHP 开发框架

### 1.2 组件查询

- PHP 组件查询: <https://packagist.org>
- 该网站仅提供了组件的基本信息,如运行环境,以及依赖的其它组件
- 该网站只是提供了组件查询与描述,组件的源代码存储在`github`上

### 1.3 组件依赖管理

- 项目开发过程中总免不了产生对第三方组件的依赖与导入
- 而众多的第三方组件之间又免不了再次产生相互依赖关系,
- 随着项目复杂度的不断提升,手工管理组件之间的依赖关系将不再适合
- 此时,需要一个工具,用来描述项目所依赖的组件以及组件之间的依赖关系
- **composer** 就是这样一个优秀的项目组件的依赖管理工具
- 从此,php 项目开发,真正进入到了组件化开发的新时代

---

 

## 2. composer.json

### 2.1 "包"(`packge`)的概念

- 只要当前目录中存在`composer.json`文件,那么整个目录就是一个"包",如`blog`
- 此时,你开发的项目就是依赖其它组件库的"包",只不过你的包没有名称而组件有名称罢了
- 如果你想将项目做为一个"包"进行发布,可以在`composer.json`中创建`name`字段
- 如果你只想当个伸手党, 那么就可以省略`name`字段,不影响你对依赖包的调用

### 2.2 文档功能

- 声明当前项目与依赖组件(包)之间的依赖与依赖之间的关系
- 可简单的理解为当前项目的`composer`配置文档
- 该文档可以手工创建,也可以使用交互式命令创建
- 该文档中声明的依赖须通过`composer install`指令加载
- 声明的所有依赖会自动下载到`vendor`目录中(目录全自动创建)
- 安装完成,会自动生成`composer.lock`锁定依赖包的版本号等信息
- 锁定依赖包版本号,可使团队中的每一位开发人员都得到相同版本的依赖包

### 2.3 交互式创建:`composer init`

- 该命令将会指导您创建 composer.json 配置文件

```shell
 

Welcome to the Composer config generator
# 欢迎使用Composer配置生成器

This command will guide you through creating your composer.json config.
# 

Package name (<vendor>/<name>) [zhupeter/tptest]:
# 包名称: 默认为当前登录用户名和目录名二部分组件,中间用目录分隔符分开
Description []: # 安装的描述,可跳过
Author [, n to skip]: # 作者信息,格式必须是,John Smith <john@example.com>
Peter Zhu <peter@qq.com> # 这是我的信息
# 授权等直接忽略

Define your dependencies.
# 定义依赖,这才是关键步骤,也是必填项

# 在安装包之前, 应该先进行搜索,确定该包存在(根据关键字即可)
Would you like to define your dependencies (require) interactively [yes]?
Search for a package: bootstrap

# 搜索 "bootstrap"包
Found 15 packages matching bootstrap

   [0] twbs/bootstrap
   [1] twitter/bootstrap
   [2] fortawesome/font-awesome
   ...

# 输入安装包对应的序号即可,例如: 0
Enter package # to add, or the complete package name if it is not listed
0

# 输入包的版本号,直接回车
Enter the version constraint to require (or leave blank to use the latest version):

# 这里提示3.7是正在使用的版本,4.3+是新版本
3.7.Using version ^4.3 for twbs/bootstrap
Search for a package: Would you like to define your dev dependencies (require-dev) interactively [yes]? *
 Please answer yes, y, no, or n.
# 询问是否可以测试版本,回复: n
Would you like to define your dev dependencies (require-dev) interactively [yes]? n

# 下面就是即将生成的: composer.json 文件的内容
{
    "name": "zhupeter/tptest",
    "require": {
        "twbs/bootstrap": "^4.3"
    },
    "authors": [
        {
            "name": "Peter Zhu",
            "email": "peter@qq.com"
        }
    ]
}
# 是否确定创建该文件? 回答: 是, 将自动生成"composer.json"
Do you confirm generation [yes]? yes

# 询问是否现在就安装这些依赖包?
# 我想以后通过"composer install"安装,现在不需要,回复: n
Would you like to install dependencies now [yes]? n

# composer.json 依赖配置文件创建成功, 退出ini命令,返回控制台
$
```

### 3.4 手工创建

- 其实`composer.json`中最重要的就是`require`字段,其它均可选
- 一个可能的经典的文档结构:

```json
{
  "require": {
    "components/jquery": "3.4.*"
  }
}
```

> 注: `composer.lock`由 composer 自动创建和维护,用户不必干涉,也没必要理会

### 3.5 安装依赖:`composer install`

以上面的`composer.json`为例,安装`jQuery`库

```shell
# 根据composer.json,下载指定的依赖组件库到`vendor`目录中
composer install
```

指令会自动进行如下操作

1. 创建`vendor`目录,并初始化它,创建必要的配置文件与自动加载入口文件
2. 访问`packgister.org`网站查询指定的组件,并从`github`下载到指定目录下面
3. 创建`composer.lock`文档,自动锁定下载的依赖组件的版本号

> 注意: 再次安装并不会重复以上操作,而是直接从缓存中下载

### 3.6 更新依赖:`composer update`

如果`composer.json`中的依赖版本发生变化

```json
{
  "require": {
    "components/jquery": "3.5.*"
  }
}
```

此时, `composer.json`与`composer.lock`中的版本不一致,需要更新`lock`文档

```shell
# 更新compoer.json中的依赖组件,并将新版本依赖写入composer.lock文档
composer update
```

> 注: 此时执行`composer install`无效,除非手工删除`composer.lock`再执行

---

## 4. 声明依赖: `require`命令

### 4.1 没有`composer.json`时

- 自动创建`composer.json`,并将依赖组件信息写入`require`字段
- 自动创建`vendor`目录,并初始化
- 自动执行`composer install`指令安装依赖到`vendor`指定目录
- 自动创建`composer.lock`锁定依赖组件的版本号

### 4.2 已存在`composer.json`

- 将依赖写入`composer.json`的`require`字段
- 执行`composer install`命令将依赖安装到`vendor`指定目录中
- 将依赖版本号写入`composer.lock`中

### 4.3 演示

将`composer.json`删除后再测试

## 4.3 总结

- `require`命令,相当于安装依赖包的自动批处理操作,非常方便
- 在工作中, 应该首选`require`指定安装组件,全自动操作可防止出错
- <https://packagist.org/>中的大多数组件,默认采用该方式安装组件

---

## 5. 创建项目: `create-project`

### 5.1 功能

- 该命令用于克隆出一个全新的项目,类似`git clone`
- 这个项目是基于一个现成的项目的
- 项目之所有称之为项目,是它有自己`vendor`,自己的依赖库
- 该命令用于创建一个全新的项目,而不能在已经的项目中执行它
- 最典型的就是一些基于组件的开发框架,如`Laravel`, `ThinkPHP`等

### 5.2 演示

```shell
# 使用默认配置
composer create-project laravel/laravel blog

# 当有可用的包时，从 dist 安装
composer create-project --prefer-dist laravel/laravel blog

# 指定版本
composer create-project --prefer-dist laravel/laravel blog 6.*
```

---

## 6. 更新自动加载器: dump-autoload

- 当项目(包中)中新增一个类时,必须使用`dump-autoload`命令更新自动加载器
- 该类必须是符合`PSR-4`规范
- 命令简写`dumpautoload`

---

## 7. `composer.lock`: 依赖锁定文件

> 依赖锁定文件, 通常可以简称为: "锁文件"

- **功能:** 将自动锁定该项目所依赖的安装包以及特定版本号

- **流程:**

  - 依赖安装完成后,Composer 将把确定的版本号列表写到`composer.lock`中
  - 如果再次执行`install`命令时,将首先检查是否存在`composer.lock`
  - 如果存在`composer.lock`将下载它指定的版本,自动忽略`composer.json`
  - 如果不存在`composer.lock`,将下载`composer.json`中的定义,并创建锁文件

- **优点:**任何人都可以通过这个`composer.lock`获得完全一致的开发环境
- **缺点:**如果依赖更新了,将不会获取到该更新,除非使用`update`命令
- `update`命令,将会根据`composer.json`获取依赖的最新的版本,并将新版本写到锁文件
- 对于库, 通常不建议提交锁文件

---

## 8. 依赖的自动加载

### 8.1 默认的加载器

- 对于库的自动加载,Composer 生成一个`vendor/autoload.php`文件
- 引入该文件将免费获得自动加载的支持, 更加方便的使用第三方代码库
- `require 'vendor/autoload.php';`添加到你的脚本顶部

```php
require 'vendor/autoload.php';

// 假设已通过composer.json安装了monolog/logger依赖
$log = new Monolog\Logger('name');
// 下面就可以直接使用该类中定义的成员了
```

### 8.2 添加自定义的加载器

- 在`composer.json`的`autoload`字段定义自己的`autoloader`

```json
{
   "autoload": {
        "psr-4": {
            "app\\": "application"
        }
}
```

- `autoload`字段的解释:

  - Composer 将注册一个`PSR-4 autoloader`到`app`命名空间
  - 即注册一个符合`PSR-4`标准的加载器到`app`命名空间中
  - 可以定义命名空间到目录的映射: 例如本例: `app`空间映射到目录`application`
  - 该`application`目录在项目根目录,并且与`vendor`目录同级
  - 举例: `application/model/Staff.php`,中定义`app\model\Staff`类

- 再次运行`composer install`命令,更新 composer 的加载器`vendor/autoloader.php`
- 引用`autoload.php`将返回加载器实例,通过它还可以添加更多的命名空间

```php
// $loader 是 autoloader 加载器实例对象
$loader = require 'vendor/autoload.php';

// 添加更多的命名空间到Composer的加载器中
$loader->add('think', 'thinkphp/libray/think');
```

---

## 9. 自动诊断: diagnose

- 如果感觉程序有问题,可用该指令进行分析(仅供参考)
- `composer diagnose`
