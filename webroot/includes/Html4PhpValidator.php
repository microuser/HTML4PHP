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
    
    private $validatorData = array();
    
    public function __construct(){
        include_once('Html4PhpValidatorData.php');       
    }
    
    public function isMatch($type,$subject){
        if(isset($this->validatorData[$type]) && isset($this->validatorData[$type]['regex'])){
            return preg_match($this->validatorData[$type]['regex'], $subject);
        }
        return false;
    }
    
    
    
    private function runTests(){
        
        
        
        
        
        
        
        
    }
    
}
