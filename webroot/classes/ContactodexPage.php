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
        
    }
    
}
