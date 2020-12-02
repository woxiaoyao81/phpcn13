<?php
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    setcookie('token');
    session_unset();
    session_destroy();
}

?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录</title>
    <style>
        .container {
            width: 30em;
            margin: 2em auto;
            border-radius: 1em;
            background-color: #007d20;
            color: white;
            padding: 0.2em 0.5em 1em;
            text-align: center;
        }

        form {
            display: grid;
            grid-template-columns: 5em 1fr;
            grid-template-rows: repeat(4, 2em);
            place-items: center initial;
            gap: 0.5em;
        }

        form>button {
            grid-column: 2/3;
        }

        form>input[type="checkbox"] {
            width: 2em;
            height: 2em;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>用户登录</h3>
        <form action="check.php" method="post">
            <label for="email">用户名:</label>
            <input type="text" name="username" id="email" placeholder="输入用户名" required autofocus>
            <label for="password">密码:</label>
            <input type="password" name="password" id="password" placeholder="密码不少于6位" required>
            <label for="autoLogin">自动登录</label>
            <input type="checkbox" name="autoLogin" id="autoLogin">
            <button>提交</button>
        </form>
    </div>
</body>

</html>