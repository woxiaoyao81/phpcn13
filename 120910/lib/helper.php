<?php
// 对客户端上传的单文件或多文件进行分析处理
// 返回的数组是上传文件信息，若只有一个则只有一个成员，若是多个则多个成员
function upload()
{
    $files = [];
    foreach ($_FILES as $file) {
        foreach ($file['name'] as $k => $v) {
            $name = $v;
            $type = $file['type'][$k];
            $tmp_name = $file['tmp_name'][$k];
            $error = $file['error'][$k];
            $size = $file['size'][$k];
            array_push($files, compact('name', 'type', 'tmp_name', 'error', 'size'));
        }
    }
    return $files;
}

// 完成文件上传
function uploadFile($file, $flag = true, $path = './upload', $ext = [], $maxSize = 2 * 1024 * 1024)
{
    // 先处理内置错误
    switch ($file['error']):
        case 0:
            break;
        case 1:
            $res['msg'] = '文件大小超过PHP.ini中upload_max_filesize指定的值';
            break;
        case 2:
            $res['msg'] = '文件大小超过表单中MAX_FILE_SIZE指定的值';
            break;
        case 3:
            $res['msg'] = '文件只有部分被上传';
            break;
        case 4:
            $res['msg'] = '没有文件被上传';
            break;
        case 6:
            $res['msg'] = '找不到临时文件夹';
            break;
        case 7:
            $res['msg'] = '文件写入失败';
            break;
        default:
            $res['msg'] = '系统错误';
    endswitch;

    // 处理后端自定义错误
    // 获取文件扩展名
    $extFile = substr($file['name'], strrpos($file['name'], '.') + 1);
    // 若是图片则判断是否真实图片和扩展名
    if ($flag) {
        $extImg = ['jpg', 'jpeg', 'png', 'wbmp', 'gif'];
        // 若是图片则返回数组，否则是false
        if (!getimagesize($file['tmp_name']))
            $res['msg'] = '不是合法的图片';
        if (!in_array($extFile, $extImg))
            $res['msg'] = '非法图片类型';
    }
    // 判断大小是否超过限制2M
    if ($file['size'] > $maxSize)
        $res['msg'] = '文件大小超过2M，请确保文件小于2M';
    // 判断是否POST上传
    if (!is_uploaded_file($file['tmp_name']))
        $res['msg'] = '文件不是通过HTTP POST上传';
    // 若设置扩展名，则检查文件类型
    if (count($ext) > 0) {
        if (!in_array($extFile, $ext))
            $res['msg'] = '非法文件类型';
    }

    if (!file_exists($path)) {
        if (!mkdir($path, 0777, true))
            $res['msg'] = '服务端禁止上传文件';
        chmod($path, 0777);
    }

    // 拦截用户定义的错误
    if ($res) return $res;

    // 成功则移动
    if ($file['error'] === 0) {
        $newPath = $path . DIRECTORY_SEPARATOR . md5(substr($file['name'], 0, strrpos($file['name'], '.'))) . '.' . $extFile;
        $res['msg'] = '上传文件失败';
        if (move_uploaded_file($file['tmp_name'], $newPath)) {
            $res['msg'] = '上传文件成功';
            $res['path'] = $newPath;
        }
    }
    return $res;
}
