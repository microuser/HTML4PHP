<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpSite.php');


/**
 * Description of TestDatabaseModel
 *
 * @author user
 */
class TestDatabaseModel extends Html4PhpSite {
    
    public function __construct($title = 'TestDatabaseModel'){
        parent::__construct($title);
    }
    
    public function makeDescribeUserTable(){
        try{
        $this->statementPrepare("describe `user`" );
        $this->statementExecute();
        return $this->statementFetchEnumeratedAssocs();
        } catch (Exception $ex) {
            $this->errors[] = $ex->getMessage();
        }
    }
    
    public function createUserTable(){
        $this->statementPrepare('create table if not exists `user` (
            userid int(11) not null auto_increment Primary Key,
            username varchar(255) not null, 
            email varchar(255) not null, 
            passhash varchar(255) not null,
            token varchar(255) null
            )');
    }
    
    
}
