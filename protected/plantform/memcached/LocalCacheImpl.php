<?php
/**
 * Created by bokix.
 * User: bokix
 * Date: 14-2-27
 * Time: 10:10
 */
Yii::import('application.plantform.*');
class LocalCacheImpl implements IWechatCache{
    private $mem;

    public function __construct()
    {
        $this->mem = array();
    }

    public function set($key, $o, $flag = 0, $exp = 0)
    {
        return $this->mem[$key] = $o;
    }

    public function get($key)
    {
        if(array_key_exists($key, $this->mem)){
            return $this->mem[$key];
        }else{
            return null;
        }
    }

    public function delete($key)
    {
         unset($this->mem[$key]);
    }


    public function keyExists($key)
    {
        array_key_exists($key,$this->mem);
    }

    public function incr($key, $value = 1)
    {
        if(array_key_exists($key, $this->mem)){
            $v = $this->mem[$key];
            $newValue= $v + $value;
        }else{
            $newValue = $value;
        }
        $this->mem[$key] = $newValue;
        return $newValue;
    }
}
