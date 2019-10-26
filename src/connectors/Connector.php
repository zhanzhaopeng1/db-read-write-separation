<?php

namespace dbrw\connectors;

use PDO;
use Exception;

class Connector
{
    use DetectsLostConnections;

    const PDO_TIME_OUT = 10; //the timeout value in seconds for communications with the database

    /**
     * The default PDO connection options.
     *
     * @var array
     */
    protected $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
//        PDO::ATTR_STRINGIFY_FETCHES => false,
//        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    /**
     * @param $dsn
     * @param array $config
     * @param array $options
     * @return PDO
     * @throws Exception
     */
    public function createConnection($dsn, array $config, array $options)
    {
        list($username, $password) = [
            $config['username'], $config['password'],
        ];

        try {
            return $this->createPdoConnection(
                $dsn, $username, $password, $options
            );
        } catch (Exception $e) {
            return $this->tryAgainIfLostConnection($e, $dsn, $username, $password, $options);
        }
    }

    /**
     * Create a new PDO connection instance.
     *
     * @param  string $dsn
     * @param  string $username
     * @param  string $password
     * @param  array $options
     * @return \PDO
     */
    protected function createPdoConnection($dsn, $username, $password, $options)
    {
        return new PDO($dsn, $username, $password, $options);
    }

    /**
     * 处理在连接期间发生的异常，进行重试
     *
     * @param Exception $e
     * @param $dsn
     * @param $username
     * @param $password
     * @param $options
     * @return PDO
     *
     * @throws Exception
     */
    protected function tryAgainIfLostConnection(Exception $e, $dsn, $username, $password, $options)
    {
        if ($this->causedByLostConnection($e)) {
            return $this->createPdoConnection(
                $dsn, $username, $password, $options
            );
        }

        throw  $e;
    }
}