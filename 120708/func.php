<?php
class User
{
    public function __call(string $name, array $args)
    {
        printf('方法名:%s(),参数[%s]', $name, implode(',', $args));
    }

    public static function __callStatic(string $name, array $args)
    {
        printf('方法名:%s(),参数[%s]', $name, implode(',', $args));
    }
}

$user = new User;
$user->hello('a', 'b', 'c');
echo '<hr>';
User::demo(1, 2, 3);
