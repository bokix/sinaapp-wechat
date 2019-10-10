<?php

Yii::import('application.plantform.memcached.*');
Yii::import('application.plantform.*');

abstract class BaseCache {
    private $cacheImpl;

    abstract function makeKey($s);

    public function __construct() {
        if (Yii::app()->params['localMode']) {
            $this->cacheImpl = new LocalCacheImpl();
        } else {
            $this->cacheImpl = new SAECacheImpl();
        }
    }

    public function set($key, $o, $flag = 0, $exp = 0) {
        if ($key == null || strlen($key) < 1) {
            return false;
        }
        return $this->cacheImpl->set($this->makeKey($key), $o, $flag, $exp);
    }


    public function get($key) {
        if ($key == null || strlen($key) < 1) {
            return null;
        }
        $k = $this->makeKey($key);
        $v = $this->cacheImpl->get($k);
        return $v;
    }

    public function delete($key) {
        if ($key == null || strlen($key) < 1) {
            return true;
        }
        return $this->cacheImpl->delete($this->makeKey($key));
    }

    public function keyExists($key) {
        if ($key == null || strlen($key) < 1) {
            return false;
        }
        return $this->cacheImpl->keyExists($this->makeKey($key));
    }

    public function incr($key, $value = 1) {
        if ($key == null || strlen($key) < 1) {
            return 0;
        }
        return $this->cacheImpl->incr($this->makeKey($key), $value);
    }
}