<?php
require_once '../vendor/autoload.php';

use dbrw\connectors\ConnectionFactory;

$sql = 'select * from user_account where uid=1';

$factory = new ConnectionFactory();
$connect = $factory->createConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'port' => 3306,
    'database' => 'test',
    'username' => 'admin',
    'password' => '123456',
], false);

$pdo = $connect->getPdo();
$connect->filter($sql);
$res = $pdo->query($sql)->fetch();
var_dump($res);
