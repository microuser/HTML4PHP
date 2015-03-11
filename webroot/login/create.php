<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/LoginPage.php');
$page = new LoginPage("Create");
echo $page->generatePage();