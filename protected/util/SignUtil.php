<?php

Yii::import('application.util.*');

class SignUtil {
    const GRANT_TYPE = "client_credential";
    const ACCESS_TOKEN_GET_URL = "https://api.weixin.qq.com/cgi-bin/token";

    public static function getAccessToken($appId, $appSecret) {
        $url = self::ACCESS_TOKEN_GET_URL . "?" . "grant_type=" . self::GRANT_TYPE . "&appid=" . $appId . "&secret=" . $appSecret;

        $nu = new NetUtil();
        $result = $nu->get($url);
        $o = json_decode($result, true);
        if (array_key_exists('access_token', $o)) {
            return $o['access_token'];
        } else {
            throw new Exception(strval($result));
        }
    }
} 