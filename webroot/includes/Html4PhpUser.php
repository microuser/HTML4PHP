<?php

include_once "Html4PhpDatabase.php";
/**
 * Description of Html4User
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
 */
class Html4PhpUser extends Html4PhpDatabase {

    protected $username = 'guest';
    private $email = '';
    private $passhash = '';

    public function __construct($title) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        parent::__construct($title);
    }

    private function saltPassword($password) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$password=Hidden');
        $salt1 = $salt2 = '';
        //Uncomment this this salt for more secure passwords.
        //$salt1 = '389c8)C8934nc8&GS43hsdlvf438vjhHEw43vc8597d9sU%vc7se5v6';
        //$salt2 = 'd8e36x8dve47a96evae84ghgliav8DJECICHELEJdfvsiehVOlevhVCG^Y#EH#OCC&t32o4';
        return crypt($password, $salt1+$salt2);
    }

    public function createUser($username, $password, $email) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$username=' . $username . ', $password=Hidden' . ', $email=' . $email);
        try {
            $this->user = $username;
            $this->passhash = $this->saltPassword($password);
            $this->statementPrepare('insert into users (username, passhash, email) VALUES (:username, :passhash, :email)');
            $this->statementBindParam(":username", $username);
            $this->statementBindParam(":passhash", $this->passhash);
            $this->statementBindParam(":email", $email);
            $status = $this->statementExecute();
        } catch (Exception $ex) {
            if ($ex->getCode() == 23000) {
                Html4PhpDebug::add(DEBUG_VERBOSE, "<br/>Username is taken<br/>");
                Html4PhpDebug::add(DEBUG_VERBOSE, "PDO Exception Code:".$ex->getCode());
                return FALSE;
            }
            Html4PhpDebug::add(DEBUG_ERROR_LOG, $ex->getMessage());
        }
        //Insertion was good
        Html4PhpDebug::add(DEBUG_VERBOSE, "createUser: Status was:" . $status);
        if ($status == null) {
            //$pdo = new PDO();
            //$statement = new PDOStatement();
            //$statement->errorCode();
            Html4PhpDebug::add(DEBUG_VERBOSE, "<br/>status is null. Message is:<pre>" . print_r($this->getStatementErrorCode(), 1) . "</pre>");
            Html4PhpDebug::add(DEBUG_VERBOSE, "Inserted Username:".$username);
            $this->add($this->sendEmail($username, $email, "Account Created.", "A username=".$username."  was created at " . date(DATE_RFC2822) . ""));
            $this->add("<br/>");
        }
    }

    public function sendEmail($toName, $toEmail, $subject, $messageHtml) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$toName=' . $toName . ', $toEmail=' . $toEmail . ', $subject=' . $subject . ', $messageHtml=' . $messageHtml);
        $email = new Html4PhpEmail();
        $email->sendEmail($toName, $toEmail, $subject, $messageHtml);
    }

    public function getUidFromUsernameAndPassword($username, $password) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$username=' . $username . ', $password=Hidden');
        $this->username = $username;
        $this->passhash = $this->saltPassword($password);
        $this->statementPrepare("select * from users where username=:username and passhash=:passhash");
        $this->statementBindParam(":username", $this->username);
        $this->statementBindParam(":passhash", $this->passhash);
        $this->statementExecute();
        //TODO return bool if good, not his, perhaps set email too.

        $ret = $this->statementFetchAssoc();

        Html4PhpDebug::add(DEBUG_RETURN_VALUE, "Return Value of getUidFromUsernameAndPassword:" . print_r($ret, 1));
        if (isset($ret[0]) && isset($ret[0]['uid'])) {
            return $ret[0];
        } else {
            return FALSE;
        }
    }

    public function login($username, $password) {
        $uid = $this->getUidFromUsernameAndPassword($username, $password);
        if ($uid === FALSE) {
            $token = sha1(srand() . date() . $username);
            $this->statementPrepare("update users set token=:token where uid=:uid");
            $this->statementBindParam("token", $token);
            $this->statementBindParam("uid", $uid);
            $this->statementExecute();
            $_SESSION[$uid]['token'] = $token;
            $_SESSION[$uid]['username'] = $username;
            $_SESSION[$uid]['loginMicrotime'] = microtime();
            return TRUE;
        } else {
            $_SESSION[$uid]['token'] = null;
            $_SESSION[$uid]['loginMicrotime'] = null;
            return FALSE;
        }
    }

    public function getEmail() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        $this->statementPrepare('select email from users where user=:user');
        $this->statementBindParam(":user", $this->username);
        $this->statementExecute();
        return $this->statementFetchAssoc();
    }

    public function getUserCount() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        $this->statementPrepare("select count(*) from user");
        $this->statementExecute();
        return $this->statementFetchAssoc();
    }

}
