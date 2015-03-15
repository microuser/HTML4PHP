<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpSite.php');

/**
 * Description of TestUserModel
 *
 * @author user
 */
class TestUserModel extends Html4PhpSite {

    public function __construct($title = null) {
        if ($title === null) {
            include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpDatabase.php');
            Html4PhpDatabase::__construct("Standalone");
        } else {
            parent::__construct($title);
        }
    }

    public function makeUserInfo() {
        return
                $this->makeTableKeyValue("User Session", array("Key", "Value"), $_SESSION, null, null, null, array(25, 75))
                . $this->makeTableKeyValue("User Cookie", array("Key", "Value"), $_COOKIE, null, null, null, array(25, 75))
                . $this->makeTableKeyValue("User Request", array("Key", "Value"), $_REQUEST, null, null, null, array(25, 75))
                . $this->makeTableKeyValue("User Request", array("Key", "Value"), $_REQUEST, null, null, null, array(25, 75))
                . $this->makeTable("User Count", array("count"), array($this->makeUserList()));
    }
    
    public function makeUserList(){
        $this->statementPrepare("SELECT count(*) from `user`");
        $this->statementExecute();
        return $this->statementFetchAssoc();
        
        
        
    }

}
