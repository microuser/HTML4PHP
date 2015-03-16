<?php

/**
 * Description of Html4PhpValidatorData
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

$validatorData = array(
    'passwordLength8OrMore' => array(
        'regex' => '(?=.*[a-z]+.*)(?=.*[A-Z]+.*)(?=.*[0-9]+.*)(?=.{8,})',
        'minLength' => '8',
        'maxLength' => '512',
        'errorMsg' => 'Must be at least 8 characters containing: lowercase, uppercase, number'
    ),
    'passwordSpecialCharLength8OrMore' => array(
        'regex' => '(?=.*[`~!@#$%^&*()\-_+=\[\]\{\}\\\\|;:\'\",.<>\/? ]+.*)(?=.*[a-z]+.*)(?=.*[A-Z]+.*)(?=.*[0-9]+.*)(?=.{8,})',
        'minLength' => '8',
        'maxLength' => '512',
        'errorMsg' => 'Must be at least 8 characters containing: special-character, lowercase, uppercase, number',
    ),
    'numbersInteger' => array(
        'regex' => '^[0-9]+$',
        'minLength' => '0',
        'maxLength' => '10',
        'errorMsg' => 'Must be a positive whole number, max length of 10',
    ),
    'numbersIntegerAllowNegative' => array(
        'regex' => '^-?[0-9]+$',
        'minLength' => '0',
        'maxLength' => '11',
        'errorMsg' => 'Must be a whole number, max length of 11',
    ),
    'numbersWithDecimals' => array(
        'regex' => '^[0-9]*(\\.[0-9]+)?$',
        'minLength' => '0',
        'maxLength' => '512',
        'errorMsg' => 'Must be a positive number, can contain decimal point',
    ),
    'numbersDecimalsAllowNegative' => array(
        'regex' => '^(-?[0-9]*\.?[0-9]+)$',
        'minLength' => '0',
        'maxLength' => '512',
        'errorMsg' => 'Must be a number, can contain a decimal point or negative sign',
    ),
    'numbersWithDecimalsAndCommas' => array(
        'regex' => '^[0-9]{0,3}(,[0-9]{3})*(\.[0-9]*)?$',
        'minLength' => '',
        'maxLength' => '',
        'errorMsg' => '',
    ),
    'numbersWithDecimalsAndCommasAllowNegative' => array(
        'regex' => '^-?[0-9]{0,3}(,[0-9]{3})*(\.[0-9]*)?$',
        'minLength' => '',
        'maxLength' => '',
        'errorMsg' => '',
    ),
    'numbersScientific' => array(
        'regex' => '^-?[0-9]+e?-?[0-9]+$',
        'minLength' => '',
        'maxLength' => '',
        'errorMsg' => '',
    ),
    'alpha' => array(
        'regex' => '[a-zA-Z]+',
        'minLength' => '',
        'maxLength' => '',
        'errorMsg' => '',
    ),
    'alphanumeric' => array(
        'regex' => '[a-zA-Z0-9]+',
        'minLength' => '',
        'maxLength' => '',
        'errorMsg' => '',
    ),
    'specialChar' => array(
        'regex' => '^[`~!@#$%^&*()\-_+=\[\]\{\}\\\\|;:\'\",.<>\/? ]+$',
        'minLength' => '',
        'maxLength' => '',
        'errorMsg' => '',
    ),
    'numbers' => array(
        'regex' => '^-?([0-9]{0,3}(,[0-9]{3})*(\\.[0-9]+)?|[0-9]+(\\.[0-9]+)?(e-?[0-9]+)?)$',
        'minLength' => '',
        'maxLength' => '',
        'errorMsg' => '',
    ),
    'username' => array(
        'regex' => '[a-zA-Z0-9]+',
        'minLength' => '2',
        'maxLength' => '512',
        'errorMsg' => 'Can be uppercase, lowercase, or number, with two or more characters'
    ),
    'email' => array(
        'regex' => '.+@.+\\..+', //This could be better
        'minLength' => '5',
        'maxLength' => '512',
        'errorMsg' => 'Emails have an ampersat and a dot',
    ),
    'password' => array(
        'regex' => '(?=.*[a-z]+.*)(?=.*[A-Z]+.*)(?=.*[0-9]+.*)',
        'minLength' => '8',
        'maxLength' => '512',
        'errorMsg' => 'must contain: 1 lowercase, 1 uppercase, 1 number, with length 8 or more'
    ),
    'text' => array(
        'regex' => '.*',
        'minLength' => '0',
        'maxLength' => '5000',
        'errorMsg' => 'Practally anything'
    ),
);
