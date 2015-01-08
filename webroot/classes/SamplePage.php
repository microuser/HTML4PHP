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
    
    public function generateSamplePage(){
        
        $this->makeDatabaseTableTable();
        $this->makeRandomTable();
        return $this->generatePage();
    }
    
    public function makeRandomTable(){
        
        $this->addTable('Title', array('a','b','c'), array(array(1,2,3),array(4,5,6), array(7,8,9)));
        
    }
    
    public function makeDatabaseTableTable(){
        $this->addTable("Show Tables", array("Tables"), $this->getDatabaseTables());
    }

}
