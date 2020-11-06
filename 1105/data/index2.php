<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: woxiaoyao
 * @Date: 2020-11-06 13:58:58
 * @LastEditTime: 2020-11-06 14:21:29
 */

//  第一种：以键-值对方式
// $data=key($_POST);
// echo $data;
// echo json_encode($data);

// 第二种：以json方式
// 以字节流方法进行接收
// $data = file_get_contents('php://input');
// echo $data;
// json 转为  php 对象来处理
// $user = json_decode($data);
// print_r($user);

// $user = json_decode($data, true);
// print_r($user);

// 第三种:FormData对象方式
echo json_encode($_POST);