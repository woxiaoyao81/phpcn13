<?php

function isAssoc(array $arr)
{
    if (is_array($arr)) {
        $key = array_keys($arr);
        return $key === array_keys($key) ? false : true;
    }
    return null;
}

// $arr=[1,2,3,4,5,6];
$arr = ['asd', 2, 3, 4];
// $arr = array('name' => 'xiaoyao','pwd'=>'3234234');
// var_dump(array_keys($arr));
// var_dump(array_keys(array_keys($arr)));
// var_dump(isAssoc($arr));


$data = array('name' => 'xiaoyao','pwd'=>'3234234');
$where=array('name'=>'woxiaoyao');
$sql = "update user set ";
$str = "";
foreach (array_keys($data) as $column) {
    $str .= $column . " = ?,";
}
$sql .= substr($str, 0, -1);
$str = "";
foreach (array_keys($where) as $item) {
    $str .= " " . $item . " = ? and";
}
$sql .= " where " . substr($str, 0, -4);
echo $sql;
