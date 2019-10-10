<?php

/**
 * Created by PhpStorm.
 * User: bokix
 * Date: 14-2-24
 * Time: 16:06
 */
class CompanyCache extends BaseCache {
    const KEY_OF_TEST = "1";

    function __construct() {
        parent::__construct();

        $alreadyLoad = $this->get(self::KEY_OF_TEST);
        if ($alreadyLoad) {
            return;
        }
        $all = Company::model()->findAll();
        foreach ($all as $company) {
            Yii::log('try to set company cache:' . $company->appId);

            $this->setCompanyByAppId($company);
        }
        $this->set(self::KEY_OF_TEST, "1");

    }

    function makeKey($s) {
        return $s . "-comp";
    }

    private function loadByKey($key) {
        $sql = "select * from company where appId=:appId";

        $com = Company::model()->findBySql($sql, array(':appId' => $key));
        if ($com == null) {
            parent::set($key, null);
        } else {
            $this->setCompanyByAppId($com);
        }
    }

    public function  getCompanyByAppId($appId) {
        if (empty($appId)) {
            return null;
        }
        if (!parent::keyExists($appId)) {
            $this->loadByKey($appId);
        }
        return parent::get($appId);
    }

    public function getCompanyByCompanyId($comId) {
        $cache = new CompanyId2AppIdCache();
        $appId = $cache->getAppId($comId);

        if (empty($appId)) {
            return null;
        }

        return parent::get($appId);
    }


    public function setCompanyByAppId($com) {
        if ($com == false || strlen($com->appId) < 1) {
            return;
        }
        parent::set($com->appId, $com);
    }

    public function removeByAppId($appId) {
        parent::delete($appId);
    }

}