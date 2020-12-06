<?php
namespace woxiaoyao;
use Exception;
use PDO;

// 接口：定义规范
interface iDb
{
    static function select(PDO $db, array $where);
    static function insert(PDO $db, array $data);
    static function update(PDO $db, array $data, array $where);
    static function delete(PDO $db, array $where);
}

// 中间类：抽象类，准备资源
abstract class aDb
{
    // 使用单例模式连接:创建类的唯一实例,唯一对象
    protected static $db = null;
    static function connect($dsn, $username, $pwd)
    {
        if (is_null(self::$db))
            self::$db = new PDO($dsn, $username, $pwd);
        return self::$db;
    }

    // 判断是关联数组或索引数组
    protected function isAssoc(array $arr)
    {
        if (is_array($arr)) {
            $key = array_keys($arr);
            return $key === array_keys($key) ? false : true;
        }
        return null;
    }

    // AOP：统一检查
    protected function check(array $arr)
    {
        if (is_null($this->isAssoc($arr))) {
            throw new Exception("插入数据不是数组");
        } else {
            if ($this->isAssoc($arr)) {
                return true;
            } else {
                throw new Exception("插入数据不是关联数组");
            }
        }
    }    
}

// 工作类(实现类)：实现接口规范
class Db extends aDb implements iDb
{
    // 查询
    static function select(PDO $db, array $where)
    {
        $that = new Db();
        if ($that->check($where) === true) {
            $sql = "select * from user where ";
            $str = "";
            $keys = array_keys($where);
            foreach ($keys as $key) {
                $str .= " " . $key . " = ? and";
            }
            $sql = $sql . substr($str, 0, -4);
            $stmt = $db->prepare($sql);
            $stmt->execute(array_values($where));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // 插入
    static function insert(PDO $db, array $data)
    {
        $that = new Db();
        if ($that->check($data) === true) {
            $sql = "insert into user (" . implode(',', array_keys($data)) . ") values (" . implode(',', array_fill(0, count($data), '?')) . ")";
            $stmt = $db->prepare($sql);
            $stmt->execute(array_values($data));
            return $stmt;
        }
    }


    // 更新
    static function update(PDO $db, array $data, array $where)
    {
        $that = new Db();
        if (($that->check($data) === true) && ($that->check($where) === true)) {
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
            $stmt = $db->prepare($sql);
            $stmt->execute(array_merge(array_values($data), array_values($where)));
            return $stmt;
        }
    }

    // 删除
    static function delete(PDO $db, array $where)
    {
        $that = new Db();
        if ($that->check($where) === true) {
            $sql = "delete from user where ";
            $str = "";
            $keys = array_keys($where);
            foreach ($keys as $key) {
                $str .= " " . $key . " = ? and";
            }
            $sql .= substr($str, 0, -4);
            $stmt = $db->prepare($sql);
            $stmt->execute(array_values($where));
            return $stmt;
        }
    }
}

$dsn = "mysql:host=localhost;dbname=test";
$db = aDb::connect($dsn, 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// var_dump($db);

// 查询
// $where = ['uname' => 'xiaoyao'];
// print_r(Db::select($db, $where));

// 插入
$arr = array('uname' => 'woxiaoyao', 'pwd' => md5('123456'));
$stmt = Db::insert($db, $arr);
if ($stmt->rowCount() > 0) {
    echo "成功插入数据" . $stmt->rowCount() . "条";
} else {
    echo "插入失败:".print_r($stmt->errorInfo(),true);
}

// 更新
// $data = array('uname' => 'xiaoyao', 'pwd' => md5('123456'));
// $where = ['uname' => 'woxiaoyao'];
// $stmt = Db::update($db, $data, $where);
// if ($stmt->rowCount() > 0) {
//     echo "成功更新数据" . $stmt->rowCount() . "条";
// } else {
//     echo "更新失败:".print_r($stmt->errorInfo(),true);
// }

// 删除
// $where = ['uname' => 'xiaoyao'];
// $stmt = Db::delete($db, $where);
// if ($stmt->rowCount() > 0) {
//     echo "成功删除数据" . $stmt->rowCount() . "条";
// } else {
//     echo "删除失败:".print_r($stmt->errorInfo(),true);
// }
