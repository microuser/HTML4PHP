<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpSite.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpForm.php');

/**
 * Description of ContactodexModel
 *
 * @author user
 */
class ContactodexModel extends Html4PhpSite {

    protected $contactid = null;
    protected $contactDetails = null;

    public function createContactTable() {
        $this->statementPrepare('CREATE TABLE IF NOT EXISTS contactodex_contact (
            contactid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            userid INT NOT NULL, 
            name text,
            phone text,
            company text,
            email text
            )');
        $this->statementExecute();
    }

    public function createCommentTable() {

        $this->statementPrepare("CREATE TABLE IF NOT EXISTS contactodex_comment (
            commentid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            contactid INT NOT NULL,
            userid INT NOT NULL, 
            comment text,
            timeupdated timestamp default now()
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

    public function insertContact($name, $phone, $company, $email) {
        try {
            $this->statementPrepare("INSERT INTO contactodex_contact (userid, name, phone, company, email) VALUES (:userid, :name, :phone, :company, :email)");
            $this->statementBindParam(":userid", $this->getUserId());
            $this->statementBindParam(":name", $name);
            $this->statementBindParam(":phone", $phone);
            $this->statementBindParam(":company", $company);
            $this->statementBindParam(":email", $email);
            $this->statementExecute();
            $this->contactid = $this->getPdo()->lastInsertId("contactid");
            $this->addDiv("Inserting Contact", "info");
            return $this->contactid;
        } catch (Exception $e) {
            $this->addDiv($e->getMessage());
            $this->addDiv("Error Creating Contact", "warning");
            return false;
        }
    }

    public function updateContact($contactid, $name, $phone, $company, $email) {
        try {
            $this->statementPrepare("Update contactodex_contact (userid, name, phone, company, email) VALUES (:userid, :name, :phone, :company, :email) WHERE contactid=:contactid");
            $this->statementBindParam(":contactid", $contactid);
            $this->statementBindParam(":userid", $this->getUserId());
            $this->statementBindParam(":name", $name);
            $this->statementBindParam(":phone", $phone);
            $this->statementBindParam(":company", $company);
            $this->statementBindParam(":email", $email);
            $this->statementExecute();
            $this->contactid = $this->getPdo()->lastInsertId("contactid");
            $this->addDiv("Contact Updated", "info");
            return $this->contactid;
        } catch (Exception $e) {
            $this->addDiv($e->getMessage());
            $this->addDiv("Error Creating Contact", "warning");
            return false;
        }
    }

    public function insertComment($contactid, $comment) {
        try {
            $this->statementPrepare("INSERT INTO contactodex_comment (contactid, comment, userid) VALUES (:contactid, :comment, :userid)");
            $this->statementBindParam(":contactid", $contactid);
            $this->statementBindParam(":comment", $comment);
            $this->statementBindParam(":userid", $this->getUserId());
            $this->statementExecute();
            $this->contactid = $this->getPdo()->lastInsertId("contactid");
            $this->add("Insert");
            return $this->contactid;
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }

    public function selectContacts() {
        $this->statementPrepare("SELECT contactid, name, phone, company, email FROM contactodex_contact WHERE userid=:userid");
        $this->statementBindParam(":userid", $this->getUserId());
        $this->statementExecute();
        return $this->statementFetchAssocs();
    }

    public function selectContact($contactid) {
        $this->statementPrepare("SELECT contactid, name, phone, company, email FROM contactodex_contact WHERE userid=:userid AND contactid=:contactid");
        $this->statementBindParam(":userid", $this->getUserId());
        $this->statementBindParam(":contactid", $contactid);
        $this->statementExecute();
        $this->contactDetails = $this->statementFetchAssoc();
        return $this->contactDetails;
    }

    public function selectComments($contactid) {
        $this->statementPrepare("SELECT timeupdated, comment FROM contactodex_comment WHERE userid=:userid AND contactid=:contactid order by timeupdated desc");
        $this->statementBindParam("userid", $this->getUserId());
        $this->statementBindParam("contactid", $contactid);
        $this->statementExecute();
        return $this->statementFetchAssocs();
    }

    public function selectCommentsLike($search) {
        $search = '%' . $search . '%';
        $this->statementPrepare("SELECT contactodex_comment.contactid, "
                . "contactodex_contact.name, "
                . "contactodex_contact.phone, "
                . "contactodex_contact.company, "
                . "contactodex_comment.comment, "
                . "contactodex_comment.timeupdated "
                . "FROM contactodex_comment "
                . "JOIN contactodex_contact "
                . "ON (contactodex_contact.contactid = contactodex_comment.contactid) "
                . "WHERE contactodex_comment.userid=:userid "
                . "AND comment like :search "
        );
        $this->statementBindParam(":search", $search);
        $this->statementBindParam('userid', $this->getUserId());
        $this->statementExecute();
        return $this->statementFetchAssocs();
    }

    public function selectContactsLike($search) {
        $search = '%' . $search . '%';
        echo $search;
        $this->statementPrepare('SELECT contactid, name, phone, company, email '
                . 'FROM contactodex_contact '
                . 'WHERE userid=:userid '
                . 'AND ( name like :search OR phone like :search OR company like :search )'
        );
        $this->statementBindParam(":search", $search);
        $this->statementBindParam(':userid', $this->getUserId());
        $this->statementExecute();
        return $this->statementFetchAssocs();
    }

    /**
     * If no values are given, it is used for creating a contact, 
     * if paramers are given, it is used for editing
     * @param type $name
     * @param type $email
     * @param type $phone
     * @param type $company
     * @param type $contactid
     * @return string
     */
    public function makeContactForm($name = '', $email = '', $phone = '', $company = '', $contactid = 0) {
        $form = new Html4PhpForm("Create Contact");
        $form->startForm("contactodex_contact", $this->getConfig('server', 'relativeUrl') . 'contactodex/list.php');

        $form->addFormInputWithDataType('Name', 'name', 'text', $name);
        $form->addFormInputWithDataType('Email', 'email', 'emailAllowEmpty', $email);
        $form->addFormInputWithDataType("Phone", "phone", 'text', $phone);
        $form->addFormInputWithDataType('Company', 'company', 'text', $company);

        if ($contactid) {
            $form->addFormInputHidden("ContactId", "contactid", $contactid);
            $form->addFormSubmitButton("", "", "Edit Contact");
            return $form->generateForm("Edit Contact");
        } else {
            $form->addFormSubmitButton("", "", "Create Contact");
            return $form->generateForm("Create Contact");
        }
    }

    public function makeCommentForm() {
        $form = new Html4PhpForm();
        $form->startForm('contactodex_comment', $this->getConfig('server', 'relativeUrl') . 'contactodex/view.php?contactid=' . $this->contactid);
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
