<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: woxiaoyao
 * @Date: 2020-12-12 06:52:43
 * @LastEditTime: 2020-12-12 11:07:39
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'helper.php';

// $files=upload();

// $res=[];
// foreach($files as $file){
//     array_push($res,uploadFile($file,false));
// }

// var_dump($res);

$files = [];
foreach ($_FILES as $file) {
    foreach ($file['name'] as $k => $v) {
        array_push($files, array_column($file, $k));
    }
}
var_dump($files);
