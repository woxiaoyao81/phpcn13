<?php
// 二维数组来模拟数据表的查询结果
$users = [
    ['id' => 1, 'name' => '天蓬大人', 'age' => 66],
    ['id' => 2, 'name' => '灭绝师妹', 'age' => 55],
    ['id' => 3, 'name' => '西门老妖', 'age' => 44],
];

// $_REQUEST: 相当于 $_GET + $_POST + $_COOKIE 三合一
if (in_array($_REQUEST['id'], array_column($users, 'id'))) {
    foreach ($users as $user) {
        if ($user['id'] == $_REQUEST['id']) {
            // vprintf(输出模板, 数组表示的参数)
            vprintf('%s: %s %s岁', $user);
            // 以下语句配合$.getJSON()调用,其它请求时请注释掉
            //  echo  json_encode($user);
        }
    }
} else {
    die('<span style="color:red">没找到</span>');
}
