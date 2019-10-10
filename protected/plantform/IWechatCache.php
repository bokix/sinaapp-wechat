<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-2-27
 * Time: 9:59
 */
interface IWechatCache {
    public function set($key, $o, $flag = 0, $exp = 0);

    public function get($key);

    public function delete($key);

    public function keyExists($key);

    public function incr($key, $value = 1);
}
