<?php
/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-4
 * Time: 15:31
 */

class OrderTakeOutEnum {
    const NOT_TAKE_OUT = 0; //堂食
    const TAKE_OUT = 1; //外卖
    public static function getDesc($isTakeOut = 0) {
        switch ($isTakeOut) {
            case self::NOT_TAKE_OUT:
                return "堂食";
            case self::TAKE_OUT:
                return "外卖";
            default:
                return "堂食";
        }
    }
}





//end class file. 