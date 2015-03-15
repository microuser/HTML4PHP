<?php

include_once('LoginModel.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/TestUserModel.php');

/**
 * Description of LoginPage
 *
 * @author user
 */
class LoginPage extends LoginModel {

    public function __construct($title = "Login") {
        parent::__construct();
    }

    public function addLoginForm() {
        if ((!$this->logoutWithRequest() || $this->getIsLoggedIn() || $this->loginWithRequest())) {
            //Your logged in
            $this->add($this->makeLogoutForm());
        } else {
            $this->add($this->makeLoginForm());
        }
        
        $this->add((new TestUserModel($this))->makeUserInfo());
        
    }

    public function addLogoutForm() {
        $this->add($this->makeLogoutForm());
    }

    
    public function addCreateUserForm() {
        if ($this->requestCreateUser()) {
            $this->add("User Created. Check Email.");
            if(count($this->messages) > 0){
                foreach($this->messages as $message){
                    $this->addDiv($message, "info");
                }
            }
            if(count($this->errors) > 0){
                foreach($this->errors as $errors){
                    $this->addDiv($errors, "warning");
                }
            }
        } else {
            $this->add($this->makeCreateUserForm());
        }
    }

    public function __toString() {
        return $this->generatePage();
    }

}
