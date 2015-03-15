<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/LoginPage.php');
$_REQUEST['Logout'] = 'Submit';
$page = new Html4PhpUser("Logout");
header("location:".$page->getConfig('server','relativeUrl')."index.php");
//$page->addLoginForm();
//echo $page;