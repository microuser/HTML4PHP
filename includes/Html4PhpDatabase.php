<?php

include_once("Html4PhpDebug.php");
include_once('Html4PhpConfig.php)');

/**
 * Description of Html4Database
 *
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
 */
class Html4PhpDatabase extends Html4PhpConfig{

    /**
     * PDO
     * @var PDO
     */
    private $pdo;

    /**
     * Statement
     * @var PDOStatement
     */
    private $statement;

    public function getStatementErrorInfo(){
        return $this->statement->errorInfo();
    }
    
    public function getStatementErrorCode(){
        return $this->statement->errorCode();
    }
    

    public function __destruct() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, "Database Close");
    }

    /**
     * Construct the Html4Database. Connect to local instance if DEV environment. Connect to Production database if server name matches production domain.
     * @param String $title
     */
    public function __construct($title) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);

        if ($_SERVER['SERVER_NAME'] == $this->getConfig('production','server','domainName') || $_SERVER['SERVER_NAME'] == $this->getConfig('production','server','domainName2')) {
            $dbHost = $this->getConfig('production', 'database', 'dbHost');
            $dbName = 'database_name';
            $dbUser = 'username_database';
            $dbPass = '';
        } elseif ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == '192.168.0.2') {
            $dbHost = 'localhost';
            $dbName = 'database_name';
            $dbUser = 'username_database';
            $dbPass = '';
        } else {
            Html4PhpDebug::add(DEBUG_ERROR,"Server production environment not detected. Entry needed for " . filter_var($_SERVER['SERVER_NAME']) . "<br/>Dropping off the deap end.<br/>");
            die();
        }
        try {
            $this->pdo = new PDO(
                    "mysql:host=$dbHost;dbname=$dbName"
                    , $dbUser
                    , $dbPass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            Html4PhpDebug::add(DEBUG_ERROR, "DB Failure:" . $ex->getMessage());
        }
    }

    /**
     * PDO Prepare the query into the statement. Used before Bind Parameter and Execute.
     * @param String $query Sql Query
     */
    public function statementPrepare($query) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        $this->statement = $this->pdo->prepare($query);
    }

    /**
     * Bind paramter to the statement.
     * @param type $param
     * @param type $value
     */
    public function statementBindParam($param, $value) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        $this->statement->bindParam($param, $value);
    }

    /**
     * Bind each parameters from the array as param => value into the statement.
     * @param type $keyValuePair
     */
    public function statementBindParams($keyValuePair) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        foreach ($keyValuePair as $param => $value) {
            $this->statement->bindParam($param, $value);
        }
    }

    /**
     * Simple PDO execute
     */
    public function statementExecute() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        $this->statement->execute();
    }

    /**
     * PDO Execute and fetch one row into array
     * @return Array 
     */
    public function statementFetchAssoc() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * PDO Execute and return one row into class object
     * @return type
     */
    public function statementFetchObject() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * PDO Execute and return all rows into an array of an array
     * @return type
     */
    public function statementFetchAssocs() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * PDO Execute and return all rows into an array of objects
     * @return type
     */
    public function statementFetchObjects() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Return the pdo object for direct access
     * @return type
     */
    public function getPdo() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        return $this->pdo;
    }

    /**
     * Return the pdo statement for direct access, usually error log.
     * @return type
     */
    public function getStatement() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        return $this->statement;
    }

}
