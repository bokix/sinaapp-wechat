<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-5
 * Time: 14:56
 */
class NetUtil {

    public function get($url) {
        $ch = curl_init();
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // 抓取URL并把它传递给浏览器
        $s = curl_exec($ch);

        curl_close($ch);

        return $s;
    }

    public function post($url, $msg) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        $data = curl_exec($ch);

        curl_close($ch);

        return $data;

    }
}





//end class file. 