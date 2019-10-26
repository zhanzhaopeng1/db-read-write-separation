<?php

namespace dbrw\filter;

use dbrw\interfaces\FilterInterface;

class MasterFilter implements FilterInterface
{
    public function filterSql($sql)
    {
        if (!preg_match('/(select|update|insert)/is', $sql)) {
            return false;
        }

        return true;
    }
}