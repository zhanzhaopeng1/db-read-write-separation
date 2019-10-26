<?php

namespace dbrw\filter;

use dbrw\interfaces\FilterInterface;

class FollowFilter implements FilterInterface
{
    public function filterSql($sql)
    {
        if (preg_match_all("/select/i", $sql, $pat_array)) {
            return true;
        }

        return false;
    }
}