<?php
/**
 * Created by PhpStorm.
 * User: zhaopeng
 * Date: 2019/10/26
 * Time: 下午6:46
 */

namespace dbrw\interfaces;


interface ConnectorInterface
{
    /**
     * 建立连接
     *
     * @param array $config
     * @return \PDO
     */
    public function connect(array $config);
}