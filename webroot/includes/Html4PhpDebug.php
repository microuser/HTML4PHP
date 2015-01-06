<?php
/**
 * 
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
 */
//Example:
//$this->addDebug(DEBUG_FUNCTION_TRACE, "Custom Error Message");
//echo Html4PhpDebuggenerateHtml();

if (!defined("DEBUG")) {
    define("DEBUG_ECHO", 128);
    define("DEBUG_ERROR_LOG", 64);
    define("DEBUG_VERBOSE", 32);
    define("DEBUG_FUNCTION_TRACE", 16);
    define("DEBUG_RETURN_VALUE", 8);
    define("DEBUG_DECISION", 4);
    define("DEBUG_PAGE_LEVEL", 2);
    define("DEBUG_ERROR", 1);
    if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
/////////////////////////////////////////////////////////////////////////////////////////////        
//SET YOUR DESIRED DEVELOPMENT DEBUG BITMASK HERE. (Add the values of desired from below)  //
/////////////////////////////////////////////////////////////////////////////////////////////
        define("DEBUG", 255);
    } else {
        //255 is all debug to screen and log
        //127 is all debug to log
        //0   is no debug
/////////////////////////////////////////////////////////////////////////////////////////////
//SET YOUR DESIRED PRODUCTION DEBUG BITMASK HERE. (Add the values of desired from below)   //
/////////////////////////////////////////////////////////////////////////////////////////////
        define("DEBUG", 0);
    }
}

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

 
    
    /**
     * Appends text to the persisted global variable array named debugLog.  It also performs a backtrace such that the calling class and time are written to the log. For appropariate values of the bitmask, see the CONSTANTS such as:     DEBUG_ECHO,    DEBUG_ERROR_LOG,    DEBUG_VERBOSE,    DEBUG_FUNCTION_TRACE,    DEBUG_RETURN_VALUE,    DEBUG_DECISION.
     * Also, if the bitmask of DEBUG has DEBUG_ERROR_LOG bit set, then the debug will be written with error_log() to the file set in php.ini
     * @param int $bitmask
     * @param String $text
     */
    public function addDebug($bitmask = DEBUG, $text = '') {
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

    public function getDebugArray(){
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
            foreach (self::getInstance()->debugLog as $line => $text) {
                $out .= "<pre>" . filter_var($line . "\t " . $text, FILTER_SANITIZE_SPECIAL_CHARS) . "</pre>";
            }
            $out .= "</div>";
        } else {
            $out = '';
        }
        return $out;
    }

}
