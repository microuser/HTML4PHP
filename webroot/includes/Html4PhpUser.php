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

    private $loggedin = false;
    private $username = null;
    private $userId = null;
    private $email = null;
    private $passhash = null;
    private $token = null;
    public $errors = array();
    public $messages = array();

    public function __construct($title) {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        parent::__construct($title);
        session_start();
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
                return true;
            } else {
                $this->errors[] = "User not created.";
                $this->resetUser();
                $status = false;
                return false;
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

    public function findUsernameWithEmail($email) {
        $this->statementPrepare("SELECT username FROM user where email=:email");
        $this->statementBindParam(":email", $email);
        $this->statementExecute();
        return $username = $this->statementFetchAssoc()['username'];
    }

    
        /**
     * select the email from the user table matching the username.
     * @return string
     */
    public function getEmailWithUsername($username) {
        try {
            $this->addDebug(DEBUG_FUNCTION_TRACE);
            $this->statementPrepare('select email from users where username=:username');
            $this->statementBindParam(":username", $username);
            $this->statementExecute();
            $email = $this->statementFetchAssoc()['email'];
            return $email;
        } catch (Exception $ex) {
            $this->addDebug(DEBUG_ERROR, "Exception getting email from user table with username. " . $ex->getMessage());
        }
        return false;
    }
    
    
    
        /**
     * Get the number of users in the user table
     * @return type
     */
    public function getUserCount() {
        try {
            $this->addDebug(DEBUG_FUNCTION_TRACE);
            $this->statementPrepare("select count(*) from user");
            $this->statementExecute();
            return $this->statementFetchAssoc();
        } catch (Exception $ex) {
            $this->addDebug(DEBUG_ERROR, "Exception getting user count from user table. " . $ex->getMessage());
        }
    }
    
    
    /**
     * Perform login with Email and password. Select details from user table matching email. Pass userDetails to loginWithUserDetailsAndPassword
     * @param type $email
     * @param type $password
     */
    public function loginWithEmailPassword($email, $password) {
        try {
            $this->statementPrepare("SELECT * FROM user WHERE email=:email limit 1");
            $this->statementBindParam(":email", $email);
            $this->statementExecute();
            $userDetails = $this->statementFetchAssoc();
            $this->loginWithUserDetailsAndPassword($userDetails, $password);
            if ($this->makeTokenAndUpdateUserId($userDetails['userid'])) {
                $this->loggedin = true;
                $this->messages[] = 'Login Success.';
                $this->addDebug(DEBUG_VERBOSE, "User details retrieved by email" . $this->email);
                return true;
            }
        } catch (Exception $ex) {
            $this->addDebug(DEBUG_ERROR, "Exception while selecting from user table with email." . $ex->getMessage());
        }
        $this->errors[] = 'Error on login with email and password.';
        return false;
    }
    
    
    
    /**
     * Perform login using existing token by matching information in $_SESSION and $_COOKIE. Call selectAndSetUserClassDetilasWithUseridAndToken with information from $_SESSION. If valid, then set $this->loggedin = true;
     * @return boolean
     */
    public function loginWithSessionCookieToken() {
        if (isset($_SEESION['token']) &&
                isset($_COOKIE['token']) &&
                isset($_SESSION['userid']) &&
                $_SESSION['token'] == $_COOKIE['token']) {
            if ($this->selectAndSetUserClassDetailsWithUserIdAndToken($_SESSION['token'], $_SESSION['userid'])) {
                $this->loggedin = true;
                $this->addDebug(DEBUG_VERBOSE, "Login Sucess using Session Token and Cookie Token matched.");
                return true;
            }
        } else {
            $this->errors[] = "Login Denied";
            $this->loggedin = false;
            $this->addDebug(DEBUG_ERROR, "Session token/userid, or cookie token not set, or not matched. Login Denied");
        }
        return false;
    }
    
    /**
     * If the parameters $password matches the password hash in userDetails, then call $this->makeTokenAndUpdateUserId.  
     * @param type $userDetails
     * @param type $password
     * @return boolean
     */
    private function loginWithUserDetailsAndPassword($userDetails, $password) {
        if (
                is_array($userDetails) &&
                isset($userDetails['passhash']) &&
                $userDetails['passhash'] == password_verify($password, $userDetails['passhash'])
        ) {

            if ($this->makeTokenAndUpdateUserId($userDetails['userid'])) {
                $this->loggedin = true;
                $this->messages[] = 'Login Success.';
                $this->addDebug(DEBUG_VERBOSE, "Login Success using password for userid=" . $userDetails['userid']);
                return true;
            }
        } else {
            $this->errors[] = "No Entry or Password Denied.";
            $this->addDebug(DEBUG_ERROR, "No Entry or Password Denied");
            return false;
        }
    }

    
    
    /**
     * Perform login with username and password. Select user details from user table matching username. Pass data to loginWithUserDetailsAndPassword(). If sucess, set $this->loggedin = true.
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function loginWithUsernamePassword($username, $password) {
        try {
            $this->statementPrepare("SELECT * FROM user WHERE username=:username LIMIT 1");
            $this->statementBindParam(":username", $username);
            $this->statementExecute();
            $this->loginWithUserDetailsAndPassword($this->statementFetchAssoc(), $password);
            if ($this->makeTokenAndUpdateUserId()) {
                $this->loggedin = true;
                $this->messages[] = 'Login Success.';
                $this->addDebug(DEBUG_VERBOSE, "Login Sucess with Password and Username=" . $username);
                return true;
            }
        } catch (Exception $ex) {
            $this->addDebug(DEBUG_ERROR, "Expection selcting from user table with username=" . $username . ". " . $ex->getMessage());
        }
        $this->error[] = "Error on login with username and password";
        return false;
    }
    
    
    /**
     * Makes a new token, and updates the $_COOKIE,  $_SESSION, and user table using $userId parameters if not null, if null then use $this->userId. Return true if inserted.
     * @param int $userId
     * @return boolean
     */
    private function makeTokenAndUpdateUserId($userId = null) {
        if ($userId === null) {
            $userId = $this->userId;
        }
        try {
            $this->token = md5(rand());
            $this->statementPrepare("UPDATE user SET token=:token WHERE userid=:userId");
            $this->statementBindParam(":token", $this->token);
            $this->statementBindParam(":userId", $this->userId);
            $this->statementExecute();
            if ($this->getPdo()->lastInsertId() > 0) {
                $_COOKIE['token'] = $this->token;
                $_SESSION['token'] = $this->token;
                $_SESSION['userid'] = $this->userId;
                $this->addDebug(DEBUG_VERBOSE, "Updated user token for userid=" . $this->userId);
                return true;
            }
        } catch (Exception $ex) {
            $this->addDebug(DEBUG_ERROR, "Exception while attempting update user token for userid=" . $this->userId . ". " . $ex->getMessage());
        }
        $this->errors[] = "Unable to update user token.";
        $this->addDebug(DEBUG_ERROR, "Unable to update user token for userid=" . $this->userId);
        return false;
    }

    /**
     * Clears private members in Html4PhpUser class. 
     */
    private function resetUser() {
        $this->username = null;
        $this->userId = null;
        $this->email = null;
        $this->passhash = null;
        $this->loggedin = false;
        $this->token = null;
    }

    /**
     * Select user details from user table using token and userid. On sucess, call setUserClassDetails. Return true upon sucess
     * @param string $token
     * @param int $userId
     */
    private function selectAndSetUserClassDetailsWithUserIdAndToken($token, $userId) {
        try {
            $this->statementPrepare("SELECT * FROM user WHERE token=:token AND userid=:userId");
            $this->statementBindParam(":token", $token);
            $this->statementBindParam(":userId", $userId);
            $this->statementExecute();
            $userDetails = $this->statementFetchAssoc();
            if (is_array($userDetails)) {
                $this->addDebug(DEBUG_VERBOSE, "userDetailed selected with token and userid=" . $userId);
                return $this->setUserClassDetails($userDetails);
            }
        } catch (Exception $ex) {
            $this->addDebug(DEBUG_ERROR, "Excpetion while selecting from user table with token and userid." . $ex->getMessage());
        }
        return false;
    }

    
    /**
     * Send an email through a simple instiation of Html4PhpEmail.
     * @param type $toName
     * @param type $toEmail
     * @param type $subject
     * @param type $messageHtml
     */
    public function sendEmail($toName, $toEmail, $subject, $messageHtml) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$toName=' . $toName . ', $toEmail=' . $toEmail . ', $subject=' . $subject . ', $messageHtml=' . $messageHtml);
        include_once('Html4PhpEmail.php');
        $email = new Html4PhpEmail();
        $email->sendEmail($toName, $toEmail, $subject, $messageHtml);
    }

    
    
    
    
    
    
    //////////////////////////////////////////////////////////////////////////////////////////////////

    
    
    /**
     * Sets the Html4PhpUser details into the private members. If all elements exist in $userDetails then return true.
     * @param array $userDetails
     */
    private function setUserClassDetails($userDetails) {
        if (
                is_array($userDetails) &&
                isset($userDetails['username']) &&
                isset($userDetails['email']) &&
                isset($userDetails['userid'])) {
            $this->email = $userDetails['email'];
            $this->token = $userDetails['token'];
            $this->userId = $userDetails['userid'];
            $this->username = $userDetails['username'];
            $this->passhash = $userDetails['passhash'];
            //$_SESSION['userid'] = $userDetails['userid'];
            $this->addDebug(DEBUG_VERBOSE, "UserDetails are now set in Html4PhpUser private member variables");
            return true;
        }
        $this->addDebug(DEBUG_ERROR, "UserDetails lack information");
        return false;
    }




    /**
     * Set the username to the Html4PHPUser class only if its valid. Return true on success.
     * Valid if length 1-128 and english letters and numbers
     * @param string $username
     * @return boolean
     */
    private function setUsername($username) {
        if (strlen($username) <= 128 && strlen($username) > 1) {
            if (preg_match('/^[a-zA-Z0-9]+$/', $username)) {
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






}
