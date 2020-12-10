<?php
// 使用事件委托(方法拦截器实现数据库链式操作)\
// 效果就是Db::table('user') ->field('id,name,age')->where('status',1) ->order('create_time') ->limit(10) ->select();

class Query
{
    protected $db;
    protected $where = 'true and ';
    protected $field;
    protected $order;
    protected $limit;
    function __construct($dsn, $username, $pwd)
    {
        $this->connect($dsn, $username, $pwd);
    }

    private function connect($dsn, $username, $pwd)
    {
        $this->db = new PDO($dsn, $username, $pwd);
    }
    // 合并成查询SQL
    private function getSql()
    {
        return sprintf("SELECT %s FROM %s where %s %s %s", $this->field, $this->table, substr($this->where, 0, -4), $this->order, $this->limit);
    }
    //数据表
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }
    // 字段名
    function field($val)
    {
        $this->field = $val;
        return $this;
    }
    // 条件，支持多次调用
    function where($name, $val)
    {
        $this->where .= "{$name}={$val} and ";
        return $this;
    }
    // 排序
    function order($name, $val = 'ASC')
    {
        $this->order = "order by{$name} {$val}";
        return $this;
    }
    // 限制
    function limit($val)
    {
        $this->limit = "limit {$val}";
        return $this;
    }
    // 选择所有符合条件记录
    function select()
    {
        return $this->db->query($this->getSql())->fetchAll(PDO::FETCH_ASSOC);
    }
    // 读取第一条记录
    function find()
    {
        return $this->db->query($this->getSql())->fetch(PDO::FETCH_ASSOC);
    }
}

class Db
{
    static function __callStatic($name, $args)
    {
        $dsn = "mysql:host=localhost;dbname=test";
        $username = 'root';
        $pwd = 'root';
        $query = new Query($dsn, $username, $pwd);
        return call_user_func(array($query, $name), ...$args);
    }
}
$res = DB::table('user')
    ->field('id,uname,pwd')
    // ->where('id', 1)
    ->limit(5)
    // ->find();//读取一条
    ->select();//读取所有
print_r($res);
