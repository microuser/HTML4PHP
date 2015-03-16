<?php

include_once('Html4PhpValidator.php');

/**
 * Html4Form creates a valid HTML form. Begin with using startForm(), add what you want, generate with generateForm();
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
class Html4PhpForm {

    public $newLine = "\n";
    private $name = '';
    private $action = '';
    private $method = '';
    private $formBody = array();
    private $formPasswordMeterCode = array();
    private $formCode = array();
    private $validator;

    /**
     * 
     * @param string $title
     */
    public function __construct($title = '') {
//include 'Html4PhpValidatorData.php';
//if (is_array($validatorData)) {
//    $this->validatorData = $validatorData;
// }
        $this->validator = new Html4PhpValidator();
    }

    public function getValidator() {
        return $this->validator;
    }

    public function getRules($dataType) {
        return $this->validator->getRules($dataType);
    }

    public function getRuleRegex($dataType) {
        return $this->validator->getRuleRegex($dataType);
    }

    public function getRuleMinLength($dataType) {
        return $this->validator->getRuleMinLength($dataType);
    }

    public function getRuleMaxLength($dataType) {
        return $this->validator->getRuleMaxLength($dataType);
    }

    public function getRuleErrorMsg($dataType) {
        return $this->validator->getRuleErrorMsg($dataType);
    }

    /**
     * startForm($name = '', $action = '#', $method = 'post') should be the first function called for an HTML4Form
     * @param type $name
     * @param type $action
     * @param type $method
     */
    public function startForm($name = '', $action = '#', $method = 'post') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, ', $name=' . $name . ', $action=' . $action . ', $method=' . $method);
        if ($name == '') {
//if no name is provided, then make one up.
            $this->name = 'form' . microtime(true) * 10000 % 1000000 . rand(0, 100000);
        } else {
            $this->name = $name;
        }
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * Clears date from Html4Form
     */
    public function resetForm() {
//$this->addDebug(DEBUG_FUNCTION_TRACE);
        $this->name = '';
        $this->formBody = array();
        $this->formPasswordMeterCode = array();
        $this->formCode = array();
    }

    /**
     * 
     * @param type $code
     */
    private function addCode($code) {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$code=' . $code);
        $this->formCode[] = $code;
    }

    /**
     * Create a label and an input field which validates for alphanumeric
     * addFormInputAlphanumeric($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length alphanumeric') {
     * @param type $title
     * @param type $name
     * @param type $value
     * @param type $placeholder
     * @param int $minLength
     * @param int $maxLength
     * @param type $errorMsg
     * @param type $dataValidation
     */
    public function addFormInputAlphanumeric($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length alphanumeric', $dataValidationAllowing = '') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $placeholder=' . $placeholder . ', $minLength=' . $minLength . ', $maxLength=' . $maxLength . ', $errorMsg=' . $errorMsg . ', $dataValidation=' . $dataValidation);
        $tags[] = 'name="' . $name . '"';
        if ($dataValidation != '') {
            $tags[] = 'data-validation="' . $dataValidation . '"';
        }
        if ($minLength === null) {
            $minLength = 1;
        }
        if ($maxLength == null) {
            $maxLength = 524288; //Set by HTML spec
        }
        $tags[] = 'data-validation-length="' . $minLength . "-" . $maxLength . '"';
        if ($errorMsg == '' || $errorMsg == null) {            //If we construct an error message
            $tags[] = 'data-validation-error-msg="Needs to be an alphanumeric (no spaces, or dashes) with a length of ' . $minLength . '-' . $maxLength . '"';
        } else {            //If we want an custom error message
            $tags[] = 'data-validation-error-msg="' . $errorMsg . '"';
        }        //If we want a default value
        if (!$placeholder == null || !$placeholder == '') {
            $tags[] = 'placeholder="' . $text . '"';
        }
        $tags[] = 'data-validation-allowing="' . $dataValidationAllowing . '"';
        $tags[] = 'type="text"';
        if (!$value == '' || !$value == null) {
            $tags[] = 'value="' . $value . '"';
        }
        $this->addForm($title, 'input', $tags);
    }

    /**
     * addFormInputAlphanumericAllowEmpty($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length alphanumeric', $dataValidationAllowing = '')
     * @param type $title
     * @param type $name
     * @param type $value
     * @param type $placeholder
     * @param type $minLength
     * @param type $maxLength
     * @param type $errorMsg
     * @param type $dataValidation
     * @param type $dataValidationAllowing
     */
    public function addFormInputAlphanumericAllowEmpty($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length alphanumeric', $dataValidationAllowing = '') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $placeholder=' . $placeholder . ', $minLength=' . $minLength . ', $maxLength=' . $maxLength . ', $errorMsg=' . $errorMsg . ', $dataValidation=' . $dataValidation . ', $dataValidationRegexp=' . $dataValidationRegexp);
        $this->addFormInputCustomRegexp($title, $name, $value, $placeholder, $minLength, $maxLength, $errorMsg, $dataValidation, '^([a-zA-Z0-9]*+)$');
    }

    /**
     * 
     * @param type $title
     * @param type $name
     * @param type $dataType
     * @param type $value
     * @param type $placeholder
     * @param type $errorMsg
     * @param type $extraTag
     */
    public function addFormInputWithDataType($title = '', $name = '', $dataType = 'alphanumeric', $value = '', $placeholder = '',  $errorMsg = '', $extraTag = '') {
        if($errorMsg == null || $errorMsg == ''){
            $errorMsg = $this->getRuleErrorMsg($dataType);
        }
        
        $this->addFormInputCustomRegexp(
                $title
                , $name
                , $value
                , $placeholder
                , $this->getRuleMinLength($dataType)
                , $this->getRuleMaxLength($dataType)
                , $errorMsg
                , 'length custom'
                , $this->getRuleRegex($dataType)
                );

    }

    /**
     * addFormInputPasswordConfirmationWithDataType($title = '', $name = '', $dataType = 'password', $errorMsg = '', $extraTag = '') {
     * @param type $title
     * @param type $name
     * @param type $dataType
     * @param type $errorMsg
     * @param type $extraTag
     */
    public function addFormInputPasswordConfirmationWithDataType($title = '', $name = '', $dataType = 'password', $errorMsg = '', $extraTag = '') {
        if($errorMsg == null || $errorMsg == ''){
            $errorMsg = $this->getRuleRegex($dataType);
        }
        $this->addFormInputPasswordAndConfirmation(
        $title
        , $name
        , $this->getRuleErrorMsg($dataType)
        , 'confirmation'
        , 0  //password strength
        , $errorMsg
        , $this->getRuleMinLength($dataType)
        , $this->getRuleMaxLength($dataType)
        , $extraTag);
    }
    
    public function addFormInputPasswordWithDataType($title = 'Password', $name = 'password', $dataType = 'password', $errorMsg = '', $extraTag = ''){
        $this->addFormInputPassword(
                $title
                , $name
                , 0
                , $this->getRuleErrorMsg($dataType)
                , $this->getRuleRegex($dataType)
                , $this->getRuleMinLength($dataType)
                , $this->getRuleMaxLength($dataType)
                , 'strength');

    }

    /**
     * public function addFormInputCustomRegexp($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length custom', $dataValidationRegexp = '^([a-zA-Z0-9.,]+)$') {
     * @param type $title
     * @param type $name
     * @param type $value
     * @param type $placeholder
     * @param int $minLength
     * @param int $maxLength
     * @param type $errorMsg
     * @param type $dataValidation
     * @param type $dataValidationRegexp
     */
    public function addFormInputCustomRegexp($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length custom', $dataValidationRegexp = '^([a-zA-Z0-9.,]+)$', $extraTag = '') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $placeholder=' . $placeholder . ', $minLength=' . $minLength . ', $maxLength=' . $maxLength . ', $errorMsg=' . $errorMsg . ', $dataValidation=' . $dataValidation . ', $dataValidationRegexp=' . $dataValidationRegexp);
        $tags[] = 'name="' . $name . '"';
        if ($dataValidation != '') {
            $tags[] = 'data-validation="' . $dataValidation . '"';
        }
        if ($minLength == null) {
            $minLength = 1;
        }
        if ($maxLength == null) {
            $maxLength = 524288; //Set by HTML spec
        }
        $tags[] = 'data-validation-length="' . $minLength . "-" . $maxLength . '"';
        if ($errorMsg == '' || $errorMsg == null) {            //If we construct an error message
            $tags[] = 'data-validation-error-msg="Needs to be length of ' . $minLength . '-' . $maxLength . ' while matching the Regexp ' . $dataValidationRegexp . '"';
        } else {            //If we want an custom error message
            $tags[] = 'data-validation-error-msg="' . $errorMsg . '"';
        }        //If we want a default value
        if (!$placeholder == null || !$placeholder == '') {
            $tags[] = 'placeholder="' . $text . '"';
        }
        $tags[] = 'data-validation-regexp="' . $dataValidationRegexp . '"';

        $tags[] = 'type="text"';
        if (!$value == '' || !$value == null) {
            $tags[] = 'value="' . $value . '"';
        }
        $tags[] = $extraTag;
        $this->addForm($title, 'input', $tags);
    }

    /**
     *   
     * Create a label and an input field which validates for alphanumeric and spaces

     * @param string $title
     * @param string $name
     * @param string $value
     * @param string $placeholder
     * @param int $minLength
     * @param int $maxLength
     * @param string $errorMsg
     * @param string $dataValidation
     * @param string $dataValidationAllowing
     */
    public function addFormInputAlphaNumericAllowSpace($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length alphanumeric', $dataValidationAllowing = '') {
        $dataValidationAllowing .= ' ';
        $this->addFormInputAlphanumeric($title, $name, $value, $placeholder, $minLength, $maxLength, $errorMsg, $dataValidation, $dataValidationAllowing);
    }

    /**
     * Create a label and an input field which validates for email. 
     * addFormInputEmail($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length email') {
     * @param type $title
     * @param type $name
     * @param type $value
     * @param type $placeholder
     * @param int $minLength
     * @param int $maxLength
     * @param type $errorMsg
     * @param type $dataValidation
     */
    public function addFormInputEmail($title = '', $name = '', $value = '', $placeholder = '', $minLength = null, $maxLength = null, $errorMsg = '', $dataValidation = 'length email') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $placeholder=' . $placeholder . ', $minLength=' . $minLength . ', $maxLength=' . $maxLength . ', $errorMsg=' . $errorMsg . ', $dataValidation=' . $dataValidation);
        $tags[] = 'name="' . $name . '"';
        if ($dataValidation != '') {
            $tags[] = 'data-validation="' . $dataValidation . '"';
        }
        if ($minLength == null) {
            $minLength = 1;
        }
        if ($maxLength == null) {
            $maxLength = 524288; //Set by HTML spec
        }
        $tags[] = 'data-validation-length="' . $minLength . "-" . $maxLength . '"';
        if ($errorMsg == '' || $errorMsg == null) {            //If we construct an error message
            $tags[] = 'data-validation-error-msg="' . $title . ' has to be an an email with an ampersat with a length of ' . $minLength . '-' . $maxLength . '"';
        } else {            //If we want an custom error message
            $tags[] = 'data-validation-error-msg="' . $errorMsg . '"';
        }        //If we want a default value
        if (!$placeholder == null || !$placeholder == '') {
            $tags[] = 'placeholder="' . $text . '"';
        }
        $tags[] = 'type="text"';
        if (!$value == '' || !$value == null) {
            $tags[] = 'value="' . $value . '"';
        }
        $this->addForm($title, 'input', $tags);
    }

    /**
     * public function addFormInputNumber($title = '', $name = '', $value = '', $placeholder = '', $float = FALSE, $negative = TRUE, $range = array(), $dataValidationAllowing = '', $dataValidation = 'number', $errorMsg = '') {
     * @param type $title
     * @param type $name
     * @param type $value
     * @param type $placeholder
     * @param type $float
     * @param type $negative
     * @param type $range
     * @param type $dataValidationAllowing
     * @param type $dataValidation
     * @param type $errorMsg
     */
    public function addFormInputNumber($title = '', $name = '', $value = '', $placeholder = '', $float = FALSE, $negative = TRUE, $range = array(), $dataValidationAllowing = '', $dataValidation = 'number', $errorMsg = '') {
        if ($float === TRUE) {
            if ($dataValidationAllowing != '') {
                $dataValidationAllowing .= ',';
            }
            $dataValidationAllowing .= 'float';
        }
        if ($negative === TRUE) {
            if ($dataValidationAllowing != '') {
                $dataValidationAllowing .= ',';
            }
            $dataValidationAllowing .= 'negative';
        }if (
                isset($range) &&
                isset($range[0]) &&
                isset($range[1]) &&
                is_numeric($range[0]) &&
                is_numeric($range[1])
        ) {
            if ($dataValidationAllowing != '') {
                $dataValidationAllowing .= ',';
            }
            $dataValidationAllowing .= 'range[' . $range[0] . ';' . $range[1] . ']';
        }

        $tags[] = 'data-validation="' . $dataValidation . '"';

        if ($dataValidationAllowing != '') {
            $tags[] = 'data-validation-allowing="' . $dataValidationAllowing . '"';
        }


        if ($errorMsg === '' || $errorMsg === null) {            //If we construct an error message
            $tags[] = 'data-validation-error-msg="' . $title . '';
        } else {            //If we want an custom error message
            $tags[] = 'data-validation-error-msg="' . $errorMsg . '"';
        }        //If we want a default value
        if (!$placeholder === null || !$placeholder === '') {
            $tags[] = 'placeholder="' . $text . '"';
        }
        $tags[] = 'type="text"';
        if ($value !== '' || $value !== null) {
            $tags[] = 'value="' . $value . '"';
        }

        if ($name !== '' || $name !== null) {
            $tags[] = 'name="' . $name . '"';
        }

        $this->addForm($title, 'input', $tags);
    }

    /**
     * Add a label and an input field which validates as password with strength
     * addFormInputPassword($title, $name, $passStrength, $errorMsg, $regexp, $minLength, $maxLength)
     * @param type $title
     * @param type $name
     * @param int $passStrength
     * @param string $errorMsg
     * @param string $regexp
     * @param int $minLength
     * @param int $maxLength
     * @param string $dataValidation
     */
    public function addFormInputPassword($title = '', $name = '', $passStrength = '1', $errorMsg = '', $regexp = '', $minLength = '', $maxLength = '', $dataValidation = 'strength') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name);
        //If regexp was given
        if ($regexp != null && $regexp != '') {
            $dataValidation .= ' custom';
            $tags[] = 'data-validation-regexp="' . $regexp . '"';
        }

        //Add rule for length, if one of them was given
        if (strlen($minLength) > 0 || strlen($maxLength) > 0) {
            $dataValidation .= ' length';

            //If its the one that wasnt given, then set it to its default
            if ($minLength == null || $minLength == '' || !is_numeric($minLength)) {
                $minLength = '0';
            }
            if ($minLength == null || $minLength == '' || !is_numeric($minLength)) {
                $minLength = '5000';
            }

            $tags[] = 'data-validation-length="' . $minLength . '-' . $maxLength . '"';
        }

        $tags[] = 'name="' . $name . '"';
        if ($dataValidation != '') {
            $tags[] = 'data-validation="' . $dataValidation . '"';
        }

        if ($passStrength == null || $passStrength == '' || !is_numeric($passStrength)) {
            $passStrength = 1;
        }
        $tags[] = 'data-validation-strength="' . $passStrength . '"';

        if ($errorMsg == '' || $errorMsg == null) {            //If we construct an error message
            $tags[] = 'data-validation-error-msg="' . $title . ' has to be a somewhat strong password"';
        } else {            //If we want an custom error message
            $tags[] = 'data-validation-error-msg="' . $errorMsg . '"';
        }        //If we want a default value

        $tags[] = 'type="password"';
        $tags[] = '><div class="password-meter-bg"></div'; //left trailing closing bracket open on purpose. Must be last tag
        $this->formPasswordMeterCode[] = '$(\'input[name="' . $name . '"]\').displayPasswordStrength(optionalConfig);';
        $this->addForm($title, 'input', $tags);
    }

    /**
     * Add a label and an input feild for validation of the previously entered password field
     * addFormInputPasswordAndConfirmation($title = '', $name = '', $errorMsg = '', $dataValidation = 'confirmation', $passStrength = '1', $regexp = '', $minLength = '', $maxLength = '', $extraTag = '')
     * @param type $title
     * @param type $name
     * @param type $errorMsg
     * @param type $dataValidation
     * @param type $passStrength
     * @param type $regexp
     * @param type $minLength
     * @param type $maxLength
     * @param type $extraTag
     */
    public function addFormInputPasswordAndConfirmation($title = '', $name = '', $errorMsg = '', $dataValidation = 'confirmation', $passStrength = '1', $regexp = '', $minLength = '', $maxLength = '', $extraTag = '') {
        //$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $errorMsg=' . $errorMsg . ', $dataValidation=' . $dataValidation);
        //$this->addFormInputPassword($title, $name . "_confirmation");
        $this->addFormInputPassword($title, $name . "_confirmation", $passStrength, $errorMsg, $regexp, $minLength, $maxLength, 'strength');

        $tags[] = 'name="' . $name . '"';
        if ($dataValidation != '') {
            $tags[] = 'data-validation="' . $dataValidation . '"';
        }

        if ($errorMsg == '' || $errorMsg == null) {            //If we construct an error message
            $tags[] = 'data-validation-error-msg="' . $title . ' needs to have a matching password."';
        } else {            //If we want an custom error message
            $tags[] = 'data-validation-error-msg="' . $errorMsg . '"';
        }        //If we want a default value
        $tags[] = 'type="password"';
        $tags[] = $extraTag;
        $this->addForm("Repeat " . $title, 'input', $tags);
    }

    /**
     * Add a label and an input field for validation for a yyyy-mm-dd
     * @param type $title
     * @param type $name
     * @param type $value
     * @param type $placeholder
     * @param type $helpMsg
     * @param type $errorMsg
     * @param type $dataValidation
     * @param type $dataValidationFormat
     */
    public function addFormInputDate($title = '', $name = '', $value = '', $placeholder = '', $helpMsg = 'yyyy-mm-dd (Year-Month-Day)', $errorMsg = '', $dataValidation = 'date', $dataValidationFormat = 'yyyy-mm-dd') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $value=' . $value . ', $placeholder=' . $placeholder . ', $helpMsg=' . $helpMsg . ', $errorMsg=' . $errorMsg . ', $dataValidation=' . $dataValidation . ', $dataValidationFormat=' . $dataValidationFormat);
        $tags[] = 'name="' . $name . '"';
        if ($dataValidation != '') {
            $tags[] = 'data-validation="' . $dataValidation . '"';
        }

        if ($dataValidation != '') {
            $tags[] = 'data-validation-format="' . $dataValidationFormat . '"';
        }

        if ($errorMsg == '' || $errorMsg == null) {            //If we construct an error message
            $tags[] = 'data-validation-error-msg="' . $title . ' Match the form of ' . $dataValidationFormat . '"';
        } else {
            $tags[] = 'data-validation-error-msg="' . $errorMsg . '"';
        }
        if ($helpMsg == '' || $helpMsg == null) {
            $tags[] = 'data-validation-help="' . $dataValidationFormat . '"';
        } else {
            $tags[] = 'data-validation-help="' . $helpMsg . '"';
        }
        if (!$placeholder == null || !$placeholder == '') {
            $tags[] = 'placeholder="aaa' . $placeholder . '"';
        }
        $tags[] = 'type="text"';

        if (!$value == '' || !$value == null) {
            $tags[] = 'value="' . $value . '"';
        }
        $this->addForm($title, 'input', $tags);
    }

    /**
     * Add a label and an input field which validates time in Military time format.
     * @param type $title
     * @param type $name
     * @param type $value
     * @param type $placeholder
     * @param type $helpMsg
     * @param type $errorMsg
     * @param type $dataValidation
     * @param type $dataValidationFormat
     */
    public function addFormInputTime($title = '', $name = '', $value = '', $placeholder = '', $helpMsg = 'HH:mm (Military Time)', $errorMsg = '', $dataValidation = 'time', $dataValidationFormat = 'HH:mm') {
        $this->addCode(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $value=' . $value . ', $placeholder' . ', $helpMsg=' . $helpMsg . ', $errorMsg=' . $errorMsg . ', $dataValidation=' . $dataValidation . ', $dataValidationFormat=' . $dataValidationFormat);
        $tags[] = 'name="' . $name . '"';
        if ($dataValidation != '') {
            $tags[] = 'data-validation="' . $dataValidation . '"';
        }

        if ($dataValidation != '') {
            $tags[] = 'data-validation-format="' . $dataValidationFormat . '"';
        }

        if ($errorMsg == '' || $errorMsg == null) {            //If we construct an error message
            $tags[] = 'data-validation-error-msg="' . $title . ' Match the form ' . $dataValidationFormat . '"';
        } else {
            $tags[] = 'data-validation-error-msg="' . $errorMsg . '"';
        }
        if ($helpMsg == '' || $helpMsg == null) {
            $tags[] = 'data-validation-help="' . $dataValidationFormat . '"';
        } else {
            $tags[] = 'data-validation-help="' . $helpMsg . '"';
        }
        if (!$placeholder == null || !$placeholder == '') {
            $tags[] = 'placeholder="' . $placeholder . '"';
        }
        $tags[] = 'type="text"';

        if (!$value == '' || !$value == null) {
            $tags[] = 'value="' . $value . '"';
        }
        $this->addForm($title, 'input', $tags);
    }

    /**
     * Add a label and an text input area of default max length 4000 characters.
     * @param type $title
     * @param type $name
     * @param type $maxLength
     * @param type $height
     * @param type $value
     * @param type $dataValidation
     */
    public function addFormTextArea($title = '', $name = '', $maxLength = 250, $value = '', $dataValidation = 'presentation length', $charactersPerLine = 83, $height = '') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $maxLength=' . $maxLenth . ', $height=' . $height . ', $value=' . $value . ', $dataValidation=' . $dataValidation);
        if ($height == '') {
            $height = ceil($maxLength / $charactersPerLine + 0.5);
        }
        if (!is_int($height)) {
            $height = '4.5em';
        }
        $tags[] = 'name="' . $name . '"';
        $afterElement = '<span id="' . $name . 'maxlength">' . $maxLength . '</span>' . $this->newLine;
        $afterElement .= '<script>$(\'textarea[name="' . $name . '"]\').restrictLength($(\'#' . $name . 'maxlength\'));' . $this->newLine
                . '$(\'textarea[name="' . $name . '"]\').parent().parent().css("height","' . ($height + 4.5) . 'em");' . $this->newLine
                . '$(\'textarea[name="' . $name . '"]\').parent().css("height","' . ($height) . 'em");' . $this->newLine
                . '$(\'textarea[name="' . $name . '"]\').css("height","' . $height . 'em");'
                . '</script>' . $this->newLine;
//$afterElement .= '<div style="clear:both;"></div>';
        $this->addForm($title, 'textarea', $tags, $afterElement, $value);
    }

    /**
     * Add a label and a upload field for upload
     * @param type $title
     * @param type $name
     * @param type $mimeTypes
     * @param type $maxSize
     */
    public function addFormFileUpload($title = '', $name = '', $mimeTypes = 'jpg, png, gif', $maxSize = '2048kb') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $mimeTypes=' . $mimeTypes . ', $maxSize=' . $maxSize);
        $tags[] = 'name="' . $name . '"';
        $tags[] = 'type="file"';


        $validations = '';
        if (!($mimeTypes == '' || $mimeTypes == null)) {
            $tags[] = 'data-validation-allowing="' . $mimeTypes . '"';
            $validations .= 'mime';
        }
        if (!($maxSize == '' || $maxSize == null)) {
            if (strlen($validations) > 0) {
                $validations .= ' ';
            }
            $validations .= 'size';
            $tags[] = 'data-validation-max-size="' . $maxSize . '"';
        }

        $tags[] = 'data-validation="' . $validations . '"';
        $this->addForm($title, 'input', $tags);
    }

    /**
     * Adds a button using values defined in function startForm()
     * @param type $title
     * @param type $name
     * @param type $value
     */
    public function addFormSubmitButton($title = '', $name = '', $value = 'Submit') {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $value=' . $value);
        $tags[] = 'name="' . $name . '"';
        $tags[] = 'value="' . $value . '"';
        $tags[] = 'type="submit"';

        $this->addForm($title, 'input', $tags);
    }

/**
 * Adds a way to place hidden values into the form.
 * @param type $title
 * @param type $name
 * @param type $value
 */    
    public function addFormInputHidden($title = '', $name = '', $value = ''){
        $tags = array();
        $tags[] = 'name="'.$name.'"';
        $tags[] = 'value="'.$value.'"';
        $tags[] = 'type="hidden"';
        $this->addForm($title, 'input', $tags);
    }
    
    /**
     * 
     * @param type $title
     * @param type $name
     * @param type $values
     */
    public function addFormCheckboxes($title = '', $name = '', $values = array()) {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . '[], $values=' . print_r($values, 1));
        foreach ($values as $label => $checkbox) {
            if ($checkbox == TRUE) {
                $checked = 'checked="true"';
            } else {
                $checked = '';
            }
            $checkboxId = $label . sha1(microtime());
            $insideElements[] = '<!-- begin InputCheckbox -->'
                    . '<p >'
                    . '<input style="width:30px" type="checkbox" id="' . $checkboxId . '" name="' . $name . '[]" value="' . $label . '" ' . $checked . ' >'
                    . '<label for="' . $checkboxId . '">' . $label . '</label>'
                    . '</p>'
                    . '<!--end InputCheckbox-->' . $this->newLine; //.$label.'</input> 
        }
        $insideElements[] = '</div><!-- end CheckboxGroup -->' . $this->newLine;
        $this->addForm($title, "div", array('class="checkBoxGroup"'), '', $insideElements);
//Unifinishsed
    }

    /**
     * 
     * @param type $title
     * @param type $name
     * @param type $values
     */
    public function addFormRadioButtons($title = '', $name = '', $values = array()) {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $name=' . $name . ', $values=' . print_r($values, 1));
        foreach ($values as $label => $checkbox) {
            if ($checkbox == TRUE) {
                $checked = 'checked="true"';
            } else {
                $checked = '';
            }
            $checkboxId = $label . sha1(microtime());
            $insideElements[] = '<!-- begin InputRadiobutton -->'
                    . '<p>'
                    . '<input style="width:30px" type="radio" id="' . $checkboxId . '" name="' . $name . '" value="' . $label . '" ' . $checked . ' >'
                    . '<label for="' . $checkboxId . '">' . $label . '</label>'
                    . '</p>'
                    . '<!--end InputRadiobutton-->' . $this->newLine; //.$label.'</input> 
        }
        $insideElements[] = '</div><!-- end CheckboxGroup -->' . $this->newLine;
        $this->addForm($title, "div", array('class="checkBoxGroup"'), '', $insideElements);
//Unifinishsed
    }

    /**
     * Adds an element to the formBody array;
     * addForm($title, $controlElement, Array $tags, $afterElement = '', $insideElements = array())
     * @param type $title
     * @param type $controlElement
     * @param array $tags
     * @param type $afterElement
     * @param array $insideElements
     */
    private function addForm($title, $controlElement, Array $tags, $afterElement = '', $insideElements = array()) {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $controlElement=' . $controlElement . ', $tags=' . print_r($tags, 1) . ', $afterElement=' . $afterElement);
        $out = '<div class="controlGroup">' . $this->newLine
                . '<label class="controlLabel">' . $this->newLine
                . $title . $this->newLine
                . '</label>' . $this->newLine
                . '<div class="controls">' . $this->newLine
                . '<' . $controlElement;
        foreach ($tags as $tag) {
            $out .= ' ' . $tag;
        }
        $out .= '>' . $this->newLine;

        if (!empty($insideElements)) {
            $ieout = '';
            if (is_array($insideElements)) {
// as array
                foreach ($insideElements as $ie) {
                    $ieout .= $ie;
                }$out .= $ieout;
            } else {
// as string
                $out .= $insideElements;
            }
        }

        if ($controlElement == 'textarea') {
            $out .= '</' . $controlElement . '>';
        }
        $out .= $afterElement;
        if ($afterElement != '') {
            $this->newLine;
        }

        $out .= '</div><!--end controls-->' . $this->newLine;
        $out .= '</div><!--end controlGroup-->' . $this->newLine;
        $this->formBody[] = $out;
    }

    /**
     * Returns the rendered html form elements from formBody and formCode member variables
     * @param type $title
     */
    public function generateForm($title) {
//$this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title);
        $out = '<div class="formTitle">' . $title . '</div><!--end formTitle--><div><form name="' . $this->name . '" action="' . $this->action . '" method="' . $this->method . '">' . $this->newLine;
        $code = '';
        foreach ($this->formCode as $codeItem) {
            $code .= $codeItem;
        }
        $passwordMeterCode = '';
        foreach ($this->formPasswordMeterCode as $passwordMeterItem) {
            $passwordMeterCode .= $passwordMeterItem;
        }
        foreach ($this->formBody as $bodyItem) {
            $out .= $bodyItem . $this->newLine;
        }


        $out .= '<script type="text/javascript">$.validate('
                . "{
modules : 'location, date, security, file',
onModulesLoaded : function() {
var optionalConfig = {
      fontSize: '12px',
      padding: '0px',
      bad : 'Very bad',
      weak : 'Weak',
      good : 'Good',
      strong : 'Strong'
                }
                "
                . $passwordMeterCode
                . "
                }});" . $this->newLine
                . $code . $this->newLine
                . '</script>';

        $out .= '</form></div>' . $this->newLine;
        return $out;
    }

}
