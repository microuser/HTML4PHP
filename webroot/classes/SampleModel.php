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
        try{
        //$this->statementPrepare("show tables");
        $baseTable = "Base Table";
        
        $this->statementPrepare("SELECT TABLE_NAME,TABLE_TYPE,AUTO_INCREMENT FROM information_schema.tables");
        $this->statementBindParam(":baseTable", $baseTable);

        
        echo $this->getStatementErrorCode();        
        $this->statementExecute();
        
        //xdebug_break();
        return $this->statementFetchAssocs();
        }
        catch(Exception $e){
            return array("1");
        }
    }
    
    public function insertTableName($value){
        try{
        $this->statementPrepare("create table ".  filter_var( htmlentities($value),FILTER_SANITIZE_STRING)." (col1 int, col2 int)");
        
        $this->statementExecute();
        }
        catch(Exception $e){
            
        }
        

    }
    
    public function getDatabaseUsers(){
        try{
        $this->statementPrepare("SELECT * FROM mysql.user");
        $this->statementExecute();
        return $this->statementFetchAssocs();
        }
        catch(Exception $e) {
            return array(array("ACCESS IS DENIED FOR YOUR USER"));
        }
    }
    

}
