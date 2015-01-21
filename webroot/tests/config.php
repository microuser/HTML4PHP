<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ConfigPage.php');

$page = new configPage("Html4Php Config Test");
echo $page->generatePage();
