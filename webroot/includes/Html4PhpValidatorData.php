<?php

$validatorData = array(
    'password' => '^(.*[a-z]+.*)(.*[A-Z]+.*)(.*[0-9]+.*)$',
    'passwordLength8OrMore' => '(?=.*[a-z]+.*)(?=.*[A-Z]+.*)(?=.*[0-9]+.*)(?=.{8,})',
    'passwordSpecialCharLength8OrMore' => '(?=.*[\\\\| `~!@#$%^&*(),.\/?:;{}\[\]].*)(?=.*[a-z]+.*)(?=.*[A-Z]+.*)(?=.*[0-9]+.*)(?=.{8,})',
    'numbersInteger' => '^[0-9]+$',
    'numbersIntegerAllowNegative' => '^-?[0-9]+$',
    'numbersWithDecimals' => '^([0-9]*\.?[0-9]+)|([0-9]+\.?[0-9]*)$',
    'numbersDecimalsAllowNegative' => '',
    'numbersWithDecimalsAndCommas' => '',
    'numbersWithDecimalsAndCommasAllowNegative' => '',
    'numbersScientific' => '',
    'numbersDecimalsAllowNegative' => '',
    '' => '',
);
