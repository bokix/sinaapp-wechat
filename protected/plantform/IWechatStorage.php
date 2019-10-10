<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-10
 * Time: 11:30
 */
interface IWechatStorage {
    public function getTmpFS();

    public function upload($file, $destFileName);

    public function  resizeImg($originFile, $destWidth,
                               $destHeight);

    public function  delete($fileName);
}


//end file. 