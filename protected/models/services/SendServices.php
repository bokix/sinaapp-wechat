<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-4
 * Time: 17:10
 */
//TODO
class SendServices {

    const SEND_MSG_URL = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=";

    public function  sendTxtMsg($com, $msg) {
        $b = $this->sendMsgUseAPI($com, $msg);
        if (!$b) {
            logger . debug("try to send msg use mock login.");
            $b = $this->sendMsgUseMockLogin($com, $msg);
        }
        return $b;
    }

// 用微信提供的API发送消息
    private function sendMsgUseAPI($com, $msg) {

        if ($com == null) {
            return false;
        }

        $userOpenId = $com->adminUserOpenId;
        if (empty($userOpenId) || empty($msg)) {
            return false;
        }
        $accessTokenCache = new AccessTokenCache();
        $token = $accessTokenCache->getToken($com->appId,
            $com->appSecret);
        return false;

        $url = self::SEND_MSG_URL . $token;
        $msgJson;
    }

    // 模拟登录的方式发送消息
    public function  sendMsgUseMockLogin($com, $msg) {
    }

    /**
     * 获取登录session
     */
    private function auth($username, $passwrod) {

    }

    public function sendMsg($cookie, $content, $fakeId) {

    }
}




//end class file. 