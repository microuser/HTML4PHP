<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ValidatorPage.php');

$page = new ValidatorPage("Php4Html Validator Tests");
$page->generateValidatorPage();

echo $page->generatePage();
