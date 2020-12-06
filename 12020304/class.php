<?php
// 类和对象
class cPerson
{
    public $describe='class';
    private $name = 'woxiaoyao';
    protected $age='28';
    const COURSE='computer';
    function hello():string
    {
        return "{$this->describe}:{$this->name}的年龄是{$this->age}";
    }
}

class cMan extends cPerson
{
    //  类中使用self访问静态成员，父类静态成员是parent，在类外是类名+范围解析符::完成
    static $count=1;
     // 判断是关联数组或索引数组
     protected function isAssoc(array $arr)
     {
         if (is_array($arr)) {
             $key = array_keys($arr);
             return $key == array_keys($key) ? false : true;
         }
         return null;
     }
     static function isAssoc2(array $arr)
     {
         if (is_array($arr)) {
             $key = array_keys($arr);
             return $key == array_keys($key) ? false : true;
         }
         return null;
     }
     public function test(array $arr){
         $this->age=25;
         var_dump($this->isAssoc($arr));
         self::$count=10;
         var_dump(self::isAssoc2($arr));
     }
     static function test2(array $arr){
         $that=new self();
         $that->age=25;
        var_dump($that->isAssoc($arr));
        self::$count=10;
        var_dump(self::isAssoc2($arr));
     }
}
// 类的实例化就是对象
$obj=new cMan();
$arr=[1,2,3,4,5];
$obj->test($arr);
cMan::test2($arr);
