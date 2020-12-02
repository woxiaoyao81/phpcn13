<?php
/**
 * 刷新浏览器才能获取cookie值
 * 服务端:
 * 第一步：解析setcookie("username","peter zhu");通过请求头告诉浏览器 我要设置一个cookie 值peter zhu
 * 第二步: 服务端返回信息,返回的信息头中带有set-cookie = peter zhu,浏览器接受到这个信息头,把cookie 储存在客户端计算机的某个文件中~ * 
 * 第三:刷新浏览器cookie中的信息会被带到请求头中发送,var_dump($_COOKIE['username']);就能成功
 */
// setcookie($name,$value,$expire);向客户端的计算机中设置cookie

// 存储字符串数据
setcookie('course','cookie');

// 存储数组型数据库
// setcookie('user[name]','woxiaoyao');
// setcookie('user[pwd]',md5('123456'));

// 读取cookie
var_dump($_COOKIE['user']);

// cookie时限
// 一旦设置时限，此时cookie就会保存到本地文件中?
setcookie('token',sha1('123123123123123123123'),time()+60*60*24*7);

// 清除cookie
// setcookie('token');

// 解决cookie存在特殊字符被转义使用setrawcookie()，使用和setcookie一样
setcookie('email','123123@qq.com');
setrawcookie('email2','123123@qq.com');



// header设置cookie
// header('Set-cookie:a=4');

// 在chrom浏览器中Cookies实际上是一个sqlite数据库文件,可以直接打开查看,chrome位置C:\Users\xxx\AppData\Local\Google\Chrome\User Data\Default
// 一般数据库名为main,有两个表cookie和meta