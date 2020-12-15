<?php
class A
{
 protected static $_instance = null;
 
 static public function getInstance()
 {
  if (self::$_instance === null) {
   self::$_instance = new self();
  }
  return self::$_instance;
 }
}
 
class B extends A
{ 
}
 
class C extends A{
}
 
$a = A::getInstance();
$b = B::getInstance();
$c = C::getInstance();
 
var_dump($a);
var_dump($b);
var_dump($c); 
?>