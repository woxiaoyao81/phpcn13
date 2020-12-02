<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: woxiaoyao
 * @Date: 2020-12-02 10:20:58
 * @LastEditTime: 2020-12-02 13:28:06
 */
session_start();
// $_SESSION['name']='woxiaoyao';
// $_SESSION['pwd']=md5('123456');
var_dump($_SESSION);
// 旧的注销某变量方法session_unregister，在现在已经放弃了
// session_unregister('name');
// 注释某个session变量方法是unset
// unset($_SESSION['name']);
// 释放当前会话中所有session变量和文件
// session_unset();
// session_destroy();