<?php
require_once 'Model.php';
require_once 'View.php';

// class Controller
// {
//     参数注入当前方法中，仅给当前方法使用
//     function index(Model $model, View $view)
//     {
//         return $view->fetch($model->getData());
//     }
// }

// // 测试输出代码
// $model=new Model();
// $view=new View();
// echo (new Controller())->index($model,$view);


// 类的共享或复用
class Controller
{
    private $model=null;
    private $view=null;
    // 参数注入构造函数中，赋值给类的成员变量，便于类的成员方法访问（共享或复用)
    function __construct(Model $model, View $view)
    {
        $this->model=$model;
        $this->view=$view;
    }
    function index()
    {
        return $this->view->fetch($this->model->getData());
    }
}

$model=new Model();
$view=new View();
echo (new Controller($model,$view))->index();
