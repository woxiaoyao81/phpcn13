<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP版计算器</title>
<style>
    :root {
        font-size: 1.1em;
    }

    form {
        margin: 1em auto;
    }

    input {
        width: 12em;
        height: 1.2em;
    }

    select {
        width: 5em;
    }
</style>
</head>

<body>
<?php
error_reporting(E_ALL & ~E_NOTICE);
$messageArr = [];
$result = "";
if (!empty($_POST)) :
    // 第一步:采用过滤函数过滤输入
    $argFilter = array(
        "num1" => array("filter" => FILTER_VALIDATE_INT),
        "num2" => array("filter" => FILTER_VALIDATE_INT),
        "opt" => array("filter" => FILTER_VALIDATE_INT, "options" => array("min_range" => 0, "max_range" => 4)),
        "calc" => FILTER_SANITIZE_ENCODED,
    );
    $inputs = filter_input_array(INPUT_POST, $argFilter);
    // var_dump($inputs);
    // 对检验结果反馈给用户
    if ($inputs['num1'] === false) array_push($messageArr, "第一个数不在许可范围内或不能为空");
    if ($inputs['num2'] === false) array_push($messageArr, "第二个数不在许可范围内或不能为空");
    if ($inputs['opt'] === 3 && $inputs['num2'] === 0) array_push($messageArr, "除法时，除数不能为0");
    if (!empty($messageArr)) :
        foreach ($messageArr as $message) :
            echo "<p><span style='color:red'>错误警告:</span>{$message}</p>";
        endforeach;
    else :
        // 一切检验通过后，正常运算
        switch ($inputs['opt']):
            case 1:
                $result = "{$inputs['num1']} - {$inputs['num2']} = " . ($inputs['num1'] - $inputs['num2']);
                break;
            case 2:
                $result = "{$inputs['num1']} * {$inputs['num2']} = " . ($inputs['num1'] * $inputs['num2']);
                break;
            case 3:
                $result = "{$inputs['num1']} / {$inputs['num2']} = " . ($inputs['num1'] / $inputs['num2']);
                break;
            case 4:
                $result = "{$inputs['num1']} % {$inputs['num2']} = " . ($inputs['num1'] % $inputs['num2']);
                break;
            default:
                $result = "{$inputs['num1']} + {$inputs['num2']} = " . ($inputs['num1'] + $inputs['num2']);
        endswitch;
    endif;
endif;
?>
<form action="" method="post">
    <label for="num1">第一个数:</label>
    <input type="num" size="4" name="num1" value="<?php echo $_POST['num1']; ?>" id="num1" placeholder="输入0到10000之间的数">
    <select name="opt" id="opt">
        <option value="0" <?php echo $_POST['opt'] == '0' ? 'selected' : '' ?>>加</option>
        <option value="1" <?php echo $_POST['opt'] == '1' ? 'selected' : '' ?>>减</option>
        <option value="2" <?php echo $_POST['opt'] == '2' ? 'selected' : '' ?>>乘</option>
        <option value="3" <?php echo $_POST['opt'] == '3' ? 'selected' : '' ?>>除</option>
        <option value="4" <?php echo $_POST['opt'] == '4' ? 'selected' : '' ?>>取余数</option>
    </select>
    <label for="num2">第二个数:</label>
    <input type="num" size="4" name="num2" value="<?php echo $_POST['num2']; ?>" id="num2" placeholder="输入0到10000之间的数">
    <button name="calc" value="calc">计算</button>
</form>
<p>计算结果:<span style="color:green;"><?php echo empty($result) ? '' : $result; ?></span></p>
</body>

</html>