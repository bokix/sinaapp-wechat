<?php
/**
 * Created by PhpStorm.
 * User: bokix
 * Date: 14-2-24
 * Time: 16:06
 */
//require_once('BaseCache.php');
Yii::import('application.util.SignUtil');

class AccessTokenCache extends BaseCache
{

    const expiry = 3600;

    function makeKey($s)
    {
        return $s . "-token";
    }

    public function getToken($appId, $appSecret, $createNew = true)
    {
        $token = parent::get($appId);
        if (strlen($token) < 1 && $createNew) {
            $token = SignUtil::getAccessToken($appId, $appSecret);
            parent::set($appId, $token, self::expiry);
        }
        return $token;
    }
}