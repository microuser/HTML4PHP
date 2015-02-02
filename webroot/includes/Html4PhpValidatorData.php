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
    'password' => '(?=.*[a-z]+.*)(?=.*[A-Z]+.*)(?=.*[0-9]+.*)',
    'passwordLength8OrMore' => '(?=.*[a-z]+.*)(?=.*[A-Z]+.*)(?=.*[0-9]+.*)(?=.{8,})',
    'passwordSpecialCharLength8OrMore' => '(?=.*[`~!@#$%^&*()\-_+=\[\]\{\}\\\\|;:\'\",.<>\/? ]+.*)(?=.*[a-z]+.*)(?=.*[A-Z]+.*)(?=.*[0-9]+.*)(?=.{8,})',
    'numbersInteger' => '^[0-9]+$',
    'numbersIntegerAllowNegative' => '^-?[0-9]+$',
    'numbersWithDecimals' => '^[0-9]*(\\.[0-9]+)?$',
    'numbersDecimalsAllowNegative' => '^(-?[0-9]*\.?[0-9]+)$',
    'numbersWithDecimalsAndCommas' => '^[0-9]{0,3}(,[0-9]{3})*(\.[0-9]*)?$',
    'numbersWithDecimalsAndCommasAllowNegative' => '^-?[0-9]{0,3}(,[0-9]{3})*(\.[0-9]*)?$',
    'numbersScientific' => '^-?[0-9]+e?-?[0-9]+$',
    'alpha' => '[a-zA-Z]',
    'alpha' => '^(([0-9]{3,6})|([0-9]{9}))$',
    'alphanumeric' => '[a-zA-Z0-9]',
    'specialChar' => '^[`~!@#$%^&*()\-_+=\[\]\{\}\\\\|;:\'\",.<>\/? ]+$',
    'numbers' => '^-?([0-9]{0,3}(,[0-9]{3})*(\\.[0-9]+)?|[0-9]+(\\.[0-9]+)?(e-?[0-9]+)?)$',
);
