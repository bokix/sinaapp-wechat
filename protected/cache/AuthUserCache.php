<?php

/**
 * Created by PhpStorm.
 * User: bokix
 * Date: 14-2-24
 * Time: 14:34
 */
class AuthUserCache extends BaseCache
{
    const expiry = 60;//86400; //24 * 60 * 60 ;// 秒， 24 小时

    public function isUserAuth($toUserName, $fromUserName)
    {
        $v = parent::get($toUserName);
        if($v==null){
            return false;
        }
        if(!array_key_exists($fromUserName,$v)){
            return false;
        }
        $user = parent::get($fromUserName);

        return $user == null ? false : true;
    }


    public function cacheAuthUser($toUserName, $fromUserName)
    {
        $v = parent::get($toUserName);
        if($v==null){
            $v = array();
        }
        $v[$fromUserName] = "1";

        parent::set($toUserName,$v);
        parent::set($fromUserName,"1",0,self::expiry);
    }

    /**
     * 移除所有已缓存的授权用户
     * @param toUserName 商户id
     */
    public function removeCachedAuthUsers($toUserName)
    {
        parent::delete($toUserName);
    }

    public function makeKey($key)
    {
        return $key . "-auth";
    }
} 