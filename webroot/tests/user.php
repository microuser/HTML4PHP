<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/TestUserPage.php');
$page = new TestUserPage("Php4User Tests");
$page->addUserInfo();
echo $page;
