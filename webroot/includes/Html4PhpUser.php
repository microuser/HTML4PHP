<?php

include_once "Html4PhpDatabase.php";

/**
 * Description of Html4User
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
class Html4PhpUser extends Html4PhpDatabase {

    protected $username = null;
    private $userId = null;
    private $email = null;
    private $passhash = null;

    public function __construct($title) {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        parent::__construct($title);
        session_start();
    }

    private function resetUser() {
        $this->username = null;
        $this->userId = null;
        $this->email = null;
        $this->passhash = null;
    }

    /**
     * Set the username to the Html4PHPUser class only if its valid. Return true on success.
     * Valid if length 1-128 and english letters and numbers
     * @param string $username
     * @return boolean
     */
    private function setUsername($username) {
        if (strlen($username) <= 128 && strlen($username) > 1) {
            if (preg_match('/^[a-zA-Z0-9]+$/',$username)) {
                $this->username = $username;
                return true;
            } else {
                $this->errors[] = "The username needs to only contain english letters or numbers";
            }
        } else {
            $this->errors[] = "The username needs to have length from 1 to 128)";
        }
        return false;
    }

    /**
     * The password can be any character, but needs to have at least one UPPERCASE, one lowercase, and a number with a length of at least 8. Return true on success.
     * @param string $password
     * @return boolean
     */
    private function validateRulesPassword($password) {
        if (strlen($password) >= 8) {
            /* //This dones't allow special chars, 
              if (preg_match('/^'
              . '([a-z]+[A-Z]+[0-9]+)+|'
              . '([a-z]+[0-9]+[A-Z]+)+|'
              . '([0-9]+[a-z]+[A-Z]+)+|'
              . '([0-9]+[A-Z]+[a-z]+)+|'
              . '([A-Z]+[a-z]+[0-9]+)+|'
              . '([A-Z]+[0-9]+[a-z]+)+$/', $password)) {
             */
            //This allows for special characters
            if (preg_match('/^'
                            . '(.*[a-z]+.*[A-Z]+.*[0-9]+.*)+|'
                            . '(.*[a-z]+.*[0-9]+.*[A-Z]+.*)+|'
                            . '(.*[0-9]+.*[a-z]+.*[A-Z]+.*)+|'
                            . '(.*[0-9]+.*[A-Z]+.*[a-z]+.*)+|'
                            . '(.*[A-Z]+.*[a-z]+.*[0-9]+.*)+|'
                            . '(.*[A-Z]+.*[0-9]+.*[a-z]+.*)+$/', $password)) {
                return true;
            } else {
                $this->errors[] = "The password needs to have at least one UPPERCASE, one lowercase, and a number.";
            }
        } else {
            $this->errors[] = "The passwords is needs a length of 8 or more.";
        }
        return false;
    }

    /**
     * Set the email to the class Html4PhpUser if it passed email validation. Return true on success.
     * @param string $email
     * @return boolean
     */
    private function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }

    /**
     * The the password to the class Html4PhpUser if it passed validation from validateRulesPassword(). Return true on success.
     * @param string $password
     * @return boolean
     */
    private function setPasshashFromPassword($password) {
        if ($this->validateRulesPassword($password)) {
            $this->passhash = password_hash($password, PASSWORD_BCRYPT);
            return true;
        }
        return false;
    }

    public function createUser($username, $email, $password) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$username=' . $username . ', $password=Hidden' . ', $email=' . $email);
        try {
            if ($this->setUsername($username) && $this->setEmail($email) && $this->setPasshashFromPassword($password)) {
                $this->statementPrepare('INSERT INTO user (username, email, passhash) VALUES (:username, :email, :passhash)');
                $this->statementBindParam(":username", $this->username);
                $this->statementBindParam(":email", $this->email);
                $this->statementBindParam(":passhash", $this->passhash);
                $status = $this->statementExecute();
                $this->errors[] = $this->getPdo()->errorCode();
                $this->errors[] = "User created";
            } else {
                $this->errors[] = "User not created.";
                $this->resetUser();
                $status = false;
            }
        } catch (Exception $ex) {
            $this->errors[] = "User not created." . $ex->getMessage();
            $this->resetUser();
            if ($ex->getCode() == 23000) {
                $this->addDebug(DEBUG_VERBOSE, "<br/>Username is taken<br/>");
                $this->addDebug(DEBUG_VERBOSE, "PDO Exception Code:" . $ex->getCode());
                return FALSE;
            }
            $this->addDebug(DEBUG_ERROR_LOG, $ex->getMessage());
        }
        //Insertion was good
        //$this->addDebug(DEBUG_VERBOSE, "createUser: Status was:" . $status);
        //if ($status == null) {
        //    //$pdo = new PDO();
        //    //$statement = new PDOStatement();
        //    //$statement->errorCode();
        //    $this->addDebug(DEBUG_VERBOSE, "<br/>status is null. Message is:<pre>" . print_r($this->getStatementErrorCode(), 1) . "</pre>");
        //    $this->addDebug(DEBUG_VERBOSE, "Inserted Username:" . $username);
        //    $this->add($this->sendEmail($username, $email, "Account Created.", "A username=" . $username . "  was created at " . date(DATE_RFC2822) . ""));
        //    $this->add("<br/>");
        //}
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
