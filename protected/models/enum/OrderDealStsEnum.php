<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-3
 * Time: 15:15
 */
class OrderDealStsEnum {

    const NOT_DEAL = 0; //未处理
    const CONFIRMED = 1; //已确认
    const REJECTED = 2; //已拒绝
    public static function getDesc($dealStsCode = 0) {
        switch ($dealStsCode) {
            case self::NOT_DEAL:
                return "未处理";
            case self::CONFIRMED:
                return "已确认";
            case self::REJECTED:
                return "已拒绝";
            default:
                return "未处理";
        }
    }
}





//end class file. 