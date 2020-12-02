<?php

namespace JSPDO;

return [
    'type' => $type ?? 'mysql',
    'host' => $host ?? 'localhost',
    'dbname' => $dbname ?? 'test',
    'name' => $name ?? 'root',
    'pwd' => $pwd ?? 'root',
    'charset' => $charset ?? 'utf-8'
];
