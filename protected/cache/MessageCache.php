<?php
$util =dirname(__FILE__).'/../util';

require_once($util . '/SAELog.php');
/**
 * Created by PhpStorm.
 * User: bokix
 * Date: 14-2-20
 * Time: 16:48
 */
class MessageCache extends BaseCache
{
    const expiry = 3600; // 秒， 1 小时
    public function  getUserLastMsg($userId)
    {
        $s = parent::get($userId);
        return $s == null ? "" : $s;
    }

    public function setUserLastMsg($userId, $msg, $exp = self::expiry)
    {
        SAELog::debug("try to set." . $userId . ", " . $msg);
        $b = parent::set($userId, $msg, 0, $exp);
    }

    public function  removeUserLastMsg($userId)
    {
        parent::delete($userId);
    }

    function makeKey($s)
    {
        return $s . "-mq";
    }
}