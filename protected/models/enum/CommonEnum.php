<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-3
 * Time: 15:28
 */
class CommonEnum {
    const YES = 1;
    const NO = 0;

    public function getDesc($code) {
        switch ($code) {
            case self::YES:
                return '是';
            case self::NO:
                return '否';
            default:
                return '否';
        }
    }
}





//end class file. 