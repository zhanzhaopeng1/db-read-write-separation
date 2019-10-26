<?php

namespace dbrw\connectors;

use dbrw\Connection;
use dbrw\MysqlConnection;
use InvalidArgumentException;

class ConnectionFactory
{
    /**
     * @param array $config
     * @param bool $isMaster
     * @return Connection
     */
    public function createConnection(array $config, $isMaster = true)
    {
        if (!isset($config['driver'])) {
            throw new InvalidArgumentException('A driver must be specified.');
        }

        $pdo = $this->createPdoResolver($config);

        switch ($config['driver']) {
            case 'mysql':
                return new MysqlConnection($pdo, $isMaster);
                break;
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}]");
    }

    /**
     * 创建pdo 解析器
     * @param array $config
     * @return \PDO
     */
    protected function createPdoResolver(array $config)
    {
        return $this->createConnector($config)->connect($config);
    }

    /**
     * 创建连接器
     *
     * @param array $config
     * @return \dbrw\interfaces\ConnectorInterface
     */
    public function createConnector(array $config)
    {
        if (!isset($config['driver'])) {
            throw new InvalidArgumentException('A driver must be specified.');
        }

        switch ($config['driver']) {
            case 'mysql':
                return new MysqlConnector();
                break;
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}]");
    }
}