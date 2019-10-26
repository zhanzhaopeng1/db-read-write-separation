<?php

namespace dbrw\connectors;

use dbrw\interfaces\ConnectorInterface;
use PDO;

class MysqlConnector extends Connector implements ConnectorInterface
{
    /**
     * @param array $config
     * @return PDO
     * @throws \Exception
     */
    public function connect(array $config)
    {
        $dsn = $this->getHostDsn($config);

        $options = $this->getOptions();

        $connection = $this->createConnection($dsn, $config, $options);

        return $connection;
    }

    /**
     * 获取配置的DSN字符串
     *
     * @param array $config
     * @return string
     */
    public function getHostDsn(array $config)
    {
        extract($config, EXTR_SKIP);

        $port = isset($port) ? $port : 3306;
        $host = isset($host) ? $host : '';

        return isset($database) ?
            "mysql:host={$host};dbname={$database};port={$port}"
            : "mysql:host={$host};port={$port}";
    }


    public function getOptions()
    {
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_EMULATE_PREPARES => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::ATTR_TIMEOUT => self::PDO_TIME_OUT,
        ];

        return array_diff_key($this->options, $options) + $options;
    }


}