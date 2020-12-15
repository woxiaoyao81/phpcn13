<?php
// 如果当前类依赖的对象较多,可以将当前依赖的外部对象放到一个"服务容器"中进行统一管理
// 服务容器: 一个自动产生类/对象的工厂
class Container
{
    // 1、对象容器(对象数组)
    protected $instance = [];
    /**
     *  2、绑定对象：对象容器中添加对象
     * $abstract :类标识, 接口, 是外部对象在当前容器数组中的键名/别名 alias    * 
     * $concrete : 要绑定的类, 闭包或者实例, 传入一个对象或者一个闭包,前者需要我们先实例化对象才能往对象容器中添加, 闭包优势:我们使用这个对象的时候,才实例化对象
     */
    function bind($abstract, Closure $concrete)
    {
        $this->instance[$abstract] = $concrete;
    }
    //3.从对象容器中取出对象, 调用
    function make($abstract, $args = [])
    {
        return call_user_func_array($this->instance[$abstract], $args);
    }
}
