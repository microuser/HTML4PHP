<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/ContactodexModel.php');

/**
 * Description of ContactodexPage
 *
 * @author user
 */
class ContactodexPage extends ContactodexModel {

    public function __construct($title = 'Login') {
        parent::__construct($title);
        $this->requestController();
    }

    public function addContactForm() {
        $this->add($this->makeContactForm());
    }

    public function addAdminScreen() {
        $this->add($this->makeAdminScreen());
    }

    public function requestController() {
        $this->requestContactView();
        $this->requestCreateComment() || $this->requestEditContact() || $this->requestCreateContact();
    }

    private function requestContactView() {

        $v = new Html4PhpValidator();
        $v->validateRequest(array(
            "contactid" => 'numbersInteger',
        ));
        if ($v->isValid()) {
            $this->contactid = $v->contactid;
            $this->selectContact($this->contactid);
        }
    }

    private function requestCreateContact() {

        if (!isset($_REQUEST['contactid'])) {
            $v = new Html4PhpValidator();
            $v->validateRequest(array(
                "name" => 'text',
                "phone" => 'text',
                "company" => 'text',
                'email' => 'emailAllowEmpty',
            ));
            if ($v->isValid()) {
                $this->insertContact($v->name, $v->phone, $v->company, $v->email);
            }
        }
    }

    private function requestEditContact() {

        $v = new Html4PhpValidator();
        $v->validateRequest(array(
            "contactid" => 'numbersInterger',
            "name" => 'text',
            "phone" => 'text',
            "company" => 'text',
            'email' => 'emailAllowEmpty',
        ));
        if ($v->isValid()) {
            $this->updateContact($v->contactid, $v->name, $v->phone, $v->company, $v->email);
        }
    }

    private function requestCreateComment() {
        $v = new Html4PhpValidator();
        $v->validateRequest(array(
            "comment" => "text",
            "contactid" => "numbersInteger"
        ));
        if ($v->isValid()) {
            $this->insertComment($v->contactid, $v->comment);
            header("location: view.php?contactid=" . $v->contactid);
        }
    }

    public function addContactTable() {
        $contacts = array();
        foreach ($this->selectContacts() as $contactRow) {
            $id = array_shift($contactRow);
            array_unshift($contactRow, '<a href="view.php?contactid=' . $id . '">View Comments</a>');
            $contacts[] = $contactRow;
        }

        $this->addTable("Contacts", array("Action", "name", 'phone', 'company', 'email'), $contacts); //, null, null, null, array());
    }

    public function addContactEdit() {

        //Edit Details
        if ($this->contactDetails !== null) {
            $this->add($this->makeContactForm(
                            $this->contactDetails['name']
                            , $this->contactDetails['email']
                            , $this->contactDetails['phone']
                            , $this->contactDetails['company']
                            , $this->contactDetails['contactid'])
            );
            $form = new Html4PhpForm("Create Comment");
            $form->startForm("Create Comment");
            $form->addFormTextArea("Comment", "comment", 512, ''); //''$dataValidation, $charactersPerLine, 6)
            $form->addFormInputHidden("contactid", "contactid");
            $form->addFormSubmitButton("Create Comment");
            $this->add($form->generateForm("Create Comment"));

            $com = array();
            foreach ($this->selectComments($this->contactDetails['contactid']) as $comment) {
                $com[] = array($comment['timeupdated'], $comment['comment']);
            }
            $this->addTable("", array("Updated", "Comment"), $com, null, null, null, array("150px", "100%"));
        } else {
            //They faked data.
            header("location: list.php");
        }



        //View Table of comments
        //Create Comments
    }

    public function addSearch() {
        
        $form = new Html4PhpForm("Search");
        $form->startForm("Search");
        $form->addFormInputWithDataType('Search','search','text');
        $form->addFormSubmitButton();
        $this->add($form->generateForm("Search"));
        
        $v = new Html4PhpValidator();
        $v->validateRequest(array("search" => "text"));
        if($v->isValid()){
            $this->addTable("Search Results: Contacts", array("Asdf","asdf"), $this->selectContactsLike($v->search));
            $this->addTable("Search Results: Comment", array("Action","Name","Phone","Company","Comment", "Updated"), $this->selectCommentsLike($v->search));
        }
        
    }

}
