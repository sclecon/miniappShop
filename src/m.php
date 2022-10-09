<?php

$config = [
    'host'      =>  'mysql',
    'dbname'    =>  'shop',
    'username'  =>  'shop',
    'password'  =>  'shop',
    'port'      =>  '3006',
    'charset'   =>  'utf-8'
];

$conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['dbname'], $config['3306']);
if (!$conn){
    print_r(mysqli_error());
}
mysqli_set_charset($conn, $config['charset']);
var_dump('链接数据库成功');