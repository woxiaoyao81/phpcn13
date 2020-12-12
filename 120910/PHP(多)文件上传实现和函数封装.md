[toc]

## 一、PHP 文件上传的相关知识

对 PHP 文件上传的相关知识总结主要是参考老师演示的代码和 drawer.php(某大神写的 PHP 单文件版的服务器文件管理端)

### 1. php 关于文件上传的配置

> 文件上传项目项在`php.ini`中设置,常用的配置项有:

| 序号 | 配置项                | 默认值 | 描述                                                                |
| ---- | --------------------- | ------ | ------------------------------------------------------------------- |
| 1    | `file_uploads`        | `On`   | 使 PHP 支持文件上传                                                 |
| 2    | `upload_tmp_dir`      | `/tmp` | 指示应该临时把上传的文件存储在什么位置                              |
| 3    | `max_file_uploads`    | `20`   | 单次请求时允许上传的最大文件数量                                    |
| 4    | `max_execution_time`  | `30`   | 设置脚本被解析器终止之前 PHP 最长执行时间(秒) ,防止服务器资源被耗尽 |
| 5    | `max_input_time`      | `60`   | 设置 PHP 通过 POST/GET/PUT 解析接收数据的时长(秒)                   |
| 6    | `memory_limit`        | `128M` | 系统分配给当前脚本执行可用的最大内存容量                            |
| 7    | `post_max_size`       | `8M`   | 允许的 POST 数据的总大小                                            |
| 8    | `upload_max_filesize` | `32M`  | 允许的尽可能最大的文件上传                                          |

### 2. 服务端超全局变量`$_FILES`

- 上传文件的描述信息,全部保存在系统全局变量`$_FILES`中
- `$_FILES`以二维数组形式保存: `$_FILES['form_file_name']['key']`
- `'form_file_name'`: 对应着表单中`<input type="file" name="my_pic">`中`name`属性值
- `'key'`: 共有 5 个键名, 描述如下:

| 序号 | 键名       | 描述                                               |
| ---- | ---------- | -------------------------------------------------- |
| 1    | `name`     | 文件在客户端的原始文件名(即存在用户电脑上的文件名) |
| 2    | `type`     | 文件的 MIME 类型, 由浏览器提供, PHP 并不检查它     |
| 3    | `tmp_name` | 文件被上传到服务器上之后,在临时目录中临时文件名    |
| 4    | `error`    | 和该文件上传相关的错误代码                         |
| 5    | `size`     | 已上传文件的大小(单位为字节)                       |

- 文件上传错误信息描述

| 序号 | 常量                    | 值  | 描述                                       |
| ---- | ----------------------- | --- | ------------------------------------------ |
| 1    | `UPLOAD_ERR_OK`         | `0` | 没有错误发生,文件上传成功                  |
| 2    | `UPLOAD_ERR_INI_SIZE`   | `1` | 文件超过`php.ini`中`upload_max_filesize`值 |
| 3    | `UPLOAD_ERR_FORM_SIZE`  | `2` | 文件大小超过表单中`MAX_FILE_SIZE`指定的值  |
| 4    | `UPLOAD_ERR_PARTIAL`    | `3` | 文件只有部分被上传                         |
| 5    | `UPLOAD_ERR_NO_FILE`    | `4` | 没有文件被上传                             |
| 6    | `UPLOAD_ERR_NO_TMP_DIR` | `6` | 找不到临时文件夹                           |
| 7    | `UPLOAD_ERR_CANT_WRITE` | `7` | 文件写入失败                               |

### 3、介绍一些常用的 PHP 函数

> **与 php.ini 配置相关的函数:** 我们知道修改 php.ini 后要重启服务，但修改配置一般是某些页面需求，再者一般也不建议随意修改 php.ini 的配置文件。PHP 提供了 ini 为前缀的函数，修改配置仅对当前页面有效，页面释放后就无效了，非常适合我们平常使用。
>
> - `ini_set(string $varname,string $newvalue):string` 设置指定配置选项的值。这个选项会在脚本运行时保持新的值，并在脚本结束时恢复。**简单的说就是可以临时修改 pnp.ini 配置文件中的值，页面结束时恢复** 。这样就可以不用去修改 php.ini 的默认配置了，毕竟它是全局的，影响机器上所有 PHP 服务，而我们改变一般都是针对当前需求的，所以使用它修改比较合适。
> - `ini_get(string $varname):string`获取一个配置选项的值，`ini_get_all([ string $extension[, bool $details = true]]):array`获取所有已注册的配置选项,`get_cfg_var(string $option):mixed`获取 PHP 配置选项 option 的值,此函数不会返回 PHP 编译的配置信息，或从 Apache 配置文件读取。
> - `ini_restore(string $varname):void` 恢复指定的配置选项到它的原始值。

```php
//限制可访问目录，避免恶意修改
ini_set('open_basedir',__DIR__);//仅在当前页面中应用该配置，不影响PHP.ini配置文件中设置，页面结束后就无效了。
echo ini_get('open_basedir'),'<br>';
ini_set('max_file_uploads','30');//设置无效
echo ini_get('max_file_uploads'),'<br>';
```

> **补充:** 本以为可以设置文件上传相关配置，经测试发现无效，查 PHP 官方只有可修改范围是 PHP_INI_ALL 才可以被 ini_set 修改。就当了解知道吧。

> **与目录或文件相关的函数:** PHP 内置大量的文件系统操作函数,在一篇类的自动加载时已经介绍过了 is_file 和 file_exists 函数，下面再介绍与上传文件相关的函数
>
> - 目录相关的函数:`is_dir()`判断给定文件名是否是一个目录,如果文件名存在，并且是个目录返回 true，否则返回 false。`opendir()、 closedir()、readdir()和rewinddir()`对目录进行遍历。`rmdir()`删除目录,`mkdir`新建目录。

```php
/**
 * 遍历出所有文件或文件夹
 * @access public
 * @param string $dira 要遍历的文件夹名
 * @return array
 */
function traverseDir( $dira ) {
	$arr = array();
	if ( $dh = opendir( $dira ) ) {
		while ( ( $file = readdir( $dh ) ) !== false ) {
			if ( ( $file != '.' ) && ( $file != '..' ) && is_dir( $dira . '/' . $file ) ) {
				$arr[] = $dira . '/' . $file;
				foreach ( traverseDir( $dira . '/' . $file ) as $v ) {
					$arr[] = $v;
				}
			}
			clearstatcache();
		}
	}
	return $arr;
}
printf("<pre>%s<pre>",print_r(traverseDir('F:/120910'),true));
```

> - 文件相关的函数: 判断就是 is_file 和 file_exists 两个函数了。`copy()`复制文件，如果目标文件已存在，将会被覆盖。这里重点说下对上传临时文件的操作函数即`tmp_name`键名的临时文件
>   - `getimagesize(临时文件)` 检验是否真实图片，可防止修改扩展名伪装图片
>   - `is_uploaded_file(临时文件)` 判断文件是否是通过 HTTP POST 上传的，如果 filename 所给出的文件是通过 HTTP POST 上传的则返回 true。这可以用来确保恶意的用户无法欺骗脚本去访问本不能访问的文件，例如`/etc/passwd`。
>   - `move_uploaded_file(临时文件，目标文件` 将上传的文件移动到新位置。

```php
if (!getimagesize($fileInfo['tmp_name']))  die('不是真实图片,get out~');
if (!is_uploaded_file($fileInfo['tmp_name'])) die('上传方式错误:请使用http post方式上传');
if (!move_uploaded_file($fileInfo['tmp_name'], $fileRealPath)) die('文件上传失败');
```

> - 路径相关的函数:
>   - `basename(string $path[,string $suffix]):string`给出一个包含有指向一个文件的全路径的字符串，本函数返回基本的文件名。
>   - `dirname(string $path[,int $levels = 1]):string`给出一个包含有指向一个文件的全路径的字符串，本函数返回去掉文件名后的目录名，且目录深度为 levels 级。
>   - `pathinfo(string $path[,int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME ]):mixed`返回一个关联数组包含有 path 的信息。返回关联数组还是字符串取决于 options。本函数检查并确保由 filename 指定的文件是合法的上传文件(即通过 PHP 的 HTTP POST 上传机制所上传的)。如果文件合法，则将其移动为由 destination 指定的文件。

```php
// 路径
echo basename("/etc/sudoers.d").PHP_EOL;
echo basename("/etc/sudoers.d", ".d").PHP_EOL;//如果文件名是以第二个参数结束的，那这一部分也会被去掉
echo dirname("/etc/passwd") . PHP_EOL;
echo dirname("/usr/local/lib", 2). PHP_EOL;//第二个参数指示深度(PHP7.0开始支持)
$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
echo $path_parts['dirname'].PHP_EOL;      //返回/www/htdocs/inc
echo $path_parts['basename'].PHP_EOL;     //返回lib.inc.php
echo $path_parts['extension'].PHP_EOL;    //返回php
echo $path_parts['filename'].PHP_EOL;     //返回lib.inc
```

## 二、PHP(多)文件上传前端的实现

### 1、功能和源码

> **功能描述:**
>
> - 可选择一个文件，也可选择多个文件
> - 若选择文件是图片则提供预览功能
> - 对选择文件可进行上传服务端

```html
<style>
  .container {
    width: 70vw;
    min-width: 600px;
    margin: 3em auto;

    background-color: #007d20;
    color: white;
    font-size: 1.1em;

    padding: 0.5em 1em 3em;
    border-radius: 1em;
  }
  .container h2 {
    text-align: center;
    margin: 0;
    padding: 0;
    border: none;
  }
  form fieldset {
    display: flex;
    justify-content: space-between;
  }
  form fieldset#image {
    flex-flow: row wrap;
    justify-content: initial;
    /* flex其实也有弹性单元的概念，不过这不是官方的说法，它的提出是我学习Grid时发现的，只是它是交叉方向的，不设置默认是拉伸stretch */
    /* 在项目中若不设置，则图片宽度和高度都一样，这样有的图片就被拉伸了，不是按图片比例缩放 */
    align-items: center;
  }
  form fieldset#image img {
    margin: 5px 10px;
  }
</style>
<div class="container">
  <h2>PHP实现的(多)文件上传</h2>
  <form action="upload.php" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>选择上传文件</legend>
      <input type="file" id="file" name="js_file[]" multiple />
      <button>上传服务器</button>
    </fieldset>
    <fieldset id="image" style="display: none;"></fieldset>
  </form>
</div>
<script>
  const file = document.querySelector('#file');
  const fdset = document.querySelector('#image');

  file.addEventListener('change', showImage, false);
  function showImage() {
    //   上传文件信息保存在input的DOM的files属性中
    let files = file.files;
    let imgArr = [];
    for (let item of Object.values(files)) {
      if (item.type.includes('image')) imgArr.push(item);
    }
    fdset.setAttribute('style', 'display:none;');
    if (imgArr.length > 0) {
      // 先清空内容再刷新
      fdset.setAttribute('style', 'display:block;');
      fdset.innerHTML = null;
      const legend = document.createElement('legend');
      legend.innerHTML = `准备上传${imgArr.length}张图片`;
      fdset.appendChild(legend);
      for (let [index, item] of imgArr.entries()) {
        const reader = new FileReader();
        reader.readAsDataURL(item);
        reader.onload = () => {
          const img = new Image();
          // const img=document.createElement('img');
          // reader.result为获取结果
          img.src = reader.result;
          img.width = '150';
          // 将用户选择的图片显示到指定元素中
          fdset.appendChild(img);
        };
      }
    }
  }
</script>
```

### 2、前端图片的预览

MDN 官方介绍：`FileReader 对象允许Web应用程序异步读取存储在用户计算机上的文件（或原始数据缓冲区）的内容，使用 File 或 Blob 对象指定要读取的文件或数据。其中File对象可以是来自用户在一个<input>元素上选择文件后返回的FileList对象,也可以来自拖放操作生成的 DataTransfer对象,还可以是来自在一个HTMLCanvasElement上执行mozGetAsFile()方法后返回结果。 重要提示： FileReader仅用于以安全的方式从用户（远程）系统读取文件内容 它不能用于从文件系统中按路径名简单地读取文件。 要在JavaScript中按路径名读取文件，应使用标准Ajax解决方案进行服务器端文件读取，如果读取跨域，则使用CORS权限。`

input 控件的上传的 FileList 保存了文件名，没有保存路径，读取只能通过 FileReader，然后通过`readAsDataURL`读取指定的 Blob 或 File 对象,成功时返回结果中 result 属性将包含一个`data:URL`格式的字符串（base64 编码）以表示所读取文件的内容。然后加载给 img 的 src，在 js 中`new Image()`也可以创建 HTMLImageElement，或直接`document.createElement('img')`创建，上面代码中二种形式均支持，而且 img 元素比较特殊，既支持路径名的图片，也支持图上的 base64 编码。

上面图片预览代码是在老师演示代码基础上进行了改进：

- 图片 HTMLImageElement 创建，老师演示是`new Image()`，我增加了`document.createElement('img')`，二者经测试是等效的
- 多张图片是 Flex 布局，由于其默认等高，只设置了宽度，图片并不会等比例缩放,需要在 CSS 中设置`align-items:center;`。关于 Flex 弹性单元的概念，首先它不是官方的，但确实存在的，是我通过 Grid 相对提出的，具体可见<https://www.php.cn/blog/detail/24670.html>
- 上面演示的是实时添加 DOM，本想使用文档片断(DocumentFragment)来优化加载渲染，但由于图片是异步加载的，目前没解决，以后再探讨吧

## 三、PHP(多)文件上传后端的实现

### 1、功能和源码

> **功能描述:**
>
> - 可处理单文件或多文件上传
> - 对文件上传失败可提供详细信息
> - 若是图片则检查是否真实图片，并检查扩展名
> - 检查文件大小是否超过限制，默认是 2M
> - 检查文件上传是否是 POST
> - 可检查文件的扩展名
> - 对文件名进行散列 md5 处理
> - 结合数据库可解决重复文件上传问题，若是重复则直接返回已经上传的路径(这个当前没提供,可通过 Hash 判断文件是否上传)

```php
// upload.php
require_once __DIR__.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'helper.php';
$files=upload();
$res=[];
foreach($files as $file){
    array_push($res,uploadFile($file,false));
}
var_dump($res);
```

```php
// lib/helper.php
// 对客户端上传的单文件或多文件进行分析处理
// 返回的数组是上传文件信息，若只有一个则只有一个成员，若是多个则多个成员
function upload()
{
    $files = [];
    foreach ($_FILES as $file) {
        foreach ($file['name'] as $k => $v) {
            $name = $v;
            $type = $file['type'][$k];
            $tmp_name = $file['tmp_name'][$k];
            $error = $file['error'][$k];
            $size = $file['size'][$k];
            array_push($files, compact('name', 'type', 'tmp_name', 'error', 'size'));
        }
    }
    return $files;
}

// 完成文件上传
function uploadFile($file, $flag = true, $path = './upload', $ext = [], $maxSize = 2 * 1024 * 1024)
{
    // 先处理内置错误
    switch ($file['error']):
        case 0:
            break;
        case 1:
            $res['msg'] = '文件大小超过PHP.ini中upload_max_filesize指定的值';
            break;
        case 2:
            $res['msg'] = '文件大小超过表单中MAX_FILE_SIZE指定的值';
            break;
        case 3:
            $res['msg'] = '文件只有部分被上传';
            break;
        case 4:
            $res['msg'] = '没有文件被上传';
            break;
        case 6:
            $res['msg'] = '找不到临时文件夹';
            break;
        case 7:
            $res['msg'] = '文件写入失败';
            break;
        default:
            $res['msg'] = '系统错误';
    endswitch;

    // 处理后端自定义错误
    // 获取文件扩展名
    $extFile = substr($file['name'], strrpos($file['name'], '.') + 1);
    // 若是图片则判断是否真实图片和扩展名
    if ($flag) {
        $extImg = ['jpg', 'jpeg', 'png', 'wbmp', 'gif'];
        // 若是图片则返回数组，否则是false
        if (!getimagesize($file['tmp_name']))
            $res['msg'] = '不是合法的图片';
        if (!in_array($extFile, $extImg))
            $res['msg'] = '非法图片类型';
    }
    // 判断大小是否超过限制2M
    if ($file['size'] > $maxSize)
        $res['msg'] = '文件大小超过2M，请确保文件小于2M';
    // 判断是否POST上传
    if (!is_uploaded_file($file['tmp_name']))
        $res['msg'] = '文件不是通过HTTP POST上传';
    // 若设置扩展名，则检查文件类型
    if (count($ext) > 0) {
        if (!in_array($extFile, $ext))
            $res['msg'] = '非法文件类型';
    }

    if (!file_exists($path)) {
        if (!mkdir($path, 0777, true))
            $res['msg'] = '服务端禁止上传文件';
        chmod($path, 0777);
    }

    // 拦截用户定义的错误
    if ($res) return $res;

    // 成功则移动
    if ($file['error'] === 0) {
        $newPath = $path . DIRECTORY_SEPARATOR . md5(substr($file['name'], 0, strrpos($file['name'], '.'))) . '.' . $extFile;
        $res['msg'] = '上传文件失败';
        if (move_uploaded_file($file['tmp_name'], $newPath)) {
            $res['msg'] = '上传文件成功';
            $res['path'] = $newPath;
        }
    }
    return $res;
}

```

### 2、多维数组的提取

在上例代码中对多文件上传时分析处理，我基本是按照老师方式遍历多维数组的方式来提取，在细节上改进了一些。其实对二维数组某列的获取，PHP 提供了`array_column()`，如对上传文件`$_FILES`，可以是如下形式，不过唯一不足就是每个上传文件信息变成索引数组了，不过和上面关联数组是一一对应的，不影响读取。

```php
function upload()
{
    $files = [];
    foreach ($_FILES as $file) {
        foreach ($file['name'] as $k => $v) {
            array_push($files, array_column($file,$k));
        }
    }
    return $files;
}
```

### 3、对上传文件状态检查

这点我和老师基本思路是一样的，就是先检查内部定义的错误，后处理用户自定义的检查(包括是否真实图片、大小、上传方式和扩展名等)，若有错误则返回，没有则从临时文件夹移动到指定的位置，并返回所有上传文件的状态信息。在一些细节方面进行了改进。

- 对文件名的获取，老师只考虑普通的情况，可能文件名是`page_new_23.my.img.jpg`时，有多个点时，老师使用`array_shift()`获取文件名就不完整，我的解决方案是`(substr($file['name'], 0, strrpos($file['name'], '.'))`，可避免老师提取文件名不全的问题

- 对内部定义的错误的处理，我是当`error`为0时，直接`break`跳出switch的分支语句。

- 对扩展名的检查不再局限于图片，毕竟上传不仅仅是图片，其它文件也需要检查扩展名，通过判断是否定义扩展名来决定是否检查扩展名。

- 我的现在项目中对上传文件还会检查是否已经上传，是通过Hash文件来判断，可在数据库中保存上传文件的Hash信息，每次上传会进行判断，若已经上传则直接返回已经上传地址。这里我就不实现了，思路已经提供了，这里只是演示文件上传功能。
