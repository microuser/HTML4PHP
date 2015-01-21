<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/Html4PhpSite.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/Html4PhpValidator.php');

/**
 * Description of ValidatorModel
 *
 * @author user
 */
class ValidatorModel extends Html4PhpSite{
    
    private $validator = null;
    
    public function __construct($title) {
        parent::__construct($title);
        $this->validator = new Html4PhpValidator();
       
    }
    
    public function getValidatorData(){
        return $this->validator->validatorData;
    }
    
    public function isMatch($type, $subject, &$matchArray){
        return $this->validator->isMatch($type, $subject, $matchArray);
    }
    
    
}
