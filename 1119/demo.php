<?php
// $a=3;
// $b=4;
// echo "$a",'<br>';
// echo "{$a}+{$b}=".($a+$b),'<br>';
// PHP中双引号不支持表达式运算
// echo "{$a}+{$b}={$a+$b}";

// echo ``;
// var_dump(``);
// var_dump(`123`);
// var_dump('123`123`12');
// var_dump("123`123`12");

// 报错
// var_dump(`1`'23`123`12');
// $outExe = `C:\Windows\write.exe`;
// $outExe = shell_exec('C:\Windows\write.exe');
// var_dump($outExe);

// 判断闰年
// $year = date('Y');
// if ($year % 4 === 0 && $year % 100 !== 0) :
//     echo "{$year}是闰年",'<br>';
// else:
//     echo "{$year}不是闰年";
// endif;
// // 限制随机数范围
// $res=mt_rand()%21;
// echo $res;

// $a='5';
// $b=4;
// $res=$a<=>$b;
// echo $res;

$hour = date("H");
if ($hour < 6):
    echo '凌晨好,主人~';
    echo '凌晨好,主人~';
elseif ($hour < 9):
    echo '早上好,主人~';
    echo '早上好,主人~';
elseif ($hour < 12):
    echo '中午好,主人~';
    echo '中午好,主人~';
elseif ($hour < 17):
    echo '下午好,主人~';
    echo '下午好,主人~';
elseif ($hour < 19):
    echo '傍晚好,主人~';
    echo '傍晚好,主人~';
elseif ($hour < 22):
    echo '晚上好,主人~';
    echo '晚上好,主人~';
else:
    echo '别熬夜了!你头发没了~';
    echo '别熬夜了!你头发没了~';
endif;
