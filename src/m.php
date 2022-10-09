<?php

$config = [
    'host'      =>  'mysql',
    'dbname'    =>  'shop',
    'username'  =>  'shop',
    'password'  =>  'shop',
    'port'      =>  '3306',
    'charset'   =>  'utf-8'
];

try {
    $conn = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'].';port='.$config['port'], $config['username'], $config['password']);
    echo '链接成功';
} catch (Exception $exception){
    var_dump($exception->getMessage());
}