<?php

declare(strict_types=1);

namespace WOXIAOYAO;

use \PDO;
use \Exception;

/*
 * @Descripttion: 自己封装的PDO类，可支持MySQL、MSSQL、ORACLE和SQLite的数据库操作
 * @version: 1.0.0
 * 准备要完成功能:1、支持PDO的query和exec(1.0.0)  2、支持PDO的预处理   3、支持PDO的事务处理
 * @Author: woxiaoyao
 * @Date: 2020-12-13 06:07:55
 * @LastEditTime: 2020-12-14 15:35:58
 */

//  准备知识:四种数据库连接方式
//  MySQL:'dsn'=>'mysql:host=localhost;dbname=talk','username'=>'root','password'=>'123456'
//  MSSQL:'dsn'=>'odbc:Driver={SQL Server};Server=192.168.1.60;Database=his','username'=>'sa','password'=>'xxxxx'
//  Oracle:'dsn'=>'oci:dbname=orcl','username'=>'BAOCRM','password'=>'BAOCRM'
//  SQLite:'dsn'=>'sqlite:'.dirname(__FILE__).'\log.db'

// 抽象类完成单例模式连接、准备处理方法和接口的定义
// 抽象类的保护静态成员为所有子类共享
abstract class aDb
{
    // 定义单例模式连接
    protected static $pdo = null;
    protected static $config = null;
    final protected function connect(array $config)
    {
        $config = array_change_key_case($config, CASE_LOWER);
        if ($config === false) throw new Exception('连接配置不是数组');
        if (empty($this->is_assoc($config))) throw new Exception('连接配置不是关联数组');
        if (empty(self::$config)) {
            self::$config = $config;
        } else if (!empty(array_diff_assoc(self::$config, $config))) {
            self::$config = $config;
        } else {
            return self::$pdo;
        }
        try {
            $pdo = new \PDO(self::$config['dsn'], self::$config['username'], self::$config['password']);
            // 若没报错则先清除旧连接，重置为新连接
            self::$pdo = null;
            self::$pdo = $pdo;
            self::$pdo->query("set names utf8");
            //属性名 属性值 数组以关联数组返回
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //把结果序列化成stdClass
            //$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (\Exception $e) {
            echo '数据库连接失败,详情: ' . $e->getMessage() . ' 请在配置文件中数据库连接信息';
            exit();
        }
    }

    // 判断是否是关联数组
    final protected function is_assoc(array $arr)
    {
        if (is_array($arr)) {
            $key = array_keys($arr);
            return $key === array_keys($key) ? false : true;
        }
        return null;
    }

    // 定义接口规范
    // 链式规范
    abstract public function table(string $table);
    abstract public function field(string $fields);
    abstract public function where($where);
    abstract public function order(string $order);
    abstract public function limit(string $limit);
    // 单条记录和多条记录查询
    abstract public function find();
    abstract public function select();
    // 插入、更新和删除规范
    abstract public function insert(array $data);
    abstract public function update(array $data);
    abstract public function delete();
}

// 工作类，实现CURD操作
class Db extends aDb
{
    private $res;
    private $table;
    private $fields = '*';
    private $where = 'true';
    private $order;
    private $limit;

    function __construct(array $config)
    {
        $this->connect($config);
    }    
    function getConfig()
    {
        return parent::$config;
    }
    function getPDO()
    {
        return parent::$pdo;
    }
    private function reset(){
        // $table='';
        $this->fields = '*';
        $this->where = 'true';
        $this->order = '';
        $this->limit = '';
    }

    // 链式查询
    function table(string $table)
    {
        if (!is_string($table)) throw new Exception("参数是字符串，形式如'user'表示user表");
        if (!empty($table))
            $this->table = $table;
        return $this;
    }
    function field(string $fields)
    {
        if (!is_string($fields)) throw new Exception("参数是字符串，形式如'id,name,pwd'表示获取3个字段");
        if (!empty($fields))
            $this->fields = $fields;
        return $this;
    }
    function where($where)
    {
        if (is_string($where)) {
            if (!empty($fields))
                $this->where .= " and {$where}";
            return $this;
        }
        if ($this->is_assoc($where)) {
            while (current($where)) {
                $this->where .= ' and ' . key($where) . '=' . current($where);
                next($where);
            }
            return $this;
        }
        throw new Exception('请检查条件');
    }
    function order(string $order)
    {
        if (!is_string($order)) throw new Exception("参数是字符串，形式如'id asc'表示id升序");
        if (!empty($order))
            $this->order = $order;
        return $this;
    }
    function limit(string $limit)
    {
        if (!is_string($limit)) throw new Exception("参数是字符串，形式如'0,5'表示偏移0数量是5");
        if (!empty($limit))
            $this->limit = $limit;
        return $this;
    }
    // 查询单条记录
    function find()
    {
        try {
            if (empty($this->table)) throw new Exception('没有查询表');
            $sql = "SELECT {$this->fields} FROM {$this->table} WHERE {$this->where}";
            if (!empty($this->order))
                $sql .= " ORDER BY {$this->order}";
            $this->res = parent::$pdo->query($sql);
            $this->reset();
            return $this->res->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return '查询错误信息：' . $e->getMessage();
        }
    }
    // 查询所有记录
    function select()
    {
        try {
            if (empty($this->table)) throw new Exception('没有查询表');
            $sql = "SELECT {$this->fields} FROM {$this->table} WHERE {$this->where}";
            if (!empty($this->order))
                $sql .= " ORDER BY {$this->order}";
            if (!empty($this->limit))
                $sql .= " LIMIT {$this->limit}";
            $this->res = parent::$pdo->query($sql);
            $this->reset();
            return $this->res->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return '查询错误信息：' . $e->getMessage();
        }
    }

    // 插入、更新和删除操作
    public function insert(array $data)
    {
        if (empty($this->is_assoc($data))) throw new Exception('插入数据不是关联数组');
        if (empty($this->table)) throw new Exception('插入时必须指定表');
        $sql = "INSERT INTO {$this->table}";
        $key = key($data);
        $value = "'" . current($data) . "'";
        next($data);
        while (current($data)) {
            $key .= "," . key($data);
            $value .= ",'" . current($data) . "'";
            next($data);
        }
        $sql .= " ({$key}) VALUES ({$value})";
        $this->res = parent::$pdo->exec($sql);
        $this->reset();
        return $this->res;
    }
    public function update(array $data)
    {
        if (empty($this->is_assoc($data))) throw new Exception('更新数据不是关联数组');
        if (empty($this->table)) throw new Exception('更新时必须指定表');
        if ($this->where == 'true') throw new Exception('更新时必须指定条件');
        $sql = "UPDATE {$this->table}";
        $item = key($data) . "='" . current($data) . "'";
        next($data);
        while (current($data)) {
            $item .= "," . key($data) . "='" . current($data) . "'";
            next($data);
        }
        $sql .= " SET {$item} WHERE {$this->where}";
        $this->res = parent::$pdo->exec($sql);
        $this->reset();
        return $this->res;
    }
    public function delete()
    {
        try {
            if (empty($this->table)) throw new Exception('删除时必须指定表');
            if ($this->where == 'true') throw new Exception('删除时必须指定条件');
            $sql = "DELETE FROM {$this->table} WHERE {$this->where}";
            $this->res = parent::$pdo->exec($sql);
            $this->reset();
            return $this->res;
        } catch (\PDOException $e) {
            return '查询错误信息：' . $e->getMessage();
        }
    }
}

//使用测试
// $config = [
//     'dsn' => 'mysql:host=localhost;dbname=test',
//     'username' => 'root',
//     'password' => 'root'
// ];
// $obj = new Db($config);
// $obj->table('baidu_cat')->where(['id'=>14])->update(['name' => 'zaq1123456']);
// var_dump($obj->table('baidu_cat')->where(['id'=>13])->delete());
