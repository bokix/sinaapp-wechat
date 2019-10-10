<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-5
 * Time: 15:03
 */
class ComplexButton extends Button {
    public $sub_button;

    /**
     * @param mixed $sub_button
     */
    public function setSubButton($sub_button) {
        $this->sub_button = $sub_button;
    }

    /**
     * @return mixed
     */
    public function getSubButton() {
        return $this->sub_button;
    }

}





//end class file. 