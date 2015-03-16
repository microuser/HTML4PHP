<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpSite.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpForm.php');

/**
 * Description of ContactodexModel
 *
 * @author user
 */
class ContactodexModel extends Html4PhpSite {

    private $contactid = null;

    public function createContactTable() {
        $this->statementPrepare('CREATE TABLE IF NOT EXISTS contactodex_contact (
            contactid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            userid INT NOT NULL, 
            name text,
            phone text,
            company text
            )');
        $this->statementExecute();
    }

    public function createCommentTable() {

        $this->statementPrepare("CREATE TABLE IF NOT EXISTS contactodex_comment (
            commentid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            contactid INT NOT NULL,
            userid INT NOT NULL, 
            comment text
            )");
        $this->statementExecute();
    }

    public function dropContactTable() {
        $this->statementPrepare('DROP TABLE IF EXISTS contactodex_contact');
        $this->statementExecute();
    }

    public function dropCommentTable() {
        $this->statementPrepare('DROP TABLE IF EXISTS contactodex_comment');
        $this->statementExecute();
    }

    public function insertContact($name, $phone, $company){
        $this->statementPrepare("INSERT INTO contactodex_contact (userid, name, phone, company) VALUES (:userid, :name, :phone, :company)" );
        $this->statementBindParam(":userid", $this->getUserId());
        $this->statementBindParam(":name", $name);
        $this->statementBindParam(":phone", $phone);
        $this->statementBindParam(":company", $company);
        $this->statementExecute();
        
        $this->contactid = $this->getPdo()->lastInsertId("contactid");
        return $this->contactid;
    }
    
    public function makeContactForm() {
        $form = new Html4PhpForm("Create Contact");
        $form->startForm("contactodex_contact", $this->getConfig('server', 'relativeUrl') . '/contactodex/index.php');
        $form->addFormInputWithDataType('Name', 'name', 'text');
        $form->addFormInputWithDataType("Phone", "phone", 'text');
        $form->addFormInputWithDataType('Company', 'company', 'text');
        $form->addFormSubmitButton();
        return $form->generateForm("Create Contact");
    }

    public function makeCommentForm() {
        $form = new Html4PhpForm();
        $form->startForm('contactodex_comment', $this->getConfig('server', 'relativeUrl') . 'contactodex/index.php');
        $form->addFormInputHidden('ContactID', 'contactid', $this->contactid);
        $form->addFormInputWithDataType('Comment', 'comment', 'text');
        $form->addFormSubmitButton();
        return $form->generateForm("Create Comment");
    }

    public function makeAdminScreen() {
        $form = new Html4PhpForm();
        if (isset($_REQUEST['admin_create_contact'])) {
            $this->createContactTable();
            $this->addDiv("Created Contact Table", "info");
        }
        if (isset($_REQUEST['admin_drop_contact'])) {
            $this->dropContactTable();
            $this->addDiv("Dropped Contact Table", "info");
        }
        if (isset($_REQUEST['admin_create_comment'])) {
            $this->createCommentTable();
            $this->addDiv("Created Comment Table", "info");
        }
        if (isset($_REQUEST['admin_drop_comment'])) {
            $this->dropCommentTable();
            $this->addDiv("Dropped Comment Table", "info");
        }
        $form->startForm('contactodex_admin', $this->getConfig('server', 'relativeUrl') . 'contactodex/admin.php');
        $form->addFormSubmitButton("Create Contact Table", "admin_create_contact");
        $form->addFormSubmitButton("Drop Contact Table", "admin_drop_contact");
        $form->addFormSubmitButton("Create Comment Table", "admin_create_comment");
        $form->addFormSubmitButton("Drop Comment Table", "admin_drop_comment");

        return $form->generateForm("Admin");
    }

}
