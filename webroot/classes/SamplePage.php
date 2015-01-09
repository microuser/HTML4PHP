<?php

include_once('SampleModel.php');

/**
 * Html4PhpSampleApp is a sample page showing how to use the main functions of the Html4Php framework.
 *
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
 */
class SamplePage extends SampleModel {

    public function __construct($title = 'Html4PhpSampleApp') {
        parent::__construct($title);
    }

    public function generateSamplePage() {

        if (isset($_GET['table'])) {
            $this->insertTableName($_GET['table']);
        }
        //$this->makeDatabaseTableTable();
        //$this->makeRandomTable();
        //$this->makeDatabaseUserTable();
        
        //$this->addTable("Test Table as Vertical List", array("Column Name"), array(1,2,3,4,5,6));
        $this->addTable("Test Table as Vertical List with String","Column Name as String", array(1));
        $this->addTable("Test Table as Vertical List with String",null, array(1));
        $this->addTable("Test Table one item",null, 1);
        $this->addTable("Test Table Horizontal", array(1,2,3,4,5), array(1,2,3,4,5));
        
        
        return $this->generatePage();
    }

    public function makeRandomTable() {

        $this->addTable('Title', array('a', 'b', 'c'), array(array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)));
    }

    public function makeDatabaseTableTable() {
        $this->addTable("Show Tables", array("TABLE_NAME","TABLE_TYPE","AUTO_INCREMENT"), $this->getDatabaseTables());

    }
    
    public function makeDatabaseUserTable(){
        $this->addTable("Users", array("users"), $this->getDatabaseUsers());
    }

}
