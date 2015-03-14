<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpSite.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpForm.php');

/**
 * Description of LoginModel
 *
 * @author user
 */
class LoginModel extends Html4PhpSite {

    public function __construct($title = "Login") {
        parent::__construct($title);
    }

    public function makeCreateUserForm(){
        $form = new Html4PhpForm();
        $form-> startForm("Create");
        $form->addFormInputWithDataType("Username", "username", "username");
        $form->addFormInputWithDataType("Email","email","email");
        $form->addFormInputPasswordConfirmationWithDataType("Password","password","password");
        $form->addFormSubmitButton("","Create User");
        return $form->generateForm("Create User");
    }
    
    protected function requestCreateUser(){
        $v = new Html4PhpValidator();
        $v->validateRequest(
                array(
                    "username" => "username",
                    "email"    => "email",
                    "password" => "password"
                    )
                );
        if($v->getIsValid()){
            return $this->createUser($v->username, $v->email, $v->password);
        }
        return null;
    }
    
    
    
    public function makeLogoutForm(){
        $form = new Html4PhpForm("Logout");
        $form->startForm("logout");
        $form->addFormSubmitButton("Logout", "Logout");
        return $form->generateForm("Logout");
    }
    
    public function makeLoginForm() {
        $form = new Html4PhpForm("Login");
        $form->startForm("login");
        $form->addFormInputWithDataType("Username","username","username");
        $form->addFormInputPasswordWithDataType("Password","password","password");
        $form->addFormSubmitButton("");
        return $form->generateForm("Login");
    }

    protected function loginWithRequest() {
        $v = new Html4PhpValidator();
        xdebug_break();
        $v->validateRequest(
                array(
                    "username" => "username",
                    "password" => "password"
                )
        );
        if ($v->getIsValid()) {
            return $this->loginWithUsernamePassword($v->username, $v->password);
        }
        return null;
    }
    
    


}
