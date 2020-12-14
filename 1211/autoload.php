<?php
spl_autoload_register(function($classname){
    $path=__DIR__.DIRECTORY_SEPARATOR.$classname.'.php';
    require_once $path;
});
