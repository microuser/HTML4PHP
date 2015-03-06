<?php

include_once('SampleModel.php');

/**
 * Html4PhpSampleApp is a sample page showing how to use the main functions of the Html4Php framework.
 *
 * @version 2015-01-12
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

                       include_once($_SERVER['DOCUMENT_ROOT'].'/includes/Html4PhpElement.php');
        $tab = new Html4PhpElement_Tab();
        $tab->append("Database Table", $this->makeDatabaseTableTable());
        $tab->append("Random Table",  $this->makeRandomTable());
        $tab->append("User Table", $this->makeDatabaseUserTable());
        $this->add($tab->generateHtml());
        
        
        
        if (isset($_GET['table'])) {
            $this->insertTableName($_GET['table']);
        }
        

        return $this->generatePage();
    }

    public function makeRandomTable() {

        return $this->makeTable('Title', array('a', 'b', 'c'), array(array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)));
    }

    public function makeDatabaseTableTable() {
        return $this->makeTable("Show Tables", array("TABLE_NAME","TABLE_TYPE","AUTO_INCREMENT"), $this->getDatabaseTables());

    }
    
    public function makeDatabaseUserTable(){
        return $this->makeTable("Users", array("users"), $this->getDatabaseUsers());
    }

}
