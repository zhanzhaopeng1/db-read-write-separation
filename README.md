# db-read-write-separation

###基于Pdo做的主从分离器

####配置文件基于不同的框架来做，项目中没有固定配置格式
####项目封装了pdo对象，没有封装具体的CURD 代码，需要自己扩展,只需要在MysqlConnection中扩展就可以了

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

$connect->filter($sql);  // 过滤sql  

$res = $pdo->query($sql)->fetch();
var_dump($res);


