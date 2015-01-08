<?php

include_once "Html4PhpDatabase.php";
/**
 * Description of Html4User
 * @version 2015-01-04
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
class Html4PhpUser extends Html4PhpDatabase {

    protected $username = 'guest';
    private $email = '';
    private $passhash = '';

    public function __construct($title) {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        parent::__construct($title);
        session_start();
    }

    private function saltPassword($password) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$password=Hidden');
        $salt1 = $salt2 = '';
        //Uncomment this this salt for more secure passwords.
        //$salt1 = '389c8)C8934nc8&GS43hsdlvf438vjhHEw43vc8597d9sU%vc7se5v6';
        //$salt2 = 'd8e36x8dve47a96evae84ghgliav8DJECICHELEJdfvsiehVOlevhVCG^Y#EH#OCC&t32o4';
        return crypt($password, $salt1+$salt2);
    }

    public function createUser($username, $password, $email) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$username=' . $username . ', $password=Hidden' . ', $email=' . $email);
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
                $this->addDebug(DEBUG_VERBOSE, "<br/>Username is taken<br/>");
                $this->addDebug(DEBUG_VERBOSE, "PDO Exception Code:".$ex->getCode());
                return FALSE;
            }
            $this->addDebug(DEBUG_ERROR_LOG, $ex->getMessage());
        }
        //Insertion was good
        $this->addDebug(DEBUG_VERBOSE, "createUser: Status was:" . $status);
        if ($status == null) {
            //$pdo = new PDO();
            //$statement = new PDOStatement();
            //$statement->errorCode();
            $this->addDebug(DEBUG_VERBOSE, "<br/>status is null. Message is:<pre>" . print_r($this->getStatementErrorCode(), 1) . "</pre>");
            $this->addDebug(DEBUG_VERBOSE, "Inserted Username:".$username);
            $this->add($this->sendEmail($username, $email, "Account Created.", "A username=".$username."  was created at " . date(DATE_RFC2822) . ""));
            $this->add("<br/>");
        }
    }

    public function sendEmail($toName, $toEmail, $subject, $messageHtml) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$toName=' . $toName . ', $toEmail=' . $toEmail . ', $subject=' . $subject . ', $messageHtml=' . $messageHtml);
        $email = new Html4PhpEmail();
        $email->sendEmail($toName, $toEmail, $subject, $messageHtml);
    }

    public function getUidFromUsernameAndPassword($username, $password) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$username=' . $username . ', $password=Hidden');
        $this->username = $username;
        $this->passhash = $this->saltPassword($password);
        $this->statementPrepare("select * from users where username=:username and passhash=:passhash");
        $this->statementBindParam(":username", $this->username);
        $this->statementBindParam(":passhash", $this->passhash);
        $this->statementExecute();
        //TODO return bool if good, not his, perhaps set email too.

        $ret = $this->statementFetchAssoc();

        $this->addDebug(DEBUG_RETURN_VALUE, "Return Value of getUidFromUsernameAndPassword:" . print_r($ret, 1));
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
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        $this->statementPrepare('select email from users where user=:user');
        $this->statementBindParam(":user", $this->username);
        $this->statementExecute();
        return $this->statementFetchAssoc();
    }

    public function getUserCount() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        $this->statementPrepare("select count(*) from user");
        $this->statementExecute();
        return $this->statementFetchAssoc();
    }

}
