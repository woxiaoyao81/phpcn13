<?php
// 普通函数改为闭包，此时外部变量可通过global、$GLOBALS，也支持use引入外部变量使用。具体分析见本文第一部分。
$isAssoc=function (array $arr)
{
    if (is_array($arr)) {
        $key = array_keys($arr);
        return $key === array_keys($key) ? false : true;
    }
    return null;
};//闭包函数最后的分号不可省，否则报错

class Check{
    // Closure就是闭包类型
    static function checkArray(Closure $isAssoc,array $arr){
        // 使用闭包时要记得()引用参数
        return $isAssoc($arr);
    }
}
$arr=[1,2,3,4,5,6];
var_dump(Check::checkArray($isAssoc,$arr));

// function isAssoc(array $arr)
// {
//     if (is_array($arr)) {
//         $key = array_keys($arr);
//         return $key === array_keys($key) ? false : true;
//     }
//     return null;
// }
// $arr=[1,2,3,4,5,6];
// $arr = ['asd', 2, 3, 4];
// $arr = array('name' => 'xiaoyao','pwd'=>'3234234');
// var_dump(array_keys($arr));
// var_dump(array_keys(array_keys($arr)));
// var_dump(isAssoc($arr));


// $data = array('name' => 'xiaoyao','pwd'=>'3234234');
// $where=array('name'=>'woxiaoyao');
// $sql = "update user set ";
// $str = "";
// foreach (array_keys($data) as $column) {
//     $str .= $column . " = ?,";
// }
// $sql .= substr($str, 0, -1);
// $str = "";
// foreach (array_keys($where) as $item) {
//     $str .= " " . $item . " = ? and";
// }
// $sql .= " where " . substr($str, 0, -4);
// echo $sql;
