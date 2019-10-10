<?php

/**
 * Created by PhpStorm.
 * User: bokix
 * Date: 14-2-21
 * Time: 16:38
 */
class SAELog {
    public static function debug($msg) {

        if (Yii::app()->params['localMode']) {
            Yii::log($msg);
        } else {
            sae_set_display_errors(false); //关闭信息输出
            sae_debug($msg); //记录日志
            sae_set_display_errors(true); //记录日志后再打开信息输出，否则会阻止正常的错误信息的显示
        }
    }
} 