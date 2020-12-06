<?php
abstract class aBase
{
    function getName()
    {
        echo __METHOD__,'<br>';
    }
}

trait tBase
{
    function getName()
    {
        echo __METHOD__,'<br>';
    }
}

class Work extends aBase
{
    use tBase;
    function getMethod(){
        print_r(get_class_methods('Work'));
    }
}

$obj = new Work();
$obj->getMethod();
