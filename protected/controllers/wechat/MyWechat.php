<?php
/**
 * 微信公众平台 PHP SDK
 */
// change the following paths if necessary
$cache = dirname(__FILE__) . '/../../cache';
$util = dirname(__FILE__) . '/../../util';

require_once($util . '/SAELog.php');

require_once('Wechat.php');

/**
 * 微信公众平台演示类
 */
class MyWechat extends Wechat {
    const SYS_BASE_URL = "http://bokix.sinaapp.com/";

    /**
     * 用户关注时触发，回复「欢迎关注」
     *
     * @return void
     */
    protected function onSubscribe() {
        $this->responseText('欢迎关注');
    }

    protected function onMenuClick() {

        $menuKey = $this->getRequest("EventKey");
        // 发送方帐号（open_id）
        $fromUserName = $this->getRequest("FromUserName");
        $msgCache = new MessageCache();
        $msgCache->removeUserLastMsg($fromUserName);

        if ("11" == $menuKey) {
            // 查看菜单
            $this->getMenuRespMsg11();
        } else if ("21" == $menuKey) {
            // 我要下单
            $this->getMenuRespMsg21();
        } else if ("31" == $menuKey) {
            // 帮助信息
            $this->getMenuRespMsg31();

        } else if ("32" == $menuKey) {
            // 管理模式
            $this->getMenuRespMsg32();
        } else if ("33" == $menuKey) {
            // 我的订单
            $this->getMenuRespMsg33();
        } else if ("34" == $menuKey) {
            // 桌位信息
            $this->getMenuRespMsg34();
        }
        $this->responseText($this->getDefaultRespMsg());
    }

    /**
     * 用户取消关注时触发
     *
     * @return void
     */
    protected function onUnsubscribe() {
    }

    protected function processSpecialMsg() {
        $msg = $this->getRequest("Content");
        $FromUserName = $this->getRequest("FromUserName"); //
        $ToUserName = $this->getRequest("ToUserName"); //
        $msgtype = $this->getRequest("msgtype"); //
        $event = $this->getRequest("event");

        //目前只处理文本特殊信息
        if ($msgtype != 'text') {
            return false;
        }
        SAELog::debug('start to process special msg.'. $msg);
        $index = strpos($msg, 'RGA');
        if ( $index === 0) {
            $appId = substr($msg, 3);
            $companyCache = new CompanyCache();
            $com = $companyCache->getCompanyByAppId(
                $appId);

            SAELog::debug("appId:$appId");

            if ($com == null) {
                $this->responseText('商家未接入');
                return true;
            }
            if (strlen($com->companyId) > 5) {
                $this->responseText('商家已注册');
                return true;
            }
            $com->companyId = $ToUserName;
            $com->adminUserOpenId = $FromUserName;

            $companyId2AppIdCache = new CompanyId2AppIdCache();
            $companyId2AppIdCache->set($ToUserName, $appId);

            $com->save();

            $companyCache->setCompanyByAppId($com);

            $categoryService = new CategoryServices();
            $categoryService->createDefaultCategory($ToUserName);
            $this->responseText('此微信号已成功注册接收客服消息，如需修改接收客服消息的微信号，请在管理模式中进行修改。');
            return true;
        }

        return false;

    }

    /**
     * 收到文本消息时触发，回复收到的文本消息内容
     *
     * @return void
     */
    protected function onText() {
        // $this->responseText('收到了文字消息：' . $this->getRequest('content'));
        $msgCache = new MessageCache();
        $msg = $this->getRequest("Content");
        $FromUserName = $this->getRequest("FromUserName"); // 用户
        $ToUserName = $this->getRequest("ToUserName"); // 公众帐号
        $lastMsg = $msgCache->getUserLastMsg($FromUserName);

        $msgCache->setUserLastMsg($FromUserName, $msg);


        //$this->responseText("msg:" . $msg . ", lastMsg:" . $lastMsg);

        $errorMsg = "无法识别的命令：" . $msg;

        if (strlen($msg) < 1 || "帮助" == $msg || "0" == $msg) {
            $msgCache->removeUserLastMsg($FromUserName);
            // TempCache.getInstance().delete(FromUserName);
            $this->responseText($this->getDefaultRespMsg());
        }

        switch ($lastMsg) {
            case "90":
            case "91":
            case "9111":
                $this->responseSingleOrderManage();
            case "911":
                $this->responseOrderManage();
                return ordersManage();
            case "912":
                $this->responseChangeAuthCode();
            case "913":
                $this->responseRegistAsAdminUser();

            default:
                $this->responseText($this->getDefaultRespMsg());
        }
    }

    /**
     * 收到图片消息时触发，回复由收到的图片组成的图文消息
     *
     * @return void
     */
    protected function onImage() {
        $items = array(
            new NewsResponseItem('标题一', '描述一', $this->getRequest('picurl'), $this->getRequest('picurl')),
            new NewsResponseItem('标题二', '描述二', $this->getRequest('picurl'), $this->getRequest('picurl')),
        );

        $this->responseNews($items);
    }

    /**
     * 收到地理位置消息时触发，回复收到的地理位置
     *
     * @return void
     */
    protected function onLocation() {
        $num = 1 / 0;
        // 故意触发错误，用于演示调试功能

        $this->responseText('收到了位置消息：' . $this->getRequest('location_x') . ',' . $this->getRequest('location_y'));
    }

    /**
     * 收到链接消息时触发，回复收到的链接地址
     *
     * @return void
     */
    protected function onLink() {
        $this->responseText('收到了链接：' . $this->getRequest('url'));
    }

    /**
     * 收到未知类型消息时触发，回复收到的消息类型
     *
     * @return void
     */
    protected function onUnknown() {
        $this->responseText('收到了未知类型消息：' . $this->getRequest('msgtype'));
    }

    private static function getHelpStr() {
        $msg = <<<msg
使用帮助：\n\n
您可以通过屏幕底部的菜单选择您需要的功能，系统将根据您的选择为您提供服务。直接输入9则进入管理模式。\n\n
在\"我要下单\"和\"查看菜单\"功能中，系统将引导您进入更丰富的图文界面，在图文界面中，您将查看到所有的菜单信息，
也可以提交您的订单，提交的订单将实时通知商家，订单的处理结果以商家的处理结果为准。\n
msg;
        return $msg;
    }

    public function getDefaultRespMsg($otherMsg = "") {
        if (strlen($otherMsg) >= 1) {
            $otherMsg = $otherMsg . "\n\n";
        }
        return $otherMsg . self::getHelpStr();
    }

    private function getMenuRespMsg11() {
        $FromUserName = $this->getRequest("FromUserName"); // 用户
        $ToUserName = $this->getRequest("ToUserName"); // 公众帐号

        $url = self::SYS_BASE_URL . "?r=dc/showItems&userName=" . $FromUserName
            . "&companyId=" . $ToUserName;

        $item1 = new NewsResponseItem("查看菜单请点击图片", "", "http://mmbiz.qpic.cn/mmbiz/mgN2Nib5iaWUcKswR3k5rNnKoDCNgwWfRrVdCpDeLrSTEicOBfZ91SZqTiaer6IdHhwtkia9Ra2IKicXHiauCd98JHB0A/0", $url);
        $item2 = new NewsResponseItem("各式美味，欢迎品尝，还可外送哦。", '', "", $url);
        $items = array(
            $item1,
            $item2,
        );

        $this->responseNews($items);
    }

    private function getMenuRespMsg21() {
        $FromUserName = $this->getRequest("FromUserName"); // 用户
        $ToUserName = $this->getRequest("ToUserName"); // 公众帐号

        $url = self::SYS_BASE_URL . "?r=dc/addOrder&userName=" . $FromUserName
            . "&companyId=" . $ToUserName;

        $item1 = new NewsResponseItem("下单请点击图片", "", "http://mmbiz.qpic.cn/mmbiz/mgN2Nib5iaWUcKswR3k5rNnKoDCNgwWfRrzEVChkMxiaO278aQWoDiaukE7p3SZ422vuZqxWklqeBsokQtMoCyLjDA/0", $url);
        $item2 = new NewsResponseItem("各式美味，欢迎品尝，还可外送哦。", "", "", $url);
        $items = array(
            $item1,
            $item2,
        );

        $this->responseNews($items);

    }

    private function getMenuRespMsg31() {
        $FromUserName = $this->getRequest("FromUserName"); // 用户
        $ToUserName = $this->getRequest("ToUserName"); // 公众帐号
        $msgCache = new MessageCache();
        $msgCache->removeUserLastMsg($FromUserName);

        $this->responseText($this->getDefaultRespMsg());
    }

    private function getMenuRespMsg32() {
        // 发送方帐号（open_id）
        $FromUserName = $this->getRequest("FromUserName");
        // 公众帐号
        $ToUserName = $this->getRequest("ToUserName");
        $msgCache = new MessageCache();
        $authCache = new AuthUserCache();

        $valid = $authCache->isUserAuth($ToUserName, $FromUserName);
        if ($valid) {
            $msgCache->setUserLastMsg($FromUserName, "91");
            $this->responseMsg91();
        } else {
            $msgCache->setUserLastMsg($FromUserName, "90");
            $this->responseMsg90();
        }
    }

    private function getMenuRespMsg33() {
        $this->responseMyOrder();
    }

    private function getMenuRespMsg34() {
        $this->responseResourceSts();
    }

    private function responseMsg91($otherMsg = "") {
        $rc = "";

        if (strlen($otherMsg) > 0) {
            $rc = $rc . $otherMsg . "\n\n";
        }

        $rc . "请输入对应的编号进行操作：\n";
        $rc . "1:查看预订信息" . "\n";
        $rc . "2:修改授权码" . "\n";
        $rc . "3:注册为客服帐号（用于接收订单提醒）" . "\n";

        $this->responseText(rc);
    }

    private function responseMsg90() {
        $respContent = "请输入授权码，通过后，有效期为24小时\n";
        $this->responseText($respContent);
    }

    private function responseMyOrder() {
        // 发送方帐号（open_id）
        $FromUserName = $this->getRequest("FromUserName");
        // 公众帐号
        $ToUserName = $this->getRequest("ToUserName");

        $os = new OrderServices();

		$mm = "";
            $l = $os->getOrderByWXUser($ToUserName, $FromUserName);
			if (count($l)<1) {
                $mm = "您还没有预订单。";
            } else {
                $mm = "您最近的一条预定信息：\n";
                $o = $l[0];
				$mm .= "联系人：" . $o->orderPersonName . "\n";
				$mm .= "联系电话：" . $o->phone . "\n";
				$mm .= "用餐人数：" . $o->orderPersonNum . "\n";
				$mm .= "备注：" . $o->orderRemark . "\n";
				$mm .= "处理结果：" . OrderDealStsEnum::getDesc($o->dealSts). "\n";
				$mm .= "商家备注：" . $o->companyRemark . "\n";

				$mm .= "\n\n查看更多预订信息请点击 <a href=\"" . self::SYS_BASE_URL
                    . "?r=dc/list&companyId=" . $ToUserName . "&userName="
                    . $FromUserName . "\">这里</a> 进行查询\n\n";

			}

        $this->responseText($mm);
    }

    private function responseResourceSts() {
        $this->responseText("我们提供外卖服务，也随时欢迎您到店用餐。");
    }
}

