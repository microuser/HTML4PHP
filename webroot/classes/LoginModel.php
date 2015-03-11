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
        $form->addFormInputCustomRegexp("Username", "username", '', '', '0', 5000, 'Error', 'custom', $form->validatorData['alphanumeric']);
        //$form->addFormInputAlphanumeric("Username", "username");
        $form->addFormInputEmail("Email", "email");
        $form->addFormInputPasswordAndConfirmation("Password","password");
        $form->addFormSubmitButton("","Create User");
        return $form->generateForm("Create User");
    }

    public function makeLogoutForm(){
        $form = new Html4PhpForm("Logout");
        $form->startForm("logout");
        $form->addFormSubmitButton("", "Logout");
        return $form->generateForm("Logout");
    }
    
    public function makeLoginForm() {
        $form = new Html4PhpForm("Login");
        $form->startForm("login");
        $form->addFormInputAlphanumeric("Username", "username");
        $form->addFormInputPassword("Password", 'password');
        $form->addFormSubmitButton("");
        return $form->generateForm("Login");
    }

    protected function loginWithRequest() {
        $v = new Html4PhpValidator();
        $v->validateRequest(
                array(
                    "username" => "text",
                    "password" => "password"
                )
        );
        if ($v->getIsValid()) {
            return $this->loginWithUsernamePassword($v->username, $v->password);
        }
        return null;
    }
    
    protected function createUserWithRequest(){
        $v = new Html4PhpValidator();
        $v->validateRequest(
                array(
                    "username" => "alphanumeric",
                    "email" => "email",
                    "password" => "passwordSpecialCharLength8OrMore"
                    )
                );
        if($v->getIsValid()){
            $this->addDiv("Is Valid");
            return $this->createUser($v->username, $v->email, $v->password);
        }
        return null;
        
    }

}
