<?php


include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ContactodexModel.php');
/**
 * Description of ContactodexPage
 *
 * @author user
 */
class ContactodexPage extends ContactodexModel{
    public function __construct($title = 'Login') {
        parent::__construct($title);
        $this->requestController();
    }
    
    public function addContactForm(){
        $this->add($this->makeContactForm());
    }
    
    
    public function addAdminScreen(){
        $this->add($this->makeAdminScreen());
    }
    
    public function requestController(){
        $this->requestCreateComment();
    }
    
    private function requestCreateComment(){
        
        $v = new Html4PhpValidator();
        $v->validateRequest(array(
            "name" => 'text',
            "phone" => 'text',
            "company" => 'text'
            ));
        if($v->isValid()){
            $this->insertContact($v->name, $v->phone, $v->company);
        }
        
    }
    private function requestCreateContact(){
        
    }
    
}
