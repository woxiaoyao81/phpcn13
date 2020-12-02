<?php
session_start();
extract($_POST);
// 1、检查是否有用户信息
if (empty($username) || empty($password)) {
    exit("
    <script>
        alert('非法登录');
        location.href='login.php';
    </script>
");
}
$password = md5($password);
$salt = 'woxiaoyao';
// 2、查询数据库，看用户名和密码是否正确
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
$stmt = $pdo->prepare('SELECT uname,pwd,id FROM user where uname = ? and pwd = ?;');
$stmt->execute(array($username, $password));
$res = $stmt->fetch(PDO::FETCH_ASSOC);
if ($stmt->rowCount() == 1) {
    // 3、若勾选了自动登录则记录用户信息
    if ($autoLogin == 'on') {
        $token = md5($res['id'] . $res['pwd'] . $salt) . time();        
        setcookie('token', $token, time() + 60 * 60 * 24 * 7);
        $_SESSION['token'] = $token;
        $_SESSION['id'] = $res['id'];
        $_SESSION['pwd'] = $res['pwd'];
    } else {
        // 4、否则清除cookie和session
        setcookie('token');
        session_unset();
        session_destroy();
    }
    exit("
        <script>
            location.href='index.php';
        </script>
    ");
} else {
    exit("
        <script>
            alert('用户名和密码不正确');
            location.href='login.php';
        </script>
    ");
}
