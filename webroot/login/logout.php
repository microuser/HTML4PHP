<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/LoginPage.php');
$_REQUEST['Logout'] = 'Submit';
$page = new LoginPage("Logout");
echo $page->generatePage();