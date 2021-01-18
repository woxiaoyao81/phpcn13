[toc]

## 一、中间件

中间件提供了一种方便的机制来过滤进入应用程序的 HTTP 请求。例如，Laravel 包含一个验证用户身份的中间件。 如果用户未能通过认证，中间件会把用户重定向到登录页面。 反之，用户如果通过验证， 中间件将把请求进一步转发到应用程序中。当然，除了验证身份外，还可以编写其他的中间件来执行各种任务。例如：CORS 中间件可以负责为所有的应用返回的 responses 添加合适的响应头。日志中间件可以记录所有传入应用的请求。Laravel 自带了一些中间件，包括身份验证、CSRF 保护等。所有的这些中间件都位于 app/Http/Middleware 目录。

### 1、定义中间件

您可以使用 make:middleware 来创建一个中间件。

```shell
php artisan make:middleware CheckAge
```

该命令会在 app/Http/Middleware 目录下放置新的 CheckAge 类。当然也可以手动创建这个php文件，不过需要手写模板代码，而artisan创建则只要写核心代码就可以。在这个中间件中，我们仅允许 age 参数大于 200 的请求对路由进行访问，否则将重定向到 home 页面。

```php
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAge
{
    /**
     * 处理传入的请求
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->age <= 200) {
            return redirect('home');
        }
        return $next($request);
    }
}
```

> **注意事项:**
> 1.若是在中间件中处理结束后，对于不符合的停止建议使用`return response('提示信息',200)`返回到前端，可以使用exit或die终止，但不建议这样，至于response方法使用可看帮助。
> 2.next在处理之前就是前置中间件，处理之后就是后置中间件

### 2、注册中间件

前面已经定义了中间件，一般情况下注册中间件都是在`app/Http/Kernel.php`中进行，分为 **全局中间件和路由中间件** ，前者是注册中间件到文件中`$middleware`变量里，在应用处理每个 HTTP 请求期间都会启用中间件。而后者是注册到`$routeMiddleware`变量里，在路由中使用middleware方法激活中间件。

```php
//app/Http/Kernel.php
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
     //.......
      'checkage' => \App\Http\Middleware\CheckAge:class,
];
```

### 3、路由中间件的激活

前面已经说过了，在路由定义时链式调用middleware方法就可以激活路由中间件了，可以分配多个中间件。

```php
Route::get('admin/profile', function () {})->middleware('auth');
Route::get('admin/profile', function () {})->middleware('first', 'second');
```

将中间件分配给一组路由时，有时可能需要阻止将中间件应用于该组中的单个路由。 您可以使用 withoutMiddleware 方法完成此操作

```php
//web.php
use App\Http\Middleware\CheckAge;

Route::middleware([CheckAge::class])->group(function () {
    Route::get('/', function () {
        //
    });
Route::get('admin/profile', function () {})->withoutMiddleware([CheckAge::class]);
});
```

### 4、中间件组

有时，您可能希望将多个中间件归为一个键，以使其更易于分配给路由。 您可以使用 HTTP 内核的 `$middlewareGroups` 属性来实现。Laravel 开箱即用，带有 web 和 api 中间件组，其中包含您可能要应用于 Web UI 和 API 路由的通用中间件

```php
/**
 * 路由中间件组
 *
 * @var array
 */
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

    'api' => [
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
```

中间件组可以使用与单个中间件相同的语法将自身分配给路由和控制器动作。同样，中间件组使得一次将多个中间件分配给一个路由更加方便

```php
Route::get('/', function () {
    //
})->middleware('web');
Route::group(['middleware' => ['web']], function () {});
Route::middleware(['web', 'subscribed'])->group(function () {});
```

> **注意:** RouteServiceProvider 默认将 web 中间件组自动应用到 routes/web.php

### 5、中间件排序

很少情况下，你可能需要中间件以特定的顺序执行，但是当它们被分配到路由时，你无法控制它们的顺序。在这种情况下，可以使用 `app/Http/Kernel.php` 文件中的` $middlewarePriority` 属性指定中间件的优先级

```php
/**
 * 中间件的优先级排序列表
 *
 * 将会强制非全局中间件始终保持给定的顺序
 *
 * @var array
 */
protected $middlewarePriority = [
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
    \Illuminate\Routing\Middleware\ThrottleRequests::class,
    \Illuminate\Session\Middleware\AuthenticateSession::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    \Illuminate\Auth\Middleware\Authorize::class,
];
```

### 6、中间件参数

中间件还可以接收额外的参数。例如，如果你的应用程序需要在执行给定操作之前验证用户是否为给定的「角色」， 你可以创建一个 CheckRole 中间件，由它来接收「角色」名称作为附加参数。附加的中间参数会在 $next 参数之后传递给中间件

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * 处理传入的请求
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            // 重定向...
        }
        return $next($request);
    }
}
```

定义路由时通过一个 : 冒号来隔开中间件名称和参数来指定中间件参数。多个参数就使用逗号分隔

```php
Route::put('post/{id}', function ($id) {})->middleware('role:editor');
```

### 7、Terminable 中间件

有时可能需要在 HTTP 响应之后做一些工作。 如果你在中间件上定义了一个 terminate 方法，并且你使用的是 FastCGI，那么 terminate 方法会在响应发送到浏览器之后自动调用

```php
<?php

namespace Illuminate\Session\Middleware;

use Closure;
use Illuminate\Http\Request;

class StartSession
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // 存储 session 数据
    }
}
```

terminate 方法应该同时接收请求和响应。定义了这个中间件之后，别忘了将它添加到路由列表或者 `app/Http/Kernel.php` 文件的全局中间件中。当你在中间件上调用 terminate 方法的时候，Laravel 将从 服务容器 中解析出一个新的中间件实例。如果在调用 handle 和 terminate 方法的同时使用相同的中间件实例， 请使用容器的 singleton 方法注册中间件， 通常这应该在 AppServiceProvider.php 文件中的 register 方法中完成

```php
use App\Http\Middleware\TerminableMiddleware;

/**
 * 注册任意应用服务
 *
 * @return void
 */
public function register()
{
    $this->app->singleton(TerminableMiddleware::class);
}
```

## 二、控制器中间件和控制器的parent拦截

在TP6学习中间件时，中间件也分为前置中间件和后置中间件，它的使用位置也可分为全局中间件、应用中间件、路由中间件，控制器中间件四种类型，那么Laravel也是存在控制器中间件概念的，其实通过TP6的中间件可以完全Laravel中间件的学习，唯一不同就是Laravel的Terminable 中间件是TP6所没有的。

### 1、控制器中间件

在控制器的构造函数中指定中间件更为方便。使用控制器构造函数中的 middleware 方法，可以轻松地将中间件分配给控制器。你甚至可以将中间件限制为只在控制器中的某些方法生效，其中only和except等同于TP6中控制器中间件的only和except方法。

```php
class UserController extends Controller
{
    /**
     * 实例化一个新的控制器实例
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('log')->only('index');
        $this->middleware('subscribed')->except('store');
    }
}
```

### 2、控制器的parent拦截

中间件其实就是拦截客户端的Request，在返回给服务端处理之前可以统一进行预处理或服务端处理后返回客户之前再处理，它实质就是拦截行为，贯彻了AOP编程理念，原生PHP是没什么中间件的概念的，它的拦截实现就是通过类的继承，在父类中进行处理统一的需求，如登录认证、防登录欺骗、过滤用户非常输入等等，其实它就是中间件的由来。在TP6实战时灭绝老师就演示了这种方法处理用户的登录检查，就是从TP6控制类继承了用户定义的控制类，它其中实现了登录检查功能，包括我项目现在也是这种实现，其它控制器需要登录检查的就继承用户的控制类，不需要登录检查的如登录界面就继承TP默认控制类。

TP5.1.6以前还没有中间件的概念，它的登录检查等统一需要都是通过parent拦截实现的，但现在已经完全引入中间件，parent拦截统一处理已经被中间件所代替，中间件实现起来更灵活更强大，可以是全局、某个应用、某个路由、某个控制器、甚至是某个方法，这个当然也可以通过parent拦截来实现，不过却需要更多代码来组织，而中间件从Laravel而来，已经非常成熟了，所以建议对统一处理的需求可多中间件，少parent拦截了。

## 三、Laravel8入门知识的梳理

默认的 Laravel 应用程序结构旨在为大型和小型应用程序提供一个良好的起点。但是你可以自由地组织你的应用程序。只要 Composer 可以自动加载类，Laravel 几乎不限制任何给定类的位置。

### 1、根目录

App 目录
app 包含你的程序的核心代码。我们很快会详细地研究这个目录；不管怎样，应用程序中几乎所有的类都将位于此目录中。

Bootstrap 目录
bootstrap 目录包含了框架的启动文件 app.php 。该目录还包含 cache 目录，其中包含用于性能优化的框架生成的文件，例如路由和服务缓存文件。这个目录平时很少用到。

Config 目录
顾名思义，config 目录包含应用程序的所有配置文件。最好把这些文件都浏览一遍，并熟悉所有可用的选项。

Database 目录
database 目录包含 数据库迁移，模型工厂和 种子成生器 文件。如果你喜欢，你还可以把它作为 SQLite 数据库存放目录。老师建议这个目录可以忽略，解释是因为数据库的操作权限应该是管理员，不应该是程序员。

Public 目录
public 包含 index.php 文件，它是进入应用程序的所有请求的入口，并配置自动加载。该目录还包含您的资源，如图像、JavaScript 脚本和 CSS 样式。

Resources 目录
resources 目录包含了视图和未编译的资源文件（如 LESS、SASS 或 JavaScript）。此目录还包含你所有的语言文件。

Routes 目录
routes 目录包含应用程序的所有路由定义。默认情况下，Laravel 包含几个路由文件：web.php, api.php, console.php 以及 channels.php。
>- web.php 文件包含 RouteServiceProvider 放置在 web 中间件组中的路由，后者提供会话状态、CSRF 保护和 cookie 加密。如果您的应用程序不提供无状态的 RESTful API，那么您的所有路由都很可能在 web.php 文件。
>- api.php 文件包含 RouteServiceProvider 放置在 api 中间件组中的路由，后者提供速率限制。这些路由是无状态的，因此通过这些路由进入应用程序的请求将通过令牌进行身份验证，并且不能访问会话状态。
>- console.php 文件是您可以定义所有基于闭包的控制台命令的地方。每个闭包都绑定到一个命令实例，允许使用一种简单的方法与每个命令的进行 IO 交互。尽管这个文件没有定义 HTTP 路由，但是它定义了应用程序中基于控制台的入口点（路由）。
>- channels.php 文件是您可以注册应用程序支持的所有事件广播频道的位置。


Storage 目录
storage 包含由 Blade 框架生成的基于目录的模板、文件和缓存。这个目录分成 app、framework 和 logs 目录。app 目录可用于存储应用程序生成的任何文件。framework 目录用于存储框架生成的文件和缓存。最后，logs 目录包含应用程序的日志文件。storage/app/public 目录用来存储用户生成的文件，例如应该公开访问的用户头像。你可能创建一个指向到这个目录软链接 public/storage ， 你可以通过这个命令 php artisan storage:link 。


Tests 目录
tests 目录包含自动化测试类。 目录提供了一个测试示例 PHPUnit 。 每个测试类都应该用单词 Test 作为后缀。您可以使用 phpunit 或 php vendor/bin/phpunit 命令运行测试。


Vendor 目录
vendor 目录包含你的 Composer 依赖。

### 2、App 目录
应用程序的大部分都位于 app 目录中。默认情况下，此目录的名称空间在 App 下，并由 Composer 使用 PSR-4 自动加载。

app 目录包含各种目录，如 Console、Http 和 Providers。可以将 Console 和 Http 目录看作是为应用程序的核心提供了一个 API。HTTP 协议和 CLI 都是与应用程序交互的机制，但实际上并不包含应用程序逻辑。换句话说，它们是向应用程序发出命令的两种方式。Console 目录包含所有 Artisan 命令，而 Http 目录包含控制器、中间件和请求。

当您使用 make Artisan 命令生成类时，将在 app 目录内生成各种目录。因此，例如 当你执行 make:job 命令生成队列任务时，将会生成 app/Jobs 目录。

> **技巧:** app 目录中的许多类可以由 Artisan 通过命令生成。要查看可用的命令，请在终端中运行 php artisan list make 命令。

Broadcasting 目录
Broadcasting 目录包含应用程序的所有广播频道类，这些类都是通过 make:channel 命令生成的。这个目录默认是不存在的，但是当你创建第一个广播频道类时候时它会自动生成。要了解有关频道的更多信息，请查看 广播系统。


Console 目录
Console 目录包含应用所有自定义的 Artisan 命令， 这些类通过 make:command 命令生成。 此目录也安置了控制台内核，在其中你可以注册自定义的 Artisan 命令，并定义 计划任务。


Events 目录
该目录默认不存在，但可以通过 event:generate 和 make:event 命令创建。Events 目录用于存放 事件类。事件类用于告知应用其他部分某个事件发生情况并提供灵活的、解耦的处理机制。


Exceptions 目录
Exceptions 目录包含应用的异常处理器，同时还是处理应用抛出的任何异常的好地方。如果你想要自定义异常如何记录或渲染，需要编辑该目录下的 Handler 类.


Http 目录
Http 目录包含了控制器、中间件以及表单请求等，几乎所有通过 Web 进入应用的请求处理都在这里进行。


Jobs 目录
该目录默认不存在，但可以通过执行 make:job 命令生产，Jobs 目录用于存放 队列任务，应用中的任务可以被推送至队列，也可以在当前请求生命周期内同步执行。同步执行的任务有时也被看作是命令，因为它们实现了 命令模式。


Listeners 目录
默认情况下，此目录不存在，但如果你执行 event:generate 或 make:listener Artisan 命令时，会自动生成。Listeners 目录包含所有处理事件的类。在事件触发后，事件侦听器接收事件实例并执行处理逻辑。例如，UserRegistered 事件被 SendWelcomeEmail 监听器所处理。


Mail 目录
默认情况下，此目录不存在，但如果你执行 make:mail Artisan 命令时，会自动生成。Mail 目录包含应用程序所有表示发送的电子邮件的类。Mail 对象允许您将构建电子邮件的所有逻辑封装在一个简单的类中，该类可以使用 Mail::send 方式发送。


Models 目录
Models 目录包含所有 Eloquent 模型类。Laravel 附带的 Eloquent ORM 为处理数据库提供了一个漂亮、简单的 ActiveRecord 实现。每个数据库表都有一个对应的「模型」，用于与该表进行交互。每个数据库表都有一个对应的 Model，用于与该表进行交互。模型允许您查询表中的数据，以及向表中插入新记录。

Notifications 目录
默认情况下，此目录不存在，但如果你执行 make:notification Artisan 命令时会自动生成。Notifications 目录包含所有你发送给应用程的「事务性」通知。例如关于应用程序内发生的事件的简单通知。Laravel 的通知功能抽象了通过各种驱动程序发送的通知，如电子邮件通知、Slack 信息、SMS 短信通知或数据库存储。


Policies 目录
默认情况下，此目录不存在，但如果您执行 make:policy Artisan 命令会生成。Policies 目录包含应用程序的授权策略类。这些类用于确定用户是否可以对资源执行给定的操作。有关更多信息，请查看 授权文档。


Providers 目录
Providers 目录包含程序中所有的的 服务提供者。服务提供者通过在服务容器中绑定服务、注册事件或执行任何其他任务来引导应用程序以应对传入请求。

在一个新的 Laravel 应用程序中，这个目录已经包含了几个提供者。您可以根据需要将自己的提供程序添加到此目录。

Rules 目录
默认情况下，此目录不存在，但如果您执行 make:rule Artisan 命令后会生成。Rules 目录包含应用程序用户自定义的验证规则。这些验证规则用于将复杂的验证逻辑封装在一个简单的对象中。有关更多信息，请查看 表单验证。

### 3、请求流程或周期

「日常生活」中使用任何工具时，如果理解了该工具的工作原理。那么用起来就会更加得心应手。应用开发也是如此，当你能真正懂得一个功能背后实现原理时，用起来会更加顺手，方便。文档存在目的是为了让你更加清晰地了解 Laravel 框架是如何工作(TP6文档也有类似章节请求流程)。通过框架进行全面了解，让一切都不再感觉很「神奇」。相信我，这有助于你更加清楚自己在做什么，对自己想做的事情更加胸有成竹。就算你不明白所有的术语，也不用因此失去信心！只要多一点尝试、学着如何运用，随着你浏览文档的其他部分，你的知识一定会因此增长。

>**首先**

Laravel 应用的所有请求入口都是 public/index.php 文件。而所有的请求都是经由你的 Web 服务器（Apache/Nginx）通过配置引导到这个文件。index.php 文件代码并不多，但是，这里是加载框架其它部分的起点。

index.php 文件加载 Composer 生成的自动加载设置，然后从 bootstrap/app.php 脚本中检索 Laravel 应用程序的实例。Laravel 本身采取的第一个动作是创建一个应用程序 / 服务容器。

> **HTTP / Console 内核**

接下来， 根据进入应用程序的请求类型来将传入的请求发送到 HTTP 内核或控制台内核。而这两个内核是用来作为所有请求都要通过的中心位置。 现在，我们先看看位于 app/Http/Kernel.php 中的 HTTP 内核。

HTTP 内核继承了 Illuminate\Foundation\Http\Kernel 类，该类定义了一个 bootstrappers 数组。 这个数组中的类在请求被执行前运行，这些 bootstrappers 配置了错误处理，日志，检测应用环境，以及其它在请求被处理前需要执行的任务。

HTTP 内核还定义了所有请求被应用程序处理之前必须经过的 HTTP 中间件。这些中间件处理 HTTP 会话 读写 HTTP session、判断应用是否处于维护模式、验证 CSRF 令牌 等等。

HTTP 内核的 handle 方法签名相当简单：获取一个 Request，返回一个 Response。可以把该内核想象作一个代表整个应用的大黑盒子，输入 HTTP 请求，返回 HTTP 响应。

> **服务提供者:** 核心工作层，与用户打交道最多地方

内核启动操作中最重要的便是你应用的 服务提供者 了。所有应用下的服务提供者均配置到了 config/app.php 配置文件中的 providers 数组中。第一步，所有服务提供者的 register 方法会被调用，然后一旦所有服务提供者均注册后， boot 方法才被调用。

服务提供者给予框架开启多种多样的组件，像数据库，队列，验证器，以及路由组件。只要被启动服务提供者就可支配框架的所有功能，所以服务提供者也是 Laravel 整个引导周期最重要组成部分。

> **请求调度:**

一旦启动且所有服务提供者被注册，Request 会被递送给路由。路由将会调度请求，交给绑定的路由或控制器，也当然包括路由绑定的中间件。


> **聚焦服务提供者:**

服务提供者是 Laravel 真正意义的生命周期中的关键。应用实例一旦创建，服务提供者就被注册，然后请求被启动的应用接管。简单吧！

牢牢掌握服务提供者的构建和其对 Laravel 应用处理机制的原理是非常有价值的。当然，你的应用默认的服务提供会存放在 app/Providers 下面。

默认的，AppServiceProvider 是空白的。这个提供者是一个不错的位置，用于你添加应用自身的引导处理和服务容器绑定。当然，大型项目中，你可能希望创建数个粒度更精细的服务提供者。
