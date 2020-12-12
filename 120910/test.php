<?php
// 学习PHP与文件上传相关的函数

// 1、与php.ini相关的。我们知道修改php.ini后要重启服务，但修改配置一般是某些页面需求，再者一般也不建议随意修改php.ini的配置文件
// PHP提供了ini为前缀的函数，修改配置仅对当前页面有效，页面释放后就无效了，非常适合我们平常使用。
//限制可访问目录，避免恶意修改
ini_set('open_basedir', __DIR__); //仅在当前页面中应用该配置，不影响PHP.ini配置文件中设置，页面结束后就无效了。
echo ini_get('open_basedir'), '<br>';
ini_set('max_file_uploads', '30'); //设置无效
echo ini_get('max_file_uploads'), '<br>';


// 2、目录或文件相关函数
// 遍历出所有文件或文件夹
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
// 文件

// 路径
echo basename("/etc/sudoers.d"), '<br>';
echo basename("/etc/sudoers.d", ".d"), '<br>'; //如果文件名是以第二个参数结束的，那这一部分也会被去掉
echo dirname("/etc/passwd"), '<br>';
echo dirname("/usr/local/lib", 2), '<br>'; //第二个参数指示深度(PHP7.0开始支持)
$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
echo $path_parts['dirname'], '<br>';      //返回/www/htdocs/inc
echo $path_parts['basename'], '<br>';    //返回lib.inc.php
echo $path_parts['extension'], '<br>';    //返回php
echo $path_parts['filename'], '<br>';     //返回lib.inc


