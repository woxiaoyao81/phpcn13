<?php
// 抽奖
/* 
一、面向过程思路
1.设置奖品数组
2.准备抽奖的号码，为降低好的中奖率，增加次中奖率，准备号码个数是比例递增的，如比例是10，即1个一等，10个二等，100个三等...,本例为了简化设置为2
3.用户抽奖
*/

// require_once 'var-function.php';

$prizes = ['电脑', '手机', '平板', '耳机', '笔', '抽纸'];

$numbers = [];
$count = 1;
for ($i = 0; $i < count($prizes); $i++) :
    if ($i > 0)
        $count *= 2;
    $numbers=array_merge(array_fill(0, $count, $i),$numbers);
endfor;

$id=$numbers[mt_rand(0,count($numbers))];
echo $prizes[$id];

var_dump(function_exists('sum'));

/*
二、面向对象思路
*/