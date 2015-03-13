<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/classes/TestDatabasePage.php');
$page = new TestDatabasePage("Html4Php Database Test");
$page->addTestDatabaseTable();
$page->addTestUserTable();
echo $page->generatePage();
