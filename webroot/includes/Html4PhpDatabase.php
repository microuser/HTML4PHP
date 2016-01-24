<?php
include_once('Html4PhpConfig.php');

/**
 * Description of Html4Database
 *
 * @version 2015-01-12
 * @category PHP Framework
 * @package HTML4PHP
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT OR GPL
 * <pre>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions: The above copyright notice, this permission notice, and the public RSA key shall be included in all copies or substantial portions of the Software. THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-----BEGIN RSA PUBLIC KEY----- ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDfpROYHVyYHe2yok8Ut5OEmNzNriV9QGdzzPm1vFJSf8Wp9iBY74xf5oYdMmUOOfLlZfcrXP6Dc3VXOlTU7P46t14s9CcoGR6As2EamV7q9sAh4Nkr6xZb4kNdy9Bd4SxY/I3kxEbTpbpPq2T5B68xJWVjf83SQI43eyjO2Hv3iA8iEyifeyAGNVX46X3uuCsBftXF5Ng1GCCp6fMeCXeY0p3qmOg7m6SMGAXY97hKakNHPN2+vDP2fCOfefFmZihP/0mQNNLu1VNfI3MKonyfiHI4k1WAbFP2ozWSGmzv3dhej3wguYmRYKsgkK3ay5QoZQSLDHnZXtkuO9rJbAuz -----END RSA PUBLIC KEY-----
 * </pre>
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
        
        if(is_string($title)){
            parent::__construct($title);
        }else {
            parent::__construct($title);
        }
        


        try {
            $dbHost = $this->getConfig('database', 'dbHost');
            $dbName = $this->getConfig('database', 'dbName');
            $dbUser = $this->getConfig('database', 'dbUser');
            $dbPass = $this->getConfig('database', 'dbPass');
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
            die();
        }
        
        //return $this;
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
        return $this->statement->execute();
    }

    public function statementRowCount(){
        $this->statement->rowCount();
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
     * PDO return all rows into an array of an array
     * @return type
     */
    public function statementFetchAssocs() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    /**
     * PDO return all rows into an array of an array with a number in front of it to preserve original ordering.
     * @return type
     */
    public function statementFetchEnumeratedAssocs(){
        $ret = array();
        foreach($this->statementFetchAssocs() as $key => $row){
            array_unshift($row, $key);
            $ret[] = $row;
        }
        return $ret;
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
