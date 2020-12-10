<?php
class Property
{
    public $name = 'xiaoyao';
    private $age = 18;
    protected $salary = 3000;
    public static $desc = 'Hello';
    // 读取拦截器
    function __get($name)
    {
        if (property_exists($this, $name)) {
            $method = 'get' . ucfirst($name);
            if (method_exists($this, $method)) {
                return call_user_func(array($this, $method));
            } else {
                return 'Error:未找到读取方法';
            }
        } else {
            return 'Error:不存在这个属性';
        }
    }
    private function getAge()
    {
        return $this->age;
    }
    // 设置拦截器
    function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $method = 'set' . ucfirst($name);
            if (method_exists($this, $method)) {
                echo call_user_func(array($this, $method), $value),'<br>';
            } else {
                echo 'Error:未找到读取方法','<br>';
            }
        } else {
            echo 'Error:不存在这个属性','<br>';
        }
    }
    private function setAge($val)
    {
        if ($val > 5 && $val < 120) {
            $this->age = $val;
            return "age设置成功，现在值为:{$this->age}";
        } else {
            return "Error:age不在合法范围";
        }
    }
    // isset()或empty()判断拦截器
    function __isset($name){
        if (!property_exists($this, $name))
        echo "__isset() => ".__CLASS__."类中没有属性{$name}",'<br>';
    }
    // unset()拦截器
    function __unset($name){
        if (!property_exists($this, $name))
        echo "__unset() => ".__CLASS__."类中没有属性{$name}",'<br>';
    }
}
$obj = new Property();
echo $obj->age,'<br>';
echo $obj->lib,'<br>';
$obj->age=131;
$bl=isset($obj->lib);
unset($obj->lib);

