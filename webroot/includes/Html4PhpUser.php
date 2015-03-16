<?php

include_once "Html4PhpDatabase.php";
include_once "Html4PhpValidator.php";

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

    public $loggedin = false;
    private $username = null;
    private $userId = null;
    private $email = null;
    private $passhash = null;
    private $token = null;
    public $errors = array();
    public $messages = array();
    private $validator = null;

    /**
     * Ways to login:
     *  1) With Token
     *  2) With Username
     * @param type $title
     */
    public function __construct($title) {

        if (is_string($title)) {
            parent::__construct($title);
            $this->validator = new Html4PhpValidator();
            session_start();
            $this->loginSequence();
        } else {
            parent::__construct($title);
        }
        $this->addDebug(DEBUG_FUNCTION_TRACE);
    }

    private function loginSequence() {
        //First try common case of logging in with session token
        //If that suceedes, then try to logout
        //else, try to login.
        if ($this->loginWithSessionCookieToken()) {
            if ($this->RequestLogout()) {
                $this->messages[] = 'Logout Success';
            }
        } else {
            if ($this->RequestLogin()) {
                    $this->messages[] = "Login Success";
            }
        }
    }

    public function requestLogout() {
        if (isset($_REQUEST['Logout']) && $_REQUEST['Logout'] == 'Submit') {
            return $this->logout();
        }
        return false;
    }

    protected function requestCreateUser() {
        $v = new Html4PhpValidator();
        $v->validateRequest(
                array(
                    "username" => "username",
                    "email" => "email",
                    "password" => "password"
                )
        );
        if ($v->getIsValid()) {
            $v->clearIsValid();
            return $this->createUser($v->username, $v->email, $v->password);
        }
        return null;
    }

    public function requestLogin() {
        $this->validator->validateRequest(
                array(
                    "username" => "username",
                    "password" => "password"
                )
        );
        if ($this->validator->getIsValid()) {
            $this->validator->clearIsValid();
            return $this->loginWithUsernamePassword($this->validator->username, $this->validator->password);
        }
        return null;
    }

    /**
     * Perform login with username and password. 
     * Select user details from user table matching username.
     *  Pass data to loginWithUserDetailsAndPassword().
     *  If sucess, set $this->loggedin = true.
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function loginWithUsernamePassword($username, $password) {
        try {
            $this->statementPrepare("SELECT * FROM user WHERE username=:username LIMIT 1");
            $this->statementBindParam(":username", $username);
            $this->statementExecute();
            return $this->loginWithUserDetailsAndPassword($this->statementFetchAssoc(), $password);
        } catch (Exception $ex) {
            $this->addDebug(DEBUG_ERROR, "Expection selcting from user table with username=" . $username . ". " . $ex->getMessage());
        }
        $this->error[] = "Error on login with username and password";
        return false;
    }

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
        if ($this->validator->isMatch("username", $username)) {
            $this->username = $username;
            return true;
        } else {
            $this->errors[] = 'Username: ' . $this->validator->getRuleErrorMsg("username");
            return false;
        }
    }

    /**
     * Set the email to the class Html4PhpUser if it passed email validation. Return true on success.
     * @param string $email
     * @return boolean
     */
    private function setEmail($email) {
        if ($this->validator->isMatch("email", $email)) {
            $this->email = $email;
            return true;
        } else {
            $this->errors[] = 'Eamil: ' . $this->validator->getRuleErrorMsg("email");
            return false;
        }
    }

    /**
     * The the password to the class Html4PhpUser if it passed validation from validateRulesPassword(). Return true on success.
     * @param string $password
     * @return boolean
     */
    private function setPasshashFromPassword($password) {
        if ($this->validator->isMatch("password", $password)) {
            $this->passhash = password_hash($password, PASSWORD_BCRYPT);
            return true;
        } else {
            $this->errors[] = 'Password: ' . $this->validator->getRuleErrorMsg("password");
            return false;
        }
        return false;
    }

    /**
     * Makes a new token, and updates the $_COOKIE,  $_SESSION, and user table using $userId parameters if not null, if null then use $this->userId. Return true if inserted.
     * @param int $userId
     * @return boolean
     */
    private function updateTokenWithUserId($userId = null) {
        if ($userId !== null) {
            $this->userId = $userId;
        }
        try {
            $this->token = md5(rand());
            $this->statementPrepare("UPDATE `user` SET token=:token WHERE userid=:userId");
            $this->statementBindParam(":token", $this->token);
            $this->statementBindParam(":userId", $this->userId);
            $success = $this->statementExecute();
            $this->messages[] = $this->statementRowCount(); //.$this->getPdo()->lastInsertId(). $this->getPdo()->errorInfo();
            if ($success) {//$this->getPdo()->lastInsertId() > 0) {
                setcookie('token', $this->token, time() + 3600 * 24, '/'); //Cookie Expires end of session
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
     * If the parameters $password matches the password hash in userDetails,
     *  then call $this->makeTokenAndUpdateUserId.  
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

            if ($this->updateTokenWithUserId($userDetails['userid'])) {
                $this->loggedin = true;
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
     * Perform login using existing token by matching information in $_SESSION and $_COOKIE. Call selectAndSetUserClassDetilasWithUseridAndToken with information from $_SESSION. If valid, then set $this->loggedin = true;
     * @return boolean
     */
    public function loginWithSessionCookieToken() {
        if ($this->getConfig('login', 'securityLevel' == 0)) {
            if (isset($_SESSION['token']) &&
                    isset($_COOKIE['token']) &&
                    isset($_SESSION['userid']) &&
                    $_SESSION['token'] == $_COOKIE['token'] &&
                    !(isset($_REQUEST['Logout']) && $_REQUEST['Logout'] == 'Submit')
            ) {
                xdebug_break();
                if ($this->selectAndSetUserClassDetailsWithUserIdAndToken($_SESSION['token'], $_SESSION['userid'])) {
                    xdebug_break();
                    $this->loggedin = true;
                    $this->addDebug(DEBUG_VERBOSE, "Login Sucess using Session Token and Cookie Token matched.");
                    return true;
                }
            } else {
                if (isset($_REQUEST['Logout']) && $_REQUEST['Logout'] == 'Submit') {
                    $this->logout();
                }
                $this->loggedin = false;
                $this->addDebug(DEBUG_ERROR, "Session token/userid, or cookie token not set, or not matched. Login Denied");
                return false;
            }
        }
        return false;
    }

    /**
     * CreateUser
     * @param type $username
     * @param type $email
     * @param type $password
     * @return boolean
     */
    public function createUser($username, $email, $password) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$username=' . $username . ', $password=Hidden' . ', $email=' . $email);
        try {
            if ($this->setUsername($username) && $this->setEmail($email) && $this->setPasshashFromPassword($password)) {
                try {
                    $this->statementPrepare('INSERT INTO `user` (username, email, passhash, timecreated) VALUES (:username, :email, :passhash, now())');
                    $this->statementBindParam(":username", $this->username);
                    $this->statementBindParam(":email", $this->email);
                    $this->statementBindParam(":passhash", $this->passhash);
                    $status = $this->statementExecute();
                    $this->errors[] = $this->getPdo()->lastInsertId();
                    $this->errors[] = $this->getPdo()->errorCode();
                    $this->errors[] = print_r($this->getPdo()->errorInfo(), 1);
                    $this->messages[] = "User created";
                } catch (Exception $e) {
                    //echo '<pre>' . $e . '</pre>';
                    $this->errors[] = "A major error occured.";
                }
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

    public function selectAndSetUserClassDetailsWithUserIdAndToken($userId, $token) {
        $this->statementPrepare("SELECT userid, username, email, token, passhash, timeupdated FROM `user` WHERE userID=:userid AND token=:token");
        $this->statementBindParam("userid", $userId);
        $this->statementBindParam("token", $token);
        $userDetails = ($this->statementFetchAssoc());
        $this->username = $userDetails['username'];
        $this->userId = $userDetails['userid'];
        $this->email = $userDetails['email'];
        $this->passhash = $userDetails['passhash'];
        $this->token = $userDetails['token'];
        $this->loggedin = true;
        xdebug_break();
        return true;
    }

    /*
      public function findUsernameWithEmail($email) {
      $this->statementPrepare("SELECT username FROM user where email=:email");
      $this->statementBindParam(":email", $email);
      $this->statementExecute();
      return $username = $this->statementFetchAssoc()['username'];
      }
     * 
     */

    /**
     * select the email from the user table matching the username.
     * @return string
     */
    /*
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
     * 
     */

    /**
     * Get the number of users in the user table
     * @return type
     */
    /*
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
     */

    /**
     * Perform login with Email and password. Select details from user table matching email. Pass userDetails to loginWithUserDetailsAndPassword
     * @param type $email
     * @param type $password
     */
    /*
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
     * 
     */

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

    public function getIsLoggedIn() {
        return $this->loggedin;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function getUserId(){
        return $this->userId;
    }

    public function logout() {
        try {
            $this->loggedin = false;
            setcookie('token', null, time() - 3600, '/');
            unset($_COOKIE['token']);
            unset($_SESSION['token']);
            setcookie('loggedin', '0', time() - 3600, '/');
            unset($_SESSION['userid']);
            unset($_SESSION['timeupdated']);
            xdebug_break();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
