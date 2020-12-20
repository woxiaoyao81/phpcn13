<?php 
require_once 'vendor/autoload.php';

use Gregwar\Captcha\CaptchaBuilder;
$builder = new CaptchaBuilder;
$builder->build();
$builder->save('out.jpg');
// 测试类加载
function sum($a,$b){
    return $a+$b;
}

echo 'Hello World \n';
echo '<hr>';
echo "Hello World \n";


