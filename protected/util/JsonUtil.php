<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-5
 * Time: 15:13
 */
class JsonUtil {
    private static function arrayEncode(&$arr) {
        foreach ($arr as $k => $v) {
            if (is_array($v) || is_object($v)) {
                self::arrayEncode($v);
            } else {
                if (is_string($v)) {
                    if (is_array($arr)) {
                        $arr[$k] = urlencode($v);
                    } elseif (is_object($arr)) {
                        $arr->$k = urlencode($v);
                    } else {
                        //????
                        $arr[$k] = urlencode($v);
                    }
                }
            }

            if (is_string($k)) {
                $nk = urlencode($k);

                if ($nk != $k) {
                    if (is_array($arr)) {
                        $arr[$nk] = $arr[$k];
                        unset($arr[$k]);
                    } elseif (is_object($arr)) {
                        $arr->$nk = $arr->$k;
                        unset($arr->$k);
                    } else {
                        $arr[$nk] = $arr[$k];
                        unset($arr[$k]);
                    }
                }
            }
        }
    }

    /**
     * json_encode()不支持中文，此方法稍作包装
     * @param $arr
     * @return string
     */
    static function getZhJson($arr) {
        self::arrayEncode($arr);
        return urldecode(json_encode($arr));
    }
}





//end class file. 