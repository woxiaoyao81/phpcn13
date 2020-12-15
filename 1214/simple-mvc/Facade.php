<?php

namespace Facade;
require_once 'Container.php';

// 门面类
class Facade
{
    protected static $container = null;
    static function instance(\Container $container)
    {
        static::$container = $container;
    }
}

class Model extends Facade
{
    static function getData()
    {
        return static::$container->make('model')->getData();
    }
}

class View extends Facade
{
    static function fetch($data)
    {
        return static::$container->make('view')->fetch($data);
    }
}
