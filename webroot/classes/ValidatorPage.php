<?php

include_once("ValidatorModel.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpForm.php');

/**
 * Description of ValidatorPage
 *
 * @author user
 */
class ValidatorPage extends ValidatorModel {

    public $runTimeIterations = 10;

    public function __construct($title) {
        parent::__construct($title);

        $this->processRequest();
    }

    private function processRequest() {
        if (isset($_REQUEST['i']) && $this->isMatch('numbersInteger', $_REQUEST['i'])) {
            $this->runTimeIterations = $_REQUEST['i'];
            $_SESSION['ValidatorPage']['i'] = $this->runTimeIterations;
        } elseif (isset($_SESSION['ValidatorPage']) && isset($_SESSION['ValidatorPage']['i'])) {
            $this->runTimeIterations = $_SESSION['ValidatorPage']['i'];
        }
    }

    private function generateFormIterationCount() {
        $form = new Html4PhpForm("iterationcount");
        $form->addFormInputNumber("Iterations", "i", $this->runTimeIterations);
        $form->addFormInputCustomRegexp("numbers", "number", '', '', null, null, 'Thats not a number',' custom', '^-?([0-9]{0,3}(,[0-9]{3})*(\\.[0-9]+)?|[0-9]+(\\.[0-9]+)?(e-?[0-9]+)?)$');
        $form->addFormSubmitButton();
        $this->add($form->generateForm("Set Iteration Count for Runtime"));
    }

    public function generateValidatorPage() {

        $this->generateFormIterationCount();

        $this->makeValidatorRulesTable();

        $this->makeRuleNumbers();
        $this->makeRuleAlpha();
        $this->makeRuleNumbersWithDecimalsAndCommasAllowNegative();
        $this->makeRuleNumbersWithDecimalsAndCommas();
        $this->makeRuleNumbersDecimalsAllowNegative();
        $this->makeRuleNumbersWithDecimals();
        $this->makeRuleNumbersIntegerAllowNegative();
        $this->makeRuleSpecialChar();
        $this->makeRulePasswordSpecialCharLength8OrMore();
        $this->makeRulePassword();
        $this->makeRulePassword8OrMore();
        $this->makeRuleNumbersInteger();
    }

    private function makeRuleNumbers() {
        $title = '<a name="numbers">numbers</a>';

        $rulesArray[] = $this->makeTestRow('numbers', 1, "123");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "12345");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "0");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "12");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "123456789");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "12345678.00");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "445,678");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "2,445,678");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "2,445,678");
        $rulesArray[] = $this->makeTestRow('numbers', 0, "12345,678.00");
        $rulesArray[] = $this->makeTestRow('numbers', 0, "12345,678.");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "12,345,678.1");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "12345678.3");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "1.2e6");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "-1.2e6");
        $rulesArray[] = $this->makeTestRow('numbers', 1, "-1.2e-6");



        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRuleAlpha() {
        $title = '<a name="alpha">alpha</a>';

        $rulesArray[] = $this->makeTestRow('alpha', 1, "123");
        $rulesArray[] = $this->makeTestRow('alpha', 1, "12345");
        $rulesArray[] = $this->makeTestRow('alpha', 0, "0");
        $rulesArray[] = $this->makeTestRow('alpha', 0, "12");
        $rulesArray[] = $this->makeTestRow('alpha', 1, "123456789");
        $rulesArray[] = $this->makeTestRow('alpha', 0, "12345678");



        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRuleNumbersWithDecimalsAndCommasAllowNegative() {
        $title = '<a name="numbersWithDecimalsAndCommasAllowNegative">numbersWithDecimalsAndCommasAllowNegative</a>';

        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 1, 100, 000);
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 1, -100, 000);
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 1, "100,000,000");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 1, "10,000,000");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 1, "1,000,000");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 0, "1,000,00");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 1, "-100,000");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 1, "100,000.0");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 1, "-100,000.0");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 0, "100,000des");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 0, "100,00");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommasAllowNegative', 0, "a1");

        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRuleNumbersWithDecimalsAndCommas() {
        $title = '<a name="numbersWithDecimalsAndCommas">numbersWithDecimalsAndCommas</a>';

        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 1, 100, 000);
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 0, -100, 000);
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 1, "100,000,000");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 1, "10,000,000");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 1, "1,000,000");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 0, "1,000,00");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 0, "-100,000");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 1, "100,000.0");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 0, "-100,000.0");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 0, "100,000des");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 0, "100,00");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimalsAndCommas', 0, "a1");

        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRuleNumbersDecimalsAllowNegative() {
        $title = '<a name="numbersDecimalsAllowNegative">numbersDecimalsAllowNegative</a>';

        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 1, 1);
        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 1, -1);
        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 1, "1");
        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 1, "-1");
        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 1, "1.0");
        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 1, "-1.0");
        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 0, " 1");
        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 0, "1 ");
        $rulesArray[] = $this->makeTestRow('numbersDecimalsAllowNegative', 0, "a1");

        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRuleNumbersWithDecimals() {
        $title = '<a name="numbersWithDecimals">numbersWithDecimals</a>';

        $rulesArray[] = $this->makeTestRow('numbersWithDecimals', 1, 1);
        $rulesArray[] = $this->makeTestRow('numbersWithDecimals', 0, -1);
        $rulesArray[] = $this->makeTestRow('numbersWithDecimals', 1, "1");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimals', 0, "-1");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimals', 1, "1.0");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimals', 0, "-1.0");
        $rulesArray[] = $this->makeTestRow('numbersWithDecimals', 0, " 1");

        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRuleNumbersIntegerAllowNegative() {
        $title = '<a name="numbersIntegerAllowNegative">numbersIntegerAllowNegative</a>';

        $rulesArray[] = $this->makeTestRow('numbersIntegerAllowNegative', 1, 1);
        $rulesArray[] = $this->makeTestRow('numbersIntegerAllowNegative', 1, -1);
        $rulesArray[] = $this->makeTestRow('numbersIntegerAllowNegative', 1, "1");
        $rulesArray[] = $this->makeTestRow('numbersIntegerAllowNegative', 1, "-1");
        $rulesArray[] = $this->makeTestRow('numbersIntegerAllowNegative', 0, "1.0");
        $rulesArray[] = $this->makeTestRow('numbersIntegerAllowNegative', 0, "-1.0");
        $rulesArray[] = $this->makeTestRow('numbersIntegerAllowNegative', 0, " 1");

        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeValidatorRulesTable() {
        $regexArray = array();
        $i = 0;
        foreach ($this->getValidatorData() as $name => $regex) {
            $i++;
            $regexArray[] = array($i, '<a href="#' . $name . '">' . $name . '</a>', $regex);
        }

        $this->addTable("Validator Regex Rules", array("#", "Rule", "Regex"), $regexArray);
    }

    private function makeRulePassword() {
        $title = '<a name="password">password</a>';

        $rulesArray[] = $this->makeTestRow('password', 0, 1);
        $rulesArray[] = $this->makeTestRow('password', 0, '1');
        $rulesArray[] = $this->makeTestRow('password', 0, 1.0);
        $rulesArray[] = $this->makeTestRow('password', 0, 1e-22);
        $rulesArray[] = $this->makeTestRow('password', 0, 'password');
        $rulesArray[] = $this->makeTestRow('password', 1, 'aA1');
        $rulesArray[] = $this->makeTestRow('password', 1, 'aaAA11');
        $rulesArray[] = $this->makeTestRow('password', 1, '#a#a#A#A#1#1');
        $rulesArray[] = $this->makeTestRow('password', 0, '###A#A#1#1');
        $rulesArray[] = $this->makeTestRow('password', 0, 1);
        $rulesArray[] = $this->makeTestRow('password', 1, '.A1a.');
        $rulesArray[] = $this->makeTestRow('password', 1, '.Aa1.');
        $rulesArray[] = $this->makeTestRow('password', 1, '.1aA.');
        $rulesArray[] = $this->makeTestRow('password', 1, '.1Aa.');
        $rulesArray[] = $this->makeTestRow('password', 1, '.aA1.');
        $rulesArray[] = $this->makeTestRow('password', 1, '.a1A');
        $rulesArray[] = $this->makeTestRow('password', 1, '#a#a#A#A#1#1');
        $rulesArray[] = $this->makeTestRow('password', 1, 'aaaaAAAAA11111');
        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRulePassword8OrMore() {
        $title = '<a name="passwordLength8OrMore">passwordLength8OrMore</a>';

        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 0, 1);
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 0, '1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 0, 1.0);
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 0, 1e-22);
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 0, 'password');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 0, 'aA1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, 'aaAA11.....');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, '#a#a#A#A#1#1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 0, '###A#A#1#1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 0, 1);
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, '.A1a....1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, '.Aa1....1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, '.1aA....1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, '.1Aa....1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, '.aA1....1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, '.a1A....1');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, 'aaaaAAAAA11111');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, '111111aaaaaaAAAAA');
        $rulesArray[] = $this->makeTestRow('passwordLength8OrMore', 1, 'aA99999999999999999999');
        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRulePasswordSpecialCharLength8OrMore() {
        $title = '<a name="passwordSpecialCharLength8OrMore">passwordSpecialCharLength8OrMore</a>';

        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aA1@@@@@@@@@@@@@@');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'A1a##############');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 0, 'aaaaaaa111111AAAAA');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 0, 'AAAAAAA111111aaaaa');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1`');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1~');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1!');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1@');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1#');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1$');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1%');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1^');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1&');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1*');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1(');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1)');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1,');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1.');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1/');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1?');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1:');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1;');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1{');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1}');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1[');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1]');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1|');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1\\');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1{=');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1{-');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 1, 'aaaaaaaaaaaaaA1{_');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 0, '0000000000000');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 0, 'aev4esv54e323g4ED');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 0, 'aaadd44');

        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 0, '');
        $rulesArray[] = $this->makeTestRow('passwordSpecialCharLength8OrMore', 0, '');
        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function enumerateArrays($arrays) {
        $i = 0;
        $outcome = array();
        foreach ($arrays as $array) {
            $i++;
            array_unshift($array, $i);
            $outcome[] = $array;
        }
        return $outcome;
    }

    private function makeRuleSpecialChar() {
        $title = '<a name="specialChar">specialChar</a>';

        $rulesArray[] = $this->makeTestRow('specialChar', 1, '`');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '~');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '!');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '@');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '#');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '$');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '%');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '^');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '&');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '*');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '(');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, ')');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '-');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '_');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '=');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '+');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '[');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '{');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, ']');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '}');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '\\');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '|');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, ';');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, ':');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '\'');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '"');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, ',');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '.');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '<');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '>');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '/');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '?');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, ' ');
        $rulesArray[] = $this->makeTestRow('specialChar', 1, '`~!@#$%^&*()_+-=[]\\{}|\':;",./<>?');
        $rulesArray[] = $this->makeTestRow('specialChar', 0, '`~!@#$%^&*()_+-=[]\\{}|\':;",./<>?abcdef');

        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeRuleNumbersInteger() {
        $title = '<a name="numbersInteger">numbersInteger</a>';

        $rulesArray[] = $this->makeTestRow('numbersInteger', 1, 1);

        $rulesArray[] = $this->makeTestRow('numbersInteger', 1, 1111);
        $rulesArray[] = $this->makeTestRow('numbersInteger', 1, '1111');
        $rulesArray[] = $this->makeTestRow('numbersInteger', 0, '-1111');
        $rulesArray[] = $this->makeTestRow('numbersInteger', 1, '1');
        $rulesArray[] = $this->makeTestRow('numbersInteger', 1, 1.0);
        $rulesArray[] = $this->makeTestRow('numbersInteger', 0, 1e-22);
        $rulesArray[] = $this->makeTestRow('numbersInteger', 0, '1.1');
        $rulesArray[] = $this->makeTestRow('numbersInteger', 0, '1.');
        $rulesArray[] = $this->makeTestRow('numbersInteger', 0, '.1');
        $this->addTable($title, array("#", "Assessment", "Desired", "Result", "Subject", "Preg Matchs", "Run Time [ms]"), $this->enumerateArrays($rulesArray));
    }

    private function makeTestRow($type, $desired, $subject) {

        $matchArray = array();
        $startTime = microtime(true);
        for ($i = 0; $i < $this->runTimeIterations; $i++) {
            $this->isMatch($type, $subject);
        }
        $runTime = microtime(true) - $startTime;
        $result = (int) $this->isMatchWithRefArray($type, $subject, $matchArray);
        return array($this->makeRedGreen($result == $desired), $desired, $result, htmlentities($subject), '<pre style="margin:0px; font-size:8px;">' . str_replace("\n)", "", str_replace("Array\n(", "", htmlentities(print_r($matchArray, 1)))) . '</pre>', ((int) ($runTime * 1000000)) / 1000.0);
    }

    private function makeRedGreen($boolean) {
        if ($boolean) {
            return '<span style="display:block;width:100%;background-color:#55cc55; color:black; padding-left:20px;">Pass</span>';
        }
        return '<span style="display:block;width:100%;background-color:#cc5555; color:black; padding-left:20px;">Fail</span>';
    }

}
