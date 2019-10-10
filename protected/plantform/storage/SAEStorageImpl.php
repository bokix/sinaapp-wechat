<?php
/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-10
 * Time: 13:59
 */
Yii::import('application.plantform.*');
Yii::import('application.util.*');

class SAEStorageImpl implements IWechatStorage {

    public function getTmpFS() {
        return SAE_TMP_PATH;
    }

    public function upload($file, $destFileName) {
        $s = new SaeStorage();
        SAELog::debug($destFileName);
        $b = $s->write($this->getDomain($destFileName), $destFileName, $file);
        if ($b === false) {
            SAELog::debug("upload false.");
        } else {
            SAELog::debug(strval($b));
        }
       // $u = $s->getUrl($this->getDomain($destFileName), $destFileName);
        return $b;
    }

    /**
     * @param $originFile
     * @param $destWidth
     * @param $destHeight
     * @return 返回二进制数据
     * @throws CHttpException
     */
    public function resizeImg($originFile, $destWidth,
                              $destHeight) {

        list($width, $height, $type, $attr) = getimagesize($originFile);

        SAELog::debug("width:$width,height:$height,type:$type");
        $data = file_get_contents($originFile);
        $img =  new SaeImage($data);
        if (max($width, $height) > max($destWidth, $destHeight)) {
            SAELog::debug("to resize...");

            do {
                $img->resizeRatio(0.75);
                $data = $img->exec();
                if ($data === false) {
                    throw new CHttpException(500, 'resize image error.');
                    return null;
                }
                $img = new SaeImage($data);

                list($width, $height, $type, $attr) = $img->getImageAttr();
            } while (max($width, $height) > max($destWidth, $destHeight));
        }
        SAELog::debug("result:$width,$height");
        return $data;
    }

    public function  delete($destFileName) {
        $s = new SaeStorage();
        SAELog::debug('delete:' . $destFileName);
        $b = $s->delete($this->getDomain($destFileName), $destFileName);
        return $b;
    }

    private function getDomain($destFileName) {
        return 'domain1';
    }
}





//end class file. 