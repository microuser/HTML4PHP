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

    public function addLoginForm() {
        if (($this->loginWithSessionCookieToken() || $this->loginWithRequest())) {
            //Your logged in
            $this->add($this->makeLogoutForm());
        } else {
            $this->add($this->makeLoginForm());
        }
    }

    public function addLogoutForm() {
        $this->add($this->makeLogoutForm());
    }

    public function addCreateUserForm() {
        if ($this->createUserWithRequest()) {
            $this->add("User Created. Check Email.");
        } else {
            $this->add($this->makeCreateUserForm());
        }
    }

    public function __toString() {
        return $this->generatePage();
    }

}
