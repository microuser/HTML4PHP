<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/includes/Html4PhpPage.php');

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
class SampleModel extends Html4PhpPage {

    public function __construct($title = 'Html4PhpSampleApp') {
        parent::__construct($title);
    }
    
    public function getDatabaseTables(){
        
        $this->statementPrepare("show tables");
        echo $this->getStatementErrorCode();        
        $this->statementExecute();
               
        return $this->statementFetchAssocs();
    }
    
    public function insertTableName($value){
        $this->statementPrepare("create table testTable3 (col1 int, col2 int)");
        //$this->statementBindParam(":testTable", $value);
        $this->statementExecute();
    }

}