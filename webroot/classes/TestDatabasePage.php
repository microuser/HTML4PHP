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

    public function addTestDatabase() {
        $this->addTable("Describe User Table"
                ,array("#", "Field","Type","Null","Key","Default","Extra")
                , $this->makeDescribeUserTable());
    }

    public function __toString() {
        return $this->generatePage();
    }

}
