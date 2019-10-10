<?php

/**
 * Created by PhpStorm.
 * User: bokix
 * Date: 14-2-24
 * Time: 16:07
 */
class CompanyId2AppIdCache extends BaseCache {
    const KEY_OF_TEST = "1";

    function makeKey($s) {
        return $s . "-match";
    }

    public function __construct() {
        parent::__construct();

        $alreadyLoad = $this->get(self::KEY_OF_TEST);

        if ($alreadyLoad) {
            return;
        }
        $all = Company::model()->findAll();
        foreach ($all as $company) {
            if (!empty($company->companyId)) {
                $this->cacheAppId($company->companyId, $company->appId);
            }
        }

        $this->set(self::KEY_OF_TEST, "1");
    }

    private function loadByKey($key) {
        $sql = "select * from company where companyId=:comId";

        $com = Company::model()->findBySql($sql, array(':comId' => $key));
        if ($com == null) {
            $this->cacheAppId($key, '');
        } else {
            $this->cacheAppId($key, $com->appId);
        }
    }

    public
    function getAppId($companyId) {
        if (empty($companyId)) {
            return '';
        }
        if (!parent::keyExists($companyId)) {
            $this->loadByKey($companyId);
        }
        return parent::get($companyId);
    }

    public
    function cacheAppId($companyId, $appId) {
        parent::set($companyId, $appId);
    }
}