<?php

namespace dbrw;

use dbrw\filter\FollowFilter;
use dbrw\filter\MasterFilter;
use InvalidArgumentException;

class Connection
{
    private $pdo;

    private $isMaster;

    /**
     * Connection constructor.
     * @param $pdo
     * @param string $isMaster 是否是主节点
     */
    public function __construct($pdo, $isMaster)
    {
        $this->pdo = $pdo;
        $this->isMaster = $isMaster;
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * 过滤sql 如果不需要可以不使用
     * @param $sql
     */
    public function filter($sql)
    {
        if ($this->isMaster) {
            $result = (new MasterFilter())->filterSql($sql);
        } else {
            $result = (new FollowFilter())->filterSql($sql);
        }

        if (!$result) {
            throw  new InvalidArgumentException('Invalid sql statement,Please check');
        }
    }
}