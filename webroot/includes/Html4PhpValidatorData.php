<?php

$this->validatorData = array(
    'password' => array(
        'regex' => '^'
        . '(.*[a-z]+.*[A-Z]+.*[0-9]+.*)+|'
        . '(.*[a-z]+.*[0-9]+.*[A-Z]+.*)+|'
        . '(.*[0-9]+.*[a-z]+.*[A-Z]+.*)+|'
        . '(.*[0-9]+.*[A-Z]+.*[a-z]+.*)+|'
        . '(.*[A-Z]+.*[a-z]+.*[0-9]+.*)+|'
        . '(.*[A-Z]+.*[0-9]+.*[a-z]+.*)+$'),
    'numbersInteger' => array(
        'regex' => '^[0-9]+$'),
    'numbersIntegerAllowNegative' => array(
        'regex' => '^-?[0-9]+$'),
    'numbersWithDecimals' => array(
        'regex' => '^([0-9]*\.?[0-9]+)|([0-9]+\.?[0-9]*)$'),
    'numbersDecimalsAllowNegative' => array(
        'regex' => ''),
    'numbersWithDecimalsAndCommas' => array(
        'regex' => ' '),
    'numbersWithDecimalsAndCommasAllowNegative' => array(
        'regex' => ''),
    'numbersScientific' => array(
        'regex' => ''),
    'numbersDecimalsAllowNegative' => array(
        'regex' => ''),
    '' => array(
        'regex' => ''),
    '' => array(
        'regex' => ''),
    '' => array(
        'regex' => ''),
    '' => array(
        'regex' => ''),
    '' => array(
        'regex' => ''),
    '' => array(
        'regex' => ''),
    '' => array(
        'regex' => ''),
);
