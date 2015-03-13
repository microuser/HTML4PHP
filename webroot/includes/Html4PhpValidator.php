<?php

include_once('Html4PhpValidatorData.php');

/**
 * Description of Html4PHpValidator
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
class Html4PhpValidator {

    public $validatorData = null;
    private $isValid = true;
    private $classData = array();

    public function __construct() {
        include('Html4PhpValidatorData.php');
        $this->validatorData = $validatorData; //this is set in the above include
        return $this;
    }

    public function getRules($dataType) {
        if (isset($this->validatorData[$dataType]) && is_array($this->validatorData[$dataType])) {
            return $this->validatorData[$dataType];
        }
        return null;
    }

    public function getRuleRegex($dataType) {
        if (isset($this->getRules($dataType)['regex'])) {
            return $this->getRules($dataType)['regex'];
        }
        return null;
    }

    public function getRuleMinLength($dataType) {
        if (isset($this->getRules($dataType)['minLength'])) {
            return $this->getRules($dataType)['minLength'];
        }
        return null;
    }

    public function getRuleMaxLength($dataType) {
        if (isset($this->getRules($dataType)['maxLength'])) {
            return $this->getRules($dataType)['maxLength'];
        }
        return null;
    }

    public function getRuleErrorMsg($dataType) {
        if (isset($this->getRules($dataType)['errorMsg'])) {
            return $this->getRules($dataType)['errorMsg'];
        }
        return null;
    }

    public function getIsValid() {
        return $this->isValid;
    }

    public function isMatchWithRefArray($type, $subject, &$matches) {
        if (isset($this->validatorData[$type]['regex'])) {
            $ret = preg_match('/' . $this->validatorData[$type]['regex'] . '/', $subject, $matches);
            if ($ret === false) {
                $this->isValid = $ret;
            }
            return $ret;
        } else {
            $this->isValid = false;
            return false;
        }
    }

    public function isMatch($dataType, $subject) {
        if (isset($this->validatorData[$dataType])) {
            /*
              $isMin = strlen($subject) >= $this->getRuleMinLength($dataType) ;
              $isMax = strlen($subject) <= $this->getRuleMaxLength($dataType) ;
              $isValid = preg_match('/' . $this->getRuleRegex($dataType) . '/', $subject);
              xdebug_break();
              return $isMin && $isMax && $isValid;
             * 
             */

            return ($this->getRuleMinLength($dataType) <= strlen($subject)) && ($this->getRuleMaxLength($dataType) >= strlen($subject)) && preg_match('/' . $this->getRuleRegex($dataType) . '/', $subject);
        } else {
            $this->isValid = false;
            return null;
        }
    }

    /**
     * Returns the subject if it passes validation of the type, If it does not pass, set to null.
     * @param type $type
     * @param type $subject
     * @return type
     */
    public function validateAndReturn($type, $subject) {
        if ($this->isMatch($type, $subject)) {
            return $subject;
        }
        $this->isValid = false;
        return null;
    }

    public function validateRequest(array $RequestNameTypeKeyPair) {
        $this->clearIsValid();
        foreach ($RequestNameTypeKeyPair as $name => $type) {
            if (isset($_REQUEST[$name])) {
                $this->{$name} = $this->validateAndReturn($type, $_REQUEST[$name]);
            } else {
                $this->isValid = false;
            }
        }
        return $this->isValid;
    }

    public function clearIsValid() {
        $this->isValid = true;
    }

    public function __set($name, $value) {
        $this->classData[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->classData)) {
            return $this->classData[$name];
        }
        //$trace = debug_backtrace();
        //trigger_error(
        //'Undefined property via __get(): ' . $name
        //. ' in ' . $trace[0]['file']
        // . ' on line ' . $trace[0]['line'], E_USER_NOTICE
        //        );

        return null;
    }

}
