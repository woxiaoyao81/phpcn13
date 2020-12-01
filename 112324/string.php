<?php
// 一、PHP字符串相关操作
// 1、{}
$a = 'apple';
// $a[1]='b';
// $a{1}='c';
// echo $a{1};
// echo $a[1];

// 2、格式化输出
printf('Hello %s','World');
echo '<hr>';
vprintf('Hello %s,my age is %d',['World',28]);
echo '<hr>';
$sql = sprintf('SELECT * FROM `%s` LIMIT %d','users',11);
echo $sql;
echo '<hr>';
$sql = vsprintf('SELECT * FROM `%s` LIMIT %d',['users',11]);
file_put_contents('temp1.txt',$sql);

// 3、字符串和数组转换
// 数组转字符串
echo implode(',',['html','css','vuejs','uniapp']);
echo '<hr>';
echo join(',',['html','css','vuejs','uniapp']);
echo '<hr>';
// 字符串转数组，explode第三个参数是指定数组的成员个数,若个数大于字符串个数时，则无效，若小于时，则大于的合并成一个成员
print_r(explode(',','localhost,root,root,utf8,3306',4));
echo '<hr>';
print_r(explode(',','localhost,root,root,utf8,3306',5));
echo '<hr>';
print_r(str_split('php中文网',3));
echo '<hr>';

// 4、大小写转换和移除字符串两侧的空白字符
// 大写是strtoupper,小写是strtolower
// trim是移除两侧空白字符，要注意若是转义字符时要用双引号，若是单引号则算成两个字符，不是转义字符，移除无效
$str1="\n\n\nHello World  !\n\n\n";
$str2='\n\n\nHello World  !\n\n\n';
echo strlen(trim($str1)).','.strlen(trim($str2));
echo '<hr>';

// 5、查找、取子串、替换和比较
echo strpos('AbCDef123asdf','as');
echo strstr('AbCDef123asdf','as',true);
echo substr('AbCDef123asdf',-3);
echo '<hr>';

echo strcmp("2Hello world!","10Hello world!");
echo '<hr>';
echo strnatcmp("2Hello world!","10Hello world!");

// find和replace可以是字符串，也可以是数组
echo str_replace('转账','**','微信转账,支付宝转账',$count),'<br>';
$search = ['交友','广告','直播','带货'];
echo str_replace($search,['***','===','&&&','+++'],'广告代理,直播教学,免费带货,异性交友'),'<br>';

// 6、求字符串长度strlen和mb_strlen
echo mb_strlen('中国人123','utf-8'),'<br>';
echo mb_strlen('中国人','gb2312'),'<br>';
echo strlen('中国人123'),'<br>';
