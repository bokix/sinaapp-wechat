<?php
/**
 * Created by bokix.
 * User: bokix
 * Date: 14-2-27
 * Time: 10:04
 */
Yii::import('application.plantform.*');

class SAECacheImpl implements IWechatCache{

    private $mem;

    public function __construct()
    {
        $this->mem = memcache_init();
    }

    public function set($key, $o, $flag = 0, $exp = 0)
    {
        return memcache_set($this->mem, $key, $o, $flag, $exp);
    }

    public function get($key)
    {
        $v = memcache_get($this->mem, $key);
        return $v;
    }

    public function delete($key)
    {
        return memcache_delete($this->mem, $key);
    }


    public function keyExists($key)
    {
        $v = memcache_add($this->mem, $key,"1",0,1);
        if(!$v){
            return true;
        }else{
            memcache_delete($this->mem,$key);
            return false;
        }
    }

    public function incr($key, $value = 1)
    {
        return memcache_increment($this->mem, $key, $value);
    }

}
