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
    
      
    
    
    public function makeLogoutForm(){
        
        $form = new Html4PhpForm("Logout");
        $form->startForm("logout",$this->getConfig('server', 'relativeUrl'));
        $form->addFormSubmitButton("Logout", "Logout");
        return $form->generateForm("Logout");
    }
    
    public function makeLoginForm() {
        $form = new Html4PhpForm("Login");
        $form->startForm("login",$this->getConfig('server', 'relativeUrl'));
        $form->addFormInputWithDataType("Username","username","username");
        $form->addFormInputPasswordWithDataType("Password","password","password");
        $form->addFormSubmitButton("");
        return $form->generateForm("Login");
    }


    
    


}
