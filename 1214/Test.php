<?php
class A {
    public static function foo() {
        static::who();
    }

    public static function who() {
        echo __CLASS__."<br>";
    }
}

class B extends A {
    public static function test() {
        // 指明具体类
        A::foo();
        // 调用static后期绑定静态成员
        parent::foo();
        self::foo();
        // parent和self区别
        parent::who();
        self::who();
    }

    public static function who() {
        echo __CLASS__."<br>";
    }
}
class C extends B {
    public static function who() {
        echo __CLASS__."<br>";
    }
}

C::test();
?>