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
        $this->createUserTable();
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
    
    public function makeUserTable(){
        try{
        $this->statementPrepare("select * from `user`" );
        $this->statementExecute();
        return $this->statementFetchEnumeratedAssocs();
        } catch (Exception $ex) {
            $this->errors[] = $ex->getMessage();
        }
    }
    
    
    
    public function createUserTable(){
        /*
        $this->statementPrepare("create table if not exists `user` (
            userid int(11) not null auto_increment Primary Key,
            username varchar(255) not null, 
            email varchar(255) not null, 
            passhash varchar(255) not null,
            token varchar(255) null,
            timecreated timestamp null default '0000-00-00 00:00:00',
            timeupdated timestamp default now() on update now()
            )");
         * 
         */
        $this->statementPrepare("create table if not exists `user` (
            userid int(11) not null auto_increment Primary Key,
            username varchar(255) not null unique, 
            email varchar(255) not null unique, 
            passhash varchar(255) not null,
            token varchar(255) null,
            timecreated timestamp null default '0000-00-00 00:00:00',
            timeupdated timestamp default now() on update now()
            )");
        $this->statementExecute();
    }
    
    
}
