<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>分页数据</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;

            display: inline-block;
            /* width: 2em; */
            height: 2em;
            line-height: 2em;
        }

        .container {
            width: 60vw;
            margin: 1em auto;
        }

        td {
            text-align: center;
        }

        .page {
            margin-top: 1em;
            text-align: center;
        }

        td a:first-child {
            margin-right: 5px;
        }

        td a:last-child {
            margin-left: 5px;
        }

        .page a {
            padding: 0 0.5em;
            margin: 0 5px;
        }

        .page a.cur {
            background-color: #007d20;
            color: white;
        }
    </style>
</head>

<body>
<div class="container">
    <table border='1' cellspacing="0" width="100%">
    <caption>用户信息表</caption>
        <thead>
            <tr bgColor="lightgray">
                <th>ID</th>
                <th>name</th>
                <th>password</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once 'pagnate.php';
            foreach ($users as $user) {
                $trdata = "<tr>";
                foreach ($user as $item) {
                    $trdata .= "<td>{$item}</td>";
                }
                $trdata .= "<td><a href='#'>编辑</a><a href='#'>删除</a></td>";
                $trdata .= "</tr>";
                echo $trdata;
            }
            ?>
        </tbody>
    </table>
    <div class="page">
        <?php
        echo "<a href='{$_SERVER["PHP_SELF"]}?p=1'>首页</a>";
        $prev = ($page - 1 > 1) ? ($page - 1) : 1;
        if ($page > 1)
            echo "<a href='{$_SERVER["PHP_SELF"]}?p={$prev}'>上一页</a>";
        for ($i = 1; $i <= $pages; $i++) :
            if ($i == $page)
                echo "<a class='cur' href='{$_SERVER["PHP_SELF"]}?p={$i}'>{$i}</a>";
            else
                echo "<a href='{$_SERVER["PHP_SELF"]}?p={$i}'>{$i}</a>";
        endfor;
        $next = ($page + 1) < $pages ? ($page + 1) : $pages;
        if ($page < $pages)
            echo "<a href='{$_SERVER["PHP_SELF"]}?p={$next}'>下一页</a>";
        echo "<a href='{$_SERVER["PHP_SELF"]}?p={$pages}'>未页</a>";
        ?>
    </div>
</div>
</body>

</html>