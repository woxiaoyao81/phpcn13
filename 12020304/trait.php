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
    function getName()
    {
        echo __METHOD__,'<br>';
    }
}

$obj = new Work();
$obj->getName();
