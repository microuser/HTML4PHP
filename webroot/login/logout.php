<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/LoginPage.php');
$page = new LoginPage("Logout");
echo $page->generatePage();