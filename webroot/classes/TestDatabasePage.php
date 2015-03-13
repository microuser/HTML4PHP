<?php

include_once('TestDatabaseModel.php');

/**
 * Description of LoginPage
 *
 * @author user
 */
class TestDatabasePage extends TestDatabaseModel {

    public function __construct($title = "Test Database") {
        parent::__construct();
    }

    public function addTestDatabaseTable() {
        $this->addTable("Describe User Table"
                ,array("#", "Field","Type","Null","Key","Default","Extra")
                , $this->makeDescribeUserTable());
    }
    
    public function addTestUserTable(){
        $this->addTable("User Table", array("#","userid","username","email","passhash","token","created","updated"), $this->makeUserTable());
    }

    public function __toString() {
        return $this->generatePage();
    }

}
