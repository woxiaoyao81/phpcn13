<?php
require_once 'Facade.php';
require_once 'Model.php';
require_once 'View.php';
use Facade\Facade;
use Facade\Model;
use Facade\View;

// 类的共享或复用
class Controller
{
    function __construct(Container $container)
    {
        Facade::instance($container);
    }
    function index()
    {
        return View::fetch(Model::getData());
    }
}
$container=new Container();
$container->bind('model',function(){
    return new \Model();
});
$container->bind('view',function(){
    return new \View();
});
echo (new Controller($container))->index();
