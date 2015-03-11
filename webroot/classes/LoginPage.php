<?php

include_once('LoginModel.php');

/**
 * Description of LoginPage
 *
 * @author user
 */
class LoginPage extends LoginModel {

    public function __construct($title = "Login") {
        parent::__construct();
    }

    public function addLoginPage() {
        if (($this->loginWithSessionCookieToken() || $this->loginWithRequest())) {
            //Your logged in
            $this->add($this->makeLogoutForm());
        } else {
            $this->add($this->makeLoginForm());
        }
    }
    
    public function addLogoutPage(){
        $this->add($this->makeLogoutForm());
    }
    
    public function addCreatePage(){
        $this->add($this->makeCreateUserForm());
    }

}
