<?php
session_start();
// 1、检测cookie中是否存在token
if (!isset($_COOKIE['token'])) {
  exit("
        <script>
            alert('请您先登录');
            location.href='login.php';
        </script>
    
    ");
}

// 2、检测token是否过期
$tokentime = intval(substr($_COOKIE['token'], -10));
if (time() - $tokentime > 60 * 60 * 24 * 7) {
  exit("
        <script>
            alert('登录已过期，请重新登录');
            location.href='login.php';
        </script>    
    ");
}

// 3、检测token是否非法
$servertoken = $_SESSION['token'];
if ($servertoken != $_COOKIE['token']) {
  exit("
        <script>
            alert('非法令牌，请重新登录');
            location.href='login.php';
        </script>    
    ");
}

// 4、在session读取用户名id和密码
$id = $_SESSION['id'];
$pwd = $_SESSION['pwd'];

// 5、从数据库中读取用户信息
$salt = 'woxiaoyao';
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
$stmt = $pdo->prepare('SELECT uname,pwd,id FROM user where id = ? and pwd = ?;');
$stmt->execute(array($id, $pwd));
$res = $stmt->fetch(PDO::FETCH_ASSOC);
if ($stmt->rowCount() < 1) {
  exit("
  <script>
      alert('用户不存在，请重新登录或注册');
      location.href='login.php';
  </script>    
");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>首页</title>
  <style>
    nav {
      height: 40px;
      background-color: deepskyblue;
      padding: 0 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav>a {
      color: white;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <nav>
    <a href="index.php">简书后台管理</a>
    <a href="" id="logout">
      <span style="color: yellow;"> 欢迎您<?php echo $res['uname']; ?></span> |
      退出</a>
  </nav>

  <script>
    document
      .querySelector("#logout")
      .addEventListener("click", function(ev) {
        // 禁用链接跳转行为
        ev.preventDefault();
        // 询问用户是否退出，并执行对应操作
        if (confirm("是否退出?"))
          window.location.assign("login.php?action=logout");
      });
  </script>
</body>
</html>