<?php

if (!defined("DEBUG")) {
    define("DEBUG_ECHO", 128);
    define("DEBUG_ERROR_LOG", 64);
    define("DEBUG_VERBOSE", 32);
    define("DEBUG_FUNCTION_TRACE", 16);
    define("DEBUG_RETURN_VALUE", 8);
    define("DEBUG_DECISION", 4);
    define("DEBUG_PAGE_LEVEL", 2);
    define("DEBUG_ERROR", 1);
    define("DEBUG", 15);
}
/**
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
//Example:
//$this->addDebug(DEBUG_FUNCTION_TRACE, "Custom Error Message");
//echo Html4PhpDebuggenerateHtml();

/**
 * Debug class uses the singleton pattern. It provides the capability of a debug trace through the static member variable. Unlike most singleton paterns, the getInstance() funciton is hidden, and interface through use is implimented inside the add() and get() functions themselfs.
 * The object of the class is not tobe returned externally, but rather used like $this->addDebug(DEBUG_VERBOSE, "custom error message"); echo Html4PhpDebuggenerateHtml();
 * 
 * 
 *
 * @author microuser
 * @copyright microuser 2014, macro_user@outlook.com
 */
class Html4PhpDebug {

    /**
     * The array of with the debuglog is stored
     * @var array 
     */
    private $debugLog = array();

    public function __construct() {
        $this->getConfig('DEBUG',$this->getConfig('envifronment','debugLevel'));
    }

    /**
     * Appends text to the persisted global variable array named debugLog.  It also performs a backtrace such that the calling class and time are written to the log. For appropariate values of the bitmask, see the CONSTANTS such as:     DEBUG_ECHO,    DEBUG_ERROR_LOG,    DEBUG_VERBOSE,    DEBUG_FUNCTION_TRACE,    DEBUG_RETURN_VALUE,    DEBUG_DECISION.
     * Also, if the bitmask of DEBUG has DEBUG_ERROR_LOG bit set, then the debug will be written with error_log() to the file set in php.ini
     * @param int $bitmask
     * @param String $text
     */
    public function addDebug($bitmask = null, $text = '') {
        if ($bitmask === null) {
            $bitmask = DEBUG;
        }
        if ($bitmask & DEBUG) {
            $time = microtime(1);
            $messageToWrite = self::getCallingFunctionName() . ": \t " . $text;
            $this->debugLog[] = date("j/d/y\@H:i:s.", $time) . ($time * 1000) % 1000 . " \t " . $messageToWrite;
            if (DEBUG & DEBUG_ERROR_LOG) {
                error_log($messageToWrite);
            }
        }
    }

    /**
     * Perform a debug_backtrace() and infer the calling function and its class.
     * @param DebugBacktrace $completeTrace
     * @return String
     */
    private function getCallingFunctionName($completeTrace = false) {
        $trace = debug_backtrace();
        if ($completeTrace) {
            $str = '';
            foreach ($trace as $caller) {
                $str .= " -- {$caller['function']}";
                if (isset($caller['class']))
                    $str .= "() of {$caller['class']}";
            }
        }
        else {
            if (!isset($trace[2])) {
                $str = ''; //No function 
            } else {
                $caller = $trace[2];
                $str = "{$caller['function']}";
                if (isset($caller['class']))
                    $str .= "() of {$caller['class']}";
            }
        }
        return $str;
    }

    public function getDebugArray() {
        return $this->debugLog;
    }

    /**
     * Returns formatted HTML of the persisted global variable array of debugLog.
     * @return string
     */
    public function getDebugHtml() {
        self::addDebug(DEBUG_FUNCTION_TRACE);
        if (DEBUG & DEBUG_ECHO) {
            $out = "<div>";
            foreach ($this->debugLog as $line => $text) {
                $out .= "<pre>" . filter_var($line . "\t " . $text, FILTER_SANITIZE_SPECIAL_CHARS) . "</pre>";
            }
            $out .= "</div>";
        } else {
            $out = '';
        }
        return $out;
    }

}
