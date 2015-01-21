<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Html4PhpValidator
 *
 * @author user
 */
class Html4PhpValidator {

    public $validatorData = null;

    public function __construct() {

        include('Html4PhpValidatorData.php');
        $this->validatorData = $validatorData;
    }

    public function isMatch($type, $subject, &$matches) {
        if (isset($this->validatorData[$type])) {
            return preg_match('/'.$this->validatorData[$type].'/', $subject, $matches);
        } else {
            return false;
        }
        echo "Type does not match entry.";
    }

}
