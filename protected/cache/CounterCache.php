<?php

/**
 * Created by PhpStorm.
 * User: bokix
 * Date: 14-2-24
 * Time: 16:07
 */

class CounterCache extends BaseCache
{
    public function makeKey($key)
    {
        return $key . "-counter";
    }

    public function addOrIncr($companyId, $date)
    {
        $key = $companyId . "-" . $date;
        $v = parent::get($key);
        if ($v == false) {
            parent::set($key, 1);
            return 1;
        }
        return parent::incr($key);
    }
} 