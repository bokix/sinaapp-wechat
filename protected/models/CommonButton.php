<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-5
 * Time: 15:01
 */
class CommonButton extends Button{
    public $type;
    public $key;

    /**
     * @param mixed $key
     */
    public function setKey($key) {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * @param mixed $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

}





//end class file. 