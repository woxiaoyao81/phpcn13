<?php
require_once 'Model.php';
require_once 'View.php';
require_once 'Container.php';

// 类的共享或复用
class Controller
{
    private $model=null;
    private $view=null;
    // 参数注入构造函数中，赋值给类的成员变量，便于类的成员方法访问（共享或复用)
    function __construct(Container $container)
    {
        $this->model=$container->make('model');
        $this->view=$container->make('view');
    }
    function index()
    {
        return $this->view->fetch($this->model->getData());
    }
}

$container=new Container();
$container->bind('model',function(){
    return new Model();
});
$container->bind('view',function(){
    return new View();
});
echo (new Controller($container))->index();
