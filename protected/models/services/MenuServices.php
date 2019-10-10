<?php
Yii::import('application.util.*');

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-5
 * Time: 14:49
 */
class MenuServices {
    const MENU_CREATE_URL = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=";
    const MENU_DELETE_URL = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=";

    public function deleteMenu($appId, $appSecret) {
        $accessTokenCache = new AccessTokenCache();
        $token = $accessTokenCache->getToken($appId, $appSecret);
        $url = self::MENU_DELETE_URL . $token;
        $nu = new NetUtil();
        $result = $nu->get($url);
        return $result;
    }

    public function createMenu($appId, $appSecret, $menu) {
        $accessTokenCache = new AccessTokenCache();
        $token = $accessTokenCache->getToken($appId, $appSecret);

        $url = self::MENU_CREATE_URL . $token;
        $nu = new NetUtil();
        $result = $nu->post($url, $menu);
        return true;
    }

    public function getDefaultMenu() {
        $meta = "<meta charset='utf-8'>";
        echo $meta;

        $btn11 = new CommonButton();
        $btn11->setName("查看菜单");
        $btn11->setType("click");
        $btn11->setKey("11");

        $btn21 = new CommonButton();
        $btn21->setName("我要下单");
        $btn21->setType("click");
        $btn21->setKey("21");

        $btn31 = new CommonButton();
        $btn31->setName("帮助信息");
        $btn31->setType("click");
        $btn31->setKey("31");

        $btn32 = new CommonButton();
        $btn32->setName("管理模式");
        $btn32->setType("click");
        $btn32->setKey("32");

        $btn33 = new CommonButton();
        $btn33->setName("我的订单");
        $btn33->setType("click");
        $btn33->setKey("33");

        $btn34 = new CommonButton();
        $btn34->setName("桌位信息");
        $btn34->setType("click");
        $btn34->setKey("34");

        //复合菜单
        $mainBtn3 = new ComplexButton();
        $mainBtn3->setName("帮助");
        $mainBtn3->setSubButton(array($btn33, $btn34, $btn31, $btn32));

        /**
         * 在某个一级菜单下没有二级菜单的情况，那么menu应该这样定义：<br>
         * menu.setButton(new Button[] { mainBtn1, mainBtn2, btn33 });
         */
        $menu = new Menu();
        $menu->setButton(array($btn11, $btn21, $mainBtn3));


        $jsonMenu = JsonUtil::getZhJson($menu);

        return $jsonMenu;
    }
}





//end class file. 