<?php
include_once('TestUserModel.php');
/**
 * Description of TestUserPage
 *
 * @author user
 */
class TestUserPage extends TestUserModel{
    public function __construct($title){
        parent::__construct($title);
    }
    
    public function addUserInfo(){
        $this->addTableKeyValue("User Session", array("Key","Value"),$_SESSION);
        $this->addTableKeyValue("User Cookie", array("Key","Value"), $_COOKIE);
        $this->addTableKeyValue("User Request", array("Key","Value"), $_REQUEST);
        $this->addTableKeyValue("User Env", array("Key","Value"), $_ENV);
    }
    
    public function __toString(){
        return $this->generatePage();
    }
}
