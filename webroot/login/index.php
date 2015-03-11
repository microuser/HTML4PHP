<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/LoginPage.php');
$page = new LoginPage("Login");
echo $page->generatePage();