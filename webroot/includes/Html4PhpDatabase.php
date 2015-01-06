<?php
include_once('Html4PhpConfig.php');

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
class Html4PhpDatabase extends Html4PhpConfig {

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

    public function getStatementErrorInfo() {
        return $this->statement->errorInfo();
    }

    public function getStatementErrorCode() {
        return $this->statement->errorCode();
    }

    public function __destruct() {
        $this->addDebug(DEBUG_FUNCTION_TRACE, "Database Close");
    }

    /**
     * Construct the Html4Database. Connect to local instance if DEV environment. Connect to Production database if server name matches production domain.
     * @param String $title
     */
    public function __construct($title) {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        parent::__construct($title);


        try {
            $dbHost = $this->getConfig('database', 'dbHost');
            $dbName = $this->getConfig('database', 'dbName');
            $dbUser = $this->getConfig('database', 'dbUser');
            $dbPass = $this->getConfig('database', 'dbPass');
            echo $dbHost . " " . $dbName . " " . $dbUser . " " . $dbPass;
            $this->pdo = new PDO(
                    "mysql:host=$dbHost;dbname=$dbName"
                    , $dbUser
                    , $dbPass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            $this->addDebug(DEBUG_ERROR, "DB Failure:" . $ex->getMessage());
            echo "<br/>\n" . $ex->getMessage();
            echo "\nNo Database Connection";
        }
    }

    /**
     * PDO Prepare the query into the statement. Used before Bind Parameter and Execute.
     * @param String $query Sql Query
     */
    public function statementPrepare($query) {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        $this->statement = $this->pdo->prepare($query);
    }

    /**
     * Bind paramter to the statement.
     * @param type $param
     * @param type $value
     */
    public function statementBindParam($param, $value) {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        $this->statement->bindParam($param, $value);
    }

    /**
     * Bind each parameters from the array as param => value into the statement.
     * @param type $keyValuePair
     */
    public function statementBindParams($keyValuePair) {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        foreach ($keyValuePair as $param => $value) {
            $this->statement->bindParam($param, $value);
        }
    }

    /**
     * Simple PDO execute
     */
    public function statementExecute() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        $this->statement->execute();
    }

    /**
     * PDO Execute and fetch one row into array
     * @return Array 
     */
    public function statementFetchAssoc() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * PDO Execute and return one row into class object
     * @return type
     */
    public function statementFetchObject() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * PDO Execute and return all rows into an array of an array
     * @return type
     */
    public function statementFetchAssocs() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * PDO Execute and return all rows into an array of objects
     * @return type
     */
    public function statementFetchObjects() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Return the pdo object for direct access
     * @return type
     */
    public function getPdo() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        return $this->pdo;
    }

    /**
     * Return the pdo statement for direct access, usually error log.
     * @return type
     */
    public function getStatement() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        return $this->statement;
    }

}
